<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>ข้อมูลสุขภาพ</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

    .page-wrap{
      max-width:1450px;
      margin:34px auto;
      padding:0 18px 32px;
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

    .ga-chip{
      display:inline-flex;
      align-items:center;
      gap:.45rem;
      padding:.5rem .9rem;
      border-radius:999px;
      background:#eefaf7;
      color:#0B5B6B;
      border:1px solid #bfe8df;
      font-size:13px;
      font-weight:600;
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

    .ga-kpi{
      background:linear-gradient(135deg,#ffffff 0%,#f9fcff 100%);
      border:1px solid #dcecf2;
      padding:18px;
      min-height:122px;
      border-radius:22px;
      box-shadow:0 10px 24px rgba(2, 6, 23, .05);
      position:relative;
      overflow:hidden;
      height:100%;
      transition:.2s ease;
    }

    .ga-kpi:hover{
      transform:translateY(-2px);
      box-shadow:0 14px 28px rgba(2, 6, 23, .08);
    }

    .ga-kpi.active{
      outline:2px solid #0B7F6F;
      box-shadow:0 0 0 4px rgba(11,127,111,.08);
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
      line-height:1.35;
      position:relative;
      z-index:1;
      display:flex;
      align-items:center;
      gap:.45rem;
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

    .ga-kpi-unit{
      color:#94a3b8;
      font-size:13px;
      margin-top:4px;
      position:relative;
      z-index:1;
    }

    .ga-kpi-badge{
      margin-top:10px;
      position:relative;
      z-index:1;
    }

    .ga-note{
      margin-bottom:18px;
      background:linear-gradient(135deg,#ffffff 0%,#f9fcff 100%);
      border:1px solid #dcecf2;
      border-radius:18px;
      padding:14px 16px;
      box-shadow:0 10px 24px rgba(2, 6, 23, .05);
      color:#475569;
      font-size:12px;
    }

    .ga-note i{
      color:#0ea5a4;
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
      overflow-x:auto !important;
      overflow-y:visible !important;
      position:relative;
      padding:0 14px 12px 14px;
    }

    .ga-table{
      width:100%;
      min-width:1200px;
      margin-bottom:0;
      border-collapse:collapse;
      font-size:12px;
    }

    .ga-table thead th{
      background:#d9e7f5 !important;
      color:#1e293b !important;
      border:1px solid #bfcddd !important;
      text-align:center;
      vertical-align:middle;
      white-space:nowrap;
      padding:8px 6px !important;
      font-weight:700;
      line-height:1.25;
    }

    .ga-table thead .filter-row th{
      background:#eef5fb !important;
      position:sticky;
      top:42px;
      z-index:20;
      vertical-align:top !important;
      padding:.45rem .5rem !important;
      height:58px;
    }

    .ga-table tbody td{
      border:1px solid #d5dfeb;
      padding:.8rem .75rem !important;
      vertical-align:middle;
      background:#fff;
      white-space:nowrap;
      font-size:14px;
    }

    .ga-table tbody tr:nth-child(even) td{
      background:#f8fbff;
    }

    .ga-table tbody tr:hover td{
      background:#eef5fc;
    }

    .ga-empty{
      padding:28px 10px !important;
      color:#94a3b8;
      font-size:13px;
    }

    .filter-cell{
      display:flex;
      align-items:flex-start;
      min-height:38px;
      margin:0;
    }

    .filter-cell > .form-select,
    .filter-cell > .form-control,
    .filter-cell > .dropdown{
      width:100%;
      margin:0 !important;
    }

    .filter-cell .form-select,
    .filter-cell .form-control{
      height:38px !important;
      min-height:38px !important;
      margin:0 !important;
      position:relative;
      z-index:21;
      font-size:13px;
      border-radius:10px;
      border-color:#dbe4ec;
    }

    .input-icon-wrap{
      position:relative;
      width:100%;
    }

    .input-icon-wrap .bi-search{
      position:absolute;
      left:10px;
      top:50%;
      transform:translateY(-50%);
      font-size:13px;
      color:#94a3b8;
      z-index:3;
    }

    .input-icon-wrap .form-control{
      padding-left:32px !important;
    }

    .dd-scroll{ max-height:320px; overflow:auto; }

    .pagination{ gap:6px; }

    .page-link{
      border-radius:999px!important;
      padding:6px 12px;
      border:1px solid #d7e2ea;
      color:#0B7F6F;
      font-size:13px;
    }

    .page-link:hover{
      background:rgba(11,127,111,.08);
      border-color:#0B7F6F;
      color:#0B7F6F;
    }

    .page-item.active .page-link{
      background:#0B7F6F;
      border-color:#0B7F6F;
      color:#fff;
    }

    .page-item.disabled .page-link{
      color:#9aa7b2;
      background:#fff;
    }

    .health-badge{
      border-radius:999px;
      padding:.45rem .85rem;
      font-weight:600;
      font-size:.82rem;
      display:inline-block;
    }

    .loading-overlay{
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.55);
      backdrop-filter: blur(3px);
      -webkit-backdrop-filter: blur(3px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 99999;
    }

    .loading-modal{
      text-align: center;
      animation: fadeInUp .25s ease;
    }

    .loading-ring{
      width: 108px;
      height: 108px;
      border: 7px solid rgba(255,255,255,.95);
      border-radius: 50%;
      margin: 0 auto 18px;
      position: relative;
      box-shadow: 0 8px 30px rgba(0,0,0,.18);
      animation: ringPulse 1.4s ease-in-out infinite;
      background: rgba(255,255,255,.02);
    }

    .loading-needle{
      position: absolute;
      width: 10px;
      height: 38px;
      background: #ffffff;
      border-radius: 999px;
      left: 50%;
      top: 50%;
      transform-origin: center 85%;
      transform: translate(-50%, -85%) rotate(45deg);
      box-shadow: 0 0 10px rgba(255,255,255,.35);
      animation: needleSpin 1.2s ease-in-out infinite;
    }

    .loading-needle::after{
      content: '';
      position: absolute;
      bottom: -5px;
      left: 50%;
      transform: translateX(-50%);
      width: 14px;
      height: 14px;
      background: #ffffff;
      border-radius: 50%;
    }

    .loading-text{
      color: #ffffff;
      font-size: 16px;
      font-weight: 700;
      letter-spacing: .2px;
      text-shadow: 0 2px 10px rgba(0,0,0,.18);
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
      from{ opacity: 0; transform: translateY(8px); }
      to{ opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 992px){
      .ga-filter-actions{
        flex-direction:column;
        align-items:stretch;
      }

      .ga-btn-export{
        width:100%;
      }
    }

    @media (max-width: 767.98px){
      .page-wrap{
        padding:0 12px 24px;
        margin:18px auto;
      }

      .ga-page{
        padding:14px;
        border-radius:22px;
      }

      .ga-title{
        font-size:16px;
      }

      .ga-kpi-value{
        font-size:22px;
      }

      .ga-filter-card{
        padding:16px;
        border-radius:22px;
      }

      .ga-btn-light{
        min-height:56px;
        font-size:16px;
        border-radius:16px;
      }

      .ga-btn-export{
        min-height:58px;
        font-size:16px;
        border-radius:18px;
      }

      .loading-ring{
        width: 90px;
        height: 90px;
      }

      .loading-text{
        font-size: 14px;
      }
    }
  </style>
</head>

<body class="app-bg">

@php
  $teal  = $teal  ?? '#0B7F6F';
  $teal2 = $teal2 ?? '#0B5B6B';
  $actionUrl = $actionUrl ?? route('health.index');

  $health      = $health ?? '';
  $district    = $district ?? '';
  $subdistrict = $subdistrict ?? '';
  $districtList    = $districtList ?? collect([]);
  $subdistrictList = $subdistrictList ?? collect([]);

  $house_id    = $house_id ?? '';
  $survey_year = $survey_year ?? '';
  $fname       = $fname ?? '';
  $lname       = $lname ?? '';
  $cid         = $cid ?? '';
  $agey        = $agey ?? '';
  $sex         = $sex ?? '';
  $age_range   = $age_range ?? request('age_range','');
  $yearList    = $yearList ?? collect([]);

  $HEALTH_OPTIONS = $HEALTH_OPTIONS ?? [
    'ปกติ',
    'ป่วยเรื้อรังที่ไม่ติดเตียง (เช่น หัวใจ เบาหวาน)',
    'พิการพึ่งตนเองได้',
    'ผู้ป่วยติดเตียง/พิการพึ่งตัวเองไม่ได้',
  ];

  $HEALTH_NULL_TOKEN = $HEALTH_NULL_TOKEN ?? '__NULL__';

  $counts = $counts ?? [];
  $rows   = $rows ?? collect([]);

  $healthBadge = function($h){
    $h = trim((string)$h);
    if ($h === 'ปกติ') return ['bg'=>'#0B7F6F','text'=>'#fff','label'=>$h, 'icon'=>'bi-heart-pulse-fill'];
    if ($h === 'ป่วยเรื้อรังที่ไม่ติดเตียง (เช่น หัวใจ เบาหวาน)') return ['bg'=>'#F6C277','text'=>'#1f2937','label'=>'ป่วยเรื้อรังไม่ติดเตียง', 'icon'=>'bi-activity'];
    if ($h === 'พิการพึ่งตนเองได้') return ['bg'=>'#0F9BD8','text'=>'#fff','label'=>$h, 'icon'=>'bi-person-check-fill'];
    if ($h === 'ผู้ป่วยติดเตียง/พิการพึ่งตัวเองไม่ได้') return ['bg'=>'#DC3545','text'=>'#fff','label'=>'ติดเตียง/พึ่งตัวเองไม่ได้', 'icon'=>'bi-person-fill-lock'];
    return ['bg'=>'#6B7280','text'=>'#fff','label'=>($h ?: 'ไม่ระบุ'), 'icon'=>'bi-question-circle-fill'];
  };

  $baseQueryParams = array_filter([
    'health'=>$health,
    'house_id'=>$house_id,
    'survey_year'=>$survey_year,
    'fname'=>$fname,
    'lname'=>$lname,
    'cid'=>$cid,
    'age_range'=>$age_range,
    'agey'=>$agey,
    'sex'=>$sex,
  ]);

  $totalRows = method_exists($rows,'total') ? (int)$rows->total() : count($rows);
@endphp

@include('layouts.topbar')

<div class="page-wrap">
  <div class="ga-page shadow-soft">

    <div class="ga-topbar">
      <div class="ga-brand">
        <div>
          <div class="ga-title">
            <i class="bi bi-heart-pulse-fill"></i>
            <span>ข้อมูลสุขภาพ</span>
          </div>
          <div class="ga-subtitle">
            แสดงข้อมูลสุขภาพรายบุคคล พร้อมตัวกรองรายพื้นที่ รายคน และข้อมูลเชิงพื้นที่สำหรับดูรายละเอียดเพิ่มเติม
          </div>
        </div>

        <span class="ga-chip">
          ทั้งหมด <strong>{{ number_format($totalRows) }}</strong> รายการ
        </span>
      </div>
    </div>

    <div class="ga-filter-card">
      <div class="row g-3 align-items-end">
        <div class="col-md-3">
          <label class="ga-filter-label">อำเภอ</label>
          <div class="dropdown">
            <button class="btn ga-btn-light w-100 dropdown-toggle" data-bs-toggle="dropdown">
              <i class="bi bi-geo-alt-fill me-1"></i>
              {{ !empty($district) ? "อ.{$district}" : "เลือกอำเภอ" }}
            </button>

            <ul class="dropdown-menu rounded-4 border-0 shadow dd-scroll w-100">
              <li>
                <a class="dropdown-item text-danger"
                   href="{{ $actionUrl }}?{{ http_build_query(array_filter(array_merge($baseQueryParams, ['district'=>'', 'subdistrict'=>'']))) }}">
                  ล้างตัวกรองอำเภอ
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>

              @foreach($districtList as $d)
                <li>
                  <a class="dropdown-item"
                     href="{{ $actionUrl }}?{{ http_build_query(array_filter(array_merge($baseQueryParams, ['district'=>$d, 'subdistrict'=>'']))) }}">
                    อ.{{ $d }}
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
        </div>

        <div class="col-md-3">
          <label class="ga-filter-label">ตำบล</label>
          <div class="dropdown">
            <button class="btn ga-btn-light w-100 dropdown-toggle"
                    data-bs-toggle="dropdown"
                    @if(empty($district)) disabled @endif>
              <i class="bi bi-pin-map-fill me-1"></i>
              {{ !empty($subdistrict) ? "ต.{$subdistrict}" : "เลือกตำบล" }}
            </button>

            <ul class="dropdown-menu rounded-4 border-0 shadow dd-scroll w-100">
              <li>
                <a class="dropdown-item text-danger"
                   href="{{ $actionUrl }}?{{ http_build_query(array_filter(array_merge($baseQueryParams, ['district'=>$district, 'subdistrict'=>'']))) }}">
                  ล้างตัวกรองตำบล
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>

              @foreach($subdistrictList as $sd)
                <li>
                  <a class="dropdown-item"
                     href="{{ $actionUrl }}?{{ http_build_query(array_filter(array_merge($baseQueryParams, ['district'=>$district, 'subdistrict'=>$sd]))) }}">
                    ต.{{ $sd }}
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
        </div>

        <div class="col-md-3">
          <label class="ga-filter-label">ส่งออกรายงาน</label>
          <a class="ga-btn-export w-100 justify-content-center"
             href="{{ route('health.export', request()->query()) }}">
            <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
          </a>
        </div>

        <div class="col-md-3">
          <label class="ga-filter-label">รีเซ็ตตัวกรอง</label>
          <a class="btn ga-btn-light w-100" href="{{ $actionUrl }}">
            <i class="bi bi-arrow-clockwise me-1"></i> ล้างทั้งหมด
          </a>
        </div>
      </div>

      <div class="ga-filter-actions">
        <div class="ga-filter-actions-text">
          <i class="bi bi-funnel-fill"></i>
          <div>
            <div style="font-weight:700; color:#0f172a;">ค้นหาและกรองข้อมูลสุขภาพ</div>
            <div style="font-size:12px; color:#64748b;">กด Enter หรือเปลี่ยนตัวเลือกเพื่อแสดงผลได้ทันที</div>
          </div>
        </div>

        <div class="ga-chip">
          พบข้อมูลตามเงื่อนไข <strong>{{ number_format($totalRows) }}</strong> รายการ
        </div>
      </div>
    </div>

    <div class="row g-3 mb-3">
      @foreach($HEALTH_OPTIONS as $opt)
        @php
          $isActive = ($health === $opt);
          $count = $counts[$opt] ?? 0;
          $b = $healthBadge($opt);
        @endphp

        <div class="col-md-6 col-xl-3">
          <a class="text-decoration-none"
             href="{{ $actionUrl }}?{{ http_build_query(array_filter([
                'health'=>$opt,
                'district'=>$district,
                'subdistrict'=>$subdistrict,
                'house_id'=>$house_id,
                'survey_year'=>$survey_year,
                'fname'=>$fname,
                'lname'=>$lname,
                'cid'=>$cid,
                'age_range'=>$age_range,
                'agey'=>$agey,
                'sex'=>$sex,
             ])) }}">
            <div class="ga-kpi {{ $isActive ? 'active' : '' }}">
              <div class="ga-kpi-label">
                <i class="bi {{ $b['icon'] }}"></i>
                {{ $opt }}
              </div>
              <h3 class="ga-kpi-value">{{ number_format($count) }}</h3>
              <div class="ga-kpi-unit">(คน)</div>
              <div class="ga-kpi-badge">
                <span class="badge rounded-pill" style="background:{{ $b['bg'] }};color:{{ $b['text'] }};">
                  {{ $isActive ? 'กำลังกรอง' : 'กดเพื่อกรอง' }}
                </span>
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>

    <div class="ga-note">
      <i class="bi bi-info-circle me-1"></i>
      ตารางด้านล่างรองรับการกรองตามปี รหัสบ้าน ชื่อ สกุล ช่วงอายุ เพศ และสถานะสุขภาพ พร้อมดูรายละเอียดรายบุคคล ที่อยู่ เบอร์ติดต่อ และพิกัดแผนที่
    </div>

    <div class="ga-table-panel">
      <div class="ga-table-head">
        <div>
          <div class="ga-table-head-title">ตารางรายชื่อบุคคล</div>
          <div class="ga-table-head-sub">แสดงข้อมูลปีที่สำรวจ รหัสบ้าน อายุ เพศ สถานะสุขภาพ และปุ่มดูรายละเอียด</div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap text-muted" style="font-size:12px;">
          @if($health === $HEALTH_NULL_TOKEN)
            <span class="badge rounded-pill bg-secondary-subtle text-secondary border">ไม่ระบุ</span>
          @elseif($health !== '')
            <span class="badge rounded-pill bg-success-subtle text-success border">กรองตามสถานะสุขภาพ</span>
          @else
            <span class="badge rounded-pill bg-light text-dark border">ทั้งหมด</span>
          @endif

          @php $nullCount = $counts[$HEALTH_NULL_TOKEN] ?? 0; @endphp
          <span class="badge rounded-pill bg-light text-dark border">ไม่ระบุ {{ number_format($nullCount) }} คน</span>
        </div>
      </div>

      <form method="GET" action="{{ $actionUrl }}" id="filterForm">
        @if(!empty($district)) <input type="hidden" name="district" value="{{ $district }}"> @endif
        @if(!empty($subdistrict)) <input type="hidden" name="subdistrict" value="{{ $subdistrict }}"> @endif

        <div class="table-responsive">
          <table class="table ga-table align-middle mb-0">
            <thead>
              <tr>
                <th style="min-width:90px;">ปีที่สำรวจ</th>
                <th style="min-width:140px;">รหัสบ้าน</th>
                <th style="min-width:140px;">ชื่อ</th>
                <th style="min-width:140px;">สกุล</th>
                <th style="min-width:120px;">อายุ</th>
                <th style="min-width:120px;">เพศ</th>
                <th style="min-width:280px;">สุขภาพ</th>
                <th style="min-width:140px;">รายละเอียด</th>
              </tr>

              <tr class="filter-row">
                <th>
                  <div class="filter-cell">
                    <select class="form-select form-select-sm" name="survey_year">
                      <option value="">ปีที่สำรวจ (ทั้งหมด)</option>
                      @foreach(($yearList ?? [2568,2567,2566,2565,2564]) as $y)
                        <option value="{{ $y }}" @selected((string)$survey_year === (string)$y)>{{ $y }}</option>
                      @endforeach
                    </select>
                  </div>
                </th>

                <th>
                  <div class="filter-cell">
                    <div class="input-icon-wrap" style="max-width:130px">
                      <i class="bi bi-search"></i>
                      <input class="form-control form-control-sm" name="house_id" value="{{ $house_id }}" placeholder="รหัสบ้าน">
                    </div>
                  </div>
                </th>

                <th>
                  <div class="filter-cell">
                    <div class="input-icon-wrap" style="max-width:140px">
                      <i class="bi bi-search"></i>
                      <input class="form-control form-control-sm" name="fname" value="{{ $fname }}" placeholder="ชื่อ">
                    </div>
                  </div>
                </th>

                <th>
                  <div class="filter-cell">
                    <div class="input-icon-wrap" style="max-width:140px">
                      <i class="bi bi-search"></i>
                      <input class="form-control form-control-sm" name="lname" value="{{ $lname }}" placeholder="สกุล">
                    </div>
                  </div>
                </th>

                <th>
                  <div class="filter-cell">
                    <select class="form-select form-select-sm" name="age_range">
                      <option value="">ช่วงอายุ (ทั้งหมด)</option>
                      <option value="0-15"  @selected($age_range==='0-15')>0 – 15 ปี</option>
                      <option value="16-28" @selected($age_range==='16-28')>16 – 28 ปี</option>
                      <option value="29-44" @selected($age_range==='29-44')>29 – 44 ปี</option>
                      <option value="45-59" @selected($age_range==='45-59')>45 – 59 ปี</option>
                      <option value="60-78" @selected($age_range==='60-78')>60 – 78 ปี</option>
                      <option value="79-97" @selected($age_range==='79-97')>79 – 97 ปี</option>
                      <option value="98+"   @selected($age_range==='98+')>98 ปีขึ้นไป</option>
                    </select>
                  </div>
                </th>

                <th>
                  <div class="filter-cell">
                    <select class="form-select form-select-sm" name="sex">
                      <option value="">เพศ (ทั้งหมด)</option>
                      <option value="ชาย" @selected($sex === 'ชาย')>ชาย</option>
                      <option value="หญิง" @selected($sex === 'หญิง')>หญิง</option>
                    </select>
                  </div>
                </th>

                <th>
                  <div class="filter-cell">
                    <select class="form-select form-select-sm" name="health">
                      <option value="">สุขภาพ (ทั้งหมด)</option>
                      <option value="{{ $HEALTH_NULL_TOKEN }}" @selected($health === $HEALTH_NULL_TOKEN)>ไม่ระบุ</option>
                      @foreach($HEALTH_OPTIONS as $opt)
                        <option value="{{ $opt }}" @selected($health === $opt)>{{ $opt }}</option>
                      @endforeach
                    </select>
                  </div>
                </th>

                <th><div class="filter-cell"></div></th>
              </tr>
            </thead>

            <tbody>
              @forelse($rows as $r)
                @php $b = $healthBadge($r->human_Health ?? ''); @endphp

                <tr
                  data-house="{{ e($r->house_Id ?? '') }}"
                  data-district="{{ e($r->survey_District ?? '') }}"
                  data-subdistrict="{{ e($r->survey_Subdistrict ?? '') }}"
                  data-year="{{ e($r->survey_Year ?? '') }}"
                  data-order="{{ e($r->human_Order ?? '') }}"
                  data-title="{{ e($r->human_Member_title ?? '') }}"
                  data-sex="{{ e($r->human_Sex ?? '') }}"
                  data-agey="{{ e($r->human_Age_y ?? '') }}"
                  data-health="{{ e($r->human_Health ?? '') }}"
                  data-lat="{{ e($r->latitude ?? '') }}"
                  data-lng="{{ e($r->longitude ?? '') }}"
                  data-cid="{{ e($r->human_Member_cid ?? '') }}"
                  data-phone="{{ e($r->survey_Informer_phone ?? '') }}"
                  data-fname="{{ e($r->human_Member_fname ?? '') }}"
                  data-lname="{{ e($r->human_Member_lname ?? '') }}"
                  data-house-number="{{ e($r->house_Number ?? '') }}"
                  data-village-no="{{ e($r->village_No ?? '') }}"
                  data-village-name="{{ e($r->village_Name ?? '') }}"
                  data-postcode="{{ e($r->survey_Postcode ?? '') }}"
                >
                  <td class="ps-3 fw-semibold">{{ $r->survey_Year ?? '-' }}</td>
                  <td class="fw-semibold">{{ $r->house_Id ?? '-' }}</td>
                  <td>{{ $r->human_Member_fname ?? '-' }}</td>
                  <td>{{ $r->human_Member_lname ?? '-' }}</td>
                  <td>{{ $r->human_Age_y ?? '-' }}</td>
                  <td>{{ $r->human_Sex ?? '-' }}</td>
                  <td>
                    <span class="health-badge" style="background:{{ $b['bg'] }};color:{{ $b['text'] }};">
                      {{ $b['label'] }}
                    </span>
                  </td>
                  <td class="text-end pe-3" style="width:1%;white-space:nowrap;">
                    <button type="button"
                            class="btn btn-sm fw-semibold d-inline-flex align-items-center gap-1"
                            style="background:linear-gradient(135deg,#0ea5a4 0%,#2d74da 100%);color:#fff;border:none;border-radius:14px;padding:.5rem .9rem;box-shadow:0 8px 18px rgba(45,116,218,.18);"
                            data-bs-toggle="modal" data-bs-target="#detailModal"
                            onclick="openDetail(this.closest('tr'))">
                      <i class="bi bi-eye"></i>
                      <span>ดูรายละเอียด</span>
                    </button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="text-center ga-empty">ไม่พบข้อมูล</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </form>

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

<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
    <div class="modal-content rounded-4 shadow">

      <div class="modal-header text-white" style="background:linear-gradient(135deg,#0B7F6F,#0B5B6B)">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-person-vcard fs-5"></i>
          <div>
            <div class="fw-semibold small">ข้อมูลเพิ่มเติม</div>
            <div class="opacity-75" style="font-size:12px;">
              รายละเอียดบุคคล • ที่อยู่ • พิกัด
            </div>
          </div>
        </div>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body bg-light">
        <div class="row g-3">

          <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4">
              <div class="card-header bg-white border-0 pb-0">
                <div class="fw-semibold text-success small">
                  <i class="bi bi-geo-alt-fill"></i> ข้อมูลบ้าน/พื้นที่
                </div>
              </div>

              <div class="card-body pt-2">
                <div class="row g-2 small">
                  <div class="col-6">
                    <div class="border rounded-3 p-2 bg-white h-100">
                      <div class="text-secondary small">รหัสบ้าน</div>
                      <div class="fw-semibold" id="m_house"></div>
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="border rounded-3 p-2 bg-white h-100">
                      <div class="text-secondary small">ปีที่สำรวจ</div>
                      <div class="fw-semibold" id="m_year"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="border rounded-3 p-2 bg-white">
                      <div class="text-secondary small">ที่อยู่</div>
                      <div class="fw-semibold lh-base">
                        บ้านเลขที่ <span id="m_house_number"></span>
                        หมู่ที่ <span id="m_village_no"></span>
                        บ้าน <span id="m_village_name"></span><br>
                        ตำบล <span id="m_subdistrict"></span>
                        อำเภอ <span id="m_district"></span>
                        จังหวัดพัทลุง
                        <span id="m_postcode"></span>
                      </div>
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="border rounded-3 p-2 bg-white h-100">
                      <div class="text-secondary small">ละติจูด</div>
                      <div class="fw-semibold font-monospace" id="m_lat"></div>
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="border rounded-3 p-2 bg-white h-100">
                      <div class="text-secondary small">ลองจิจูด</div>
                      <div class="fw-semibold font-monospace" id="m_lng"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4">
              <div class="card-header bg-white border-0 pb-0">
                <div class="fw-semibold text-success small">
                  <i class="bi bi-person-fill"></i> ข้อมูลบุคคล
                </div>
              </div>

              <div class="card-body pt-2">
                <div class="row g-2 small">
                  <div class="col-12">
                    <div class="row g-2">
                      <div class="col-4 col-md-3">
                        <div class="border rounded-3 p-2 bg-white h-100">
                          <div class="text-secondary small">ลำดับที่</div>
                          <div class="fw-semibold" id="m_order"></div>
                        </div>
                      </div>

                      <div class="col-8 col-md-9">
                        <div class="border rounded-3 p-2 bg-white h-100">
                          <div class="text-secondary small">ชื่อ - สกุล</div>
                          <div class="fw-bold fs-6">
                            <span id="m_fname"></span>
                            <span id="m_lname_wrap" class="ms-1">
                              <span id="m_lname"></span>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="row g-2">
                      <div class="col-6 col-md-4">
                        <div class="border rounded-3 p-2 bg-white h-100">
                          <div class="text-secondary small">อายุ</div>
                          <div class="fw-semibold">
                            <span id="m_agey"></span> <span id="m_age_suffix">ปี</span>
                          </div>
                        </div>
                      </div>

                      <div class="col-6 col-md-4">
                        <div class="border rounded-3 p-2 bg-white h-100">
                          <div class="text-secondary small">เพศ</div>
                          <div class="fw-semibold" id="m_sex"></div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="border rounded-3 p-2 bg-white">
                      <div class="text-secondary small">บัตรประชาชน</div>
                      <div class="fw-semibold font-monospace" id="m_cid"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="border rounded-3 p-2 bg-white d-flex align-items-center justify-content-between gap-2">
                      <div>
                        <div class="text-secondary small">เบอร์ติดต่อ</div>
                        <div class="fw-semibold font-monospace" id="m_phone"></div>
                      </div>

                      <a id="m_call"
                         class="btn btn-sm btn-success rounded-pill px-3 d-none"
                         target="_self">
                        <i class="bi bi-telephone-fill"></i> โทร
                      </a>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="border rounded-3 p-2 bg-success-subtle">
                      <div class="text-secondary small">สุขภาพ</div>
                      <div class="fw-semibold text-success" id="m_health"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
              <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <div class="fw-semibold text-success small">
                  <i class="bi bi-map"></i> แผนที่
                </div>
                <a id="m_map_link"
                   target="_blank"
                   class="btn btn-sm btn-outline-success rounded-pill d-none">
                  เปิด Google Maps
                </a>
              </div>

              <div id="m_map_wrap" style="display:none;">
                <iframe id="m_map_iframe"
                        class="w-100"
                        style="height:300px;border:0"
                        loading="lazy"></iframe>
              </div>

              <div id="m_map_empty" class="text-center text-secondary small py-3">
                ไม่มีพิกัดแผนที่
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="modal-footer bg-white border-0">
        <button class="btn btn-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">
          ปิด
        </button>
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
  function showLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) overlay.style.display = 'flex';
  }

  function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) overlay.style.display = 'none';
  }

  function submitWithLoading(form, delay = 500) {
    if (!form) return;
    showLoading();
    setTimeout(() => form.submit(), delay);
  }

  function openDetail(row){
    const d = row.dataset;

    const set = (id, val, fallback='-') => {
      const el = document.getElementById(id);
      if (!el) return;
      const v = (val ?? '').toString().trim();
      el.textContent = v !== '' ? v : fallback;
    };

    set('m_house', d.house);
    set('m_house_number', d.houseNumber, '-');
    set('m_village_no', d.villageNo, '-');
    set('m_village_name', d.villageName, '-');
    set('m_postcode', d.postcode, '');
    set('m_district', d.district);
    set('m_subdistrict', d.subdistrict);
    set('m_year', d.year);

    const latv = (d.lat ?? '').toString().trim();
    const lngv = (d.lng ?? '').toString().trim();
    set('m_lat', latv);
    set('m_lng', lngv);

    set('m_order', d.order);
    set('m_sex', d.sex);
    set('m_agey', d.agey);
    set('m_fname', d.fname);
    set('m_lname', d.lname);
    set('m_cid', d.cid);
    set('m_phone', d.phone);

    const hv = (d.health ?? '').toString().trim();
    const healthEl = document.getElementById('m_health');
    if (healthEl) healthEl.textContent = hv !== '' ? hv : 'ไม่ระบุ';

    const phone = (d.phone ?? '').toString().trim();
    const callBtn = document.getElementById('m_call');
    if (callBtn) {
      const clean = phone.replace(/\s+/g,'');
      if (clean) {
        callBtn.href = `tel:${clean}`;
        callBtn.classList.remove('d-none');
      } else {
        callBtn.href = '#';
        callBtn.classList.add('d-none');
      }
    }

    const wrap   = document.getElementById('m_map_wrap');
    const empty  = document.getElementById('m_map_empty');
    const iframe = document.getElementById('m_map_iframe');
    const link   = document.getElementById('m_map_link');

    const latNum = Number(latv);
    const lngNum = Number(lngv);
    const hasLatLng = Number.isFinite(latNum) && Number.isFinite(lngNum);

    if (wrap && empty && iframe && link) {
      if (hasLatLng) {
        const q = encodeURIComponent(`${latNum},${lngNum}`);
        iframe.src = `https://www.google.com/maps?q=${q}&z=16&output=embed`;
        link.href  = `https://www.google.com/maps?q=${q}&z=16`;
        wrap.style.display  = 'block';
        empty.style.display = 'none';
        link.classList.remove('d-none');
      } else {
        iframe.src = '';
        link.href  = '#';
        wrap.style.display  = 'none';
        empty.style.display = 'block';
        link.classList.add('d-none');
      }
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('filterForm');

    if (filterForm) {
      filterForm.addEventListener('submit', function(e){
        e.preventDefault();
        submitWithLoading(filterForm);
      });
    }

    document.querySelectorAll('#filterForm thead select').forEach(el => {
      el.addEventListener('change', () => submitWithLoading(filterForm, 500));
    });

    document.querySelectorAll('#filterForm thead input').forEach(el => {
      el.addEventListener('keydown', function(e){
        if (e.key === 'Enter') {
          e.preventDefault();
          submitWithLoading(filterForm, 500);
        }
      });
    });

    document.querySelectorAll('a[href]').forEach(link => {
      if (
        link.href &&
        !link.href.startsWith('javascript:') &&
        !link.hasAttribute('target') &&
        !link.closest('.modal') &&
        !link.dataset.bsToggle
      ) {
        link.addEventListener('click', function(){
          showLoading();
        });
      }
    });

    window.addEventListener('pageshow', function(){
      hideLoading();
    });
  });
</script>

</body>
</html>