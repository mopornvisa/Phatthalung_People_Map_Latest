<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

// Excel
use App\Exports\HealthExport;
use Maatwebsite\Excel\Facades\Excel;

class HealthController extends Controller
{
    public function index(Request $request)
    {
        $actionUrl = route('health.index');

        $conn         = DB::connection('sqlsrv');
        $mainTable    = '[dbo].[survey_a]';
        $profileTable = '[dbo].[survey_profile64]';

        // ======================
        // อ่านคอลัมน์
        // ======================
        $colsMain = collect($conn->select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA='dbo' AND TABLE_NAME='survey_a'
        "))->pluck('COLUMN_NAME')->map(fn($c) => strtolower($c))->all();

        $colsProfile = collect($conn->select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA='dbo' AND TABLE_NAME='survey_profile64'
        "))->pluck('COLUMN_NAME')->map(fn($c) => strtolower($c))->all();

        $hasMainCol = fn($c) => in_array(strtolower($c), $colsMain, true);
        $hasProfCol = fn($c) => in_array(strtolower($c), $colsProfile, true);

        $pickMainCol = fn($cands, $f = null) => collect($cands)->first(fn($c) => $hasMainCol($c)) ?? $f;
        $pickProfCol = fn($cands, $f = null) => collect($cands)->first(fn($c) => $hasProfCol($c)) ?? $f;

        $colRef = fn($a, $c) => ($a && $c) ? "$a.[$c]" : null;
        $trim   = fn($e) => "LTRIM(RTRIM($e))";

        // ======================
        // mapping
        // ======================
        $COL_HOUSE    = $pickMainCol(['HC'], 'HC');
        $COL_FNAME    = $pickMainCol(['a2_2']);
        $COL_LNAME    = $pickMainCol(['a2_3']);
        $COL_AGE      = $pickMainCol(['a3_1']);
        $COL_SEX      = $pickMainCol(['a4']);
        $COL_HEALTH   = $pickMainCol(['a6', 'a5', 'health']);
        $COL_YEAR     = $pickMainCol(['survey_year']);
        $COL_POPID    = $pickMainCol(['popid']);

        $COL_DISTRICT = $pickMainCol(['district_name_thai']);
        $COL_TAMBON   = $pickMainCol(['tambon_name_thai']);

        $COL_HOUSE_NO = $pickMainCol(['house_Number', 'house_number', 'MBNO']);
        $COL_VILL_NO  = $pickMainCol(['village_No', 'village_no', 'MB']);
        $COL_VILLAGE  = $pickMainCol(['village_Name', 'village_name', 'MM']);
        $COL_POSTCODE = $pickMainCol(['POSTCODE', 'postcode']);

        $P_COL_HOUSE  = $pickProfCol(['HC1'], 'HC1');
        $P_COL_TEL    = $pickProfCol(['TEL']);
        $P_COL_LAT    = $pickProfCol(['latx', 'LATX']);
        $P_COL_LNG    = $pickProfCol(['lngy', 'LNGY']);

        $districtRef = $colRef('u', $COL_DISTRICT);
        $tambonRef   = $colRef('u', $COL_TAMBON);

        // ======================
        // filters
        // ======================
        $health      = trim((string) $request->get('health', ''));
        $district    = trim((string) $request->get('district', ''));
        $subdistrict = trim((string) $request->get('subdistrict', ''));

        $house_id    = trim((string) $request->get('house_id', ''));
        $survey_year = trim((string) $request->get('survey_year', ''));
        $fname       = trim((string) $request->get('fname', ''));
        $lname       = trim((string) $request->get('lname', ''));
        $cid         = trim((string) $request->get('cid', ''));
        $agey        = trim((string) $request->get('agey', ''));
        $sex         = trim((string) $request->get('sex', ''));
        $age_range   = trim((string) $request->get('age_range', ''));

        $HEALTH_OPTIONS = [
            'ปกติ',
            'ป่วยเรื้อรังที่ไม่ติดเตียง (เช่น หัวใจ เบาหวาน)',
            'พิการพึ่งตนเองได้',
            'ผู้ป่วยติดเตียง/พิการพึ่งตัวเองไม่ได้',
        ];

        $HEALTH_NULL_TOKEN = '__NULL__';

        $healthCaseSql = "
            CASE TRY_CONVERT(int, u.$COL_HEALTH)
                WHEN 1 THEN N'ปกติ'
                WHEN 2 THEN N'ป่วยเรื้อรังที่ไม่ติดเตียง (เช่น หัวใจ เบาหวาน)'
                WHEN 3 THEN N'พิการพึ่งตนเองได้'
                WHEN 4 THEN N'ผู้ป่วยติดเตียง/พิการพึ่งตัวเองไม่ได้'
                ELSE N''
            END
        ";

        // ======================
        // base query
        // ======================
        $baseQuery = $conn->table(DB::raw("$mainTable as u"))
            ->leftJoin(DB::raw("$profileTable as p"), "u.$COL_HOUSE", "=", "p.$P_COL_HOUSE");

        if ($district !== '' && $districtRef) {
            $baseQuery->whereRaw($trim($districtRef) . " = ?", [$district]);
        }

        if ($subdistrict !== '' && $tambonRef) {
            $baseQuery->whereRaw($trim($tambonRef) . " = ?", [$subdistrict]);
        }

        if ($house_id !== '' && $COL_HOUSE) {
            $baseQuery->where("u.$COL_HOUSE", 'like', "%{$house_id}%");
        }

        if ($survey_year !== '' && $COL_YEAR) {
            $baseQuery->where("u.$COL_YEAR", $survey_year);
        }

        if ($fname !== '' && $COL_FNAME) {
            $baseQuery->where("u.$COL_FNAME", 'like', "%{$fname}%");
        }

        if ($lname !== '' && $COL_LNAME) {
            $baseQuery->where("u.$COL_LNAME", 'like', "%{$lname}%");
        }

        if ($cid !== '' && $COL_POPID) {
            $baseQuery->where("u.$COL_POPID", 'like', "%{$cid}%");
        }

        if ($sex !== '' && $COL_SEX) {
            if ($sex === 'ชาย') {
                $baseQuery->whereRaw("TRY_CONVERT(int, u.$COL_SEX) = 1");
            } elseif ($sex === 'หญิง') {
                $baseQuery->whereRaw("TRY_CONVERT(int, u.$COL_SEX) = 2");
            } else {
                $baseQuery->where("u.$COL_SEX", $sex);
            }
        }

        if ($agey !== '' && $COL_AGE) {
            $baseQuery->whereRaw("TRY_CONVERT(int, u.$COL_AGE) = ?", [(int) $agey]);
        }

        if ($age_range !== '' && $COL_AGE) {
            if (preg_match('/^(\d+)-(\d+)$/', $age_range, $m)) {
                $baseQuery->whereBetween(DB::raw("TRY_CONVERT(int, u.$COL_AGE)"), [(int) $m[1], (int) $m[2]]);
            } elseif (preg_match('/^(\d+)\+$/', $age_range, $m)) {
                $baseQuery->whereRaw("TRY_CONVERT(int, u.$COL_AGE) >= ?", [(int) $m[1]]);
            }
        }

        if ($health !== '') {
            if ($health === $HEALTH_NULL_TOKEN) {
                $baseQuery->whereRaw("($healthCaseSql = N'' OR $healthCaseSql IS NULL)");
            } else {
                $baseQuery->whereRaw("$healthCaseSql = ?", [$health]);
            }
        }

        // ======================
        // rows
        // ======================
        $rows = (clone $baseQuery)
            ->selectRaw("
                u.$COL_HOUSE as house_Id,
                u.$COL_FNAME as human_Member_fname,
                u.$COL_LNAME as human_Member_lname,
                u.$COL_AGE as human_Age_y,
                u.$COL_YEAR as survey_Year,

                CASE TRY_CONVERT(int, u.$COL_SEX)
                    WHEN 1 THEN N'ชาย'
                    WHEN 2 THEN N'หญิง'
                    ELSE N''
                END as human_Sex,

                $healthCaseSql as human_Health,

                " . ($COL_DISTRICT ? "u.$COL_DISTRICT" : "NULL") . " as survey_District,
                " . ($COL_TAMBON ? "u.$COL_TAMBON" : "NULL") . " as survey_Subdistrict,

                " . ($COL_POPID ? "u.$COL_POPID" : "NULL") . " as human_Member_cid,
                " . ($COL_HOUSE_NO ? "u.$COL_HOUSE_NO" : "NULL") . " as house_Number,
                " . ($COL_VILL_NO ? "u.$COL_VILL_NO" : "NULL") . " as village_No,
                " . ($COL_VILLAGE ? "u.$COL_VILLAGE" : "NULL") . " as village_Name,
                " . ($COL_POSTCODE ? "u.$COL_POSTCODE" : "NULL") . " as survey_Postcode,
                " . ($P_COL_TEL ? "p.$P_COL_TEL" : "NULL") . " as survey_Informer_phone,
                " . ($P_COL_LAT ? "p.$P_COL_LAT" : "NULL") . " as latitude,
                " . ($P_COL_LNG ? "p.$P_COL_LNG" : "NULL") . " as longitude,
                NULL as human_Order,
                NULL as human_Member_title
            ")
            ->orderByDesc("u.$COL_YEAR")
            ->paginate(20)
            ->withQueryString();

        // ======================
        // counts
        // ======================
        $countRows = (clone $baseQuery)
            ->selectRaw("$healthCaseSql as human_Health")
            ->get();

        $counts = [
            'ปกติ' => 0,
            'ป่วยเรื้อรังที่ไม่ติดเตียง (เช่น หัวใจ เบาหวาน)' => 0,
            'พิการพึ่งตนเองได้' => 0,
            'ผู้ป่วยติดเตียง/พิการพึ่งตัวเองไม่ได้' => 0,
            $HEALTH_NULL_TOKEN => 0,
        ];

        foreach ($countRows as $r) {
            $label = trim((string) ($r->human_Health ?? ''));
            if ($label === '') {
                $counts[$HEALTH_NULL_TOKEN]++;
            } elseif (isset($counts[$label])) {
                $counts[$label]++;
            }
        }

        // ======================
        // district list
        // ======================
        $districtList = Cache::remember('health_district_list', 600, function () use ($conn, $mainTable, $COL_DISTRICT) {
            return $conn->table(DB::raw("$mainTable as u"))
                ->selectRaw("DISTINCT LTRIM(RTRIM(u.$COL_DISTRICT)) as district_name_thai")
                ->whereNotNull("u.$COL_DISTRICT")
                ->whereRaw("LTRIM(RTRIM(u.$COL_DISTRICT)) <> ''")
                ->orderBy('district_name_thai')
                ->pluck('district_name_thai');
        });

        // ======================
        // subdistrict list
        // ======================
        $subdistrictList = collect([]);

        if ($district !== '') {
            $subdistrictList = Cache::remember('health_subdistrict_list_' . md5($district), 600, function () use ($conn, $mainTable, $COL_DISTRICT, $COL_TAMBON, $district, $trim) {
                return $conn->table(DB::raw("$mainTable as u"))
                    ->selectRaw("DISTINCT LTRIM(RTRIM(u.$COL_TAMBON)) as tambon_name_thai")
                    ->whereNotNull("u.$COL_TAMBON")
                    ->whereRaw("LTRIM(RTRIM(u.$COL_TAMBON)) <> ''")
                    ->whereRaw($trim("u.$COL_DISTRICT") . " = ?", [$district])
                    ->orderBy('tambon_name_thai')
                    ->pluck('tambon_name_thai');
            });
        }

        // ======================
        // year list
        // ======================
        $yearList = Cache::remember('health_year_list', 600, function () use ($conn, $mainTable, $COL_YEAR) {
            return $conn->table(DB::raw("$mainTable as u"))
                ->selectRaw("DISTINCT TRY_CONVERT(int, u.$COL_YEAR) as survey_year")
                ->whereNotNull("u.$COL_YEAR")
                ->orderByDesc('survey_year')
                ->pluck('survey_year')
                ->filter(fn($y) => !is_null($y) && $y !== '')
                ->values();
        });

        return view('health', compact(
            'actionUrl',
            'health',
            'district',
            'subdistrict',
            'house_id',
            'survey_year',
            'fname',
            'lname',
            'cid',
            'agey',
            'sex',
            'age_range',
            'rows',
            'counts',
            'districtList',
            'subdistrictList',
            'yearList',
            'HEALTH_OPTIONS',
            'HEALTH_NULL_TOKEN'
        ));
    }

    public function export(Request $request)
    {
        $year = trim((string) $request->get('survey_year', ''));
        $filename = $year !== '' ? "health_{$year}.xlsx" : 'health.xlsx';

        return Excel::download(new HealthExport($request->all()), $filename);
    }
}