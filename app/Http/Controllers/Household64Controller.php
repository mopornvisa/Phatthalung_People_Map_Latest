<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Household64Controller extends Controller
{
    public function index(Request $request)
    {
        $conn = DB::connection('sqlsrv');

        // ======================
        // 1) เลือกตารางอัตโนมัติ
        // ======================
        $tables = collect($conn->select("
            SELECT TABLE_SCHEMA, TABLE_NAME
            FROM INFORMATION_SCHEMA.TABLES
            WHERE TABLE_TYPE='BASE TABLE'
        "));

        $has64 = $tables->contains(fn($t) =>
            strtolower((string)$t->TABLE_SCHEMA) === 'dbo' &&
            strtolower((string)$t->TABLE_NAME) === 'survey_profile64'
        );

        $hasProfile = $tables->contains(fn($t) =>
            strtolower((string)$t->TABLE_SCHEMA) === 'dbo' &&
            strtolower((string)$t->TABLE_NAME) === 'survey_profile'
        );

        $tableName = $has64 ? 'survey_profile64' : ($hasProfile ? 'survey_profile' : null);
        if (!$tableName) abort(404, 'ไม่พบตาราง survey_profile64 หรือ survey_profile');

        // ======================
        // 2) รายชื่อคอลัมน์ของตาราง survey (s)
        // ======================
        $colsS = collect($conn->select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA='dbo' AND TABLE_NAME=?
        ", [$tableName]))
            ->pluck('COLUMN_NAME')
            ->map(fn($c) => strtoupper((string)$c))
            ->toArray();

        // ======================
        // 3) ตรวจตารางอื่น ๆ
        // ======================
        $hasPPP = $tables->contains(fn($t) =>
            strtolower((string)$t->TABLE_SCHEMA) === 'dbo' &&
            strtolower((string)$t->TABLE_NAME) === 'ppp'
        );

        $colsP = [];
        if ($hasPPP) {
            $colsP = collect($conn->select("
                SELECT COLUMN_NAME
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA='dbo' AND TABLE_NAME='PPP'
            "))
                ->pluck('COLUMN_NAME')
                ->map(fn($c) => strtoupper((string)$c))
                ->toArray();
        }

        $hasTambon   = $tables->contains(fn($t) => strtolower((string)$t->TABLE_SCHEMA)==='dbo' && strtolower((string)$t->TABLE_NAME)==='tambon');
        $hasDistrict = $tables->contains(fn($t) => strtolower((string)$t->TABLE_SCHEMA)==='dbo' && strtolower((string)$t->TABLE_NAME)==='district');
        $hasProvince = $tables->contains(fn($t) => strtolower((string)$t->TABLE_SCHEMA)==='dbo' && strtolower((string)$t->TABLE_NAME)==='province');

        $colsT  = $hasTambon   ? $this->tableColsUpper($conn, 'tambon')   : [];
        $colsD  = $hasDistrict ? $this->tableColsUpper($conn, 'district') : [];
        $colsPr = $hasProvince ? $this->tableColsUpper($conn, 'province') : [];

        // ======================
        // 4) helper select
        // ======================
        $optS = function (string $col, ?string $alias = null) use ($colsS) {
            $alias = $alias ?: $col;
            return in_array(strtoupper($col), $colsS, true)
                ? DB::raw("[s].[$col] as [$alias]")
                : DB::raw("NULL as [$alias]");
        };

        $optP = function (string $col, ?string $alias = null) use ($colsP) {
            $alias = $alias ?: $col;
            return in_array(strtoupper($col), $colsP, true)
                ? DB::raw("[p].[$col] as [$alias]")
                : DB::raw("NULL as [$alias]");
        };

        // ======================
        // 5) mapping ชื่อคอลัมน์
        // ======================
        $personExpr = $this->pickFirstExisting($colsS, ['PERSON', 'PERSON_NAME', 'NAME'], 'PERSON', 's');
        $prefixExpr = $this->pickFirstExisting($colsS, ['PREFIX', 'PERSON_PREFIX'], 'PREFIX', 's');
        $popidExpr  = $this->coalesceFirstExisting($colsS, ['POPID', 'PERSON_POPID', 'PERSON_POPID1'], 'popid', 's');
        $telExpr    = $this->pickFirstExisting($colsS, ['TEL', 'PHONE'], 'TEL', 's');
        $hhmExpr    = $this->pickFirstExisting($colsS, ['HHM'], 'HHM', 's');

        // ✅ หาคอลัมน์คำนำหน้าที่มีจริง
        $prefixCol = $this->firstCol($colsS, ['PREFIX', 'PERSON_PREFIX']);

        // ✅ หาคอลัมน์ join HC ของฝั่ง survey และ PPP
        $sHouseJoinCol = $this->firstCol($colsS, ['HC', 'HC1']);
        $pHouseJoinCol = $this->firstCol($colsP, ['HC', 'HC1']);

        // ✅ คอลัมน์อื่นที่อาจใช้ filter
        $sTelCol = $this->firstCol($colsS, ['TEL', 'PHONE']);
        $pLatCol = $this->firstCol($colsP, ['LAT', 'LATX', 'lat']);
        $pLngCol = $this->firstCol($colsP, ['LNG', 'LNGY', 'Lng', 'lng']);

        // ======================
        // 6) รับค่าฟิลเตอร์จากหน้า Blade
        // ======================
        $qText      = trim((string)$request->get('q', ''));
        $year       = trim((string)$request->get('survey_year', ''));
        $survey_no  = trim((string)$request->get('survey_no', ''));

        $HC       = trim((string)$request->get('HC', ''));
        $AGRI     = trim((string)$request->get('AGRI', ''));
        $AGRI_NO  = trim((string)$request->get('AGRI_NO', ''));
        $MBNO     = trim((string)$request->get('MBNO', ''));
        $MB       = trim((string)$request->get('MB', ''));
        $MM       = trim((string)$request->get('MM', ''));
        $TMP      = trim((string)$request->get('TMP', ''));
        $AMP      = trim((string)$request->get('AMP', ''));
        $JUN      = trim((string)$request->get('JUN', ''));
        $POSTCODE = trim((string)$request->get('POSTCODE', ''));
        $PREFIX   = trim((string)$request->get('PREFIX', ''));
        $TEL      = trim((string)$request->get('TEL', ''));
        $HHM      = trim((string)$request->get('HHM', ''));
        $lat      = trim((string)$request->get('lat', ''));
        $Lng      = trim((string)$request->get('Lng', ''));

        $tambon_name_thai   = trim((string)$request->get('tambon_name_thai',''));
        $district_name_thai = trim((string)$request->get('district_name_thai',''));
        $province_name_thai = trim((string)$request->get('province_name_thai',''));

        // ======================
        // 7) Build Query
        // ======================
        $q = $conn->table("dbo.$tableName as s");

        if ($hasPPP && $sHouseJoinCol && $pHouseJoinCol) {
            $q->leftJoin('dbo.PPP as p', "p.$pHouseJoinCol", '=', "s.$sHouseJoinCol");
        }

        $tKey  = $hasTambon   ? $this->firstCol($colsT,  ['TAMBON_CODE','TAMBON_ID','CODE','ID']) : null;
        $dKey  = $hasDistrict ? $this->firstCol($colsD,  ['DISTRICT_CODE','AMPHUR_CODE','DISTRICT_ID','CODE','ID']) : null;
        $prKey = $hasProvince ? $this->firstCol($colsPr, ['PROVINCE_CODE','CHANGWAT_CODE','PROVINCE_ID','CODE','ID']) : null;

        $tName  = $hasTambon   ? $this->firstCol($colsT,  ['TAMBON_NAME_THAI','TAMBON_NAME','NAME_THAI','NAME']) : null;
        $dName  = $hasDistrict ? $this->firstCol($colsD,  ['DISTRICT_NAME_THAI','DISTRICT_NAME','NAME_THAI','NAME']) : null;
        $prName = $hasProvince ? $this->firstCol($colsPr, ['PROVINCE_NAME_THAI','PROVINCE_NAME','NAME_THAI','NAME']) : null;

        if ($hasTambon && $tKey && in_array('TMP', $colsS, true)) {
            $q->leftJoin('dbo.tambon as t', function($join) use ($tKey) {
                $join->on(DB::raw("LEFT([s].[TMP],6)"), '=', DB::raw("[t].[$tKey]"));
            });
        }

        if ($hasDistrict && $dKey && in_array('AMP', $colsS, true)) {
            $q->leftJoin('dbo.district as d', function($join) use ($dKey) {
                $join->on(DB::raw("[s].[AMP]"), '=', DB::raw("[d].[$dKey]"));
            });
        }

        if ($hasProvince && $prKey && in_array('JUN', $colsS, true)) {
            $q->leftJoin('dbo.province as pr', function($join) use ($prKey) {
                $join->on(DB::raw("[s].[JUN]"), '=', DB::raw("[pr].[$prKey]"));
            });
        }

        // ======================
        // 8) SELECT
        // ======================
        $q->select([
            $optS('HC'),
            $optS('survey_year'),
            $optS('survey_no'),
            $optS('AGRI'),
            $optS('AGRI_NO'),
            $optS('MBNO'),
            $optS('MB'),
            $optS('MM'),
            $optS('TMP'),
            $optS('AMP'),
            $optS('JUN'),
            $optS('POSTCODE'),

            ($hasTambon && $tName)   ? DB::raw("[t].[$tName] as [tambon_name_thai]")     : DB::raw("NULL as [tambon_name_thai]"),
            ($hasDistrict && $dName) ? DB::raw("[d].[$dName] as [district_name_thai]")   : DB::raw("NULL as [district_name_thai]"),
            ($hasProvince && $prName)? DB::raw("[pr].[$prName] as [province_name_thai]") : DB::raw("NULL as [province_name_thai]"),

            $prefixExpr,
            $personExpr,
            $popidExpr,
            $telExpr,
            $hhmExpr,

            $hasPPP ? $optP('PPP') : DB::raw("NULL as [PPP]"),
            $hasPPP ? $optP($pLatCol ?: 'lat', 'lat') : DB::raw("NULL as [lat]"),
            $hasPPP ? $optP($pLngCol ?: 'Lng', 'Lng') : DB::raw("NULL as [Lng]"),
        ]);

        if ($sHouseJoinCol) {
            $q->whereNotNull("s.$sHouseJoinCol")
              ->whereRaw("LTRIM(RTRIM(COALESCE([s].[$sHouseJoinCol],''))) <> ''");
        }

        // ======================
        // 9) APPLY FILTERS
        // ======================
        if ($year !== '' && in_array($year, ['2564','2565','2566','2567','2568'], true) && in_array('SURVEY_YEAR', $colsS, true)) {
            $q->whereRaw("CAST([s].[survey_year] as varchar(10)) = ?", [$year]);
        }

        if ($survey_no !== '' && in_array('SURVEY_NO', $colsS, true)) {
            $q->where('s.survey_no', 'like', "%{$survey_no}%");
        }

        if ($HC !== '' && $sHouseJoinCol) $q->where("s.$sHouseJoinCol", 'like', "%{$HC}%");
        if ($AGRI !== '' && in_array('AGRI', $colsS, true)) $q->where('s.AGRI', 'like', "%{$AGRI}%");
        if ($AGRI_NO !== '' && in_array('AGRI_NO', $colsS, true)) $q->where('s.AGRI_NO', 'like', "%{$AGRI_NO}%");
        if ($MBNO !== '' && in_array('MBNO', $colsS, true)) $q->where('s.MBNO', 'like', "%{$MBNO}%");
        if ($MB !== '' && in_array('MB', $colsS, true)) $q->where('s.MB', 'like', "%{$MB}%");
        if ($MM !== '' && in_array('MM', $colsS, true)) $q->where('s.MM', 'like', "%{$MM}%");
        if ($TMP !== '' && in_array('TMP', $colsS, true)) $q->where('s.TMP', 'like', "%{$TMP}%");
        if ($AMP !== '' && in_array('AMP', $colsS, true)) $q->where('s.AMP', 'like', "%{$AMP}%");
        if ($JUN !== '' && in_array('JUN', $colsS, true)) $q->where('s.JUN', 'like', "%{$JUN}%");
        if ($POSTCODE !== '' && in_array('POSTCODE', $colsS, true)) $q->where('s.POSTCODE', 'like', "%{$POSTCODE}%");

        if ($PREFIX !== '' && $prefixCol) {
            $mapTextToCode = [
                'เด็กชาย'  => '1',
                'เด็กหญิง' => '2',
                'นาย'      => '3',
                'นางสาว'   => '4',
                'นาง'      => '5',
            ];
            $p = trim($PREFIX);
            if (isset($mapTextToCode[$p])) $p = $mapTextToCode[$p];

            $q->whereRaw("CAST([s].[$prefixCol] as varchar(10)) = ?", [$p]);
        }

        if ($TEL !== '' && $sTelCol) {
            $q->where("s.$sTelCol", 'like', "%{$TEL}%");
        }

        if ($HHM !== '' && in_array('HHM', $colsS, true)) {
            $q->where('s.HHM', 'like', "%{$HHM}%");
        }

        if ($hasPPP) {
            if ($lat !== '' && $pLatCol) $q->where("p.$pLatCol", 'like', "%{$lat}%");
            if ($Lng !== '' && $pLngCol) $q->where("p.$pLngCol", 'like', "%{$Lng}%");
        }

        if ($tambon_name_thai !== '' && $hasTambon && $tName) {
            $q->whereRaw("LTRIM(RTRIM([t].[$tName])) LIKE ?", ["%{$tambon_name_thai}%"]);
        }
        if ($district_name_thai !== '' && $hasDistrict && $dName) {
            $q->whereRaw("LTRIM(RTRIM([d].[$dName])) LIKE ?", ["%{$district_name_thai}%"]);
        }
        if ($province_name_thai !== '' && $hasProvince && $prName) {
            $q->whereRaw("LTRIM(RTRIM([pr].[$prName])) LIKE ?", ["%{$province_name_thai}%"]);
        }

        if ($qText !== '') {
            $like = "%$qText%";
            $q->where(function($w) use ($like, $colsS, $hasTambon, $hasDistrict, $hasProvince, $tName, $dName, $prName, $prefixCol, $sHouseJoinCol, $sTelCol) {
                if ($sHouseJoinCol) {
                    $w->orWhere("s.$sHouseJoinCol", 'like', $like);
                }

                if (in_array('PERSON', $colsS, true)) {
                    $w->orWhere('s.PERSON', 'like', $like);
                } elseif (in_array('PERSON_NAME', $colsS, true)) {
                    $w->orWhere('s.PERSON_NAME', 'like', $like);
                } elseif (in_array('NAME', $colsS, true)) {
                    $w->orWhere('s.NAME', 'like', $like);
                }

                if ($sTelCol) {
                    $w->orWhere("s.$sTelCol", 'like', $like);
                }

                if ($prefixCol) {
                    $w->orWhereRaw("CAST([s].[$prefixCol] as varchar(10)) LIKE ?", [$like]);
                }

                if (in_array('MBNO', $colsS, true)) $w->orWhere('s.MBNO', 'like', $like);
                if (in_array('MB', $colsS, true))   $w->orWhere('s.MB', 'like', $like);
                if (in_array('MM', $colsS, true))   $w->orWhere('s.MM', 'like', $like);

                if ($hasTambon && $tName)   $w->orWhereRaw("LTRIM(RTRIM([t].[$tName])) LIKE ?", [$like]);
                if ($hasDistrict && $dName) $w->orWhereRaw("LTRIM(RTRIM([d].[$dName])) LIKE ?", [$like]);
                if ($hasProvince && $prName)$w->orWhereRaw("LTRIM(RTRIM([pr].[$prName])) LIKE ?", [$like]);
            });
        }

        // ======================
        // 10) sort + paginate + debugCount
        // ======================
        if (in_array('SURVEY_YEAR', $colsS, true)) {
            $q->orderByDesc('s.survey_year');
        }

        if ($sHouseJoinCol) {
            $q->orderBy("s.$sHouseJoinCol");
        }

        $debugCount = (clone $q)->count();
        $surveys    = $q->paginate(25)->withQueryString();

        return view('household_64', [
            'surveys'     => $surveys,
            'tableName'   => $tableName,
            'debugCount'  => $debugCount,
            'hasPPP'      => $hasPPP,
            'q'           => $qText,
            'survey_year' => $year,
            'yearList'    => [2564,2565,2566,2567,2568],

            'tambon_name_thai'   => $tambon_name_thai,
            'district_name_thai' => $district_name_thai,
            'province_name_thai' => $province_name_thai,
        ]);
    }

    private function tableColsUpper($conn, string $table): array
    {
        return collect($conn->select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA='dbo' AND TABLE_NAME=?
        ", [$table]))
            ->pluck('COLUMN_NAME')
            ->map(fn($c) => strtoupper((string)$c))
            ->toArray();
    }

    private function firstCol(array $colsUpper, array $candidates): ?string
    {
        foreach ($candidates as $c) {
            if (in_array(strtoupper($c), $colsUpper, true)) return $c;
        }
        return null;
    }

    private function pickFirstExisting(array $colsUpper, array $candidates, string $alias, string $tableAlias)
    {
        foreach ($candidates as $col) {
            if (in_array(strtoupper($col), $colsUpper, true)) {
                return DB::raw("[$tableAlias].[$col] as [$alias]");
            }
        }
        return DB::raw("NULL as [$alias]");
    }

    private function coalesceFirstExisting(array $colsUpper, array $candidates, string $alias, string $tableAlias)
    {
        $exists = [];
        foreach ($candidates as $col) {
            if (in_array(strtoupper($col), $colsUpper, true)) {
                $exists[] = "[$tableAlias].[$col]";
            }
        }
        if (count($exists) === 0) return DB::raw("NULL as [$alias]");
        if (count($exists) === 1) return DB::raw($exists[0] . " as [$alias]");
        return DB::raw("COALESCE(" . implode(',', $exists) . ") as [$alias]");
    }
}