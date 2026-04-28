<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
</head>

<body style="font-family:'TH Sarabun New','Sarabun',sans-serif; font-size:14px; color:#0f172a;">

    <!-- TITLE -->
    <div style="text-align:center; font-size:24px; font-weight:bold; margin-bottom:4px;">
        รายงานข้อมูลการตายจังหวัดพัทลุง
    </div>

    <div style="text-align:center; font-size:15px; margin-bottom:14px; color:#475569;">
        แสดงข้อมูลการตายตามเงื่อนไขที่เลือก
    </div>

    <!-- META -->
    <table style="width:100%; margin-bottom:14px; border-collapse:collapse;">
        <tr>
            <td style="padding:8px; background:#f8fbff; border:1px solid #dbe7f3;">
                <strong>ปี:</strong> {{ $year !== '' ? $year : 'ทั้งหมด' }}
                &nbsp;&nbsp;&nbsp;
                <strong>อำเภอ:</strong> {{ $district !== '' ? $district : 'ทั้งหมด' }}
                &nbsp;&nbsp;&nbsp;
                <strong>เพศ:</strong> {{ $gender !== '' ? $gender : 'ทั้งหมด' }}
                &nbsp;&nbsp;&nbsp;
                <strong>กลุ่มอายุ:</strong> {{ $ageGroup !== '' ? $ageGroup : 'ทั้งหมด' }}
            </td>
        </tr>
        <tr>
            <td style="padding:8px; background:#f8fbff; border:1px solid #dbe7f3;">
                <strong>สาเหตุการเสียชีวิต:</strong> {{ $cause !== '' ? $cause : 'ทั้งหมด' }}
            </td>
        </tr>
    </table>

    <!-- TABLE -->
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th style="border:1px solid #bfcddd; padding:8px; background:#cfe0f2;">ปี</th>
                <th style="border:1px solid #bfcddd; padding:8px; background:#cfe0f2;">เดือน</th>
                <th style="border:1px solid #bfcddd; padding:8px; background:#cfe0f2;">อำเภอ</th>
                <th style="border:1px solid #bfcddd; padding:8px; background:#cfe0f2;">เพศ</th>
                <th style="border:1px solid #bfcddd; padding:8px; background:#cfe0f2;">กลุ่มอายุ</th>
                <th style="border:1px solid #bfcddd; padding:8px; background:#cfe0f2;">สาเหตุการเสียชีวิต</th>
                <th style="border:1px solid #bfcddd; padding:8px; background:#cfe0f2;">จำนวนผู้เสียชีวิต</th>
            </tr>
        </thead>

        <tbody>
            @php
                $sumDeath = 0;
            @endphp

            @forelse($rows as $r)
                @php
                    $sumDeath += $r->death_total ?? 0;
                @endphp
                <tr>
                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:center;">
                        {{ $r->year_th }}
                    </td>

                   <td style="border:1px solid #d5dfeb; padding:6px; text-align:center;">
    @php
    $monthName = [
        1 => 'มกราคม',
        2 => 'กุมภาพันธ์',
        3 => 'มีนาคม',
        4 => 'เมษายน',
        5 => 'พฤษภาคม',
        6 => 'มิถุนายน',
        7 => 'กรกฎาคม',
        8 => 'สิงหาคม',
        9 => 'กันยายน',
        10 => 'ตุลาคม',
        11 => 'พฤศจิกายน',
        12 => 'ธันวาคม',
    ];
    @endphp

    {{ $monthName[(int)($r->month_no ?? 0)] ?? '-' }}
</td>

                    <td style="border:1px solid #d5dfeb; padding:6px; font-weight:bold;">
                        {{ $r->district_name_th }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:center;">
                        {{ $r->sex_name_th }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:center; background:#edf4fb;">
                        {{ $r->age_group }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px;">
                        {{ $r->cause_of_death }}
                    </td>

                    <td style="border:1px solid #d5dfeb; padding:6px; text-align:right; background:#edf4fb;">
                        {{ number_format($r->death_total ?? 0) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; border:1px solid #d5dfeb; padding:10px;">
                        ไม่พบข้อมูล
                    </td>
                </tr>
            @endforelse

            @if(count($rows) > 0)
                <tr style="background:#eaf2fb; font-weight:bold;">
                    <td colspan="6" style="border:1px solid #bfcddd; padding:8px; text-align:right;">
                        รวมจำนวนผู้เสียชีวิตทั้งหมด
                    </td>
                    <td style="border:1px solid #bfcddd; padding:8px; text-align:right;">
                        {{ number_format($sumDeath) }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    
</body>
</html>