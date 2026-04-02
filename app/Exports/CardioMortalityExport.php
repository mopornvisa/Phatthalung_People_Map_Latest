<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class CardioMortalityExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $year     = trim((string) $this->request->get('year', ''));
        $district = trim((string) $this->request->get('district', ''));

        $rawRows = DB::connection('mysql_help')
            ->table('health_cardio_mortality_all')
            ->when($year !== '', function ($q) use ($year) {
                $q->where('survey_year', $year);
            })
            ->when($district !== '', function ($q) use ($district) {
                $q->where('district_name_thai', $district);
            })
            ->orderBy('district_name_thai')
            ->get();

        $rows = $rawRows->map(function ($r) {
            return (object) [
                'district_name_thai' => $r->district_name_thai,

                // B = ผู้ป่วย
                'population_total'  => (float) ($r->patient_cardio_chd_total ?? 0),
                'population_total1' => (float) ($r->patient_cardio_chd_total1 ?? 0),
                'population_total2' => (float) ($r->patient_cardio_chd_total2 ?? 0),
                'population_total3' => (float) ($r->patient_cardio_chd_total3 ?? 0),
                'population_total4' => (float) ($r->patient_cardio_chd_total4 ?? 0),
                'population_total5' => (float) ($r->patient_cardio_chd_total5 ?? 0),

                // A = ผู้เสียชีวิต
                'patient_cardio_total'  => (float) ($r->death_cardio_chd ?? 0),
                'patient_cardio_total1' => (float) ($r->death_cardio_chd1 ?? 0),
                'patient_cardio_total2' => (float) ($r->death_cardio_chd2 ?? 0),
                'patient_cardio_total3' => (float) ($r->death_cardio_chd3 ?? 0),
                'patient_cardio_total4' => (float) ($r->death_cardio_chd4 ?? 0),
                'patient_cardio_total5' => (float) ($r->death_cardio_chd5 ?? 0),

                // ร้อยละ
                'percentage_total'  => (float) ($r->death_cardio_chd_rate ?? 0),
                'percentage_total1' => (float) ($r->death_cardio_chd_rate1 ?? 0),
                'percentage_total2' => (float) ($r->death_cardio_chd_rate2 ?? 0),
                'percentage_total3' => (float) ($r->death_cardio_chd_rate3 ?? 0),
                'percentage_total4' => (float) ($r->death_cardio_chd_rate4 ?? 0),
                'percentage_total5' => (float) ($r->death_cardio_chd_rate5 ?? 0),
            ];
        });

        $summary = (object) [
            'population_total_sum'     => $rows->sum('population_total'),
            'patient_cardio_total_sum' => $rows->sum('patient_cardio_total'),
        ];

        $overallRate = $summary->population_total_sum > 0
            ? ($summary->patient_cardio_total_sum / $summary->population_total_sum) * 100
            : 0;

        $sumPopulation1 = $rows->sum('population_total1');
        $sumPatient1    = $rows->sum('patient_cardio_total1');
        $sumRate1       = $sumPopulation1 > 0 ? ($sumPatient1 / $sumPopulation1) * 100 : 0;

        $sumPopulation2 = $rows->sum('population_total2');
        $sumPatient2    = $rows->sum('patient_cardio_total2');
        $sumRate2       = $sumPopulation2 > 0 ? ($sumPatient2 / $sumPopulation2) * 100 : 0;

        $sumPopulation3 = $rows->sum('population_total3');
        $sumPatient3    = $rows->sum('patient_cardio_total3');
        $sumRate3       = $sumPopulation3 > 0 ? ($sumPatient3 / $sumPopulation3) * 100 : 0;

        $sumPopulation4 = $rows->sum('population_total4');
        $sumPatient4    = $rows->sum('patient_cardio_total4');
        $sumRate4       = $sumPopulation4 > 0 ? ($sumPatient4 / $sumPopulation4) * 100 : 0;

        $sumPopulation5 = $rows->sum('population_total5');
        $sumPatient5    = $rows->sum('patient_cardio_total5');
        $sumRate5       = $sumPopulation5 > 0 ? ($sumPatient5 / $sumPopulation5) * 100 : 0;

        return view('exports.cardio_mortality', compact(
            'rows',
            'year',
            'district',
            'summary',
            'overallRate',
            'sumPopulation1',
            'sumPatient1',
            'sumRate1',
            'sumPopulation2',
            'sumPatient2',
            'sumRate2',
            'sumPopulation3',
            'sumPatient3',
            'sumRate3',
            'sumPopulation4',
            'sumPatient4',
            'sumRate4',
            'sumPopulation5',
            'sumPatient5',
            'sumRate5'
        ));
    }
}