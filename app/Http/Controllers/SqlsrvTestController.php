<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlsrvTestController extends Controller
{
    public function index(Request $request)
    {
        $conn = DB::connection('sqlsrv');

        $tables   = [];
        $selected = $request->get('table');
        $rows     = [];
        $cols     = [];
        $count    = 0;
        $error    = null;

        $keyword = trim((string) $request->get('keyword', ''));
        $year    = trim((string) $request->get('year', ''));
        $limit   = (int) $request->get('limit', 20);
        $limit   = in_array($limit, [20, 50, 100, 200], true) ? $limit : 20;

        try {
            // =========================
            // 1) ดึงรายชื่อตาราง
            // =========================
            $dbTables = $conn->select("
                SELECT TABLE_SCHEMA, TABLE_NAME
                FROM INFORMATION_SCHEMA.TABLES
                WHERE TABLE_TYPE = 'BASE TABLE'
                ORDER BY TABLE_SCHEMA, TABLE_NAME
            ");

            foreach ($dbTables as $t) {
                $schema = (string) $t->TABLE_SCHEMA;
                $name   = (string) $t->TABLE_NAME;

                $tables[] = [
                    'schema' => $schema,
                    'name'   => $name,
                    'full'   => $schema . '.' . $name,
                ];
            }

            if (!$selected && !empty($tables)) {
                $selected = $tables[0]['full'];
            }

            if ($selected) {
                $parts = explode('.', $selected, 2);
                $schema = $parts[0] ?? 'dbo';
                $table  = $parts[1] ?? '';

                // กันชื่อแปลก
                $schema = preg_replace('/[^A-Za-z0-9_]/', '', $schema);
                $table  = preg_replace('/[^A-Za-z0-9_]/', '', $table);

                if ($table === '') {
                    throw new \Exception('ไม่พบชื่อตารางที่ถูกต้อง');
                }

                $fullTable = "[{$schema}].[{$table}]";

                // =========================
                // 2) ดึงรายชื่อคอลัมน์จริง
                // =========================
                $colRows = $conn->select("
                    SELECT COLUMN_NAME
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
                    ORDER BY ORDINAL_POSITION
                ", [$schema, $table]);

                $cols = collect($colRows)
                    ->pluck('COLUMN_NAME')
                    ->map(fn($c) => (string) $c)
                    ->values()
                    ->all();

                // หา column ปีที่อาจมีอยู่
                $yearColumn = null;
                foreach (['survey_year', 'year', 'yyyy', 'budget_year'] as $candidate) {
                    foreach ($cols as $col) {
                        if (strtolower($col) === strtolower($candidate)) {
                            $yearColumn = $col;
                            break 2;
                        }
                    }
                }

                // =========================
                // 3) สร้าง WHERE
                // =========================
                $whereParts = [];
                $bindings   = [];

                // ค้นหาตามปี
                if ($year !== '' && $yearColumn) {
                    $safeYearCol = str_replace(']', ']]', $yearColumn);
                    $whereParts[] = "[{$safeYearCol}] = ?";
                    $bindings[] = $year;
                }

                // ค้นหาคำทั่วไปทุกคอลัมน์
                if ($keyword !== '' && !empty($cols)) {
                    $searchParts = [];

                    foreach ($cols as $col) {
                        $safeCol = str_replace(']', ']]', $col);
                        $searchParts[] = "CAST([{$safeCol}] AS NVARCHAR(MAX)) LIKE ?";
                        $bindings[] = '%' . $keyword . '%';
                    }

                    if (!empty($searchParts)) {
                        $whereParts[] = '(' . implode(' OR ', $searchParts) . ')';
                    }
                }

                $whereSql = '';
                if (!empty($whereParts)) {
                    $whereSql = ' WHERE ' . implode(' AND ', $whereParts);
                }

                // =========================
                // 4) นับจำนวนข้อมูลหลังกรอง
                // =========================
                $countSql = "SELECT COUNT(*) AS total FROM {$fullTable}{$whereSql}";
                $countRow = $conn->selectOne($countSql, $bindings);
                $count    = (int) ($countRow->total ?? 0);

                // =========================
                // 5) ดึงข้อมูลตัวอย่าง
                // =========================
                $sql = "
                    SELECT TOP {$limit} *
                    FROM {$fullTable}
                    {$whereSql}
                ";

                $rows = $conn->select($sql, $bindings);
            }
        } catch (\Throwable $e) {
            $error = $e->getMessage();
        }

        return view('sqlsrv_test', compact(
            'tables',
            'selected',
            'rows',
            'cols',
            'count',
            'error'
        ));
    }
}