<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $conn = DB::connection('sqlsrv');

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
        $COL_AGE      = $pickMainCol(['a3_1'], null);
        $COL_SEX      = $pickMainCol(['a4'], null);
        $COL_HEALTH   = $pickMainCol(['a5', 'health'], null);
        $COL_YEAR     = $pickMainCol(['survey_year', 'year'], null);

        $COL_PROVINCE = $pickMainCol(['province_name_thai'], null);
        $COL_DISTRICT = $pickMainCol(['district_name_thai'], null);
        $COL_TAMBON   = $pickMainCol(['tambon_name_thai'], null);

        // welfare
        $COL_A70 = $pickMainCol(['a7_0'], null);
        $COL_A71 = $pickMainCol(['a7_1'], null);
        $COL_A72 = $pickMainCol(['a7_2'], null);
        $COL_A73 = $pickMainCol(['a7_3'], null);
        $COL_A74 = $pickMainCol(['a7_4'], null);
        $COL_A75 = $pickMainCol(['a7_5'], null);
        $COL_A76 = $pickMainCol(['a7_6'], null);

        // ======================
        // mapping survey_profile64
        // ======================
        $P_COL_HOUSE = $pickProfCol(['HC1'], 'HC1');
        $P_COL_YEAR  = $pickProfCol(['survey_year', 'year'], null);

        $P_COL_DISTRICT = $pickProfCol(['district_name_thai','district'], null);
        $P_COL_TAMBON   = $pickProfCol(['tambon_name_thai','subdistrict'], null);

        $P_COL_POOR = $pickProfCol([
            'poor_flag',
            'is_poor',
            'poor',
            'status_poverty',
            'poverty_status',
            'hh_poor',
            'target_group',
            'poor_type'
        ], null);

        $P_CH1 = $pickProfCol(['ch1','ch_1'], null);
        $P_CH2 = $pickProfCol(['ch2','ch_2'], null);
        $P_CH3 = $pickProfCol(['ch3','ch_3'], null);
        $P_CH4 = $pickProfCol(['ch4','ch_4'], null);
        $P_CH5 = $pickProfCol(['ch5','ch_5'], null);

        $districtRef = $colRef('u', $COL_DISTRICT);
        $tambonRef   = $colRef('u', $COL_TAMBON);

        // ======================
        // options / map
        // ======================
        $YEAR_OPTIONS = ['all','2564','2565','2566','2567','2568'];

        $healthMap = [
            1 => 'ปกติ',
            2 => 'ป่วยเรื้อรังที่ไม่ติดเตียง (เช่น หัวใจ เบาหวาน)',
            3 => 'พิการพึ่งตนเองได้',
            4 => 'ผู้ป่วยติดเตียง/พิการพึ่งตัวเองไม่ได้',
        ];

        $sexMap = [
            1 => 'ชาย',
            2 => 'หญิง',
        ];

        $sexTextToCode = array_flip($sexMap);

        // ======================
        // filters
        // ======================
        $year        = trim((string) $request->get('year', 'all'));
        $view        = trim((string) $request->get('view', 'district'));
        $district    = trim((string) $request->get('district', ''));
        $subdistrict = trim((string) $request->get('subdistrict', ''));
        $human_Sex   = trim((string) $request->get('human_Sex', ''));
        $age_range   = trim((string) $request->get('age_range', ''));

        if (!in_array($year, $YEAR_OPTIONS, true)) {
            $year = 'all';
        }

        $parseAgeRange = function(string $ageRange): array {
            $ageRange = trim($ageRange);
            if ($ageRange === '') return [null, null];
            if (preg_match('/^(\d+)\-(\d+)$/', $ageRange, $m)) return [(int)$m[1], (int)$m[2]];
            if (preg_match('/^(\d+)\+$/', $ageRange, $m)) return [(int)$m[1], null];
            return [null, null];
        };

        [$ageMin, $ageMax] = $parseAgeRange($age_range);

        // ======================
        // base query (member-level)
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
        // helper apply filters (member-level)
        // ======================
        $applyCommonFilters = function($q) use (
            $district, $subdistrict, $year, $human_Sex, $ageMin, $ageMax,
            $districtRef, $tambonRef, $COL_YEAR, $COL_AGE, $COL_SEX,
            $colRef, $trim, $sexTextToCode
        ) {
            if ($district !== '' && $districtRef) {
                $q->whereRaw($trim($districtRef)." = ?", [$district]);
            }

            if ($subdistrict !== '' && $tambonRef) {
                $q->whereRaw($trim($tambonRef)." = ?", [$subdistrict]);
            }

            if ($year !== 'all' && ctype_digit($year) && $COL_YEAR) {
                $q->whereRaw($colRef('u', $COL_YEAR)." = ?", [(int)$year]);
            }

            if ($COL_AGE && ($ageMin !== null || $ageMax !== null)) {
                $ageExpr = $trim($colRef('u', $COL_AGE));
                if ($ageMin !== null && $ageMax !== null) {
                    $q->whereRaw("TRY_CONVERT(int, $ageExpr) BETWEEN ? AND ?", [$ageMin, $ageMax]);
                } elseif ($ageMin !== null) {
                    $q->whereRaw("TRY_CONVERT(int, $ageExpr) >= ?", [$ageMin]);
                }
            }

            if ($human_Sex !== '' && $COL_SEX) {
                $sexExpr = $trim($colRef('u', $COL_SEX));

                if (isset($sexTextToCode[$human_Sex])) {
                    $q->whereRaw("TRY_CONVERT(int, $sexExpr) = ?", [$sexTextToCode[$human_Sex]]);
                } elseif (in_array($human_Sex, ['1', '2'], true)) {
                    $q->whereRaw("TRY_CONVERT(int, $sexExpr) = ?", [(int)$human_Sex]);
                } else {
                    $q->whereRaw("$sexExpr = ?", [$human_Sex]);
                }
            }

            return $q;
        };

        // ======================
        // helper profile query (household capital)
        // ======================
        $profileBaseQuery = function() use ($conn, $profileTable) {
            return $conn->table(DB::raw("$profileTable as p"));
        };

        $applyProfileCapitalFilters = function($q) use (
            $district, $subdistrict, $year,
            $P_COL_DISTRICT, $P_COL_TAMBON, $P_COL_YEAR, $P_COL_POOR,
            $trim
        ) {
            if ($district !== '' && $P_COL_DISTRICT) {
                $q->whereRaw($trim("p.[$P_COL_DISTRICT]") . " = ?", [$district]);
            }

            if ($subdistrict !== '' && $P_COL_TAMBON) {
                $q->whereRaw($trim("p.[$P_COL_TAMBON]") . " = ?", [$subdistrict]);
            }

            if ($year !== 'all' && ctype_digit($year) && $P_COL_YEAR) {
                $q->whereRaw("TRY_CONVERT(int, p.[$P_COL_YEAR]) = ?", [(int)$year]);
            }

            if ($P_COL_POOR) {
                $poorExpr = $trim("CAST(p.[$P_COL_POOR] AS NVARCHAR(100))");

                $q->where(function($qq) use ($P_COL_POOR, $poorExpr) {
                    $qq->whereRaw("TRY_CONVERT(int, p.[$P_COL_POOR]) = 1")
                       ->orWhereRaw("$poorExpr IN (N'ยากจน', N'จน', N'poor', N'Poor', N'1')");
                });
            }

            return $q;
        };

        // ======================
        // helper welfare conditions
        // ======================
        $isNotReceivedCondition = function() use ($COL_A70, $trim) {
            if (!$COL_A70) return null;

            $a70 = $trim("u.[$COL_A70]");

            return "(
                $a70 = N'0'
                OR $a70 = N'ไม่'
                OR $a70 = N'ไม่มี'
                OR $a70 = N'ไม่ได้รับ'
                OR $a70 = N'ไม่เคยได้รับ'
                OR TRY_CONVERT(int, $a70) = 0
            )";
        };

        $isReceivedCondition = function() use ($COL_A70, $COL_A71, $COL_A72, $COL_A73, $COL_A74, $COL_A75, $COL_A76, $trim) {
            $receiveCols = array_values(array_filter([$COL_A71, $COL_A72, $COL_A73, $COL_A74, $COL_A75, $COL_A76]));

            $receiveChecks = [];
            foreach ($receiveCols as $col) {
                $expr = $trim("u.[$col]");
                $receiveChecks[] = "(NULLIF($expr, N'') IS NOT NULL AND $expr <> N'0')";
            }

            if (empty($receiveChecks)) {
                return null;
            }

            $a70Blank = "1=1";
            if ($COL_A70) {
                $a70 = $trim("u.[$COL_A70]");
                $a70Blank = "($a70 IS NULL OR $a70 = N'')";
            }

            return "(" . $a70Blank . " AND (" . implode(' OR ', $receiveChecks) . "))";
        };

        // ======================
        // dropdowns
        // ======================
        $districtList = Cache::remember('dashboard_district_survey_a', 3600, function () use ($baseQuery, $districtRef, $trim) {
            if (!$districtRef) return [];

            return $baseQuery()
                ->selectRaw($trim($districtRef)." as district")
                ->whereRaw("$districtRef IS NOT NULL")
                ->whereRaw($trim($districtRef)." <> N''")
                ->distinct()
                ->orderBy('district')
                ->pluck('district')
                ->toArray();
        });

        $subdistrictList = collect();
        if ($district !== '' && $tambonRef) {
            $subdistrictList = Cache::remember('dashboard_tambon_'.md5($district), 3600, function () use (
                $baseQuery, $district, $districtRef, $tambonRef, $trim
            ) {
                $q = $baseQuery()
                    ->selectRaw($trim($tambonRef)." as tambon")
                    ->whereRaw("$tambonRef IS NOT NULL")
                    ->whereRaw($trim($tambonRef)." <> N''");

                if ($district !== '' && $districtRef) {
                    $q->whereRaw($trim($districtRef)." = ?", [$district]);
                }

                return $q->distinct()->orderBy('tambon')->pluck('tambon');
            });
        }

        // ======================
        // main filtered query (member-level)
        // ======================
        // ใช้ survey_a ตรง ๆ ไม่ JOIN survey_profile64
        // เพื่อไม่ให้จำนวนสมาชิก/เพศ/สุขภาพ/สวัสดิการถูกนับซ้ำจากการ join
        $q = $conn->table(DB::raw("$mainTable as u"));
        $q = $applyCommonFilters($q);

        // ======================
        // KPI
        // ======================
        $totalMembers = (clone $q)->count();

        $totalHouseholds = $COL_HOUSE
            ? (clone $q)->distinct()->count("u.$COL_HOUSE")
            : 0;

        // ======================
        // เพศ
        // ======================
        if ($COL_SEX) {
            $sexExpr = $trim("u.[$COL_SEX]");
            $sexRaw = (clone $q)->selectRaw("
                SUM(CASE WHEN TRY_CONVERT(int, $sexExpr) = 1 THEN 1 ELSE 0 END) AS male,
                SUM(CASE WHEN TRY_CONVERT(int, $sexExpr) = 2 THEN 1 ELSE 0 END) AS female
            ")->first();
        } else {
            $sexRaw = (object)['male' => 0, 'female' => 0];
        }

        $sexCounts = [
            'ชาย'  => (int)($sexRaw->male ?? 0),
            'หญิง' => (int)($sexRaw->female ?? 0),
        ];

        // ======================
        // สุขภาพ summary
        // ======================
        if ($COL_HEALTH) {
            $healthExpr = $trim("u.[$COL_HEALTH]");
            $healthRaw = (clone $q)->selectRaw("
                SUM(CASE WHEN TRY_CONVERT(int, $healthExpr) = 1 THEN 1 ELSE 0 END) AS h0,
                SUM(CASE WHEN TRY_CONVERT(int, $healthExpr) = 2 THEN 1 ELSE 0 END) AS h1,
                SUM(CASE WHEN TRY_CONVERT(int, $healthExpr) = 3 THEN 1 ELSE 0 END) AS h2,
                SUM(CASE WHEN TRY_CONVERT(int, $healthExpr) = 4 THEN 1 ELSE 0 END) AS h3
            ")->first();
        } else {
            $healthRaw = (object)['h0' => 0, 'h1' => 0, 'h2' => 0, 'h3' => 0];
        }

        $healthCounts = [
            'ปกติ'                             => (int)($healthRaw->h0 ?? 0),
            'ป่วยเรื้อรังที่ไม่ติดเตียง'        => (int)($healthRaw->h1 ?? 0),
            'พิการพึ่งตนเองได้'                => (int)($healthRaw->h2 ?? 0),
            'ผู้ป่วยติดเตียง/พึ่งตัวเองไม่ได้' => (int)($healthRaw->h3 ?? 0),
        ];

        // ======================
        // สวัสดิการ (นับ "จำนวนคน")
        // received  = a7_0 ว่าง/NULL และ a7_1-a7_6 มีค่า
        // not_received = a7_0 = 0/ไม่/ไม่มี/ไม่ได้รับ
        // ======================
        $welfareTotal = $totalMembers;
        $welfareReceived = 0;
        $welfareNotReceived = 0;

        $receivedCond = $isReceivedCondition();
        $notReceivedCond = $isNotReceivedCondition();

        if ($receivedCond) {
            $welfareReceived = (clone $q)
                ->whereRaw($receivedCond)
                ->count();
        }

        if ($notReceivedCond) {
            $welfareNotReceived = (clone $q)
                ->whereRaw($notReceivedCond)
                ->count();
        }

        if ($welfareReceived > $welfareTotal) {
            $welfareReceived = $welfareTotal;
        }
        if ($welfareNotReceived > $welfareTotal) {
            $welfareNotReceived = $welfareTotal;
        }

        // ======================
        // กราฟสุขภาพ
        // ======================
        $labels = [];
        $datasets = [];

        if ($COL_HEALTH && ($COL_DISTRICT || $COL_TAMBON)) {
            $healthExpr = $trim("u.[$COL_HEALTH]");

            // ใช้ survey_a ตรง ๆ สำหรับกราฟสุขภาพ เพื่อกันข้อมูลซ้ำจากการ join
            $chartQ = $conn->table(DB::raw("$mainTable as u"));
            $chartQ = $applyCommonFilters($chartQ);

            if ($district !== '' && $COL_TAMBON) {
                $groupExpr = $trim("u.[$COL_TAMBON]");
            } elseif ($COL_DISTRICT) {
                $groupExpr = $trim("u.[$COL_DISTRICT]");
            } else {
                $groupExpr = null;
            }

            if ($groupExpr) {
                $healthByArea = $chartQ
                    ->selectRaw("
                        $groupExpr AS label,
                        SUM(CASE WHEN TRY_CONVERT(int, $healthExpr) = 1 THEN 1 ELSE 0 END) AS normal_total,
                        SUM(CASE WHEN TRY_CONVERT(int, $healthExpr) = 2 THEN 1 ELSE 0 END) AS chronic_total,
                        SUM(CASE WHEN TRY_CONVERT(int, $healthExpr) = 3 THEN 1 ELSE 0 END) AS disabled_total,
                        SUM(CASE WHEN TRY_CONVERT(int, $healthExpr) = 4 THEN 1 ELSE 0 END) AS bedridden_total,
                        SUM(CASE
                            WHEN u.[$COL_HEALTH] IS NULL
                              OR $healthExpr = N''
                              OR TRY_CONVERT(int, $healthExpr) NOT IN (1,2,3,4)
                              OR $healthExpr = N'0'
                            THEN 1 ELSE 0
                        END) AS unknown_total
                    ")
                    ->whereRaw("$groupExpr IS NOT NULL")
                    ->whereRaw("$groupExpr <> N''")
                    ->groupByRaw($groupExpr)
                    ->orderBy('label')
                    ->get();

                $labels = $healthByArea->pluck('label')->map(fn($v) => (string)$v)->values()->all();

                $datasets = [
                    [
                        'label' => 'ปกติ',
                        'data'  => $healthByArea->pluck('normal_total')->map(fn($v) => (int)$v)->values()->all(),
                    ],
                    [
                        'label' => 'ป่วยเรื้อรังที่ไม่ติดเตียง (เช่น หัวใจ เบาหวาน)',
                        'data'  => $healthByArea->pluck('chronic_total')->map(fn($v) => (int)$v)->values()->all(),
                    ],
                    [
                        'label' => 'พิการพึ่งตนเองได้',
                        'data'  => $healthByArea->pluck('disabled_total')->map(fn($v) => (int)$v)->values()->all(),
                    ],
                    [
                        'label' => 'ผู้ป่วยติดเตียง/พิการพึ่งตัวเองไม่ได้',
                        'data'  => $healthByArea->pluck('bedridden_total')->map(fn($v) => (int)$v)->values()->all(),
                    ],
                    [
                        'label' => 'ไม่ระบุ',
                        'data'  => $healthByArea->pluck('unknown_total')->map(fn($v) => (int)$v)->values()->all(),
                    ],
                ];
            }
        }

        // ======================
        // householdsByDistrict
        // ======================
        if ($COL_DISTRICT && $COL_HOUSE) {
            // ใช้ survey_a ตรง ๆ สำหรับจำนวนครัวเรือนรายอำเภอ
            $hhQ = $conn->table(DB::raw("$mainTable as u"));
            $hhQ = $applyCommonFilters($hhQ);

            $householdsByDistrict = $hhQ
                ->selectRaw("
                    ".$trim("u.[$COL_DISTRICT]")." AS label,
                    COUNT(DISTINCT u.[$COL_HOUSE]) AS total
                ")
                ->whereRaw("u.[$COL_DISTRICT] IS NOT NULL")
                ->whereRaw($trim("u.[$COL_DISTRICT]")." <> N''")
                ->groupByRaw($trim("u.[$COL_DISTRICT]"))
                ->orderByDesc('total')
                ->get();
        } else {
            $householdsByDistrict = collect();
        }

        // ======================
        // ทุน 5 ด้าน ของ "ครัวเรือนยากจน"
        // ======================
        $capSummary = [
            'human'     => 0,
            'physical'  => 0,
            'financial' => 0,
            'natural'   => 0,
            'social'    => 0,
        ];

        $capStd = [
            'human'     => 0,
            'physical'  => 0,
            'financial' => 0,
            'natural'   => 0,
            'social'    => 0,
        ];

        $capRadar = [0,0,0,0,0];
        $capRadarStd = [0,0,0,0,0];
        $capYear = ($year === 'all') ? 2568 : (int)$year;
        $capByYear = [];
        $poorHouseholds = 0;
        $capOverallMean = 0;

        if ($P_CH1 && $P_CH2 && $P_CH3 && $P_CH4 && $P_CH5) {
            $capQ = $profileBaseQuery();
            $capQ = $applyProfileCapitalFilters($capQ);

            if ($P_COL_HOUSE && $P_COL_YEAR) {
                $sub = $capQ->selectRaw("
                    p.[$P_COL_HOUSE] AS hc,
                    TRY_CONVERT(int, p.[$P_COL_YEAR]) AS survey_year,
                    AVG(TRY_CAST(p.[$P_CH1] AS float)) AS ch1,
                    AVG(TRY_CAST(p.[$P_CH2] AS float)) AS ch2,
                    AVG(TRY_CAST(p.[$P_CH3] AS float)) AS ch3,
                    AVG(TRY_CAST(p.[$P_CH4] AS float)) AS ch4,
                    AVG(TRY_CAST(p.[$P_CH5] AS float)) AS ch5
                ")
                ->groupByRaw("p.[$P_COL_HOUSE], TRY_CONVERT(int, p.[$P_COL_YEAR])");

                $capAgg = $conn->query()
                    ->fromSub($sub, 'x')
                    ->selectRaw("
                        COUNT(*) AS poor_households,
                        AVG(ch1) AS human,
                        AVG(ch2) AS physical,
                        AVG(ch3) AS financial,
                        AVG(ch4) AS natural,
                        AVG(ch5) AS social,

                        STDEV(ch1) AS human_sd,
                        STDEV(ch2) AS physical_sd,
                        STDEV(ch3) AS financial_sd,
                        STDEV(ch4) AS natural_sd,
                        STDEV(ch5) AS social_sd,

                        AVG((ISNULL(ch1,0)+ISNULL(ch2,0)+ISNULL(ch3,0)+ISNULL(ch4,0)+ISNULL(ch5,0))/5.0) AS overall_mean
                    ")
                    ->first();
            } else {
                $capAgg = $capQ->selectRaw("
                    COUNT(*) AS poor_households,
                    AVG(TRY_CAST(p.[$P_CH1] AS float)) AS human,
                    AVG(TRY_CAST(p.[$P_CH2] AS float)) AS physical,
                    AVG(TRY_CAST(p.[$P_CH3] AS float)) AS financial,
                    AVG(TRY_CAST(p.[$P_CH4] AS float)) AS natural,
                    AVG(TRY_CAST(p.[$P_CH5] AS float)) AS social,

                    STDEV(TRY_CAST(p.[$P_CH1] AS float)) AS human_sd,
                    STDEV(TRY_CAST(p.[$P_CH2] AS float)) AS physical_sd,
                    STDEV(TRY_CAST(p.[$P_CH3] AS float)) AS financial_sd,
                    STDEV(TRY_CAST(p.[$P_CH4] AS float)) AS natural_sd,
                    STDEV(TRY_CAST(p.[$P_CH5] AS float)) AS social_sd,

                    AVG((
                        ISNULL(TRY_CAST(p.[$P_CH1] AS float),0) +
                        ISNULL(TRY_CAST(p.[$P_CH2] AS float),0) +
                        ISNULL(TRY_CAST(p.[$P_CH3] AS float),0) +
                        ISNULL(TRY_CAST(p.[$P_CH4] AS float),0) +
                        ISNULL(TRY_CAST(p.[$P_CH5] AS float),0)
                    ) / 5.0) AS overall_mean
                ")->first();
            }

            $poorHouseholds = (int)($capAgg->poor_households ?? 0);

            $capSummary = [
                'human'     => round((float)($capAgg->human ?? 0), 2),
                'physical'  => round((float)($capAgg->physical ?? 0), 2),
                'financial' => round((float)($capAgg->financial ?? 0), 2),
                'natural'   => round((float)($capAgg->natural ?? 0), 2),
                'social'    => round((float)($capAgg->social ?? 0), 2),
            ];

            $capStd = [
                'human'     => round((float)($capAgg->human_sd ?? 0), 2),
                'physical'  => round((float)($capAgg->physical_sd ?? 0), 2),
                'financial' => round((float)($capAgg->financial_sd ?? 0), 2),
                'natural'   => round((float)($capAgg->natural_sd ?? 0), 2),
                'social'    => round((float)($capAgg->social_sd ?? 0), 2),
            ];

            $capOverallMean = round((float)($capAgg->overall_mean ?? 0), 2);

            $capRadar = [
                $capSummary['human'],
                $capSummary['physical'],
                $capSummary['financial'],
                $capSummary['natural'],
                $capSummary['social'],
            ];

            $capRadarStd = [
                $capStd['human'],
                $capStd['physical'],
                $capStd['financial'],
                $capStd['natural'],
                $capStd['social'],
            ];

            if ($P_COL_YEAR) {
                foreach ([2564,2565,2566,2567,2568] as $yy) {
                    $yearQ = $profileBaseQuery();

                    if ($district !== '' && $P_COL_DISTRICT) {
                        $yearQ->whereRaw($trim("p.[$P_COL_DISTRICT]") . " = ?", [$district]);
                    }

                    if ($subdistrict !== '' && $P_COL_TAMBON) {
                        $yearQ->whereRaw($trim("p.[$P_COL_TAMBON]") . " = ?", [$subdistrict]);
                    }

                    if ($P_COL_POOR) {
                        $poorExpr = $trim("CAST(p.[$P_COL_POOR] AS NVARCHAR(100))");

                        $yearQ->where(function($qq) use ($P_COL_POOR, $poorExpr) {
                            $qq->whereRaw("TRY_CONVERT(int, p.[$P_COL_POOR]) = 1")
                               ->orWhereRaw("$poorExpr IN (N'ยากจน', N'จน', N'poor', N'Poor', N'1')");
                        });
                    }

                    $yearQ->whereRaw("TRY_CONVERT(int, p.[$P_COL_YEAR]) = ?", [$yy]);

                    if ($P_COL_HOUSE && $P_COL_YEAR) {
                        $subYear = $yearQ->selectRaw("
                            p.[$P_COL_HOUSE] AS hc,
                            TRY_CONVERT(int, p.[$P_COL_YEAR]) AS survey_year,
                            AVG(TRY_CAST(p.[$P_CH1] AS float)) AS ch1,
                            AVG(TRY_CAST(p.[$P_CH2] AS float)) AS ch2,
                            AVG(TRY_CAST(p.[$P_CH3] AS float)) AS ch3,
                            AVG(TRY_CAST(p.[$P_CH4] AS float)) AS ch4,
                            AVG(TRY_CAST(p.[$P_CH5] AS float)) AS ch5
                        ")
                        ->groupByRaw("p.[$P_COL_HOUSE], TRY_CONVERT(int, p.[$P_COL_YEAR])");

                        $row = $conn->query()
                            ->fromSub($subYear, 'x')
                            ->selectRaw("
                                AVG(ch1) AS human,
                                AVG(ch2) AS physical,
                                AVG(ch3) AS financial,
                                AVG(ch4) AS natural,
                                AVG(ch5) AS social
                            ")
                            ->first();
                    } else {
                        $row = $yearQ->selectRaw("
                            AVG(TRY_CAST(p.[$P_CH1] AS float)) AS human,
                            AVG(TRY_CAST(p.[$P_CH2] AS float)) AS physical,
                            AVG(TRY_CAST(p.[$P_CH3] AS float)) AS financial,
                            AVG(TRY_CAST(p.[$P_CH4] AS float)) AS natural,
                            AVG(TRY_CAST(p.[$P_CH5] AS float)) AS social
                        ")->first();
                    }

                    $capByYear[$yy] = [
                        'human'     => round((float)($row->human ?? 0), 2),
                        'physical'  => round((float)($row->physical ?? 0), 2),
                        'financial' => round((float)($row->financial ?? 0), 2),
                        'natural'   => round((float)($row->natural ?? 0), 2),
                        'social'    => round((float)($row->social ?? 0), 2),
                    ];
                }
            }
        }

        return view('dashboard', compact(
            'year',
            'view',
            'district',
            'subdistrict',
            'human_Sex',
            'age_range',
            'YEAR_OPTIONS',
            'districtList',
            'subdistrictList',
            'totalHouseholds',
            'totalMembers',
            'labels',
            'datasets',
            'sexCounts',
            'healthCounts',
            'welfareTotal',
            'welfareReceived',
            'welfareNotReceived',
            'householdsByDistrict',
            'capSummary',
            'capStd',
            'capRadar',
            'capRadarStd',
            'capYear',
            'capByYear',
            'poorHouseholds',
            'capOverallMean'
        ));
    }
}