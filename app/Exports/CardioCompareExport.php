<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class CardioCompareExport implements FromView
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
        $conn = DB::connection('mysql_help');
        $table = 'health_cardio_yearly';

        $year = trim((string)$this->year);
        $district = trim((string)$this->district);

        if ($district === 'ทุกอำเภอ' || strtolower($district) === 'all') {
            $district = '';
        }

        $yearNew = $year !== '' ? ((int)$year + 1) : '';

        $query = $conn->table($table . ' as old');

        if ($year !== '') {
            $query->where('old.survey_year', $year);
        }

        if (!empty($district)) {
            $query->where('old.district_name_thai', $district);
        }

        $rows = $query
            ->leftJoin($table . ' as n', function ($join) use ($yearNew) {
                $join->on('old.district_name_thai', '=', 'n.district_name_thai');

                if ($yearNew !== '') {
                    $join->where('n.survey_year', $yearNew);
                }
            })
            ->selectRaw("
                old.survey_year as year_old,
                old.district_name_thai,

                old.population_civil_registry as population_old,
                old.patient_total as patient_old,
                old.rate_per_100k as rate_old,

                n.survey_year as year_new,
                COALESCE(n.population_civil_registry,0) as population_new,
                COALESCE(n.patient_total,0) as patient_new,
                COALESCE(n.rate_per_100k,0) as rate_new,

                CASE
                    WHEN COALESCE(old.rate_per_100k,0) > 0
                    THEN ROUND(
                        ((old.rate_per_100k - COALESCE(n.rate_per_100k,0))
                        / old.rate_per_100k) * 100
                    ,2)
                    ELSE 0
                END as cardio
            ")
            ->orderByRaw("
                FIELD(old.district_name_thai,
                'เมืองพัทลุง','กงหรา','เขาชัยสน','ตะโหมด','ควนขนุน',
                'ปากพะยูน','ศรีบรรพต','ป่าบอน','บางแก้ว','ป่าพะยอม','ศรีนครินทร์')
            ")
            ->get();

        $sumOldPopulation = (float)$rows->sum('population_old');
        $sumOldPatient    = (float)$rows->sum('patient_old');

        $sumNewPopulation = (float)$rows->sum('population_new');
        $sumNewPatient    = (float)$rows->sum('patient_new');

        $rateOldSummary = $sumOldPopulation > 0
            ? ($sumOldPatient / $sumOldPopulation) * 100000
            : 0;

        $rateNewSummary = $sumNewPopulation > 0
            ? ($sumNewPatient / $sumNewPopulation) * 100000
            : 0;

        $cardioAvg = $rateOldSummary > 0
            ? (($rateOldSummary - $rateNewSummary) / $rateOldSummary) * 100
            : 0;

        $summary = [
            'population_old' => $sumOldPopulation,
            'patient_old'    => $sumOldPatient,
            'population_new' => $sumNewPopulation,
            'patient_new'    => $sumNewPatient,
            'rate_old'       => $rateOldSummary,
            'rate_new'       => $rateNewSummary,
            'cardio_avg'     => $cardioAvg,
        ];

        return view('exports.cardio_compare_excel', [
            'rows'     => $rows,
            'summary'  => $summary,
            'year'     => $year,
            'yearNew'  => $yearNew,
            'district' => $district,
        ]);
    }
}