<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HealthNcd;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CardioExport;

class CardioIncidenceController extends Controller
{
    public function index(Request $request)
    {
        set_time_limit(120);
        ini_set('memory_limit', '512M');

        $year     = $request->get('year', 2569);
        $district = trim((string) $request->get('district', ''));

        $districtList = HealthNcd::query()
            ->select('district_name_thai')
            ->whereNotNull('district_name_thai')
            ->where('district_name_thai', '!=', '')
            ->distinct()
            ->orderBy('district_name_thai')
            ->pluck('district_name_thai')
            ->values();

        $yearList = HealthNcd::query()
            ->select('survey_year')
            ->whereNotNull('survey_year')
            ->distinct()
            ->orderBy('survey_year')
            ->pluck('survey_year')
            ->values();

        $rows = HealthNcd::query()
            ->when($year !== '', function ($q) use ($year) {
                $q->where('survey_year', $year);
            })
            ->when($district !== '', function ($q) use ($district) {
                $q->where('district_name_thai', $district);
            })
            ->selectRaw("
                district_name_thai,
                SUM(IFNULL(patient_total, 0)) as patient_total,
                SUM(IFNULL(population_civil_registry, 0)) as population_civil_registry,

                SUM(IFNULL(month10, 0)) as month10,
                SUM(IFNULL(month11, 0)) as month11,
                SUM(IFNULL(month12, 0)) as month12,
                SUM(IFNULL(month1, 0)) as month1,
                SUM(IFNULL(month2, 0)) as month2,
                SUM(IFNULL(month3, 0)) as month3,
                SUM(IFNULL(month4, 0)) as month4,
                SUM(IFNULL(month5, 0)) as month5,
                SUM(IFNULL(month6, 0)) as month6,
                SUM(IFNULL(month7, 0)) as month7,
                SUM(IFNULL(month8, 0)) as month8,
                SUM(IFNULL(month9, 0)) as month9,

                CASE
                    WHEN SUM(IFNULL(population_civil_registry, 0)) = 0 THEN 0
                    ELSE (SUM(IFNULL(patient_total, 0)) * 100000.0) / SUM(IFNULL(population_civil_registry, 0))
                END as rate_per_100k
            ")
            ->groupBy('district_name_thai')
            ->orderBy('district_name_thai')
            ->get();

        $summaryCase = (float) $rows->sum('patient_total');
        $summaryPop  = (float) $rows->sum('population_civil_registry');
        $summaryRate = $summaryPop > 0 ? (($summaryCase * 100000) / $summaryPop) : 0;

        $summary = [
            'case'    => $summaryCase,
            'pop'     => $summaryPop,
            'rate'    => $summaryRate,

            'month10' => $rows->sum('month10'),
            'month11' => $rows->sum('month11'),
            'month12' => $rows->sum('month12'),
            'month1'  => $rows->sum('month1'),
            'month2'  => $rows->sum('month2'),
            'month3'  => $rows->sum('month3'),
            'month4'  => $rows->sum('month4'),
            'month5'  => $rows->sum('month5'),
            'month6'  => $rows->sum('month6'),
            'month7'  => $rows->sum('month7'),
            'month8'  => $rows->sum('month8'),
            'month9'  => $rows->sum('month9'),
        ];

        return view('health.cardio_incidence', compact(
            'rows',
            'summary',
            'districtList',
            'yearList',
            'district',
            'year'
        ));
    }
    public function export(Request $request)
{
    $year = $request->get('year', 'all');

    return Excel::download(
        new CardioExport($request),
        'อัตราป่วยรายใหม่โรคหัวใจและหลอดเลือด'.$year.'.xlsx'
    );
}
}