<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
</head>

<body style="font-family:'TH Sarabun New','Sarabun',sans-serif; font-size:14px; color:#0f172a;">

<table style="border-collapse:collapse; width:100%;">
    <thead>
    

        <tr>
            <th colspan="20"
                style="text-align:left; padding:10px 12px; background:#f0fdfa; border:1px solid #99f6e4;">
                <strong>ปี:</strong> {{ $survey_year !== '' ? $survey_year : 'ทั้งหมด' }}
                &nbsp;&nbsp;
                <strong>อำเภอ:</strong> {{ $district !== '' ? $district : 'ทุกอำเภอ' }}
                &nbsp;&nbsp;
                <strong>ตำบล:</strong> {{ $subdistrict !== '' ? $subdistrict : 'ทุกตำบล' }}
                &nbsp;&nbsp;
                <strong>สถานะ:</strong>
                @if($welfare === 'received')
                    ได้รับสวัสดิการ
                @elseif($welfare === 'not_received')
                    ไม่ได้รับสวัสดิการ
                @else
                    ทั้งหมด
                @endif
            </th>
        </tr>

        <tr>
            <th colspan="20" style="height:8px; background:#ffffff; border:none;"></th>
        </tr>

        <tr>
            @foreach([
                'ลำดับ','ปีที่สำรวจ','รหัสบ้าน','ลำดับในบ้าน','ชื่อ - นามสกุล',
                'เลขบัตรประชาชน','อายุ','เพศ','สถานะสวัสดิการ','ประเภทสวัสดิการ',
                'จังหวัด','อำเภอ','ตำบล','บ้านเลขที่','หมู่','ชื่อหมู่บ้าน',
                'รหัสไปรษณีย์','เบอร์โทร','ละติจูด','ลองจิจูด'
            ] as $head)
                <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">
                    {{ $head }}
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @forelse($rows as $index => $r)
            @php
                $bg = $index % 2 == 0 ? '#ffffff' : '#f8fffd';

                $welfareMap = [
    'a7_1' => 'เด็กแรกเกิด',
    'a7_2' => 'เบี้ยผู้สูงอายุ/คนชรา',
    'a7_3' => 'เบี้ยคนพิการ',
    'a7_4' => 'ประกันสังคม (ม.33)',
    'a7_5' => 'ประกันตนเอง (ม.40)',
    'a7_6' => 'บัตรสวัสดิการแห่งรัฐ',
];

$selectedTypes = $welfare_type ?? [];

$showCols = !empty($selectedTypes)
    ? array_intersect(array_keys($welfareMap), $selectedTypes)
    : array_keys($welfareMap);

$types = [];

foreach ($showCols as $col) {
    if (!empty($r->$col) && $r->$col != '0') {
        $types[] = $welfareMap[$col];
    }
}

                $sexLabel = match((string)($r->a4 ?? '')) {
                    '1' => 'ชาย',
                    '2' => 'หญิง',
                    default => '-',
                };
            @endphp

            <tr>
                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">{{ $index + 1 }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">{{ $r->survey_year ?? '-' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">{{ '="' . ($r->HC ?? '') . '"' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">{{ $r->a1 ?? '-' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }}; font-weight:bold;">{{ $r->a2_2 ?? '-' }} {{ $r->a2_3 ?? '' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">{{ '="' . ($r->popid ?? '') . '"' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">{{ $r->a3_1 ?? '-' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">{{ $sexLabel }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">{{ count($types) ? 'ได้รับ' : 'ไม่ได้รับ' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">{{ count($types) ? implode(', ', $types) : '-' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">{{ $r->province_name_thai ?? '-' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">{{ $r->district_name_thai ?? '-' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">{{ $r->tambon_name_thai ?? '-' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">{{ $r->house_number ?? '-' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">{{ $r->village_no ?? '-' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">{{ $r->village_name ?? '-' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">{{ $r->postcode ?? '-' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">{{ '="' . ($r->TEL ?? '') . '"' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">{{ $r->latx ?? '-' }}</td>
                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">{{ $r->lngy ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="20" style="padding:14px; text-align:center; color:#64748b; background:#f8fafc; border:1px solid #dbe7f3;">
                    ไม่พบข้อมูล
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>