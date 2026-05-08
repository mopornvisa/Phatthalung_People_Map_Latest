<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EconomyExport implements FromView
{
    protected $rows;

    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    public function view(): View
{
    $isChecked = function ($value) {
        return !is_null($value)
            && trim((string)$value) !== ''
            && (int)$value !== 0;
    };

    $rows = collect($this->rows)->map(function ($row) use ($isChecked) {

        $crop = [];
        if ($isChecked($row->c1_1_1 ?? null)) $crop[] = 'ทำนา';

        if ($isChecked($row->c1_1_2 ?? null)) {
            $text = 'ทำสวนผัก';
            if (!empty($row->c1_1_2_0)) $text .= ' (' . $row->c1_1_2_0 . ')';
            $crop[] = $text;
        }

        if ($isChecked($row->c1_1_3 ?? null)) {
            $text = 'ทำสวนผลไม้';
            if (!empty($row->c1_1_3_0)) $text .= ' (' . $row->c1_1_3_0 . ')';
            $crop[] = $text;
        }

        if ($isChecked($row->c1_1_4 ?? null)) {
            $crop[] = 'พืชไร่ เช่น มันสำปะหลัง อ้อย ถั่วเหลือง ถั่วอื่นๆ พริก ฯลฯ';
        }

        if ($isChecked($row->c1_1_5 ?? null)) {
            $crop[] = 'พืชอุตสาหกรรมอื่นๆ เช่น ยางพารา ปาล์มน้ำมัน';
        }

        $row->crop_text = count($crop)
            ? implode(' / ', $crop)
            : (((int)($row->c1_1_0 ?? -1) === 0) ? 'ไม่ได้เพาะปลูกพืชเกษตร' : '-');

        $livestock = [];
        if ($isChecked($row->c1_2_1 ?? null)) $livestock[] = 'สัตว์ปีก (เป็ด/ไก่/นก)';
        if ($isChecked($row->c1_2_2 ?? null)) $livestock[] = 'หมู/แพะ/แกะ/ลา/ล่อ';
        if ($isChecked($row->c1_2_3 ?? null)) $livestock[] = 'วัว/ควาย/ม้า';

        if ($isChecked($row->c1_2_4 ?? null)) {
            $text = 'อื่นๆ';
            if (!empty($row->c1_2_4_0)) $text .= ' (' . $row->c1_2_4_0 . ')';
            $livestock[] = $text;
        }

        $row->livestock_text = count($livestock)
            ? implode(' / ', $livestock)
            : (((int)($row->c1_2_0 ?? -1) === 0) ? 'ไม่ได้ทำปศุสัตว์' : '-');

        $fishery = [];
        if ($isChecked($row->c1_3_1 ?? null)) $fishery[] = 'ประมงน้ำเค็ม';
        if ($isChecked($row->c1_3_2 ?? null)) $fishery[] = 'ประมงน้ำจืด';

        $row->fishery_text = count($fishery)
            ? implode(' / ', $fishery)
            : (((int)($row->c1_3_0 ?? -1) === 0) ? 'ไม่ได้ทำประมง' : '-');

        return $row;
    });

    return view('exports.economy_export', [
        'rows' => $rows
    ]);
}
}