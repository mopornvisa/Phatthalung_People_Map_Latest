<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EconomyController extends Controller
{
    public function index(Request $request)
    {
        $district = trim((string)($request->district_name_thai ?? ''));
        $tambon   = trim((string)($request->tambon_name_thai ?? ''));

        $conn = DB::connection('sqlsrv');

        $profileSub = $conn->table('PPAOS93.dbo.survey_profile64')
            ->selectRaw("
                HC,
                MIN(AMP) as AMP,
                MIN(TMP) as TMP,
                MIN(district_name_thai) as district_name_thai,
                MIN(tambon_name_thai) as tambon_name_thai
            ")
            ->whereNotNull('HC')
            ->groupBy('HC');

        $base = $conn
            ->table('PPAOS93.dbo.survey_c as c')
            ->leftJoinSub($profileSub, 'p', function ($join) {
                $join->on(
                    DB::raw("LTRIM(RTRIM(p.HC))"),
                    '=',
                    DB::raw("LTRIM(RTRIM(c.HC))")
                );
            })
            ->leftJoin('PPAOS93.dbo.district as d', function ($join) {
                $join->on(
                    DB::raw("LTRIM(RTRIM(p.AMP))"),
                    '=',
                    DB::raw("d.district_id")
                );
            })
            ->leftJoin('PPAOS93.dbo.tambon as t', function ($join) {
                $join->on(
                    DB::raw("LEFT(LTRIM(RTRIM(p.TMP)), 7)"),
                    '=',
                    DB::raw("t.tambon_id")
                );
            });

        if ($request->filled('survey_year')) {
            $base->where('c.survey_year', $request->survey_year);
        }

        if ($request->filled('hc')) {
            $base->where('c.HC', 'like', '%' . $request->hc . '%');
        }

        if ($district !== '') {
            $base->whereRaw("
                LTRIM(RTRIM(COALESCE(d.district_name_thai, p.district_name_thai))) = ?
            ", [$district]);
        }

        if ($tambon !== '') {
            $base->whereRaw("
                LTRIM(RTRIM(COALESCE(t.tambon_name_thai, p.tambon_name_thai))) = ?
            ", [$tambon]);
        }

       $cropTypes = (array) $request->input('crop_type', []);

if (!empty($cropTypes)) {
    $base->where(function ($q) use ($cropTypes) {
        if (in_array('none', $cropTypes)) {
            $q->where('c.c1_1_0', 0);
        } else {
            if (in_array('rice', $cropTypes)) $q->orWhere('c.c1_1_1', '<>', 0);
            if (in_array('vegetable', $cropTypes)) $q->orWhere('c.c1_1_2', '<>', 0);
            if (in_array('fruit', $cropTypes)) $q->orWhere('c.c1_1_3', '<>', 0);
            if (in_array('field_crop', $cropTypes)) $q->orWhere('c.c1_1_4', '<>', 0);
            if (in_array('industrial', $cropTypes)) $q->orWhere('c.c1_1_5', '<>', 0);
        }
    });
}

$livestockTypes = (array) $request->input('livestock_type', []);

if (!empty($livestockTypes)) {
    $base->where(function ($q) use ($livestockTypes) {
        if (in_array('none', $livestockTypes)) {
            $q->where('c.c1_2_0', 0);
        } else {
            if (in_array('poultry', $livestockTypes)) $q->orWhere('c.c1_2_1', '<>', 0);
            if (in_array('pig_goat', $livestockTypes)) $q->orWhere('c.c1_2_2', '<>', 0);
            if (in_array('cattle', $livestockTypes)) $q->orWhere('c.c1_2_3', '<>', 0);
            if (in_array('other', $livestockTypes)) $q->orWhere('c.c1_2_4', '<>', 0);
        }
    });
}

$fisheryTypes = (array) $request->input('fishery_type', []);

if (!empty($fisheryTypes)) {
    $base->where(function ($q) use ($fisheryTypes) {
        if (in_array('none', $fisheryTypes)) {
            $q->where('c.c1_3_0', 0);
        } else {
            if (in_array('sea', $fisheryTypes)) $q->orWhere('c.c1_3_1', '<>', 0);
            if (in_array('fresh', $fisheryTypes)) $q->orWhere('c.c1_3_2', '<>', 0);
        }
    });
}

        if ($request->filled('income_min')) {
            $base->where('c.c2_1', '>=', $request->income_min);
        }

        if ($request->filled('income_max')) {
            $base->where('c.c2_1', '<=', $request->income_max);
        }

        $rows = (clone $base)
            ->select([
                'c.HC',
                'c.survey_year',

                DB::raw("COALESCE(NULLIF(LTRIM(RTRIM(d.district_name_thai)), ''), NULLIF(LTRIM(RTRIM(p.district_name_thai)), '')) as district_name_thai"),
                DB::raw("COALESCE(NULLIF(LTRIM(RTRIM(t.tambon_name_thai)), ''), NULLIF(LTRIM(RTRIM(p.tambon_name_thai)), '')) as tambon_name_thai"),

                'c.c1_1_0','c.c1_1_1','c.c1_1_2','c.c1_1_2_0','c.c1_1_3','c.c1_1_3_0','c.c1_1_4','c.c1_1_5',
                'c.c1_2_0','c.c1_2_1','c.c1_2_2','c.c1_2_3','c.c1_2_4','c.c1_2_4_0',
                'c.c1_3_0','c.c1_3_1','c.c1_3_2',
                'c.c2_1','c.c2_2','c.c2_3',
            ])
            ->orderByDesc('c.survey_year')
            ->orderBy('c.HC')
            ->paginate(20)
            ->withQueryString();

        $years = $conn->table('PPAOS93.dbo.survey_c')
            ->whereNotNull('survey_year')
            ->distinct()
            ->orderByDesc('survey_year')
            ->pluck('survey_year');

        $districts = $conn->table('PPAOS93.dbo.district')
            ->selectRaw("DISTINCT LTRIM(RTRIM(district_name_thai)) as district_name")
            ->whereRaw("LTRIM(RTRIM(district_name_thai)) <> ''")
            ->orderBy('district_name')
            ->pluck('district_name');

        $tambons = collect();

        if ($district !== '') {
            $tambons = $conn
                ->table('PPAOS93.dbo.tambon as t')
                ->leftJoin('PPAOS93.dbo.district as d', 't.district_id', '=', 'd.district_id')
                ->whereRaw("LTRIM(RTRIM(d.district_name_thai)) = ?", [$district])
                ->selectRaw("DISTINCT LTRIM(RTRIM(t.tambon_name_thai)) as tambon_name")
                ->whereRaw("LTRIM(RTRIM(t.tambon_name_thai)) <> ''")
                ->orderBy('tambon_name')
                ->pluck('tambon_name');
        }

        $summary = (clone $base)
            ->selectRaw("
                COUNT(*) as total_households,

                SUM(CASE WHEN c.c1_1_1 <> 0 THEN 1 ELSE 0 END) as rice,
                SUM(CASE WHEN c.c1_1_2 <> 0 THEN 1 ELSE 0 END) as vegetable,
                SUM(CASE WHEN c.c1_1_3 <> 0 THEN 1 ELSE 0 END) as fruit,
                SUM(CASE WHEN c.c1_1_4 <> 0 THEN 1 ELSE 0 END) as field_crop,
                SUM(CASE WHEN c.c1_1_5 <> 0 THEN 1 ELSE 0 END) as industrial_crop,

                SUM(CASE WHEN c.c1_2_1 <> 0 THEN 1 ELSE 0 END) as poultry,
                SUM(CASE WHEN c.c1_2_2 <> 0 THEN 1 ELSE 0 END) as pig_goat,
                SUM(CASE WHEN c.c1_2_3 <> 0 THEN 1 ELSE 0 END) as cattle,
                SUM(CASE WHEN c.c1_2_4 <> 0 THEN 1 ELSE 0 END) as other_livestock,

                SUM(CASE WHEN c.c1_3_1 <> 0 THEN 1 ELSE 0 END) as sea_fishery,
                SUM(CASE WHEN c.c1_3_2 <> 0 THEN 1 ELSE 0 END) as fresh_fishery,

                SUM(COALESCE(c.c2_1, 0)) as income_outside_area,
                SUM(COALESCE(c.c2_2, 0)) as cost_outside_area,
                SUM(COALESCE(c.c2_3, 0)) as income_children
            ")
            ->first();

        $cropChart = [
            ['name' => 'ทำนา', 'value' => (int)($summary->rice ?? 0)],
            ['name' => 'ทำสวนผัก', 'value' => (int)($summary->vegetable ?? 0)],
            ['name' => 'ทำสวนผลไม้', 'value' => (int)($summary->fruit ?? 0)],
            ['name' => 'พืชไร่', 'value' => (int)($summary->field_crop ?? 0)],
            ['name' => 'พืชอุตสาหกรรม', 'value' => (int)($summary->industrial_crop ?? 0)],
        ];

        $livestockChart = [
            ['name' => 'สัตว์ปีก', 'value' => (int)($summary->poultry ?? 0)],
            ['name' => 'หมู/แพะ/แกะ/ลา/ล่อ', 'value' => (int)($summary->pig_goat ?? 0)],
            ['name' => 'วัว/ควาย/ม้า', 'value' => (int)($summary->cattle ?? 0)],
            ['name' => 'อื่น ๆ', 'value' => (int)($summary->other_livestock ?? 0)],
        ];

        $fisheryChart = [
            ['name' => 'ประมงน้ำเค็ม', 'value' => (int)($summary->sea_fishery ?? 0)],
            ['name' => 'ประมงน้ำจืด', 'value' => (int)($summary->fresh_fishery ?? 0)],
        ];

        $incomeCompareChart = [
            ['name' => 'รายได้นอกภาคเกษตร', 'value' => (float)($summary->income_outside_area ?? 0)],
            ['name' => 'ต้นทุน', 'value' => (float)($summary->cost_outside_area ?? 0)],
            ['name' => 'ลูกหลานส่งกลับ', 'value' => (float)($summary->income_children ?? 0)],
        ];

        $districtIncome = (clone $base)
            ->selectRaw("
                COALESCE(
                    NULLIF(LTRIM(RTRIM(d.district_name_thai)), ''),
                    NULLIF(LTRIM(RTRIM(p.district_name_thai)), ''),
                    'ไม่ระบุอำเภอ'
                ) as district,
                AVG(COALESCE(c.c2_1, 0)) as avg_income
            ")
            ->groupByRaw("
                COALESCE(
                    NULLIF(LTRIM(RTRIM(d.district_name_thai)), ''),
                    NULLIF(LTRIM(RTRIM(p.district_name_thai)), ''),
                    'ไม่ระบุอำเภอ'
                )
            ")
            ->orderByDesc('avg_income')
            ->limit(10)
            ->get();

        return view('economy.index', compact(
            'rows',
            'years',
            'districts',
            'tambons',
            'summary',
            'cropChart',
            'livestockChart',
            'fisheryChart',
            'incomeCompareChart',
            'districtIncome'
        ));
    }
public function export(Request $request)
{
    $district = trim((string)($request->district_name_thai ?? ''));
    $tambon   = trim((string)($request->tambon_name_thai ?? ''));

    $conn = DB::connection('sqlsrv');

    $profileSub = $conn->table('PPAOS93.dbo.survey_profile64')
        ->selectRaw("
            HC,
            MIN(AMP) as AMP,
            MIN(TMP) as TMP,
            MIN(district_name_thai) as district_name_thai,
            MIN(tambon_name_thai) as tambon_name_thai
        ")
        ->whereNotNull('HC')
        ->groupBy('HC');

    $base = $conn
        ->table('PPAOS93.dbo.survey_c as c')
        ->leftJoinSub($profileSub, 'p', function ($join) {
            $join->on(
                DB::raw("LTRIM(RTRIM(p.HC))"),
                '=',
                DB::raw("LTRIM(RTRIM(c.HC))")
            );
        })
        ->leftJoin('PPAOS93.dbo.district as d', function ($join) {
            $join->on(
                DB::raw("LTRIM(RTRIM(p.AMP))"),
                '=',
                DB::raw("d.district_id")
            );
        })
        ->leftJoin('PPAOS93.dbo.tambon as t', function ($join) {
            $join->on(
                DB::raw("LEFT(LTRIM(RTRIM(p.TMP)), 7)"),
                '=',
                DB::raw("t.tambon_id")
            );
        });

    if ($request->filled('survey_year')) {
        $base->where('c.survey_year', $request->survey_year);
    }

    if ($request->filled('hc')) {
        $base->where('c.HC', 'like', '%' . $request->hc . '%');
    }

    if ($district !== '') {
        $base->whereRaw("
            LTRIM(RTRIM(COALESCE(d.district_name_thai, p.district_name_thai))) = ?
        ", [$district]);
    }

    if ($tambon !== '') {
        $base->whereRaw("
            LTRIM(RTRIM(COALESCE(t.tambon_name_thai, p.tambon_name_thai))) = ?
        ", [$tambon]);
    }

    $rows = $base
        ->select([
            'c.HC',
            'c.survey_year',

            DB::raw("COALESCE(NULLIF(LTRIM(RTRIM(d.district_name_thai)), ''), NULLIF(LTRIM(RTRIM(p.district_name_thai)), '')) as district_name_thai"),

            DB::raw("COALESCE(NULLIF(LTRIM(RTRIM(t.tambon_name_thai)), ''), NULLIF(LTRIM(RTRIM(p.tambon_name_thai)), '')) as tambon_name_thai"),

            'c.c1_1_0','c.c1_1_1','c.c1_1_2','c.c1_1_2_0',
            'c.c1_1_3','c.c1_1_3_0','c.c1_1_4','c.c1_1_5',

            'c.c1_2_0','c.c1_2_1','c.c1_2_2',
            'c.c1_2_3','c.c1_2_4','c.c1_2_4_0',

            'c.c1_3_0','c.c1_3_1','c.c1_3_2',

            'c.c2_1','c.c2_2','c.c2_3',
        ])
        ->orderByDesc('c.survey_year')
        ->orderBy('c.HC')
        ->get();

    $filename = 'ข้อมูลด้านเศรษฐกิจจังหวัดพัทลุง_' .
                ($request->survey_year ?? 'ทั้งหมด') .
                '.xlsx';

    return \Maatwebsite\Excel\Facades\Excel::download(
        new \App\Exports\EconomyExport($rows),
        $filename
    );
}
}