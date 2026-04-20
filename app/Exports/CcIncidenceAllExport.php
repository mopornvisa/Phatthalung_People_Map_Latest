<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CcIncidenceAllExport implements FromView, ShouldAutoSize
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
                ->table('health_cc_incidence_all')
                ->where('survey_year', $year)
                ->when($district !== '', function ($q) use ($district) {
                    $q->where('district_name_thai', $district);
                })
                ->select(
                    'district_name_thai',
                    'population_total',
                    'patient_cc_total',
                    'percentage_total',
                    'population_total1',
                    'patient_cc_total1',
                    'percentage_total1',
                    'population_total2',
                    'patient_cc_total2',
                    'percentage_total2',
                    'population_total3',
                    'patient_cc_total3',
                    'percentage_total3',
                    'population_total4',
                    'patient_cc_total4',
                    'percentage_total4',
                    'population_total5',
                    'patient_cc_total5',
                    'percentage_total5'
                )
                ->orderBy('district_name_thai')
                ->limit(50)
                ->get();
        }

        $summary = (object) [
            'population_total_sum' => (float) $rows->sum('population_total'),
            'patient_cc_total_sum' => (float) $rows->sum('patient_cc_total'),
        ];

        $overallRate = $summary->population_total_sum > 0
            ? ($summary->patient_cc_total_sum / $summary->population_total_sum) * 100
            : 0;

        $sumPopulation1 = (float) $rows->sum('population_total1');
        $sumPatient1    = (float) $rows->sum('patient_cc_total1');
        $sumRate1       = $sumPopulation1 > 0 ? ($sumPatient1 / $sumPopulation1) * 100 : 0;

        $sumPopulation2 = (float) $rows->sum('population_total2');
        $sumPatient2    = (float) $rows->sum('patient_cc_total2');
        $sumRate2       = $sumPopulation2 > 0 ? ($sumPatient2 / $sumPopulation2) * 100 : 0;

        $sumPopulation3 = (float) $rows->sum('population_total3');
        $sumPatient3    = (float) $rows->sum('patient_cc_total3');
        $sumRate3       = $sumPopulation3 > 0 ? ($sumPatient3 / $sumPopulation3) * 100 : 0;

        $sumPopulation4 = (float) $rows->sum('population_total4');
        $sumPatient4    = (float) $rows->sum('patient_cc_total4');
        $sumRate4       = $sumPopulation4 > 0 ? ($sumPatient4 / $sumPopulation4) * 100 : 0;

        $sumPopulation5 = (float) $rows->sum('population_total5');
        $sumPatient5    = (float) $rows->sum('patient_cc_total5');
        $sumRate5       = $sumPopulation5 > 0 ? ($sumPatient5 / $sumPopulation5) * 100 : 0;

        return view('exports.cc_incidence_all_excel', compact(
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