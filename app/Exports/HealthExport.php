<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class HealthExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithColumnFormatting,
    WithStyles,
    WithEvents
{
    protected $rows;

    public function __construct($rows)
    {
        $this->rows = collect($rows);
    }

    public function collection()
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'ปีที่สำรวจ',
            'รหัสบ้าน',
            'ชื่อ',
            'สกุล',
            'อายุ(ปี)',
            'เพศ',
            'สุขภาพ',
            'อำเภอ',
            'ตำบล',
            'บัตรประชาชน',
            'เบอร์โทร',
            'ละติจูด',
            'ลองจิจูด',
            'บ้านเลขที่',
            'หมู่ที่',
            'ชื่อหมู่บ้าน',
            'รหัสไปรษณีย์',
        ];
    }
public function map($r): array
{
    return [
        data_get($r, 'survey_Year', ''),
        data_get($r, 'house_Id', ''),
        data_get($r, 'human_Member_fname', ''),
        data_get($r, 'human_Member_lname', ''),
        data_get($r, 'human_Age_y', ''),
        data_get($r, 'human_Sex', ''),
        data_get($r, 'human_Health', ''),
        data_get($r, 'survey_District', ''),
        data_get($r, 'survey_Subdistrict', ''),

        data_get($r, 'human_Member_cid')
            ? "'" . data_get($r, 'human_Member_cid')
            : '',

        data_get($r, 'survey_Informer_phone')
            ? "'" . data_get($r, 'survey_Informer_phone')
            : '',

        data_get($r, 'latitude', ''),
        data_get($r, 'longitude', ''),
        data_get($r, 'house_Number', ''),
        data_get($r, 'village_No', ''),
        data_get($r, 'village_Name', ''),
        data_get($r, 'survey_Postcode', ''),
    ];
}
   

    public function columnFormats(): array
    {
        return [
            'J' => NumberFormat::FORMAT_TEXT,
            'K' => NumberFormat::FORMAT_TEXT,
            'L' => NumberFormat::FORMAT_TEXT,
            'M' => NumberFormat::FORMAT_TEXT,
            'Q' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'name' => 'TH Sarabun New',
                    'size' => 16,
                ],

                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => '0B7F6F',
                    ],
                ],

                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                // ======================
                // ฟอนต์
                // ======================

                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
                    ->getFont()
                    ->setName('TH Sarabun New')
                    ->setSize(14);

                // ======================
                // ความสูงหัวตาราง
                // ======================

                $sheet->getRowDimension(1)->setRowHeight(28);

                // ======================
                // freeze
                // ======================

                $sheet->freezePane('A2');

                // ======================
                // auto filter
                // ======================

                $sheet->setAutoFilter(
                    "A1:{$highestColumn}{$highestRow}"
                );

                // ======================
                // border
                // ======================

                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->getColor()
                    ->setRGB('D8E6E1');

                // ======================
                // alignment
                // ======================

                $sheet->getStyle("A:Q")
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle("A:A")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("E:F")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("J:Q")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // ======================
                // สีแถวสลับ
                // ======================

                for ($row = 2; $row <= $highestRow; $row++) {

                    if ($row % 2 == 0) {

                        $sheet->getStyle(
                            "A{$row}:{$highestColumn}{$row}"
                        )
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB('F6FFFB');
                    }
                }

                // ======================
                // width
                // ======================

                $sheet->getColumnDimension('A')->setWidth(14);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('C')->setWidth(18);
                $sheet->getColumnDimension('D')->setWidth(20);
                $sheet->getColumnDimension('E')->setWidth(12);
                $sheet->getColumnDimension('F')->setWidth(12);
                $sheet->getColumnDimension('G')->setWidth(42);
                $sheet->getColumnDimension('H')->setWidth(20);
                $sheet->getColumnDimension('I')->setWidth(20);
                $sheet->getColumnDimension('J')->setWidth(24);
                $sheet->getColumnDimension('K')->setWidth(20);
                $sheet->getColumnDimension('L')->setWidth(18);
                $sheet->getColumnDimension('M')->setWidth(18);
                $sheet->getColumnDimension('N')->setWidth(18);
                $sheet->getColumnDimension('O')->setWidth(12);
                $sheet->getColumnDimension('P')->setWidth(24);
                $sheet->getColumnDimension('Q')->setWidth(14);

                // ======================
                // wrap text
                // ======================

                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
                    ->getAlignment()
                    ->setWrapText(true);
            }
        ];
    }
}