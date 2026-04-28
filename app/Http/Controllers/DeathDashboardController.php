<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\DeathDashboardExport;
use Maatwebsite\Excel\Facades\Excel;

class DeathDashboardController extends Controller
{
    public function index(Request $request)
    {
        $conn = DB::connection('mysql_help');
        $table = 'death_summary';

        $selectedYear = trim((string) $request->get('year', ''));
        $selectedDistrict = trim((string) $request->get('district', ''));
        $selectedGender = trim((string) $request->get('gender', ''));
        $selectedAgeGroup = trim((string) $request->get('age_group', ''));
        $selectedCause = trim((string) $request->get('cause_of_death', ''));

        $yearList = $conn->table($table)
            ->select('year_th')
            ->whereNotNull('year_th')
            ->distinct()
            ->orderBy('year_th', 'desc')
            ->pluck('year_th');

        $districtList = $conn->table($table)
            ->select('district_name_th')
            ->whereNotNull('district_name_th')
            ->distinct()
            ->orderBy('district_name_th')
            ->pluck('district_name_th');

        $genderList = $conn->table($table)
            ->select('sex_name_th')
            ->whereNotNull('sex_name_th')
            ->distinct()
            ->orderBy('sex_name_th')
            ->pluck('sex_name_th');

        $causeList = $conn->table($table)
            ->select('cause_of_death')
            ->whereNotNull('cause_of_death')
            ->distinct()
            ->orderBy('cause_of_death')
            ->pluck('cause_of_death');

        $ageGroupList = collect([
            '0-5',
            '6-24',
            '25-59',
            '60+',
        ]);

        $ageGroupMap = [
            '0-5'   => ['0', '1-4'],
            '6-24'  => ['5-9', '10-15', '15-19', '20-24'],
            '25-59' => ['25-29', '30-34', '35-39', '40-44', '45-49', '50-54', '55-59'],
            '60+'   => ['60-64', '65-69', '70-74', '75-79', '80-84', '85+'],
        ];

        $baseQuery = $conn->table($table);

        if ($selectedYear !== '') {
            $baseQuery->where('year_th', (int)$selectedYear);
        }

        if ($selectedDistrict !== '') {
            $baseQuery->where('district_name_th', $selectedDistrict);
        }

        if ($selectedGender !== '') {
            $baseQuery->where('sex_name_th', $selectedGender);
        }

        if ($selectedCause !== '') {
            $baseQuery->where('cause_of_death', $selectedCause);
        }

        if ($selectedAgeGroup !== '' && isset($ageGroupMap[$selectedAgeGroup])) {
            $baseQuery->whereIn('age_group', $ageGroupMap[$selectedAgeGroup]);
        }

        $totalDeaths = (clone $baseQuery)->sum('death_total');

        $maleDeaths = (clone $baseQuery)
            ->where('sex_name_th', 'ชาย')
            ->sum('death_total');

        $femaleDeaths = (clone $baseQuery)
            ->where('sex_name_th', 'หญิง')
            ->sum('death_total');

        $districtCount = (clone $baseQuery)
            ->distinct()
            ->count('district_name_th');

        $causeCount = (clone $baseQuery)
            ->distinct()
            ->count('cause_of_death');

        $monthlyData = (clone $baseQuery)
            ->select('month_no', DB::raw('SUM(death_total) as total'))
            ->groupBy('month_no')
            ->orderBy('month_no')
            ->get();

        $districtData = (clone $baseQuery)
            ->select('district_name_th', DB::raw('SUM(death_total) as total'))
            ->groupBy('district_name_th')
            ->orderByDesc('total')
            ->get();

        $causeData = (clone $baseQuery)
            ->select('cause_of_death', DB::raw('SUM(death_total) as total'))
            ->groupBy('cause_of_death')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $ageGroupChartLabels = collect([
            '0-5 ปี',
            '6-24 ปี',
            '25-59 ปี',
            '60 ปีขึ้นไป'
        ]);

        $ageGroupChartData = collect([
            (clone $baseQuery)->whereIn('age_group', $ageGroupMap['0-5'])->sum('death_total'),
            (clone $baseQuery)->whereIn('age_group', $ageGroupMap['6-24'])->sum('death_total'),
            (clone $baseQuery)->whereIn('age_group', $ageGroupMap['25-59'])->sum('death_total'),
            (clone $baseQuery)->whereIn('age_group', $ageGroupMap['60+'])->sum('death_total'),
        ]);

        $topCausesAge0_5 = (clone $baseQuery)
            ->select('cause_of_death', DB::raw('SUM(death_total) as total'))
            ->whereIn('age_group', $ageGroupMap['0-5'])
            ->groupBy('cause_of_death')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        $topCausesAge6_24 = (clone $baseQuery)
            ->select('cause_of_death', DB::raw('SUM(death_total) as total'))
            ->whereIn('age_group', $ageGroupMap['6-24'])
            ->groupBy('cause_of_death')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        $topCausesAge25_59 = (clone $baseQuery)
            ->select('cause_of_death', DB::raw('SUM(death_total) as total'))
            ->whereIn('age_group', $ageGroupMap['25-59'])
            ->groupBy('cause_of_death')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        $topCausesAge60Plus = (clone $baseQuery)
            ->select('cause_of_death', DB::raw('SUM(death_total) as total'))
            ->whereIn('age_group', $ageGroupMap['60+'])
            ->groupBy('cause_of_death')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        $monthLabels = [
            1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.',
            5 => 'พ.ค.', 6 => 'มิ.ย.', 7 => 'ก.ค.', 8 => 'ส.ค.',
            9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.',
        ];

        $monthlyChartLabels = $monthlyData->pluck('month_no')
            ->map(fn($m) => $monthLabels[(int)$m] ?? $m)
            ->values();

        $monthlyChartData = $monthlyData->pluck('total')->values();

        $districtChartLabels = $districtData->pluck('district_name_th')->values();
        $districtChartData = $districtData->pluck('total')->values();

        $causeChartLabels = $causeData->pluck('cause_of_death')->values();
        $causeChartData = $causeData->pluck('total')->values();

        return view('health.death_dashboard', compact(
            'selectedYear',
            'selectedDistrict',
            'selectedGender',
            'selectedAgeGroup',
            'selectedCause',
            'yearList',
            'districtList',
            'genderList',
            'ageGroupList',
            'causeList',
            'totalDeaths',
            'maleDeaths',
            'femaleDeaths',
            'districtCount',
            'causeCount',
            'monthlyChartLabels',
            'monthlyChartData',
            'districtChartLabels',
            'districtChartData',
            'causeChartLabels',
            'causeChartData',
            'ageGroupChartLabels',
            'ageGroupChartData',
            'topCausesAge0_5',
            'topCausesAge6_24',
            'topCausesAge25_59',
            'topCausesAge60Plus'
        ));
    }

    public function export(Request $request)
    {
        $year = trim((string)$request->get('year', ''));
        $district = trim((string)$request->get('district', ''));
        $gender = trim((string)$request->get('gender', ''));
        $ageGroup = trim((string)$request->get('age_group', ''));
        $cause = trim((string)$request->get('cause_of_death', ''));

        $fileName = 'ข้อมูลการตายจังหวัดพัทลุง';

        if ($year !== '') {
            $fileName .= '_' . $year;
        }

        if ($district !== '') {
            $fileName .= '_' . $district;
        }

        $fileName .= '.xlsx';

        return Excel::download(
            new DeathDashboardExport(
                $year,
                $district,
                $gender,
                $ageGroup,
                $cause
            ),
            $fileName
        );
    }
}