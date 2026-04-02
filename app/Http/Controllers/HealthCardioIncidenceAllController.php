<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HealthCardioIncidenceAllExport;

class HealthCardioIncidenceAllController extends Controller
{
    public function index(Request $request)
    {
        $year     = trim((string) $request->get('year', ''));
        $district = trim((string) $request->get('district', ''));

        $yearList = collect([2565, 2566, 2567, 2568, 2569])->sortDesc()->values();

        if ($year === '') {
            $year = (string) $yearList->first();
        }

        $districtList = collect([
            'เมืองพัทลุง',
            'กงหรา',
            'เขาชัยสน',
            'ควนขนุน',
            'ตะโหมด',
            'บางแก้ว',
            'ปากพะยูน',
            'ศรีบรรพต',
            'ป่าบอน',
            'ป่าพะยอม',
            'ศรีนครินทร์',
        ]);

        $rowsCollection = DB::connection('mysql_help')
            ->table('health_cardio_incidence_all')
            ->where('survey_year', $year)
            ->when($district !== '', function ($q) use ($district) {
                $q->where('district_name_thai', $district);
            })
            ->select(
                'district_name_thai',
                'population_total',
                'patient_cardio_total',
                'percentage_total',
                'population_total1',
                'patient_cardio_total1',
                'percentage_total1',
                'population_total2',
                'patient_cardio_total2',
                'percentage_total2',
                'population_total3',
                'patient_cardio_total3',
                'percentage_total3',
                'population_total4',
                'patient_cardio_total4',
                'percentage_total4',
                'population_total5',
                'patient_cardio_total5',
                'percentage_total5'
            )
            ->orderBy('district_name_thai')
            ->limit(50)
            ->get();

        $rows = new LengthAwarePaginator(
            $rowsCollection,
            $rowsCollection->count(),
            50,
            1,
            [
                'path' => url()->current(),
                'query' => array_merge($request->query(), ['year' => $year]),
            ]
        );

        $summary = (object) [
            'population_total_sum'     => (float) $rowsCollection->sum('population_total'),
            'patient_cardio_total_sum' => (float) $rowsCollection->sum('patient_cardio_total'),
        ];

        $overallRate = $summary->population_total_sum > 0
            ? ($summary->patient_cardio_total_sum / $summary->population_total_sum) * 100
            : 0;

        $sumPopulation1 = (float) $rowsCollection->sum('population_total1');
        $sumPatient1    = (float) $rowsCollection->sum('patient_cardio_total1');
        $sumRate1       = $sumPopulation1 > 0 ? ($sumPatient1 / $sumPopulation1) * 100 : 0;

        $sumPopulation2 = (float) $rowsCollection->sum('population_total2');
        $sumPatient2    = (float) $rowsCollection->sum('patient_cardio_total2');
        $sumRate2       = $sumPopulation2 > 0 ? ($sumPatient2 / $sumPopulation2) * 100 : 0;

        $sumPopulation3 = (float) $rowsCollection->sum('population_total3');
        $sumPatient3    = (float) $rowsCollection->sum('patient_cardio_total3');
        $sumRate3       = $sumPopulation3 > 0 ? ($sumPatient3 / $sumPopulation3) * 100 : 0;

        $sumPopulation4 = (float) $rowsCollection->sum('population_total4');
        $sumPatient4    = (float) $rowsCollection->sum('patient_cardio_total4');
        $sumRate4       = $sumPopulation4 > 0 ? ($sumPatient4 / $sumPopulation4) * 100 : 0;

        $sumPopulation5 = (float) $rowsCollection->sum('population_total5');
        $sumPatient5    = (float) $rowsCollection->sum('patient_cardio_total5');
        $sumRate5       = $sumPopulation5 > 0 ? ($sumPatient5 / $sumPopulation5) * 100 : 0;

        return view('health.cardio_incidence_all', compact(
            'rows',
            'year',
            'district',
            'yearList',
            'districtList',
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

    public function export(Request $request)
    {
        $year = trim((string) $request->get('year', ''));

        if ($year === '') {
            $year = '2569';
        }

        $fileName = 'อัตราป่วยด้วยโรคหัวใจและหลอดเลือดต่อประชากร ' . $year . '.xlsx';

        return Excel::download(
            new HealthCardioIncidenceAllExport($request),
            $fileName
        );
    }
}