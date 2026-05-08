<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EducationExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;

        $profileSub = DB::connection('sqlsrv')
            ->table('PPAOS93.dbo.survey_profile64')
            ->selectRaw("
                HC,
                MIN(MBNO) as MBNO,
                MIN(MB) as MB,
                MIN(MM) as MM,
                MIN(POSTCODE) as POSTCODE,
                MIN(district_name_thai) as district_name_thai,
                MIN(tambon_name_thai) as tambon_name_thai
            ")
            ->whereNotNull('HC')
            ->groupBy('HC');

        $query = DB::connection('sqlsrv')
            ->table('PPAOS93.dbo.survey_a as u')
            ->leftJoinSub($profileSub, 'p', function ($join) {
                $join->on(
                    DB::raw("LTRIM(RTRIM(u.HC))"),
                    '=',
                    DB::raw("LTRIM(RTRIM(p.HC))")
                );
            });

        if ($request->filled('survey_year')) {
            $query->where('u.survey_year', $request->survey_year);
        }

        if ($request->filled('district')) {
            $query->whereRaw("LTRIM(RTRIM(p.district_name_thai)) = ?", [$request->district]);
        }

        if ($request->filled('subdistrict')) {
            $query->whereRaw("LTRIM(RTRIM(p.tambon_name_thai)) = ?", [$request->subdistrict]);
        }

        if ($request->filled('household_code')) {
            $query->where('u.HC', 'like', '%' . $request->household_code . '%');
        }

        if ($request->filled('fname')) {
            $query->where('u.a2_2', 'like', '%' . $request->fname . '%');
        }

        if ($request->filled('lname')) {
            $query->where('u.a2_3', 'like', '%' . $request->lname . '%');
        }

        if ($request->filled('cid')) {
            $query->where('u.popid', 'like', '%' . $request->cid . '%');
        }

        if ($request->filled('sex')) {
            $query->where('u.a4', $request->sex);
        }

        if ($request->filled('speak_thai')) {
            $query->where('u.a9_1', $request->speak_thai);
        }

        if ($request->filled('read_thai')) {
            $query->where('u.a9_2', $request->read_thai);
        }

        if ($request->filled('write_thai')) {
            $query->where('u.a10', $request->write_thai);
        }

        if ($request->filled('education_level')) {
            $query->where('u.a11', $request->education_level);
        }

        if ($request->filled('education_status')) {
            $query->where('u.a13', $request->education_status);
        }

        $rows = $query
            ->select([
                'u.survey_year',
                'u.HC',
                'u.a1',
                'u.a2_2',
                'u.a2_3',
                'u.popid',
                'u.a3_1',
                'u.a4',
                'u.a9_1',
                'u.a9_2',
                'u.a10',
                'u.a11',
                'u.a13',
                'p.MBNO',
                'p.MB',
                'p.MM',
                'p.POSTCODE',
                'p.district_name_thai',
                'p.tambon_name_thai',
            ])
            ->orderByDesc('u.survey_year')
            ->orderBy('u.HC')
            ->orderBy('u.a1')
            ->get();

        return view('exports.education_excel', [
            'rows' => $rows,
            'survey_year' => $request->survey_year ?? '',
            'district' => $request->district ?? '',
            'subdistrict' => $request->subdistrict ?? '',
        ]);
    }
}