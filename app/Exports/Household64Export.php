<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
class Household64Export implements FromView, ShouldAutoSize, WithColumnFormatting
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;

        $conn = DB::connection('sqlsrv');

        // ======================
        // ตรวจ column จริง
        // ======================
        $colsT = collect($conn->select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME='tambon'
        "))->pluck('COLUMN_NAME')->toArray();

        $colsD = collect($conn->select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME='district'
        "))->pluck('COLUMN_NAME')->toArray();

        $colsP = collect($conn->select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME='province'
        "))->pluck('COLUMN_NAME')->toArray();

        // ======================
        // หา key จริงอัตโนมัติ
        // ======================
        $tambonKey = collect([
            'tambon_code',
            'tambon_id',
            'code',
            'id'
        ])->first(fn($c) => in_array($c, $colsT));

        $districtKey = collect([
            'district_code',
            'amphur_code',
            'district_id',
            'code',
            'id'
        ])->first(fn($c) => in_array($c, $colsD));

        $provinceKey = collect([
            'province_code',
            'changwat_code',
            'province_id',
            'code',
            'id'
        ])->first(fn($c) => in_array($c, $colsP));

        // ======================
        // query
        // ======================
        $q = $conn->table('dbo.survey_profile64 as s');

        if ($tambonKey) {
    $q->leftJoin('dbo.tambon as t', function ($join) use ($tambonKey) {
        $join->on(
            DB::raw("RTRIM(LTRIM(LEFT([s].[TMP],6)))"),
            '=',
            DB::raw("[t].[$tambonKey]")
        );
    });
}

if ($districtKey) {
    $q->leftJoin('dbo.district as d', function ($join) use ($districtKey) {
        $join->on(
            DB::raw("RTRIM(LTRIM([s].[AMP]))"),
            '=',
            DB::raw("[d].[$districtKey]")
        );
    });
}

if ($provinceKey) {
    $q->leftJoin('dbo.province as pr', function ($join) use ($provinceKey) {
        $join->on(
            DB::raw("RTRIM(LTRIM([s].[JUN]))"),
            '=',
            DB::raw("[pr].[$provinceKey]")
        );
    });
}

        $q->select([
            's.HC',
            's.survey_year',
            's.survey_no',
            's.AGRI',
            's.AGRI_NO',
            's.MBNO',
            's.MB',
            's.MM',

          DB::raw("t.tambon_name_thai as tambon_name_thai"),
DB::raw("d.district_name_thai as district_name_thai"),
DB::raw("pr.province_name_thai as province_name_thai"),

's.POSTCODE',
's.TEL',

        ]);

        // ======================
        // filters
        // ======================
        if ($request->filled('survey_year')) {
            $q->where('s.survey_year', $request->survey_year);
        }

        if ($request->filled('survey_no')) {
            $q->where('s.survey_no', 'like', '%' . $request->survey_no . '%');
        }

        if ($request->filled('HC')) {
            $q->where('s.HC', 'like', '%' . $request->HC . '%');
        }

        if ($request->filled('AGRI')) {
            $q->where('s.AGRI', 'like', '%' . $request->AGRI . '%');
        }

        if ($request->filled('AGRI_NO')) {
            $q->where('s.AGRI_NO', 'like', '%' . $request->AGRI_NO . '%');
        }

        if ($request->filled('MBNO')) {
            $q->where('s.MBNO', 'like', '%' . $request->MBNO . '%');
        }

        if ($request->filled('MB')) {
            $q->where('s.MB', 'like', '%' . $request->MB . '%');
        }

        if ($request->filled('MM')) {
            $q->where('s.MM', 'like', '%' . $request->MM . '%');
        }

        if ($request->filled('POSTCODE')) {
            $q->where('s.POSTCODE', 'like', '%' . $request->POSTCODE . '%');
        }

        if ($request->filled('TEL')) {
            $q->where('s.TEL', 'like', '%' . $request->TEL . '%');
        }

        if ($request->filled('q')) {
            $search = '%' . $request->q . '%';

            $q->where(function ($w) use ($search) {
                $w->orWhere('s.HC', 'like', $search)
                  ->orWhere('s.TEL', 'like', $search)
                  ->orWhere('s.MBNO', 'like', $search)
                  ->orWhere('s.MM', 'like', $search)
                  ->orWhere('t.tambon_name_thai', 'like', $search)
                  ->orWhere('d.district_name_thai', 'like', $search)
                  ->orWhere('pr.province_name_thai', 'like', $search);
            });
        }
$rows = $q
    ->orderByDesc('s.survey_year')
    ->orderBy('s.HC')
    ->get();

return view('exports.household64_excel', [
    'rows' => $rows,
    'survey_year' => $request->get('survey_year', ''),
    'district' => $request->get('district_name_thai', ''),
    'subdistrict' => $request->get('tambon_name_thai', ''),
]);
    }

    public function headings(): array
    {
       return [
    'เลขครัวเรือน',
    'ปีที่สำรวจ',
    'ครั้งที่สำรวจ',
    'สมุดเกษตร',
    'เลขเกษตร',
    'บ้านเลขที่',
    'หมู่ที่',
    'หมู่บ้าน',
    'ตำบล',
    'อำเภอ',
   'จังหวัด',
'รหัสไปรษณีย์',
'เบอร์โทรศัพท์',
];
    }
    public function columnFormats(): array
{
  return [
    'A' => NumberFormat::FORMAT_TEXT,
    'M' => NumberFormat::FORMAT_TEXT,
];
}
}