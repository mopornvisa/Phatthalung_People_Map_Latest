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
            'welfareChartLabels' => $data['welfareChartLabels'],
'welfareChartData'   => $data['welfareChartData'],
'typeChartLabels'    => $data['typeChartLabels'],
'typeChartData'      => $data['typeChartData'],
'typeChartReceivedData'    => $data['typeChartReceivedData'],
'typeChartNotReceivedData' => $data['typeChartNotReceivedData'],
        ]);
    }

    public function export(Request $request)
    {
        @ini_set('max_execution_time', 300);
        @ini_set('memory_limit', '1024M');
        @set_time_limit(300);

        $data = $this->getWelfareBaseData($request, true);

        $fileName = 'รายงานข้อมูลสวัสดิการ';

if ($request->filled('survey_year')) {
    $fileName .= '_ปี'.$request->survey_year;
}

if ($request->filled('district')) {
    $fileName .= '_อำเภอ'.$request->district;
}

if ($request->filled('subdistrict')) {
    $fileName .= '_ตำบล'.$request->subdistrict;
}

$fileName .= '.xlsx';

     return Excel::download(
    new WelfareExport(
        $data['exportQuery'],
        [
            'survey_year' => $data['survey_year'],
            'district' => $data['district'],
            'subdistrict' => $data['subdistrict'],
            'welfare' => $data['welfare'],
            'welfare_type' => $data['welfare_type'],
        ]
    ),
    $fileName
);
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

        $coalesceTrim = function (?string $mainExpr, ?string $profExpr, string $alias) {
            if ($mainExpr && $profExpr) {
                return "COALESCE(NULLIF(LTRIM(RTRIM($mainExpr)), N''), NULLIF(LTRIM(RTRIM($profExpr)), N'')) as {$alias}";
            }
            if ($mainExpr) {
                return "$mainExpr as {$alias}";
            }
            if ($profExpr) {
                return "$profExpr as {$alias}";
            }
            return null;
        };

        // ======================
        // mapping survey_a
        // ======================
        $COL_HOUSE = $pickMainCol(['HC'], null);
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
       $COL_HOUSE_PROFILE = $pickProfCol(['HC1', 'HC'], null);
$COL_HOUSE_SURVEY  = $pickMainCol(['HC'], null);
        $P_COL_TEL      = $pickProfCol(['TEL'], null);
        $P_COL_LATX     = $pickProfCol(['latx'], null);
        $P_COL_LNGY     = $pickProfCol(['lngy'], null);

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

    if ($ageRange === '') {
        return [null, null];
    }

    // ไม่ระบุอายุ = 0
    if ($ageRange === '0') {
        return [0, 0];
    }

    if (preg_match('/^(\d+)\-(\d+)$/', $ageRange, $m)) {
        return [(int)$m[1], (int)$m[2]];
    }

    if (preg_match('/^(\d+)\+$/', $ageRange, $m)) {
        return [(int)$m[1], null];
    }

    return [null, null];
};
      
          

        // ======================
        // welfare cols
        // ======================
       $allowedCols = ['a7_1','a7_2','a7_3','a7_4','a7_5','a7_6'];
$picked      = array_values(array_intersect($welfare_type, $allowedCols));

$isUnknownOnly = in_array('unknown', $welfare_type, true);

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
            $COL_HOUSE_SURVEY, $COL_HOUSE_PROFILE
        ) {
            $q = $conn->table(DB::raw("$mainTable as u"));

            // สำคัญ: survey_profile64 อาจมีรหัสบ้านซ้ำหลายแถว
            // ถ้า join ตรง ๆ จะทำให้คนใน survey_a ซ้ำและโหลดช้า
            // เลยเลือก profile แค่ 1 แถวต่อรหัสบ้านก่อน
            if ($COL_HOUSE_SURVEY && $COL_HOUSE_PROFILE) {

                $profileOne = "
                    (
                        SELECT *
                        FROM (
                            SELECT p.*,
                                   ROW_NUMBER() OVER (
                                       PARTITION BY LTRIM(RTRIM(p.[{$COL_HOUSE_PROFILE}]))
                                       ORDER BY p.[{$COL_HOUSE_PROFILE}]
                                   ) as rn
                            FROM {$profileTable} p
                        ) pp
                        WHERE pp.rn = 1
                    ) as p
                ";

                $q->leftJoin(DB::raw($profileOne), function($join)
                    use ($COL_HOUSE_SURVEY, $COL_HOUSE_PROFILE) {

                    $join->on(
                        DB::raw("LTRIM(RTRIM(u.[{$COL_HOUSE_SURVEY}]))"),
                        '=',
                        DB::raw("LTRIM(RTRIM(p.[{$COL_HOUSE_PROFILE}]))")
                    );
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
            $picked, $welfare, $welfare_match, $isUnknownOnly,
            $parseAgeRange, $trim, $hasNumericValueCondition,
            $COL_HOUSE, $COL_FNAME, $COL_LNAME, $COL_CID, $COL_YEAR, $COL_AGE, $COL_SEX,
            $a70ExprT, $provinceRef, $districtRef, $tambonRef, $colRef
        );

        // ใช้ query ตัวนี้สำหรับนับ KPI/กราฟ แบบนับคนไม่ซ้ำที่ SQL เลย
        // ห้ามใช้ get()->unique() กับข้อมูลแสนกว่าแถว เพราะจะโหลดช้ามาก
        $countBaseQ = clone $q;

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

        $houseNoExpr = $coalesceTrim(
            $COL_HOUSE_NO ? "u.[{$COL_HOUSE_NO}]" : null,
            $P_COL_HOUSE_NO ? "p.[{$P_COL_HOUSE_NO}]" : null,
            'house_number'
        );
        if ($houseNoExpr) $selects[] = $houseNoExpr;

        $villageNoExpr = $coalesceTrim(
            $COL_VILLAGE_NO ? "u.[{$COL_VILLAGE_NO}]" : null,
            $P_COL_VILLAGE_NO ? "p.[{$P_COL_VILLAGE_NO}]" : null,
            'village_no'
        );
        if ($villageNoExpr) $selects[] = $villageNoExpr;

        $villageNameExpr = $coalesceTrim(
            $COL_VILLAGE_NAME ? "u.[{$COL_VILLAGE_NAME}]" : null,
            $P_COL_VILLAGE_NAME ? "p.[{$P_COL_VILLAGE_NAME}]" : null,
            'village_name'
        );
        if ($villageNameExpr) $selects[] = $villageNameExpr;

        $postcodeExpr = $coalesceTrim(
            $COL_POSTCODE ? "u.[{$COL_POSTCODE}]" : null,
            $P_COL_POSTCODE ? "p.[{$P_COL_POSTCODE}]" : null,
            'postcode'
        );
        if ($postcodeExpr) $selects[] = $postcodeExpr;

        if ($P_COL_TEL) {
            $selects[] = "COALESCE(NULLIF(LTRIM(RTRIM(p.[{$P_COL_TEL}])), N''), N'') as TEL";
        }

        if ($P_COL_LATX) {
            $selects[] = "COALESCE(NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(100), p.[{$P_COL_LATX}]))), N''), N'') as latx";
        }

        if ($P_COL_LNGY) {
            $selects[] = "COALESCE(NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(100), p.[{$P_COL_LNGY}]))), N''), N'') as lngy";
        }

        foreach (['a7_0','a7_1','a7_2','a7_3','a7_4','a7_5','a7_6'] as $wcol) {
            if ($hasMainCol($wcol)) {
                $selects[] = "u.[$wcol] as $wcol";
            }
        }

       $q->selectRaw(implode(",\n", $selects));

if ($COL_YEAR)     $q->orderByRaw("u.[{$COL_YEAR}] asc");
if ($COL_PROVINCE) $q->orderByRaw("u.[{$COL_PROVINCE}] asc");
if ($COL_DISTRICT) $q->orderByRaw("u.[{$COL_DISTRICT}] asc");
if ($COL_TAMBON)   $q->orderByRaw("u.[{$COL_TAMBON}] asc");
if ($COL_HOUSE)    $q->orderByRaw("u.[{$COL_HOUSE}] asc");
// ======================
// counts + charts
// ======================

// key สำหรับนับ "คนไม่ซ้ำ"
// ถ้ามี popid ใช้ popid, ถ้า popid ว่าง ใช้ HC-a1 แทน
$personKey = "COALESCE(
    NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(100), u.[popid]))), N''),
    CONCAT(
        LTRIM(RTRIM(CONVERT(nvarchar(100), u.[HC]))),
        N'-',
        LTRIM(RTRIM(CONVERT(nvarchar(100), u.[a1]))),
        N'-',
        LTRIM(RTRIM(CONVERT(nvarchar(100), u.[survey_year])))
    )
)";

$a70CountExpr = "LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_0])))";

$countDistinctPeople = function ($query) use ($personKey) {
    return (int) $query
        ->distinct()
        ->count(DB::raw($personKey));
};

if ($forExport) {
    $receivedCount = 0;
    $notReceivedCount = 0;
} elseif ($welfare === 'received') {
    $receivedCount = $countDistinctPeople(clone $countBaseQ);
    $notReceivedCount = 0;
} elseif ($welfare === 'not_received') {
    $receivedCount = 0;
    $notReceivedCount = $countDistinctPeople(clone $countBaseQ);
} else {
    $receivedCount = $countDistinctPeople(
        (clone $countBaseQ)->where(function($qq) use ($a70CountExpr) {
            $qq->whereRaw("$a70CountExpr IS NULL")
               ->orWhereRaw("$a70CountExpr = N''")
               ->orWhereRaw("$a70CountExpr <> N'0'");
        })
    );

    $notReceivedCount = $countDistinctPeople(
        (clone $countBaseQ)->whereRaw("$a70CountExpr = N'0'")
    );
}

if ($welfare === 'received') {
    $counts = [
        'received' => $receivedCount,
        'not_received' => 0,
    ];

    $welfareChartLabels = ['ได้รับสวัสดิการ'];
    $welfareChartData = [$receivedCount];

} elseif ($welfare === 'not_received') {
    $counts = [
        'received' => 0,
        'not_received' => $notReceivedCount,
    ];

    $welfareChartLabels = ['ไม่ได้รับสวัสดิการ'];
    $welfareChartData = [$notReceivedCount];

} else {
    $counts = [
        'received' => $receivedCount,
        'not_received' => $notReceivedCount,
    ];

    $welfareChartLabels = ['ได้รับสวัสดิการ', 'ไม่ได้รับสวัสดิการ'];
    $welfareChartData = [$receivedCount, $notReceivedCount];
}

$typeChartLabels = [];
$typeChartData = [];
$typeChartReceivedData = [];
$typeChartNotReceivedData = [];

// ======================
// กราฟประเภทแบบ "จัดกลุ่มหลัก"
// 1 คน นับได้แค่ 1 กลุ่มเท่านั้น
// ทำให้ยอดรวมทุกประเภท = จำนวนสมาชิกไม่ซ้ำทั้งหมด
// ลำดับความสำคัญ:
// ไม่ได้รับ > เด็กแรกเกิด > ผู้สูงอายุ > คนพิการ > ม.33 > ม.40 > บัตรสวัสดิการ > ไม่ระบุ
// ======================
if (!$forExport) {

    // กราฟประเภทสวัสดิการต้องใช้ $countBaseQ
    // เพื่อให้กราฟเปลี่ยนตามตัวกรองที่กรอกไว้ทั้งหมด
    $typeRules = [
        'เด็กแรกเกิด' => "
            NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_1]))), N'') IS NOT NULL
            AND LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_1]))) <> N'0'
        ",
        'เบี้ยผู้สูงอายุ/คนชรา' => "
            NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_2]))), N'') IS NOT NULL
            AND LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_2]))) <> N'0'
        ",
        'เบี้ยคนพิการ' => "
            NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_3]))), N'') IS NOT NULL
            AND LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_3]))) <> N'0'
        ",
        'ประกันสังคม (ม.33)' => "
            NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_4]))), N'') IS NOT NULL
            AND LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_4]))) <> N'0'
        ",
        'ประกันตนเอง (ม.40)' => "
            NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_5]))), N'') IS NOT NULL
            AND LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_5]))) <> N'0'
        ",
        'บัตรสวัสดิการแห่งรัฐ' => "
            NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_6]))), N'') IS NOT NULL
            AND LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_6]))) <> N'0'
        ",
        'ไม่ระบุ' => "
            (NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_1]))), N'') IS NULL OR LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_1]))) = N'0')
            AND (NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_2]))), N'') IS NULL OR LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_2]))) = N'0')
            AND (NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_3]))), N'') IS NULL OR LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_3]))) = N'0')
            AND (NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_4]))), N'') IS NULL OR LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_4]))) = N'0')
            AND (NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_5]))), N'') IS NULL OR LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_5]))) = N'0')
            AND (NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_6]))), N'') IS NULL OR LTRIM(RTRIM(CONVERT(nvarchar(50), u.[a7_6]))) = N'0')
            AND ($a70CountExpr IS NULL OR $a70CountExpr = N'' OR $a70CountExpr <> N'0')
        ",
        'ไม่ได้รับสวัสดิการ' => "
            $a70CountExpr = N'0'
        ",
    ];

    foreach ($typeRules as $label => $condition) {
        $count = $countDistinctPeople(
            (clone $countBaseQ)->whereRaw($condition)
        );

        $typeChartLabels[] = $label;
$typeChartData[] = $count;

if ($label === 'ไม่ได้รับสวัสดิการ') {
    $typeChartReceivedData[] = 0;
    $typeChartNotReceivedData[] = $count;
} else {
    $typeChartReceivedData[] = $count;
    $typeChartNotReceivedData[] = 0;
}
    }
}


$exportQuery = clone $q;

// แสดงตารางแบบ paginate จาก SQL โดยตรง ไม่ดึงทั้งหมดเข้า PHP
// ความไม่ซ้ำแก้ที่ join profileOne ด้านบนแล้ว
$rows = $forExport
    ? collect()
    : $q->paginate(15)->appends($request->query());

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

            'welfareChartLabels' => $welfareChartLabels,
'welfareChartData'   => $welfareChartData,
'typeChartLabels'    => $typeChartLabels,
'typeChartData'      => $typeChartData,
'typeChartReceivedData'    => $typeChartReceivedData,
'typeChartNotReceivedData' => $typeChartNotReceivedData,
        ];
    }

    private function applyWelfareFilters(
        $q,
        $province, $district, $subdistrict,
        $survey_year, $house_id, $fname, $lname, $cid,
        $agey, $age_range, $sex,
        $picked, $welfare, $welfare_match, $isUnknownOnly,
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
    $q->whereRaw("LTRIM(RTRIM(u.[{$COL_HOUSE}])) LIKE ?", ["%{$house_id}%"]);
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
   ->orWhereRaw("$a70ExprT = N''")
   ->orWhereRaw("$a70ExprT <> N'0'");
    });

    // กรณีเลือก "ไม่ระบุ"
    if ($isUnknownOnly) {

        $q->whereRaw("
            (NULLIF(LTRIM(RTRIM(u.[a7_1])), N'') IS NULL OR LTRIM(RTRIM(u.[a7_1])) = N'0')
            AND (NULLIF(LTRIM(RTRIM(u.[a7_2])), N'') IS NULL OR LTRIM(RTRIM(u.[a7_2])) = N'0')
            AND (NULLIF(LTRIM(RTRIM(u.[a7_3])), N'') IS NULL OR LTRIM(RTRIM(u.[a7_3])) = N'0')
            AND (NULLIF(LTRIM(RTRIM(u.[a7_4])), N'') IS NULL OR LTRIM(RTRIM(u.[a7_4])) = N'0')
            AND (NULLIF(LTRIM(RTRIM(u.[a7_5])), N'') IS NULL OR LTRIM(RTRIM(u.[a7_5])) = N'0')
            AND (NULLIF(LTRIM(RTRIM(u.[a7_6])), N'') IS NULL OR LTRIM(RTRIM(u.[a7_6])) = N'0')
        ");

    }
    elseif (!empty($picked)) {

        $cond = $hasNumericValueCondition($picked, $welfare_match);

        if ($cond) {
            $q->whereRaw($cond);
        }
    }
}
elseif ($welfare === 'not_received') {

    $q->whereRaw("$a70ExprT = N'0'");
}
        return $q;
    }
}