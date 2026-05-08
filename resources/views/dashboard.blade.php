{{-- resources/views/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dashboard | Phatthalung People Map</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/countup.js@2.8.0/dist/countUp.umd.js"></script>

<style>
:root{
    --main:#0B7F6F;
    --main2:#0B5B6B;
    --soft:#eefaf7;
    --dark:#0f172a;
    --muted:#64748b;
    --line:#dbe7e5;
    --card:#ffffff;
    --blue:#0ea5e9;
    --orange:#f59e0b;
    --red:#ef4444;
}

*{font-family:'Prompt',sans-serif;}

body{
    margin:0;
    background:
        radial-gradient(circle at top left, rgba(11,127,111,.12), transparent 30%),
        radial-gradient(circle at top right, rgba(14,165,233,.10), transparent 28%),
        linear-gradient(135deg,#f6fbf9,#f8fbff);
    color:var(--dark);
}

.dashboard-page{
    padding:18px;
    width:100%;
}

.hero{
    background:linear-gradient(135deg,#063f3a,#0B7F6F 55%,#14b8a6);
    border-radius:24px;
    padding:22px 24px;
    color:white;
    box-shadow:0 15px 40px rgba(11,127,111,.18);
    margin-bottom:16px;
}

.hero h1{
    font-size:28px;
    font-weight:800;
    margin:0;
}

.hero p{
    margin:8px 0 0;
    opacity:.9;
    max-width:900px;
    line-height:1.7;
    font-size:14px;
}

.filter-card{
    background:rgba(255,255,255,.95);
    backdrop-filter:blur(12px);
    border:1px solid var(--line);
    border-radius:22px;
    padding:14px;
    box-shadow:0 10px 28px rgba(15,23,42,.05);
    margin-bottom:16px;
    position:relative;
    z-index:20;
    overflow:visible;
}

.filter-btn{
    height:44px;
    border-radius:14px;
    font-size:14px;
    font-weight:600;
}

.dropdown-menu{
    border:none;
    border-radius:18px;
    padding:10px;
    box-shadow:0 18px 40px rgba(15,23,42,.12);
    z-index:9999;
}

.dropdown-item{
    border-radius:12px;
    padding:10px 12px;
    font-size:14px;
}

.dropdown-item:hover{
    background:#f1f5f9;
}

.dropdown-menu-scrollable{
    max-height:260px;
    overflow:auto;
}

.active-chip{
    display:inline-flex;
    gap:6px;
    align-items:center;
    padding:7px 13px;
    border-radius:999px;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    font-size:12px;
    font-weight:600;
    color:#475569;
}

.kpi-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:14px;
    margin-bottom:16px;
}

.kpi-card{
    background:var(--card);
    border:1px solid var(--line);
    border-radius:22px;
    padding:16px;
    box-shadow:0 10px 30px rgba(15,23,42,.05);
    position:relative;
    overflow:hidden;
    transition:.25s ease;
}

.kpi-card:hover{
    transform:translateY(-4px);
}

.kpi-card:after{
    content:"";
    position:absolute;
    width:120px;
    height:120px;
    border-radius:50%;
    right:-40px;
    top:-40px;
    background:rgba(11,127,111,.08);
}

.kpi-icon{
    width:42px;
    height:42px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:18px;
    margin-bottom:10px;
    background:linear-gradient(135deg,var(--main),var(--main2));
}

.kpi-label{
    color:var(--muted);
    font-size:13px;
    font-weight:600;
}

.kpi-value{
    font-size:26px;
    font-weight:800;
    margin-top:2px;
    line-height:1.1;
}

.kpi-sub{
    font-size:11px;
    color:#64748b;
    margin-top:5px;
}

.dashboard-grid{
    display:grid;
    grid-template-columns:repeat(12,1fr);
    gap:14px;
}

.panel{
    background:white;
    border:1px solid var(--line);
    border-radius:24px;
    box-shadow:0 10px 30px rgba(15,23,42,.05);
    overflow:hidden;
}

.col-4x{grid-column:span 4;}
.col-5x{grid-column:span 5;}
.col-7x{grid-column:span 7;}
.col-8x{grid-column:span 8;}
.col-12x{grid-column:span 12;}

.panel-head{
    padding:14px 18px;
    border-bottom:1px solid #edf2f7;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.panel-title{
    font-size:15px;
    font-weight:800;
    margin:0;
}

.panel-sub{
    font-size:11px;
    color:var(--muted);
    margin-top:2px;
}

.panel-body{
    padding:16px;
}

.chart-box{height:260px;}
.chart-lg{height:340px;}

.summary-table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 10px;
}

.summary-table td{
    padding:10px 12px;
    background:#f8fafc;
    font-size:13px;
}

.summary-table td:first-child{
    border-radius:12px 0 0 12px;
    color:#475569;
    font-weight:700;
}

.summary-table td:last-child{
    border-radius:0 12px 12px 0;
    text-align:right;
    font-weight:800;
    color:var(--dark);
}

.progress-soft{
    height:10px;
    background:#e2e8f0;
    border-radius:999px;
    overflow:hidden;
}

.progress-soft span{
    display:block;
    height:100%;
    background:linear-gradient(90deg,var(--main),#2dd4bf);
    border-radius:999px;
}

.footer-note{
    text-align:center;
    color:var(--muted);
    font-size:12px;
    padding:20px 0 4px;
}

canvas{
    max-height:100% !important;
}




/* dashboard interaction animation */
.panel,
.kpi-card{
    transition:all .28s ease;
    animation:fadeUp .55s ease both;
}

.kpi-card:nth-child(1){animation-delay:.03s;}
.kpi-card:nth-child(2){animation-delay:.08s;}
.kpi-card:nth-child(3){animation-delay:.13s;}
.kpi-card:nth-child(4){animation-delay:.18s;}

.panel:nth-child(1){animation-delay:.08s;}
.panel:nth-child(2){animation-delay:.14s;}
.panel:nth-child(3){animation-delay:.20s;}
.panel:nth-child(4){animation-delay:.26s;}

.panel:hover,
.kpi-card:hover{
    transform:translateY(-6px);
    box-shadow:0 18px 45px rgba(15,23,42,.10);
}

@keyframes fadeUp{
    from{
        opacity:0;
        transform:translateY(14px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

#loadingOverlay{
    position:fixed;
    inset:0;
    background:rgba(15,23,42,.36);
    backdrop-filter:blur(5px);
    z-index:99999;
    display:none;
    align-items:center;
    justify-content:center;
}

.loading-card{
    background:rgba(255,255,255,.96);
    border-radius:22px;
    padding:22px 28px;
    box-shadow:0 20px 55px rgba(15,23,42,.18);
    display:flex;
    align-items:center;
    gap:14px;
    color:#0B5B6B;
    font-weight:800;
}

.loading-card .spinner-border{
    width:1.7rem;
    height:1.7rem;
}

@media(max-width:1200px){
    .kpi-grid{grid-template-columns:repeat(2,1fr);}
    .col-4x,.col-5x,.col-7x,.col-8x{grid-column:span 12;}
}

@media(max-width:768px){
    .dashboard-page{padding:12px;}
    .hero{padding:18px;border-radius:20px;}
    .hero h1{font-size:22px;}
    .kpi-grid{grid-template-columns:1fr;}
    .chart-box{height:230px;}
    .chart-lg{height:280px;}
}
</style>
</head>

<body>

@php
$year = $year ?? request('year', 'all');
$YEAR_OPTIONS = $YEAR_OPTIONS ?? ['all','2564','2565','2566','2567','2568'];
if (!in_array($year, $YEAR_OPTIONS, true)) $year = 'all';
$yearLabel = ($year === 'all') ? '2564–2568' : $year;

$view = $view ?? request('view', 'district');

$districtList = $districtList ?? [
    'เมืองพัทลุง','กงหรา','เขาชัยสน','ควนขนุน','ตะโหมด','บางแก้ว',
    'ปากพะยูน','ศรีบรรพต','ป่าบอน','ป่าพะยอม','ศรีนครินทร์'
];

$district    = $district ?? request('district','');
$subdistrict = $subdistrict ?? request('subdistrict','');
$human_Sex   = $human_Sex ?? request('human_Sex','');
$age_range   = $age_range ?? request('age_range','');

$AGE_RANGES = $AGE_RANGES ?? [
    ''=>'อายุ: ทั้งหมด',
    '0-15'=>'0–15 ปี',
    '16-28'=>'16–28 ปี',
    '29-44'=>'29–44 ปี',
    '45-59'=>'45–59 ปี',
    '60-78'=>'60–78 ปี',
    '79-97'=>'79–97 ปี',
    '98+'=>'98 ปีขึ้นไป',
];

$subdistrictList = $subdistrictList ?? collect([]);

$totalHouseholds = $totalHouseholds ?? 0;
$totalMembers = $totalMembers ?? 0;
$poorHouseholds = $poorHouseholds ?? 0;

$welfareTotal = $welfareTotal ?? 0;

$welfareReceived = $welfareReceived ?? 0;

$welfareNotReceived = max(
    0,
    $welfareTotal - $welfareReceived
);

$sexCounts = $sexCounts ?? ['ชาย'=>0,'หญิง'=>0];
$sexTotal = ($sexCounts['ชาย'] ?? 0) + ($sexCounts['หญิง'] ?? 0);

$poorPercent = $totalHouseholds > 0 ? round(($poorHouseholds / $totalHouseholds) * 100) : 0;
$femalePercent = $sexTotal > 0 ? round((($sexCounts['หญิง'] ?? 0) / $sexTotal) * 100) : 0;

$labels = $labels ?? [];
$datasets = $datasets ?? [];

$capSummary = $capSummary ?? [
    'human'=>0,
    'physical'=>0,
    'financial'=>0,
    'natural'=>0,
    'social'=>0,
];

$capStd = $capStd ?? [
    'human'=>0,
    'physical'=>0,
    'financial'=>0,
    'natural'=>0,
    'social'=>0,
];

$capRadarSafe = $capRadar ?? [
    (float)($capSummary['human'] ?? 0),
    (float)($capSummary['physical'] ?? 0),
    (float)($capSummary['financial'] ?? 0),
    (float)($capSummary['natural'] ?? 0),
    (float)($capSummary['social'] ?? 0),
];

$capRadarStdSafe = $capRadarStd ?? [
    (float)($capStd['human'] ?? 0),
    (float)($capStd['physical'] ?? 0),
    (float)($capStd['financial'] ?? 0),
    (float)($capStd['natural'] ?? 0),
    (float)($capStd['social'] ?? 0),
];

$baseParams = [
    'year'=>$year,
    'district'=>$district,
    'subdistrict'=>$subdistrict,
    'human_Sex'=>$human_Sex,
    'age_range'=>$age_range,
    'view'=>$view,
];

$sexCountsSafe = $sexCounts;
@endphp

@include('layouts.topbar')

<div class="dashboard-page">

    <section class="hero">
        <div class="d-flex flex-wrap justify-content-between gap-3 align-items-center">
            <div>
                <h1>แดชบอร์ดข้อมูลภาพรวมครัวเรือนยากจน</h1>
                <p>
                    ภาพรวมข้อมูลภาพรวมครัวเรือนยากจน ประชากร สุขภาพ สวัสดิการ และทุน 5 ด้าน
                    สำหรับสนับสนุนการวิเคราะห์ข้อมูลเชิงพื้นที่และการตัดสินใจ
                </p>
            </div>
            <div class="text-end">
                <div style="font-size:13px;opacity:.8;">ปีข้อมูล</div>
                <div style="font-size:30px;font-weight:800;">{{ $yearLabel }}</div>
            </div>
        </div>
    </section>

    <section class="filter-card">
        <div class="row g-3">

            <div class="col-12 col-md-2">
                <div class="dropdown">
                    <button class="btn btn-outline-success w-100 filter-btn dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-calendar2-week me-1"></i> ปี {{ $yearLabel }}
                    </button>
                    <ul class="dropdown-menu w-100">
                        @foreach($YEAR_OPTIONS as $y)
                            @php $yLabel = ($y==='all') ? '2564–2568' : $y; @endphp
                            <li>
                                <a class="dropdown-item {{ $year===$y ? 'active' : '' }}"
                                   href="{{ route('dashboard', array_filter(array_merge($baseParams, ['year'=>$y,'subdistrict'=>'']))) }}">
                                    {{ $yLabel }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="dropdown">
                    <button class="btn btn-success w-100 filter-btn dropdown-toggle"
                            style="background:#0B7F6F;border-color:#0B7F6F;"
                            data-bs-toggle="dropdown"
                            data-bs-auto-close="outside">
                        <i class="bi bi-geo-alt-fill me-1"></i>
                        {{ $district ? 'อ.'.$district : 'เลือกอำเภอ' }}
                    </button>
                    <ul class="dropdown-menu w-100 dropdown-menu-scrollable">
                        @foreach($districtList as $d)
                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('dashboard', array_filter(array_merge($baseParams, ['district'=>$d,'subdistrict'=>'']))) }}">
                                    อ.{{ $d }}
                                </a>
                            </li>
                        @endforeach
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger"
                               href="{{ route('dashboard', array_filter(array_merge($baseParams, ['district'=>'','subdistrict'=>'']))) }}">
                                ล้างอำเภอ
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="dropdown">
                    <button class="btn btn-outline-success w-100 filter-btn dropdown-toggle"
                            data-bs-toggle="dropdown"
                            data-bs-auto-close="outside"
                            @if(empty($district)) disabled @endif>
                        <i class="bi bi-pin-map-fill me-1"></i>
                        {{ $subdistrict ? 'ต.'.$subdistrict : 'เลือกตำบล' }}
                    </button>
                    <ul class="dropdown-menu w-100 dropdown-menu-scrollable">
                        @if(empty($district))
                            <li><span class="dropdown-item text-muted">กรุณาเลือกอำเภอก่อน</span></li>
                        @else
                            <li>
                                <a class="dropdown-item text-danger"
                                   href="{{ route('dashboard', array_filter(array_merge($baseParams, ['subdistrict'=>'']))) }}">
                                    ล้างตำบล
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @foreach($subdistrictList as $sd)
                                <li>
                                    <a class="dropdown-item {{ $subdistrict===$sd ? 'active' : '' }}"
                                       href="{{ route('dashboard', array_filter(array_merge($baseParams, ['subdistrict'=>$sd]))) }}">
                                        ต.{{ $sd }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <div class="col-12 col-md-2">
                <div class="dropdown">
                    <button class="btn btn-outline-info w-100 filter-btn dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-gender-ambiguous me-1"></i>
                        {{ $human_Sex ? 'เพศ: '.$human_Sex : 'เพศทั้งหมด' }}
                    </button>
                    <ul class="dropdown-menu w-100">
                        <li><a class="dropdown-item" href="{{ route('dashboard', array_filter(array_merge($baseParams, ['human_Sex'=>'']))) }}">ทั้งหมด</a></li>
                        <li><a class="dropdown-item" href="{{ route('dashboard', array_filter(array_merge($baseParams, ['human_Sex'=>'ชาย']))) }}">ชาย</a></li>
                        <li><a class="dropdown-item" href="{{ route('dashboard', array_filter(array_merge($baseParams, ['human_Sex'=>'หญิง']))) }}">หญิง</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-12 col-md-2">
                <div class="dropdown">
                    <button class="btn btn-outline-warning w-100 filter-btn dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-hourglass-split me-1"></i>
                        {{ $age_range ? ($AGE_RANGES[$age_range] ?? $age_range) : 'อายุทั้งหมด' }}
                    </button>
                    <ul class="dropdown-menu w-100 dropdown-menu-scrollable">
                        @foreach($AGE_RANGES as $key => $label)
                            <li>
                                <a class="dropdown-item {{ $age_range===$key ? 'active' : '' }}"
                                   href="{{ route('dashboard', array_filter(array_merge($baseParams, ['age_range'=>$key]))) }}">
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-12">
                <div class="d-flex flex-wrap gap-2">
                    <span class="active-chip"><i class="bi bi-calendar2-week text-success"></i> {{ $yearLabel }}</span>
                    <span class="active-chip"><i class="bi bi-geo-alt-fill text-success"></i> {{ $district ? 'อ.'.$district : 'ทุกอำเภอ' }}</span>
                    <span class="active-chip"><i class="bi bi-pin-map-fill text-success"></i> {{ $subdistrict ? 'ต.'.$subdistrict : 'ทุกตำบล' }}</span>
                    <span class="active-chip"><i class="bi bi-gender-ambiguous text-success"></i> {{ $human_Sex ?: 'ทุกเพศ' }}</span>
                    <span class="active-chip"><i class="bi bi-hourglass-split text-success"></i> {{ $age_range ? ($AGE_RANGES[$age_range] ?? $age_range) : 'ทุกช่วงอายุ' }}</span>

                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-danger rounded-pill px-3 ms-auto">
                        <i class="bi bi-arrow-clockwise me-1"></i> ล้างค่าทั้งหมด
                    </a>
                </div>
            </div>

        </div>
    </section>

    <section class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon"><i class="bi bi-houses-fill"></i></div>
            <div class="kpi-label">ครัวเรือนทั้งหมด</div>
            <div class="kpi-value countup" data-count="{{ $totalHouseholds }}">0</div>
            <div class="kpi-sub">ข้อมูลตามตัวกรองปัจจุบัน</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon" style="background:linear-gradient(135deg,#0ea5e9,#0369a1);"><i class="bi bi-people-fill"></i></div>
            <div class="kpi-label">สมาชิกทั้งหมด</div>
            <div class="kpi-value countup" data-count="{{ $totalMembers }}">0</div>
            <div class="kpi-sub">จำนวนประชากรในฐานข้อมูล</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon" style="background:linear-gradient(135deg,#f59e0b,#b45309);"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div class="kpi-label">ครัวเรือนยากจน</div>
            <div class="kpi-value countup" data-count="{{ $poorHouseholds }}">0</div>
            <div class="kpi-sub">คิดเป็น {{ $poorPercent }}% ของครัวเรือน</div>
        </div>

        <div class="kpi-card">

    <div class="kpi-icon"
         style="background:linear-gradient(135deg,#ef4444,#be123c);">
        <i class="bi bi-heart-pulse-fill"></i>
    </div>

    <div class="kpi-label">
        ผู้ได้รับสวัสดิการ
    </div>

    <div class="kpi-value countup"
         data-count="{{ $welfareReceived ?? 0 }}">
        0
    </div>

    <div class="kpi-sub">
        ไม่ได้รับ
        {{ number_format($welfareNotReceived ?? 0) }}
        คน
        • รวม
        {{ number_format($welfareTotal ?? 0) }}
        คน
    </div>

</div>
    </section>
<div class="row g-3 mb-3">

    {{-- Insight --}}
    <div class="col-lg-4">

        <div class="panel h-100">

            <div class="panel-head">
                <div>
                    <h3 class="panel-title">
                        Insight อัตโนมัติ
                    </h3>

                    <div class="panel-sub">
                        วิเคราะห์ข้อมูลจากระบบ
                    </div>
                </div>

                <i class="bi bi-lightbulb-fill text-warning fs-4"></i>
            </div>

            <div class="panel-body">

                <div class="mb-3 p-3 rounded-4"
                     style="background:#f8fafc;border:1px solid #e2e8f0;">

                    <div class="fw-bold text-success mb-1">
                        ครัวเรือนทั้งหมด
                    </div>

                    <div style="font-size:14px;color:#475569;">
                        พบข้อมูล
                        <strong>{{ number_format($totalHouseholds) }}</strong>
                        ครัวเรือน
                    </div>

                </div>

                <div class="mb-3 p-3 rounded-4"
                     style="background:#fff7ed;border:1px solid #fed7aa;">

                    <div class="fw-bold text-warning mb-1">
                        กลุ่มเปราะบาง
                    </div>

                    <div style="font-size:14px;color:#7c2d12;">
                        ครัวเรือนยากจน
                        <strong>{{ number_format($poorHouseholds) }}</strong>
                        ครัวเรือน
                    </div>

                </div>

                <div class="p-3 rounded-4"
                     style="background:#eff6ff;border:1px solid #bfdbfe;">

                    <div class="fw-bold text-primary mb-1">
                        สวัสดิการ
                    </div>

                    <div style="font-size:14px;color:#1e3a8a;">
                        ยังไม่ได้รับ
                        <strong>{{ number_format($welfareNotReceived) }}</strong>
                        คน
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Top 5 อำเภอ --}}
    <div class="col-lg-4">

        <div class="panel h-100">

            <div class="panel-head">

                <div>
                    <h3 class="panel-title">
                        Top 5 อำเภอ
                    </h3>

                    <div class="panel-sub">
                        จำนวนครัวเรือนสูงสุด
                    </div>
                </div>

                <i class="bi bi-trophy-fill text-warning fs-4"></i>

            </div>

            <div class="panel-body">

                @forelse(($householdsByDistrict ?? []) as $index => $item)

                    @if($index < 5)

                    <div class="d-flex align-items-center justify-content-between mb-3 p-3 rounded-4"
                         style="background:#f8fafc;border:1px solid #e2e8f0;">

                        <div class="d-flex align-items-center gap-3">

                            <div style="
                                width:42px;
                                height:42px;
                                border-radius:14px;
                                background:linear-gradient(135deg,#0B7F6F,#0B5B6B);
                                color:#fff;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-weight:800;
                            ">
                                {{ $index + 1 }}
                            </div>

                            <div>

                                <div class="fw-bold">
                                    {{ $item->label ?? '-' }}
                                </div>

                                <div style="font-size:12px;color:#64748b;">
                                    จำนวนครัวเรือน
                                </div>

                            </div>

                        </div>

                        <div class="fw-bold fs-5 text-success">
                            {{ number_format($item->total ?? 0) }}
                        </div>

                    </div>

                    @endif

                @empty

                    <div class="text-muted text-center py-5">
                        ไม่มีข้อมูล
                    </div>

                @endforelse

            </div>

        </div>

    </div>

    {{-- ปุ่มลัด --}}
    <div class="col-lg-4">

        <div class="panel h-100">

            <div class="panel-head">

                <div>
                    <h3 class="panel-title">
                        เมนูลัดระบบ
                    </h3>

                    <div class="panel-sub">
                        เข้าถึงข้อมูลสำคัญรวดเร็ว
                    </div>
                </div>

                <i class="bi bi-grid-fill text-success fs-4"></i>

            </div>

            <div class="panel-body">

                <div class="d-grid gap-3">

                    <a href="{{ route('health_status') }}"
                       class="btn btn-lg text-start rounded-4"
                       style="background:#ecfeff;border:1px solid #bae6fd;color:#0c4a6e;">

                        <i class="bi bi-heart-pulse-fill me-2"></i>
                        ระบบข้อมูลสุขภาพ

                    </a>

                    <a href="{{ route('welfare.index') }}"
                       class="btn btn-lg text-start rounded-4"
                       style="background:#f5f3ff;border:1px solid #ddd6fe;color:#5b21b6;">

                        <i class="bi bi-people-fill me-2"></i>
                        ระบบข้อมูลสวัสดิการ

                    </a>

                    <a href="{{ route('household_64') }}"
                       class="btn btn-lg text-start rounded-4"
                       style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;">

                        <i class="bi bi-house-heart-fill me-2"></i>
                        ระบบข้อมูลครัวเรือน

                    </a>

                    <a href="{{ route('dashboard') }}"
                       class="btn btn-lg text-start rounded-4"
                       style="background:#fff7ed;border:1px solid #fed7aa;color:#9a3412;">

                        <i class="bi bi-bar-chart-fill me-2"></i>
                        Dashboard ภาพรวม

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>
    <section class="dashboard-grid">

        <div class="panel col-8x">
            <div class="panel-head">
                <div>
                    <h3 class="panel-title">สถานะสุขภาพประชากร</h3>
                    <div class="panel-sub">แสดงผลตามอำเภอ/ตำบลและตัวกรองที่เลือก</div>
                </div>
                <i class="bi bi-bar-chart-fill text-success fs-4"></i>
            </div>
            <div class="panel-body">
                <div class="chart-box">
                    <canvas id="healthChart"></canvas>
                </div>
            </div>
        </div>

        <div class="panel col-4x">
            <div class="panel-head">
                <div>
                    <h3 class="panel-title">สัดส่วนเพศ</h3>
                    <div class="panel-sub">ชาย / หญิง</div>
                </div>
                <i class="bi bi-pie-chart-fill text-info fs-4"></i>
            </div>
            <div class="panel-body">
                <div class="chart-box">
                    <canvas id="sexChart"></canvas>
                </div>

                <table class="summary-table mt-3">
                    <tr><td>ชาย</td><td>{{ number_format($sexCounts['ชาย'] ?? 0) }}</td></tr>
                    <tr><td>หญิง</td><td>{{ number_format($sexCounts['หญิง'] ?? 0) }}</td></tr>
                    <tr><td>รวม</td><td>{{ number_format($sexTotal) }}</td></tr>
                </table>
            </div>
        </div>

        <div class="panel col-7x">
            <div class="panel-head">
                <div>
                    <h3 class="panel-title">ทุน 5 ด้านของครัวเรือน</h3>
                    <div class="panel-sub">ค่าเฉลี่ยเปรียบเทียบรายด้าน</div>
                </div>
                <i class="bi bi-radar text-warning fs-4"></i>
            </div>
            <div class="panel-body">
                <div class="chart-lg">
                    <canvas id="capitalsRadar"></canvas>
                </div>
            </div>
        </div>

        <div class="panel col-5x">
            <div class="panel-head">
                <div>
                    <h3 class="panel-title">สรุปค่าเฉลี่ยทุน</h3>
                    <div class="panel-sub">รายละเอียดทุน 5 ด้าน</div>
                </div>
                <i class="bi bi-list-check text-danger fs-4"></i>
            </div>
            <div class="panel-body">
                @php
                    $capRows = [
                        'ทุนมนุษย์' => $capSummary['human'] ?? 0,
                        'ทุนกายภาพ' => $capSummary['physical'] ?? 0,
                        'ทุนการเงิน' => $capSummary['financial'] ?? 0,
                        'ทุนธรรมชาติ' => $capSummary['natural'] ?? 0,
                        'ทุนทางสังคม' => $capSummary['social'] ?? 0,
                    ];
                @endphp

                @foreach($capRows as $name => $value)
                    @php $percent = max(0, min(100, (float)$value)); @endphp
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <strong>{{ $name }}</strong>
                            <strong>{{ number_format($value, 2) }}</strong>
                        </div>
                        <div class="progress-soft">
                            <span style="width:{{ $percent }}%;"></span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="panel col-7x">
            <div class="panel-head">
                <div>
                    <h3 class="panel-title">จำนวนครัวเรือนรายอำเภอ</h3>
                    <div class="panel-sub">จัดอันดับจำนวนครัวเรือนตามตัวกรอง</div>
                </div>
                <i class="bi bi-building text-primary fs-4"></i>
            </div>
            <div class="panel-body">
                <div class="chart-lg">
                    <canvas id="districtHouseholdChart"></canvas>
                </div>
            </div>
        </div>

        <div class="panel col-5x">
            <div class="panel-head">
                <div>
                    <h3 class="panel-title">สถานะสวัสดิการ</h3>
                    <div class="panel-sub">ได้รับ / ไม่ได้รับสวัสดิการ</div>
                </div>
                <i class="bi bi-shield-check text-danger fs-4"></i>
            </div>
            <div class="panel-body">
                <div class="chart-lg">
                    <canvas id="welfareChart"></canvas>
                </div>
            </div>
        </div>

    </section>

    <div class="footer-note">
        Phatthalung People Map • ระบบฐานข้อมูลพัทลุงโมเดล
    </div>

</div>

<script>
const labelsFromServer = @json($labels ?? []);
const datasetsFromServer = @json($datasets ?? []);
const sexCounts = @json($sexCountsSafe);

const labels = Array.isArray(labelsFromServer) && labelsFromServer.length
    ? labelsFromServer
    : ['ไม่มีข้อมูล'];

const datasetsRaw = Array.isArray(datasetsFromServer)
    ? JSON.parse(JSON.stringify(datasetsFromServer))
    : [];

const labelShortMap = {
    'ปกติ':'ปกติ',
    'ป่วยเรื้อรังที่ไม่ติดเตียง (เช่น หัวใจ เบาหวาน)':'เรื้อรัง',
    'พิการพึ่งตนเองได้':'พิการ',
    'ผู้ป่วยติดเตียง/พิการพึ่งตัวเองไม่ได้':'ติดเตียง',
    'ไม่ระบุ':'ไม่ระบุ',
};

const palette = {
    'ปกติ':'#0B7F6F',
    'เรื้อรัง':'#ef4444',
    'พิการ':'#0ea5e9',
    'ติดเตียง':'#f59e0b',
    'ไม่ระบุ':'#64748b',
};

const healthDatasets = datasetsRaw.map(ds=>{
    const short = labelShortMap[ds.label] || ds.label;

    return {
        label:short,
        data:Array.isArray(ds.data) && ds.data.length
            ? ds.data.map(v=>Number(v||0))
            : labels.map(()=>0),
        backgroundColor:palette[short] ?? '#64748b',
        borderRadius:12,
        borderSkipped:false,
        barPercentage:.7,
        categoryPercentage:.55,
        maxBarThickness:34,
    };
});

new Chart(document.getElementById('healthChart'),{
    type:'bar',
    data:{
        labels,
        datasets:healthDatasets.length ? healthDatasets : [{
            label:'ไม่มีข้อมูล',
            data:labels.map(()=>0),
            backgroundColor:'#cbd5e1',
            borderRadius:12
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        animation:{duration:1400,easing:'easeOutQuart'},
        plugins:{
            legend:{
                position:'bottom',
                labels:{usePointStyle:true,boxWidth:8,padding:14,font:{family:'Prompt',size:11}}
            }
        },
        scales:{
            x:{
                stacked:false,
                grid:{display:false},
                ticks:{font:{family:'Prompt'}}
            },
            y:{
                beginAtZero:true,
                grid:{color:'#edf2f7'},
                ticks:{font:{family:'Prompt'}}
            }
        }
    }
});

const male = Number(sexCounts['ชาย'] || 0);
const female = Number(sexCounts['หญิง'] || 0);
const sexTotalJs = male + female;

new Chart(document.getElementById('sexChart'),{
    type:'doughnut',
    data:{
        labels:sexTotalJs > 0 ? ['ชาย','หญิง'] : ['ไม่มีข้อมูล'],
        datasets:[{
            data:sexTotalJs > 0 ? [male,female] : [1],
            backgroundColor:sexTotalJs > 0 ? ['#0B7F6F','#0ea5e9'] : ['#cbd5e1'],
            borderWidth:0,
            hoverOffset:8
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        animation:{duration:1400,easing:'easeOutQuart'},
        cutout:'70%',
        plugins:{
            legend:{
                position:'bottom',
                labels:{usePointStyle:true,boxWidth:8,padding:14,font:{family:'Prompt',size:11}}
            }
        }
    }
});

const capRadarData = @json($capRadarSafe);
const capRadarStd = @json($capRadarStdSafe);

const mean = (capRadarData || []).map(v=>Number(v||0));
const sd = (capRadarStd || []).map(v=>Number(v||0));

const meanPlus = mean.map((v,i)=>v+(sd[i]||0));
const meanMinus = mean.map((v,i)=>Math.max(0,v-(sd[i]||0)));

new Chart(document.getElementById('capitalsRadar'),{
    type:'radar',
    data:{
        labels:['ทุนมนุษย์','ทุนกายภาพ','ทุนการเงิน','ทุนธรรมชาติ','ทุนทางสังคม'],
        datasets:[
            {
                label:'Mean + SD',
                data:meanPlus,
                borderColor:'#94a3b8',
                backgroundColor:'rgba(148,163,184,.04)',
                borderWidth:2,
                fill:false,
                pointRadius:2,
                borderDash:[6,4]
            },
            {
                label:'Mean - SD',
                data:meanMinus,
                borderColor:'#cbd5e1',
                backgroundColor:'rgba(203,213,225,.04)',
                borderWidth:2,
                fill:false,
                pointRadius:2,
                borderDash:[6,4]
            },
            {
                label:'Mean',
                data:mean,
                borderColor:'#0B7F6F',
                backgroundColor:'rgba(11,127,111,.18)',
                borderWidth:2.5,
                fill:true,
                pointRadius:3,
                pointHoverRadius:5,
                pointBackgroundColor:'#0B7F6F'
            }
        ]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        animation:{duration:1400,easing:'easeOutQuart'},
        plugins:{
            legend:{
                position:'bottom',
                labels:{usePointStyle:true,boxWidth:8,padding:14,font:{family:'Prompt',size:11}}
            }
        },
        scales:{
            r:{
                beginAtZero:true,
                grid:{color:'#e2e8f0'},
                angleLines:{color:'#e2e8f0'},
                pointLabels:{font:{family:'Prompt',size:13}},
                ticks:{backdropColor:'transparent'}
            }
        }
    }
});


const householdsByDistrict = @json($householdsByDistrict ?? []);
const districtRows = Array.isArray(householdsByDistrict)
    ? householdsByDistrict.slice(0, 12)
    : [];

new Chart(document.getElementById('districtHouseholdChart'),{
    type:'bar',
    data:{
        labels:districtRows.length ? districtRows.map(v=>v.label) : ['ไม่มีข้อมูล'],
        datasets:[{
            label:'ครัวเรือน',
            data:districtRows.length ? districtRows.map(v=>Number(v.total || 0)) : [0],
            backgroundColor:'#0ea5e9',
            borderRadius:12,
            maxBarThickness:32
        }]
    },
    options:{
        indexAxis:'y',
        responsive:true,
        maintainAspectRatio:false,
        animation:{duration:1400,easing:'easeOutQuart'},
        plugins:{
            legend:{display:false}
        },
        scales:{
            x:{
                beginAtZero:true,
                grid:{color:'#edf2f7'},
                ticks:{font:{family:'Prompt'}}
            },
            y:{
                grid:{display:false},
                ticks:{font:{family:'Prompt'}}
            }
        }
    }
});

const welfareReceived = Number(@json($welfareReceived ?? 0));
const welfareNotReceived = Number(@json($welfareNotReceived ?? 0));
const welfareSum = welfareReceived + welfareNotReceived;

new Chart(document.getElementById('welfareChart'),{
    type:'doughnut',
    data:{
        labels:welfareSum > 0 ? ['ได้รับ','ไม่ได้รับ'] : ['ไม่มีข้อมูล'],
        datasets:[{
            data:welfareSum > 0 ? [welfareReceived,welfareNotReceived] : [1],
            backgroundColor:welfareSum > 0 ? ['#0B7F6F','#ef4444'] : ['#cbd5e1'],
            borderWidth:0,
            hoverOffset:10
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        cutout:'72%',
        animation:{duration:1400,easing:'easeOutQuart'},
        plugins:{
            legend:{
                position:'bottom',
                labels:{usePointStyle:true,boxWidth:8,padding:14,font:{family:'Prompt',size:11}}
            }
        }
    }
});



/* countup KPI + loading while filtering */
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.countup').forEach(el => {
        const num = Number(el.dataset.count || 0);

        if (window.countUp && window.countUp.CountUp) {
            const counter = new window.countUp.CountUp(el, num, {
                duration: 1.35,
                separator: ','
            });

            if (!counter.error) {
                counter.start();
                return;
            }
        }

        el.textContent = new Intl.NumberFormat('th-TH').format(num);
    });

    const loading = document.getElementById('loadingOverlay');

    document.querySelectorAll('.filter-card a.dropdown-item, .filter-card a.btn').forEach(el => {
        el.addEventListener('click', () => {
            if (loading) loading.style.display = 'flex';
        });
    });
});

</script>

<div id="loadingOverlay">
    <div class="loading-card">
        <div class="spinner-border text-success" role="status"></div>
        <div>กำลังโหลดข้อมูล...</div>
    </div>
</div>

</body>
</html>