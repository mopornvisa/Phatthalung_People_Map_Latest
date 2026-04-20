<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CopdMortalityExport implements FromView, ShouldAutoSize
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $year     = trim((string) $this->request->get('year', ''));
        $district = trim((string) $this->request->get('district', ''));

        $rows = collect();

        if ($year !== '') {
            $rows = DB::connection('mysql_help')
                ->table('health_copd_mortality_all')
                ->where('survey_year', $year)
                ->when($district !== '', function ($q) use ($district) {
                    $q->where('district_name_thai', $district);
                })
                ->select(
                    'district_name_thai',
                    'patient_copd_total',
                    'death_copd_total',
                    'percentage_total',
                    'patient_copd_total1',
                    'death_copd_total1',
                    'percentage_total1',
                    'patient_copd_total2',
                    'death_copd_total2',
                    'percentage_total2',
                    'patient_copd_total3',
                    'death_copd_total3',
                    'percentage_total3',
                    'patient_copd_total4',
                    'death_copd_total4',
                    'percentage_total4',
                    'patient_copd_total5',
                    'death_copd_total5',
                    'percentage_total5'
                )
                ->orderBy('district_name_thai')
                ->limit(50)
                ->get();
        }

        $summary = (object) [
            'patient_copd_total_sum' => (float) $rows->sum('patient_copd_total'),
            'death_copd_total_sum'   => (float) $rows->sum('death_copd_total'),
        ];

        $overallRate = $summary->patient_copd_total_sum > 0
            ? ($summary->death_copd_total_sum / $summary->patient_copd_total_sum) * 100
            : 0;

        $sumPatient1 = (float) $rows->sum('patient_copd_total1');
        $sumDeath1   = (float) $rows->sum('death_copd_total1');
        $sumRate1    = $sumPatient1 > 0 ? ($sumDeath1 / $sumPatient1) * 100 : 0;

        $sumPatient2 = (float) $rows->sum('patient_copd_total2');
        $sumDeath2   = (float) $rows->sum('death_copd_total2');
        $sumRate2    = $sumPatient2 > 0 ? ($sumDeath2 / $sumPatient2) * 100 : 0;

        $sumPatient3 = (float) $rows->sum('patient_copd_total3');
        $sumDeath3   = (float) $rows->sum('death_copd_total3');
        $sumRate3    = $sumPatient3 > 0 ? ($sumDeath3 / $sumPatient3) * 100 : 0;

        $sumPatient4 = (float) $rows->sum('patient_copd_total4');
        $sumDeath4   = (float) $rows->sum('death_copd_total4');
        $sumRate4    = $sumPatient4 > 0 ? ($sumDeath4 / $sumPatient4) * 100 : 0;

        $sumPatient5 = (float) $rows->sum('patient_copd_total5');
        $sumDeath5   = (float) $rows->sum('death_copd_total5');
        $sumRate5    = $sumPatient5 > 0 ? ($sumDeath5 / $sumPatient5) * 100 : 0;

        return view('exports.copd_mortality_excel', compact(
            'rows',
            'year',
            'district',
            'summary',
            'overallRate',
            'sumPatient1',
            'sumDeath1',
            'sumRate1',
            'sumPatient2',
            'sumDeath2',
            'sumRate2',
            'sumPatient3',
            'sumDeath3',
            'sumRate3',
            'sumPatient4',
            'sumDeath4',
            'sumRate4',
            'sumPatient5',
            'sumDeath5',
            'sumRate5'
        ));
    }
}