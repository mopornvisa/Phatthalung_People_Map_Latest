<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class DeathSummaryImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows->skip(1) as $row) {

            DB::connection('mysql_help')->table('death_summary')->insert([
    'year_th'          => $row[0] ?? null,
    'month_no'         => $row[1] ?? null,
    'district_name_th' => $row[2] ?? null,
    'sex_name_th'      => $row[3] ?? null,
    'age_group'        => $row[4] ?? null,
    'cause_of_death'   => $row[5] ?? null,
    'death_total'      => $row[6] ?? 0,
    'created_at'       => now(),
    'updated_at'       => now(),
]);

        }
    }
}