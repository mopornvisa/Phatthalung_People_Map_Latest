<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class HtIncidence100kExport implements FromView
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
        $table = 'health_ht_incidence_100k_all';

        $query = DB::connection('mysql_help')
            ->table($table)
            ->select([
                'survey_year',
                'district_name_thai',
                'population_civil_registry',
                'patient_ht_total',
                'rate_per_100k',
                'month10',
                'month11',
                'month12',
                'month1',
                'month2',
                'month3',
                'month4',
                'month5',
                'month6',
                'month7',
                'month8',
                'month9',
            ]);

        if ($this->year !== null && $this->year !== '') {
            $query->where('survey_year', $this->year);
        }

        if ($this->district !== null && $this->district !== '') {
            $query->where('district_name_thai', $this->district);
        }

        $rows = $query
            ->orderBy('district_name_thai')
            ->get();

        $summary = [
            'pop'     => $rows->sum(fn ($r) => (float) ($r->population_civil_registry ?? 0)),
            'case'    => $rows->sum(fn ($r) => (float) ($r->patient_ht_total ?? 0)),
            'month10' => $rows->sum(fn ($r) => (float) ($r->month10 ?? 0)),
            'month11' => $rows->sum(fn ($r) => (float) ($r->month11 ?? 0)),
            'month12' => $rows->sum(fn ($r) => (float) ($r->month12 ?? 0)),
            'month1'  => $rows->sum(fn ($r) => (float) ($r->month1 ?? 0)),
            'month2'  => $rows->sum(fn ($r) => (float) ($r->month2 ?? 0)),
            'month3'  => $rows->sum(fn ($r) => (float) ($r->month3 ?? 0)),
            'month4'  => $rows->sum(fn ($r) => (float) ($r->month4 ?? 0)),
            'month5'  => $rows->sum(fn ($r) => (float) ($r->month5 ?? 0)),
            'month6'  => $rows->sum(fn ($r) => (float) ($r->month6 ?? 0)),
            'month7'  => $rows->sum(fn ($r) => (float) ($r->month7 ?? 0)),
            'month8'  => $rows->sum(fn ($r) => (float) ($r->month8 ?? 0)),
            'month9'  => $rows->sum(fn ($r) => (float) ($r->month9 ?? 0)),
        ];

        $summary['rate'] = $summary['pop'] > 0
            ? (($summary['case'] / $summary['pop']) * 100000)
            : 0;

        return view('exports.ht_incidence_100k_excel', [
            'rows'     => $rows,
            'summary'  => $summary,
            'year'     => $this->year,
            'district' => $this->district,
        ]);
    }
}