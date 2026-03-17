<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

// Excel
use App\Exports\HealthExport;
use Maatwebsite\Excel\Facades\Excel;

class HealthController extends Controller
{
    public function index(Request $request)
    {
        $actionUrl = route('health.index');

        // ======================
        // ใช้แค่ 2 ตาราง
        // ======================
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
        $COL_TITLE    = $pickMainCol(['a2_1'], null);
        $COL_FNAME    = $pickMainCol(['a2_2'], null);
        $COL_LNAME    = $pickMainCol(['a2_3'], null);
        $COL_CID      = $pickMainCol(['popid'], null);
        $COL_AGE      = $pickMainCol(['a3_1'], null);
        $COL_SEX      = $pickMainCol(['a4'], null);
        $COL_HEALTH   = $pickMainCol(['a5', 'health'], null);
        $COL_YEAR     = $pickMainCol(['survey_year', 'year'], null);

        $COL_PROVINCE = $pickMainCol(['province_name_thai'], null);
        $COL_DISTRICT = $pickMainCol(['district_name_thai'], null);
        $COL_TAMBON   = $pickMainCol(['tambon_name_thai'], null);

        $COL_HOUSE_NO     = $pickMainCol(['MBNO', 'house_number'], null);
        $COL_VILLAGE_NO   = $pickMainCol(['MB', 'village_no'], null);
        $COL_VILLAGE_NAME = $pickMainCol(['MM', 'village_name'], null);
        $COL_POSTCODE     = $pickMainCol(['postcode'], null);

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
        $P_COL_POSTCODE     = $pickProfCol(['postcode'], null);

        $provinceRef = $colRef('u', $COL_PROVINCE);
        $districtRef = $colRef('u', $COL_DISTRICT);
        $tambonRef   = $colRef('u', $COL_TAMBON);

        // ======================
        // options
        // ======================
        $HEALTH_OPTIONS = [
            'ปกติ',
            'ป่วยเรื้อรังที่ไม่ติดเตียง (เช่น หัวใจ เบาหวาน)',
            'พิการพึ่งตนเองได้',
            'ผู้ป่วยติดเตียง/พิการพึ่งตัวเองไม่ได้',
        ];
        $HEALTH_NULL_TOKEN = '__NULL__';

        $healthMap = [
            1 => 'ปกติ',
            2 => 'ป่วยเรื้อรังที่ไม่ติดเตียง (เช่น หัวใจ เบาหวาน)',
            3 => 'พิการพึ่งตนเองได้',
            4 => 'ผู้ป่วยติดเตียง/พิการพึ่งตัวเองไม่ได้',
        ];

        $healthTextToCode = array_flip($healthMap);

        $sexMap = [
            1 => 'ชาย',
            2 => 'หญิง',
        ];

        $sexTextToCode = array_flip($sexMap);

        // ======================
        // filters
        // ======================
        $district    = trim((string) $request->get('district', ''));
        $subdistrict = trim((string) $request->get('subdistrict', ''));
        $health      = trim((string) $request->get('health', ''));

        $house_id    = trim((string) $request->get('house_id', ''));
        $fname       = trim((string) $request->get('fname', ''));
        $lname       = trim((string) $request->get('lname', ''));
        $cid         = trim((string) $request->get('cid', ''));
        $survey_year = trim((string) $request->get('survey_year', ''));
        $agey        = trim((string) $request->get('agey', ''));
        $age_range   = trim((string) $request->get('age_range', ''));
        $sex         = trim((string) $request->get('sex', ''));

        if (!in_array($health, array_merge(['', $HEALTH_NULL_TOKEN], $HEALTH_OPTIONS), true)) {
            $health = '';
        }

        $parseAgeRange = function(string $ageRange): array {
            $ageRange = trim($ageRange);
            if ($ageRange === '') return [null, null];
            if (preg_match('/^(\d+)\-(\d+)$/', $ageRange, $m)) return [(int)$m[1], (int)$m[2]];
            if (preg_match('/^(\d+)\+$/', $ageRange, $m)) return [(int)$m[1], null];
            return [null, null];
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

        // ======================
        // dropdowns
        // ======================
        $districtList = Cache::remember('health_district_survey_a', 3600, function () use ($baseQuery, $districtRef, $trim) {
            if (!$districtRef) return collect();

            return $baseQuery()
                ->selectRaw($trim($districtRef)." as district")
                ->whereRaw("$districtRef IS NOT NULL")
                ->whereRaw($trim($districtRef)." <> N''")
                ->distinct()
                ->orderBy('district')
                ->pluck('district');
        });

        $subdistrictList = Cache::remember('health_tambon_survey_a_'.md5($district), 3600, function () use (
            $baseQuery, $district, $districtRef, $tambonRef, $trim
        ) {
            if (!$tambonRef) return collect();

            $q = $baseQuery()
                ->selectRaw($trim($tambonRef)." as tambon")
                ->whereRaw("$tambonRef IS NOT NULL")
                ->whereRaw($trim($tambonRef)." <> N''");

            if ($district !== '' && $districtRef) {
                $q->whereRaw($trim($districtRef)." = ?", [$district]);
            }

            return $q->distinct()->orderBy('tambon')->pluck('tambon');
        });

        // ======================
        // main query
        // ======================
        $q = $baseQuery();

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
                    ? $q->whereRaw("TRY_CONVERT(int, $ageExpr) = ?", [(int)$agey])
                    : $q->whereRaw("$ageExpr LIKE ?", ["%{$agey}%"]);
            }
        }

        if ($sex !== '' && $COL_SEX) {
            $sexExpr = $trim($colRef('u', $COL_SEX));

            if (isset($sexTextToCode[$sex])) {
                $q->whereRaw("TRY_CONVERT(int, $sexExpr) = ?", [$sexTextToCode[$sex]]);
            } elseif (in_array($sex, ['1', '2'], true)) {
                $q->whereRaw("TRY_CONVERT(int, $sexExpr) = ?", [(int)$sex]);
            } else {
                $q->whereRaw("$sexExpr = ?", [$sex]);
            }
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

        if ($COL_HEALTH) {
            if ($health === $HEALTH_NULL_TOKEN) {
                $q->where(function($qq) use ($COL_HEALTH, $trim) {
                    $expr = $trim("u.[$COL_HEALTH]");
                    $qq->whereRaw("u.[$COL_HEALTH] IS NULL")
                       ->orWhereRaw("$expr = N''")
                       ->orWhereRaw("TRY_CONVERT(int, $expr) NOT IN (1,2,3,4)")
                       ->orWhereRaw("$expr = N'0'");
                });
            } elseif ($health !== '') {
                $code = $healthTextToCode[$health] ?? null;
                if ($code !== null) {
                    $q->whereRaw("TRY_CONVERT(int, ".$trim("u.[$COL_HEALTH]").") = ?", [$code]);
                }
            }
        }

        // ======================
        // select
        // ======================
        $healthCase = $COL_HEALTH
            ? "
                CASE TRY_CONVERT(int, ".$trim("u.[$COL_HEALTH]").")
                    WHEN 1 THEN N'ปกติ'
                    WHEN 2 THEN N'ป่วยเรื้อรังที่ไม่ติดเตียง (เช่น หัวใจ เบาหวาน)'
                    WHEN 3 THEN N'พิการพึ่งตนเองได้'
                    WHEN 4 THEN N'ผู้ป่วยติดเตียง/พิการพึ่งตัวเองไม่ได้'
                    ELSE N''
                END
            "
            : "N''";

        $sexCase = $COL_SEX
            ? "
                CASE TRY_CONVERT(int, ".$trim("u.[$COL_SEX]").")
                    WHEN 1 THEN N'ชาย'
                    WHEN 2 THEN N'หญิง'
                    ELSE N''
                END
            "
            : "N''";

        $selects = [];

        if ($COL_HOUSE)    $selects[] = "u.[{$COL_HOUSE}] as house_Id";
        if ($COL_ORDER)    $selects[] = "u.[{$COL_ORDER}] as human_Order";
        if ($COL_TITLE)    $selects[] = "u.[{$COL_TITLE}] as human_Member_title";
        if ($COL_FNAME)    $selects[] = "u.[{$COL_FNAME}] as human_Member_fname";
        if ($COL_LNAME)    $selects[] = "u.[{$COL_LNAME}] as human_Member_lname";
        if ($COL_CID)      $selects[] = "u.[{$COL_CID}] as human_Member_cid";
        if ($COL_AGE)      $selects[] = "u.[{$COL_AGE}] as human_Age_y";
        if ($COL_YEAR)     $selects[] = "u.[{$COL_YEAR}] as survey_Year";

        $selects[] = "$sexCase as human_Sex";
        $selects[] = "$healthCase as human_Health";

        if ($COL_DISTRICT) $selects[] = "u.[{$COL_DISTRICT}] as survey_District";
        if ($COL_TAMBON)   $selects[] = "u.[{$COL_TAMBON}] as survey_Subdistrict";

        if ($COL_HOUSE_NO) {
            $selects[] = "u.[{$COL_HOUSE_NO}] as house_Number";
        } elseif ($P_COL_HOUSE_NO) {
            $selects[] = "p.[{$P_COL_HOUSE_NO}] as house_Number";
        }

        if ($COL_VILLAGE_NO) {
            $selects[] = "u.[{$COL_VILLAGE_NO}] as village_No";
        } elseif ($P_COL_VILLAGE_NO) {
            $selects[] = "p.[{$P_COL_VILLAGE_NO}] as village_No";
        }

        if ($COL_VILLAGE_NAME) {
            $selects[] = "u.[{$COL_VILLAGE_NAME}] as village_Name";
        } elseif ($P_COL_VILLAGE_NAME) {
            $selects[] = "p.[{$P_COL_VILLAGE_NAME}] as village_Name";
        }

        if ($COL_POSTCODE) {
            $selects[] = "u.[{$COL_POSTCODE}] as survey_Postcode";
        } elseif ($P_COL_POSTCODE) {
            $selects[] = "p.[{$P_COL_POSTCODE}] as survey_Postcode";
        }

        if ($P_COL_TEL)  $selects[] = "p.[{$P_COL_TEL}] as survey_Informer_phone";
        if ($P_COL_LATX) $selects[] = "p.[{$P_COL_LATX}] as latitude";
        if ($P_COL_LNGY) $selects[] = "p.[{$P_COL_LNGY}] as longitude";

        $q->selectRaw(implode(",\n", $selects));

        if ($COL_YEAR)     $q->orderBy("u.$COL_YEAR");
        if ($COL_DISTRICT) $q->orderBy("u.$COL_DISTRICT");
        if ($COL_TAMBON)   $q->orderBy("u.$COL_TAMBON");
        if ($COL_HOUSE)    $q->orderBy("u.$COL_HOUSE");
        if ($COL_ORDER)    $q->orderByRaw("TRY_CONVERT(int, ".$trim("u.[$COL_ORDER]").")");

        $rows = $q->paginate(20)->appends($request->query());

        // ======================
        // counts
        // ======================
        $countKey = 'health_counts_survey_a_'.md5(json_encode([
            $district,$subdistrict,$survey_year,
            $house_id,$fname,$lname,$cid,$agey,$age_range,$sex
        ], JSON_UNESCAPED_UNICODE));

        $counts = Cache::remember($countKey, 300, function () use (
            $baseQuery,
            $district,$subdistrict,$survey_year,
            $house_id,$fname,$lname,$cid,$agey,$age_range,$sex,
            $parseAgeRange,$trim,
            $COL_HOUSE,$COL_FNAME,$COL_LNAME,$COL_CID,$COL_YEAR,$COL_AGE,$COL_SEX,$COL_HEALTH,
            $districtRef,$tambonRef,$colRef,
            $HEALTH_OPTIONS,$HEALTH_NULL_TOKEN
        ) {
            $base = $baseQuery();

            if ($district !== '' && $districtRef) {
                $base->whereRaw($trim($districtRef)." = ?", [$district]);
            }
            if ($subdistrict !== '' && $tambonRef) {
                $base->whereRaw($trim($tambonRef)." = ?", [$subdistrict]);
            }
            if ($survey_year !== '' && ctype_digit($survey_year) && $COL_YEAR) {
                $base->whereRaw($colRef('u', $COL_YEAR)." = ?", [(int)$survey_year]);
            }

            if ($house_id !== '' && $COL_HOUSE) {
                $base->whereRaw($colRef('u', $COL_HOUSE)." LIKE ?", ["%{$house_id}%"]);
            }
            if ($fname !== '' && $COL_FNAME) {
                $base->whereRaw($colRef('u', $COL_FNAME)." LIKE ?", ["%{$fname}%"]);
            }
            if ($lname !== '' && $COL_LNAME) {
                $base->whereRaw($colRef('u', $COL_LNAME)." LIKE ?", ["%{$lname}%"]);
            }
            if ($cid !== '' && $COL_CID) {
                $base->whereRaw($colRef('u', $COL_CID)." LIKE ?", ["%{$cid}%"]);
            }

            [$ageMin, $ageMax] = $parseAgeRange($age_range);
            if ($COL_AGE) {
                $ageExpr = $trim($colRef('u', $COL_AGE));
                if ($ageMin !== null && $ageMax !== null) {
                    $base->whereRaw("TRY_CONVERT(int, $ageExpr) BETWEEN ? AND ?", [$ageMin, $ageMax]);
                } elseif ($ageMin !== null && $ageMax === null) {
                    $base->whereRaw("TRY_CONVERT(int, $ageExpr) >= ?", [$ageMin]);
                } elseif ($agey !== '') {
                    ctype_digit($agey)
                        ? $base->whereRaw("TRY_CONVERT(int, $ageExpr) = ?", [(int)$agey])
                        : $base->whereRaw("$ageExpr LIKE ?", ["%{$agey}%"]);
                }
            }

            if ($sex !== '' && $COL_SEX) {
                $sexExpr = $trim($colRef('u', $COL_SEX));

                if ($sex === 'ชาย') {
                    $base->whereRaw("TRY_CONVERT(int, $sexExpr) = 1");
                } elseif ($sex === 'หญิง') {
                    $base->whereRaw("TRY_CONVERT(int, $sexExpr) = 2");
                } elseif (in_array($sex, ['1', '2'], true)) {
                    $base->whereRaw("TRY_CONVERT(int, $sexExpr) = ?", [(int)$sex]);
                } else {
                    $base->whereRaw("$sexExpr = ?", [$sex]);
                }
            }

            if (!$COL_HEALTH) {
                return [
                    $HEALTH_OPTIONS[0] => 0,
                    $HEALTH_OPTIONS[1] => 0,
                    $HEALTH_OPTIONS[2] => 0,
                    $HEALTH_OPTIONS[3] => 0,
                    $HEALTH_NULL_TOKEN => 0,
                ];
            }

            $healthExpr = $trim("u.[$COL_HEALTH]");

            $raw = (clone $base)->selectRaw("
                SUM(CASE WHEN TRY_CONVERT(int, $healthExpr) = 1 THEN 1 ELSE 0 END) as normal_cnt,
                SUM(CASE WHEN TRY_CONVERT(int, $healthExpr) = 2 THEN 1 ELSE 0 END) as chronic_cnt,
                SUM(CASE WHEN TRY_CONVERT(int, $healthExpr) = 3 THEN 1 ELSE 0 END) as disable_cnt,
                SUM(CASE WHEN TRY_CONVERT(int, $healthExpr) = 4 THEN 1 ELSE 0 END) as bed_cnt,
                SUM(CASE
                    WHEN u.[$COL_HEALTH] IS NULL
                      OR $healthExpr = N''
                      OR TRY_CONVERT(int, $healthExpr) NOT IN (1,2,3,4)
                      OR $healthExpr = N'0'
                    THEN 1 ELSE 0
                END) as unknown_cnt
            ")->first();

            return [
                $HEALTH_OPTIONS[0] => (int)($raw->normal_cnt ?? 0),
                $HEALTH_OPTIONS[1] => (int)($raw->chronic_cnt ?? 0),
                $HEALTH_OPTIONS[2] => (int)($raw->disable_cnt ?? 0),
                $HEALTH_OPTIONS[3] => (int)($raw->bed_cnt ?? 0),
                $HEALTH_NULL_TOKEN => (int)($raw->unknown_cnt ?? 0),
            ];
        });

        return view('health', compact(
            'actionUrl',
            'district','subdistrict','districtList','subdistrictList',
            'health','house_id','fname','lname','cid',
            'survey_year','agey','age_range','sex',
            'HEALTH_OPTIONS','HEALTH_NULL_TOKEN',
            'counts','rows'
        ));
    }

    public function export(Request $request)
    {
        $conn         = DB::connection('sqlsrv');
        $mainTable    = '[dbo].[survey_a]';
        $profileTable = '[dbo].[survey_profile64]';

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

        $COL_HOUSE    = $pickMainCol(['HC'], 'HC');
        $COL_ORDER    = $pickMainCol(['a1'], null);
        $COL_TITLE    = $pickMainCol(['a2_1'], null);
        $COL_FNAME    = $pickMainCol(['a2_2'], null);
        $COL_LNAME    = $pickMainCol(['a2_3'], null);
        $COL_CID      = $pickMainCol(['popid'], null);
        $COL_AGE      = $pickMainCol(['a3_1'], null);
        $COL_SEX      = $pickMainCol(['a4'], null);
        $COL_HEALTH   = $pickMainCol(['a5', 'health'], null);
        $COL_YEAR     = $pickMainCol(['survey_year', 'year'], null);

        $COL_DISTRICT = $pickMainCol(['district_name_thai'], null);
        $COL_TAMBON   = $pickMainCol(['tambon_name_thai'], null);

        $COL_HOUSE_NO     = $pickMainCol(['MBNO', 'house_number'], null);
        $COL_VILLAGE_NO   = $pickMainCol(['MB', 'village_no'], null);
        $COL_VILLAGE_NAME = $pickMainCol(['MM', 'village_name'], null);
        $COL_POSTCODE     = $pickMainCol(['postcode'], null);

        $P_COL_HOUSE    = $pickProfCol(['HC1'], 'HC1');
        $P_COL_TEL      = $pickProfCol(['TEL'], null);
        $P_COL_LATX     = $pickProfCol(['latx'], null);
        $P_COL_LNGY     = $pickProfCol(['lngy'], null);
        $P_COL_YEAR     = $pickProfCol(['survey_year', 'year'], null);

        $P_COL_HOUSE_NO     = $pickProfCol(['MBNO', 'house_number'], null);
        $P_COL_VILLAGE_NO   = $pickProfCol(['MB', 'village_no'], null);
        $P_COL_VILLAGE_NAME = $pickProfCol(['MM', 'village_name'], null);
        $P_COL_POSTCODE     = $pickProfCol(['postcode'], null);

        $districtRef = $colRef('u', $COL_DISTRICT);
        $tambonRef   = $colRef('u', $COL_TAMBON);

        $HEALTH_OPTIONS = [
            'ปกติ',
            'ป่วยเรื้อรังที่ไม่ติดเตียง (เช่น หัวใจ เบาหวาน)',
            'พิการพึ่งตนเองได้',
            'ผู้ป่วยติดเตียง/พิการพึ่งตัวเองไม่ได้',
        ];
        $HEALTH_NULL_TOKEN = '__NULL__';

        $healthTextToCode = [
            'ปกติ' => 1,
            'ป่วยเรื้อรังที่ไม่ติดเตียง (เช่น หัวใจ เบาหวาน)' => 2,
            'พิการพึ่งตนเองได้' => 3,
            'ผู้ป่วยติดเตียง/พิการพึ่งตัวเองไม่ได้' => 4,
        ];

        $sexMap = [
            1 => 'ชาย',
            2 => 'หญิง',
        ];

        $sexTextToCode = array_flip($sexMap);

        $district    = trim((string) $request->get('district', ''));
        $subdistrict = trim((string) $request->get('subdistrict', ''));
        $health      = trim((string) $request->get('health', ''));

        $house_id    = trim((string) $request->get('house_id', ''));
        $fname       = trim((string) $request->get('fname', ''));
        $lname       = trim((string) $request->get('lname', ''));
        $cid         = trim((string) $request->get('cid', ''));
        $survey_year = trim((string) $request->get('survey_year', ''));
        $agey        = trim((string) $request->get('agey', ''));
        $age_range   = trim((string) $request->get('age_range', ''));
        $sex         = trim((string) $request->get('sex', ''));

        if (!in_array($health, array_merge(['', $HEALTH_NULL_TOKEN], $HEALTH_OPTIONS), true)) {
            $health = '';
        }

        $parseAgeRange = function(string $ageRange): array {
            $ageRange = trim($ageRange);
            if ($ageRange === '') return [null, null];
            if (preg_match('/^(\d+)\-(\d+)$/', $ageRange, $m)) return [(int)$m[1], (int)$m[2]];
            if (preg_match('/^(\d+)\+$/', $ageRange, $m)) return [(int)$m[1], null];
            return [null, null];
        };

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

        $q = $baseQuery();

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
                    ? $q->whereRaw("TRY_CONVERT(int, $ageExpr) = ?", [(int)$agey])
                    : $q->whereRaw("$ageExpr LIKE ?", ["%{$agey}%"]);
            }
        }

        if ($sex !== '' && $COL_SEX) {
            $sexExpr = $trim($colRef('u', $COL_SEX));

            if (isset($sexTextToCode[$sex])) {
                $q->whereRaw("TRY_CONVERT(int, $sexExpr) = ?", [$sexTextToCode[$sex]]);
            } elseif (in_array($sex, ['1', '2'], true)) {
                $q->whereRaw("TRY_CONVERT(int, $sexExpr) = ?", [(int)$sex]);
            } else {
                $q->whereRaw("$sexExpr = ?", [$sex]);
            }
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

        if ($COL_HEALTH) {
            if ($health === $HEALTH_NULL_TOKEN) {
                $q->where(function($qq) use ($COL_HEALTH, $trim) {
                    $expr = $trim("u.[$COL_HEALTH]");
                    $qq->whereRaw("u.[$COL_HEALTH] IS NULL")
                       ->orWhereRaw("$expr = N''")
                       ->orWhereRaw("TRY_CONVERT(int, $expr) NOT IN (1,2,3,4)")
                       ->orWhereRaw("$expr = N'0'");
                });
            } elseif ($health !== '') {
                $code = $healthTextToCode[$health] ?? null;
                if ($code !== null) {
                    $q->whereRaw("TRY_CONVERT(int, ".$trim("u.[$COL_HEALTH]").") = ?", [$code]);
                }
            }
        }

        $healthCase = $COL_HEALTH
            ? "
                CASE TRY_CONVERT(int, ".$trim("u.[$COL_HEALTH]").")
                    WHEN 1 THEN N'ปกติ'
                    WHEN 2 THEN N'ป่วยเรื้อรังที่ไม่ติดเตียง (เช่น หัวใจ เบาหวาน)'
                    WHEN 3 THEN N'พิการพึ่งตนเองได้'
                    WHEN 4 THEN N'ผู้ป่วยติดเตียง/พิการพึ่งตัวเองไม่ได้'
                    ELSE N''
                END
            "
            : "N''";

        $sexCase = $COL_SEX
            ? "
                CASE TRY_CONVERT(int, ".$trim("u.[$COL_SEX]").")
                    WHEN 1 THEN N'ชาย'
                    WHEN 2 THEN N'หญิง'
                    ELSE N''
                END
            "
            : "N''";

        $selects = [];

        if ($COL_HOUSE)    $selects[] = "u.[{$COL_HOUSE}] as house_Id";
        if ($COL_ORDER)    $selects[] = "u.[{$COL_ORDER}] as human_Order";
        if ($COL_TITLE)    $selects[] = "u.[{$COL_TITLE}] as human_Member_title";
        if ($COL_FNAME)    $selects[] = "u.[{$COL_FNAME}] as human_Member_fname";
        if ($COL_LNAME)    $selects[] = "u.[{$COL_LNAME}] as human_Member_lname";
        if ($COL_CID)      $selects[] = "u.[{$COL_CID}] as human_Member_cid";
        if ($COL_AGE)      $selects[] = "u.[{$COL_AGE}] as human_Age_y";
        if ($COL_YEAR)     $selects[] = "u.[{$COL_YEAR}] as survey_Year";

        $selects[] = "$sexCase as human_Sex";
        $selects[] = "$healthCase as human_Health";

        if ($COL_DISTRICT) $selects[] = "u.[{$COL_DISTRICT}] as survey_District";
        if ($COL_TAMBON)   $selects[] = "u.[{$COL_TAMBON}] as survey_Subdistrict";

        if ($COL_HOUSE_NO) {
            $selects[] = "u.[{$COL_HOUSE_NO}] as house_Number";
        } elseif ($P_COL_HOUSE_NO) {
            $selects[] = "p.[{$P_COL_HOUSE_NO}] as house_Number";
        }

        if ($COL_VILLAGE_NO) {
            $selects[] = "u.[{$COL_VILLAGE_NO}] as village_No";
        } elseif ($P_COL_VILLAGE_NO) {
            $selects[] = "p.[{$P_COL_VILLAGE_NO}] as village_No";
        }

        if ($COL_VILLAGE_NAME) {
            $selects[] = "u.[{$COL_VILLAGE_NAME}] as village_Name";
        } elseif ($P_COL_VILLAGE_NAME) {
            $selects[] = "p.[{$P_COL_VILLAGE_NAME}] as village_Name";
        }

        if ($COL_POSTCODE) {
            $selects[] = "u.[{$COL_POSTCODE}] as survey_Postcode";
        } elseif ($P_COL_POSTCODE) {
            $selects[] = "p.[{$P_COL_POSTCODE}] as survey_Postcode";
        }

        if ($P_COL_TEL)  $selects[] = "p.[{$P_COL_TEL}] as survey_Informer_phone";
        if ($P_COL_LATX) $selects[] = "p.[{$P_COL_LATX}] as latitude";
        if ($P_COL_LNGY) $selects[] = "p.[{$P_COL_LNGY}] as longitude";

        $q->selectRaw(implode(",\n", $selects));

        if ($COL_YEAR)     $q->orderBy("u.$COL_YEAR");
        if ($COL_DISTRICT) $q->orderBy("u.$COL_DISTRICT");
        if ($COL_TAMBON)   $q->orderBy("u.$COL_TAMBON");
        if ($COL_HOUSE)    $q->orderBy("u.$COL_HOUSE");
        if ($COL_ORDER)    $q->orderByRaw("TRY_CONVERT(int, ".$trim("u.[$COL_ORDER]").")");

        $rows = $q->get();

        $fileName = 'health_export_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new HealthExport($rows), $fileName);
    }
}