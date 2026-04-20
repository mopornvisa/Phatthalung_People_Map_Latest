<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family:'TH Sarabun New','Sarabun',sans-serif; font-size:14px; color:#0f172a;">

    <!-- TITLE -->
    <div style="text-align:center; font-size:24px; font-weight:bold; margin-bottom:4px; color:#0f172a;">
        รายงานอัตราป่วยด้วยโรคหัวใจและหลอดเลือด
    </div>

    <div style="text-align:center; font-size:15px; margin-bottom:14px; color:#475569;">
        แสดงข้อมูลสรุปภาพรวมรายอำเภอ พร้อมข้อมูลรายกลุ่มอายุ
    </div>

    <!-- META -->
    <table style="width:100%; border-collapse:separate; border-spacing:0; margin-bottom:14px;">
        <tr>
            <td style="padding:8px 10px; background:#f8fbff; border:1px solid #dbe7f3; font-size:13px; color:#334155;">
                <strong>ปี:</strong> {{ $year !== '' ? $year : 'ทั้งหมด' }}
                &nbsp;&nbsp;&nbsp;
                <strong>อำเภอ:</strong> {{ $district !== '' ? $district : 'ทุกอำเภอ' }}
            </td>
        </tr>
    </table>

    <!-- TABLE -->
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th rowspan="2" style="border:1px solid #bfcddd; padding:8px 6px; background:#cfe0f2; text-align:center; font-weight:bold;">
                    อำเภอ
                </th>

                <th colspan="3" style="border:1px solid #bfcddd; padding:8px 6px; background:#cfe0f2; text-align:center; font-weight:bold;">
                    ข้อมูลสรุป
                </th>

                <th colspan="3" style="border:1px solid #bfcddd; padding:8px 6px; background:#cfe0f2; text-align:center; font-weight:bold;">
                    ต่ำกว่า 15 ปี
                </th>

                <th colspan="3" style="border:1px solid #bfcddd; padding:8px 6px; background:#cfe0f2; text-align:center; font-weight:bold;">
                    15-39 ปี
                </th>

                <th colspan="3" style="border:1px solid #bfcddd; padding:8px 6px; background:#cfe0f2; text-align:center; font-weight:bold;">
                    40-49 ปี
                </th>

                <th colspan="3" style="border:1px solid #bfcddd; padding:8px 6px; background:#cfe0f2; text-align:center; font-weight:bold;">
                    50-59 ปี
                </th>

                <th colspan="3" style="border:1px solid #bfcddd; padding:8px 6px; background:#cfe0f2; text-align:center; font-weight:bold;">
                    60 ปีขึ้นไป
                </th>
            </tr>
            <tr>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">B</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">A</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">ร้อยละ</th>

                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">B</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">A</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">ร้อยละ</th>

                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">B</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">A</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">ร้อยละ</th>

                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">B</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">A</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">ร้อยละ</th>

                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">B</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">A</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">ร้อยละ</th>

                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">B</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">A</th>
                <th style="border:1px solid #bfcddd; padding:6px; background:#e5eff9; text-align:center;">ร้อยละ</th>
            </tr>
        </thead>

        <tbody>
            @forelse($rows as $index => $row)
                <tr>
                    <td style="
                        border:1px solid #d5dfeb;
                        padding:6px;
                        font-weight:bold;
                        background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};
                    ">
                        {{ $row->district_name_thai }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#edf4fb' : '#e8f1fb' }};">
                        {{ number_format($row->population_total ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#edf4fb' : '#e8f1fb' }};">
                        {{ number_format($row->patient_cardio_total ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#edf4fb' : '#e8f1fb' }};">
                        {{ number_format((float) ($row->percentage_total ?? 0), 2) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($row->population_total1 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($row->patient_cardio_total1 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format((float) ($row->percentage_total1 ?? 0), 2) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($row->population_total2 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($row->patient_cardio_total2 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format((float) ($row->percentage_total2 ?? 0), 2) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($row->population_total3 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($row->patient_cardio_total3 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format((float) ($row->percentage_total3 ?? 0), 2) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($row->population_total4 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($row->patient_cardio_total4 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format((float) ($row->percentage_total4 ?? 0), 2) }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($row->population_total5 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format($row->patient_cardio_total5 ?? 0) }}
                    </td>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                        {{ number_format((float) ($row->percentage_total5 ?? 0), 2) }}
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

    <!-- LEGEND -->
    <table style="width:100%; border-collapse:separate; border-spacing:0; margin-top:14px;">
        <tr>
            <td style="padding:8px 10px; background:#f8fbfd; border:1px solid #dcecf2; font-size:13px; color:#334155;">
                <strong>A</strong> หมายถึง จำนวนผู้ป่วยด้วยโรคหัวใจและหลอดเลือด (Coronary heart disease) ทั้งหมดตามกลุ่มอายุ
            </td>
        </tr>
        <tr>
            <td style="padding:8px 10px; background:#f8fbfd; border:1px solid #dcecf2; font-size:13px; color:#334155;">
                <strong>B</strong> หมายถึง จำนวนประชากร ตามกลุ่มอายุ
            </td>
        </tr>
    </table>

</body>
</html>