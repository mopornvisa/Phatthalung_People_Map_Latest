<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\HelpRecord;

class HelpRecordController extends Controller
{
   public function index(Request $request)
{
    $houseId = trim((string) $request->get('house_id', ''));

   $householdsQuery = DB::connection('sqlsrv')
    ->table('PPAOS93.dbo.survey_profile64 as s')

    ->leftJoin(
        'PPAOS93.dbo.tambon as t',
        DB::raw("RTRIM(LTRIM(LEFT([s].[TMP],6)))"),
        '=',
        DB::raw("[t].[tambon_code]")
    )

    ->leftJoin(
        'PPAOS93.dbo.district as d',
        DB::raw("RTRIM(LTRIM([s].[AMP]))"),
        '=',
        DB::raw("[d].[district_code]")
    )

    ->leftJoin(
        'PPAOS93.dbo.province as pr',
        DB::raw("RTRIM(LTRIM([s].[JUN]))"),
        '=',
        DB::raw("[pr].[province_code]")
    )

    ->select([
        's.HC as HC1',
        's.survey_year',
        's.MBNO',
        's.MB',
        's.MM',
        's.POSTCODE',

        DB::raw("t.tambon_name_thai as tambon_name_thai"),
        DB::raw("d.district_name_thai as district_name_thai"),
        DB::raw("pr.province_name_thai as province_name_thai"),

        DB::raw("NULL as NAME"),
        DB::raw("NULL as LNAME"),
    ]);

if ($houseId !== '') {
    $householdsQuery->where('s.HC', 'like', "%{$houseId}%");
}

$households = $householdsQuery
    ->orderByDesc('s.survey_year')
    ->orderBy('s.HC')
    ->paginate(25)
    ->withQueryString();

$houseIds = collect($households->items())
    ->pluck('HC1')
    ->filter()
    ->values();

    $helpRecords = HelpRecord::query()
        ->whereIn('house_Id', $houseIds)
        ->orderByDesc('action_date')
        ->get()
        ->groupBy('house_Id');

    return view('help_records.index', [
        'households'  => $households,
        'helpRecords' => $helpRecords,
        'houseId'     => $houseId,
    ]);
}
    public function create(Request $request, string $houseId)
    {
        $surveyYear = $request->query('survey_year');

        return view('help_records.create', [
            'houseId'    => $houseId,
            'surveyYear' => $surveyYear,
        ]);
    }

    public function store(Request $request, string $houseId)
    {
        $data = $request->validate([
            'survey_year'   => ['nullable', 'integer'],
            'help_year'     => ['nullable', 'integer'],
            'action_date'   => ['nullable', 'date'],
            'agency'        => ['nullable', 'string', 'max:255'],
            'action_type'   => ['nullable', 'string', 'max:255'],
            'budget'        => ['nullable', 'numeric', 'min:0'],
            'detail'        => ['nullable', 'string'],
            'status'        => ['required', 'string', 'max:50'],
            'next_followup' => ['nullable', 'date'],
            'result'        => ['nullable', 'string'],
        ]);

        $data['house_Id'] = $houseId;

        if (empty($data['survey_year'])) {
            $data['survey_year'] = $request->input('survey_year') ?: $request->query('survey_year');
        }

        if (empty($data['help_year'])) {
            $data['help_year'] = (int) date('Y') + 543;
        }

        HelpRecord::create($data);

        return redirect()
            ->route('housing.show', $houseId)
            ->with('success', 'บันทึกการช่วยเหลือเรียบร้อยแล้ว');
    }
}