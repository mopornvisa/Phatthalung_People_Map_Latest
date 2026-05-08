{{-- resources/views/economy.blade.php --}}

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">

<title>ข้อมูลด้านเศรษฐกิจ จังหวัดพัทลุง</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@php
$economyBaht = fn($value) => number_format((float)($value ?? 0), 2);

$isChecked = function ($value) {
    return !is_null($value)
        && trim((string)$value) !== ''
        && (int)$value !== 0;
};

$agricultureCrops = function ($row) use ($isChecked) {

    $items = [];

    // 1 ทำนา
    if ($isChecked($row->c1_1_1 ?? null)) {
        $items[] = 'ทำนา';
    }

    // 2 สวนผัก
    if ($isChecked($row->c1_1_2 ?? null)) {

        $text = 'ทำสวนผัก';

        if (!empty($row->c1_1_2_0)) {
            $text .= ' (' . $row->c1_1_2_0 . ')';
        }

        $items[] = $text;
    }

    // 3 สวนผลไม้
    if ($isChecked($row->c1_1_3 ?? null)) {

        $text = 'ทำสวนผลไม้';

        if (!empty($row->c1_1_3_0)) {
            $text .= ' (' . $row->c1_1_3_0 . ')';
        }

        $items[] = $text;
    }

    // 4 พืชไร่
    if ($isChecked($row->c1_1_4 ?? null)) {
        $items[] = 'พืชไร่ เช่น มันสำปะหลัง อ้อย ถั่วเหลือง ถั่วอื่นๆ พริก ฯลฯ';
    }

    // 5 พืชอุตสาหกรรม
    if ($isChecked($row->c1_1_5 ?? null)) {
        $items[] = 'พืชอุตสาหกรรมอื่นๆ เช่น ยางพารา ปาล์มน้ำมัน';
    }

    if (count($items)) {
        return implode(' / ', $items);
    }

    if ((int)($row->c1_1_0 ?? -1) === 0) {
        return 'ไม่ได้เพาะปลูกพืชเกษตร';
    }

    return '-';
};

$livestockText = function ($row) use ($isChecked) {

    $items = [];

    // 1 สัตว์ปีก
    if ($isChecked($row->c1_2_1 ?? null)) {
        $items[] = 'สัตว์ปีก (เป็ด/ไก่/นก)';
    }

    // 2 หมู แพะ
    if ($isChecked($row->c1_2_2 ?? null)) {
        $items[] = 'หมู/แพะ/แกะ/ลา/ล่อ';
    }

    // 3 วัวควาย
    if ($isChecked($row->c1_2_3 ?? null)) {
        $items[] = 'วัว/ควาย/ม้า';
    }

    // 4 อื่นๆ
    if ($isChecked($row->c1_2_4 ?? null)) {

        $text = 'อื่นๆ';

        if (!empty($row->c1_2_4_0)) {
            $text .= ' (' . $row->c1_2_4_0 . ')';
        }

        $items[] = $text;
    }

    if (count($items)) {
        return implode(' / ', $items);
    }

    if ((int)($row->c1_2_0 ?? -1) === 0) {
        return 'ไม่ได้ทำปศุสัตว์';
    }

    return '-';
};

$fisheryText = function ($row) use ($isChecked) {

    $items = [];

    // น้ำเค็ม
    if ($isChecked($row->c1_3_1 ?? null)) {
        $items[] = 'ประมงน้ำเค็ม';
    }

    // น้ำจืด
    if ($isChecked($row->c1_3_2 ?? null)) {
        $items[] = 'ประมงน้ำจืด';
    }

    if (count($items)) {
        return implode(' / ', $items);
    }

    if ((int)($row->c1_3_0 ?? -1) === 0) {
        return 'ไม่ได้ทำประมง';
    }

    return '-';
};
@endphp
<style>
body{
    font-family:'Prompt',sans-serif;
    margin:0;
    color:#0f172a;
    background:
        radial-gradient(circle at 10% 5%,rgba(14,165,164,.20),transparent 28%),
        radial-gradient(circle at 95% 10%,rgba(45,116,218,.15),transparent 30%),
        linear-gradient(135deg,#dff5f7 0%,#ecf9f3 48%,#f6fbff 100%);
}

.page-wrap{
    max-width:1500px;
    margin:30px auto;
    padding:0 18px 36px;
}

.eco-page{
    background:rgba(255,255,255,.88);
    border:1px solid rgba(255,255,255,.75);
    border-radius:30px;
    padding:22px;
    box-shadow:0 18px 38px rgba(15,23,42,.09);
    backdrop-filter:blur(8px);
}

.eco-hero{
    position:relative;
    overflow:hidden;
    background:
        radial-gradient(circle at 85% 15%,rgba(255,255,255,.25),transparent 25%),
        linear-gradient(135deg,#0B7F6F 0%,#0B5B6B 55%,#064E45 100%);
    border-radius:28px;
    padding:26px;
    color:#fff;
    margin-bottom:20px;
    box-shadow:0 18px 38px rgba(11,127,111,.25);
}

.eco-hero::before{
    content:'';
    position:absolute;
    width:180px;
    height:180px;
    border-radius:50%;
    right:-60px;
    bottom:-70px;
    background:rgba(255,255,255,.12);
}

.eco-hero::after{
    content:'';
    position:absolute;
    width:90px;
    height:90px;
    border-radius:50%;
    right:90px;
    top:-30px;
    background:rgba(255,255,255,.10);
}

.eco-hero>*{
    position:relative;
    z-index:1;
}

.hero-icon{
    width:64px;
    height:64px;
    border-radius:22px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:rgba(255,255,255,.18);
    border:1px solid rgba(255,255,255,.25);
    font-size:32px;
}

.hero-title{
    font-size:26px;
    font-weight:800;
    margin:0;
}

.hero-sub{
    font-size:13px;
    opacity:.92;
    margin-top:6px;
}

.eco-chip{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:rgba(255,255,255,.16);
    border:1px solid rgba(255,255,255,.28);
    color:#fff;
    padding:11px 16px;
    border-radius:999px;
    font-size:14px;
    font-weight:700;
}

.filter-card,
.kpi-card,
.chart-card,
.table-panel{
    background:linear-gradient(135deg,#fff,#f9fcff);
    border:1px solid #dcecf2;
    border-radius:24px;
    box-shadow:0 10px 24px rgba(15,23,42,.06);
}

.filter-card{
    padding:18px;
    margin-bottom:18px;
}

.filter-title{
    font-weight:800;
    color:#0B5B6B;
    display:flex;
    align-items:center;
    gap:8px;
    margin-bottom:14px;
}

.form-label{
    font-size:12px;
    font-weight:700;
    color:#64748b;
    margin-bottom:6px;
}

.eco-filter{
    border:1px solid #d8e8ef;
    border-radius:15px;
    min-height:45px;
    font-size:13px;
}

.eco-filter:focus{
    border-color:#0ea5a4;
    box-shadow:0 0 0 .15rem rgba(14,165,164,.12)!important;
}

.btn-success{
    background:linear-gradient(135deg,#16a34a,#22c55e);
    border:none;
    font-weight:700;
    transition:all .2s ease;
    border-radius:15px;
}

.btn-success:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 24px rgba(34,197,94,.30);
}

.btn-clear{
    min-height:45px;
    border-radius:15px;
    font-size:13px;
    font-weight:700;
    border:1px solid #d8e8ef;
    background:#fff;
}

.kpi-card{
    padding:18px;
    height:100%;
    min-height:125px;
    position:relative;
    overflow:hidden;
    background:linear-gradient(135deg,#ffffff 0%,#f6fffb 100%);
    border:1px solid #d7eee8;
    transition:.2s ease;
}

.kpi-card:hover{
    transform:translateY(-4px);
    box-shadow:0 20px 40px rgba(11,127,111,.15);
    border-color:#9ddccd;
}

.kpi-card::after{
    content:'';
    width:95px;
    height:95px;
    border-radius:50%;
    position:absolute;
    right:-28px;
    top:-28px;
    background:linear-gradient(135deg,rgba(11,127,111,.16),rgba(11,91,107,.08));
}

.kpi-label{
    color:#64748b;
    font-size:12px;
    font-weight:700;
    display:flex;
    align-items:center;
    gap:7px;
    position:relative;
    z-index:1;
}

.kpi-value{
    font-size:26px;
    font-weight:800;
    color:#0B5B6B;
    margin-top:8px;
    line-height:1.15;
    position:relative;
    z-index:1;
}

.kpi-unit{
    font-size:12px;
    color:#94a3b8;
    margin-top:6px;
    position:relative;
    z-index:1;
}

.chart-grid{
    display:grid;
    grid-template-columns:1.15fr .85fr;
    gap:18px;
    margin-bottom:18px;
}

.chart-card{
    position:relative;
    overflow:hidden;
    background:linear-gradient(135deg,#ffffff,#f7fffb);
    border:1px solid #d7eee8;
    border-radius:28px;
    padding:20px;
    box-shadow:0 14px 30px rgba(15,23,42,.07);
    transition:all .25s ease;
}

.chart-card:hover{
    transform:translateY(-6px) scale(1.01);
    box-shadow:0 25px 50px rgba(11,127,111,.18);
    border-color:#9ddccd;
}

.chart-card::before{
    content:'';
    position:absolute;
    width:150px;
    height:150px;
    border-radius:50%;
    right:-60px;
    top:-65px;
    background:linear-gradient(135deg,rgba(11,127,111,.13),rgba(45,116,218,.09));
}

.chart-header{
    position:relative;
    z-index:2;
    display:flex;
    justify-content:space-between;
    gap:12px;
    margin-bottom:14px;
}

.chart-title{
    font-size:16px;
    font-weight:800;
    color:#0B5B6B;
    display:flex;
    align-items:center;
    gap:8px;
}

.chart-sub{
    font-size:12px;
    color:#64748b;
    margin-top:5px;
}

.chart-badge{
    height:max-content;
    white-space:nowrap;
    font-size:12px;
    font-weight:800;
    color:#0B7F6F;
    background:#e8faf5;
    border:1px solid #bfe8df;
    padding:8px 12px;
    border-radius:999px;
}

.chart-box{
    position:relative;
    z-index:2;
    width:100%;
    height:245px;
}

.chart-box.lg{
    height:245px;
}

.table-panel{
    overflow:hidden;
    margin-top:18px;
}

.table-head{
    padding:16px 18px;
    border-bottom:1px solid #e5edf4;
    background:linear-gradient(135deg,#f8fcff,#f3fbf8);
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}

.table-title{
    font-size:16px;
    font-weight:800;
    color:#0f172a;
}

.table-responsive{
    padding:0 14px 12px;
    overflow-x:auto!important;
}

.eco-table{
    min-width:1200px;
    font-size:13px;
    margin-bottom:0;
}

.eco-table thead th{
    background:#e6f4f1!important;
    border:1px solid #b7ddd5!important;
    text-align:center;
    white-space:nowrap;
    vertical-align:middle;
    color:#0B5B6B;
    font-weight:800;
    padding:9px 7px!important;
}

.eco-table tbody td{
    border:1px solid #d5dfeb;
    padding:.75rem!important;
    white-space:normal;
    vertical-align:middle;
    font-size:13px;
    line-height:1.7;
}

.eco-table tbody tr:nth-child(even) td{
    background:#f8fbff;
}

.eco-table tbody tr:hover td{
    background:#eefdf8!important;
}

.income-box{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:14px;
    padding:10px;
    margin-bottom:8px;
}

.pagination{
    gap:6px;
}

.page-link{
    border-radius:999px!important;
    padding:6px 12px;
    border:1px solid #d7e2ea;
    color:#0B7F6F;
    font-size:13px;
}

.page-item.active .page-link{
    background:#0B7F6F;
    border-color:#0B7F6F;
    color:#fff;
}

@media(max-width:992px){
    .chart-grid{
        grid-template-columns:1fr;
    }

    .chart-box{
        height:245px;
    }
}


    @media(max-width:768px){

    .eco-page{
        padding:14px;
        border-radius:24px;
    }

    .hero-title{
        font-size:19px;
    }

    .eco-hero{
        padding:18px;
    }

    .chart-box,
    .chart-box.lg{
        height:230px;
    }

    .kpi-value{
        font-size:23px;
    }
}
.detail-card{
    background:linear-gradient(135deg,#ffffff,#f7fffb);
    border:1px solid #d7eee8;
    border-radius:20px;
    padding:16px;
    box-shadow:0 8px 18px rgba(15,23,42,.06);
}

.detail-title{
    font-size:14px;
    font-weight:800;
    color:#0B5B6B;
    margin-bottom:8px;
    display:flex;
    align-items:center;
    gap:8px;
}

.detail-text{
    font-size:14px;
    color:#334155;
    line-height:1.8;
}

.income-detail{
    height:100%;
    border-radius:20px;
    padding:16px;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    text-align:center;
}

.income-label{
    font-size:12px;
    color:#64748b;
    font-weight:700;
    min-height:38px;
}

.income-value{
    font-size:21px;
    font-weight:800;
    color:#0B5B6B;
    margin-top:8px;
}

.income-unit{
    font-size:12px;
    color:#94a3b8;
}
.economy-filter-dropdown .dropdown-menu{
    min-width:320px;
    max-height:60vh;
    overflow-y:auto;
}

.economy-filter-dropdown label{
    cursor:pointer;
    background:#fff;
    transition:.15s ease;
}

.economy-filter-dropdown label:hover{
    background:#ecfdf5;
    border-color:#9ddccd!important;
}
.eco-filter-panel{
    padding:22px;
    border-radius:26px;
}

.filter-dropdown-btn{
    min-height:45px;
    border:1px solid #d8e8ef;
    border-radius:15px;
    background:#fff;
    text-align:left;
    font-size:13px;
    font-weight:700;
    color:#334155;
}

.economy-filter-dropdown .dropdown-menu{
    width:100%;
    min-width:340px;
    max-height:55vh;
    overflow-y:auto;
}

.filter-choice{
    display:flex;
    gap:10px;
    align-items:center;
    width:100%;
    padding:10px 12px;
    border:1px solid #e2e8f0;
    border-radius:14px;
    margin-bottom:8px;
    background:#fff;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
}

.filter-choice:hover{
    background:#ecfdf5;
    border-color:#9ddccd;
}
.app-bg{
    min-height:100vh;
    background:
        radial-gradient(circle at 10% 5%,rgba(14,165,164,.20),transparent 28%),
        radial-gradient(circle at 95% 10%,rgba(45,116,218,.15),transparent 30%),
        linear-gradient(135deg,#dff5f7 0%,#ecf9f3 48%,#f6fbff 100%);
}
.loading-overlay{
    position:fixed;
    inset:0;
    background:rgba(15,23,42,.55);
    backdrop-filter:blur(3px);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:99999;
}
.loading-modal{text-align:center;animation:fadeInUp .25s ease;}
.loading-ring{
    width:108px;height:108px;border:7px solid rgba(255,255,255,.95);
    border-radius:50%;margin:0 auto 18px;position:relative;
    box-shadow:0 8px 30px rgba(0,0,0,.18);
    animation:ringPulse 1.4s ease-in-out infinite;
}
.loading-needle{
    position:absolute;width:10px;height:38px;background:#fff;border-radius:999px;
    left:50%;top:50%;transform-origin:center 85%;
    animation:needleSpin 1.2s ease-in-out infinite;
}
.loading-needle::after{
    content:'';position:absolute;bottom:-5px;left:50%;transform:translateX(-50%);
    width:14px;height:14px;background:#fff;border-radius:50%;
}
.loading-text{color:#fff;font-size:16px;font-weight:700;}
@keyframes needleSpin{
    0%{transform:translate(-50%,-85%) rotate(-35deg);}
    50%{transform:translate(-50%,-85%) rotate(45deg);}
    100%{transform:translate(-50%,-85%) rotate(-35deg);}
}
@keyframes ringPulse{
    0%,100%{transform:scale(1);}
    50%{transform:scale(1.03);}
}
@keyframes fadeInUp{
    from{opacity:0;transform:translateY(8px);}
    to{opacity:1;transform:translateY(0);}
}

</style>
</head>

<body class="app-bg">

@include('layouts.topbar')

<div class="page-wrap">
<div class="eco-page">

    <div class="eco-hero">
        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-3">
                <div class="hero-icon">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div>
                    <h1 class="hero-title">ข้อมูลด้านเศรษฐกิจ จังหวัดพัทลุง</h1>
                    <div class="hero-sub">
                        วิเคราะห์ข้อมูลเศรษฐกิจครัวเรือน ภาคเกษตร ปศุสัตว์ ประมง และรายได้นอกภาคเกษตร
                    </div>
                </div>
            </div>

            <div class="eco-chip">
                <i class="bi bi-database-fill"></i>
                {{ number_format($rows->total() ?? 0) }} รายการ
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('economy.index') }}" id="ecoFilterForm">
<div class="filter-card eco-filter-panel">
    <div class="filter-title mb-3">
        <i class="bi bi-sliders"></i>
        ตัวกรองข้อมูลเศรษฐกิจ
    </div>

    <div class="row g-3">

        <div class="col-lg-3 col-md-6">
            <label class="form-label">ปีข้อมูล</label>
            <select name="survey_year" class="form-select eco-filter auto-filter">
                <option value="">ทั้งหมด</option>
                @foreach($years as $year)
                    <option value="{{ $year }}" @selected(request('survey_year') == $year)>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-lg-3 col-md-6">
            <label class="form-label">เลขครัวเรือน</label>
            <input type="text" name="hc" class="form-control eco-filter auto-filter"
                   placeholder="ค้นหาเลขครัวเรือน" value="{{ request('hc') }}">
        </div>

        <div class="col-lg-3 col-md-6">
            <label class="form-label">อำเภอ</label>
            <select name="district_name_thai" class="form-select eco-filter auto-filter">
                <option value="">ทั้งหมด</option>
                @foreach($districts as $district)
                    <option value="{{ $district }}" @selected(request('district_name_thai') == $district)>
                        {{ $district }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-lg-3 col-md-6">
            <label class="form-label">ตำบล</label>
           <select name="tambon_name_thai" class="form-select eco-filter auto-filter">
                <option value="">ทั้งหมด</option>
                @foreach($tambons as $tambon)
                    <option value="{{ $tambon }}" @selected(request('tambon_name_thai') == $tambon)>
                        {{ $tambon }}
                    </option>
                @endforeach
            </select>
        </div>

        @php
            $cropOptions = [
                'none' => 'ไม่ได้เพาะปลูกพืชเกษตร',
                'rice' => 'ทำนา',
                'vegetable' => 'ทำสวนผัก',
                'fruit' => 'ทำสวนผลไม้',
                'field_crop' => 'พืชไร่',
                'industrial' => 'พืชอุตสาหกรรม',
            ];
            $cropSelected = (array) request('crop_type', []);

            $livestockOptions = [
                'none' => 'ไม่ได้ทำปศุสัตว์',
                'poultry' => 'สัตว์ปีก',
                'pig_goat' => 'หมู/แพะ/แกะ/ลา/ล่อ',
                'cattle' => 'วัว/ควาย/ม้า',
                'other' => 'อื่น ๆ',
            ];
            $livestockSelected = (array) request('livestock_type', []);

            $fisheryOptions = [
                'none' => 'ไม่ได้ทำประมง',
                'sea' => 'ประมงน้ำเค็ม',
                'fresh' => 'ประมงน้ำจืด',
            ];
            $fisherySelected = (array) request('fishery_type', []);
        @endphp

        <div class="col-lg-4 col-md-6">
            <label class="form-label">พืชเกษตร</label>
            <div class="dropdown economy-filter-dropdown">
                <button class="btn filter-dropdown-btn dropdown-toggle w-100" type="button"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <i class="bi bi-flower1 text-success me-2"></i>
                    เลือกประเภทพืชเกษตร
                </button>
                <div class="dropdown-menu p-3 border-0 shadow rounded-4">
                    @foreach($cropOptions as $key => $label)
                        <label class="filter-choice">
                            <input class="form-check-input crop-check auto-filter" type="checkbox"
                                   name="crop_type[]" value="{{ $key }}"
                                   @checked(in_array($key, $cropSelected))
                                   onchange="handleExclusiveCheck('crop-check','none',this)">
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <label class="form-label">ปศุสัตว์</label>
            <div class="dropdown economy-filter-dropdown">
                <button class="btn filter-dropdown-btn dropdown-toggle w-100" type="button"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <i class="bi bi-egg-fried text-warning me-2"></i>
                    เลือกประเภทปศุสัตว์
                </button>
                <div class="dropdown-menu p-3 border-0 shadow rounded-4">
                    @foreach($livestockOptions as $key => $label)
                        <label class="filter-choice">
                            <input class="form-check-input livestock-check auto-filter" type="checkbox"
                                   name="livestock_type[]" value="{{ $key }}"
                                   @checked(in_array($key, $livestockSelected))
                                   onchange="handleExclusiveCheck('livestock-check','none',this)">
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <label class="form-label">ประมง</label>
            <div class="dropdown economy-filter-dropdown">
                <button class="btn filter-dropdown-btn dropdown-toggle w-100" type="button"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <i class="bi bi-water text-primary me-2"></i>
                    เลือกประเภทประมง
                </button>
                <div class="dropdown-menu p-3 border-0 shadow rounded-4">
                    @foreach($fisheryOptions as $key => $label)
                        <label class="filter-choice">
                            <input class="form-check-input fishery-check auto-filter" type="checkbox"
                                   name="fishery_type[]" value="{{ $key }}"
                                   @checked(in_array($key, $fisherySelected))
                                   onchange="handleExclusiveCheck('fishery-check','none',this)">
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <label class="form-label">รายได้ขั้นต่ำ</label>
            <input type="number" name="income_min" class="form-control eco-filter auto-filter"
                   value="{{ request('income_min') }}" placeholder="เช่น 10000">
           </div>

          <div class="col-lg-3 col-md-6">
            <label class="form-label">รายได้สูงสุด</label>
            <input type="number" name="income_max" class="form-control eco-filter auto-filter"
                   value="{{ request('income_max') }}" placeholder="เช่น 50000">
        </div>

        <div class="col-lg-6 col-md-12">
    <div class="d-flex align-items-end gap-2 h-100">

      <div class="d-flex align-items-end gap-2 h-100">

    <button type="submit"
            class="btn btn-success d-flex align-items-center justify-content-center"
            style="
                min-width:120px;
                height:42px;
                border-radius:12px;
                font-size:13px;
                font-weight:700;
            ">

        <i class="bi bi-search me-1"></i>
        ค้นหา

    </button>

    <a href="{{ route('economy.index') }}"
       class="btn btn-light d-flex align-items-center justify-content-center"
       style="
            min-width:120px;
            height:42px;
            border-radius:12px;
            font-size:13px;
            font-weight:700;
            border:1px solid #d8e8ef;
            color:#475569;
            background:#ffffff;
       ">

        <i class="bi bi-arrow-clockwise me-1"></i>
        ล้างค่า

    </a>

</div>

    </div>
</div>

    </div>
</div>
   


</form>
    <div class="row g-3 mb-3">
        <div class="col-lg-3 col-md-6">
            <div class="kpi-card">
                <div class="kpi-label"><i class="bi bi-house-door-fill text-success"></i>จำนวนครัวเรือน</div>
                <div class="kpi-value">{{ number_format($summary->total_households ?? 0) }}</div>
                <div class="kpi-unit">ครัวเรือน</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="kpi-card">
                <div class="kpi-label"><i class="bi bi-wallet2 text-warning"></i>รายได้นอกภาคเกษตร</div>
                <div class="kpi-value">{{ $economyBaht($summary->income_outside_area ?? 0) }}</div>
                <div class="kpi-unit">บาท/ปี</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="kpi-card">
                <div class="kpi-label"><i class="bi bi-receipt text-danger"></i>ต้นทุนรวม</div>
                <div class="kpi-value">{{ $economyBaht($summary->cost_outside_area ?? 0) }}</div>
                <div class="kpi-unit">บาท/ปี</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="kpi-card">
                <div class="kpi-label"><i class="bi bi-send-heart-fill text-success"></i>ลูกหลานส่งกลับ</div>
                <div class="kpi-value">{{ $economyBaht($summary->income_children ?? 0) }}</div>
                <div class="kpi-unit">บาท/ปี</div>
            </div>
        </div>
    </div>

   <div class="chart-grid">
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <div class="chart-title"><i class="bi bi-flower1"></i> พืชเกษตร</div>
                <div class="chart-sub">จำนวนครัวเรือนตามประเภทพืชเกษตร</div>
            </div>
            <div class="chart-badge">Crops</div>
        </div>
        <div class="chart-box lg">
            <canvas id="cropChart"></canvas>
        </div>
    </div>

    <div class="chart-card">
        <div class="chart-header">
            <div>
                <div class="chart-title"><i class="bi bi-egg-fried"></i> ปศุสัตว์</div>
                <div class="chart-sub">สัดส่วนประเภทปศุสัตว์</div>
            </div>
            <div class="chart-badge">Livestock</div>
        </div>
        <div class="chart-box">
            <canvas id="livestockChart"></canvas>
        </div>
    </div>
</div>

<div class="chart-grid">
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <div class="chart-title"><i class="bi bi-water"></i> ประมง</div>
                <div class="chart-sub">ประมงน้ำเค็มและประมงน้ำจืด</div>
            </div>
            <div class="chart-badge">Fishery</div>
        </div>
        <div class="chart-box">
            <canvas id="fisheryChart"></canvas>
        </div>
    </div>

    <div class="chart-card">
        <div class="chart-header">
            <div>
                <div class="chart-title"><i class="bi bi-cash-stack"></i> รายได้ / ต้นทุน / เงินส่งกลับ</div>
                <div class="chart-sub">เปรียบเทียบมูลค่ารวม บาท/ปี</div>
            </div>
            <div class="chart-badge">Income</div>
        </div>
        <div class="chart-box">
            <canvas id="incomeCompareChart"></canvas>
        </div>
    </div>
</div>

<div class="chart-card mb-3">
    
    <div class="chart-header">
        <div>
            <div class="chart-title"><i class="bi bi-bar-chart-fill"></i> รายได้เฉลี่ยแต่ละอำเภอ</div>
            <div class="chart-sub">รายได้เฉลี่ยนอกภาคเกษตร บาท/ปี</div>
        </div>
        <div class="chart-badge">District</div>
    </div>
    <div class="chart-box lg">
        <canvas id="districtIncomeChart"></canvas>
    </div>
</div>

    <div class="chart-card mb-3">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

    <div>
        <div class="fw-bold fs-5 text-success">
            <i class="bi bi-table me-2"></i>
            รายการข้อมูลด้านเศรษฐกิจ
        </div>

        <div class="text-muted small">
            ข้อมูลเศรษฐกิจครัวเรือน ภาคเกษตร ปศุสัตว์ และประมง
        </div>
    </div>

    <a href="{{ route('economy.export', request()->query()) }}"
       class="btn btn-success rounded-pill px-4 shadow-sm">

        <i class="bi bi-file-earmark-excel-fill me-1"></i>
        Export Excel

    </a>

</div>

        <div class="table-responsive">
            <table class="table eco-table align-middle">
                <thead>
<tr>
    <th>ปี</th>
<th>เลขครัวเรือน</th>
<th>อำเภอ</th>
<th>ตำบล</th>
<th>พืชเกษตร</th>
<th>ปศุสัตว์</th>
<th>ประมง</th>
<th>รายละเอียด</th>
</tr>
</thead>

<tbody>
@forelse($rows as $row)
<tr>
    <td class="text-center">
        <span class="badge rounded-pill bg-success-subtle text-success border">
            {{ $row->survey_year }}
        </span>
    </td>

    <td class="fw-bold">{{ $row->HC }}</td>
    <td>{{ $row->district_name_thai ?? '-' }}</td>
<td>{{ $row->tambon_name_thai ?? '-' }}</td>

  <td style="min-width:320px;">
    <div class="small text-muted fw-medium">
        {!! nl2br(e($agricultureCrops($row))) !!}
    </div>
</td>

    <td>
        <div class="small text-muted">
            {!! nl2br(e($livestockText($row))) !!}
        </div>
    </td>

    <td>
        <div class="small text-muted">
{!! nl2br(e($fisheryText($row))) !!}        </div>
    </td>

    <td class="text-center">

        <button class="btn btn-sm btn-outline-success rounded-pill px-3"
                data-bs-toggle="modal"
                data-bs-target="#detailModal{{ $loop->index }}">

            <i class="bi bi-eye"></i>
            ดูรายละเอียด

        </button>

    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center text-muted py-5">
        ไม่พบข้อมูล
    </td>
</tr>
@endforelse
</tbody>
            </table>
        </div>

        @if($rows instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="py-3">
                <div class="text-center text-muted small mb-2">
                    แสดง {{ $rows->firstItem() }}–{{ $rows->lastItem() }}
                    จาก {{ number_format($rows->total()) }} รายการ
                </div>
                <div class="d-flex justify-content-center">
                    {{ $rows->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

</div>
</div>
@foreach($rows as $row)
<div class="modal fade" id="detailModal{{ $loop->index }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">

            <div class="modal-header border-0 text-white"
                 style="background:linear-gradient(135deg,#0B7F6F,#0B5B6B);">
                <div>
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-house-door-fill me-2"></i>
                        รายละเอียดเศรษฐกิจครัวเรือน
                    </h5>
                    <div class="small opacity-75">
                        เลขครัวเรือน {{ $row->HC }} • ปี {{ $row->survey_year }}
                    </div>
                </div>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row g-4">

                    <div class="col-lg-12">
                        <div class="detail-card">
                            <div class="detail-title">
                                <i class="bi bi-flower1 text-success"></i>
                                พืชเกษตร
                            </div>
                            <div class="detail-text">
                                {{ $agricultureCrops($row) }}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="detail-card">
                            <div class="detail-title">
                                <i class="bi bi-egg-fried text-warning"></i>
                                ปศุสัตว์
                            </div>
                            <div class="detail-text">
                                {{ $livestockText($row) }}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="detail-card">
                            <div class="detail-title">
                                <i class="bi bi-water text-primary"></i>
                                ประมง
                            </div>
                            <div class="detail-text">
                                {{ $fisheryText($row) }}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="income-detail">
                            <div class="income-label">รายได้นอกภาคเกษตร</div>
                            <div class="income-value">{{ $economyBaht($row->c2_1) }}</div>
                            <div class="income-unit">บาท/ปี</div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="income-detail">
                            <div class="income-label">ต้นทุน</div>
                            <div class="income-value text-danger">{{ $economyBaht($row->c2_2) }}</div>
                            <div class="income-unit">บาท/ปี</div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="income-detail">
                            <div class="income-label">ลูกหลานส่งกลับ</div>
                            <div class="income-value text-success">{{ $economyBaht($row->c2_3) }}</div>
                            <div class="income-unit">บาท/ปี</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endforeach
<script>
Chart.defaults.font.family = 'Prompt';
Chart.defaults.color = '#475569';

const cropChartData = @json($cropChart ?? []);
const livestockChartData = @json($livestockChart ?? []);
const fisheryChartData = @json($fisheryChart ?? []);
const incomeCompareData = @json($incomeCompareChart ?? []);
const districtIncome = @json($districtIncome ?? []);

const palette = {
    green: '#0B7F6F',
    teal: '#0B5B6B',
    mint: '#2DD4BF',
    amber: '#F59E0B',
    gold: '#FBBF24',
    blue: '#2D74DA',
    sky: '#38BDF8',
    purple: '#8B5CF6',
    red: '#EF4444'
};

const tooltipStyle = {
    backgroundColor:'rgba(15,23,42,.96)',
    titleFont:{family:'Prompt',size:14,weight:'700'},
    bodyFont:{family:'Prompt',size:13},
    padding:14,
    cornerRadius:14
};

function makeBar(id, data, colors, horizontal = false, suffix = ' ครัวเรือน') {
    new Chart(document.getElementById(id), {
        type:'bar',
        data:{
            labels:data.map(x => x.name ?? x.district ?? x.label ?? '-'),
            datasets:[{
                label:'จำนวน',
                data:data.map(x => Number(x.value ?? x.avg_income ?? 0)),
                backgroundColor:colors,
                borderRadius:14
            }]
        },
        options:{
            indexAxis: horizontal ? 'y' : 'x',
            responsive:true,
            maintainAspectRatio:false,
            plugins:{
                legend:{display:false},
                tooltip:{
                    ...tooltipStyle,
                    callbacks:{
                        title:ctx => ctx[0].label,
                        label:ctx => Number(ctx.raw).toLocaleString() + suffix
                    }
                }
            },
            scales: horizontal ? {
                x:{
                    beginAtZero:true,
                    grid:{color:'rgba(148,163,184,.18)'},
                    ticks:{callback:v => Number(v).toLocaleString()}
                },
                y:{
                    type:'category',
                    grid:{display:false}
                }
            } : {
                x:{
                    type:'category',
                    grid:{display:false}
                },
                y:{
                    beginAtZero:true,
                    grid:{color:'rgba(148,163,184,.18)'},
                    ticks:{callback:v => Number(v).toLocaleString()}
                }
            }
        }
    });
}
if(document.getElementById('cropChart')){
    makeBar('cropChart', cropChartData, [
        palette.green,
        palette.teal,
        palette.mint,
        palette.amber,
        palette.gold
    ], true);
}

if(document.getElementById('fisheryChart')){
    makeBar('fisheryChart', fisheryChartData, [
        palette.blue,
        palette.sky
    ], true);
}

if(document.getElementById('incomeCompareChart')){
    makeBar('incomeCompareChart', incomeCompareData, [
        palette.green,
        palette.red,
        palette.blue
    ], false, ' บาท');
}

if(document.getElementById('districtIncomeChart')){
    makeBar('districtIncomeChart', districtIncome, palette.amber, true, ' บาท/ปี');
}

if(document.getElementById('livestockChart')){

new Chart(document.getElementById('livestockChart'), {
    type:'doughnut',
    data:{
        labels:livestockChartData.map(x => x.name),
        datasets:[{
            data:livestockChartData.map(x => Number(x.value)),
            backgroundColor:[
                palette.green,
                palette.amber,
                palette.blue,
                palette.purple
            ],
            borderColor:'#fff',
            borderWidth:3,
            hoverOffset:8
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        cutout:'62%',
        plugins:{
            legend:{
                position:'bottom',
                labels:{
                    usePointStyle:true,
                    padding:14,
                    font:{family:'Prompt',size:12}
                }
            },
            tooltip:{
                ...tooltipStyle,
                callbacks:{
                    label:ctx =>
                        ctx.label + ': ' +
                        Number(ctx.raw).toLocaleString() +
                        ' ครัวเรือน'
                }
            }
        }
    }
});
}
function handleExclusiveCheck(className, noneValue, current) {
    const checks = document.querySelectorAll('.' + className);

    if (current.value === noneValue && current.checked) {
        checks.forEach(cb => {
            if (cb.value !== noneValue) cb.checked = false;
        });
    } else if (current.checked) {
        checks.forEach(cb => {
            if (cb.value === noneValue) cb.checked = false;
        });
    }
}
document.addEventListener('DOMContentLoaded', function(){

    const ecoForm = document.getElementById('ecoFilterForm');
    const loadingOverlay = document.getElementById('loadingOverlay');

    if(ecoForm){

       ecoForm.addEventListener('submit', function(e){

    e.preventDefault();

    if(loadingOverlay){
        loadingOverlay.style.display = 'flex';
    }

    setTimeout(() => {
        ecoForm.submit();
    }, 200);

});

    }

   

});

</script>

<div id="loadingOverlay" class="loading-overlay">
    <div class="loading-modal">
        <div class="loading-ring">
            <div class="loading-needle"></div>
        </div>

        <div class="loading-text">
            กำลังประมวลผล
        </div>
    </div>
</div>


</body>
</html>