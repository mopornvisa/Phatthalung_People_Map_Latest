<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family:'TH Sarabun New','Sarabun',sans-serif; font-size:14px; color:#0f172a;">

    <!-- TITLE -->
    <div style="text-align:center; font-size:24px; font-weight:bold; margin-bottom:4px;">
        รายงานอัตราป่วยรายใหม่โรคความดันโลหิตสูง
    </div>

    <div style="text-align:center; font-size:15px; margin-bottom:14px; color:#475569;">
        แสดงข้อมูลสรุปรายอำเภอ
    </div>

    <!-- META -->
    <table style="width:100%; margin-bottom:14px;">
        <tr>
            <td style="padding:8px; background:#f8fbff; border:1px solid #dbe7f3;">
                <strong>ปีงบประมาณ:</strong> {{ $year ?: 'ทั้งหมด' }}
                &nbsp;&nbsp;&nbsp;
                <strong>อำเภอ:</strong> {{ $district ?: 'ทุกอำเภอ' }}
            </td>
        </tr>
    </table>

    <!-- TABLE -->
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th rowspan="2" style="border:1px solid #bfcddd; padding:8px; background:#cfe0f2;">อำเภอ</th>
                <th colspan="3" style="border:1px solid #bfcddd; padding:8px; background:#cfe0f2;">ข้อมูลสรุป</th>
                <th colspan="12" style="border:1px solid #bfcddd; padding:8px; background:#cfe0f2;">จำนวนผู้ป่วยรายเดือน</th>
            </tr>
            <tr>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9;">B ประชากร</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9;">A ผู้ป่วย</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9;">อัตราต่อแสน</th>

                @foreach(['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'] as $m)
                    <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9;">{{ $m }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @forelse($rows as $index => $r)
                <tr>
                    <td style="border:1px solid #d5dfeb; padding:6px; font-weight:bold;">
                        {{ $r->district_name_thai }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:#edf4fb;">
                        {{ number_format($r->population_civil_registry ?? 0) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:#edf4fb;">
                        {{ number_format($r->patient_ht_total ?? 0) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:#edf4fb;">
                        {{ number_format($r->rate_per_100k ?? 0, 2) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right;">{{ number_format($r->month1 ?? 0) }}</td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right;">{{ number_format($r->month2 ?? 0) }}</td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right;">{{ number_format($r->month3 ?? 0) }}</td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right;">{{ number_format($r->month4 ?? 0) }}</td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right;">{{ number_format($r->month5 ?? 0) }}</td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right;">{{ number_format($r->month6 ?? 0) }}</td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right;">{{ number_format($r->month7 ?? 0) }}</td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right;">{{ number_format($r->month8 ?? 0) }}</td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right;">{{ number_format($r->month9 ?? 0) }}</td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right;">{{ number_format($r->month10 ?? 0) }}</td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right;">{{ number_format($r->month11 ?? 0) }}</td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right;">{{ number_format($r->month12 ?? 0) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="16" style="text-align:center;">ไม่พบข้อมูล</td>
                </tr>
            @endforelse

            <!-- SUMMARY -->
            <tr style="background:#eaf2fb; font-weight:bold;">
                <td>รวม</td>
                <td align="right">{{ number_format($summary['pop'] ?? 0) }}</td>
                <td align="right">{{ number_format($summary['case'] ?? 0) }}</td>
                <td align="right">{{ number_format($summary['rate'] ?? 0, 2) }}</td>

                <td>{{ number_format($summary['month1'] ?? 0) }}</td>
                <td>{{ number_format($summary['month2'] ?? 0) }}</td>
                <td>{{ number_format($summary['month3'] ?? 0) }}</td>
                <td>{{ number_format($summary['month4'] ?? 0) }}</td>
                <td>{{ number_format($summary['month5'] ?? 0) }}</td>
                <td>{{ number_format($summary['month6'] ?? 0) }}</td>
                <td>{{ number_format($summary['month7'] ?? 0) }}</td>
                <td>{{ number_format($summary['month8'] ?? 0) }}</td>
                <td>{{ number_format($summary['month9'] ?? 0) }}</td>
                <td>{{ number_format($summary['month10'] ?? 0) }}</td>
                <td>{{ number_format($summary['month11'] ?? 0) }}</td>
                <td>{{ number_format($summary['month12'] ?? 0) }}</td>
            </tr>
        </tbody>
    </table>
  <!-- NOTE -->
    <table style="width:100%; border-collapse:separate; border-spacing:0; margin-top:14px;">
        <tr>
            <td style="padding:8px 10px; background:#f8fbfd; border:1px solid #dcecf2; font-size:13px; color:#334155;">
                <strong>A</strong> หมายถึง จำนวนผู้ป่วยโรคความดันโลหิตสูง รายใหม่ในปีงบประมาณ
            </td>
        </tr>
        <tr>
            <td style="padding:8px 10px; background:#f8fbfd; border:1px solid #dcecf2; font-size:13px; color:#334155;">
                <strong>B</strong> หมายถึง จำนวนประชากรทะเบียนราษฎร์ทั้งหมดทุกกล่มอายุ
            </td>
        </tr>
    </table>
</body>
</html>