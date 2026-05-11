<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard ข้อมูลทรัพยากรป่าไม้</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
:root{
    --primary:#0f766e;
    --primary-2:#0ea5a4;
    --secondary:#2563eb;
    --accent:#f97316;
    --green:#16a34a;
    --ink:#0f172a;
    --muted:#64748b;
    --line:#d9e7ef;
}

*{ box-sizing:border-box; }

body{
    font-family:'Prompt',system-ui,sans-serif;
    margin:0;
    color:var(--ink);
    background:
        radial-gradient(circle at 0% 0%, rgba(14,165,164,.16), transparent 22%),
        radial-gradient(circle at 100% 0%, rgba(37,99,235,.12), transparent 24%),
        radial-gradient(circle at 50% 100%, rgba(22,163,74,.08), transparent 20%),
        linear-gradient(135deg,#dbf4f4 0%, #eef8f6 45%, #f7fbff 100%);
    min-height:100vh;
}

.page-shell{
    max-width:1480px;
    margin:28px auto;
    padding:0 18px 34px;
}

.dashboard-frame{
    background:rgba(255,255,255,.74);
    border:1px solid rgba(255,255,255,.65);
    border-radius:30px;
    padding:22px;
    box-shadow:0 20px 50px rgba(15,23,42,.08);
    backdrop-filter:blur(10px);
}

.hero-card,
.filter-card,
.kpi-card,
.panel-card,
.source-card{
    background:linear-gradient(180deg,rgba(255,255,255,.96) 0%, rgba(249,252,255,.98) 100%);
    border:1px solid #deebf2;
    box-shadow:0 12px 28px rgba(15,23,42,.05);
}

.hero-card{
    border-radius:28px;
    overflow:hidden;
    position:relative;
    margin-bottom:18px;
    background:
        radial-gradient(circle at 10% 20%, rgba(255,255,255,.18), transparent 25%),
        radial-gradient(circle at 90% 10%, rgba(255,255,255,.10), transparent 24%),
        linear-gradient(135deg,#0f766e 0%, #0ea5a4 45%, #2563eb 100%);
    color:#fff;
}

.hero-inner{
    padding:24px;
    position:relative;
    z-index:1;
}

.hero-badge{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    background:rgba(255,255,255,.14);
    border:1px solid rgba(255,255,255,.18);
    margin-bottom:12px;
}

.hero-title{
    font-size:clamp(1.5rem,3vw,2.4rem);
    font-weight:700;
    line-height:1.2;
    margin-bottom:8px;
}

.hero-subtitle{
    font-size:14px;
    line-height:1.7;
    opacity:.95;
    max-width:760px;
}

.hero-meta{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:12px;
}

.hero-meta-box{
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.16);
    border-radius:18px;
    padding:14px 16px;
    min-height:84px;
}

.hero-meta-label{
    font-size:12px;
    opacity:.88;
    margin-bottom:4px;
}

.hero-meta-value{
    font-size:1.15rem;
    font-weight:700;
}

.filter-card{
    border-radius:24px;
    padding:18px;
    margin-bottom:18px;
}

.filter-label{
    display:block;
    font-size:12px;
    font-weight:600;
    color:var(--muted);
    margin-bottom:6px;
}

.filter-control{
    min-height:48px;
    border-radius:16px;
    border:1px solid #d7e5ed;
    background:#fff;
    font-size:13px;
    color:#1f2937;
    box-shadow:none !important;
}

.filter-control:focus{
    border-color:#7dd3fc;
    box-shadow:0 0 0 .16rem rgba(14,165,164,.12) !important;
}

.filter-footer{
    margin-top:16px;
    padding-top:16px;
    border-top:1px dashed #d8e5ec;
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    gap:14px;
    flex-wrap:wrap;
}

.filter-info{
    display:flex;
    align-items:center;
    gap:12px;
    flex:1;
    min-width:320px;
}

.filter-info-icon{
    width:40px;
    height:40px;
    border-radius:14px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    color:#0f766e;
    background:linear-gradient(135deg,#d9fbf6 0%, #e0f2fe 100%);
    border:1px solid #b9ece7;
    font-size:18px;
}

.filter-info-title{
    font-size:13px;
    font-weight:700;
    color:var(--ink);
    margin-bottom:2px;
}

.filter-info-sub{
    font-size:12px;
    color:var(--muted);
}

.filter-action{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:12px;
    align-self:flex-end;
    flex-wrap:wrap;
}

.btn-main,
.btn-soft{
    min-height:48px;
    border-radius:16px;
    padding:0 22px;
    font-size:13px;
    font-weight:700;
    text-decoration:none !important;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    line-height:1;
    white-space:nowrap;
}

.btn-main{
    border:none;
    color:#fff;
    background:linear-gradient(135deg,#0ea5a4 0%, #2563eb 100%);
    box-shadow:0 10px 22px rgba(37,99,235,.18);
}

.btn-soft{
    border:1px solid #d8e6ed;
    background:#fff;
    color:#334155;
}

.btn-main:hover{
    color:#fff;
    transform:translateY(-1px);
}

.btn-soft:hover{
    color:#0f172a;
    background:#f8fafc;
}

.export-btn{
    border:1px solid #cfe7d4 !important;
    background:linear-gradient(135deg,#f6fff8 0%, #ecfff1 100%) !important;
    color:#15803d !important;
    box-shadow:0 8px 18px rgba(21,128,61,.10);
}

.export-btn:hover{
    background:linear-gradient(135deg,#eaffef 0%, #ddfce7 100%) !important;
    color:#166534 !important;
    border-color:#9fddb0 !important;
    transform:translateY(-1px);
}

.kpi-row{
    flex-wrap:nowrap;
    overflow:auto;
    padding-bottom:4px;
}

.kpi-col{
    min-width:220px;
}

.kpi-card{
    border-radius:24px;
    padding:18px;
    min-height:126px;
    position:relative;
    overflow:hidden;
    height:100%;
}

.kpi-icon{
    width:42px;
    height:42px;
    border-radius:14px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
    margin-bottom:10px;
    background:linear-gradient(135deg,#d9fbf6 0%, #dbeafe 100%);
    color:#0f766e;
    border:1px solid #cce8f0;
}

.kpi-label{
    font-size:12px;
    color:var(--muted);
    margin-bottom:6px;
}

.kpi-value{
    font-size:28px;
    line-height:1.15;
    font-weight:700;
    color:var(--ink);
    margin:0;
}

.kpi-sub{
    margin-top:6px;
    font-size:12px;
    color:var(--primary-2);
    font-weight:600;
}

.panel-card{
    border-radius:24px;
    height:100%;
    overflow:hidden;
}

.panel-head{
    padding:18px 18px 0 18px;
}

.panel-title{
    font-size:15px;
    font-weight:700;
    color:var(--ink);
    margin-bottom:4px;
}

.panel-sub{
    font-size:12px;
    color:var(--muted);
}

.panel-body{
    padding:14px 18px 18px 18px;
}

.chart-box{
    position:relative;
    height:290px;
}

.rank-item{
    padding:13px 14px;
    border-radius:16px;
    background:#f8fbfd;
    border:1px solid #e5edf4;
    margin-bottom:10px;
}

.progress-custom{
    height:12px;
    border-radius:30px;
    background:#e2e8f0;
}

.progress-custom .progress-bar{
    background:linear-gradient(90deg,#0f766e,#0ea5a4);
}

.ga-table{
    width:100%;
    margin-bottom:0;
    border-collapse:collapse;
    font-size:12px;
}

.ga-table thead th{
    background:#d9e7f5 !important;
    color:#1e293b !important;
    border:1px solid #bfd0de !important;
    text-align:center;
    vertical-align:middle;
    white-space:nowrap;
    padding:10px 8px;
    font-weight:700;
}

.ga-table tbody td{
    border:1px solid #d7e2eb;
    padding:9px 8px;
    background:#fff;
    vertical-align:middle;
}

.ga-table tbody tr:nth-child(even) td{
    background:#f8fbff;
}

.ga-table tbody tr:hover td{
    background:#f2fbfb;
}

.empty-state{
    padding:30px 10px !important;
    text-align:center;
    color:#94a3b8;
    font-size:13px;
}

.source-card{
    border-radius:20px;
    padding:16px;
    margin-top:18px;
}

.source-icon{
    width:42px;
    height:42px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#ecfdf5 0%, #d9fbf6 100%);
    color:#0f766e;
    font-size:18px;
    flex-shrink:0;
}

.loading-overlay{
    position:fixed;
    inset:0;
    background:rgba(15,23,42,.55);
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

.loading-text{
    color:#ffffff;
    font-size:16px;
    font-weight:700;
    letter-spacing:.2px;
    text-shadow:0 2px 10px rgba(0,0,0,.18);
}

@keyframes needleSpin{
    0%{ transform:translate(-50%, -85%) rotate(-35deg); }
    50%{ transform:translate(-50%, -85%) rotate(45deg); }
    100%{ transform:translate(-50%, -85%) rotate(-35deg); }
}

@keyframes ringPulse{
    0%,100%{ transform:scale(1); opacity:1; }
    50%{ transform:scale(1.03); opacity:.95; }
}

@keyframes fadeInUp{
    from{ opacity:0; transform:translateY(8px); }
    to{ opacity:1; transform:translateY(0); }
}

@media (max-width: 768px){
    .page-shell{
        margin:18px auto;
        padding:0 12px 24px;
    }

    .dashboard-frame{
        padding:14px;
        border-radius:22px;
    }

    .hero-inner{
        padding:18px;
    }

    .hero-meta{
        grid-template-columns:1fr;
    }

    .chart-box{
        height:240px;
    }

    .filter-footer{
        flex-direction:column;
        align-items:stretch;
    }

    .filter-info{
        min-width:100%;
    }

    .filter-action{
        width:100%;
        justify-content:stretch;
    }

    .filter-action .btn{
        flex:1;
    }
}
</style>
</head>
<body>

@include('layouts.topbar')

<div class="page-shell">
    <div class="dashboard-frame">

        <div class="hero-card">
            <div class="hero-inner">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-8">
                        <div class="hero-badge">
                            <i class="bi bi-tree-fill"></i>
                            Phatthalung People Map
                        </div>
                        <div class="hero-title">Dashboard : ข้อมูลทรัพยากรป่าไม้</div>
                        <div class="hero-subtitle">
                            ติดตามข้อมูลจำนวนป่าไม้และพื้นที่ป่าไม้ของจังหวัดพัทลุง ปี 2553-2560 เพื่อสนับสนุนการวิเคราะห์ทรัพยากรธรรมชาติและการตัดสินใจเชิงพื้นที่ 
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="hero-meta">
                            <div class="hero-meta-box">
                                <div class="hero-meta-label">จำนวนป่ารวม</div>
                                <div class="hero-meta-value">{{ number_format($totalForestCount ?? 0) }}</div>
                            </div>
                            <div class="hero-meta-box">
                                <div class="hero-meta-label">พื้นที่รวม</div>
                                <div class="hero-meta-value">{{ number_format($totalForestArea ?? 0, 2) }}</div>
                            </div>
                            <div class="hero-meta-box">
                                <div class="hero-meta-label">รายการข้อมูล</div>
                                <div class="hero-meta-value">{{ number_format($totalForestTypes ?? 0) }}</div>
                            </div>
                            <div class="hero-meta-box">
                                <div class="hero-meta-label">หน่วยพื้นที่</div>
                                <div class="hero-meta-value">ไร่</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success rounded-4 shadow-sm">
                <i class="bi bi-check-circle-fill me-1"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger rounded-4 shadow-sm">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <div class="filter-card">
            <form method="GET" id="filterForm" action="{{ route('forest.resources.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-8 col-lg-6">
                        <label class="filter-label">ค้นหาชื่อป่า</label>
                        <input type="text"
                               name="keyword"
                               value="{{ $keyword ?? '' }}"
                               class="form-control filter-control"
                               placeholder="ค้นหาชื่อป่า เช่น ป่าสงวน ป่าชุมชน เขตรักษาพันธุ์">
                    </div>
                </div>

                <div class="filter-footer">
                    <div class="filter-info">
                        <div class="filter-info-icon">
                            <i class="bi bi-funnel-fill"></i>
                        </div>
                        <div>
                            <div class="filter-info-title">
                                กรองข้อมูลตามชื่อป่า และนำเข้าไฟล์ Excel ได้จากหน้านี้
                            </div>
                            <div class="filter-info-sub">
                                ระบบจะคำนวณ KPI กราฟ และตารางจากข้อมูลทรัพยากรป่าไม้อัตโนมัติ
                            </div>
                        </div>
                    </div>

                    <div class="filter-action">
                        <button type="submit" class="btn btn-main">
                            <i class="bi bi-search me-1"></i>
                            <span>ค้นหาข้อมูล</span>
                        </button>

                        <button type="button" class="btn btn-soft export-btn" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                            <span>Import Excel</span>
                        </button>
<a href="{{ route('forest.resources.manage') }}" class="btn btn-soft">
    <i class="bi bi-pencil-square me-1"></i>
    <span>จัดการข้อมูล</span>
</a>
                        <a href="{{ route('forest.resources.index') }}" class="btn btn-soft">
                            <i class="bi bi-arrow-clockwise me-1"></i>
                            <span>ล้างข้อมูล</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="row g-3 mb-3 kpi-row">
            <div class="col kpi-col">
                <div class="kpi-card">
                    <div class="kpi-icon"><i class="bi bi-tree-fill"></i></div>
                    <div class="kpi-label">จำนวนป่ารวม</div>
                    <h3 class="kpi-value">{{ number_format($totalForestCount ?? 0) }}</h3>
                    <div class="kpi-sub">รวมทุกข้อมูลที่นำเข้า</div>
                </div>
            </div>

            <div class="col kpi-col">
                <div class="kpi-card">
                    <div class="kpi-icon"><i class="bi bi-map-fill"></i></div>
                    <div class="kpi-label">พื้นที่ป่าไม้รวม</div>
                    <h3 class="kpi-value">{{ number_format($totalForestArea ?? 0, 2) }}</h3>
                    <div class="kpi-sub">หน่วย: ไร่</div>
                </div>
            </div>

            <div class="col kpi-col">
                <div class="kpi-card">
                    <div class="kpi-icon"><i class="bi bi-list-check"></i></div>
                    <div class="kpi-label">จำนวนรายการข้อมูล</div>
                    <h3 class="kpi-value">{{ number_format($totalForestTypes ?? 0) }}</h3>
                    <div class="kpi-sub">รายการจากตาราง</div>
                </div>
            </div>

            <div class="col kpi-col">
                <div class="kpi-card">
                    <div class="kpi-icon"><i class="bi bi-calculator-fill"></i></div>
                    <div class="kpi-label">พื้นที่เฉลี่ยต่อรายการ</div>
                    <h3 class="kpi-value">{{ number_format($avgForestArea ?? 0, 2) }}</h3>
                    <div class="kpi-sub">ไร่/รายการ</div>
                </div>
            </div>

            <div class="col kpi-col">
                <div class="kpi-card">
                    <div class="kpi-icon"><i class="bi bi-clock-history"></i></div>
                    <div class="kpi-label">อัปเดตล่าสุด</div>
                    <h3 class="kpi-value" style="font-size:20px;">
                        {{ now()->format('d/m/Y') }}
                    </h3>
                    <div class="kpi-sub">{{ now()->format('H:i') }} น.</div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="panel-card">
                    <div class="panel-head">
                        <div class="panel-title">จำนวนป่าไม้แยกตามชื่อป่า</div>
                        <div class="panel-sub">เปรียบเทียบจำนวนป่าแต่ละรายการจากข้อมูลที่นำเข้า</div>
                    </div>
                    <div class="panel-body">
                        <div class="chart-box">
                            <canvas id="forestCountChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="panel-card">
                    <div class="panel-head">
                        <div class="panel-title">สัดส่วนพื้นที่ป่าไม้</div>
                        <div class="panel-sub">แสดงสัดส่วนพื้นที่ตามชื่อป่า</div>
                    </div>
                    <div class="panel-body">
                        <div class="chart-box">
                            <canvas id="forestAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-lg-7">
                <div class="panel-card">
                    <div class="panel-head">
                        <div class="panel-title">พื้นที่ป่าไม้แยกตามชื่อป่า</div>
                        <div class="panel-sub">แนวโน้มพื้นที่เรียงตามรายการข้อมูล</div>
                    </div>
                    <div class="panel-body">
                        <div class="chart-box">
                            <canvas id="forestAreaBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="panel-card">
                    <div class="panel-head">
                        <div class="panel-title">อันดับพื้นที่ป่าไม้สูงสุด</div>
                        <div class="panel-sub">เรียงจากพื้นที่มากไปน้อย</div>
                    </div>
                    <div class="panel-body">
                        @forelse(($topForests ?? collect()) as $item)
                            @php
                                $percent = ($totalForestArea ?? 0) > 0 ? ($item->forest_area / $totalForestArea) * 100 : 0;
                            @endphp
                            <div class="rank-item">
                                <div class="d-flex justify-content-between mb-2 gap-2">
                                    <div class="fw-bold text-truncate">{{ $item->forest_name }}</div>
                                    <strong>{{ number_format($percent, 2) }}%</strong>
                                </div>
                                <div class="progress progress-custom mb-1">
                                    <div class="progress-bar" style="width:{{ $percent }}%"></div>
                                </div>
                                <small class="text-muted">
                                    พื้นที่ {{ number_format($item->forest_area, 2) }} ไร่ / จำนวน {{ number_format($item->forest_count) }} แห่ง
                                </small>
                            </div>
                        @empty
                            <div class="empty-state">ยังไม่มีข้อมูลอันดับพื้นที่ป่าไม้</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

      

        <div class="source-card py-3 px-4">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="source-icon">
                    <i class="bi bi-database-fill-check"></i>
                </div>
                <div class="flex-grow-1">
                    <div style="font-size:13px; font-weight:700; color:#0f172a;">
                        แหล่งที่มา : สำนักงานจังหวัดพัทลุง
                    </div>
                  <div style="font-size:12px; color:#64748b; margin-top:4px;">
    อัปเดตข้อมูลล่าสุด :
    {{
        optional(
            \App\Models\ForestResource::orderByDesc('updated_at')->first()
        )->updated_at
            ? \App\Models\ForestResource::orderByDesc('updated_at')->first()->updated_at->format('d/m/Y H:i')
            : '-'
    }}
    น.
</div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="importExcelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:24px; border:0; overflow:hidden;">
            <div class="modal-header" style="background:linear-gradient(135deg,#0f766e,#2563eb); color:#fff;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-cloud-arrow-up-fill me-2"></i>
                    นำเข้าข้อมูลทรัพยากรป่าไม้จาก Excel
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('forest.resources.import') }}" enctype="multipart/form-data" id="importForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3 p-3 rounded-4" style="background:#fef9c3;border:1px solid #fde68a;font-size:13px;line-height:1.8;">
                        <strong>⚠️ ข้อกำหนดสำคัญ</strong><br>
                        • หัวตารางต้องตรงตามไฟล์ต้นฉบับ<br>
                        • ต้องมี 3 คอลัมน์หลัก<br>
                        • ระบบจะล้างข้อมูลเดิมและนำเข้าข้อมูลใหม่
                    </div>

                    <div class="mb-3 p-3 rounded-4" style="background:#f0fdf4;border:1px solid #bbf7d0;font-size:13px;">
                        <strong>📋 หัวตารางที่ถูกต้อง</strong><br>
                        <div class="mt-2" style="font-family:monospace;">
                            ชื่อป่า | จำนวนป่า | พื้นที่ป่าไม้
                        </div>
                    </div>

                    <div class="mb-3 p-3 rounded-4" style="background:#f8fafc;border:1px solid #e2e8f0;font-size:13px;">
                        <strong>📊 ตัวอย่างข้อมูล</strong><br>
                        <div class="mt-2" style="font-family:monospace;">
                            ป่าสงวนแห่งชาติ | 12 | 2450.50
                        </div>
                    </div>

                    <div class="mb-3 text-muted" style="font-size:12px;line-height:1.8;">
                        ✔ จำนวนป่าและพื้นที่ป่าไม้ต้องเป็นตัวเลข<br>
                        ✔ รองรับไฟล์ .xlsx, .xls, .csv
                    </div>

                    <label class="form-label fw-semibold">เลือกไฟล์ Excel</label>
                    <input type="file"
                           name="excel_file"
                           class="form-control filter-control"
                           accept=".xlsx,.xls,.csv"
                           required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        ยกเลิก
                    </button>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-upload me-1"></i>
                        นำเข้า Excel
                    </button>
                </div>
            </form>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const labels = @json($chartLabels ?? []);
const counts = @json($chartCounts ?? []);
const areas  = @json($chartAreas ?? []);

const chartColors = [
    '#0f766e', '#0ea5a4', '#2563eb', '#16a34a',
    '#f97316', '#ef4444', '#6366f1', '#64748b',
    '#84cc16', '#06b6d4', '#a855f7', '#fb7185'
];

const countChart = document.getElementById('forestCountChart');
if (countChart) {
    new Chart(countChart, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'จำนวนป่า',
                data: counts,
                backgroundColor: '#2563eb',
                borderColor: '#2563eb',
                borderWidth: 1,
                borderRadius: 10,
                maxBarThickness: 36
            }]
        },
        options: {
            indexAxis: 'y',
            responsive:true,
            maintainAspectRatio:false,
            plugins:{
                legend:{display:false},
                tooltip:{
                    callbacks:{
                        label:function(context){
                            return 'จำนวนป่า: ' + Number(context.raw).toLocaleString() + ' แห่ง';
                        }
                    }
                }
            },
            scales:{
                x:{ beginAtZero:true, grid:{ color:'rgba(148,163,184,.18)' } },
                y:{ grid:{ display:false } }
            }
        }
    });
}

const areaChart = document.getElementById('forestAreaChart');
if (areaChart) {
    new Chart(areaChart, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: areas,
                backgroundColor: chartColors,
                borderColor:'#fff',
                borderWidth:2
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{
                legend:{position:'bottom'},
                tooltip:{
                    callbacks:{
                        label:function(context){
                            return context.label + ': ' + Number(context.raw).toLocaleString() + ' ไร่';
                        }
                    }
                }
            }
        }
    });
}

const areaBarChart = document.getElementById('forestAreaBarChart');
if (areaBarChart) {
    new Chart(areaBarChart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label:'พื้นที่ป่าไม้',
                data: areas,
                borderColor:'#0ea5a4',
                backgroundColor:'rgba(14,165,164,.14)',
                fill:true,
                tension:.35,
                borderWidth:4,
                pointRadius:4,
                pointBackgroundColor:'#0ea5a4',
                pointBorderColor:'#ffffff',
                pointBorderWidth:2
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{
                legend:{display:false},
                tooltip:{
                    callbacks:{
                        label:function(context){
                            return 'พื้นที่: ' + Number(context.raw).toLocaleString() + ' ไร่';
                        }
                    }
                }
            },
            scales:{
                x:{ grid:{ display:false }, ticks:{maxRotation:45,minRotation:0} },
                y:{ beginAtZero:true, grid:{ color:'rgba(148,163,184,.18)' } }
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
            setTimeout(() => filterForm.submit(), 500);
        }
    });
}

const importForm = document.getElementById('importForm');
if (importForm) {
    importForm.addEventListener('submit', function () {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) overlay.style.display = 'flex';
    });
}
</script>

@if(session('success'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'success',
        title: 'สำเร็จ',
        text: '{{ session('success') }}',
        confirmButtonText: 'ตกลง',
        confirmButtonColor: '#16a34a',
        backdrop: 'rgba(15,23,42,0.6)',
        allowOutsideClick: false,
        allowEscapeKey: false
    });
});
</script>
@endif

</body>
</html>

