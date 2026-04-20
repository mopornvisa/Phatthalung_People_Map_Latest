<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CopdIncidence100kExport;

class CopdIncidence100kController extends Controller
{
    public function index(Request $request)
    {
        $table = 'health_copd_incidence_100k_all';
        $conn = DB::connection('mysql_help');

        $yearList = $conn->table($table)
            ->select('survey_year')
            ->distinct()
            ->orderBy('survey_year', 'desc')
            ->pluck('survey_year');

        $districtList = $conn->table($table)
            ->select('district_name_thai')
            ->distinct()
            ->orderBy('district_name_thai')
            ->pluck('district_name_thai');

        $year = $request->get('year');
        $district = $request->get('district', '');

        if (!$year && $yearList->count()) {
            $year = $yearList->first();
        }

        $baseQuery = $conn->table($table);

        if ($year) {
            $baseQuery->where('survey_year', $year);
        }

        if ($district) {
            $baseQuery->where('district_name_thai', $district);
        }

        $rows = (clone $baseQuery)
            ->select([
                'survey_year',
                'district_name_thai',
                'population_civil_registry',
                'patient_copd_total',
                'rate_per_100k',
                'month10','month11','month12',
                'month1','month2','month3','month4','month5','month6','month7','month8','month9',
            ])
            ->orderBy('district_name_thai')
            ->get();

        $summaryRow = (clone $baseQuery)
            ->selectRaw('
                COALESCE(SUM(population_civil_registry),0) as pop,
                COALESCE(SUM(patient_copd_total),0) as `case`,
                COALESCE(SUM(month10),0) as month10,
                COALESCE(SUM(month11),0) as month11,
                COALESCE(SUM(month12),0) as month12,
                COALESCE(SUM(month1),0) as month1,
                COALESCE(SUM(month2),0) as month2,
                COALESCE(SUM(month3),0) as month3,
                COALESCE(SUM(month4),0) as month4,
                COALESCE(SUM(month5),0) as month5,
                COALESCE(SUM(month6),0) as month6,
                COALESCE(SUM(month7),0) as month7,
                COALESCE(SUM(month8),0) as month8,
                COALESCE(SUM(month9),0) as month9
            ')
            ->first();

        $summary = [
            'pop' => (float)($summaryRow->pop ?? 0),
            'case' => (float)($summaryRow->case ?? 0),
            'month1' => (float)($summaryRow->month1 ?? 0),
            'month2' => (float)($summaryRow->month2 ?? 0),
            'month3' => (float)($summaryRow->month3 ?? 0),
            'month4' => (float)($summaryRow->month4 ?? 0),
            'month5' => (float)($summaryRow->month5 ?? 0),
            'month6' => (float)($summaryRow->month6 ?? 0),
            'month7' => (float)($summaryRow->month7 ?? 0),
            'month8' => (float)($summaryRow->month8 ?? 0),
            'month9' => (float)($summaryRow->month9 ?? 0),
            'month10' => (float)($summaryRow->month10 ?? 0),
            'month11' => (float)($summaryRow->month11 ?? 0),
            'month12' => (float)($summaryRow->month12 ?? 0),
        ];

        $summary['rate'] = $summary['pop'] > 0
            ? ($summary['case'] / $summary['pop']) * 100000
            : 0;

        return view('health.copd_incidence_100k', compact(
            'rows','summary','year','district','yearList','districtList'
        ));
    }

    public function export(Request $request)
    {
        return Excel::download(
            new CopdIncidence100kExport(
                $request->get('year'),
                $request->get('district')
            ),
            'อัตราป่วยโรคปอดอุดกั้นเรื้อรัง.xlsx'
        );
    }
}