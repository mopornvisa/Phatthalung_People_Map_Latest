<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EducationExport;

class EducationDashboardController extends Controller
{
    public function index(Request $request)
    {
        $district = trim((string)($request->district ?? ''));
        $subdistrict = trim((string)($request->subdistrict ?? ''));

        $conn = DB::connection('sqlsrv');

        $profileSub = $conn->table('PPAOS93.dbo.survey_profile64')
    ->selectRaw("
        HC,
        MIN(AMP) as AMP,
        MIN(TMP) as TMP,
        MIN(district_name_thai) as district_name_thai,
        MIN(tambon_name_thai) as tambon_name_thai,

        MIN(MBNO) as MBNO,        -- บ้านเลขที่
        MIN(MB) as MB,            -- หมู่ที่
        MIN(MM) as MM,            -- ชื่อหมู่บ้าน
        MIN(POSTCODE) as POSTCODE -- รหัสไปรษณีย์
    ")
    ->whereNotNull('HC')
    ->groupBy('HC');

        $query = $conn
            ->table('PPAOS93.dbo.survey_a as u')
            ->leftJoinSub($profileSub, 'p', function ($join) {
                $join->on(
                    DB::raw("LTRIM(RTRIM(p.HC))"),
                    '=',
                    DB::raw("LTRIM(RTRIM(u.HC))")
                );
            })
            ->leftJoin('PPAOS93.dbo.district as d', function ($join) {
                $join->on(
                    DB::raw("COALESCE(NULLIF(LTRIM(RTRIM(p.AMP)), ''), NULLIF(LTRIM(RTRIM(u.AMP)), ''))"),
                    '=',
                    DB::raw('d.district_id')
                );
            })
            ->leftJoin('PPAOS93.dbo.tambon as t', function ($join) {
                $join->on(
                    DB::raw("LEFT(COALESCE(NULLIF(LTRIM(RTRIM(p.TMP)), ''), NULLIF(LTRIM(RTRIM(u.TMP)), '')), 7)"),
                    '=',
                    DB::raw('t.tambon_id')
                );
            });

        if ($request->filled('survey_year')) {
            $query->where('u.survey_year', $request->survey_year);
        }

        if ($request->filled('household_code')) {
            $query->where('u.HC', 'like', '%' . $request->household_code . '%');
        }

        if ($district !== '') {
            $query->whereRaw("LTRIM(RTRIM(d.district_name_thai)) = ?", [$district]);
        }

        if ($subdistrict !== '') {
            $query->whereRaw("LTRIM(RTRIM(t.tambon_name_thai)) = ?", [$subdistrict]);
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

        $districtList = $conn->table('PPAOS93.dbo.district')
            ->selectRaw("DISTINCT LTRIM(RTRIM(district_name_thai)) as district_name")
            ->whereRaw("LTRIM(RTRIM(district_name_thai)) <> ''")
            ->orderBy('district_name')
            ->pluck('district_name');

        $subdistrictList = collect();

        if ($district !== '') {
            $subdistrictList = $conn
                ->table('PPAOS93.dbo.tambon as t')
                ->leftJoin('PPAOS93.dbo.district as d', 't.district_id', '=', 'd.district_id')
                ->whereRaw("LTRIM(RTRIM(d.district_name_thai)) = ?", [$district])
                ->selectRaw("DISTINCT LTRIM(RTRIM(t.tambon_name_thai)) as tambon_name")
                ->whereRaw("LTRIM(RTRIM(t.tambon_name_thai)) <> ''")
                ->orderBy('tambon_name')
                ->pluck('tambon_name');
        }

        $base = clone $query;

        $total = (clone $base)->count();
        $speakThai = (clone $base)->where('u.a9_1', 1)->count();
        $readThai = (clone $base)->where('u.a9_2', 1)->count();
        $cannotReadThai = (clone $base)->where('u.a9_2', 0)->count();
        $cannotWriteThai = (clone $base)->where('u.a10', 0)->count();
        $notStudy = (clone $base)->where('u.a11', 0)->count();
        $studyRegular = (clone $base)->where('u.a13', 1)->count();
        $studySometimes = (clone $base)->where('u.a13', 2)->count();
        $dropout = (clone $base)->where('u.a13', 3)->count();

        // ================== กราฟแนวโน้มรายปี ==================
        $trendByYear = (clone $base)
            ->selectRaw("
                u.survey_year,
                COUNT(*) as total_people,
                SUM(CASE WHEN u.a9_2 = 0 THEN 1 ELSE 0 END) as cannot_read,
                SUM(CASE WHEN u.a10 = 0 THEN 1 ELSE 0 END) as cannot_write,
                SUM(CASE WHEN u.a13 = 3 THEN 1 ELSE 0 END) as dropout
            ")
            ->whereNotNull('u.survey_year')
            ->groupBy('u.survey_year')
            ->orderBy('u.survey_year')
            ->get();

        // ================== Top 5 อำเภอเสี่ยง ==================
        $topRiskDistricts = (clone $base)
            ->selectRaw("
                COALESCE(NULLIF(LTRIM(RTRIM(d.district_name_thai)), ''), 'ไม่ระบุอำเภอ') as district,
                SUM(CASE WHEN u.a9_2 = 0 THEN 1 ELSE 0 END) as cannot_read,
                SUM(CASE WHEN u.a10 = 0 THEN 1 ELSE 0 END) as cannot_write,
                SUM(CASE WHEN u.a13 = 3 THEN 1 ELSE 0 END) as dropout,
                (
                    SUM(CASE WHEN u.a9_2 = 0 THEN 1 ELSE 0 END)
                    + SUM(CASE WHEN u.a10 = 0 THEN 1 ELSE 0 END)
                    + SUM(CASE WHEN u.a13 = 3 THEN 1 ELSE 0 END)
                ) as risk_total
            ")
            ->groupByRaw("COALESCE(NULLIF(LTRIM(RTRIM(d.district_name_thai)), ''), 'ไม่ระบุอำเภอ')")
            ->orderByDesc('risk_total')
            ->limit(5)
            ->get();

        // ================== Insight อัตโนมัติ ==================
        $topRisk = $topRiskDistricts->first();

        $autoInsight = [
            'district' => $topRisk->district ?? 'ไม่พบข้อมูล',
            'risk_total' => (int)($topRisk->risk_total ?? 0),
            'cannot_read' => (int)($topRisk->cannot_read ?? 0),
            'cannot_write' => (int)($topRisk->cannot_write ?? 0),
            'dropout' => (int)($topRisk->dropout ?? 0),
        ];

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
        'u.a12',
        'u.a13',
        'u.a13_1',

        'p.MBNO',
        'p.MB',
        'p.MM',
        'p.POSTCODE',

        DB::raw("COALESCE(NULLIF(LTRIM(RTRIM(d.district_name_thai)), ''), NULLIF(LTRIM(RTRIM(p.district_name_thai)), '')) as district_name_thai"),
        DB::raw("COALESCE(NULLIF(LTRIM(RTRIM(t.tambon_name_thai)), ''), NULLIF(LTRIM(RTRIM(p.tambon_name_thai)), '')) as tambon_name_thai"),
    ])
        
            ->orderByDesc('u.survey_year')
            ->orderBy('u.HC')
            ->orderBy('u.a1')
            ->paginate(20)
            ->withQueryString();

        return view('education.dashboard', compact(
            'rows',
            'total',
            'speakThai',
            'readThai',
            'cannotReadThai',
            'cannotWriteThai',
            'notStudy',
            'studyRegular',
            'studySometimes',
            'dropout',
            'district',
            'subdistrict',
            'districtList',
            'subdistrictList',
            'trendByYear',
            'topRiskDistricts',
            'autoInsight'
        ));
    }
  

public function export(Request $request)
{
    $year = $request->survey_year ?? 'ทั้งหมด';

    return Excel::download(
        new EducationExport($request),
        'รายงานข้อมูลการศึกษา_'.$year.'.xlsx'
    );
}
}
