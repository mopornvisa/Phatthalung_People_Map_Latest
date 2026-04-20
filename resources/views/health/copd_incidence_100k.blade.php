@php
    $summary = $summary ?? [];
@endphp
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อัตราป่วยรายใหม่โรคปอดอุดกั้นเรื้อรัง</title>

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

        .ga-brand{
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:12px;
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

        .ga-subtitle{
            margin-top:8px;
            color:#64748b;
            font-size:13px;
            line-height:1.5;
        }

        .ga-filter-card{
            background:linear-gradient(135deg,#ffffff 0%,#f9fcff 100%);
            border:1px solid #dcecf2;
            border-radius:22px;
            padding:18px;
            margin-bottom:18px;
            box-shadow:0 10px 24px rgba(2, 6, 23, .05);
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
            transform:translateY(-1px);
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

        .ga-btn-light:hover{
            background:#f8fbfd;
            color:#0f172a;
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

        .ga-kpi{
            background:linear-gradient(135deg,#ffffff 0%,#f9fcff 100%);
            border:1px solid #dcecf2;
            padding:18px;
            min-height:110px;
            border-radius:22px;
            box-shadow:0 10px 24px rgba(2, 6, 23, .05);
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
            line-height:1.2;
            position:relative;
            z-index:1;
        }

        .ga-kpi-value{
            color:#0f172a;
            font-size:26px;
            font-weight:700;
            margin:0;
            line-height:1.2;
            position:relative;
            z-index:1;
        }

        .ga-panel{
            background:linear-gradient(135deg,#ffffff 0%,#fafdff 100%);
            border:1px solid #dcecf2;
            margin-bottom:10px;
            border-radius:22px;
            box-shadow:0 10px 24px rgba(2, 6, 23, .05);
            height:100%;
        }

        .ga-panel-title{
            color:#334155;
            font-size:13px;
            padding:16px 16px 0 16px;
            font-weight:700;
        }

        .ga-panel-body{
            padding:12px 16px 18px 16px;
        }

        .ga-chart-wrap{
            position:relative;
            height:245px;
        }

        .ga-table-panel{
            background:linear-gradient(135deg,#ffffff 0%,#fbfdff 100%);
            border:1px solid #dcecf2;
            margin-top:18px;
            border-radius:22px;
            overflow:hidden;
            box-shadow:0 10px 24px rgba(2, 6, 23, .05);
        }

        .ga-table-head{
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:10px;
            padding:16px 18px;
            border-bottom:1px solid #e5edf4;
            background:linear-gradient(135deg,#f8fcff 0%,#f3fbf8 100%);
        }

        .ga-table-head-title{
            font-size:15px;
            font-weight:700;
            color:#0f172a;
        }

        .ga-table-head-sub{
            font-size:12px;
            color:#64748b;
        }

        .table-responsive{
            padding:0 14px 12px 14px;
        }

        .ga-table{
            margin-bottom:0;
            font-size:11px;
            min-width:1300px;
            border-collapse:collapse;
        }

        .ga-table thead th{
            background:#d9e7f5 !important;
            color:#1e293b !important;
            border:1px solid #bfcddd !important;
            text-align:center;
            vertical-align:middle;
            white-space:nowrap;
            padding:8px 6px;
            font-weight:700;
            line-height:1.25;
        }

        .ga-table thead tr:first-child th{
            background:#cfe0f2 !important;
            font-size:11px;
        }

        .ga-table thead tr:nth-child(2) th{
            background:#e5eff9 !important;
            font-size:10px;
        }

        .ga-table tbody td{
            border:1px solid #d5dfeb;
            padding:6px 6px;
            vertical-align:middle;
            background:#fff;
            white-space:nowrap;
        }

        .ga-table tbody td:first-child{
            font-weight:600;
        }

        .ga-table tbody tr:nth-child(even) td{
            background:#f8fbff;
        }

        .ga-table tbody tr:hover td{
            background:#eef5fc;
        }

        .ga-total-row td{
            background:#eaf2fb !important;
            border:1px solid #c5d3e2 !important;
            font-weight:700;
            color:#0f172a;
        }

        .metric-blue{
            background:#edf4fb !important;
            font-weight:600;
        }

        .ga-empty{
            padding:28px 10px !important;
            color:#94a3b8;
            font-size:13px;
        }

        .ga-small-note{
            color:#64748b;
            font-size:11px;
            padding:0 16px 16px 16px;
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

<div class="page-wrap">
    <div class="ga-page shadow-soft">

        <div class="ga-topbar">
            <div class="ga-brand">
                <div>
                    <div class="ga-title">
                        <i class="bi bi-heart-pulse-fill"></i>
                        <span>อัตราป่วยรายใหม่โรคปอดอุดกั้นเรื้อรัง</span>
                    </div>
                    <div class="ga-subtitle">
                        แสดงข้อมูลสรุปรายอำเภอ พร้อมกราฟวิเคราะห์ และข้อมูลรายเดือน
                    </div>
                </div>
            </div>
        </div>

        <div class="ga-filter-card">
            <form method="GET" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="ga-filter-label">ปี</label>
                        <select name="year" class="form-select ga-filter">
                            <option value="">ทุกปี</option>
                            @foreach(($yearList ?? []) as $y)
                                <option value="{{ $y }}" {{ (string)($year ?? '') === (string)$y ? 'selected' : '' }}>
                                    ปี {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
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

                 <a href="{{ route('copd.incidence.100k.export', request()->query()) }}" class="btn ga-btn-export">
                 <i class="bi bi-download"></i> Export Excel
                  </a>
                </div>
            </form>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="ga-kpi">
                    <div class="ga-kpi-label">จำนวนผู้ป่วยรายใหม่ทั้งหมด</div>
                    <h3 class="ga-kpi-value">{{ number_format($summary['case'] ?? 0) }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ga-kpi">
                    <div class="ga-kpi-label">จำนวนประชากร</div>
                    <h3 class="ga-kpi-value">{{ number_format($summary['pop'] ?? 0) }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ga-kpi">
                    <div class="ga-kpi-label">อัตราป่วยต่อแสนประชากร</div>
                    <h3 class="ga-kpi-value">{{ number_format($summary['rate'] ?? 0, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-4">
                <div class="ga-panel">
                    <div class="ga-panel-title">สัดส่วนผู้ป่วยรายอำเภอ</div>
                    <div class="ga-panel-body">
                        <div class="ga-chart-wrap">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="ga-panel">
                    <div class="ga-panel-title">อัตราต่อแสนรายอำเภอ</div>
                    <div class="ga-panel-body">
                        <div class="ga-chart-wrap">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="ga-panel">
                    <div class="ga-panel-title">ผู้ป่วยรายเดือน (รวม)</div>
                    <div class="ga-panel-body">
                        <div class="ga-chart-wrap">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ga-table-panel">
            <div class="ga-table-head">
                <div>
                    <div class="ga-table-head-title">ตารางสรุปข้อมูลรายอำเภอ</div>
                    <div class="ga-table-head-sub">แสดงจำนวนประชากร จำนวนผู้ป่วย อัตราต่อแสน และข้อมูลรายเดือน</div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table ga-table">
                    <thead>
                        <tr>
                            <th rowspan="2">อำเภอ</th>
                            <th colspan="3">ข้อมูลสรุป</th>
                            <th colspan="12">จำนวนผู้ป่วยรายเดือน</th>
                        </tr>
                        <tr>
                            <th>B ประชากร</th>
                            <th>A ผู้ป่วย</th>
                            <th>อัตราต่อแสน</th>
                            <th>ม.ค.</th>
                            <th>ก.พ.</th>
                            <th>มี.ค.</th>
                            <th>เม.ย.</th>
                            <th>พ.ค.</th>
                            <th>มิ.ย.</th>
                            <th>ก.ค.</th>
                            <th>ส.ค.</th>
                            <th>ก.ย.</th>
                            <th>ต.ค.</th>
                            <th>พ.ย.</th>
                            <th>ธ.ค.</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse(($rows ?? []) as $r)
                            @php
                                $patient = (float)($r->patient_copd_total ?? 0);
                                $rate = (float)($r->rate_per_100k ?? 0);
                            @endphp
                            <tr>
                                <td>{{ $r->district_name_thai }}</td>
                                <td class="text-end metric-blue">{{ number_format($r->population_civil_registry ?? 0) }}</td>
                                <td class="text-end metric-blue">{{ number_format($patient) }}</td>
                                <td class="text-end metric-blue">{{ number_format($rate, 2) }}</td>
                                <td class="text-end">{{ number_format($r->month1 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month2 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month3 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month4 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month5 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month6 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month7 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month8 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month9 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month10 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month11 ?? 0) }}</td>
                                <td class="text-end">{{ number_format($r->month12 ?? 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="16" class="text-center ga-empty">ไม่พบข้อมูล</td>
                            </tr>
                        @endforelse

                        <tr class="ga-total-row">
                            <td>รวม</td>
                            <td class="text-end">{{ number_format($summary['pop'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['case'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['rate'] ?? 0, 2) }}</td>
                            <td class="text-end">{{ number_format($summary['month1'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month2'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month3'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month4'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month5'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month6'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month7'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month8'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month9'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month10'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month11'] ?? 0) }}</td>
                            <td class="text-end">{{ number_format($summary['month12'] ?? 0) }}</td>
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
                <strong>A</strong> หมายถึง จำนวนผู้ป่วยโรคปอดอุดกั้นเรื้อรัง รายใหม่ในปี
            </div>
            <div class="ga-legend-item mb-0">
                <strong>B</strong> หมายถึง จำนวนประชากรทะเบียนราษฎร์
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = @json(collect($rows ?? [])->pluck('district_name_thai')->values());
    const cases = @json(collect($rows ?? [])->pluck('patient_copd_total')->map(fn($v) => (float)($v ?? 0))->values());
    const rates = @json(collect($rows ?? [])->pluck('rate_per_100k')->map(fn($v) => (float)($v ?? 0))->values());

    const monthly = [
        {{ (float)($summary['month1'] ?? 0) }},
        {{ (float)($summary['month2'] ?? 0) }},
        {{ (float)($summary['month3'] ?? 0) }},
        {{ (float)($summary['month4'] ?? 0) }},
        {{ (float)($summary['month5'] ?? 0) }},
        {{ (float)($summary['month6'] ?? 0) }},
        {{ (float)($summary['month7'] ?? 0) }},
        {{ (float)($summary['month8'] ?? 0) }},
        {{ (float)($summary['month9'] ?? 0) }},
        {{ (float)($summary['month10'] ?? 0) }},
        {{ (float)($summary['month11'] ?? 0) }},
        {{ (float)($summary['month12'] ?? 0) }},
    ];

    const monthLabels = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];

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
                    label: 'ผู้ป่วยรายเดือน',
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