<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\HelpRecord;

class HousingPhysicalController extends Controller
{
    public function dashboard(Request $request)
    {
        [$q, $meta] = $this->baseQuery($request);

        $houseId  = trim((string) $request->get('house_id', ''));
        $houseCol = $meta['COL_HOUSE'];

        if ($houseId !== '' && $houseCol) {
            $q->whereRaw("LTRIM(RTRIM(u.[$houseCol])) LIKE ?", ["%{$houseId}%"]);
        }

        $raw  = $q->limit(3000)->get();
        $coll = $this->enrichCollection($raw)->sortByDesc('score')->values();

        $kpi = [
            'total'       => $coll->count(),
            'urgent'      => $coll->where('score', '>=', 75)->count(),
            'poor_house'  => $coll->where('house_condition', 'ทรุดโทรม')->count(),
            'no_toilet'   => $coll->where('sanitation', 'ไม่มี')->count(),
            'no_drain'    => $coll->where('drainage', 'ไม่มี')->count(),
            'bad_waste'   => $coll->where('waste', 'ไม่เหมาะสม')->count(),
            'elec_risk'   => $coll->filter(fn($x) => in_array(($x['electric'] ?? ''), ['ต่อพ่วง', 'ไม่มี'], true))->count(),
            'water_short' => $coll->where('water', 'ไม่เพียงพอ')->count(),
        ];

        $perPage = 10;
        $page    = LengthAwarePaginator::resolveCurrentPage();
        $items   = $coll->slice(($page - 1) * $perPage, $perPage)->values();

        $rows = new LengthAwarePaginator(
            $items,
            $coll->count(),
            $perPage,
            $page,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

        $houseIds = collect($items)
            ->pluck('house_Id')
            ->filter()
            ->map(fn($x) => trim((string) $x))
            ->unique()
            ->values()
            ->all();

        $helpStatusMap = [];
        if (!empty($houseIds)) {
            $helpStatusMap = HelpRecord::whereIn('house_Id', $houseIds)
                ->orderByDesc('action_date')
                ->orderByDesc('id')
                ->get()
                ->groupBy(fn($r) => trim((string) $r->house_Id))
                ->map(fn($g) => optional($g->first())->status)
                ->toArray();
        }

        return view('housing.dashboard', [
            'kpi'           => $kpi,
            'rows'          => $rows,
            'houseId'       => $houseId,
            'helpStatusMap' => $helpStatusMap,
        ]);
    }

    public function map(Request $request)
    {
        [$q, $meta] = $this->baseQuery($request);

        if (!empty($meta['P_COL_LAT'])) {
            $q->whereNotNull(DB::raw("p.[{$meta['P_COL_LAT']}]"));
        }

        if (!empty($meta['P_COL_LNG'])) {
            $q->whereNotNull(DB::raw("p.[{$meta['P_COL_LNG']}]"));
        }

        $pins = $q->limit(3000)->get();
        $pins = $this->enrichCollection($pins)->values()->all();

        return view('housing.map', compact('pins'));
    }

    public function cases(Request $request)
    {
        $levelFilter = trim((string) $request->get('level', ''));

        [$q, $meta] = $this->baseQuery($request);

        $rows = $q->limit(3000)->get();
        $rows = $this->enrichCollection($rows)->values()->all();

        if ($levelFilter !== '') {
            $rows = array_values(array_filter($rows, fn($x) => ($x['level'] ?? '') === $levelFilter));
        }

        usort($rows, fn($a, $b) => ($b['score'] ?? 0) <=> ($a['score'] ?? 0));

        $conn = $meta['conn'];

        $districts = [];
        $subdistricts = [];

        if ($meta['P_COL_DISTRICT']) {
            $districts = $conn->table(DB::raw('[dbo].[survey_profile64] as p'))
                ->selectRaw("LTRIM(RTRIM(p.[{$meta['P_COL_DISTRICT']}])) as district")
                ->whereRaw("p.[{$meta['P_COL_DISTRICT']}] IS NOT NULL")
                ->whereRaw("LTRIM(RTRIM(p.[{$meta['P_COL_DISTRICT']}])) <> N''")
                ->distinct()
                ->orderBy('district')
                ->pluck('district')
                ->toArray();
        }

        if ($meta['P_COL_TAMBON']) {
            $subdistricts = $conn->table(DB::raw('[dbo].[survey_profile64] as p'))
                ->selectRaw("LTRIM(RTRIM(p.[{$meta['P_COL_TAMBON']}])) as subdistrict")
                ->whereRaw("p.[{$meta['P_COL_TAMBON']}] IS NOT NULL")
                ->whereRaw("LTRIM(RTRIM(p.[{$meta['P_COL_TAMBON']}])) <> N''")
                ->distinct()
                ->orderBy('subdistrict')
                ->pluck('subdistrict')
                ->toArray();
        }

        return view('housing.cases', [
            'filtered'     => $rows,
            'districts'    => $districts,
            'subdistricts' => $subdistricts,
            'district'     => (string) $request->get('district', ''),
            'subdistrict'  => (string) $request->get('subdistrict', ''),
            'level'        => $levelFilter,
        ]);
    }

    public function show(string $houseId)
    {
        [$q, $meta] = $this->baseQuery(request());

        $houseCol = $meta['COL_HOUSE'];

        if (!$houseCol) {
            abort(404, 'ไม่พบคอลัมน์รหัสครัวเรือน');
        }

        $houseId = trim($houseId);

        $row = $q->whereRaw("LTRIM(RTRIM(u.[$houseCol])) = ?", [$houseId])->first();
        abort_if(!$row, 404);

        $house = $this->normalizeRow((array) $row);
        $house['house_id'] = $house['house_id'] ?? $houseId;

        $score = $this->score($house);
        $lvl   = $this->level($score);

        $latestHelp = HelpRecord::where('house_Id', $houseId)
            ->orderByDesc('action_date')
            ->orderByDesc('id')
            ->first();

        return view('housing.show', [
            'house'      => $house,
            'score'      => $score,
            'level'      => $lvl['label'],
            'badge'      => $lvl['badge'],
            'helpStatus' => $latestHelp->status ?? null,
            'latestHelp' => $latestHelp,
        ]);
    }

    private function baseQuery(Request $request): array
    {
        $conn = DB::connection('sqlsrv');

        $colsMain = $this->tableColsMap($conn, 'survey_a');
        $colsProf = $this->tableColsMap($conn, 'survey_profile64');

        if (empty($colsMain)) {
            abort(404, 'ไม่พบตาราง survey_a');
        }

        if (empty($colsProf)) {
            abort(404, 'ไม่พบตาราง survey_profile64');
        }

        // ========= survey_a =========
        $COL_HOUSE    = $this->firstCol($colsMain, ['HC']);
        $COL_YEAR     = $this->firstCol($colsMain, ['survey_year', 'year']);
        $COL_DISTRICT = $this->firstCol($colsMain, ['district_name_thai', 'district']);
        $COL_TAMBON   = $this->firstCol($colsMain, ['tambon_name_thai', 'subdistrict']);
        $COL_PROVINCE = $this->firstCol($colsMain, ['province_name_thai', 'province']);

        // ========= survey_profile64 =========
        $P_COL_HOUSE    = $this->firstCol($colsProf, ['HC1', 'HC']);
        $P_COL_YEAR     = $this->firstCol($colsProf, ['survey_year', 'year']);
        $P_COL_DISTRICT = $this->firstCol($colsProf, ['district_name_thai', 'district']);
        $P_COL_TAMBON   = $this->firstCol($colsProf, ['tambon_name_thai', 'subdistrict']);
        $P_COL_PROVINCE = $this->firstCol($colsProf, ['province_name_thai', 'province']);

        $P_COL_POSTCODE = $this->firstCol($colsProf, ['POSTCODE', 'postcode']);
        $P_COL_PHONE    = $this->firstCol($colsProf, ['TEL', 'PHONE', 'phone']);
        $P_COL_HOUSE_NO = $this->firstCol($colsProf, ['HOUSE_NO', 'HOUSE_NUMBER', 'house_no']);
        $P_COL_MOO      = $this->firstCol($colsProf, ['MBNO', 'MOO', 'village_no']);
        $P_COL_VILLAGE  = $this->firstCol($colsProf, ['MB', 'VILLAGE_NAME', 'village_name']);
        $P_COL_LAT      = $this->firstCol($colsProf, ['LAT', 'LATX', 'latitude', 'lat']);
        $P_COL_LNG      = $this->firstCol($colsProf, ['LNG', 'LNGY', 'longitude', 'lng']);
        $P_COL_TITLE    = $this->firstCol($colsProf, ['PREFIX', 'TITLE', 'householder_title']);
        $P_COL_FNAME    = $this->firstCol($colsProf, ['PERSON', 'FNAME', 'NAME', 'householder_fname']);
        $P_COL_LNAME    = $this->firstCol($colsProf, ['LNAME', 'LAST_NAME', 'SURNAME', 'householder_lname']);
        $P_COL_CID      = $this->firstCol($colsProf, ['POPID', 'CID', 'CITIZEN_ID', 'householder_cid']);

        // ========= physical / housing =========
        $P_COL_HOUSE_CONDITION = $this->firstCol($colsProf, [
            'phys_house_condition',
            'physical_house_condition',
            'house_condition',
            'housing_condition'
        ]);

        $P_COL_SANITATION = $this->firstCol($colsProf, [
            'physical_housing_sanitation',
            'sanitation',
            'toilet'
        ]);

        $P_COL_ROAD_ACCESS = $this->firstCol($colsProf, [
            'physical_road_access_type',
            'road_access_type',
            'road_access'
        ]);

        $P_COL_DRAINAGE = $this->firstCol($colsProf, [
            'physical_drainage',
            'drainage'
        ]);

        $P_COL_ELECTRIC = $this->firstCol($colsProf, [
            'phys_electricity',
            'electricity',
            'electric'
        ]);

        $P_COL_MOBILE = $this->firstCol($colsProf, [
            'phys_mobilephone',
            'mobilephone',
            'mobile_phone'
        ]);

        $P_COL_HOME_ROUTE = $this->firstCol($colsProf, [
            'phys_home_route',
            'home_route'
        ]);

        $P_COL_OTHER121 = $this->firstCol($colsProf, [
            'phys_other121',
            'other121'
        ]);

        $P_COL_ALT_ENERGY = $this->firstCol($colsProf, [
            'phys_alternative_energy',
            'alternative_energy'
        ]);

        $P_COL_WATER = $this->firstCol($colsProf, [
            'physical_water',
            'water'
        ]);

        $P_COL_WATER_SUPPLY = $this->firstCol($colsProf, [
            'phys_water_supply',
            'water_supply'
        ]);

        $P_COL_WATER_SOURCES = $this->firstCol($colsProf, [
            'phys_water_sources',
            'water_sources'
        ]);

        $P_COL_BUY_WATER = $this->firstCol($colsProf, [
            'phys_buy_water',
            'buy_water'
        ]);

        $P_COL_WASTE = $this->firstCol($colsProf, [
            'physical_waste',
            'waste'
        ]);

        $district    = trim((string) $request->get('district', ''));
        $subdistrict = trim((string) $request->get('subdistrict', ''));
        $surveyYear  = trim((string) $request->get('survey_year', ''));

        $q = $conn->table(DB::raw('[dbo].[survey_a] as u'));

        // FIX: join house_id และ year แบบ trim/convert ให้สะอาด
        if ($COL_HOUSE && $P_COL_HOUSE) {
            $q->leftJoin(DB::raw('[dbo].[survey_profile64] as p'), function ($join) use ($COL_HOUSE, $P_COL_HOUSE, $COL_YEAR, $P_COL_YEAR) {
                $join->on(
                    DB::raw("LTRIM(RTRIM(CONVERT(nvarchar(50), u.[$COL_HOUSE])))"),
                    '=',
                    DB::raw("LTRIM(RTRIM(CONVERT(nvarchar(50), p.[$P_COL_HOUSE])))")
                );

                if ($COL_YEAR && $P_COL_YEAR) {
                    $join->on(
                        DB::raw("TRY_CONVERT(int, NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(20), u.[$COL_YEAR]))), ''))"),
                        '=',
                        DB::raw("TRY_CONVERT(int, NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(20), p.[$P_COL_YEAR]))), ''))")
                    );
                }
            });
        }

        $districtRef = $P_COL_DISTRICT ? "p.[$P_COL_DISTRICT]" : ($COL_DISTRICT ? "u.[$COL_DISTRICT]" : null);
        $tambonRef   = $P_COL_TAMBON   ? "p.[$P_COL_TAMBON]"   : ($COL_TAMBON ? "u.[$COL_TAMBON]" : null);
        $provinceRef = $P_COL_PROVINCE ? "p.[$P_COL_PROVINCE]" : ($COL_PROVINCE ? "u.[$COL_PROVINCE]" : null);

        if ($district !== '' && $districtRef) {
            $q->whereRaw("LTRIM(RTRIM($districtRef)) = ?", [$district]);
        }

        if ($subdistrict !== '' && $tambonRef) {
            $q->whereRaw("LTRIM(RTRIM($tambonRef)) = ?", [$subdistrict]);
        }

        // FIX: ใช้ COALESCE ระหว่าง p.year กับ u.year
        $yearExpr = null;
        if ($P_COL_YEAR && $COL_YEAR) {
            $yearExpr = "
                COALESCE(
                    NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(20), p.[$P_COL_YEAR]))), N''),
                    NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(20), u.[$COL_YEAR]))), N'')
                )
            ";
        } elseif ($P_COL_YEAR) {
            $yearExpr = "p.[$P_COL_YEAR]";
        } elseif ($COL_YEAR) {
            $yearExpr = "u.[$COL_YEAR]";
        }

        if ($surveyYear !== '' && ctype_digit($surveyYear)) {
            if ($P_COL_YEAR && $COL_YEAR) {
                $q->whereRaw("
                    TRY_CONVERT(int,
                        COALESCE(
                            NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(20), p.[$P_COL_YEAR]))), N''),
                            NULLIF(LTRIM(RTRIM(CONVERT(nvarchar(20), u.[$COL_YEAR]))), N'')
                        )
                    ) = ?
                ", [(int) $surveyYear]);
            } elseif ($P_COL_YEAR) {
                $q->whereRaw("TRY_CONVERT(int, p.[$P_COL_YEAR]) = ?", [(int) $surveyYear]);
            } elseif ($COL_YEAR) {
                $q->whereRaw("TRY_CONVERT(int, u.[$COL_YEAR]) = ?", [(int) $surveyYear]);
            }
        }

        $sel = fn(?string $expr, string $alias) =>
            $expr ? DB::raw("$expr as [$alias]") : DB::raw("NULL as [$alias]");

        $latExpr  = $P_COL_LAT ? "p.[$P_COL_LAT]" : null;
        $lngExpr  = $P_COL_LNG ? "p.[$P_COL_LNG]" : null;

        $q->select([
            $sel($COL_HOUSE ? "u.[$COL_HOUSE]" : null, 'house_Id'),
            $sel($yearExpr, 'survey_Year'),

            $sel($provinceRef, 'survey_Province'),
            $sel($districtRef, 'survey_District'),
            $sel($tambonRef, 'survey_Subdistrict'),

            $sel($P_COL_POSTCODE ? "p.[$P_COL_POSTCODE]" : null, 'survey_Postcode'),
            $sel($P_COL_PHONE ? "p.[$P_COL_PHONE]" : null, 'survey_Informer_phone'),

            $sel($P_COL_HOUSE_NO ? "p.[$P_COL_HOUSE_NO]" : null, 'house_Number'),
            $sel($P_COL_MOO ? "p.[$P_COL_MOO]" : null, 'village_No'),
            $sel($P_COL_VILLAGE ? "p.[$P_COL_VILLAGE]" : null, 'village_Name'),

            $sel($latExpr, 'latitude'),
            $sel($lngExpr, 'longitude'),

            $sel($P_COL_TITLE ? "p.[$P_COL_TITLE]" : null, 'survey_Householder_title'),
            $sel($P_COL_FNAME ? "p.[$P_COL_FNAME]" : null, 'survey_Householder_fname'),
            $sel($P_COL_LNAME ? "p.[$P_COL_LNAME]" : null, 'survey_Householder_lname'),
            $sel($P_COL_CID ? "p.[$P_COL_CID]" : null, 'survey_Householder_cid'),

            $sel($P_COL_HOUSE_CONDITION ? "p.[$P_COL_HOUSE_CONDITION]" : null, 'house_condition'),
            $sel($P_COL_SANITATION ? "p.[$P_COL_SANITATION]" : null, 'sanitation'),
            $sel($P_COL_ROAD_ACCESS ? "p.[$P_COL_ROAD_ACCESS]" : null, 'road_access'),
            $sel($P_COL_DRAINAGE ? "p.[$P_COL_DRAINAGE]" : null, 'drainage'),
            $sel($P_COL_ELECTRIC ? "p.[$P_COL_ELECTRIC]" : null, 'electric'),
            $sel($P_COL_MOBILE ? "p.[$P_COL_MOBILE]" : null, 'mobile'),
            $sel($P_COL_HOME_ROUTE ? "p.[$P_COL_HOME_ROUTE]" : null, 'home_route'),
            $sel($P_COL_OTHER121 ? "p.[$P_COL_OTHER121]" : null, 'other121'),
            $sel($P_COL_ALT_ENERGY ? "p.[$P_COL_ALT_ENERGY]" : null, 'alternative_energy'),
            $sel($P_COL_WATER ? "p.[$P_COL_WATER]" : null, 'water'),
            $sel($P_COL_WATER_SUPPLY ? "p.[$P_COL_WATER_SUPPLY]" : null, 'water_supply'),
            $sel($P_COL_WATER_SOURCES ? "p.[$P_COL_WATER_SOURCES]" : null, 'water_sources'),
            $sel($P_COL_BUY_WATER ? "p.[$P_COL_BUY_WATER]" : null, 'buy_water'),
            $sel($P_COL_WASTE ? "p.[$P_COL_WASTE]" : null, 'waste'),
        ]);

        return [$q, [
            'conn'           => $conn,
            'COL_HOUSE'      => $COL_HOUSE,
            'P_COL_DISTRICT' => $P_COL_DISTRICT,
            'P_COL_TAMBON'   => $P_COL_TAMBON,
            'P_COL_LAT'      => $P_COL_LAT,
            'P_COL_LNG'      => $P_COL_LNG,
        ]];
    }

    private function score(array $r): int
    {
        $score = 0;

        if (($r['house_condition'] ?? '') === 'ทรุดโทรม') $score += 30;
        if (($r['sanitation'] ?? '') === 'ไม่มี') $score += 20;
        if (($r['sanitation'] ?? '') === 'ไม่มาตรฐาน') $score += 12;
        if (($r['drainage'] ?? '') === 'ไม่มี') $score += 15;
        if (($r['electric'] ?? '') === 'ต่อพ่วง') $score += 10;
        if (($r['electric'] ?? '') === 'ไม่มี') $score += 15;
        if (($r['water'] ?? '') === 'ไม่เพียงพอ') $score += 10;
        if (($r['road_access'] ?? '') === 'ยาก') $score += 10;
        if (($r['waste'] ?? '') === 'ไม่เหมาะสม') $score += 10;

        return min(100, $score);
    }

    private function level(int $score): array
    {
        if ($score >= 75) return ['label' => 'ด่วนมาก', 'badge' => 'bg-danger'];
        if ($score >= 50) return ['label' => 'ด่วน', 'badge' => 'bg-warning text-dark'];
        if ($score >= 25) return ['label' => 'เฝ้าระวัง', 'badge' => 'bg-info text-dark'];
        return ['label' => 'ปกติ', 'badge' => 'bg-success'];
    }

    private function normalizeRow(array $r): array
    {
        $r['house_id']     = $r['house_id'] ?? ($r['house_Id'] ?? null);
        $r['district']     = $r['district'] ?? ($r['survey_District'] ?? null);
        $r['subdistrict']  = $r['subdistrict'] ?? ($r['survey_Subdistrict'] ?? null);
        $r['village_no']   = $r['village_no'] ?? ($r['village_No'] ?? null);
        $r['village_name'] = $r['village_name'] ?? ($r['village_Name'] ?? null);
        $r['lat']          = $r['lat'] ?? ($r['latitude'] ?? null);
        $r['lng']          = $r['lng'] ?? ($r['longitude'] ?? null);

        return $r;
    }

    private function enrichCollection($rows)
    {
        return collect($rows)->map(function ($r) {
            $r = $this->normalizeRow((array) $r);

            $s   = $this->score($r);
            $lvl = $this->level($s);

            $r['score'] = $s;
            $r['level'] = $lvl['label'];
            $r['badge'] = $lvl['badge'];

            return $r;
        });
    }

    private function tableColsMap($conn, string $table): array
    {
        return collect($conn->select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA='dbo' AND TABLE_NAME=?
        ", [$table]))
            ->pluck('COLUMN_NAME')
            ->mapWithKeys(fn($c) => [strtoupper((string) $c) => (string) $c])
            ->toArray();
    }

    private function firstCol(array $colsMap, array $candidates): ?string
    {
        foreach ($candidates as $c) {
            $key = strtoupper($c);
            if (isset($colsMap[$key])) {
                return $colsMap[$key];
            }
        }
        return null;
    }
}