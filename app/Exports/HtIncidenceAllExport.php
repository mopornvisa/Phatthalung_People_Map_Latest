<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class HtIncidenceAllExport implements FromView
{
    protected $year;
    protected $district;

    public function __construct($year = '', $district = '')
    {
        $this->year = $year;
        $this->district = $district;
    }

    public function view(): View
    {
        $table = 'health_ht_incidence_all';
        $conn  = DB::connection('mysql_help');

        $rows = $conn->table($table)
            ->when($this->year !== '', function ($q) {
                $q->where('survey_year', $this->year);
            })
            ->when($this->district !== '', function ($q) {
                $q->where('district_name_thai', $this->district);
            })
            ->selectRaw("
                district_name_thai,

                SUM(IFNULL(population_total, 0)) as population_total,
                SUM(IFNULL(patient_ht_total, 0)) as patient_ht_total,
                CASE
                    WHEN SUM(IFNULL(population_total, 0)) = 0 THEN 0
                    ELSE (SUM(IFNULL(patient_ht_total, 0)) * 100.0) / SUM(IFNULL(population_total, 0))
                END as percentage_total,

                SUM(IFNULL(population_total1, 0)) as population_total1,
                SUM(IFNULL(patient_ht_total1, 0)) as patient_ht_total1,
                CASE
                    WHEN SUM(IFNULL(population_total1, 0)) = 0 THEN 0
                    ELSE (SUM(IFNULL(patient_ht_total1, 0)) * 100.0) / SUM(IFNULL(population_total1, 0))
                END as percentage_total1,

                SUM(IFNULL(population_total2, 0)) as population_total2,
                SUM(IFNULL(patient_ht_total2, 0)) as patient_ht_total2,
                CASE
                    WHEN SUM(IFNULL(population_total2, 0)) = 0 THEN 0
                    ELSE (SUM(IFNULL(patient_ht_total2, 0)) * 100.0) / SUM(IFNULL(population_total2, 0))
                END as percentage_total2,

                SUM(IFNULL(population_total3, 0)) as population_total3,
                SUM(IFNULL(patient_ht_total3, 0)) as patient_ht_total3,
                CASE
                    WHEN SUM(IFNULL(population_total3, 0)) = 0 THEN 0
                    ELSE (SUM(IFNULL(patient_ht_total3, 0)) * 100.0) / SUM(IFNULL(population_total3, 0))
                END as percentage_total3,

                SUM(IFNULL(population_total4, 0)) as population_total4,
                SUM(IFNULL(patient_ht_total4, 0)) as patient_ht_total4,
                CASE
                    WHEN SUM(IFNULL(population_total4, 0)) = 0 THEN 0
                    ELSE (SUM(IFNULL(patient_ht_total4, 0)) * 100.0) / SUM(IFNULL(population_total4, 0))
                END as percentage_total4,

                SUM(IFNULL(population_total5, 0)) as population_total5,
                SUM(IFNULL(patient_ht_total5, 0)) as patient_ht_total5,
                CASE
                    WHEN SUM(IFNULL(population_total5, 0)) = 0 THEN 0
                    ELSE (SUM(IFNULL(patient_ht_total5, 0)) * 100.0) / SUM(IFNULL(population_total5, 0))
                END as percentage_total5
            ")
            ->groupBy('district_name_thai')
            ->orderBy('district_name_thai')
            ->get();

        $summary = (object) [
            'population_total_sum' => $rows->sum('population_total'),
            'patient_ht_total_sum' => $rows->sum('patient_ht_total'),
        ];

        $overallRate = ($summary->population_total_sum ?? 0) > 0
            ? (($summary->patient_ht_total_sum ?? 0) * 100) / $summary->population_total_sum
            : 0;

        return view('exports.ht_incidence_all_excel', [
            'rows'        => $rows,
            'year'        => $this->year,
            'district'    => $this->district,
            'summary'     => $summary,
            'overallRate' => $overallRate,
        ]);
    }
}