<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class DeathDashboardExport implements FromView
{
    protected $year;
    protected $district;
    protected $gender;
    protected $ageGroup;
    protected $cause;

    public function __construct($year = '', $district = '', $gender = '', $ageGroup = '', $cause = '')
    {
        $this->year = $year;
        $this->district = $district;
        $this->gender = $gender;
        $this->ageGroup = $ageGroup;
        $this->cause = $cause;
    }

    public function view(): View
    {
        $conn = DB::connection('mysql_help');
        $table = 'death_summary';

        $ageGroupMap = [
            '0-5'   => ['0', '1-4'],
            '6-24'  => ['5-9', '10-15', '15-19', '20-24'],
            '25-59' => ['25-29', '30-34', '35-39', '40-44', '45-49', '50-54', '55-59'],
            '60+'   => ['60-64', '65-69', '70-74', '75-79', '80-84', '85+'],
        ];

        $query = $conn->table($table)
            ->select(
                'year_th',
                'month_no',
                'district_name_th',
                'sex_name_th',
                'age_group',
                'cause_of_death',
                DB::raw('SUM(death_total) as death_total')
            )
            ->groupBy(
                'year_th',
                'month_no',
                'district_name_th',
                'sex_name_th',
                'age_group',
                'cause_of_death'
            )
            ->orderBy('year_th')
            ->orderBy('month_no')
            ->orderBy('district_name_th');

        if ($this->year !== '') {
            $query->where('year_th', (int) $this->year);
        }

        if ($this->district !== '') {
            $query->where('district_name_th', $this->district);
        }

        if ($this->gender !== '') {
            $query->where('sex_name_th', $this->gender);
        }

        if ($this->cause !== '') {
            $query->where('cause_of_death', $this->cause);
        }

        if ($this->ageGroup !== '' && isset($ageGroupMap[$this->ageGroup])) {
            $query->whereIn('age_group', $ageGroupMap[$this->ageGroup]);
        }

        $rows = $query->get();

        return view('exports.death_dashboard_excel', [
            'rows' => $rows,
            'year' => $this->year,
            'district' => $this->district,
            'gender' => $this->gender,
            'ageGroup' => $this->ageGroup,
            'cause' => $this->cause,
        ]);
    }
}