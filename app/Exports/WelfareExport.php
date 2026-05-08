<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class WelfareExport implements FromView, ShouldAutoSize
{
    protected $query;
    protected array $filters;

    public function __construct($query, array $filters = [])
    {
        $this->query = $query;
        $this->filters = $filters;
    }

    public function view(): View
    {
        return view('exports.welfare-export', [
            'rows' => $this->query->get(),

            'survey_year' => $this->filters['survey_year'] ?? '',
            'district' => $this->filters['district'] ?? '',
            'subdistrict' => $this->filters['subdistrict'] ?? '',
            'welfare' => $this->filters['welfare'] ?? '',
            'welfare_type' => $this->filters['welfare_type'] ?? [],
        ]);
    }
}