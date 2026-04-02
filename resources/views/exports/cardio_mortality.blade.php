<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
</head>

<body style="font-family:'TH Sarabun New','Sarabun',sans-serif; font-size:14px; color:#0f172a;">

    <div style="text-align:center; font-size:24px; font-weight:bold; margin-bottom:4px;">
        รายงานอัตราการเสียชีวิตโรคหัวใจและหลอดเลือด
    </div>

    <div style="text-align:center; font-size:15px; margin-bottom:14px; color:#475569;">
        แสดงข้อมูลสรุปภาพรวมรายอำเภอ พร้อมข้อมูลรายกลุ่มอายุ
    </div>

    <table style="width:100%; margin-bottom:14px; border-collapse:collapse;">
        <tr>
            <td style="padding:8px; background:#f8fbff; border:1px solid #dbe7f3;">
                <strong>ปี:</strong> {{ $year ?: 'ทั้งหมด' }}
                &nbsp;&nbsp;&nbsp;
                <strong>อำเภอ:</strong> {{ $district ?: 'ทุกอำเภอ' }}
            </td>
        </tr>
    </table>

    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th rowspan="2" style="border:1px solid #bfcddd; background:#cfe0f2; padding:6px;">อำเภอ</th>

                <th colspan="3" style="border:1px solid #bfcddd; background:#cfe0f2; padding:6px;">ข้อมูลสรุป</th>
                <th colspan="3" style="border:1px solid #bfcddd; background:#cfe0f2; padding:6px;">ต่ำกว่า 15 ปี</th>
                <th colspan="3" style="border:1px solid #bfcddd; background:#cfe0f2; padding:6px;">15-39 ปี</th>
                <th colspan="3" style="border:1px solid #bfcddd; background:#cfe0f2; padding:6px;">40-49 ปี</th>
                <th colspan="3" style="border:1px solid #bfcddd; background:#cfe0f2; padding:6px;">50-59 ปี</th>
                <th colspan="3" style="border:1px solid #bfcddd; background:#cfe0f2; padding:6px;">60 ปีขึ้นไป</th>
            </tr>

            <tr>
                @for($i = 0; $i < 6; $i++)
                    <th style="border:1px solid #bfcddd; background:#e5eff9; padding:6px;">B</th>
                    <th style="border:1px solid #bfcddd; background:#e5eff9; padding:6px;">A</th>
                    <th style="border:1px solid #bfcddd; background:#e5eff9; padding:6px;">ร้อยละ</th>
                @endfor
            </tr>
        </thead>

        <tbody>
            @forelse($rows as $index => $r)
                <tr>
                    <td style="border:1px solid #d5dfeb; padding:6px; font-weight:bold; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ $r->district_name_thai }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#edf4fb' : '#e8f1fb' }};">
                        {{ number_format($r->population_total ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#edf4fb' : '#e8f1fb' }};">
                        {{ number_format($r->patient_cardio_total ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#edf4fb' : '#e8f1fb' }};">
                        {{ number_format((float) ($r->percentage_total ?? 0), 2) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($r->population_total1 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($r->patient_cardio_total1 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format((float) ($r->percentage_total1 ?? 0), 2) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($r->population_total2 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($r->patient_cardio_total2 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format((float) ($r->percentage_total2 ?? 0), 2) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($r->population_total3 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($r->patient_cardio_total3 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format((float) ($r->percentage_total3 ?? 0), 2) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($r->population_total4 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($r->patient_cardio_total4 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format((float) ($r->percentage_total4 ?? 0), 2) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($r->population_total5 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($r->patient_cardio_total5 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format((float) ($r->percentage_total5 ?? 0), 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="19" style="border:1px solid #d5dfeb; padding:12px; text-align:center; color:#64748b;">
                        ไม่พบข้อมูล
                    </td>
                </tr>
            @endforelse

            <tr>
                <td style="border:1px solid #c5d3e2; padding:7px; font-weight:bold; background:#eaf2fb;">
                    รวม
                </td>

                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($summary->population_total_sum ?? 0) }}
                </td>
                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($summary->patient_cardio_total_sum ?? 0) }}
                </td>
                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($overallRate ?? 0, 2) }}
                </td>

                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumPopulation1 ?? 0) }}
                </td>
                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumPatient1 ?? 0) }}
                </td>
                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumRate1 ?? 0, 2) }}
                </td>

                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumPopulation2 ?? 0) }}
                </td>
                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumPatient2 ?? 0) }}
                </td>
                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumRate2 ?? 0, 2) }}
                </td>

                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumPopulation3 ?? 0) }}
                </td>
                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumPatient3 ?? 0) }}
                </td>
                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumRate3 ?? 0, 2) }}
                </td>

                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumPopulation4 ?? 0) }}
                </td>
                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumPatient4 ?? 0) }}
                </td>
                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumRate4 ?? 0, 2) }}
                </td>

                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumPopulation5 ?? 0) }}
                </td>
                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumPatient5 ?? 0) }}
                </td>
                <td style="border:1px solid #c5d3e2; padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">
                    {{ number_format($sumRate5 ?? 0, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width:100%; margin-top:14px; border-collapse:collapse;">
        <tr>
            <td style="padding:8px; border:1px solid #dcecf2;">
                <strong>A</strong> หมายถึง จำนวนผู้ป่วยด้วยโรคหัวใจและหลอดเลือด (Coronary heart disease) เสียชีวิต
            </td>
        </tr>
        <tr>
            <td style="padding:8px; border:1px solid #dcecf2;">
                <strong>B</strong> หมายถึง จำนวนผู้ป่วยด้วยโรคหัวใจและหลอดเลือด (Coronary heart disease)
            </td>
        </tr>
    </table>

</body>
</html>