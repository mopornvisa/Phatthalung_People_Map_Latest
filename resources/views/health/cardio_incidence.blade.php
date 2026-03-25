<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อัตราป่วยรายใหม่โรคหัวใจ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body{
            font-family:'Prompt',system-ui,sans-serif;
            margin:0;
        }

        .app-bg{
            background:linear-gradient(135deg,#CFEFF3 0%,#DFF7EF 50%,#F0F8FB 100%);
            min-height:100vh;
        }

        .shadow-soft{
            box-shadow:0 12px 28px rgba(2, 6, 23, .08) !important;
        }

        .container-fluid{
            max-width:1450px;
            margin:auto;
        }

        .ga-page{
            background:rgba(255,255,255,.88);
            border:1px solid rgba(255,255,255,.65);
            padding:20px;
            border-radius:24px;
            box-shadow:0 12px 28px rgba(2, 6, 23, .08);
            backdrop-filter:blur(6px);
        }

        .ga-topbar{
            background:linear-gradient(135deg,#ffffff 0%,#f7fcff 100%);
            border:1px solid #d8ebf2;
            padding:14px 18px;
            margin-bottom:16px;
            border-radius:20px;
            box-shadow:0 8px 20px rgba(2, 6, 23, .05);
        }

        .ga-brand{
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:12px;
        }

        .ga-title{
            font-size:18px;
            font-weight:700;
            color:#0f172a;
            display:flex;
            align-items:center;
            gap:10px;
            line-height:1.25;
        }

        .ga-title i{
            font-size:24px;
            color:#0ea5a4;
            width:42px;
            height:42px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border-radius:14px;
            background:linear-gradient(135deg,#d7fbf1 0%,#dbeafe 100%);
        }

        .ga-title span{
            display:inline-block;
        }

        .ga-right-title{
            color:#0b7f6f;
            font-weight:700;
            font-size:16px;
            padding:8px 14px;
            border-radius:999px;
            background:#ecfdf5;
            border:1px solid #cdeee3;
        }

        .ga-filter-row{
            margin-bottom:16px;
        }

        .ga-filter{
            background:#fff;
            border:1px solid #d8e8ef;
            border-radius:14px;
            min-height:44px;
            font-size:13px;
            color:#1f2937;
            box-shadow:none !important;
        }

        .ga-filter:focus{
            border-color:#0ea5a4;
            box-shadow:0 0 0 .15rem rgba(14,165,164,.12) !important;
        }

        .ga-btn{
            background:linear-gradient(135deg,#0ea5a4 0%,#2d74da 100%);
            border:none;
            color:#fff;
            border-radius:14px;
            min-height:44px;
            font-size:13px;
            font-weight:600;
            box-shadow:0 8px 18px rgba(45,116,218,.18);
        }

        .ga-btn:hover{
            color:#fff;
            opacity:.95;
        }

        .ga-btn-light{
            background:#fff;
            border:1px solid #d8e8ef;
            color:#334155;
            border-radius:14px;
            min-height:44px;
            font-size:13px;
            font-weight:600;
        }

        .ga-btn-light:hover{
            background:#f8fbfd;
            color:#0f172a;
        }

        .ga-kpi{
            background:linear-gradient(135deg,#ffffff 0%,#f9fcff 100%);
            border:1px solid #dcecf2;
            padding:16px 18px;
            min-height:96px;
            border-radius:20px;
            box-shadow:0 10px 24px rgba(2, 6, 23, .05);
        }

        .ga-kpi-label{
            color:#64748b;
            font-size:12px;
            margin-bottom:6px;
            line-height:1.2;
        }

        .ga-kpi-value{
            color:#0f172a;
            font-size:22px;
            font-weight:700;
            margin:0;
            line-height:1.2;
        }

        .ga-panel{
            background:linear-gradient(135deg,#ffffff 0%,#fafdff 100%);
            border:1px solid #dcecf2;
            margin-bottom:10px;
            border-radius:20px;
            box-shadow:0 10px 24px rgba(2, 6, 23, .05);
        }

        .ga-panel-title{
            color:#475569;
            font-size:12px;
            padding:14px 14px 0 14px;
            font-weight:700;
        }

        .ga-panel-body{
            padding:10px 14px 16px 14px;
        }

        .ga-chart-wrap{
            position:relative;
            height:230px;
        }

        .ga-table-panel{
            background:linear-gradient(135deg,#ffffff 0%,#fbfdff 100%);
            border:1px solid #dcecf2;
            margin-top:16px;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 10px 24px rgba(2, 6, 23, .05);
        }

        .ga-section-tabs{
            display:grid;
            grid-template-columns:1fr 1fr;
            border-bottom:1px solid #dcecf2;
            background:#f6fbfd;
        }

        .ga-section-tab{
            text-align:center;
            padding:12px 6px;
            font-size:12px;
            color:#64748b;
            border-right:1px solid #dcecf2;
            font-weight:700;
        }

        .ga-section-tab:last-child{
            border-right:none;
        }

        .table-responsive{
            padding:0 14px 12px 14px;
        }

        .ga-table{
            margin-bottom:0;
            font-size:12px;
            min-width:1200px;
        }

        .ga-table thead th{
            background:linear-gradient(135deg,#0b7f6f 0%,#2d74da 100%);
            color:#fff;
            border:1px solid #d7e3ea !important;
            text-align:center;
            vertical-align:middle;
            white-space:nowrap;
            padding:8px 8px;
            font-weight:700;
        }

        .ga-table tbody td{
            border:1px solid #dbe7ee;
            padding:6px 8px;
            vertical-align:middle;
            background:#fff;
        }

        .ga-table tbody tr:nth-child(even) td{
            background:#f9fcfe;
        }

        .ga-table tbody tr:hover td{
            background:#eef8ff;
        }

        .ga-total-row td{
            background:#e8f6f3 !important;
            font-weight:700;
            color:#0f172a;
        }

        .metric-blue{
            background:#dff2ff !important;
            font-weight:600;
        }

        .metric-orange{
            background:#fff0d8 !important;
            font-weight:600;
        }

        .ga-small-note{
            color:#64748b;
            font-size:11px;
            padding:0 14px 14px 14px;
        }

        @media (max-width: 768px){
            .container-fluid{
                padding-left:12px;
                padding-right:12px;
            }

            .ga-page{
                padding:14px;
                border-radius:18px;
            }

            .ga-title{
                font-size:15px;
            }

            .ga-right-title{
                font-size:14px;
            }

            .table-responsive{
                padding:0 8px 10px 8px;
            }
        }
    </style>
</head>
<body class="app-bg">
@include('layouts.topbar')

<div class="container-fluid py-4">
    <div class="ga-page shadow-soft">

        <div class="ga-topbar">
            <div class="ga-brand">
                <div class="ga-title">
                    <i class="bi bi-heart-pulse-fill"></i>
                    <span>อัตราป่วยรายใหม่โรคหัวใจและหลอดเลือด</span>
                </div>
                <div class="ga-right-title">
                    Health Dashboard
                </div>
            </div>
        </div>

        <form method="GET" class="ga-filter-row">
            <div class="row g-2">
                <div class="col-md-3">
                    <select name="year" class="form-select ga-filter">
                        <option value="">ปีงบประมาณทั้งหมด</option>
                        @foreach($yearList as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                ปี {{ $y }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="district" class="form-select ga-filter">
                        <option value="">ทุกอำเภอ</option>
                        @foreach($districtList as $d)
                            <option value="{{ $d }}" {{ $district == $d ? 'selected' : '' }}>
                                {{ $d }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn ga-btn w-100">
                        <i class="bi bi-search me-1"></i> ดูรายงาน
                    </button>
                </div>

                <div class="col-md-3">
                    <a href="{{ url()->current() }}" class="btn ga-btn-light w-100">
                        <i class="bi bi-arrow-clockwise me-1"></i> ล้างข้อมูล
                    </a>
                </div>
            </div>
        </form>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="ga-kpi">
                    <div class="ga-kpi-label">จำนวนป่วยรายใหม่</div>
                    <h3 class="ga-kpi-value">{{ number_format($summary['case'] ?? 0) }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ga-kpi">
                    <div class="ga-kpi-label">ประชากร</div>
                    <h3 class="ga-kpi-value">{{ number_format($summary['pop'] ?? 0) }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ga-kpi">
                    <div class="ga-kpi-label">อัตราต่อแสน</div>
                    <h3 class="ga-kpi-value">{{ number_format($summary['rate'] ?? 0, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="ga-panel">
                    <div class="ga-panel-title">สัดส่วนผู้ป่วยรายอำเภอ</div>
                    <div class="ga-panel-body">
                        <div class="ga-chart-wrap">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ga-panel">
                    <div class="ga-panel-title">อัตราต่อแสนรายอำเภอ</div>
                    <div class="ga-panel-body">
                        <div class="ga-chart-wrap">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ga-panel">
                    <div class="ga-panel-title">ผู้ป่วยรายใหม่รายเดือน (รวม)</div>
                    <div class="ga-panel-body">
                        <div class="ga-chart-wrap">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ga-table-panel">
            <div class="ga-section-tabs">
                <div class="ga-section-tab">Acquisition</div>
                <div class="ga-section-tab">Behavior</div>
            </div>

            <div class="table-responsive">
                <table class="table ga-table">
                    <thead>
                        <tr>
                            <th rowspan="2">อำเภอ</th>
                            <th colspan="3">Acquisition</th>
                            <th colspan="2">Behavior</th>
                            <th colspan="12">จำนวนผู้ป่วยรายใหม่รายเดือน</th>
                        </tr>
                        <tr>
                            <th>B ประชากร</th>
                            <th>A ผู้ป่วย</th>
                            <th>อัตราต่อแสน</th>
                            <th>ค่าเฉลี่ย/เดือน</th>
                            <th>สัดส่วนผู้ป่วย</th>
                            <th>ต.ค.</th>
                            <th>พ.ย.</th>
                            <th>ธ.ค.</th>
                            <th>ม.ค.</th>
                            <th>ก.พ.</th>
                            <th>มี.ค.</th>
                            <th>เม.ย.</th>
                            <th>พ.ค.</th>
                            <th>มิ.ย.</th>
                            <th>ก.ค.</th>
                            <th>ส.ค.</th>
                            <th>ก.ย.</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $totalCase = max((float)($summary['case'] ?? 0), 1);
                        @endphp

                        @forelse($rows as $r)
                            @php
                                $patient = (float)($r->patient_total ?? 0);
                                $rate = (float)($r->rate_per_100k ?? 0);
                                $avgPerMonth = $patient / 12;
                                $share = ($patient / $totalCase) * 100;
                            @endphp
                            <tr>
                                <td>{{ $r->district_name_thai }}</td>

                                <td class="text-end metric-blue">{{ number_format($r->population_civil_registry ?? 0) }}</td>
                                <td class="text-end metric-blue">{{ number_format($patient) }}</td>
                                <td class="text-end metric-blue">{{ number_format($rate, 2) }}</td>

                                <td class="text-end metric-orange">{{ number_format($avgPerMonth, 2) }}</td>
                                <td class="text-end metric-orange">{{ number_format($share, 2) }}%</td>

                                <td class="text-end">{{ number_format($r->month10 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month11 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month12 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month1 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month2 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month3 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month4 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month5 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month6 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month7 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month8 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month9 ?? 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="18" class="text-center text-muted py-4">ไม่พบข้อมูล</td>
                            </tr>
                        @endforelse

                        <tr class="ga-total-row">
                            <td>รวม</td>
                            <td class="text-end">{{ number_format($summary['pop'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['case'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['rate'] ?? 0, 2) }}</td>
                            <td class="text-end">{{ number_format(((float)($summary['case'] ?? 0))/12, 2) }}</td>
                            <td class="text-end">100.00%</td>
                            <td class="text-end">{{ number_format($summary['month10'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month11'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month12'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month1'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month2'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month3'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month4'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month5'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month6'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month7'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month8'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month9'] ?? 0) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="ga-small-note text-end">
                แสดงข้อมูลสรุปรายอำเภอ
            </div>
        </div>
<div div class="ga-kpi-label">A หมายถึง จำนวนผู้ป่วยโรคหัวใจและหลอดเลือด (Coronary heart disease) รายใหม่ในปี</div>
<div div class="ga-kpi-label">B หมายถึง จำนวนประชากรทะเบียนราษฎร์</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = @json(collect($rows)->pluck('district_name_thai')->values());
    const cases = @json(collect($rows)->pluck('patient_total')->map(fn($v) => (float)($v ?? 0))->values());
    const rates = @json(collect($rows)->pluck('rate_per_100k')->map(fn($v) => (float)($v ?? 0))->values());

    const monthly = [
        {{ (float)($summary['month10'] ?? 0) }},
        {{ (float)($summary['month11'] ?? 0) }},
        {{ (float)($summary['month12'] ?? 0) }},
        {{ (float)($summary['month1'] ?? 0) }},
        {{ (float)($summary['month2'] ?? 0) }},
        {{ (float)($summary['month3'] ?? 0) }},
        {{ (float)($summary['month4'] ?? 0) }},
        {{ (float)($summary['month5'] ?? 0) }},
        {{ (float)($summary['month6'] ?? 0) }},
        {{ (float)($summary['month7'] ?? 0) }},
        {{ (float)($summary['month8'] ?? 0) }},
        {{ (float)($summary['month9'] ?? 0) }}
    ];

    const monthLabels = ['ต.ค.','พ.ย.','ธ.ค.','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.'];

    const baseOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    font: { family: 'Prompt', size: 11 }
                }
            }
        }
    };

    const pieEl = document.getElementById('pieChart');
    if (pieEl) {
        new Chart(pieEl, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: cases,
                    backgroundColor: [
                        '#14b8a6','#60a5fa','#f59e0b','#8b5cf6','#22c55e',
                        '#ef4444','#ec4899','#06b6d4','#f97316','#84cc16','#6366f1'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                ...baseOptions,
                cutout: '60%'
            }
        });
    }

    const barEl = document.getElementById('barChart');
    if (barEl) {
        new Chart(barEl, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'อัตราต่อแสน',
                    data: rates,
                    backgroundColor: '#2d74da',
                    borderColor: '#2d74da',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                ...baseOptions,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        ticks: {
                            font: { family: 'Prompt', size: 10 },
                            color: '#334155'
                        },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: { family: 'Prompt', size: 10 },
                            color: '#334155'
                        },
                        grid: { color: '#e2e8f0' }
                    }
                }
            }
        });
    }

    const lineEl = document.getElementById('lineChart');
    if (lineEl) {
        new Chart(lineEl, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'ผู้ป่วยรายใหม่',
                    data: monthly,
                    borderColor: '#0ea5a4',
                    backgroundColor: '#0ea5a4',
                    pointRadius: 3,
                    pointHoverRadius: 4,
                    tension: 0.3,
                    fill: false
                }]
            },
            options: {
                ...baseOptions,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        ticks: {
                            font: { family: 'Prompt', size: 10 },
                            color: '#334155'
                        },
                        grid: { color: '#eef2f7' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: { family: 'Prompt', size: 10 },
                            color: '#334155'
                        },
                        grid: { color: '#e2e8f0' }
                    }
                }
            }
        });
    }
});
</script>

</body>
</html>