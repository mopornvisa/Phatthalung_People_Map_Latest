<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CcIncidenceAllExport;

class CcIncidenceAllController extends Controller
{
    public function index(Request $request)
    {
        set_time_limit(120);
        ini_set('memory_limit', '512M');

        $table = 'health_cc_incidence_all';
        $conn  = DB::connection('mysql_help');

        $year     = $request->get('year', 2569);
        $district = trim((string) $request->get('district', ''));

        $districtList = $conn->table($table)
            ->select('district_name_thai')
            ->whereNotNull('district_name_thai')
            ->where('district_name_thai', '!=', '')
            ->distinct()
            ->orderBy('district_name_thai')
            ->pluck('district_name_thai')
            ->values();

        $yearList = $conn->table($table)
            ->select('survey_year')
            ->whereNotNull('survey_year')
            ->distinct()
            ->orderBy('survey_year')
            ->pluck('survey_year')
            ->values();

        $rows = $conn->table($table)
            ->when($year !== '', function ($q) use ($year) {
                $q->where('survey_year', $year);
            })
            ->when($district !== '', function ($q) use ($district) {
                $q->where('district_name_thai', $district);
            })
            ->selectRaw("
                district_name_thai,

                SUM(IFNULL(population_total, 0)) as population_total,
                SUM(IFNULL(patient_cc_total, 0)) as patient_cc_total,
                CASE
                    WHEN SUM(IFNULL(population_total, 0)) = 0 THEN 0
                    ELSE (SUM(IFNULL(patient_cc_total, 0)) * 100.0) / SUM(IFNULL(population_total, 0))
                END as percentage_total,

                SUM(IFNULL(population_total1, 0)) as population_total1,
                SUM(IFNULL(patient_cc_total1, 0)) as patient_cc_total1,
                CASE
                    WHEN SUM(IFNULL(population_total1, 0)) = 0 THEN 0
                    ELSE (SUM(IFNULL(patient_cc_total1, 0)) * 100.0) / SUM(IFNULL(population_total1, 0))
                END as percentage_total1,

                SUM(IFNULL(population_total2, 0)) as population_total2,
                SUM(IFNULL(patient_cc_total2, 0)) as patient_cc_total2,
                CASE
                    WHEN SUM(IFNULL(population_total2, 0)) = 0 THEN 0
                    ELSE (SUM(IFNULL(patient_cc_total2, 0)) * 100.0) / SUM(IFNULL(population_total2, 0))
                END as percentage_total2,

                SUM(IFNULL(population_total3, 0)) as population_total3,
                SUM(IFNULL(patient_cc_total3, 0)) as patient_cc_total3,
                CASE
                    WHEN SUM(IFNULL(population_total3, 0)) = 0 THEN 0
                    ELSE (SUM(IFNULL(patient_cc_total3, 0)) * 100.0) / SUM(IFNULL(population_total3, 0))
                END as percentage_total3,

                SUM(IFNULL(population_total4, 0)) as population_total4,
                SUM(IFNULL(patient_cc_total4, 0)) as patient_cc_total4,
                CASE
                    WHEN SUM(IFNULL(population_total4, 0)) = 0 THEN 0
                    ELSE (SUM(IFNULL(patient_cc_total4, 0)) * 100.0) / SUM(IFNULL(population_total4, 0))
                END as percentage_total4,

                SUM(IFNULL(population_total5, 0)) as population_total5,
                SUM(IFNULL(patient_cc_total5, 0)) as patient_cc_total5,
                CASE
                    WHEN SUM(IFNULL(population_total5, 0)) = 0 THEN 0
                    ELSE (SUM(IFNULL(patient_cc_total5, 0)) * 100.0) / SUM(IFNULL(population_total5, 0))
                END as percentage_total5
            ")
            ->groupBy('district_name_thai')
            ->orderBy('district_name_thai')
            ->get();

        $summary = (object) [
            'population_total_sum' => (float) $rows->sum('population_total'),
            'patient_cc_total_sum' => (float) $rows->sum('patient_cc_total'),
        ];

        $overallRate = $summary->population_total_sum > 0
            ? (($summary->patient_cc_total_sum * 100) / $summary->population_total_sum)
            : 0;

        return view('health.cc_incidence_all', compact(
            'rows',
            'summary',
            'districtList',
            'yearList',
            'district',
            'year',
            'overallRate'
        ));
    }

    public function export(Request $request)
    {
        $year = $request->get('year', 'all');

        return Excel::download(
            new CcIncidenceAllExport($request),
            'อัตราป่วยโรคมะเร็งปากมดลูก' . $year . '.xlsx'
        );
    }
}