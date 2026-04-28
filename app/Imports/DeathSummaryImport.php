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

            if (
                empty($row[0]) &&
                empty($row[2]) &&
                empty($row[5])
            ) {
                continue;
            }

            DB::connection('mysql_help')->table('death_summary')->insert([
                'year_th'          => $row[0] ?? null,
                'month_no'         => $row[1] ?? null,
                'province_name_th' => $row[2] ?? null,
                'district_name_th' => $row[3] ?? null,
                'sex_name_th'      => $row[4] ?? null,
                'age_group'        => $this->mapAgeGroup($row[5] ?? null),
                'cause_of_death'   => $row[6] ?? null,
                'death_total'      => is_numeric($row[7] ?? null) ? (int) $row[7] : 0,
                'created_at' => \Carbon\Carbon::now('Asia/Bangkok'),
                'updated_at' => \Carbon\Carbon::now('Asia/Bangkok'),
            ]);
        }
    }

    private function mapAgeGroup($age)
    {
        if ($age === null || $age === '') {
            return null;
        }

        $ageText = trim((string) $age);

        if (in_array($ageText, ['0-5', '6-24', '25-59', '60+'])) {
            return $ageText;
        }

        if (is_numeric($ageText)) {
            $ageNum = (int) $ageText;

            if ($ageNum >= 0 && $ageNum <= 5) {
                return '0-5';
            }

            if ($ageNum >= 6 && $ageNum <= 24) {
                return '6-24';
            }

            if ($ageNum >= 25 && $ageNum <= 59) {
                return '25-59';
            }

            if ($ageNum >= 60) {
                return '60+';
            }
        }

        return $ageText;
    }
}