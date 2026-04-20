<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CardioCompareExport;

class CardioCompareController extends Controller
{
    public function index(Request $request)
    {
        $conn = DB::connection('mysql_help');
        $table = 'health_cardio_yearly';

        // =========================
        // รายการปี
        // =========================
        $yearList = $conn->table($table)
            ->select('survey_year')
            ->whereNotNull('survey_year')
            ->distinct()
            ->orderBy('survey_year', 'desc')
            ->pluck('survey_year')
            ->values();

        // =========================
        // รายการอำเภอ
        // =========================
        $districtList = $conn->table($table)
            ->select('district_name_thai')
            ->whereNotNull('district_name_thai')
            ->distinct()
            ->orderByRaw("
                FIELD(district_name_thai,
                'เมืองพัทลุง','กงหรา','เขาชัยสน','ตะโหมด','ควนขนุน',
                'ปากพะยูน','ศรีบรรพต','ป่าบอน','บางแก้ว','ป่าพะยอม','ศรีนครินทร์')
            ")
            ->pluck('district_name_thai')
            ->values();

        // =========================
        // รับค่า filter
        // =========================
        $year = trim((string)$request->get('year', $yearList->first() ?? ''));
        $district = trim((string)$request->get('district', ''));

        if ($district === 'ทุกอำเภอ' || strtolower($district) === 'all') {
            $district = '';
        }

        $yearNew = $year !== '' ? ((int)$year + 1) : '';

        // =========================
        // Query หลัก
        // =========================
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

        // =========================
        // สรุปผล
        // =========================
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

        return view('health.cardio_compare', compact(
            'rows',
            'summary',
            'year',
            'yearNew',
            'district',
            'yearList',
            'districtList'
        ));
    }

    public function export(Request $request)
    {
        $year = trim((string)$request->get('year', ''));
        $district = trim((string)$request->get('district', ''));

        if ($district === 'ทุกอำเภอ' || strtolower($district) === 'all') {
            $district = '';
        }

        $fileName = 'อัตราป่วยโรคหลอดเลือดหัวใจลดลง_' . ($year ?: 'all') . '.xlsx';

        return Excel::download(
            new CardioCompareExport($year, $district),
            $fileName
        );
    }
}