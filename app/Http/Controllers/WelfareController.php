<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WelfareExport;

class WelfareController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getWelfareBaseData($request, false);

        return view('welfare', [
            'actionUrl'       => route('welfare.index'),
            'baseQueryParams' => $data['baseQueryParams'],

            'province'        => $data['province'],
            'provinceList'    => $data['provinceList'],
            'district'        => $data['district'],
            'subdistrict'     => $data['subdistrict'],
            'districtList'    => $data['districtList'],
            'subdistrictList' => $data['subdistrictList'],

            'welfare'         => $data['welfare'],
            'welfare_type'    => $data['welfare_type'],
            'welfare_match'   => $data['welfare_match'],

            'house_id'        => $data['house_id'],
            'fname'           => $data['fname'],
            'lname'           => $data['lname'],
            'cid'             => $data['cid'],
            'survey_year'     => $data['survey_year'],
            'agey'            => $data['agey'],
            'age_range'       => $data['age_range'],
            'sex'             => $data['sex'],

            'counts'          => $data['counts'],
            'rows'            => $data['rows'],
        ]);
    }

    public function export(Request $request)
{
    @ini_set('max_execution_time', 300);
    @ini_set('memory_limit', '1024M');
    @set_time_limit(300);

    $data = $this->getWelfareBaseData($request, true);

    $filename = 'welfare_export_' . now()->format('Ymd_His') . '.xlsx';

    return Excel::download(new WelfareExport($data['exportQuery']), $filename);
}

    private function getWelfareBaseData(Request $request, bool $forExport = false): array
    {
        $conn         = DB::connection('sqlsrv');
        $mainTable    = '[dbo].[survey_a]';
        $profileTable = '[dbo].[survey_profile64]';

        // ======================
        // อ่านคอลัมน์จริง
        // ======================
        $colsMain = collect($conn->select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA='dbo' AND TABLE_NAME='survey_a'
        "))
        ->pluck('COLUMN_NAME')
        ->map(fn($c) => strtolower((string)$c))
        ->values()
        ->all();

        $colsProfile = collect($conn->select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA='dbo' AND TABLE_NAME='survey_profile64'
        "))
        ->pluck('COLUMN_NAME')
        ->map(fn($c) => strtolower((string)$c))
        ->values()
        ->all();

        $hasMainCol = fn(string $c) => in_array(strtolower($c), $colsMain, true);
        $hasProfCol = fn(string $c) => in_array(strtolower($c), $colsProfile, true);

        $pickMainCol = function(array $candidates, ?string $fallback = null) use ($hasMainCol) {
            foreach ($candidates as $c) {
                if ($hasMainCol($c)) return $c;
            }
            return $fallback;
        };

        $pickProfCol = function(array $candidates, ?string $fallback = null) use ($hasProfCol) {
            foreach ($candidates as $c) {
                if ($hasProfCol($c)) return $c;
            }
            return $fallback;
        };

        $colRef = function(?string $alias, ?string $col) {
            return ($alias && $col) ? "{$alias}.[{$col}]" : null;
        };

        $trim = fn($expr) => "LTRIM(RTRIM($expr))";

        // ======================
        // mapping survey_a
        // ======================
        $COL_HOUSE    = $pickMainCol(['HC'], 'HC');
        $COL_ORDER    = $pickMainCol(['a1'], null);
        $COL_FNAME    = $pickMainCol(['a2_2'], null);
        $COL_LNAME    = $pickMainCol(['a2_3'], null);
        $COL_CID      = $pickMainCol(['popid'], null);
        $COL_AGE      = $pickMainCol(['a3_1'], null);
        $COL_SEX      = $pickMainCol(['a4'], null);
        $COL_YEAR     = $pickMainCol(['survey_year', 'year'], null);

        $COL_PROVINCE = $pickMainCol(['province_name_thai'], null);
        $COL_DISTRICT = $pickMainCol(['district_name_thai'], null);
        $COL_TAMBON   = $pickMainCol(['tambon_name_thai'], null);

        $COL_HOUSE_NO     = $pickMainCol(['MBNO', 'house_number'], null);
        $COL_VILLAGE_NO   = $pickMainCol(['MB', 'village_no'], null);
        $COL_VILLAGE_NAME = $pickMainCol(['MM', 'village_name'], null);
        $COL_POSTCODE     = $pickMainCol(['postcode', 'POSTCODE'], null);

        // ======================
        // mapping survey_profile64
        // ======================
        $P_COL_HOUSE    = $pickProfCol(['HC1'], 'HC1');
        $P_COL_TEL      = $pickProfCol(['TEL'], null);
        $P_COL_LATX     = $pickProfCol(['latx'], null);
        $P_COL_LNGY     = $pickProfCol(['lngy'], null);
        $P_COL_YEAR     = $pickProfCol(['survey_year', 'year'], null);

        $P_COL_HOUSE_NO     = $pickProfCol(['MBNO', 'house_number'], null);
        $P_COL_VILLAGE_NO   = $pickProfCol(['MB', 'village_no'], null);
        $P_COL_VILLAGE_NAME = $pickProfCol(['MM', 'village_name'], null);
        $P_COL_POSTCODE     = $pickProfCol(['postcode', 'POSTCODE'], null);

        $provinceRef = $colRef('u', $COL_PROVINCE);
        $districtRef = $colRef('u', $COL_DISTRICT);
        $tambonRef   = $colRef('u', $COL_TAMBON);

        // ======================
        // filters
        // ======================
        $province    = trim((string) $request->get('province', ''));
        $district    = trim((string) $request->get('district', ''));
        $subdistrict = trim((string) $request->get('subdistrict', ''));

        $welfare      = (string) $request->get('welfare', '');
        $welfare_type = (array) $request->input('welfare_type', []);
        if (!in_array($welfare, ['', 'received', 'not_received'], true)) $welfare = '';

        $welfare_match = (string) $request->get('welfare_match', 'any');
        if (!in_array($welfare_match, ['any','all'], true)) $welfare_match = 'any';

        $house_id    = trim((string) $request->get('house_id', ''));
        $fname       = trim((string) $request->get('fname', ''));
        $lname       = trim((string) $request->get('lname', ''));
        $cid         = trim((string) $request->get('cid', ''));
        $survey_year = trim((string) $request->get('survey_year', ''));
        $agey        = trim((string) $request->get('agey', ''));
        $age_range   = trim((string) $request->get('age_range', ''));
        $sex         = trim((string) $request->get('sex', ''));

        if ($welfare !== 'received') $welfare_type = [];

        $parseAgeRange = function(string $ageRange): array {
            $ageRange = trim($ageRange);
            if ($ageRange === '') return [null, null];
            if (preg_match('/^(\d+)\-(\d+)$/', $ageRange, $m)) return [(int)$m[1], (int)$m[2]];
            if (preg_match('/^(\d+)\+$/', $ageRange, $m)) return [(int)$m[1], null];
            return [null, null];
        };

        // ======================
        // welfare cols
        // ======================
        $allowedCols = ['a7_1','a7_2','a7_3','a7_4','a7_5','a7_6'];
        $picked      = array_values(array_intersect($welfare_type, $allowedCols));

        $a70Ref   = $colRef('u', 'a7_0');
        $a70ExprT = $a70Ref ? $trim($a70Ref) : "NULL";

        $hasNumericValueCondition = function(array $cols, string $mode) use ($trim, $hasMainCol) {
            $conds = [];
            foreach ($cols as $c) {
                if (!$hasMainCol($c)) continue;
                $expr = $trim("u.[$c]");
                $conds[] = "(NULLIF($expr, N'') IS NOT NULL AND $expr <> N'0')";
            }
            if (empty($conds)) return null;
            return '(' . implode($mode === 'all' ? ' AND ' : ' OR ', $conds) . ')';
        };

        // ======================
        // base query
        // ======================
        $baseQuery = function() use (
            $conn, $mainTable, $profileTable,
            $COL_HOUSE, $P_COL_HOUSE, $COL_YEAR, $P_COL_YEAR
        ) {
            $q = $conn->table(DB::raw("$mainTable as u"));

            if ($COL_HOUSE && $P_COL_HOUSE) {
                $q->leftJoin(DB::raw("$profileTable as p"), function($join) use ($COL_HOUSE, $P_COL_HOUSE, $COL_YEAR, $P_COL_YEAR) {
                    $join->on("u.$COL_HOUSE", '=', "p.$P_COL_HOUSE");

                    if ($COL_YEAR && $P_COL_YEAR) {
                        $join->on("u.$COL_YEAR", '=', "p.$P_COL_YEAR");
                    }
                });
            }

            return $q;
        };

        $baseQueryParams = array_filter([
            'welfare'       => $welfare,
            'welfare_match' => $welfare_match,
            'welfare_type'  => $welfare_type,
            'house_id'      => $house_id,
            'fname'         => $fname,
            'lname'         => $lname,
            'cid'           => $cid,
            'survey_year'   => $survey_year,
            'age_range'     => $age_range,
            'sex'           => $sex,
        ], fn($v) => $v !== '' && $v !== [] && $v !== null);

        // ======================
        // dropdowns เฉพาะหน้าแสดงผล
        // ======================
        $provinceList = collect();
        $districtList = collect();
        $subdistrictList = collect();

        if (!$forExport) {
            $provinceList = Cache::remember('welfare_province_survey_a', 3600, function () use ($baseQuery, $provinceRef, $trim) {
                if (!$provinceRef) return collect();

                return $baseQuery()
                    ->selectRaw($trim($provinceRef)." as province")
                    ->whereRaw("$provinceRef IS NOT NULL")
                    ->whereRaw($trim($provinceRef)." <> N''")
                    ->distinct()
                    ->orderBy('province')
                    ->pluck('province');
            });

            $districtList = Cache::remember('welfare_district_survey_a_'.md5($province), 3600, function () use ($baseQuery, $province, $provinceRef, $districtRef, $trim) {
                if (!$districtRef) return collect();

                $q = $baseQuery()
                    ->selectRaw($trim($districtRef)." as district")
                    ->whereRaw("$districtRef IS NOT NULL")
                    ->whereRaw($trim($districtRef)." <> N''");

                if ($province !== '' && $provinceRef) {
                    $q->whereRaw($trim($provinceRef)." = ?", [$province]);
                }

                return $q->distinct()->orderBy('district')->pluck('district');
            });

            $subdistrictList = Cache::remember('welfare_tambon_survey_a_'.md5($province.'|'.$district), 3600, function () use (
                $baseQuery, $province, $district, $provinceRef, $districtRef, $tambonRef, $trim
            ) {
                if (!$tambonRef) return collect();

                $q = $baseQuery()
                    ->selectRaw($trim($tambonRef)." as tambon")
                    ->whereRaw("$tambonRef IS NOT NULL")
                    ->whereRaw($trim($tambonRef)." <> N''");

                if ($province !== '' && $provinceRef) {
                    $q->whereRaw($trim($provinceRef)." = ?", [$province]);
                }
                if ($district !== '' && $districtRef) {
                    $q->whereRaw($trim($districtRef)." = ?", [$district]);
                }

                return $q->distinct()->orderBy('tambon')->pluck('tambon');
            });
        }

        // ======================
        // main query
        // ======================
        $q = $baseQuery();

        $this->applyWelfareFilters(
            $q,
            $province, $district, $subdistrict,
            $survey_year, $house_id, $fname, $lname, $cid,
            $agey, $age_range, $sex,
            $picked, $welfare, $welfare_match,
            $parseAgeRange, $trim, $hasNumericValueCondition,
            $COL_HOUSE, $COL_FNAME, $COL_LNAME, $COL_CID, $COL_YEAR, $COL_AGE, $COL_SEX,
            $a70ExprT, $provinceRef, $districtRef, $tambonRef, $colRef
        );

        $selects = [];

        if ($COL_HOUSE)    $selects[] = "u.[{$COL_HOUSE}] as HC";
        if ($COL_ORDER)    $selects[] = "u.[{$COL_ORDER}] as a1";
        if ($COL_FNAME)    $selects[] = "u.[{$COL_FNAME}] as a2_2";
        if ($COL_LNAME)    $selects[] = "u.[{$COL_LNAME}] as a2_3";
        if ($COL_CID)      $selects[] = "u.[{$COL_CID}] as popid";
        if ($COL_PROVINCE) $selects[] = "u.[{$COL_PROVINCE}] as province_name_thai";
        if ($COL_DISTRICT) $selects[] = "u.[{$COL_DISTRICT}] as district_name_thai";
        if ($COL_TAMBON)   $selects[] = "u.[{$COL_TAMBON}] as tambon_name_thai";
        if ($COL_YEAR)     $selects[] = "u.[{$COL_YEAR}] as survey_year";
        if ($COL_AGE)      $selects[] = "u.[{$COL_AGE}] as a3_1";
        if ($COL_SEX)      $selects[] = "u.[{$COL_SEX}] as a4";

        if ($COL_HOUSE_NO) {
            $selects[] = "u.[{$COL_HOUSE_NO}] as house_number";
        } elseif ($P_COL_HOUSE_NO) {
            $selects[] = "p.[{$P_COL_HOUSE_NO}] as house_number";
        }

        if ($COL_VILLAGE_NO) {
            $selects[] = "u.[{$COL_VILLAGE_NO}] as village_no";
        } elseif ($P_COL_VILLAGE_NO) {
            $selects[] = "p.[{$P_COL_VILLAGE_NO}] as village_no";
        }

        if ($COL_VILLAGE_NAME) {
            $selects[] = "u.[{$COL_VILLAGE_NAME}] as village_name";
        } elseif ($P_COL_VILLAGE_NAME) {
            $selects[] = "p.[{$P_COL_VILLAGE_NAME}] as village_name";
        }

        if ($COL_POSTCODE) {
            $selects[] = "u.[{$COL_POSTCODE}] as postcode";
        } elseif ($P_COL_POSTCODE) {
            $selects[] = "p.[{$P_COL_POSTCODE}] as postcode";
        }

        if ($P_COL_TEL)  $selects[] = "p.[{$P_COL_TEL}] as TEL";
        if ($P_COL_LATX) $selects[] = "p.[{$P_COL_LATX}] as latx";
        if ($P_COL_LNGY) $selects[] = "p.[{$P_COL_LNGY}] as lngy";

        foreach (['a7_0','a7_1','a7_2','a7_3','a7_4','a7_5','a7_6'] as $wcol) {
            if ($hasMainCol($wcol)) {
                $selects[] = "u.[$wcol] as $wcol";
            }
        }

        $q->selectRaw(implode(",\n", $selects));

        if ($COL_YEAR)     $q->orderBy("u.$COL_YEAR");
        if ($COL_PROVINCE) $q->orderBy("u.$COL_PROVINCE");
        if ($COL_DISTRICT) $q->orderBy("u.$COL_DISTRICT");
        if ($COL_TAMBON)   $q->orderBy("u.$COL_TAMBON");
        if ($COL_HOUSE)    $q->orderBy("u.$COL_HOUSE");

        $exportQuery = clone $q;

        $rows = $forExport
            ? collect()
            : $q->paginate(15)->appends($request->query());

        // ======================
        // counts เฉพาะหน้าแสดงผล
        // ======================
        $counts = ['received' => 0, 'not_received' => 0];

        if (!$forExport) {
            $countKey = 'welfare_counts_survey_a_'.md5(json_encode([
                $province,$district,$subdistrict,$survey_year,
                $house_id,$fname,$lname,$cid,$agey,$age_range,$sex,
                $picked,$welfare_match
            ], JSON_UNESCAPED_UNICODE));

            $counts = Cache::remember($countKey, 300, function () use (
                $baseQuery,
                $province,$district,$subdistrict,$survey_year,
                $house_id,$fname,$lname,$cid,$agey,$age_range,$sex,
                $picked,$welfare_match,
                $parseAgeRange,$trim,$hasNumericValueCondition,
                $COL_HOUSE,$COL_FNAME,$COL_LNAME,$COL_CID,$COL_YEAR,$COL_AGE,$COL_SEX,
                $a70ExprT,$provinceRef,$districtRef,$tambonRef,$colRef
            ) {
                $base = $baseQuery();

                $this->applyWelfareFilters(
                    $base,
                    $province, $district, $subdistrict,
                    $survey_year, $house_id, $fname, $lname, $cid,
                    $agey, $age_range, $sex,
                    [], '', 'any',
                    $parseAgeRange, $trim, $hasNumericValueCondition,
                    $COL_HOUSE, $COL_FNAME, $COL_LNAME, $COL_CID, $COL_YEAR, $COL_AGE, $COL_SEX,
                    $a70ExprT, $provinceRef, $districtRef, $tambonRef, $colRef
                );

                $receivedBase = (clone $base)->where(function($qq) use ($a70ExprT) {
                    $qq->whereRaw("$a70ExprT IS NULL")
                       ->orWhereRaw("$a70ExprT = N''");
                });

                if (!empty($picked)) {
                    $cond = $hasNumericValueCondition($picked, $welfare_match);
                    if ($cond) $receivedBase->whereRaw($cond);
                }

                $notReceivedBase = (clone $base)->whereRaw("$a70ExprT = N'0'");

                return [
                    'received'     => $receivedBase->count(),
                    'not_received' => $notReceivedBase->count(),
                ];
            });
        }

        return [
            'baseQueryParams' => $baseQueryParams,

            'province'        => $province,
            'provinceList'    => $provinceList,
            'district'        => $district,
            'subdistrict'     => $subdistrict,
            'districtList'    => $districtList,
            'subdistrictList' => $subdistrictList,

            'welfare'         => $welfare,
            'welfare_type'    => $welfare_type,
            'welfare_match'   => $welfare_match,

            'house_id'        => $house_id,
            'fname'           => $fname,
            'lname'           => $lname,
            'cid'             => $cid,
            'survey_year'     => $survey_year,
            'agey'            => $agey,
            'age_range'       => $age_range,
            'sex'             => $sex,

            'counts'          => $counts,
            'rows'            => $rows,
            'exportQuery'     => $exportQuery,
        ];
    }

    private function applyWelfareFilters(
        $q,
        $province, $district, $subdistrict,
        $survey_year, $house_id, $fname, $lname, $cid,
        $agey, $age_range, $sex,
        $picked, $welfare, $welfare_match,
        $parseAgeRange, $trim, $hasNumericValueCondition,
        $COL_HOUSE, $COL_FNAME, $COL_LNAME, $COL_CID, $COL_YEAR, $COL_AGE, $COL_SEX,
        $a70ExprT, $provinceRef, $districtRef, $tambonRef, $colRef
    ) {
        if ($province !== '' && $provinceRef) {
            $q->whereRaw($trim($provinceRef)." = ?", [$province]);
        }
        if ($district !== '' && $districtRef) {
            $q->whereRaw($trim($districtRef)." = ?", [$district]);
        }
        if ($subdistrict !== '' && $tambonRef) {
            $q->whereRaw($trim($tambonRef)." = ?", [$subdistrict]);
        }

        if ($survey_year !== '' && ctype_digit($survey_year) && $COL_YEAR) {
            $q->whereRaw($colRef('u', $COL_YEAR)." = ?", [(int)$survey_year]);
        }

        [$ageMin, $ageMax] = $parseAgeRange($age_range);
        if ($COL_AGE) {
            $ageExpr = $trim($colRef('u', $COL_AGE));
            if ($ageMin !== null && $ageMax !== null) {
                $q->whereRaw("TRY_CONVERT(int, $ageExpr) BETWEEN ? AND ?", [$ageMin, $ageMax]);
            } elseif ($ageMin !== null && $ageMax === null) {
                $q->whereRaw("TRY_CONVERT(int, $ageExpr) >= ?", [$ageMin]);
            } elseif ($agey !== '') {
                ctype_digit($agey)
                    ? $q->whereRaw("$ageExpr = ?", [$agey])
                    : $q->whereRaw("$ageExpr LIKE ?", ["%{$agey}%"]);
            }
        }

        if ($sex !== '' && $COL_SEX) {
            $q->whereRaw($trim($colRef('u', $COL_SEX))." = ?", [$sex]);
        }

        if ($house_id !== '' && $COL_HOUSE) {
            $q->whereRaw($colRef('u', $COL_HOUSE)." LIKE ?", ["%{$house_id}%"]);
        }
        if ($fname !== '' && $COL_FNAME) {
            $q->whereRaw($colRef('u', $COL_FNAME)." LIKE ?", ["%{$fname}%"]);
        }
        if ($lname !== '' && $COL_LNAME) {
            $q->whereRaw($colRef('u', $COL_LNAME)." LIKE ?", ["%{$lname}%"]);
        }
        if ($cid !== '' && $COL_CID) {
            $q->whereRaw($colRef('u', $COL_CID)." LIKE ?", ["%{$cid}%"]);
        }

        if ($welfare === 'received') {
            $q->where(function($qq) use ($a70ExprT) {
                $qq->whereRaw("$a70ExprT IS NULL")
                   ->orWhereRaw("$a70ExprT = N''");
            });

            if (!empty($picked)) {
                $cond = $hasNumericValueCondition($picked, $welfare_match);
                if ($cond) $q->whereRaw($cond);
            }
        } elseif ($welfare === 'not_received') {
            $q->whereRaw("$a70ExprT = N'0'");
        }

        return $q;
    }
}