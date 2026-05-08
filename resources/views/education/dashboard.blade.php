{{-- resources/views/education/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>ข้อมูลด้านการศึกษา จังหวัดพัทลุง</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body{font-family:'Prompt',sans-serif;margin:0;color:#0f172a;}
.app-bg{min-height:100vh;background:radial-gradient(circle at 10% 5%,rgba(14,165,164,.20),transparent 28%),radial-gradient(circle at 95% 10%,rgba(45,116,218,.15),transparent 30%),linear-gradient(135deg,#dff5f7 0%,#ecf9f3 48%,#f6fbff 100%);}
.page-wrap{max-width:1500px;margin:30px auto;padding:0 18px 36px;}
.edu-page{background:rgba(255,255,255,.88);border:1px solid rgba(255,255,255,.75);border-radius:30px;padding:22px;box-shadow:0 18px 38px rgba(15,23,42,.09);backdrop-filter:blur(8px);}

.hero{position:relative;overflow:hidden;background:radial-gradient(circle at 85% 15%,rgba(255,255,255,.25),transparent 25%),linear-gradient(135deg,#0B7F6F 0%,#0B5B6B 55%,#064E45 100%);border-radius:28px;padding:26px;color:#fff;margin-bottom:20px;box-shadow:0 18px 38px rgba(11,127,111,.25);}
.hero::before{content:'';position:absolute;width:180px;height:180px;border-radius:50%;right:-60px;bottom:-70px;background:rgba(255,255,255,.12);}
.hero::after{content:'';position:absolute;width:90px;height:90px;border-radius:50%;right:90px;top:-30px;background:rgba(255,255,255,.10);}
.hero>*{position:relative;z-index:1;}
.hero-icon{width:64px;height:64px;border-radius:22px;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.25);font-size:32px;}
.hero-title{font-size:26px;font-weight:800;margin:0;}
.hero-sub{font-size:13px;opacity:.92;margin-top:6px;}
.edu-chip{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.28);color:#fff;padding:9px 14px;border-radius:999px;font-size:13px;font-weight:700;}

.filter-card,.kpi-card,.risk-card,.table-panel,.chart-card{background:linear-gradient(135deg,#fff,#f9fcff);border:1px solid #dcecf2;border-radius:24px;box-shadow:0 10px 24px rgba(15,23,42,.06);}
.filter-card{padding:18px;margin-bottom:18px;}
.filter-title{font-weight:800;color:#0B5B6B;display:flex;align-items:center;gap:8px;margin-bottom:14px;}
.form-label{font-size:12px;font-weight:700;color:#64748b;margin-bottom:6px;}
.edu-filter{border:1px solid #d8e8ef;border-radius:15px;min-height:45px;font-size:13px;}
.edu-filter:focus{border-color:#0ea5a4;box-shadow:0 0 0 .15rem rgba(14,165,164,.12)!important;}
.btn-clear{min-height:45px;border-radius:15px;font-size:13px;font-weight:700;border:1px solid #d8e8ef;background:#fff;}

.kpi-card{padding:18px;height:100%;min-height:125px;position:relative;overflow:hidden;background:linear-gradient(135deg,#ffffff 0%,#f6fffb 100%);border:1px solid #d7eee8;transition:.2s ease;}
.kpi-card:hover{transform:translateY(-4px);box-shadow:0 20px 40px rgba(11,127,111,.15);border-color:#9ddccd;}
.kpi-card::after{content:'';width:95px;height:95px;border-radius:50%;position:absolute;right:-28px;top:-28px;background:linear-gradient(135deg,rgba(11,127,111,.16),rgba(11,91,107,.08));}
.kpi-label{color:#64748b;font-size:12px;font-weight:700;display:flex;align-items:center;gap:7px;position:relative;z-index:1;}
.kpi-value{font-size:30px;font-weight:800;color:#0B5B6B;margin-top:8px;line-height:1;position:relative;z-index:1;}
.kpi-unit{font-size:12px;color:#94a3b8;margin-top:6px;position:relative;z-index:1;}

.chart-card{padding:18px;height:100%;background:linear-gradient(135deg,#ffffff,#f7fffb);border:1px solid #d7eee8;}
.chart-title{font-size:15px;font-weight:800;color:#0B5B6B;display:flex;align-items:center;gap:8px;margin-bottom:6px;}
.chart-sub{font-size:12px;color:#64748b;margin-bottom:14px;}
.chart-box{position:relative;height:280px;}

.risk-card{padding:16px;margin-bottom:18px;}
.risk-title{font-weight:800;color:#0B5B6B;font-size:15px;margin-bottom:12px;}
.risk-item{border-radius:18px;padding:14px;background:#fff;border:1px solid #e2e8f0;height:100%;}
.risk-item .num{font-size:22px;font-weight:800;}

.table-panel{overflow:hidden;}
.table-head{padding:16px 18px;border-bottom:1px solid #e5edf4;background:linear-gradient(135deg,#f8fcff,#f3fbf8);display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;}
.table-title{font-size:16px;font-weight:800;color:#0f172a;}
.table-responsive{padding:0 14px 12px;overflow-x:auto!important;}
.edu-table{
    min-width:1220px;
    font-size:13px;
    margin-bottom:0;
}
.edu-table thead th{background:#d9e7f5!important;border:1px solid #bfcddd!important;text-align:center;white-space:nowrap;vertical-align:middle;color:#1e293b;font-weight:800;padding:9px 7px!important;}
.edu-table tbody td{border:1px solid #d5dfeb;padding:.75rem!important;white-space:nowrap;vertical-align:middle;font-size:13px;}
.edu-table tbody tr:nth-child(even) td{background:#f8fbff;}
.edu-table tbody tr:hover td{background:#eef7fb;}
.detail-btn{background:linear-gradient(135deg,#0ea5a4,#2d74da);color:#fff;border:none;border-radius:14px;padding:.48rem .8rem;font-size:12px;font-weight:700;}
.detail-btn:hover{color:#fff;opacity:.94;}

.pagination{gap:6px;}
.page-link{border-radius:999px!important;padding:6px 12px;border:1px solid #d7e2ea;color:#0B7F6F;font-size:13px;}
.page-item.active .page-link{background:#0B7F6F;border-color:#0B7F6F;color:#fff;}

.loading-overlay{position:fixed;inset:0;background:rgba(15,23,42,.50);display:none;align-items:center;justify-content:center;z-index:99999;backdrop-filter:blur(3px);}
.loading-box{text-align:center;color:#fff;font-weight:800;}
.spinner-border{width:3rem;height:3rem;}
.modal-header{background:linear-gradient(135deg,#0B7F6F,#0B5B6B);color:#fff;}
.info-box{background:#fff;border:1px solid #e2e8f0;border-radius:18px;padding:14px;height:100%;}
.info-label{font-size:12px;color:#64748b;margin-bottom:4px;}
.info-value{font-weight:700;color:#0f172a;}

@media(max-width:768px){
    .page-wrap{margin:16px auto;padding:0 12px 24px;}
    .edu-page{padding:14px;border-radius:24px;}
    .hero-title{font-size:19px;}
    .hero{padding:18px;}
    .chart-box{height:240px;}
}
.chart-dashboard{margin:20px 0;}
.chart-grid-3{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:18px;
    margin-bottom:18px;
}
.chart-card.modern{
    position:relative;
    overflow:hidden;
    background:linear-gradient(135deg,#ffffff 0%,#f7fffd 100%);
    border:1px solid #d7eee8;
    border-radius:28px;
    padding:20px;
    box-shadow:0 14px 30px rgba(15,23,42,.07);
}
.chart-card.modern::before{
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
.chart-badge.danger{
    color:#dc2626;
    background:#fff1f2;
    border-color:#fecdd3;
}
.chart-box{
    position:relative;
    z-index:2;
    width:100%;
}
.chart-box.md{height:310px;}
.chart-box.lg{height:520px;}
.district-card{padding-bottom:26px;}

@media(max-width:1200px){
    .chart-grid-3{grid-template-columns:1fr 1fr;}
}
@media(max-width:768px){
    .chart-grid-3{grid-template-columns:1fr;}
    .chart-box.md{height:280px;}
    .chart-box.lg{height:430px;}
    .chart-card.modern,
.kpi-card,
.table-panel,
.filter-card{
    transition:all .25s ease;
}

.chart-card.modern:hover{
    transform:translateY(-6px) scale(1.01);
    box-shadow:0 25px 50px rgba(11,127,111,.18);
    border-color:#9ddccd;
}

.kpi-card:hover{
    transform:translateY(-6px) scale(1.02);
    box-shadow:0 24px 44px rgba(11,127,111,.16);
}

.loading-box{
    background:rgba(255,255,255,.10);
    padding:30px 42px;
    border-radius:24px;
    border:1px solid rgba(255,255,255,.20);
    backdrop-filter:blur(12px);
    box-shadow:0 24px 60px rgba(0,0,0,.22);
}

.loading-overlay{
    background:rgba(15,23,42,.66);
}

.edu-table tbody tr{
    transition:.15s ease;
}

.edu-table tbody tr:hover td{
    background:#eefdf8!important;
}

.detail-btn{
    transition:all .2s ease;
    box-shadow:0 8px 18px rgba(45,116,218,.18);
}

.detail-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 14px 28px rgba(45,116,218,.25);
}

.chart-card.modern canvas{
    animation:chartFade .55s ease both;
}

@keyframes chartFade{
    from{opacity:0;transform:translateY(10px);}
    to{opacity:1;transform:translateY(0);}
}
}
.insight-panel{
    background:linear-gradient(135deg,#ffffff 0%,#ecfdf5 100%);
    border:1px solid #bfe8df;
    border-radius:26px;
    padding:18px 20px;
    box-shadow:0 14px 30px rgba(15,23,42,.07);
    margin-bottom:18px;
}

.insight-main{
    display:flex;
    align-items:flex-start;
    gap:14px;
}

.insight-icon{
    width:48px;
    height:48px;
    border-radius:18px;
    background:linear-gradient(135deg,#0B7F6F,#2DD4BF);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    box-shadow:0 12px 24px rgba(11,127,111,.22);
}

.insight-title{
    font-size:16px;
    font-weight:800;
    color:#0B5B6B;
    margin-bottom:4px;
}

.insight-text{
    font-size:13px;
    color:#334155;
    line-height:1.7;
}

.chart-grid-2{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
    margin-bottom:18px;
}

@media(max-width:992px){
    .chart-grid-2{
        grid-template-columns:1fr;
    }
}

/* ===== Balanced chart layout: เหลือกราฟหลัก 2 กราฟ ให้หน้าไม่แน่นเกินไป ===== */
.chart-dashboard{
    margin:18px 0 20px;
}

.chart-grid-balanced{
    display:grid;
    grid-template-columns:1.15fr .85fr;
    gap:18px;
    margin-bottom:18px;
}

.chart-box.balanced{
    height:330px;
}

.compact-insight{
    margin-bottom:18px;
}

.table-panel{
    margin-top:18px;
}

@media(max-width:992px){
    .chart-grid-balanced{
        grid-template-columns:1fr;
    }

    .chart-box.balanced{
        height:300px;
    }
}
.info-box{
    background:rgba(255,255,255,.78);
    border:1px solid #d7eee8;
    border-radius:24px;
    padding:18px;
    box-shadow:0 14px 30px rgba(15,23,42,.06);
}

.btn-success{
    background:linear-gradient(135deg,#16a34a,#22c55e);
    border:none;
    font-weight:700;
    transition:all .2s ease;
}
.btn-success:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 24px rgba(34,197,94,.30);
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
}

.loading-needle{
    position:absolute;
    width:10px;
    height:38px;
    background:#fff;
    border-radius:999px;
    left:50%;
    top:50%;
    transform-origin:center 85%;
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
    background:#fff;
    border-radius:50%;
}

.loading-text{
    color:#fff;
    font-size:16px;
    font-weight:700;
}

@keyframes needleSpin{
    0%{
        transform:translate(-50%,-85%) rotate(-35deg);
    }

    50%{
        transform:translate(-50%,-85%) rotate(45deg);
    }

    100%{
        transform:translate(-50%,-85%) rotate(-35deg);
    }
}

@keyframes ringPulse{
    0%,100%{
        transform:scale(1);
    }

    50%{
        transform:scale(1.03);
    }
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

</style>
</head>

<body class="app-bg">

@include('layouts.topbar')

@php
$educationLevels = [
    0 => 'ไม่ได้เรียน',
    1 => 'ต่ำกว่าประถม',
    2 => 'ประถมศึกษา',
    3 => 'ม.ต้น หรือเทียบเท่า',
    4 => 'ม.ปลาย หรือเทียบเท่า',
    5 => 'ปวช./ประกาศนียบัตร',
    6 => 'ปวส./อนุปริญญา',
    7 => 'ป.ตรี หรือเทียบเท่า',
    8 => 'สูงกว่าปริญญาตรี',
    9 => 'เรียนสายศาสนา',
];

$studyLevels = [
    1 => 'ต่ำกว่าประถม',
    2 => 'ประถมศึกษา',
    3 => 'ม.ต้น หรือเทียบเท่า',
    4 => 'ม.ปลาย หรือเทียบเท่า',
    5 => 'ปวช./ประกาศนียบัตร',
    6 => 'ปวส./อนุปริญญา',
    7 => 'ป.ตรี หรือเทียบเท่า',
    8 => 'สูงกว่าปริญญาตรี',
    9 => 'เรียนสายศาสนา',
];

$educationStatuses = [
    1 => 'ไปเรียนสม่ำเสมอ',
    2 => 'หยุดเรียนเป็นระยะ ๆ',
    3 => 'ออกกลางคัน (Dropout)',
];

$sexMap = [
    1 => 'ชาย',
    2 => 'หญิง',
];

$yesNoMap = [
    0 => 'ไม่ได้',
    1 => 'ได้',
];
@endphp

<div class="page-wrap">
<div class="edu-page">

    <div class="hero">
        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-3">
                <div class="hero-icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div>
                    <h1 class="hero-title">ข้อมูลด้านการศึกษา จังหวัดพัทลุง</h1>
                    <div class="hero-sub">ค้นหาและติดตามข้อมูลการศึกษาของประชาชนในจังหวัดพัทลุง</div>
                </div>
            </div>

            <div class="edu-chip">
                <i class="bi bi-database-fill"></i>
                {{ number_format($total ?? 0) }} รายการ
            </div>
        </div>
    </div>

   {{-- FILTER --}}
<form method="GET" action="{{ route('education.dashboard') }}" id="eduFilterForm">

    <div class="filter-card">

        <div class="filter-title">
            <i class="bi bi-sliders"></i>
            ตัวกรองข้อมูลการศึกษา
        </div>

        <div class="row g-3">

            <div class="col-lg-2 col-md-6">
                <label class="form-label">ปีข้อมูล</label>

                <select name="survey_year" class="form-select edu-filter">

                    <option value="">ทั้งหมด</option>

                    @foreach([2564,2565,2566,2567,2568,2569] as $y)

                        <option value="{{ $y }}"
                            @selected((string)request('survey_year') === (string)$y)>

                            {{ $y }}

                        </option>

                    @endforeach

                </select>
            </div>

            <div class="col-lg-2 col-md-6">

                <label class="form-label">อำเภอ</label>

                <select name="district" class="form-select edu-filter">

                    <option value="">ทั้งหมด</option>

                    @foreach($districtList as $d)

                        @php $d = trim((string)$d); @endphp

                        <option value="{{ $d }}"
                            @selected(trim((string)$district) === $d)>

                            {{ $d }}

                        </option>

                    @endforeach

                </select>
            </div>

            <div class="col-lg-2 col-md-6">

                <label class="form-label">ตำบล</label>

                <select name="subdistrict"
                        class="form-select edu-filter"
                        @if(empty($district)) disabled @endif>

                    <option value="">ทั้งหมด</option>

                    @foreach($subdistrictList as $sd)

                        @php $sd = trim((string)$sd); @endphp

                        <option value="{{ $sd }}"
                            @selected(trim((string)$subdistrict) === $sd)>

                            {{ $sd }}

                        </option>

                    @endforeach

                </select>
            </div>

            <div class="col-lg-2 col-md-6">

                <label class="form-label">เลขครัวเรือน</label>

                <input type="text"
                       name="household_code"
                       value="{{ request('household_code') }}"
                       class="form-control edu-filter"
                       placeholder="ค้นหาเลขครัวเรือน">

            </div>

            <div class="col-lg-2 col-md-6">

                <label class="form-label">ชื่อ</label>

                <input type="text"
                       name="fname"
                       value="{{ request('fname') }}"
                       class="form-control edu-filter"
                       placeholder="ค้นหาชื่อ">

            </div>

            <div class="col-lg-2 col-md-6">

                <label class="form-label">นามสกุล</label>

                <input type="text"
                       name="lname"
                       value="{{ request('lname') }}"
                       class="form-control edu-filter"
                       placeholder="ค้นหานามสกุล">

            </div>

            <div class="col-lg-2 col-md-6">

                <label class="form-label">เลขบัตรประชาชน</label>

                <input type="text"
                       name="cid"
                       value="{{ request('cid') }}"
                       class="form-control edu-filter"
                       placeholder="ค้นหาเลขบัตร">

            </div>

            <div class="col-lg-2 col-md-6">

                <label class="form-label">เพศ</label>

                <select name="sex" class="form-select edu-filter">

                    <option value="">ทั้งหมด</option>

                    <option value="1" @selected(request('sex')==='1')>
                        ชาย
                    </option>

                    <option value="2" @selected(request('sex')==='2')>
                        หญิง
                    </option>

                </select>
            </div>

            <div class="col-lg-2 col-md-6">

                <label class="form-label">พูดภาษาไทย</label>

                <select name="speak_thai" class="form-select edu-filter">

                    <option value="">ทั้งหมด</option>

                    <option value="1" @selected(request('speak_thai')==='1')>
                        ได้
                    </option>

                    <option value="0" @selected(request('speak_thai')==='0')>
                        ไม่ได้
                    </option>

                </select>
            </div>

            <div class="col-lg-2 col-md-6">

                <label class="form-label">อ่านภาษาไทย</label>

                <select name="read_thai" class="form-select edu-filter">

                    <option value="">ทั้งหมด</option>

                    <option value="1" @selected(request('read_thai')==='1')>
                        ได้
                    </option>

                    <option value="0" @selected(request('read_thai')==='0')>
                        ไม่ได้
                    </option>

                </select>
            </div>

            <div class="col-lg-2 col-md-6">

                <label class="form-label">เขียนภาษาไทย</label>

                <select name="write_thai" class="form-select edu-filter">

                    <option value="">ทั้งหมด</option>

                    <option value="1" @selected(request('write_thai')==='1')>
                        ได้
                    </option>

                    <option value="0" @selected(request('write_thai')==='0')>
                        ไม่ได้
                    </option>

                </select>
            </div>

            <div class="col-lg-2 col-md-6">

                <label class="form-label">การศึกษาสูงสุด</label>

                <select name="education_level" class="form-select edu-filter">

                    <option value="">ทั้งหมด</option>

                    @foreach($educationLevels as $key => $label)

                        <option value="{{ $key }}"
                            @selected((string)request('education_level') === (string)$key)>

                            {{ $label }}

                        </option>

                    @endforeach

                </select>
            </div>

            <div class="col-lg-2 col-md-6">

                <label class="form-label">สถานภาพ</label>

                <select name="education_status" class="form-select edu-filter">

                    <option value="">ทั้งหมด</option>

                    @foreach($educationStatuses as $key => $label)

                        <option value="{{ $key }}"
                            @selected((string)request('education_status') === (string)$key)>

                            {{ $label }}

                        </option>

                    @endforeach

                </select>
            </div>

            <div class="col-lg-4 col-md-12">

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

                    <a href="{{ route('education.dashboard') }}"
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

        <div class="small text-muted mt-3 pt-3 border-top">

            <i class="bi bi-lightning-charge-fill text-success me-1"></i>

            เลือกอำเภอแล้วระบบจะแสดงตำบลของอำเภอนั้นอัตโนมัติ

        </div>

    </div>

</form>
           
                    
    <div class="row g-3 mb-3">
        <div class="col-lg-2 col-md-4 col-6">
            <div class="kpi-card">
                <div class="kpi-label"><i class="bi bi-people-fill text-primary"></i>ประชากรทั้งหมด</div>
                <div class="kpi-value">{{ number_format($total ?? 0) }}</div>
                <div class="kpi-unit">คน</div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-6">
            <div class="kpi-card">
                <div class="kpi-label"><i class="bi bi-chat-dots-fill text-success"></i>พูดไทยได้</div>
                <div class="kpi-value">{{ number_format($speakThai ?? 0) }}</div>
                <div class="kpi-unit">คน</div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-6">
            <div class="kpi-card">
                <div class="kpi-label"><i class="bi bi-book-fill text-success"></i>อ่านไทยได้</div>
                <div class="kpi-value">{{ number_format($readThai ?? 0) }}</div>
                <div class="kpi-unit">คน</div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-6">
            <div class="kpi-card">
                <div class="kpi-label"><i class="bi bi-book text-danger"></i>อ่านไทยไม่ได้</div>
                <div class="kpi-value text-danger">{{ number_format($cannotReadThai ?? 0) }}</div>
                <div class="kpi-unit">คน</div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-6">
            <div class="kpi-card">
                <div class="kpi-label"><i class="bi bi-pencil-square text-warning"></i>เขียนไทยไม่ได้</div>
                <div class="kpi-value text-warning">{{ number_format($cannotWriteThai ?? 0) }}</div>
                <div class="kpi-unit">คน</div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-6">
            <div class="kpi-card">
                <div class="kpi-label"><i class="bi bi-person-x-fill text-danger"></i>ออกกลางคัน</div>
                <div class="kpi-value text-danger">{{ number_format($dropout ?? 0) }}</div>
                <div class="kpi-unit">คน</div>
            </div>
        </div>
    </div>

{{-- CHART DASHBOARD --}}
<div class="chart-dashboard">

    <div class="insight-panel compact-insight">
        <div class="insight-main">
            <div class="insight-icon">
                <i class="bi bi-lightbulb-fill"></i>
            </div>
            <div>
                <div class="insight-title">Insight สรุปข้อมูลการศึกษา</div>
                <div class="insight-text">
                    อำเภอที่ควรติดตามมากที่สุดคือ
                    <strong>{{ $autoInsight['district'] ?? '-' }}</strong>
                    พบกลุ่มเสี่ยงรวม
                    <strong>{{ number_format($autoInsight['risk_total'] ?? 0) }}</strong>
                    รายการ
                    <span class="text-muted">
                        (อ่านไม่ได้ {{ number_format($autoInsight['cannot_read'] ?? 0) }},
                        เขียนไม่ได้ {{ number_format($autoInsight['cannot_write'] ?? 0) }},
                        ออกกลางคัน {{ number_format($autoInsight['dropout'] ?? 0) }})
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="chart-grid-balanced">
        <div class="chart-card modern">
            <div class="chart-header">
                <div>
                    <div class="chart-title">
                        <i class="bi bi-graph-up-arrow"></i>
                        แนวโน้มกลุ่มเสี่ยงรายปี
                    </div>
                    <div class="chart-sub">อ่านไม่ได้ / เขียนไม่ได้ / ออกกลางคัน</div>
                </div>
                <div class="chart-badge">Trend</div>
            </div>
            <div class="chart-box balanced">
                <canvas id="trendYearChart"></canvas>
            </div>
        </div>

        <div class="chart-card modern">
            <div class="chart-header">
                <div>
                    <div class="chart-title">
                        <i class="bi bi-trophy-fill"></i>
                        Top 5 อำเภอที่ควรติดตาม
                    </div>
                    <div class="chart-sub">เรียงจากจำนวนกลุ่มเสี่ยงรวม</div>
                </div>
                <div class="chart-badge danger">Top Risk</div>
            </div>
            <div class="chart-box balanced">
                <canvas id="topRiskDistrictChart"></canvas>
            </div>
        </div>
    </div>

</div>

    <div class="table-panel">
        <div class="table-head">
            <div>
                <div class="table-title">รายการข้อมูลการศึกษารายบุคคล</div>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="edu-chip" style="background:#eefaf7;color:#0B5B6B;border-color:#bfe8df;">
                    พบข้อมูล <strong>{{ number_format($rows->total() ?? 0) }}</strong> รายการ
                </span>

                <a href="{{ route('education.export', request()->query()) }}"
                   class="btn btn-success rounded-pill px-4 shadow-sm">
                    <i class="bi bi-file-earmark-excel-fill me-1"></i>
                    Export Excel
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table edu-table align-middle">
                <thead>
<tr>
    <th>ปี</th>
    <th>เลขครัวเรือน</th>
    <th>ชื่อ - นามสกุล / เลขบัตร</th>
    <th>ที่อยู่</th>
    <th>อายุ</th>
    <th>เพศ</th>
    <th>สถานะติดตาม</th>
    <th>รายละเอียด</th>
</tr>
</thead>
                  
                <tbody>
                @forelse($rows as $r)
                    @php
                        $sexLabel = $sexMap[(int)($r->a4 ?? 0)] ?? '-';
                        $speakLabel = $yesNoMap[(int)($r->a9_1 ?? -1)] ?? '-';
                        $readLabel = $yesNoMap[(int)($r->a9_2 ?? -1)] ?? '-';
                        $writeLabel = $yesNoMap[(int)($r->a10 ?? -1)] ?? '-';
                        $eduLabel = $educationLevels[(int)($r->a11 ?? -1)] ?? '-';
                        $studyLabel = $studyLevels[(int)($r->a12 ?? -1)] ?? '-';
                        $statusLabel = $educationStatuses[(int)($r->a13 ?? -1)] ?? '-';
                    @endphp

                    <tr>
    <td class="fw-semibold">{{ $r->survey_year ?? '-' }}</td>

    <td>
        <div class="fw-bold">{{ $r->HC ?? '-' }}</div>
        <div class="text-muted small">ลำดับในครัวเรือน {{ $r->a1 ?? '-' }}</div>
    </td>

    <td>
        <div class="fw-bold">{{ $r->a2_2 ?? '-' }} {{ $r->a2_3 ?? '' }}</div>
        <div class="text-muted small">{{ $r->popid ?? '-' }}</div>
    </td>

    <td>
        <div class="fw-semibold">
            บ้านเลขที่ {{ $r->MBNO ?? '-' }}
            หมู่ที่ {{ $r->MB ?? '-' }}
            {{ $r->MM ?? '-' }}
        </div>
        <div class="text-muted small">
            ตำบล{{ $r->tambon_name_thai ?? '-' }}
            อำเภอ{{ $r->district_name_thai ?? '-' }}
            จังหวัดพัทลุง
            {{ $r->POSTCODE ?? '-' }}
        </div>
    </td>

    <td>{{ $r->a3_1 ?? '-' }}</td>
    <td>{{ $sexLabel }}</td>

    <td>
        @if((string)$r->a9_2 === '0' || (string)$r->a10 === '0' || (int)($r->a13 ?? 0) === 3)
            <span class="badge rounded-pill bg-danger-subtle text-danger border">
                ควรติดตาม
            </span>
        @else
            <span class="badge rounded-pill bg-success-subtle text-success border">
                ปกติ
            </span>
        @endif
    </td>

    <td>
        <button type="button"
                class="detail-btn"
                data-bs-toggle="modal"
                data-bs-target="#educationDetailModal"
                data-a1="{{ $r->a1 ?? '-' }}"
                data-year="{{ $r->survey_year ?? '-' }}"
                data-hc="{{ $r->HC ?? '-' }}"
                data-name="{{ trim(($r->a2_2 ?? '').' '.($r->a2_3 ?? '')) }}"
                data-popid="{{ $r->popid ?? '-' }}"
                data-district="{{ $r->district_name_thai ?? '-' }}"
                data-subdistrict="{{ $r->tambon_name_thai ?? '-' }}"
                data-house="{{ $r->MBNO ?? '-' }}"
                data-village-no="{{ $r->MB ?? '-' }}"
                data-village-name="{{ $r->MM ?? '-' }}"
                data-postcode="{{ $r->POSTCODE ?? '-' }}"
                data-age="{{ $r->a3_1 ?? '-' }}"
                data-sex="{{ $sexLabel }}"
                data-speak="{{ $speakLabel }}"
                data-read="{{ $readLabel }}"
                data-write="{{ $writeLabel }}"
                data-edu="{{ $eduLabel }}"
                data-study="{{ $studyLabel }}"
                data-status="{{ $statusLabel }}"
                data-reason="{{ $r->a13_1 ?? '-' }}">
            <i class="bi bi-eye me-1"></i> ดูรายละเอียด
        </button>
    </td>
</tr>
                      
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">ไม่พบข้อมูล</td>
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

<div class="modal fade" id="educationDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-5 overflow-hidden">

            <div class="modal-header border-0 text-white"
                 style="background:linear-gradient(135deg,#0B7F6F,#0B5B6B);padding:22px 26px;">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:54px;height:54px;border-radius:20px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;font-size:26px;">
                        <i class="bi bi-person-vcard-fill"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5">รายละเอียดข้อมูลด้านการศึกษา</div>
                        <div style="font-size:13px;opacity:.88;">ข้อมูลรายบุคคลและข้อมูลพื้นที่/ที่อยู่</div>
                    </div>
                </div>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" style="background:linear-gradient(135deg,#f6fbff,#ecfdf5);padding:22px;">
                <div class="row g-3">

                    <div class="col-lg-4">
                        <div class="info-box h-100">
                            <div class="fw-bold text-success mb-3">
                                <i class="bi bi-person-fill me-1"></i> ข้อมูลบุคคล
                            </div>

                            <div class="p-3 rounded-4 bg-white border mb-3">
                                <div class="info-label">ชื่อ - นามสกุล</div>
                                <div class="info-value fs-5" id="m_name">-</div>
                                <div class="text-muted small font-monospace mt-1" id="m_popid">-</div>
                            </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="p-3 rounded-4 bg-white border">
                                        <div class="info-label">ปีข้อมูล</div>
                                        <div class="info-value" id="m_year">-</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-4 bg-white border">
                                        <div class="info-label">ลำดับในครัวเรือน</div>
                                        <div class="info-value" id="m_a1">-</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-4 bg-white border">
                                        <div class="info-label">อายุ</div>
                                        <div class="info-value"><span id="m_age">-</span> ปี</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-4 bg-white border">
                                        <div class="info-label">เพศ</div>
                                        <div class="info-value" id="m_sex">-</div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 rounded-4 bg-white border mt-3">
                                <div class="info-label">เลขครัวเรือน</div>
                                <div class="info-value font-monospace" id="m_hc">-</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="info-box h-100">
                            <div class="fw-bold text-success mb-3">
                                <i class="bi bi-geo-alt-fill me-1"></i> พื้นที่ / ที่อยู่
                            </div>

                            <div class="p-3 rounded-4 bg-white border mb-3">
                                <div class="info-label">อำเภอ / ตำบล</div>
                                <div class="info-value">
                                    อำเภอ <span id="m_district">-</span>
                                    / ตำบล <span id="m_subdistrict">-</span>
                                </div>
                            </div>

                            <div class="p-3 rounded-4 bg-white border"
                                 style="background:linear-gradient(135deg,#ffffff,#f0fdfa)!important;">
                                <div class="info-label">ที่อยู่</div>
                                <div class="info-value lh-lg" id="m_address">-</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="info-box h-100">
                            <div class="fw-bold text-success mb-3">
                                <i class="bi bi-mortarboard-fill me-1"></i> ข้อมูลการศึกษา
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-4">
                                    <div class="p-3 rounded-4 bg-white border text-center">
                                        <div class="info-label">พูดไทย</div>
                                        <div class="info-value" id="m_speak">-</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 rounded-4 bg-white border text-center">
                                        <div class="info-label">อ่านไทย</div>
                                        <div class="info-value" id="m_read">-</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 rounded-4 bg-white border text-center">
                                        <div class="info-label">เขียนไทย</div>
                                        <div class="info-value" id="m_write">-</div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 rounded-4 bg-white border mb-2">
                                <div class="info-label">การศึกษาสูงสุด</div>
                                <div class="info-value" id="m_edu">-</div>
                            </div>

                            <div class="p-3 rounded-4 bg-white border mb-2">
                                <div class="info-label">กำลังศึกษาระดับ</div>
                                <div class="info-value" id="m_study">-</div>
                            </div>

                            <div class="p-3 rounded-4 bg-white border mb-2">
                                <div class="info-label">สถานภาพการศึกษา</div>
                                <div class="info-value" id="m_status">-</div>
                            </div>

                            <div class="p-3 rounded-4 bg-white border">
                                <div class="info-label">สาเหตุ กรณีหยุดเรียน/ออกกลางคัน</div>
                                <div class="info-value" id="m_reason">-</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer border-0 bg-white px-4 py-3">
                <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> ปิด
                </button>
            </div>
        </div>
    </div>
</div>

    
  



<script>

document.addEventListener('DOMContentLoaded', function(){

    const eduForm = document.getElementById('eduFilterForm');
    const loadingOverlay = document.getElementById('loadingOverlay');

    if(eduForm){

        eduForm.addEventListener('submit', function(e){

            e.preventDefault();

            if(loadingOverlay){
                loadingOverlay.style.display = 'flex';
            }

            setTimeout(() => {
                eduForm.submit();
            }, 200);

        });

    }



    const modal = document.getElementById('educationDetailModal');

    if(modal){

        modal.addEventListener('show.bs.modal', function(event){

            const btn = event.relatedTarget;

            document.getElementById('m_year').textContent = btn.getAttribute('data-year') || '-';
            document.getElementById('m_hc').textContent = btn.getAttribute('data-hc') || '-';
            document.getElementById('m_a1').textContent = btn.getAttribute('data-a1') || '-';
            document.getElementById('m_name').textContent = btn.getAttribute('data-name') || '-';
            document.getElementById('m_popid').textContent = btn.getAttribute('data-popid') || '-';
            document.getElementById('m_district').textContent = btn.getAttribute('data-district') || '-';
            document.getElementById('m_subdistrict').textContent = btn.getAttribute('data-subdistrict') || '-';

            const house = btn.getAttribute('data-house') || '-';
            const villageNo = btn.getAttribute('data-village-no') || '-';
            const villageName = btn.getAttribute('data-village-name') || '-';
            const subdistrict = btn.getAttribute('data-subdistrict') || '-';
            const district = btn.getAttribute('data-district') || '-';
            const postcode = btn.getAttribute('data-postcode') || '-';

            const address =
                'บ้านเลขที่ ' + house +
                ' หมู่ที่ ' + villageNo +
                ' ' + villageName +
                '<br>ตำบล' + subdistrict +
                ' อำเภอ' + district +
                ' จังหวัดพัทลุง ' + postcode;

            document.getElementById('m_address').innerHTML = address;

            document.getElementById('m_age').textContent = btn.getAttribute('data-age') || '-';
            document.getElementById('m_sex').textContent = btn.getAttribute('data-sex') || '-';
            document.getElementById('m_speak').textContent = btn.getAttribute('data-speak') || '-';
            document.getElementById('m_read').textContent = btn.getAttribute('data-read') || '-';
            document.getElementById('m_write').textContent = btn.getAttribute('data-write') || '-';
            document.getElementById('m_edu').textContent = btn.getAttribute('data-edu') || '-';
            document.getElementById('m_study').textContent = btn.getAttribute('data-study') || '-';
            document.getElementById('m_status').textContent = btn.getAttribute('data-status') || '-';
            document.getElementById('m_reason').textContent = btn.getAttribute('data-reason') || '-';

        });

    }

    window.addEventListener('pageshow', function(){

       if(loadingOverlay){
    loadingOverlay.style.display = 'none';
}

    });

});

const palette = {
    teal: '#0B5B6B',
    mint: '#2DD4BF',
    blue: '#2D74DA',
    sky: '#38BDF8',
    amber: '#F59E0B',
    red: '#EF4444',
    pink: '#EC4899',
    purple: '#8B5CF6',
    gray: '#94A3B8'
};

Chart.defaults.font.family = 'Prompt';
Chart.defaults.color = '#475569';

const tooltipStyle = {
    
    backgroundColor: 'rgba(15,23,42,.96)',
    titleFont: { family: 'Prompt', size: 14, weight: '700' },
    bodyFont: { family: 'Prompt', size: 13 },
    padding: 14,
    cornerRadius: 14,
    displayColors: true,
    boxPadding: 6
};
const chartAnimation = {
    duration: 1200,
    easing: 'easeOutQuart'
};

const trendYearData = @json($trendByYear ?? []);
const topRiskDistrictData = @json($topRiskDistricts ?? []);
const trendYearCanvas = document.getElementById('trendYearChart');

if(trendYearCanvas){
    new Chart(trendYearCanvas, {
        type:'line',
        data:{
            labels: trendYearData.map(row => row.survey_year),
            datasets:[
                {
                    label:'อ่านไม่ได้',
                    data: trendYearData.map(row => row.cannot_read),
                    borderColor: palette.red,
                    backgroundColor:'rgba(239,68,68,.12)',
                    tension:.35,
                    fill:true,
                    pointRadius:4,
                    pointHoverRadius:7
                },
                {
                    label:'เขียนไม่ได้',
                    data: trendYearData.map(row => row.cannot_write),
                    borderColor: palette.amber,
                    backgroundColor:'rgba(245,158,11,.10)',
                    tension:.35,
                    fill:true,
                    pointRadius:4,
                    pointHoverRadius:7
                },
                {
                    label:'ออกกลางคัน',
                    data: trendYearData.map(row => row.dropout),
                    borderColor: palette.teal,
                    backgroundColor:'rgba(11,91,107,.10)',
                    tension:.35,
                    fill:true,
                    pointRadius:4,
                    pointHoverRadius:7
                }
            ]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            animation:chartAnimation,
            plugins:{
                tooltip:{
                    ...tooltipStyle,
                    callbacks:{
                        label: ctx => ctx.dataset.label + ': ' + Number(ctx.raw).toLocaleString() + ' คน'
                    }
                },
                legend:{
                    position:'bottom',
                    labels:{
                        usePointStyle:true,
                        pointStyle:'circle',
                        padding:14
                    }
                }
            },
            scales:{
                x:{grid:{display:false},ticks:{font:{weight:'700'}}},
                y:{
                    beginAtZero:true,
                    grid:{color:'rgba(148,163,184,.18)'},
                    ticks:{callback:v=>Number(v).toLocaleString()}
                }
            }
        }
    });
}

const topRiskCanvas = document.getElementById('topRiskDistrictChart');

if(topRiskCanvas){
    new Chart(topRiskCanvas, {
        type:'bar',
        data:{
            labels: topRiskDistrictData.map(row => row.district),
            datasets:[
                {
                    label:'อ่านไม่ได้',
                    data: topRiskDistrictData.map(row => row.cannot_read),
                    backgroundColor: palette.red,
                    borderRadius:10
                },
                {
                    label:'เขียนไม่ได้',
                    data: topRiskDistrictData.map(row => row.cannot_write),
                    backgroundColor: palette.amber,
                    borderRadius:10
                },
                {
                    label:'ออกกลางคัน',
                    data: topRiskDistrictData.map(row => row.dropout),
                    backgroundColor: palette.teal,
                    borderRadius:10
                }
            ]
        },
        options:{
            indexAxis:'y',
            responsive:true,
            maintainAspectRatio:false,
            animation:chartAnimation,
            plugins:{
                tooltip:{
                    ...tooltipStyle,
                    callbacks:{
                        label: ctx => ctx.dataset.label + ': ' + Number(ctx.raw).toLocaleString() + ' คน'
                    }
                },
                legend:{
                    position:'bottom',
                    labels:{
                        usePointStyle:true,
                        pointStyle:'circle',
                        padding:14
                    }
                }
            },
            scales:{
                x:{
                    stacked:true,
                    beginAtZero:true,
                    grid:{color:'rgba(148,163,184,.18)'},
                    ticks:{callback:v=>Number(v).toLocaleString()}
                },
                y:{
                    stacked:true,
                    grid:{display:false},
                    ticks:{font:{weight:'700'}}
                }
            }
        }
    });
}
window.addEventListener('pageshow', function(){

    if(loadingOverlay){
        loadingOverlay.style.display = 'none';
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