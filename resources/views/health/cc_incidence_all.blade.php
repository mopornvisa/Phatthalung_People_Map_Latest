<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อัตราป่วยโรคมะเร็งปากมดลูก</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        .shadow-soft{ box-shadow:0 14px 34px rgba(2, 6, 23, .08) !important; }
        .page-wrap{ max-width:1450px; margin:34px auto; padding:0 18px 32px; }
        .ga-page{
            background:rgba(255,255,255,.86);
            border:1px solid rgba(255,255,255,.7);
            padding:22px;
            border-radius:28px;
            box-shadow:0 16px 36px rgba(2, 6, 23, .08);
            backdrop-filter:blur(8px);
        }
        .ga-topbar,.ga-filter-card,.ga-kpi,.ga-panel,.ga-table-panel,.ga-note,.ga-legend-box{
            background:linear-gradient(135deg,#ffffff 0%,#f9fcff 100%);
            border:1px solid #dcecf2;
            box-shadow:0 10px 24px rgba(2, 6, 23, .05);
        }
        .ga-topbar{ padding:16px 18px; margin-bottom:18px; border-radius:22px; }
        .ga-title{
            font-size:20px; font-weight:700; color:#0f172a;
            display:flex; align-items:center; gap:12px; line-height:1.25;
        }
        .ga-title i{
            font-size:24px; color:#0ea5a4; width:46px; height:46px;
            display:inline-flex; align-items:center; justify-content:center;
            border-radius:16px; background:linear-gradient(135deg,#d7fbf1 0%,#dbeafe 100%);
        }
        .ga-subtitle{ margin-top:8px; color:#64748b; font-size:13px; line-height:1.5; }
        .ga-filter-card{ border-radius:22px; padding:18px; margin-bottom:18px; }
        .ga-filter-label{ display:block; font-size:12px; font-weight:600; color:#64748b; margin-bottom:6px; }
        .ga-filter{
            background:#fff; border:1px solid #d8e8ef; border-radius:14px;
            min-height:46px; font-size:13px; color:#1f2937;
        }
        .ga-btn{
            background:linear-gradient(135deg,#0ea5a4 0%,#2d74da 100%);
            border:none; color:#fff; border-radius:14px; min-height:46px;
            font-size:13px; font-weight:700;
        }
        .ga-btn-light{
            background:#fff; border:1px solid #d8e8ef; color:#334155;
            border-radius:14px; min-height:46px; font-size:13px; font-weight:700;
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
            border:none; color:#fff; border-radius:16px; min-height:48px; padding:0 18px;
            font-size:13px; font-weight:700; text-decoration:none;
            display:inline-flex; align-items:center; gap:8px;
        }
        .ga-kpi{
            padding:18px; min-height:110px; border-radius:22px; position:relative; overflow:hidden; height:100%;
        }
        .ga-kpi-label{ color:#64748b; font-size:12px; margin-bottom:8px; }
        .ga-kpi-value{ color:#0f172a; font-size:26px; font-weight:700; margin:0; }
        .ga-note{ margin-bottom:18px; border-radius:18px; padding:14px 16px; color:#475569; font-size:12px; }
        .ga-panel{ margin-bottom:10px; border-radius:22px; height:100%; }
        .ga-panel-title{ color:#334155; font-size:13px; padding:16px 16px 0 16px; font-weight:700; }
        .ga-panel-body{ padding:12px 16px 18px 16px; }
        .ga-chart-wrap{ position:relative; height:245px; }
        .ga-table-panel{ margin-top:18px; border-radius:22px; overflow:hidden; }
        .ga-table-head{
            display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap;
            gap:10px; padding:16px 18px; border-bottom:1px solid #e5edf4;
            background:linear-gradient(135deg,#f8fcff 0%,#f3fbf8 100%);
        }
        .ga-table-head-title{ font-size:15px; font-weight:700; color:#0f172a; }
        .ga-table-head-sub{ font-size:12px; color:#64748b; }
        .table-responsive{ padding:0 14px 12px 14px; }
        .ga-table{ width:100%; min-width:1700px; margin-bottom:0; border-collapse:collapse; font-size:11px; }
        .ga-table thead th{
            background:#d9e7f5 !important; color:#1e293b !important; border:1px solid #bfcddd !important;
            text-align:center; vertical-align:middle; white-space:nowrap; padding:8px 6px; font-weight:700;
        }
        .ga-table thead tr:first-child th{ background:#cfe0f2 !important; }
        .ga-table thead tr:nth-child(2) th{ background:#e5eff9 !important; font-size:10px; }
        .ga-table tbody td{
            border:1px solid #d5dfeb; padding:6px 6px; vertical-align:middle; background:#fff; white-space:nowrap;
        }
        .ga-table tbody tr:nth-child(even) td{ background:#f8fbff; }
        .ga-total-row td{
            background:#eaf2fb !important; font-weight:700; color:#0f172a; border:1px solid #c5d3e2 !important;
        }
        .metric-blue{ background:#edf4fb !important; font-weight:600; }
        .ga-empty{ padding:28px 10px !important; color:#94a3b8; font-size:13px; }
        .ga-small-note{ color:#64748b; font-size:11px; padding:0 16px 16px 16px; }

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

        .loading-overlay{
            position:fixed;
            inset:0;
            background:rgba(15, 23, 42, 0.55);
            backdrop-filter:blur(3px);
            -webkit-backdrop-filter:blur(3px);
            display:none;
            align-items:center;
            justify-content:center;
            z-index:99999;
        }

        .loading-modal{
            text-align:center;
            animation:fadeInUp .25s ease;
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
            background:rgba(255,255,255,.02);
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
            box-shadow:0 0 10px rgba(255,255,255,.35);
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

        .page-wrap{
            max-width:1450px;
            margin:34px auto;
            padding:0 18px 32px;
        }

        .loading-text{
            color:#ffffff;
            font-size:16px;
            font-weight:700;
            letter-spacing:.2px;
            text-shadow:0 2px 10px rgba(0,0,0,.18);
        }

        @keyframes needleSpin{
            0%   { transform: translate(-50%, -85%) rotate(-35deg); }
            50%  { transform: translate(-50%, -85%) rotate(45deg); }
            100% { transform: translate(-50%, -85%) rotate(-35deg); }
        }

        @keyframes ringPulse{
            0%,100%{ transform: scale(1); opacity: 1; }
            50%{ transform: scale(1.03); opacity: .95; }
        }

        @keyframes fadeInUp{
            from{
                opacity:0;
                transform:translateY(8px);
            }
            to{
                opacity:1;
                transform:translateY(0);
            }
        }

        @media (max-width: 768px){
            .ga-page{
                padding:14px;
                border-radius:18px;
            }

            .ga-title{
                font-size:16px;
            }

            .table-responsive{
                padding:0 8px 10px 8px;
            }

            .ga-kpi-value{
                font-size:22px;
            }

            .ga-filter-actions{
                align-items:stretch;
            }

            .ga-filter-actions-text{
                width:100%;
            }

            .ga-filter-actions .ga-btn-export{
                width:100%;
            }

            .loading-ring{
                width:90px;
                height:90px;
            }

            .loading-text{
                font-size:14px;
            }
        }
    </style>
</head>
<body class="app-bg">

@include('layouts.topbar')

@php
    $chartRows = collect(method_exists($rows, 'items') ? $rows->items() : $rows);

    $districtLabels = $chartRows->pluck('district_name_thai')->map(fn($v) => (string) $v)->values();
    $rateTotalData  = $chartRows->pluck('percentage_total')->map(fn($v) => round((float)$v, 2))->values();

    $age1Data = $chartRows->pluck('percentage_total1')->map(fn($v) => round((float)$v, 2))->values();
    $age2Data = $chartRows->pluck('percentage_total2')->map(fn($v) => round((float)$v, 2))->values();
    $age3Data = $chartRows->pluck('percentage_total3')->map(fn($v) => round((float)$v, 2))->values();
    $age4Data = $chartRows->pluck('percentage_total4')->map(fn($v) => round((float)$v, 2))->values();
    $age5Data = $chartRows->pluck('percentage_total5')->map(fn($v) => round((float)$v, 2))->values();

    $sumPopulation1 = $chartRows->sum(fn($r) => (float) ($r->population_total1 ?? 0));
    $sumPatient1    = $chartRows->sum(fn($r) => (float) ($r->patient_cc_total1 ?? 0));
    $sumRate1       = $sumPopulation1 > 0 ? ($sumPatient1 / $sumPopulation1) * 100 : 0;

    $sumPopulation2 = $chartRows->sum(fn($r) => (float) ($r->population_total2 ?? 0));
    $sumPatient2    = $chartRows->sum(fn($r) => (float) ($r->patient_cc_total2 ?? 0));
    $sumRate2       = $sumPopulation2 > 0 ? ($sumPatient2 / $sumPopulation2) * 100 : 0;

    $sumPopulation3 = $chartRows->sum(fn($r) => (float) ($r->population_total3 ?? 0));
    $sumPatient3    = $chartRows->sum(fn($r) => (float) ($r->patient_cc_total3 ?? 0));
    $sumRate3       = $sumPopulation3 > 0 ? ($sumPatient3 / $sumPopulation3) * 100 : 0;

    $sumPopulation4 = $chartRows->sum(fn($r) => (float) ($r->population_total4 ?? 0));
    $sumPatient4    = $chartRows->sum(fn($r) => (float) ($r->patient_cc_total4 ?? 0));
    $sumRate4       = $sumPopulation4 > 0 ? ($sumPatient4 / $sumPopulation4) * 100 : 0;

    $sumPopulation5 = $chartRows->sum(fn($r) => (float) ($r->population_total5 ?? 0));
    $sumPatient5    = $chartRows->sum(fn($r) => (float) ($r->patient_cc_total5 ?? 0));
    $sumRate5       = $sumPopulation5 > 0 ? ($sumPatient5 / $sumPopulation5) * 100 : 0;
@endphp

<div class="page-wrap">
    <div class="ga-page shadow-soft">

        <div class="ga-topbar">
            <div class="ga-title">
                <i class="bi bi-gender-female"></i>
                <span>อัตราป่วยโรคมะเร็งปากมดลูก</span>
            </div>
            <div class="ga-subtitle">
                แสดงข้อมูลสรุปภาพรวมรายอำเภอ พร้อมกราฟวิเคราะห์และตารางข้อมูลรายกลุ่มอายุ
            </div>
        </div>

        <div class="ga-filter-card">
            <form method="GET" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="ga-filter-label">ปี</label>
                        <select name="year" class="form-select ga-filter">
                            @foreach($yearList as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>ปี {{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="ga-filter-label">อำเภอ</label>
                        <select name="district" class="form-select ga-filter">
                            <option value="">ทุกอำเภอ</option>
                            @foreach($districtList as $d)
                                <option value="{{ $d }}" {{ $district == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn ga-btn w-100">
                            <i class="bi bi-search me-1"></i> ค้นหา
                        </button>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ url()->current() }}" class="btn ga-btn-light w-100">
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

                    <a href="{{ route('health.cc-incidence-all.export', request()->query()) }}" class="btn ga-btn-export">
                        <i class="bi bi-download"></i> Export Excel
                    </a>
                </div>
            </form>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="ga-kpi">
                    <div class="ga-kpi-label">ประชากรรวม</div>
                    <h3 class="ga-kpi-value">{{ number_format($summary->population_total_sum ?? 0) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ga-kpi">
                    <div class="ga-kpi-label">ผู้ป่วยรวม</div>
                    <h3 class="ga-kpi-value">{{ number_format($summary->patient_cc_total_sum ?? 0) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ga-kpi">
                    <div class="ga-kpi-label">ร้อยละเฉลี่ยรวม</div>
                    <h3 class="ga-kpi-value">{{ number_format($overallRate ?? 0, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="ga-note">
            <i class="bi bi-info-circle me-1"></i>
            กราฟและตารางด้านล่างจะแสดงเฉพาะข้อมูลที่กำลังถูกกรองอยู่ในหน้าปัจจุบัน
        </div>

        <div class="row g-3">
            <div class="col-lg-6">
                <div class="ga-panel">
                    <div class="ga-panel-title">แผนภูมิร้อยละรวมรายอำเภอ</div>
                    <div class="ga-panel-body">
                        <div class="ga-chart-wrap">
                            <canvas id="districtRateChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="ga-panel">
                    <div class="ga-panel-title">แผนภูมิร้อยละตามช่วงอายุ</div>
                    <div class="ga-panel-body">
                        <div class="ga-chart-wrap">
                            <canvas id="ageRateChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ga-table-panel">
            <div class="ga-table-head">
                <div>
                    <div class="ga-table-head-title">ตารางสรุปข้อมูลรายอำเภอ</div>
                    <div class="ga-table-head-sub">แสดงจำนวนประชากร จำนวนผู้ป่วย และอัตราร้อยละรายกลุ่มอายุ</div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table ga-table">
                    <thead>
                        <tr>
                            <th rowspan="2">อำเภอ</th>
                            <th colspan="3">ข้อมูลสรุป</th>
                            <th colspan="3">ต่ำกว่า 15 ปี</th>
                            <th colspan="3">15-39 ปี</th>
                            <th colspan="3">40-49 ปี</th>
                            <th colspan="3">50-59 ปี</th>
                            <th colspan="3">60 ปีขึ้นไป</th>
                        </tr>
                        <tr>
                            <th>B</th><th>A</th><th>ร้อยละ</th>
                            <th>B</th><th>A</th><th>ร้อยละ</th>
                            <th>B</th><th>A</th><th>ร้อยละ</th>
                            <th>B</th><th>A</th><th>ร้อยละ</th>
                            <th>B</th><th>A</th><th>ร้อยละ</th>
                            <th>B</th><th>A</th><th>ร้อยละ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $row)
                            <tr>
                                <td>{{ $row->district_name_thai }}</td>

                                <td class="text-end metric-blue">{{ number_format($row->population_total) }}</td>
                                <td class="text-end metric-blue">{{ number_format($row->patient_cc_total) }}</td>
                                <td class="text-end metric-blue">{{ number_format($row->percentage_total, 2) }}</td>

                                <td class="text-end">{{ number_format($row->population_total1) }}</td>
                                <td class="text-end">{{ number_format($row->patient_cc_total1) }}</td>
                                <td class="text-end">{{ number_format($row->percentage_total1, 2) }}</td>

                                <td class="text-end">{{ number_format($row->population_total2) }}</td>
                                <td class="text-end">{{ number_format($row->patient_cc_total2) }}</td>
                                <td class="text-end">{{ number_format($row->percentage_total2, 2) }}</td>

                                <td class="text-end">{{ number_format($row->population_total3) }}</td>
                                <td class="text-end">{{ number_format($row->patient_cc_total3) }}</td>
                                <td class="text-end">{{ number_format($row->percentage_total3, 2) }}</td>

                                <td class="text-end">{{ number_format($row->population_total4) }}</td>
                                <td class="text-end">{{ number_format($row->patient_cc_total4) }}</td>
                                <td class="text-end">{{ number_format($row->percentage_total4, 2) }}</td>

                                <td class="text-end">{{ number_format($row->population_total5) }}</td>
                                <td class="text-end">{{ number_format($row->patient_cc_total5) }}</td>
                                <td class="text-end">{{ number_format($row->percentage_total5, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="19" class="text-center ga-empty">ไม่พบข้อมูล</td>
                            </tr>
                        @endforelse

                        <tr class="ga-total-row">
                            <td>รวม</td>

                            <td class="text-end">{{ number_format($summary->population_total_sum ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary->patient_cc_total_sum ?? 0) }}</td>
                            <td class="text-end">{{ number_format($overallRate ?? 0, 2) }}</td>

                            <td class="text-end">{{ number_format($sumPopulation1) }}</td>
                            <td class="text-end">{{ number_format($sumPatient1) }}</td>
                            <td class="text-end">{{ number_format($sumRate1, 2) }}</td>

                            <td class="text-end">{{ number_format($sumPopulation2) }}</td>
                            <td class="text-end">{{ number_format($sumPatient2) }}</td>
                            <td class="text-end">{{ number_format($sumRate2, 2) }}</td>

                            <td class="text-end">{{ number_format($sumPopulation3) }}</td>
                            <td class="text-end">{{ number_format($sumPatient3) }}</td>
                            <td class="text-end">{{ number_format($sumRate3, 2) }}</td>

                            <td class="text-end">{{ number_format($sumPopulation4) }}</td>
                            <td class="text-end">{{ number_format($sumPatient4) }}</td>
                            <td class="text-end">{{ number_format($sumRate4, 2) }}</td>

                            <td class="text-end">{{ number_format($sumPopulation5) }}</td>
                            <td class="text-end">{{ number_format($sumPatient5) }}</td>
                            <td class="text-end">{{ number_format($sumRate5, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="ga-small-note text-end">
                แสดงข้อมูลสรุปรายอำเภอ
            </div>
        </div>

        <div class="ga-legend-box">
            <div class="ga-legend-title">คำอธิบายตัวชี้วัด</div>
            <div class="ga-legend-item">
                <strong>A</strong> หมายถึง จำนวนผู้ป่วยโรคมะเร็งปากมดลูกทั้งหมด
            </div>
            <div class="ga-legend-item mb-0">
                <strong>B</strong> หมายถึง จำนวนประชากร ตามกลุ่มอายุ
            </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const districtLabels = @json($districtLabels);
    const rateTotalData  = @json($rateTotalData);

    const age1Data = @json($age1Data);
    const age2Data = @json($age2Data);
    const age3Data = @json($age3Data);
    const age4Data = @json($age4Data);
    const age5Data = @json($age5Data);

    const districtRateChart = document.getElementById('districtRateChart');
    if (districtRateChart) {
        new Chart(districtRateChart, {
            type: 'bar',
            data: {
                labels: districtLabels,
                datasets: [{
                    label: 'ร้อยละรวม',
                    data: rateTotalData,
                    backgroundColor: '#2d74da',
                    borderColor: '#2d74da',
                    borderWidth: 1,
                    borderRadius: 8,
                    maxBarThickness: 42
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'ร้อยละ' }
                    }
                }
            }
        });
    }

    const ageRateChart = document.getElementById('ageRateChart');
    if (ageRateChart) {
        new Chart(ageRateChart, {
            type: 'line',
            data: {
                labels: districtLabels,
                datasets: [
                    { label: 'ต่ำกว่า 15 ปี', data: age1Data, borderColor: '#14b8a6', backgroundColor: '#14b8a6', tension: 0.35, fill: false },
                    { label: '15-39 ปี', data: age2Data, borderColor: '#3b82f6', backgroundColor: '#3b82f6', tension: 0.35, fill: false },
                    { label: '40-49 ปี', data: age3Data, borderColor: '#8b5cf6', backgroundColor: '#8b5cf6', tension: 0.35, fill: false },
                    { label: '50-59 ปี', data: age4Data, borderColor: '#f97316', backgroundColor: '#f97316', tension: 0.35, fill: false },
                    { label: '60 ปีขึ้นไป', data: age5Data, borderColor: '#ef4444', backgroundColor: '#ef4444', tension: 0.35, fill: false }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top' } },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'ร้อยละ' }
                    }
                }
            }
        });
    }

    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.addEventListener('submit', function (e) {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) {
                overlay.style.display = 'flex';
                e.preventDefault();
                setTimeout(() => filterForm.submit(), 700);
            }
        });
    }
</script>
</body>
</html>