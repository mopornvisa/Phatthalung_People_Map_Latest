<?php

namespace App\Exports;

use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WelfareExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'เลขครัวเรือน',
            'ลำดับที่',
            'ชื่อ',
            'นามสกุล',
            'เลขบัตรประชาชน',
            'จังหวัด',
            'อำเภอ',
            'ตำบล',
            'ปีสำรวจ',
            'อายุ',
            'เพศ',
            'บ้านเลขที่',
            'หมู่ที่',
            'ชื่อหมู่บ้าน',
            'รหัสไปรษณีย์',
            'เบอร์โทร',
            'ละติจูด',
            'ลองจิจูด',
            'สถานะรับสวัสดิการ',
            'เด็กแรกเกิด',
            'เบี้ยผู้สูงอายุ/คนชรา',
            'เบี้ยคนพิการ',
            'ประกันสังคม (ม.33)',
            'ประกันตนเอง (ม.40)',
            'บัตรสวัสดิการแห่งรัฐ',
        ];
    }

    public function map($r): array
    {
        return [
            $r->HC ?? '',
            $r->a1 ?? '',
            $r->a2_2 ?? '',
            $r->a2_3 ?? '',
            $r->popid ?? '',
            $r->province_name_thai ?? '',
            $r->district_name_thai ?? '',
            $r->tambon_name_thai ?? '',
            $r->survey_year ?? '',
            $r->a3_1 ?? '',
            $r->a4 ?? '',
            $r->house_number ?? '',
            $r->village_no ?? '',
            $r->village_name ?? '',
            $r->postcode ?? '',
            $r->TEL ?? '',
            $r->latx ?? '',
            $r->lngy ?? '',
            $r->a7_0 ?? '',
            $r->a7_1 ?? '',
            $r->a7_2 ?? '',
            $r->a7_3 ?? '',
            $r->a7_4 ?? '',
            $r->a7_5 ?? '',
            $r->a7_6 ?? '',
        ];
    }
}