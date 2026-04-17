<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DmIncidence100kExport;

class DmIncidence100kController extends Controller
{
    public function index(Request $request)
    {
        $table = 'health_dm_incidence_100k_all';
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

        if ($year !== null && $year !== '') {
            $baseQuery->where('survey_year', $year);
        }

        if ($district !== null && $district !== '') {
            $baseQuery->where('district_name_thai', $district);
        }

        $rows = (clone $baseQuery)
            ->select([
                'survey_year',
                'district_name_thai',
                'population_civil_registry',
                'patient_dm_total',
                'rate_per_100k',
                'month10',
                'month11',
                'month12',
                'month1',
                'month2',
                'month3',
                'month4',
                'month5',
                'month6',
                'month7',
                'month8',
                'month9',
            ])
            ->orderBy('district_name_thai')
            ->get();

        $summary = (clone $baseQuery)
            ->selectRaw('
                COALESCE(SUM(population_civil_registry),0) as pop,
                COALESCE(SUM(patient_dm_total),0) as `case`,
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
            'pop'     => (float) ($summary->pop ?? 0),
            'case'    => (float) ($summary->case ?? 0),
            'month10' => (float) ($summary->month10 ?? 0),
            'month11' => (float) ($summary->month11 ?? 0),
            'month12' => (float) ($summary->month12 ?? 0),
            'month1'  => (float) ($summary->month1 ?? 0),
            'month2'  => (float) ($summary->month2 ?? 0),
            'month3'  => (float) ($summary->month3 ?? 0),
            'month4'  => (float) ($summary->month4 ?? 0),
            'month5'  => (float) ($summary->month5 ?? 0),
            'month6'  => (float) ($summary->month6 ?? 0),
            'month7'  => (float) ($summary->month7 ?? 0),
            'month8'  => (float) ($summary->month8 ?? 0),
            'month9'  => (float) ($summary->month9 ?? 0),
        ];

        $summary['rate'] = $summary['pop'] > 0
            ? (($summary['case'] / $summary['pop']) * 100000)
            : 0;

        return view('health.dm_incidence_100k', compact(
            'rows',
            'summary',
            'year',
            'district',
            'yearList',
            'districtList'
        ));
    }

    public function export(Request $request)
    {
        $year = $request->get('year', '');
        $district = $request->get('district', '');

        $filename = 'อัตราป่วยรายใหม่โรคเบาหวาน';
        if ($year !== '') {
            $filename .= '_' . $year;
        }
        if ($district !== '') {
            $filename .= '_' . str_replace(' ', '_', $district);
        }
        $filename .= '.xlsx';

        return Excel::download(
            new DmIncidence100kExport($year, $district),
            $filename
        );
    }
}