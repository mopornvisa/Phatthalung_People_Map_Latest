<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
</head>

<body style="font-family:'TH Sarabun New','Sarabun',sans-serif; font-size:14px; color:#0f172a;">

    @php
        $firstRow = $rows->first();
        $yearOld = $firstRow->year_old ?? ($year ?: '');
        $yearNew = $firstRow->year_new ?? '';
    @endphp

    <div style="text-align:center; font-size:24px; font-weight:bold; margin-bottom:4px;">
        รายงานเปรียบเทียบอัตราผู้ป่วยรายใหม่จากโรคหลอดเลือดหัวใจลดลง
    </div>

    <div style="text-align:center; font-size:15px; margin-bottom:14px; color:#475569;">
        แสดงข้อมูลเปรียบเทียบรายอำเภอ
    </div>

    <table style="width:100%; margin-bottom:14px;">
        <tr>
            <td style="padding:8px; background:#f8fbff; border:1px solid #dbe7f3;">
                <strong>ปี:</strong> {{ $yearOld ?: 'ทั้งหมด' }}
                @if($yearNew)
                    &nbsp;&nbsp;&nbsp;
                    <strong>เทียบกับปี:</strong> {{ $yearNew }}
                @endif
                &nbsp;&nbsp;&nbsp;
                <strong>อำเภอ:</strong> {{ $district ?: 'ทุกอำเภอ' }}
            </td>
        </tr>
    </table>

    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th rowspan="2" style="border:1px solid #bfcddd; padding:8px; background:#cfe0f2;">อำเภอ</th>

                <th colspan="3" style="border:1px solid #bfcddd; padding:8px; background:#cfe0f2;">
                    ข้อมูลปี {{ $yearOld ?: '-' }}
                </th>

                <th colspan="3" style="border:1px solid #bfcddd; padding:8px; background:#cfe0f2;">
                    ข้อมูลปี {{ $yearNew ?: '-' }}
                </th>

                <th rowspan="2" style="border:1px solid #bfcddd; padding:8px; background:#cfe0f2;">
                    ร้อยละการลดลง
                </th>
            </tr>
            <tr>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9;">ประชากร</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9;">ผู้ป่วย</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9;">อัตรา (B)</th>

                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9;">ประชากร</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9;">ผู้ป่วย</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9;">อัตรา (A)</th>
            </tr>
        </thead>

        <tbody>
            @forelse($rows as $r)
                <tr>
                    <td style="border:1px solid #d5dfeb; padding:6px; font-weight:bold;">
                        {{ $r->district_name_thai }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:#edf4fb;">
                        {{ number_format($r->population_old ?? 0) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:#edf4fb;">
                        {{ number_format($r->patient_old ?? 0) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:#edf4fb;">
                        {{ number_format($r->rate_old ?? 0, 2) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:#edf4fb;">
                        {{ number_format($r->population_new ?? 0) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:#edf4fb;">
                        {{ number_format($r->patient_new ?? 0) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:#edf4fb;">
                        {{ number_format($r->rate_new ?? 0, 2) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; font-weight:bold; color:{{ ($r->cardio ?? 0) >= 0 ? '#16a34a' : '#dc2626' }};">
                        {{ number_format($r->cardio ?? 0, 2) }}%
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; border:1px solid #d5dfeb; padding:8px;">
                        ไม่พบข้อมูล
                    </td>
                </tr>
            @endforelse

            <tr style="background:#eaf2fb; font-weight:bold;">
                <td style="border:1px solid #d5dfeb; padding:6px;">รวม/เฉลี่ย</td>
                <td style="border:1px solid #d5dfeb; padding:6px;" align="right">{{ number_format($summary['population_old'] ?? 0) }}</td>
                <td style="border:1px solid #d5dfeb; padding:6px;" align="right">{{ number_format($summary['patient_old'] ?? 0) }}</td>
                <td style="border:1px solid #d5dfeb; padding:6px;" align="right">{{ number_format($summary['rate_old'] ?? 0, 2) }}</td>

                <td style="border:1px solid #d5dfeb; padding:6px;" align="right">{{ number_format($summary['population_new'] ?? 0) }}</td>
                <td style="border:1px solid #d5dfeb; padding:6px;" align="right">{{ number_format($summary['patient_new'] ?? 0) }}</td>
                <td style="border:1px solid #d5dfeb; padding:6px;" align="right">{{ number_format($summary['rate_new'] ?? 0, 2) }}</td>

                <td style="border:1px solid #d5dfeb; padding:6px;" align="right">
                    {{ number_format($summary['cardio_avg'] ?? 0, 2) }}%
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width:100%; margin-top:14px; border-collapse:collapse;">
        <tr>
            <td style="padding:8px; background:#f8fbfd; border:1px solid #dcecf2; font-size:13px;">
                <strong>A</strong> หมายถึง อัตราผู้ป่วยรายใหม่จากโรคหลอดเลือดหัวใจในปีงบประมาณถัดไป
            </td>
        </tr>
        <tr>
            <td style="padding:8px; background:#f8fbfd; border:1px solid #dcecf2; font-size:13px;">
                <strong>B</strong> หมายถึง อัตราผู้ป่วยรายใหม่จากโรคหลอดเลือดหัวใจในปีงบประมาณปัจจุบัน
            </td>
        </tr>
        <tr>
            <td style="padding:8px; background:#f8fbfd; border:1px solid #dcecf2; font-size:13px;">
                <strong>ร้อยละการลดลง</strong> คำนวณจากสูตร (B - A) / B × 100
            </td>
        </tr>
    </table>

</body>
</html>