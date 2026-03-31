<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    
</head>
<body style="font-family:'TH Sarabun New','Sarabun',sans-serif; font-size:14px; color:#111827;">

    <!-- TITLE -->
    <div style="text-align:center; font-size:22px; font-weight:bold; margin-bottom:4px;">
        รายงานอัตราป่วยรายใหม่โรคหัวใจและหลอดเลือด
    </div>

    <div style="text-align:center; font-size:15px; margin-bottom:12px; color:#374151;">
        แสดงข้อมูลสรุปรายอำเภอ
    </div>

    <!-- META -->
    <div style="margin-bottom:12px; font-size:13px; color:#4b5563;">
        <div>ปีงบประมาณ: {{ $year ?: 'ทั้งหมด' }}</div>
        <div>อำเภอ: {{ $district ?: 'ทุกอำเภอ' }}</div>
    </div>

    <!-- TABLE -->
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th rowspan="2" style="border:1px solid #94a3b8; padding:6px; background:#dbeafe;">อำเภอ</th>
                <th colspan="3" style="border:1px solid #94a3b8; padding:6px; background:#dbeafe;">ข้อมูลสรุป</th>
                <th colspan="12" style="border:1px solid #94a3b8; padding:6px; background:#dbeafe;">จำนวนผู้ป่วยรายใหม่รายเดือน</th>
            </tr>
            <tr>
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">B ประชากร</th>
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">A ผู้ป่วย</th>
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">อัตราต่อแสน</th>
                
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">ม.ค.</th>
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">ก.พ.</th>
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">มี.ค.</th>
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">เม.ย.</th>
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">พ.ค.</th>
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">มิ.ย.</th>
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">ก.ค.</th>
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">ส.ค.</th>
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">ก.ย.</th>
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">ต.ค.</th>
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">พ.ย.</th>
                <th style="border:1px solid #94a3b8; padding:6px; background:#eff6ff;">ธ.ค.</th>
            </tr>
        </thead>

        <tbody>
            @forelse($rows as $r)
                <tr>
                    <td style="border:1px solid #94a3b8; padding:6px;">
                        {{ $r->district_name_thai }}
                    </td>

                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">
                        {{ number_format($r->population_civil_registry ?? 0) }}
                    </td>

                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">
                        {{ number_format($r->patient_total ?? 0) }}
                    </td>

                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">
                        {{ number_format($r->rate_per_100k ?? 0, 2) }}
                    </td>

                    
                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ $r->month1 ?? 0 }}</td>
                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ $r->month2 ?? 0 }}</td>
                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ $r->month3 ?? 0 }}</td>
                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ $r->month4 ?? 0 }}</td>
                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ $r->month5 ?? 0 }}</td>
                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ $r->month6 ?? 0 }}</td>
                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ $r->month7 ?? 0 }}</td>
                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ $r->month8 ?? 0 }}</td>
                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ $r->month9 ?? 0 }}</td>
                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ $r->month10 ?? 0 }}</td>
                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ $r->month11 ?? 0 }}</td>
                    <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ $r->month12 ?? 0 }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="16" style="border:1px solid #94a3b8; padding:10px; text-align:center;">
                        ไม่พบข้อมูล
                    </td>
                </tr>
            @endforelse

            <!-- TOTAL -->
            <tr style="background:#dcfce7; font-weight:bold;">
                <td style="border:1px solid #94a3b8; padding:6px;">รวม</td>
                <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ number_format($summary['pop'] ?? 0) }}</td>
                <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ number_format($summary['case'] ?? 0) }}</td>
                <td style="border:1px solid #94a3b8; padding:6px; text-align:right;">{{ number_format($summary['rate'] ?? 0, 2) }}</td>

                
                <td style="border:1px solid #94a3b8; padding:6px;">{{ $summary['month1'] ?? 0 }}</td>
                <td style="border:1px solid #94a3b8; padding:6px;">{{ $summary['month2'] ?? 0 }}</td>
                <td style="border:1px solid #94a3b8; padding:6px;">{{ $summary['month3'] ?? 0 }}</td>
                <td style="border:1px solid #94a3b8; padding:6px;">{{ $summary['month4'] ?? 0 }}</td>
                <td style="border:1px solid #94a3b8; padding:6px;">{{ $summary['month5'] ?? 0 }}</td>
                <td style="border:1px solid #94a3b8; padding:6px;">{{ $summary['month6'] ?? 0 }}</td>
                <td style="border:1px solid #94a3b8; padding:6px;">{{ $summary['month7'] ?? 0 }}</td>
                <td style="border:1px solid #94a3b8; padding:6px;">{{ $summary['month8'] ?? 0 }}</td>
                <td style="border:1px solid #94a3b8; padding:6px;">{{ $summary['month9'] ?? 0 }}</td>
                <td style="border:1px solid #94a3b8; padding:6px;">{{ $summary['month10'] ?? 0 }}</td>
                <td style="border:1px solid #94a3b8; padding:6px;">{{ $summary['month11'] ?? 0 }}</td>
                <td style="border:1px solid #94a3b8; padding:6px;">{{ $summary['month12'] ?? 0 }}</td>
            </tr>
        </tbody>
    </table>

    <!-- NOTE -->
    <div style="margin-top:12px; font-size:13px; color:#374151;">
        <div><strong>A</strong> = จำนวนผู้ป่วยรายใหม่</div>
        <div><strong>B</strong> = จำนวนประชากรทะเบียนราษฎร์</div>
    </div>

</body>
</html>