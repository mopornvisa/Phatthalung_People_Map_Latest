<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard ข้อมูลการตาย</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
/* ===== Select2 Theme ===== */
.select2-container{
    width:100% !important;
}

.select2-container--default .select2-selection--single{
    height:48px;
    border-radius:16px;
    border:1px solid #d7e5ed;
    background:#fff;
    display:flex;
    align-items:center;
    padding:0 12px;
    font-size:13px;
}

.select2-container--default .select2-selection__rendered{
    line-height:46px !important;
    padding-left:0 !important;
    color:#1f2937 !important;
}

.select2-container--default .select2-selection__arrow{
    height:46px !important;
    right:10px;
}

.select2-dropdown{
    border:1px solid #d7e5ed;
    border-radius:14px;
    overflow:hidden;
}

.select2-search--dropdown{
    padding:10px;
}

.select2-search--dropdown .select2-search__field{
    border:1px solid #d7e5ed !important;
    border-radius:10px;
    padding:8px 10px;
    font-size:13px;
}

.select2-results__option{
    font-size:13px;
    padding:8px 12px;
}

:root{
    --primary:#0f766e;
    --primary-2:#0ea5a4;
    --secondary:#2563eb;
    --accent:#f97316;
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
        radial-gradient(circle at 50% 100%, rgba(249,115,22,.08), transparent 20%),
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
.note-card,
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

.note-card{
    border-radius:18px;
    padding:14px 16px;
    margin-bottom:18px;
    font-size:12px;
    color:#475569;
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

.legend-title,
.source-title{
    font-size:13px;
    font-weight:700;
    color:var(--ink);
    margin-bottom:10px;
}

.legend-item{
    font-size:12px;
    color:#475569;
    padding:9px 12px;
    background:#f8fbfd;
    border:1px solid #e5edf4;
    border-radius:12px;
    margin-bottom:8px;
}

.source-box{
    display:flex;
    align-items:flex-start;
    gap:12px;
    padding:12px 14px;
    border-radius:14px;
    background:#fff8f2;
    border:1px solid #fde3cf;
}

.source-icon{
    width:40px;
    height:40px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#fff1e6 0%, #ffe4d0 100%);
    color:#ea580c;
    font-size:18px;
    flex-shrink:0;
}

.source-link{
    color:#0f766e;
    text-decoration:none;
    word-break:break-all;
    font-weight:600;
}

.source-link:hover{
    text-decoration:underline;
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

.export-btn i{
    font-size:15px;
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
                            <i class="bi bi-activity"></i>
                            Phatthalung People Map
                        </div>
                        <div class="hero-title">Dashboard : ข้อมูลการตายจังหวัดพัทลุง</div>
                        <div class="hero-subtitle">
                            ติดตามสถานการณ์การเสียชีวิต จำแนกตามปี อำเภอ เพศ กลุ่มอายุ และสาเหตุการตาย
                            เพื่อสนับสนุนการติดตาม วิเคราะห์ และตัดสินใจเชิงนโยบายในระดับพื้นที่
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="hero-meta">
                            <div class="hero-meta-box">
                                <div class="hero-meta-label">ปีข้อมูลที่เลือก</div>
                                <div class="hero-meta-value">{{ $selectedYear !== '' ? $selectedYear : 'ทั้งหมด' }}</div>
                            </div>
                            <div class="hero-meta-box">
                                <div class="hero-meta-label">จังหวัด</div>
                                <div class="hero-meta-value">พัทลุง</div>
                            </div>
                            <div class="hero-meta-box">
                                <div class="hero-meta-label">จำนวนอำเภอ</div>
                                <div class="hero-meta-value">{{ number_format($districtCount) }}</div>
                            </div>
                            <div class="hero-meta-box">
                                <div class="hero-meta-label">จำนวนสาเหตุ</div>
                                <div class="hero-meta-value">{{ number_format($causeCount) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="filter-card">
            <form method="GET" id="filterForm" action="{{ route('health.death_dashboard') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4 col-lg-2">
                        <label class="filter-label">ปี</label>
                        <select name="year" class="form-select filter-control">
                            <option value="">ทั้งหมด</option>
                            @foreach($yearList as $year)
                                <option value="{{ $year }}" {{ (string)$selectedYear === (string)$year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 col-lg-2">
                        <label class="filter-label">อำเภอ</label>
                        <select name="district" class="form-select filter-control">
                            <option value="">ทั้งหมด</option>
                            @foreach($districtList as $district)
                                <option value="{{ $district }}" {{ $selectedDistrict === $district ? 'selected' : '' }}>
                                    {{ $district }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 col-lg-2">
                        <label class="filter-label">เพศ</label>
                        <select name="gender" class="form-select filter-control">
                            <option value="">ทั้งหมด</option>
                            @foreach($genderList as $gender)
                                <option value="{{ $gender }}" {{ $selectedGender === $gender ? 'selected' : '' }}>
                                    {{ $gender }}
                                </option>
                            @endforeach
                        </select>
                    </div>

               <div class="col-md-6 col-lg-2">
    <label class="filter-label">กลุ่มอายุ</label>
    <select name="age_group" class="form-select filter-control">
        <option value="">ทั้งหมด</option>
        <option value="0-5" {{ $selectedAgeGroup === '0-5' ? 'selected' : '' }}>0-5 ปี</option>
        <option value="6-24" {{ $selectedAgeGroup === '6-24' ? 'selected' : '' }}>6-24 ปี</option>
        <option value="25-59" {{ $selectedAgeGroup === '25-59' ? 'selected' : '' }}>25-59 ปี</option>
        <option value="60+" {{ $selectedAgeGroup === '60+' ? 'selected' : '' }}>60 ปีขึ้นไป</option>
    </select>
</div>

                    <!-- ช่องสาเหตุการเสียชีวิต ใช้อันนี้แทนของเดิม -->

<div class="col-md-6 col-lg-4">
    <label class="filter-label">สาเหตุการเสียชีวิต</label>

    <select name="cause_of_death"
            id="causeSelect"
            class="form-select filter-control">
        <option value="">ทั้งหมด</option>
        @foreach($causeList as $cause)
            <option value="{{ $cause }}"
                {{ ($selectedCause ?? '') === $cause ? 'selected' : '' }}>
                {{ $cause }}
            </option>
        @endforeach
    </select>
</div>
                </div>

               <div class="filter-footer">

    <div class="filter-info">
        <div class="filter-info-icon">
            <i class="bi bi-funnel-fill"></i>
        </div>

        <div>
            <div class="filter-info-title">
                กรองข้อมูลตามปี อำเภอ เพศ กลุ่มอายุ และสาเหตุการตาย
            </div>
            <div class="filter-info-sub">
                ค้นหาและดาวน์โหลดข้อมูลตามตัวกรองที่เลือกเป็นไฟล์ Excel
            </div>
        </div>
    </div>

   <div class="filter-action">

    <button type="submit" class="btn btn-main">
        <i class="bi bi-search me-1"></i>
        <span>ค้นหาข้อมูล</span>
    </button>

    <a href="{{ route('health.death_dashboard.export', request()->query()) }}" class="btn btn-soft export-btn">
        <i class="bi bi-file-earmark-excel-fill"></i>
        <span>Export Excel</span>
    </a>

    <a href="{{ route('death_summary.manage') }}" class="btn btn-soft">
        <i class="bi bi-pencil-square"></i>
        <span>จัดการข้อมูล</span>
    </a>

    <button type="button" class="btn btn-soft" data-bs-toggle="modal" data-bs-target="#importExcelModal">
        <i class="bi bi-cloud-arrow-up-fill"></i>
        <span>Import Excel</span>
    </button>

    <a href="{{ route('health.death_dashboard') }}" class="btn btn-soft">
        <i class="bi bi-arrow-clockwise me-1"></i>
        <span>ล้างข้อมูล</span>
    </a>

</div>
</div>
            </form>
        </div>

       

          <div class="row g-3 mb-3 flex-nowrap overflow-auto">

    <div class="col" style="min-width:220px;">
        <div class="kpi-card">
            <div class="kpi-icon"><i class="bi bi-people-fill"></i></div>
            <div class="kpi-label">ผู้เสียชีวิตทั้งหมด</div>
            <h3 class="kpi-value">{{ number_format($totalDeaths) }}</h3>
            <div class="kpi-sub">รวมทุกเงื่อนไขที่เลือก</div>
        </div>
    </div>

    <div class="col" style="min-width:220px;">
        <div class="kpi-card">
            <div class="kpi-icon"><i class="bi bi-gender-male"></i></div>
            <div class="kpi-label">เพศชาย</div>
            <h3 class="kpi-value">{{ number_format($maleDeaths) }}</h3>
            <div class="kpi-sub">จำนวนผู้เสียชีวิตเพศชาย</div>
        </div>
    </div>

    <div class="col" style="min-width:220px;">
        <div class="kpi-card">
            <div class="kpi-icon"><i class="bi bi-gender-female"></i></div>
            <div class="kpi-label">เพศหญิง</div>
            <h3 class="kpi-value">{{ number_format($femaleDeaths) }}</h3>
            <div class="kpi-sub">จำนวนผู้เสียชีวิตเพศหญิง</div>
        </div>
    </div>

    <div class="col" style="min-width:220px;">
        <div class="kpi-card">
            <div class="kpi-icon"><i class="bi bi-geo-alt-fill"></i></div>
            <div class="kpi-label">จำนวนอำเภอ</div>
            <h3 class="kpi-value">{{ number_format($districtCount) }}</h3>
            <div class="kpi-sub">อำเภอที่มีข้อมูลในเงื่อนไขนี้</div>
        </div>
    </div>

    <div class="col" style="min-width:220px;">
        <div class="kpi-card">
            <div class="kpi-icon"><i class="bi bi-clipboard2-pulse-fill"></i></div>
            <div class="kpi-label">จำนวนสาเหตุการตาย</div>
            <h3 class="kpi-value">{{ number_format($causeCount) }}</h3>
            <div class="kpi-sub">กลุ่มสาเหตุที่ปรากฏ</div>
        </div>
    </div>

</div>
          
      
        

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="panel-card">
                    <div class="panel-head">
                        <div class="panel-title">แนวโน้มผู้เสียชีวิตรายเดือน</div>
                        <div class="panel-sub">แสดงจำนวนผู้เสียชีวิตรวมรายเดือน</div>
                    </div>
                    <div class="panel-body">
                        <div class="chart-box">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="panel-card">
                    <div class="panel-head">
                        <div class="panel-title">จำนวนผู้เสียชีวิตตามกลุ่มอายุ</div>
                        <div class="panel-sub">เปรียบเทียบแต่ละช่วงวัย</div>
                    </div>
                    <div class="panel-body">
                        <div class="chart-box">
                            <canvas id="ageChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-lg-6">
                <div class="panel-card">
                    <div class="panel-head">
                        <div class="panel-title">จำนวนผู้เสียชีวิตรายอำเภอ</div>
                        <div class="panel-sub">เรียงจากจำนวนมากไปน้อย</div>
                    </div>
                    <div class="panel-body">
                        <div class="chart-box">
                            <canvas id="districtChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel-card">
                    <div class="panel-head">
                        <div class="panel-title">10 อันดับสาเหตุการตายสูงสุด</div>
                        <div class="panel-sub">ประเด็นสำคัญที่ควรติดตามเป็นพิเศษ</div>
                    </div>
                    <div class="panel-body">
                        <div class="chart-box">
                            <canvas id="causeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3 สาเหตุการตาย แยกตามช่วงอายุ --}}
        <div class="row g-3 mt-1">
            <div class="col-lg-3 col-md-6">
                <div class="panel-card h-100">
                    <div class="panel-head">
                        <div class="panel-title">3 สาเหตุการตาย (อายุ 0-5 ปี)</div>
                       
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table ga-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>สาเหตุการตาย</th>
                                        <th style="width:90px;" class="text-end">จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topCausesAge0_5 as $row)
                                        <tr>
                                            <td>{{ $row->cause_of_death }}</td>
                                            <td class="text-end fw-semibold">{{ number_format($row->total) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="empty-state">ไม่พบข้อมูล</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel-card h-100">
                    <div class="panel-head">
                        <div class="panel-title">3 สาเหตุการตาย (อายุ 6-24 ปี)</div>
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table ga-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>สาเหตุการตาย</th>
                                        <th style="width:90px;" class="text-end">จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topCausesAge6_24 as $row)
                                        <tr>
                                            <td>{{ $row->cause_of_death }}</td>
                                            <td class="text-end fw-semibold">{{ number_format($row->total) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="empty-state">ไม่พบข้อมูล</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel-card h-100">
                    <div class="panel-head">
                        <div class="panel-title">3 สาเหตุการตาย (อายุ 25-59 ปี)</div>
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table ga-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>สาเหตุการตาย</th>
                                        <th style="width:90px;" class="text-end">จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topCausesAge25_59 as $row)
                                        <tr>
                                            <td>{{ $row->cause_of_death }}</td>
                                            <td class="text-end fw-semibold">{{ number_format($row->total) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="empty-state">ไม่พบข้อมูล</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel-card h-100">
                    <div class="panel-head">
                        <div class="panel-title">3 สาเหตุการตาย (อายุ 60 ปีขึ้นไป)</div>
            
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table ga-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>สาเหตุการตาย</th>
                                        <th style="width:90px;" class="text-end">จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topCausesAge60Plus as $row)
                                        <tr>
                                            <td>{{ $row->cause_of_death }}</td>
                                            <td class="text-end fw-semibold">{{ number_format($row->total) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="empty-state">ไม่พบข้อมูล</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
      <div class="source-card py-3 px-4">
    <div class="d-flex align-items-center gap-3 flex-wrap">

        <div class="source-icon"
             style="width:42px;height:42px;border-radius:14px;">
            <i class="bi bi-link-45deg"></i>
        </div>

       <div class="flex-grow-1">

    <div style="font-size:13px; font-weight:700; color:#0f172a;">
        แหล่งที่มา : ระบบบริการข้อมูลสถิติชีพประเทศไทย
    </div>

    <a class="source-link"
       href="https://vitalstat.moph.go.th"
       target="_blank"
       rel="noopener noreferrer"
       style="font-size:12px;">
        vitalstat.moph.go.th
    </a>

    <div style="font-size:12px; color:#64748b; margin-top:4px;">
        อัปเดตข้อมูลล่าสุด :
        {{ \Carbon\Carbon::now('Asia/Bangkok')->format('d/m/Y H:i') }} น.
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
                    นำเข้าข้อมูลการตายจาก Excel
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('death_summary.import') }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-body p-4">
                    <label class="form-label fw-semibold">เลือกไฟล์ Excel</label>
                    <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv" required>

                    <div class="mt-3 small text-muted">
                       หัวตาราง Excel ต้องเรียงเป็น 8 ช่อง:<br>
ปี,เดือน,ชื่อจังหวัด,ชื่ออำเภอ,ชื่อเพศ,กลุ่มอายุ,สาเหตุการตาย,จำนวนผู้ตาย
                    </div>
                    <div class="mt-2">
    ตัวอย่าง:<br>
    2569, 1, พัทลุง, เมืองพัทลุง, ชาย, 60+, โรคหัวใจ, 25
</div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success">
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
<!-- ก่อนปิด </body> ใส่เพิ่ม -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(function(){

    $('#causeSelect').select2({
        width: '100%',
        allowClear: false,
        language: {
            noResults: function () {
                return "ไม่พบข้อมูล";
            }
        }
    });

    $('#causeSelect').on('select2:open', function () {
        const searchField = document.querySelector('.select2-search__field');
        if (searchField) searchField.focus();
    });

});
</script>

<script>
    const monthlyLabels = @json($monthlyChartLabels);
    const monthlyData = @json($monthlyChartData);

    const districtLabels = @json($districtChartLabels);
    const districtData = @json($districtChartData);

    const causeLabels = @json($causeChartLabels);
    const causeData = @json($causeChartData);

    const ageLabels = @json($ageGroupChartLabels);
    const ageData = @json($ageGroupChartData);

    const monthlyChart = document.getElementById('monthlyChart');
    if (monthlyChart) {
        new Chart(monthlyChart, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'จำนวนผู้เสียชีวิต',
                    data: monthlyData,
                    borderColor: '#0ea5a4',
                    backgroundColor: 'rgba(14,165,164,.14)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#0ea5a4',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2
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
                        title: { display: true, text: 'จำนวนผู้เสียชีวิต' }
                    }
                }
            }
        });
    }

    const districtChart = document.getElementById('districtChart');
    if (districtChart) {
        new Chart(districtChart, {
            type: 'bar',
            data: {
                labels: districtLabels,
                datasets: [{
                    label: 'จำนวนผู้เสียชีวิต',
                    data: districtData,
                    backgroundColor: '#2563eb',
                    borderColor: '#2563eb',
                    borderWidth: 1,
                    borderRadius: 10,
                    maxBarThickness: 32
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: 'rgba(148,163,184,.18)' }
                    },
                    y: { grid: { display: false } }
                }
            }
        });
    }

    const causeChart = document.getElementById('causeChart');
    if (causeChart) {
        new Chart(causeChart, {
            type: 'bar',
            data: {
                labels: causeLabels,
                datasets: [{
                    label: 'จำนวนผู้เสียชีวิต',
                    data: causeData,
                    backgroundColor: '#f97316',
                    borderColor: '#f97316',
                    borderWidth: 1,
                    borderRadius: 10,
                    maxBarThickness: 32
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: 'rgba(148,163,184,.18)' }
                    },
                    y: { grid: { display: false } }
                }
            }
        });
    }

    const ageChart = document.getElementById('ageChart');
    if (ageChart) {
        new Chart(ageChart, {
            type: 'bar',
            data: {
                labels: ageLabels,
                datasets: [{
                    label: 'จำนวนผู้เสียชีวิต',
                    data: ageData,
                    backgroundColor: '#14b8a6',
                    borderColor: '#14b8a6',
                    borderWidth: 1,
                    borderRadius: 10,
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
                        title: { display: true, text: 'จำนวนผู้เสียชีวิต' }
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