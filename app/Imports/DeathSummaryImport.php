<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;

class DeathSummaryImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            throw ValidationException::withMessages([
                'excel_file' => 'ไฟล์ไม่มีข้อมูล'
            ]);
        }

        // ✅ ไม่เข้ม: เช็กแค่ว่าแถวแรกมีหัวตารางครบ 8 ช่อง
        $headers = $rows->first()
            ->take(8)
            ->filter(fn ($value) => trim((string) $value) !== '')
            ->values()
            ->toArray();

        if (count($headers) < 8) {
            throw ValidationException::withMessages([
                'excel_file' => 'นำเข้าไม่ได้ กรุณาตรวจสอบว่าแถวแรกมีหัวตารางครบ 8 ช่อง'
            ]);
        }

        $now = Carbon::now('Asia/Bangkok');
        $insertData = [];

        foreach ($rows->skip(1) as $row) {
            if ($row->filter(fn ($v) => trim((string) $v) !== '')->isEmpty()) {
                continue;
            }

            $insertData[] = [
                'year_th'          => (int) trim((string) ($row[0] ?? '')),
                'month_no' => $this->convertMonth($row[1] ?? null),
                'province_name_th' => trim((string) ($row[2] ?? '')),
                'district_name_th' => trim((string) ($row[3] ?? '')),
                'sex_name_th'      => trim((string) ($row[4] ?? '')),
                'age_group'        => $this->mapAgeGroup($row[5] ?? null),
                'cause_of_death'   => trim((string) ($row[6] ?? '')),
                'death_total'      => is_numeric($row[7] ?? null) ? (int) $row[7] : 0,
                'created_at'       => $now,
                'updated_at'       => $now,
            ];
        }

        if (empty($insertData)) {
            throw ValidationException::withMessages([
                'excel_file' => 'ไม่พบข้อมูลสำหรับนำเข้า'
            ]);
        }

        foreach (array_chunk($insertData, 500) as $chunk) {
            DB::connection('mysql_help')
                ->table('death_summary')
                ->insert($chunk);
        }
    }

    private function mapAgeGroup($age)
    {
        if ($age === null || trim((string) $age) === '') {
            return null;
        }

        $ageText = trim((string) $age);

        if (in_array($ageText, ['0-5', '6-24', '25-59', '60+'])) {
            return $ageText;
        }

        if (is_numeric($ageText)) {
            $ageNum = (int) $ageText;

            if ($ageNum >= 0 && $ageNum <= 5) return '0-5';
            if ($ageNum >= 6 && $ageNum <= 24) return '6-24';
            if ($ageNum >= 25 && $ageNum <= 59) return '25-59';
            if ($ageNum >= 60) return '60+';
        }

        return $ageText;
    }
    private function convertMonth($value)
{
    $value = trim((string) $value);

    $months = [
        '1'=>1,'01'=>1,'มกราคม'=>1,'ม.ค.'=>1,'ม.ค'=>1,
        '2'=>2,'02'=>2,'กุมภาพันธ์'=>2,'ก.พ.'=>2,'ก.พ'=>2,
        '3'=>3,'03'=>3,'มีนาคม'=>3,'มี.ค.'=>3,'มี.ค'=>3,
        '4'=>4,'04'=>4,'เมษายน'=>4,'เม.ย.'=>4,'เม.ย'=>4,
        '5'=>5,'05'=>5,'พฤษภาคม'=>5,'พ.ค.'=>5,'พ.ค'=>5,
        '6'=>6,'06'=>6,'มิถุนายน'=>6,'มิ.ย.'=>6,'มิ.ย'=>6,
        '7'=>7,'07'=>7,'กรกฎาคม'=>7,'ก.ค.'=>7,'ก.ค'=>7,
        '8'=>8,'08'=>8,'สิงหาคม'=>8,'ส.ค.'=>8,'ส.ค'=>8,
        '9'=>9,'09'=>9,'กันยายน'=>9,'ก.ย.'=>9,'ก.ย'=>9,
        '10'=>10,'ตุลาคม'=>10,'ต.ค.'=>10,'ต.ค'=>10,
        '11'=>11,'พฤศจิกายน'=>11,'พ.ย.'=>11,'พ.ย'=>11,
        '12'=>12,'ธันวาคม'=>12,'ธ.ค.'=>12,'ธ.ค'=>12,
    ];

    return $months[$value] ?? null;
}
}