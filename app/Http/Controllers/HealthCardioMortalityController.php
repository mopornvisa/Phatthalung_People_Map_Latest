<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CardioMortalityExport;

class HealthCardioMortalityController extends Controller
{
    public function index(Request $request)
    {
        $year     = trim((string) $request->get('year', ''));
        $district = trim((string) $request->get('district', ''));

        $yearList = DB::connection('mysql_help')
            ->table('health_cardio_mortality_all')
            ->select('survey_year')
            ->whereNotNull('survey_year')
            ->distinct()
            ->orderByDesc('survey_year')
            ->pluck('survey_year');

        // ถ้ายังไม่ได้เลือกปี ให้ default เป็นปีล่าสุด
        if ($year === '' && $yearList->count() > 0) {
            $year = (string) $yearList->first();
        }

        $districtList = DB::connection('mysql_help')
            ->table('health_cardio_mortality_all')
            ->select('district_name_thai')
            ->whereNotNull('district_name_thai')
            ->where('district_name_thai', '!=', '')
            ->distinct()
            ->orderBy('district_name_thai')
            ->pluck('district_name_thai');

        $query = DB::connection('mysql_help')
            ->table('health_cardio_mortality_all');

        if ($year !== '') {
            $query->where('survey_year', $year);
        }

        if ($district !== '') {
            $query->where('district_name_thai', $district);
        }

        $rawRows = $query
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

        return view('health.cardio_mortality', compact(
            'rows',
            'yearList',
            'districtList',
            'year',
            'district',
            'summary',
            'overallRate'
        ));
    }

    public function export(Request $request)
    {
        $year = trim((string) $request->get('year', ''));
        $district = trim((string) $request->get('district', ''));

        $filename = 'อัตราจำนวนผู้ป่วยตายโรคหัวใจและหลอดเลือด '
            . ($year !== '' ? '_' . $year : '')
            . ($district !== '' ? '_' . $district : '')
            . '.xlsx';

        return Excel::download(new CardioMortalityExport($request), $filename);
    }
    
}