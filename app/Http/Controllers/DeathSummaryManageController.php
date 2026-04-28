<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DeathSummaryImport;
class DeathSummaryManageController extends Controller
{
   public function index(Request $request)
{
    $conn = DB::connection('mysql_help');

    $query = $conn->table('death_summary');

    if ($request->filled('year_th')) {
        $query->where('year_th', $request->year_th);
    }

    if ($request->filled('month_no')) {
        $query->where('month_no', $request->month_no);
    }

    if ($request->filled('district_name_th')) {
        $query->where('district_name_th', $request->district_name_th);
    }

    if ($request->filled('sex_name_th')) {
        $query->where('sex_name_th', $request->sex_name_th);
    }

    if ($request->filled('cause_of_death')) {
        $query->where('cause_of_death', 'like', '%' . $request->cause_of_death . '%');
    }

    $rows = $query
        ->orderByDesc('year_th')
        ->orderBy('month_no')
        ->orderByRaw("
            FIELD(district_name_th,
                'เมืองพัทลุง',
                'กงหรา',
                'เขาชัยสน',
                'ตะโหมด',
                'ควนขนุน',
                'ปากพะยูน',
                'ศรีบรรพต',
                'ป่าบอน',
                'บางแก้ว',
                'ป่าพะยอม',
                'ศรีนครินทร์'
            )
        ")
        ->paginate(20)
        ->withQueryString();

    $years = $conn->table('death_summary')
        ->select('year_th')
        ->whereNotNull('year_th')
        ->where('year_th', '>=', 2500)
        ->distinct()
        ->orderByDesc('year_th')
        ->pluck('year_th');

    $months = range(1, 12);

    $districts = collect([
        'เมืองพัทลุง',
        'กงหรา',
        'เขาชัยสน',
        'ตะโหมด',
        'ควนขนุน',
        'ปากพะยูน',
        'ศรีบรรพต',
        'ป่าบอน',
        'บางแก้ว',
        'ป่าพะยอม',
        'ศรีนครินทร์'
    ]);

    return view('death_summary_manage.index', compact(
        'rows',
        'years',
        'months',
        'districts'
    ));
}
    public function store(Request $request)
    {
        DB::connection('mysql_help')->table('death_summary')->insert([
            'year_th'          => $request->year_th,
            'month_no'         => $request->month_no,
            'province_name_th' => 'พัทลุง',
            'district_name_th' => $request->district_name_th,
            'sex_name_th'      => $request->sex_name_th,
            'age_group'        => $request->age_group,
            'cause_of_death'   => $request->cause_of_death,
            'death_total'      => $request->death_total ?? 0,
            'created_at' => \Carbon\Carbon::now('Asia/Bangkok'),
'updated_at' => \Carbon\Carbon::now('Asia/Bangkok'),
        ]);

        return back()->with('success', 'เพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function update(Request $request, $id)
    {
        DB::connection('mysql_help')
            ->table('death_summary')
            ->where('id', $id)
            ->update([
                'year_th'          => $request->year_th,
                'month_no'         => $request->month_no,
                'province_name_th' => 'พัทลุง',
                'district_name_th' => $request->district_name_th,
                'sex_name_th'      => $request->sex_name_th,
                'age_group'        => $request->age_group,
                'cause_of_death'   => $request->cause_of_death,
                'death_total'      => $request->death_total ?? 0,
                'updated_at'       => now(),
            ]);

        return back()->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        DB::connection('mysql_help')
            ->table('death_summary')
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }

   public function import(Request $request)
{
    $request->validate([
        'excel_file' => 'required|mimes:xlsx,xls,csv'
    ]);

    try {

        Excel::import(new DeathSummaryImport, $request->file('excel_file'));

        return back()->with('success', 'นำเข้า Excel เรียบร้อยแล้ว');

    } catch (\Throwable $e) {

        return back()->withErrors([
            'excel_file' => 'นำเข้าไม่สำเร็จ กรุณาตรวจสอบรูปแบบไฟล์ Excel หรือหัวตารางไม่ถูกต้อง'
        ]);
    }
}
}