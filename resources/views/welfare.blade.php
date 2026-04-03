<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>ข้อมูลสวัสดิการ</title>

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

    .ga-kpi{
      background:linear-gradient(135deg,#ffffff 0%,#f9fcff 100%);
      border:1px solid #dcecf2;
      padding:18px;
      min-height:110px;
      border-radius:22px;
      box-shadow:0 10px 24px rgba(2, 6, 23, .05);
      position:relative;
      overflow:hidden;
      height:100%;
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
      min-width:1250px;
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

    .ga-table thead tr:first-child th{
      background:#cfe0f2 !important;
      font-size:11px;
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
    .filter-cell .form-control,
    .filter-cell .dropdown-toggle{
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

    .welfare-filter-dropdown{
      position:relative;
      width:100%;
    }

    .welfare-filter-dropdown .dropdown-toggle{
      display:flex;
      align-items:center;
      justify-content:space-between;
      width:100%;
      white-space:nowrap;
      font-size:13px;
    }

    .welfare-filter-dropdown .dropdown-menu{
      z-index:5000 !important;
      min-width:380px;
      max-width:min(90vw, 380px);
      border-radius:18px !important;
    }

    .badge{
      font-weight:500;
    }

    .rounded-4{
      border-radius:22px !important;
    }

    .modal .card{
      border-radius:18px !important;
    }

    .modal .card .small,
    .modal .text-secondary.small{
      font-size:12px !important;
    }

    .modal .fw-bold.fs-6{
      font-size:1rem !important;
    }

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
      from{
        opacity: 0;
        transform: translateY(8px);
      }
      to{
        opacity: 1;
        transform: translateY(0);
      }
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

      .ga-filter,
      .ga-btn,
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

      .welfare-filter-dropdown .dropdown-menu{
        min-width:320px;
        max-width:min(92vw, 360px);
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

@include('layouts.topbar')

@php
  $teal  = '#0B7F6F';
  $teal2 = '#0B5B6B';

  $actionUrl = $actionUrl ?? route('welfare.index');

  $district = $district ?? '';
  $subdistrict = $subdistrict ?? '';

  $districtList = $districtList ?? collect([]);
  $subdistrictList = $subdistrictList ?? collect([]);

  $welfare = $welfare ?? '';

  $welfare_match = $welfare_match ?? request('welfare_match','any');
  if (!in_array($welfare_match, ['any','all'], true)) $welfare_match = 'any';

  $house_id = $house_id ?? '';
  $fname = $fname ?? '';
  $lname = $lname ?? '';
  $cid = $cid ?? '';

  $survey_year = $survey_year ?? request('survey_year','');
  $age_range   = $age_range ?? request('age_range','');
  $sex         = $sex ?? request('sex','');

  $welfare_type = (array)($welfare_type ?? []);

  $counts = $counts ?? ['received'=>0,'not_received'=>0];
  $rows = $rows ?? collect([]);

  $receivedCount = (int)($counts['received'] ?? 0);
  $notReceivedCount = (int)($counts['not_received'] ?? 0);

  $types = [
    'a7_1' => 'เด็กแรกเกิด',
    'a7_2' => 'เบี้ยผู้สูงอายุ/คนชรา',
    'a7_3' => 'เบี้ยคนพิการ',
    'a7_4' => 'ประกันสังคม (ม.33)',
    'a7_5' => 'ประกันตนเอง (ม.40)',
    'a7_6' => 'บัตรสวัสดิการแห่งรัฐ',
    'unknown' => 'ไม่ระบุ',
  ];

  $typeCount = count($welfare_type);
  $matchLabel = $welfare_match === 'all'
    ? 'AND ได้รับ ครบทุกประเภท'
    : 'ได้รับ อย่างน้อย 1 ประเภท';

  $baseQueryParams = array_filter([
    'welfare'=>$welfare,
    'welfare_match'=>$welfare_match,
    'welfare_type'=>$welfare_type,
    'house_id'=>$house_id,
    'fname'=>$fname,
    'lname'=>$lname,
    'cid'=>$cid,
    'survey_year'=>$survey_year,
    'age_range'=>$age_range,
    'sex'=>$sex,
  ]);

  $totalRows = method_exists($rows,'total') ? (int)$rows->total() : count($rows);
@endphp

<div class="page-wrap">
  <div class="ga-page shadow-soft">

    <div class="ga-topbar">
      <div class="ga-brand">
        <div>
          <div class="ga-title">
            <i class="bi bi-gift-fill"></i>
            <span>ข้อมูลสวัสดิการ</span>
          </div>
          <div class="ga-subtitle">
            แสดงข้อมูลผู้ได้รับและไม่ได้รับสวัสดิการ พร้อมตัวกรองรายบุคคล รายพื้นที่ และรายละเอียดเชิงพื้นที่
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
            <button class="btn ga-btn-light w-100 dropdown-toggle"
                    data-bs-toggle="dropdown">
              <i class="bi bi-geo-alt-fill me-1"></i>
              {{ !empty($district) ? "อ.{$district}" : "เลือกอำเภอ" }}
            </button>

            <ul class="dropdown-menu rounded-4 border-0 shadow dd-scroll w-100">
              <li>
                <a class="dropdown-item text-danger"
                   href="{{ $actionUrl }}?{{ http_build_query(array_filter(array_merge($baseQueryParams, [
                     'district'=>'',
                     'subdistrict'=>'',
                   ]))) }}">
                  ล้างตัวกรองอำเภอ
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>

              @foreach($districtList as $d)
                <li>
                  <a class="dropdown-item"
                     href="{{ $actionUrl }}?{{ http_build_query(array_filter(array_merge($baseQueryParams, [
                       'district'=>$d,
                       'subdistrict'=>'',
                     ]))) }}">
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
                   href="{{ $actionUrl }}?{{ http_build_query(array_filter(array_merge($baseQueryParams, [
                     'district'=>$district,
                     'subdistrict'=>'',
                   ]))) }}">
                  ล้างตัวกรองตำบล
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>

              @foreach($subdistrictList as $sd)
                <li>
                  <a class="dropdown-item"
                     href="{{ $actionUrl }}?{{ http_build_query(array_filter(array_merge($baseQueryParams, [
                       'district'=>$district,
                       'subdistrict'=>$sd,
                     ]))) }}">
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
             href="{{ route('welfare.export', request()->query()) }}">
            <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
          </a>
        </div>

        <div class="col-md-3">
          <label class="ga-filter-label">รีเซ็ตตัวกรอง</label>
          <a class="btn ga-btn-light w-100"
             href="{{ $actionUrl }}">
            <i class="bi bi-arrow-clockwise me-1"></i> ล้างทั้งหมด
          </a>
        </div>
      </div>

      <div class="ga-filter-actions">
        <div class="ga-filter-actions-text">
          <i class="bi bi-funnel-fill"></i>
          <div>
            <div style="font-weight:700; color:#0f172a;">ค้นหาและกรองข้อมูลสวัสดิการ</div>
            <div style="font-size:12px; color:#64748b;">กด Enter หรือเปลี่ยนตัวเลือกเพื่อแสดงผลได้ทันที</div>
          </div>
        </div>

        <div class="ga-chip">
          พบข้อมูลตามเงื่อนไข <strong>{{ number_format($totalRows) }}</strong> รายการ
        </div>
      </div>
    </div>

    <div class="row g-3 mb-3">
      <div class="col-md-6">
        <div class="ga-kpi">
          <div class="ga-kpi-label">
            <i class="bi bi-check-circle-fill text-success"></i>
            ได้รับสวัสดิการ
          </div>
          <h3 class="ga-kpi-value">{{ number_format($receivedCount) }}</h3>
          <div class="ga-kpi-unit">(คน)</div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="ga-kpi">
          <div class="ga-kpi-label">
            <i class="bi bi-x-circle-fill text-secondary"></i>
            ไม่ได้รับสวัสดิการ
          </div>
          <h3 class="ga-kpi-value">{{ number_format($notReceivedCount) }}</h3>
          <div class="ga-kpi-unit">(คน)</div>
        </div>
      </div>
    </div>

    <div class="ga-note">
      <i class="bi bi-info-circle me-1"></i>
      ตารางด้านล่างรองรับการกรองตามปี รหัสบ้าน ชื่อ นามสกุล อายุ เพศ และประเภทสวัสดิการ พร้อมดูรายละเอียดพิกัดและข้อมูลบ้านของแต่ละรายการ
    </div>

    <div class="ga-table-panel">
      <div class="ga-table-head">
        <div>
          <div class="ga-table-head-title">ตารางรายชื่อบุคคล</div>
          <div class="ga-table-head-sub">แสดงสถานะสวัสดิการ ประเภทสวัสดิการ และข้อมูลรายละเอียดรายบุคคล</div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap text-muted" style="font-size:12px;">
          @if($welfare === 'received')
            <span class="badge rounded-pill bg-success-subtle text-success border">ได้รับ</span>
          @elseif($welfare === 'not_received')
            <span class="badge rounded-pill bg-secondary-subtle text-secondary border">ไม่ได้รับ</span>
          @else
            <span class="badge rounded-pill bg-light text-dark border">ทั้งหมด</span>
          @endif

          @if($welfare === 'received' && $typeCount > 0)
            <span class="badge rounded-pill bg-light text-dark border">{{ $matchLabel }}</span>
          @endif
        </div>
      </div>

      <form method="GET" action="{{ $actionUrl }}" id="filterForm">
        @if(!empty($district)) <input type="hidden" name="district" value="{{ $district }}"> @endif
        @if(!empty($subdistrict)) <input type="hidden" name="subdistrict" value="{{ $subdistrict }}"> @endif

        <input type="hidden" name="welfare" id="welfareHidden" value="{{ $welfare }}">
        <input type="hidden" name="welfare_match" id="welfareMatchHidden" value="{{ $welfare_match }}">

        <div class="table-responsive">
          <table class="table ga-table align-middle mb-0">
            <thead>
              <tr>
                <th style="min-width:90px;">ปีที่สำรวจ</th>
                <th style="min-width:150px;">รหัสบ้าน</th>
                <th style="min-width:150px;">ชื่อ</th>
                <th style="min-width:150px;">สกุล</th>
                <th style="min-width:120px;">อายุ</th>
                <th style="min-width:120px;">เพศ</th>
                <th style="min-width:160px;">สวัสดิการ</th>
                <th style="min-width:340px;">ประเภทสวัสดิการ</th>
                <th style="min-width:140px;">รายละเอียด</th>
              </tr>

              <tr class="filter-row">
                <th>
                  <div class="filter-cell">
                    <select class="form-select form-select-sm" name="survey_year">
                      <option value="">ปีที่สำรวจ (ทั้งหมด)</option>
                      @foreach([2564,2565,2566,2567,2568] as $y)
                        <option value="{{ $y }}" @selected((string)$survey_year === (string)$y)>{{ $y }}</option>
                      @endforeach
                    </select>
                  </div>
                </th>

                <th>
                  <div class="filter-cell">
                    <div class="input-icon-wrap" style="max-width:120px">
                      <i class="bi bi-search"></i>
                      <input class="form-control form-control-sm"
                             name="house_id" value="{{ $house_id }}" placeholder="รหัสบ้าน">
                    </div>
                  </div>
                </th>

                <th>
                  <div class="filter-cell">
                    <div class="input-icon-wrap" style="max-width:140px">
                      <i class="bi bi-search"></i>
                      <input class="form-control form-control-sm"
                             name="fname" value="{{ $fname }}" placeholder="ชื่อ">
                    </div>
                  </div>
                </th>

                <th>
                  <div class="filter-cell">
                    <div class="input-icon-wrap" style="max-width:140px">
                      <i class="bi bi-search"></i>
                      <input class="form-control form-control-sm"
                             name="lname" value="{{ $lname }}" placeholder="นามสกุล">
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
                      <option value="1" @selected($sex === '1')>ชาย</option>
                      <option value="2" @selected($sex === '2')>หญิง</option>
                    </select>
                  </div>
                </th>

                <th>
                  <div class="filter-cell">
                    <div class="dropdown welfare-filter-dropdown">
                      <button class="btn btn-sm dropdown-toggle w-100"
                              type="button"
                              data-bs-toggle="dropdown"
                              data-bs-auto-close="outside"
                              aria-expanded="false"
                              style="background:#fff;border:1px solid #E2E8F0;text-align:left;">
                        <span>
                          <i class="bi bi-funnel-fill text-success me-1"></i>
                          ตัวกรองข้อมูลสวัสดิการ
                        </span>
                      </button>

                      <div class="dropdown-menu p-3 border-0 shadow rounded-4">
                        <div class="overflow-auto overflow-x-hidden" style="max-height:60vh;">
                          <div class="fw-semibold text-secondary mb-2">
                            ขั้นตอนที่ 1 : เลือกสถานะสวัสดิการ
                          </div>

                          <div class="d-flex gap-2 mb-3 flex-wrap">
                            <button type="button"
                                    class="btn btn-sm {{ $welfare==='' ? 'btn-success' : 'btn-outline-success' }}"
                                    onclick="setWelfare('', true)">
                              ทั้งหมด
                            </button>

                            <button type="button"
                                    class="btn btn-sm {{ $welfare==='received' ? 'btn-success' : 'btn-outline-success' }}"
                                    onclick="setWelfare('received', true)">
                              ได้รับสวัสดิการ
                            </button>

                            <button type="button"
                                    class="btn btn-sm {{ $welfare==='not_received' ? 'btn-secondary' : 'btn-outline-secondary' }}"
                                    onclick="setWelfare('not_received', true)">
                              ไม่ได้รับสวัสดิการ
                            </button>
                          </div>

                          <div id="welfareTypeSection">
                            <div class="fw-semibold text-secondary mb-2">
                              ขั้นตอนที่ 2 : เลือกประเภทสวัสดิการ
                            </div>

                            <div class="row g-2 mb-3">
                              @foreach($types as $key=>$label)
                                <div class="col-6">
                                  <label class="form-check w-100">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="welfare_type[]"
                                           value="{{ $key }}"
                                           @checked(in_array($key, $welfare_type))
                                           onchange="handleUnknownToggle(this); ensureReceived()">

                                    <span class="badge rounded-pill w-100 text-start d-block text-truncate
                                      {{ in_array($key,$welfare_type) ? 'bg-success-subtle text-success' : 'bg-light text-dark border' }}"
                                      style="padding:.6rem .75rem;" title="{{ $label }}">
                                      {{ $label }}
                                    </span>
                                  </label>
                                </div>
                              @endforeach
                            </div>

                            @if($typeCount > 1)
                              <div class="fw-semibold text-secondary mb-2">
                                ขั้นตอนที่ 3 : เงื่อนไขการแสดงผล
                              </div>

                              <div class="vstack gap-2 mb-3 small">
                                <label class="border rounded-3 p-2 d-flex gap-2">
                                  <input type="radio" class="form-check-input mt-1"
                                         name="welfare_match_ui"
                                         value="any"
                                         @checked($welfare_match==='any')
                                         onclick="setMatch('any')">
                                  <div>ได้รับ <strong>อย่างน้อย 1 ประเภท</strong></div>
                                </label>

                                <label class="border rounded-3 p-2 d-flex gap-2">
                                  <input type="radio" class="form-check-input mt-1"
                                         name="welfare_match_ui"
                                         value="all"
                                         @checked($welfare_match==='all')
                                         onclick="setMatch('all')">
                                  <div>ได้รับ <strong>ครบทุกประเภท</strong></div>
                                </label>
                              </div>
                            @endif
                          </div>
                        </div>

                        <div class="d-flex gap-2 pt-2 border-top">
                          <button type="button"
                                  class="btn btn-sm btn-outline-secondary w-100"
                                  onclick="clearWelfareTypes()">
                            ล้างการเลือก
                          </button>
                          <button type="submit"
                                  class="btn btn-sm btn-success w-100">
                            แสดงผลข้อมูล
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </th>

                <th><div class="filter-cell"></div></th>
              </tr>
            </thead>

            <tbody>
              @forelse($rows as $r)
                @php
                  $a70 = trim((string)($r->a7_0 ?? ''));
                  $isNotReceivedRow = ($a70 === '0');

                  $statusLabel = $isNotReceivedRow ? 'ไม่ได้รับ' : 'ได้รับ';
                  $statusClass = $isNotReceivedRow
                    ? 'bg-secondary-subtle text-secondary border'
                    : 'bg-success-subtle text-success border';

                  $wMap = [
                    'a7_1' => 'เด็กแรกเกิด',
                    'a7_2' => 'เบี้ยผู้สูงอายุ/คนชรา',
                    'a7_3' => 'เบี้ยคนพิการ',
                    'a7_4' => 'ประกันสังคม (ม.33)',
                    'a7_5' => 'ประกันตนเอง (ม.40)',
                    'a7_6' => 'บัตรสวัสดิการแห่งรัฐ',
                  ];

                  $isYes = function($v){
                    $v = trim((string)$v);
                    return $v !== '' && $v !== '0';
                  };

                  $receivedList = [];

                  if (!$isNotReceivedRow) {
                    $selectedCols = array_values(array_intersect($welfare_type, array_keys($wMap)));
                    $showCols = !empty($selectedCols) ? $selectedCols : array_keys($wMap);

                    foreach ($showCols as $col) {
                      if (isset($r->$col) && $isYes($r->$col)) {
                        $receivedList[] = $wMap[$col];
                      }
                    }

                    if (count($receivedList) === 0) {
                      $receivedList = ['ไม่ระบุ'];
                    }
                  }

                  $sexLabel = match((string)($r->a4 ?? '')) {
                    '1' => 'ชาย',
                    '2' => 'หญิง',
                    default => '-',
                  };
                @endphp

                <tr
                  data-order="{{ $r->a1 ?? '' }}"
                  data-house="{{ $r->HC ?? '' }}"
                  data-year="{{ $r->survey_year ?? '' }}"
                  data-house_number="{{ $r->house_number ?? '' }}"
                  data-village_no="{{ $r->village_no ?? '' }}"
                  data-village_name="{{ $r->village_name ?? '' }}"
                  data-postcode="{{ $r->postcode ?? '' }}"
                  data-subdistrict="{{ $r->tambon_name_thai ?? '' }}"
                  data-district="{{ $r->district_name_thai ?? '' }}"
                  data-lat="{{ $r->latx ?? '' }}"
                  data-lng="{{ $r->lngy ?? '' }}"
                  data-title=""
                  data-fname="{{ $r->a2_2 ?? '' }}"
                  data-lname="{{ $r->a2_3 ?? '' }}"
                  data-agey="{{ $r->a3_1 ?? '' }}"
                  data-sex="{{ match((string)($r->a4 ?? '')) {
                    '1' => 'ชาย',
                    '2' => 'หญิง',
                    default => '',
                  } }}"
                  data-cid="{{ $r->popid ?? '' }}"
                  data-phone="{{ $r->TEL ?? '' }}"
                  data-health=""
                  data-welfare='@json(array_values(array_unique($receivedList ?? [])))'
                >
                  <td class="ps-3 fw-semibold">{{ $r->survey_year ?? '-' }}</td>
                  <td class="fw-semibold">{{ $r->HC ?? '-' }}</td>
                  <td>{{ $r->a2_2 ?? '-' }}</td>
                  <td>{{ $r->a2_3 ?? '-' }}</td>
                  <td>{{ $r->a3_1 ?? '-' }}</td>
                  <td>{{ $sexLabel }}</td>

                  <td>
                    <span class="badge rounded-pill px-3 py-2 {{ $statusClass }}">
                      {{ $statusLabel }}
                    </span>
                  </td>

                  <td class="welfare-cell">
                    @if($isNotReceivedRow)
                      <span class="badge rounded-pill bg-secondary-subtle text-secondary border">-</span>
                    @else
                      <div class="d-flex flex-wrap gap-1">
                        @foreach(array_unique($receivedList) as $item)
                          <span class="badge rounded-pill bg-light text-dark border">{{ $item }}</span>
                        @endforeach
                      </div>
                    @endif
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
                  <td colspan="9" class="text-center ga-empty">ไม่พบข้อมูล</td>
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

      <div class="modal-header text-white"
           style="background:linear-gradient(135deg,#0B7F6F,#0B5B6B)">
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
                        บ้าน<span id="m_village_name"></span><br>
                        ตำบล<span id="m_subdistrict"></span>
                        อำเภอ<span id="m_district"></span>
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
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="border rounded-3 p-2 bg-success-subtle">
                      <div class="text-secondary small">สวัสดิการ</div>
                      <div class="fw-semibold" id="m_welfare"></div>
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
  function initWelfareDropdown() {
    document.querySelectorAll('.welfare-filter-dropdown > [data-bs-toggle="dropdown"]').forEach((el) => {
      if (el.dataset.ddInit === '1') return;
      el.dataset.ddInit = '1';

      new bootstrap.Dropdown(el, {
        autoClose: 'outside',
        popperConfig(defaultBsPopperConfig) {
          return {
            ...defaultBsPopperConfig,
            placement: 'bottom-start',
            strategy: 'fixed',
            modifiers: [
              ...(defaultBsPopperConfig.modifiers || []),
              {
                name: 'offset',
                options: { offset: [0, 8] }
              },
              {
                name: 'preventOverflow',
                options: {
                  boundary: 'viewport',
                  padding: 8
                }
              },
              {
                name: 'flip',
                options: {
                  boundary: 'viewport',
                  fallbackPlacements: ['top-start', 'right-start']
                }
              }
            ]
          };
        }
      });
    });
  }

  function handleUnknownToggle(changed){
    const unknown = document.querySelector('input[name="welfare_type[]"][value="unknown"]');
    if(!unknown) return;

    const others = Array.from(document.querySelectorAll('input[name="welfare_type[]"]'))
      .filter(x => x.value !== 'unknown');

    if(changed === unknown && unknown.checked){
      others.forEach(x => x.checked = false);
      setMatch('any');
      ensureReceived();
      return;
    }

    if(changed !== unknown && changed.checked){
      unknown.checked = false;
    }
  }

  function toggleWelfareTypeSection(){
    const welfare = document.getElementById('welfareHidden')?.value || '';
    const sec = document.getElementById('welfareTypeSection');
    if(!sec) return;

    if (welfare === 'not_received') {
      sec.classList.add('d-none');
      clearWelfareTypes();
      setMatch('any');
    } else {
      sec.classList.remove('d-none');
    }
  }

  function setMatch(val){
    const m = document.getElementById('welfareMatchHidden');
    if(m) m.value = val;
  }

  function showLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) overlay.style.display = 'flex';
  }

  function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) overlay.style.display = 'none';
  }

  function submitWithLoading(form, delay = 600) {
    if (!form) return;
    showLoading();
    setTimeout(() => form.submit(), delay);
  }

  function setWelfare(val, autoSubmit = false){
    const hidden = document.getElementById('welfareHidden');
    if(hidden) hidden.value = val;

    if(val !== 'received'){
      clearWelfareTypes();
      setMatch('any');
    }

    toggleWelfareTypeSection();

    if(autoSubmit){
      submitWithLoading(document.getElementById('filterForm'));
    }
  }

  function ensureReceived(){
    const hidden = document.getElementById('welfareHidden');
    if(hidden) hidden.value = 'received';

    const m = document.getElementById('welfareMatchHidden');
    if(m && !m.value) m.value = 'any';

    toggleWelfareTypeSection();
  }

  function clearWelfareTypes(){
    document.querySelectorAll('input[name="welfare_type[]"]').forEach(cb => cb.checked = false);
  }

  function openDetail(tr){
    if(!tr) return;
    const get = (k) => (tr.dataset[k] ?? '').toString().trim();
    const safe = (v, dash = '-') => (v && v.trim() !== '' ? v : dash);

    document.getElementById('m_house').textContent = safe(get('house'));
    document.getElementById('m_year').textContent  = safe(get('year'));
    document.getElementById('m_house_number').textContent = safe(get('house_number'));
    document.getElementById('m_village_no').textContent   = safe(get('village_no'));
    document.getElementById('m_village_name').textContent = safe(get('village_name'), '');
    document.getElementById('m_subdistrict').textContent  = safe(get('subdistrict'));
    document.getElementById('m_district').textContent     = safe(get('district'));
    document.getElementById('m_postcode').textContent     = safe(get('postcode'), '');
    document.getElementById('m_lat').textContent = safe(get('lat'));
    document.getElementById('m_lng').textContent = safe(get('lng'));

    document.getElementById('m_order').textContent = safe(get('order'));
    document.getElementById('m_fname').textContent = safe(get('fname'));
    document.getElementById('m_agey').textContent  = safe(get('agey'));
    document.getElementById('m_sex').textContent   = safe(get('sex'));
    document.getElementById('m_cid').textContent   = safe(get('cid'));
    document.getElementById('m_phone').textContent = safe(get('phone'));

    const lname = get('lname');
    const lnameWrap = document.getElementById('m_lname_wrap');
    const lnameEl = document.getElementById('m_lname');

    if(lname){
      lnameEl.textContent = lname;
      lnameWrap.classList.remove('d-none');
    }else{
      lnameEl.textContent = '';
      lnameWrap.classList.add('d-none');
    }

    const welfareEl = document.getElementById('m_welfare');
    if (welfareEl) {
      let list = [];
      try { list = JSON.parse(get('welfare') || '[]'); } catch (e) { list = []; }

      if (!Array.isArray(list) || list.length === 0) {
        welfareEl.innerHTML = '<span class="badge rounded-pill bg-light text-dark border">ไม่ระบุ</span>';
      } else {
        welfareEl.innerHTML = list
          .map(x => `<span class="badge rounded-pill bg-light text-dark border me-1 mb-1">${String(x)}</span>`)
          .join('');
      }
    }

    const lat = get('lat'), lng = get('lng');
    const mapWrap = document.getElementById('m_map_wrap');
    const mapEmpty = document.getElementById('m_map_empty');
    const mapIframe = document.getElementById('m_map_iframe');
    const mapLink = document.getElementById('m_map_link');

    if(lat && lng){
      const q = `${lat},${lng}`;
      if(mapIframe) mapIframe.src = `https://www.google.com/maps?q=${encodeURIComponent(q)}&z=16&output=embed`;
      if(mapWrap) mapWrap.style.display = '';
      if(mapEmpty) mapEmpty.style.display = 'none';
      if(mapLink){
        mapLink.href = `https://www.google.com/maps?q=${encodeURIComponent(q)}&z=16`;
        mapLink.classList.remove('d-none');
      }
    }else{
      if(mapWrap) mapWrap.style.display = 'none';
      if(mapEmpty) mapEmpty.style.display = '';
      if(mapLink) mapLink.classList.add('d-none');
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    initWelfareDropdown();
    toggleWelfareTypeSection();

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