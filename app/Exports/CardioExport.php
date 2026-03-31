<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\HealthNcd;

class CardioExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $year = $this->request->get('year', '');
        $district = $this->request->get('district', '');

        // ✅ รวมข้อมูลรายอำเภอ (เหมือนหน้า dashboard)
        $rows = HealthNcd::query()
            ->selectRaw("
                district_name_thai,
                SUM(COALESCE(population_civil_registry,0)) as population_civil_registry,
                SUM(COALESCE(patient_total,0)) as patient_total,
                SUM(COALESCE(month10,0)) as month10,
                SUM(COALESCE(month11,0)) as month11,
                SUM(COALESCE(month12,0)) as month12,
                SUM(COALESCE(month1,0)) as month1,
                SUM(COALESCE(month2,0)) as month2,
                SUM(COALESCE(month3,0)) as month3,
                SUM(COALESCE(month4,0)) as month4,
                SUM(COALESCE(month5,0)) as month5,
                SUM(COALESCE(month6,0)) as month6,
                SUM(COALESCE(month7,0)) as month7,
                SUM(COALESCE(month8,0)) as month8,
                SUM(COALESCE(month9,0)) as month9
            ")
            ->when($year !== '', function ($q) use ($year) {
                $q->where('survey_year', $year);
            })
            ->when($district !== '', function ($q) use ($district) {
                $q->where('district_name_thai', $district);
            })
            ->groupBy('district_name_thai')
            ->orderBy('district_name_thai')
            ->get()
            ->map(function ($r) {
                $pop  = (float) ($r->population_civil_registry ?? 0);
                $case = (float) ($r->patient_total ?? 0);
                $r->rate_per_100k = $pop > 0 ? ($case * 100000) / $pop : 0;
                return $r;
            });

        // ✅ summary
        $summary = [
            'pop'     => $rows->sum('population_civil_registry'),
            'case'    => $rows->sum('patient_total'),
            'month10' => $rows->sum('month10'),
            'month11' => $rows->sum('month11'),
            'month12' => $rows->sum('month12'),
            'month1'  => $rows->sum('month1'),
            'month2'  => $rows->sum('month2'),
            'month3'  => $rows->sum('month3'),
            'month4'  => $rows->sum('month4'),
            'month5'  => $rows->sum('month5'),
            'month6'  => $rows->sum('month6'),
            'month7'  => $rows->sum('month7'),
            'month8'  => $rows->sum('month8'),
            'month9'  => $rows->sum('month9'),
        ];

        $summary['rate'] = ($summary['pop'] ?? 0) > 0
            ? (($summary['case'] ?? 0) * 100000) / $summary['pop']
            : 0;

        // ✅ ส่งครบทุกตัว
        return view('exports.cardio_excel', [
            'rows' => $rows,
            'summary' => $summary,
            'year' => $year,
            'district' => $district,
        ]);
    }
}