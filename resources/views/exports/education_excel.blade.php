<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
</head>

<body style="font-family:'TH Sarabun New','Sarabun',sans-serif; font-size:14px; color:#0f172a; margin:0; padding:0;">

<table style="border-collapse:collapse; width:100%;">

    {{-- TITLE --}}
    <thead>
       

        {{-- META --}}
        <tr>
            <th colspan="14"
                style="
                    text-align:left;
                    padding:10px 12px;
                    background:#f0fdfa;
                    border:1px solid #99f6e4;
                    font-size:14px;
                    color:#0f172a;
                ">
                <strong>ปี:</strong> {{ $survey_year !== '' ? $survey_year : 'ทั้งหมด' }}
                &nbsp;&nbsp;&nbsp;
                <strong>อำเภอ:</strong> {{ $district !== '' ? $district : 'ทุกอำเภอ' }}
                &nbsp;&nbsp;&nbsp;
                <strong>ตำบล:</strong> {{ $subdistrict !== '' ? $subdistrict : 'ทุกตำบล' }}
            </th>
        </tr>

        <tr>
            <th colspan="14"
                style="
                    height:8px;
                    background:#ffffff;
                    border:none;
                ">
            </th>
        </tr>

        {{-- HEADER TABLE --}}
        <tr>
            <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">ลำดับ</th>
            <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">ปี</th>
            <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">เลขครัวเรือน</th>
            <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">ลำดับในครัวเรือน</th>
            <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">ชื่อ - นามสกุล</th>
            <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">เลขบัตรประชาชน</th>
            <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">อายุ</th>
            <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">เพศ</th>
            <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">ที่อยู่</th>
            <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">พูดไทย</th>
            <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">อ่านไทย</th>
            <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">เขียนไทย</th>
            <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">การศึกษาสูงสุด</th>
            <th style="background:#dff7ef; border:1px solid #8dd8c7; padding:8px; text-align:center; font-weight:bold;">สถานภาพ</th>
        </tr>
    </thead>

    <tbody>
        @forelse($rows as $index => $r)
            @php
                $sexLabel = [1 => 'ชาย', 2 => 'หญิง'][(int)($r->a4 ?? 0)] ?? '-';
                $yesNo = [0 => 'ไม่ได้', 1 => 'ได้'];

                $educationLevels = [
                    0 => 'ไม่ได้เรียน',
                    1 => 'ต่ำกว่าประถม',
                    2 => 'ประถมศึกษา',
                    3 => 'ม.ต้น หรือเทียบเท่า',
                    4 => 'ม.ปลาย หรือเทียบเท่า',
                    5 => 'ปวช./ประกาศนียบัตร',
                    6 => 'ปวส./อนุปริญญา',
                    7 => 'ป.ตรี หรือเทียบเท่า',
                    8 => 'สูงกว่าปริญญาตรี',
                    9 => 'เรียนสายศาสนา',
                ];

                $educationStatuses = [
                    1 => 'ไปเรียนสม่ำเสมอ',
                    2 => 'หยุดเรียนเป็นระยะ ๆ',
                    3 => 'ออกกลางคัน (Dropout)',
                ];

                $address = 'บ้านเลขที่ '.($r->MBNO ?: '-')
                    .' หมู่ที่ '.($r->MB ?: '-')
                    .' '.($r->MM ?: '-')
                    .' ตำบล'.($r->tambon_name_thai ?: '-')
                    .' อำเภอ'.($r->district_name_thai ?: '-')
                    .' จังหวัดพัทลุง '.($r->POSTCODE ?: '-');

                $bg = $index % 2 == 0 ? '#ffffff' : '#f8fffd';
            @endphp

            <tr>
                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">
                    {{ $index + 1 }}
                </td>

                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">
                    {{ $r->survey_year ?? '-' }}
                </td>

                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">
                    {{ $r->HC ?? '-' }}
                </td>

                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">
                    {{ $r->a1 ?? '-' }}
                </td>

                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }}; font-weight:bold;">
                    {{ $r->a2_2 ?? '-' }} {{ $r->a2_3 ?? '' }}
                </td>

                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">
                    {{ $r->popid ?? '-' }}
                </td>

                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">
                    {{ $r->a3_1 ?? '-' }}
                </td>

                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">
                    {{ $sexLabel }}
                </td>

                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">
                    {{ $address }}
                </td>

                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">
                    {{ $yesNo[(int)($r->a9_1 ?? -1)] ?? '-' }}
                </td>

                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">
                    {{ $yesNo[(int)($r->a9_2 ?? -1)] ?? '-' }}
                </td>

                <td style="border:1px solid #d6eee8; padding:6px; text-align:center; background:{{ $bg }};">
                    {{ $yesNo[(int)($r->a10 ?? -1)] ?? '-' }}
                </td>

                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">
                    {{ $educationLevels[(int)($r->a11 ?? -1)] ?? '-' }}
                </td>

                <td style="border:1px solid #d6eee8; padding:6px; background:{{ $bg }};">
                    {{ $educationStatuses[(int)($r->a13 ?? -1)] ?? '-' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="14"
                    style="
                        padding:14px;
                        text-align:center;
                        color:#64748b;
                        background:#f8fafc;
                        border:1px solid #dbe7f3;
                    ">
                    ไม่พบข้อมูล
                </td>
            </tr>
        @endforelse

        
    </tbody>
</table>

</body>
</html>