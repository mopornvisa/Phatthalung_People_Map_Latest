<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
</head>

<body style="font-family:'TH Sarabun New','Sarabun',sans-serif; font-size:14px; color:#0f172a; margin:0; padding:0;">

<table style="border-collapse:collapse; width:100%;">

    <thead>
        <tr>
            <th colspan="22"
                style="text-align:left;padding:10px 12px;background:#f0fdfa;border:1px solid #99f6e4;font-size:14px;color:#0f172a;">
                <strong>ปี:</strong> {{ request('survey_year') ?: 'ทั้งหมด' }}
                &nbsp;&nbsp;&nbsp;
                <strong>อำเภอ:</strong> {{ request('district_name_thai') ?: 'ทุกอำเภอ' }}
                &nbsp;&nbsp;&nbsp;
                <strong>ตำบล:</strong> {{ request('tambon_name_thai') ?: 'ทุกตำบล' }}
                &nbsp;&nbsp;&nbsp;
                <strong>จำนวนข้อมูล:</strong> {{ number_format(count($rows)) }} รายการ
            </th>
        </tr>

        <tr>
            <th colspan="22" style="height:8px;background:#ffffff;border:none;"></th>
        </tr>

        <tr>
            @foreach([
                'ลำดับ','ปี','เลขครัวเรือน','อำเภอ','ตำบล',
                'ทำนา','สวนผัก','ชนิดผัก','สวนผลไม้','ชนิดผลไม้','พืชไร่','พืชอุตสาหกรรม',
                'สัตว์ปีก','หมู/แพะ','วัว/ควาย','ปศุสัตว์อื่น ๆ','ระบุ',
                'ประมงน้ำเค็ม','ประมงน้ำจืด',
                'รายได้นอกภาคเกษตร','ต้นทุน','ลูกหลานส่งกลับ'
            ] as $head)
                <th style="background:#dff7ef;border:1px solid #8dd8c7;padding:8px;text-align:center;font-weight:bold;">
                    {{ $head }}
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @forelse($rows as $index => $row)
            @php
                $bg = $index % 2 == 0 ? '#ffffff' : '#f8fffd';
                $yes = '✓';
                $no = '—';
            @endphp

            <tr>
                <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">{{ $index + 1 }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">{{ $row->survey_year ?? '-' }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;background:{{ $bg }};font-weight:bold;">{{ $row->HC ?? '-' }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;background:{{ $bg }};">{{ $row->district_name_thai ?? '-' }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;background:{{ $bg }};">{{ $row->tambon_name_thai ?? '-' }}</td>

                <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">{{ !empty($row->c1_1_1) ? $yes : $no }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">{{ !empty($row->c1_1_2) ? $yes : $no }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;background:{{ $bg }};">{{ $row->c1_1_2_0 ?? '-' }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">{{ !empty($row->c1_1_3) ? $yes : $no }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;background:{{ $bg }};">{{ $row->c1_1_3_0 ?? '-' }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">{{ !empty($row->c1_1_4) ? $yes : $no }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">{{ !empty($row->c1_1_5) ? $yes : $no }}</td>

                <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">{{ !empty($row->c1_2_1) ? $yes : $no }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">{{ !empty($row->c1_2_2) ? $yes : $no }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">{{ !empty($row->c1_2_3) ? $yes : $no }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">{{ !empty($row->c1_2_4) ? $yes : $no }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;background:{{ $bg }};">{{ $row->c1_2_4_0 ?? '-' }}</td>

                <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">{{ !empty($row->c1_3_1) ? $yes : $no }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;text-align:center;background:{{ $bg }};">{{ !empty($row->c1_3_2) ? $yes : $no }}</td>

                <td style="border:1px solid #d6eee8;padding:6px;text-align:right;background:{{ $bg }};">{{ number_format((float)($row->c2_1 ?? 0),2) }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;text-align:right;background:{{ $bg }};">{{ number_format((float)($row->c2_2 ?? 0),2) }}</td>
                <td style="border:1px solid #d6eee8;padding:6px;text-align:right;background:{{ $bg }};">{{ number_format((float)($row->c2_3 ?? 0),2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="22" style="padding:14px;text-align:center;color:#64748b;background:#f8fafc;border:1px solid #dbe7f3;">
                    ไม่พบข้อมูล
                </td>
            </tr>
        @endforelse
    </tbody>

</table>

</body>
</html>