<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family:'TH Sarabun New','Sarabun',sans-serif; font-size:14px; color:#0f172a; margin:0; padding:0;">

<table border="1" style="border-collapse:collapse; width:100%;">
    <thead>
        <tr>
            <th colspan="19" style="text-align:left; padding:8px 10px; background:#f8fbff; border:1px solid #dbe7f3; font-size:13px; color:#334155;">
                <strong>ปี:</strong> {{ $year !== '' ? $year : 'ทั้งหมด' }}
                &nbsp;&nbsp;&nbsp;
                <strong>อำเภอ:</strong> {{ $district !== '' ? $district : 'ทุกอำเภอ' }}
            </th>
        </tr>
        <tr>
            <th rowspan="2" style="padding:8px 6px; background:#cfe0f2; text-align:center; font-weight:bold;">
                อำเภอ
            </th>
            <th colspan="3" style="padding:8px 6px; background:#cfe0f2; text-align:center; font-weight:bold;">
                ข้อมูลสรุป
            </th>
            <th colspan="3" style="padding:8px 6px; background:#cfe0f2; text-align:center; font-weight:bold;">
                ต่ำกว่า 15 ปี
            </th>
            <th colspan="3" style="padding:8px 6px; background:#cfe0f2; text-align:center; font-weight:bold;">
                15-39 ปี
            </th>
            <th colspan="3" style="padding:8px 6px; background:#cfe0f2; text-align:center; font-weight:bold;">
                40-49 ปี
            </th>
            <th colspan="3" style="padding:8px 6px; background:#cfe0f2; text-align:center; font-weight:bold;">
                50-59 ปี
            </th>
            <th colspan="3" style="padding:8px 6px; background:#cfe0f2; text-align:center; font-weight:bold;">
                60 ปีขึ้นไป
            </th>
        </tr>
        <tr>
            <th style="padding:6px; background:#e5eff9; text-align:center;">B</th>
            <th style="padding:6px; background:#e5eff9; text-align:center;">A</th>
            <th style="padding:6px; background:#e5eff9; text-align:center;">ร้อยละ</th>

            <th style="padding:6px; background:#e5eff9; text-align:center;">B</th>
            <th style="padding:6px; background:#e5eff9; text-align:center;">A</th>
            <th style="padding:6px; background:#e5eff9; text-align:center;">ร้อยละ</th>

            <th style="padding:6px; background:#e5eff9; text-align:center;">B</th>
            <th style="padding:6px; background:#e5eff9; text-align:center;">A</th>
            <th style="padding:6px; background:#e5eff9; text-align:center;">ร้อยละ</th>

            <th style="padding:6px; background:#e5eff9; text-align:center;">B</th>
            <th style="padding:6px; background:#e5eff9; text-align:center;">A</th>
            <th style="padding:6px; background:#e5eff9; text-align:center;">ร้อยละ</th>

            <th style="padding:6px; background:#e5eff9; text-align:center;">B</th>
            <th style="padding:6px; background:#e5eff9; text-align:center;">A</th>
            <th style="padding:6px; background:#e5eff9; text-align:center;">ร้อยละ</th>

            <th style="padding:6px; background:#e5eff9; text-align:center;">B</th>
            <th style="padding:6px; background:#e5eff9; text-align:center;">A</th>
            <th style="padding:6px; background:#e5eff9; text-align:center;">ร้อยละ</th>
        </tr>
    </thead>

    <tbody>
        @forelse($rows as $index => $row)
            <tr>
                <td style="padding:6px; font-weight:bold; background:{{ $index % 2 == 0 ? '#ffffff' : '#f8fbff' }};">
                    {{ $row->district_name_thai }}
                </td>

                <td style="padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#edf4fb' : '#e8f1fb' }};">
                    {{ number_format($row->population_total ?? 0) }}
                </td>
                <td style="padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#edf4fb' : '#e8f1fb' }};">
                    {{ number_format($row->patient_emph_total ?? 0) }}
                </td>
                <td style="padding:6px; text-align:right; background:{{ $index % 2 == 0 ? '#edf4fb' : '#e8f1fb' }};">
                    {{ number_format((float) ($row->percentage_total ?? 0), 2) }}
                </td>

                <td style="padding:6px; text-align:right;">{{ number_format($row->population_total1 ?? 0) }}</td>
                <td style="padding:6px; text-align:right;">{{ number_format($row->patient_emph_total1 ?? 0) }}</td>
                <td style="padding:6px; text-align:right;">{{ number_format((float) ($row->percentage_total1 ?? 0), 2) }}</td>

                <td style="padding:6px; text-align:right;">{{ number_format($row->population_total2 ?? 0) }}</td>
                <td style="padding:6px; text-align:right;">{{ number_format($row->patient_emph_total2 ?? 0) }}</td>
                <td style="padding:6px; text-align:right;">{{ number_format((float) ($row->percentage_total2 ?? 0), 2) }}</td>

                <td style="padding:6px; text-align:right;">{{ number_format($row->population_total3 ?? 0) }}</td>
                <td style="padding:6px; text-align:right;">{{ number_format($row->patient_emph_total3 ?? 0) }}</td>
                <td style="padding:6px; text-align:right;">{{ number_format((float) ($row->percentage_total3 ?? 0), 2) }}</td>

                <td style="padding:6px; text-align:right;">{{ number_format($row->population_total4 ?? 0) }}</td>
                <td style="padding:6px; text-align:right;">{{ number_format($row->patient_emph_total4 ?? 0) }}</td>
                <td style="padding:6px; text-align:right;">{{ number_format((float) ($row->percentage_total4 ?? 0), 2) }}</td>

                <td style="padding:6px; text-align:right;">{{ number_format($row->population_total5 ?? 0) }}</td>
                <td style="padding:6px; text-align:right;">{{ number_format($row->patient_emph_total5 ?? 0) }}</td>
                <td style="padding:6px; text-align:right;">{{ number_format((float) ($row->percentage_total5 ?? 0), 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="19" style="padding:12px; text-align:center; color:#64748b;">
                    ไม่พบข้อมูล
                </td>
            </tr>
        @endforelse

        <tr>
            <td style="padding:7px; font-weight:bold; background:#eaf2fb;">รวม</td>

            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($summary->population_total_sum ?? 0) }}</td>
            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($summary->patient_emph_total_sum ?? 0) }}</td>
            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($overallRate ?? 0, 2) }}</td>

            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumPopulation1 ?? 0) }}</td>
            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumPatient1 ?? 0) }}</td>
            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumRate1 ?? 0, 2) }}</td>

            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumPopulation2 ?? 0) }}</td>
            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumPatient2 ?? 0) }}</td>
            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumRate2 ?? 0, 2) }}</td>

            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumPopulation3 ?? 0) }}</td>
            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumPatient3 ?? 0) }}</td>
            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumRate3 ?? 0, 2) }}</td>

            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumPopulation4 ?? 0) }}</td>
            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumPatient4 ?? 0) }}</td>
            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumRate4 ?? 0, 2) }}</td>

            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumPopulation5 ?? 0) }}</td>
            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumPatient5 ?? 0) }}</td>
            <td style="padding:7px; text-align:right; font-weight:bold; background:#eaf2fb;">{{ number_format($sumRate5 ?? 0, 2) }}</td>
        </tr>

        <tr>
            <td colspan="19" style="padding:8px 10px; background:#f8fbfd; font-size:13px; color:#334155;">
                <strong>A</strong> หมายถึง จำนวนผู้ป่วยโรคถุงลมโป่งพองทั้งหมด
            </td>
        </tr>
        <tr>
            <td colspan="19" style="padding:8px 10px; background:#f8fbfd; font-size:13px; color:#334155;">
                <strong>B</strong> หมายถึง จำนวนประชากร ตามกลุ่มอายุ
            </td>
        </tr>
    </tbody>
</table>

</body>
</html>