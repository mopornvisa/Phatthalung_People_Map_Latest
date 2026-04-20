@php
    $summary = $summary ?? [];
    $rows = $rows ?? collect();

    $selectedYearOld = $year ?? ($rows->first()->year_old ?? '');
    $selectedYearNew = $yearNew ?? ($rows->first()->year_new ?? '');
@endphp
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เปรียบเทียบอัตราป่วยโรคหลอดเลือดหัวใจลดลงแต่ละปี</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body{
            font-family:'Prompt',system-ui,sans-serif;
            margin:0;
            color:#0f172a;
        }

        .app-bg{
            background:
                radial-gradient(circle at top left, rgba(14,165,164,.18), transparent 26%),
                radial-gradient(circle at top right, rgba(45,116,218,.14), transparent 26%),
                linear-gradient(135deg,#dff5f7 0%,#eaf8f3 45%,#f4f9fc 100%);
            min-height:100vh;
        }

        .shadow-soft{
            box-shadow:0 14px 34px rgba(2, 6, 23, .08) !important;
        }

        .ga-page{
            background:rgba(255,255,255,.86);
            border:1px solid rgba(255,255,255,.7);
            padding:22px;
            border-radius:28px;
            box-shadow:0 16px 36px rgba(2, 6, 23, .08);
            backdrop-filter:blur(8px);
        }

        .ga-topbar{
            background:linear-gradient(135deg,#ffffff 0%,#f7fcff 100%);
            border:1px solid #d8ebf2;
            padding:16px 18px;
            margin-bottom:18px;
            border-radius:22px;
            box-shadow:0 10px 24px rgba(2, 6, 23, .05);
        }

        .ga-title{
            font-size:20px;
            font-weight:700;
            color:#0f172a;
            display:flex;
            align-items:center;
            gap:12px;
            line-height:1.25;
        }

        .ga-title i{
            font-size:24px;
            color:#0ea5a4;
            width:46px;
            height:46px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border-radius:16px;
            background:linear-gradient(135deg,#d7fbf1 0%,#dbeafe 100%);
            box-shadow:inset 0 1px 0 rgba(255,255,255,.7);
        }

        .ga-filter-card,
        .ga-kpi,
        .ga-panel,
        .ga-table-panel{
            background:linear-gradient(135deg,#ffffff 0%,#f9fcff 100%);
            border:1px solid #dcecf2;
            border-radius:22px;
            box-shadow:0 10px 24px rgba(2, 6, 23, .05);
        }

        .ga-filter-card{
            padding:18px;
            margin-bottom:18px;
        }

        .ga-filter-label{
            display:block;
            font-size:12px;
            font-weight:600;
            color:#64748b;
            margin-bottom:6px;
        }

        .ga-filter{
            background:#fff;
            border:1px solid #d8e8ef;
            border-radius:14px;
            min-height:46px;
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
            min-height:46px;
            font-size:13px;
            font-weight:700;
            box-shadow:0 8px 18px rgba(45,116,218,.18);
        }

        .ga-btn:hover{
            color:#fff;
            opacity:.96;
        }

        .ga-btn-light{
            background:#fff;
            border:1px solid #d8e8ef;
            color:#334155;
            border-radius:14px;
            min-height:46px;
            font-size:13px;
            font-weight:700;
        }

        .ga-kpi{
            padding:18px;
            min-height:110px;
            position:relative;
            overflow:hidden;
        }

        .ga-kpi::after{
            content:'';
            position:absolute;
            right:-20px;
            top:-20px;
            width:90px;
            height:90px;
            border-radius:50%;
            background:linear-gradient(135deg, rgba(14,165,164,.12), rgba(45,116,218,.08));
        }

        .ga-kpi-label{
            color:#64748b;
            font-size:12px;
            margin-bottom:8px;
            position:relative;
            z-index:1;
        }

        .ga-kpi-value{
            color:#0f172a;
            font-size:26px;
            font-weight:700;
            margin:0;
            position:relative;
            z-index:1;
        }

        .ga-panel{
            height:100%;
        }

        .ga-panel-title{
            color:#334155;
            font-size:13px;
            padding:16px 16px 0;
            font-weight:700;
        }

        .ga-panel-body{
            padding:12px 16px 18px;
        }

        .ga-chart-wrap{
            position:relative;
            height:300px;
        }

        .ga-table-panel{
            margin-top:18px;
            border:1px solid #d9e6ee;
            border-radius:24px;
            background:linear-gradient(135deg,#ffffff 0%,#fbfdff 100%);
            box-shadow:0 10px 24px rgba(2, 6, 23, .05);
            overflow:hidden;
        }

        .ga-table-head{
            padding:20px 24px 12px;
            border-bottom:1px solid #e8eef5;
            background:linear-gradient(135deg,#f8fcff 0%,#f3fbf8 100%);
        }

        .ga-table-head-title{
            font-size:15px;
            font-weight:700;
            color:#0f172a;
            line-height:1.3;
        }

        .ga-table-head-sub{
            margin-top:4px;
            font-size:12px;
            color:#64748b;
        }

        .ga-table-wrap{
            padding:18px 22px 22px;
        }

        .ga-table-clean{
            width:100%;
            table-layout:fixed;
            border-collapse:separate;
            border-spacing:0;
            overflow:hidden;
            border-radius:16px;
            font-size:11px;
            margin:0;
        }

        .ga-table-clean thead th{
            background:#cfdceb;
            color:#1e293b;
            border:1px solid #bcccdc;
            text-align:center;
            vertical-align:middle;
            padding:8px 6px;
            font-weight:700;
        }

        .ga-table-clean thead tr:nth-child(2) th{
            background:#dbe6f2;
            font-size:10px;
        }

        .ga-table-clean tbody td,
        .ga-table-clean tfoot td{
            border:1px solid #d7e0ea;
            padding:6px; 
            vertical-align:middle;
            background:#fff;
            font-size:11px; 
        }

        .ga-table-clean tbody tr:nth-child(even) td{
            background:#f8fbff;
        }

        .ga-table-clean tbody tr:hover td{
            background:#eef6ff;
        }

        .ga-table-clean .col-district{
            width:14%;
        }

        .ga-table-clean .col-percent{
            width:12%;
            min-width:110px;
        }

        .ga-table-clean .group-head{
            text-align:center;
        }

        .metric-cell{
            background:#edf4fb !important;
            font-weight:600;
        }

        .percent-cell{
            text-align:center;
            white-space:nowrap;
        }

        .ga-total-row td{
            background:#e6eff8 !important;
            font-weight:700;
            color:#0f172a;
        }

        .metric-green{
            color:#16a34a;
            font-weight:700;
        }

        .metric-red{
            color:#dc2626;
            font-weight:700;
        }

        .page-wrap{
            max-width:1450px;
            margin:34px auto;
            padding:0 18px 32px;
        }

        .loading-overlay{
            position:fixed;
            inset:0;
            background:rgba(15, 23, 42, 0.55);
            backdrop-filter:blur(3px);
            display:none;
            align-items:center;
            justify-content:center;
            z-index:99999;
        }

        .loading-modal{
            text-align:center;
        }

        .loading-ring{
            width:108px;
            height:108px;
            border:7px solid rgba(255,255,255,.95);
            border-radius:50%;
            margin:0 auto 18px;
            position:relative;
            box-shadow:0 8px 30px rgba(0,0,0,.18);
            animation:ringPulse 1.4s ease-in-out infinite;
        }

        .loading-needle{
            position:absolute;
            width:10px;
            height:38px;
            background:#ffffff;
            border-radius:999px;
            left:50%;
            top:50%;
            transform-origin:center 85%;
            transform:translate(-50%, -85%) rotate(45deg);
            animation:needleSpin 1.2s ease-in-out infinite;
        }

        .loading-needle::after{
            content:'';
            position:absolute;
            bottom:-5px;
            left:50%;
            transform:translateX(-50%);
            width:14px;
            height:14px;
            background:#ffffff;
            border-radius:50%;
        }

        .loading-text{
            color:#ffffff;
            font-size:16px;
            font-weight:700;
        }

        .ga-legend-box{
            margin-top:18px;
            background:linear-gradient(135deg,#ffffff 0%,#f9fcff 100%);
            border:1px solid #dcecf2;
            border-radius:18px;
            padding:14px 16px;
            box-shadow:0 10px 24px rgba(2, 6, 23, .05);
        }

        .ga-legend-title{
            font-size:13px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:10px;
        }

        .ga-legend-item{
            font-size:12px;
            color:#475569;
            padding:8px 12px;
            background:#f8fbfd;
            border:1px solid #e5edf4;
            border-radius:12px;
            margin-bottom:8px;
        }

        @keyframes needleSpin{
            0%   { transform: translate(-50%, -85%) rotate(-35deg); }
            50%  { transform: translate(-50%, -85%) rotate(45deg); }
            100% { transform: translate(-50%, -85%) rotate(-35deg); }
        }

        @keyframes ringPulse{
            0%,100%{ transform: scale(1); opacity:1; }
            50%{ transform: scale(1.03); opacity:.95; }
        }

        @media (max-width:768px){
            .ga-page{
                padding:14px;
                border-radius:18px;
            }

            .ga-title{
                font-size:16px;
            }

            .ga-kpi-value{
                font-size:22px;
            }

            .ga-chart-wrap{
                height:260px;
            }

            .ga-table-wrap{
                padding:12px;
                overflow-x:auto;
            }

            .ga-table-clean{
                min-width:900px;
            }
        }
         .ga-filter-actions{
            margin-top:16px;
            padding-top:16px;
            border-top:1px dashed #d8e8ef;
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
        }

        .ga-filter-actions-text{
            display:flex;
            align-items:center;
            gap:10px;
            color:#475569;
            font-size:13px;
            font-weight:500;
        }

        .ga-filter-actions-text i{
            width:36px;
            height:36px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border-radius:12px;
            color:#15803d;
            background:linear-gradient(135deg,#dcfce7 0%,#ecfdf5 100%);
            border:1px solid #bbf7d0;
            font-size:16px;
        }
         .ga-btn-export{
            background:linear-gradient(135deg,#16a34a 0%,#22c55e 100%);
            border:none;
            color:#fff;
            border-radius:16px;
            min-height:48px;
            padding:0 18px;
            font-size:13px;
            font-weight:700;
            box-shadow:0 10px 22px rgba(34,197,94,.22);
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            transition:.2s ease;
            text-decoration:none;
        }

        .ga-btn-export:hover{
            color:#fff;
            transform:translateY(-2px);
            box-shadow:0 14px 28px rgba(34,197,94,.28);
        }
    </style>
</head>
<body class="app-bg">

@include('layouts.topbar')

<div class="page-wrap">
    <div class="ga-page shadow-soft">

        <div class="ga-topbar">
            <div class="ga-title">
                <i class="bi bi-graph-down-arrow"></i>
                <span>เปรียบเทียบอัตราป่วยโรคหลอดเลือดหัวใจลดลงแต่ละปี</span>
            </div>
        </div>

        <div class="ga-filter-card">
            <form method="GET" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="ga-filter-label">ปี</label>
                        <select name="year" class="form-select ga-filter">
                           
                            @foreach(($yearList ?? []) as $y)
                                <option value="{{ $y }}" {{ (string)($year ?? '') === (string)$y ? 'selected' : '' }}>
                                    ปี {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="ga-filter-label">อำเภอ</label>
                        <select name="district" class="form-select ga-filter">
                            <option value="">ทุกอำเภอ</option>
                            @foreach(($districtList ?? []) as $d)
                                <option value="{{ $d }}" {{ ($district ?? '') === $d ? 'selected' : '' }}>
                                    {{ $d }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn ga-btn w-100">
                            <i class="bi bi-search me-1"></i> ค้นหา
                        </button>
                    </div>

                    <div class="col-md-2">
                        <a href="{{ route('health.cardio_compare') }}" class="btn ga-btn-light w-100">
                            <i class="bi bi-arrow-clockwise me-1"></i> ล้างข้อมูล
                        </a>
                    </div>
                </div>
                <div class="ga-filter-actions">
                    <div class="ga-filter-actions-text">
                        <i class="bi bi-file-earmark-excel-fill"></i>
                        <div>
                            <div style="font-weight:700; color:#0f172a;">ส่งออกข้อมูลรายงาน</div>
                            <div style="font-size:12px; color:#64748b;">ดาวน์โหลดข้อมูลตามตัวกรองที่เลือกเป็นไฟล์ Excel</div>
                        </div>
                    </div>

                <a href="{{ route('health.cardio_compare.export', request()->query()) }}" class="btn ga-btn-export">
    <i class="bi bi-download"></i> Export Excel
</a>
                </div>
            </form>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="ga-kpi">
                    <div class="ga-kpi-label">อัตราป่วยเฉลี่ยปี {{ $selectedYearOld ?: '-' }}</div>
                    <h3 class="ga-kpi-value">{{ number_format($summary['rate_old'] ?? 0, 2) }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ga-kpi">
                    <div class="ga-kpi-label">อัตราป่วยเฉลี่ยปี {{ $selectedYearNew ?: '-' }}</div>
                    <h3 class="ga-kpi-value">{{ number_format($summary['rate_new'] ?? 0, 2) }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ga-kpi">
                    <div class="ga-kpi-label">ร้อยละการลดลงเฉลี่ย </div>
                    <h3 class="ga-kpi-value">{{ number_format($summary['cardio_avg'] ?? 0, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-6">
                <div class="ga-panel">
                    <div class="ga-panel-title">อัตราต่อแสนประชากร ปี {{ $selectedYearOld ?: '-' }}</div>
                    <div class="ga-panel-body">
                        <div class="ga-chart-wrap">
                            <canvas id="oldYearChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="ga-panel">
                    <div class="ga-panel-title">อัตราต่อแสนประชากร ปี {{ $selectedYearNew ?: '-' }}</div>
                    <div class="ga-panel-body">
                        <div class="ga-chart-wrap">
                            <canvas id="newYearChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ga-table-panel mt-4">
            <div class="ga-table-head">
                <div>
                    <div class="ga-table-head-title">ตารางเปรียบเทียบข้อมูลรายอำเภอ</div>
                    <div class="ga-table-head-sub">
                        เปรียบเทียบข้อมูลปี {{ $selectedYearOld ?: '-' }} และ {{ $selectedYearNew ?: '-' }}
                    </div>
                </div>
            </div>

            <div class="ga-table-wrap">
                <table class="table ga-table-clean align-middle mb-0">
                    <thead>
                        <tr>
                            <th rowspan="2" class="col-district">อำเภอ</th>

                            <th colspan="3" class="group-head">
                                ข้อมูลปี {{ $selectedYearOld ?: '-' }}
                            </th>

                            <th colspan="3" class="group-head">
                                ข้อมูลปี {{ $selectedYearNew ?: '-' }}
                            </th>

                            <th rowspan="2" class="col-percent">
    ร้อยละการลดลง<br>
    (B - A) / B × 100
</th>
                        </tr>

                        <tr>
                            <th>ประชากร</th>
                            <th>ผู้ป่วย</th>
                            <th>อัตรา (B)</th>

                            <th>ประชากร</th>
                            <th>ผู้ป่วย</th>
                            <th>อัตรา (A)</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rows as $r)
                            <tr>
                                <td class="text-start fw-semibold">
                                    {{ $r->district_name_thai }}
                                </td>

                                <td class="text-end metric-cell">
                                    {{ number_format($r->population_old ?? 0) }}
                                </td>
                                <td class="text-end metric-cell">
                                    {{ number_format($r->patient_old ?? 0) }}
                                </td>
                                <td class="text-end metric-cell">
                                    {{ number_format($r->rate_old ?? 0, 2) }}
                                </td>

                                <td class="text-end metric-cell">
                                    {{ number_format($r->population_new ?? 0) }}
                                </td>
                                <td class="text-end metric-cell">
                                    {{ number_format($r->patient_new ?? 0) }}
                                </td>
                                <td class="text-end metric-cell">
                                    {{ number_format($r->rate_new ?? 0, 2) }}
                                </td>

                                <td class="percent-cell">
                                    <span class="fw-bold {{ ($r->cardio ?? 0) >= 0 ? 'metric-green' : 'metric-red' }}">
                                        {{ number_format($r->cardio ?? 0, 2) }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">ไม่พบข้อมูล</td>
                            </tr>
                        @endforelse
                    </tbody>

                    <tfoot>
                        <tr class="ga-total-row">
                            <td class="text-start fw-bold">รวม/เฉลี่ย</td>
                            <td class="text-end">{{ number_format($summary['population_old'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['patient_old'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['rate_old'] ?? 0, 2) }}</td>
                            <td class="text-end">{{ number_format($summary['population_new'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['patient_new'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['rate_new'] ?? 0, 2) }}</td>
                            <td class="text-center fw-bold">{{ number_format($summary['cardio_avg'] ?? 0, 2) }}%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            

    </div>
      <div class="ga-legend-box">
            <div class="ga-legend-title">คำอธิบายตัวชี้วัด</div>
            <div class="ga-legend-item">
                <strong>A</strong> หมายถึง  อัตราผู้ป่วยรายใหม่จากโรคหลอดเลือดหัวใจ ในปีงบประมาณถัดไป
            </div>
            <div class="ga-legend-item mb-0">
                <strong>B</strong> หมายถึง  อัตราผู้ป่วยรายใหม่จากโรคหลอดเลือดหัวใจ ในปีงบประมาณปัจจุบัน
            </div>
        </div>
       
</div>

<div id="loadingOverlay" class="loading-overlay">
    <div class="loading-modal">
        <div class="loading-ring">
            <div class="loading-needle"></div>
        </div>
        <div class="loading-text">กำลังประมวลผล</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = @json(collect($rows)->pluck('district_name_thai')->values());
    const oldRates = @json(collect($rows)->pluck('rate_old')->map(fn($v) => (float)($v ?? 0))->values());
    const newRates = @json(collect($rows)->pluck('rate_new')->map(fn($v) => (float)($v ?? 0))->values());

    const baseOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
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
    };

    const oldYearChart = document.getElementById('oldYearChart');
    if (oldYearChart) {
        new Chart(oldYearChart, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    data: oldRates,
                    backgroundColor: '#94a3b8',
                    borderColor: '#94a3b8',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: baseOptions
        });
    }

    const newYearChart = document.getElementById('newYearChart');
    if (newYearChart) {
        new Chart(newYearChart, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    data: newRates,
                    backgroundColor: '#0ea5a4',
                    borderColor: '#0ea5a4',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: baseOptions
        });
    }

    const filterForm = document.getElementById('filterForm');
    const overlay = document.getElementById('loadingOverlay');

    if (filterForm && overlay) {
        let submitting = false;

        filterForm.addEventListener('submit', function (e) {
            if (submitting) return;
            submitting = true;
            overlay.style.display = 'flex';
            e.preventDefault();

            setTimeout(() => {
                filterForm.submit();
            }, 900);
        });
    }
});
</script>

</body>
</html>