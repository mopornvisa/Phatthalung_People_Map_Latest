{{-- resources/views/household_64.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">

@php
  $survey_year = $survey_year ?? request('survey_year','');
@endphp

<title>ข้อมูลครัวเรือน {{ $survey_year ? "ปี {$survey_year}" : "ทุกปี" }}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    padding:0 14px 12px 14px;
    overflow-x:auto !important;
    overflow-y:visible !important;
    position:relative;
  }

  .ga-table{
    width:100%;
    min-width:1800px;
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
    padding:8px 6px;
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
    z-index:5;
    vertical-align:top;
  }

  .ga-table tbody td{
    border:1px solid #d5dfeb;
    padding:7px 6px;
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

  .ga-empty{
    padding:28px 10px !important;
    color:#94a3b8;
    font-size:13px;
  }

  .subcode{
    font-size:11px;
    color:#6b7280;
    line-height:1.1;
    margin-top:2px;
  }

  .ga-badge-soft{
    display:inline-flex;
    align-items:center;
    gap:.35rem;
    padding:.38rem .7rem;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
  }

  .ga-badge-green{
    background:#dcfce7;
    color:#166534;
    border:1px solid #bbf7d0;
  }

  .ga-badge-red{
    background:#fee2e2;
    color:#b91c1c;
    border:1px solid #fecaca;
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
    from{ opacity: 0; transform: translateY(8px); }
    to{ opacity: 1; transform: translateY(0); }
  }

  @media (max-width: 992px){
    .ga-filter-actions{
      justify-content:flex-start;
      flex-direction:column;
      align-items:stretch;
    }
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
  @media (max-width: 768px){
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

    .loading-ring{
      width: 90px;
      height: 90px;
    }

    .loading-text{
      font-size: 14px;
    }
    
  }
  .detail-section{
  background:#ffffff;
  border:1px solid #dbe7ef;
  border-radius:16px;
  overflow:hidden;
  box-shadow:0 8px 18px rgba(15,23,42,.05);
}

.detail-section-title{
  padding:11px 14px;
  background:linear-gradient(135deg,#eef7f7,#f8fbff);
  border-bottom:1px solid #dbe7ef;
  font-size:13px;
  font-weight:700;
  color:#0B5B6B;
  display:flex;
  align-items:center;
  gap:8px;
}

.detail-table{
  font-size:13px;
}

.detail-table th{
  width:22%;
  background:#f8fafc;
  color:#475569;
  font-weight:700;
  border-color:#e5edf4 !important;
  padding:10px 12px !important;
  white-space:nowrap;
}

.detail-table td{
  width:28%;
  color:#0f172a;
  font-weight:600;
  border-color:#e5edf4 !important;
  padding:10px 12px !important;
  background:#fff;
}
</style>
</head>

<body class="app-bg">

@include('layouts.topbar')

@php
  $teal  = '#0B7F6F';
  $teal2 = '#0B5B6B';

  $prefixMap = [
    '1' => 'เด็กชาย',
    '2' => 'เด็กหญิง',
    '3' => 'นาย',
    '4' => 'นางสาว',
    '5' => 'นาง',
  ];

  $q          = request('q','');
  $survey_no  = request('survey_no','');

  $HC         = request('HC','');
  $AGRI       = request('AGRI','');
  $AGRI_NO    = request('AGRI_NO','');
  $MBNO       = request('MBNO','');
  $MB         = request('MB','');
  $MM         = request('MM','');
  $TMP        = request('TMP','');
  $AMP        = request('AMP','');
  $JUN        = request('JUN','');
  $POSTCODE   = request('POSTCODE','');
  $PREFIX     = request('PREFIX','');
  $PERSON     = request('PERSON','');
  $popid      = request('popid','');
  $TEL        = request('TEL','');

  $tambon_name_thai   = request('tambon_name_thai','');
  $district_name_thai = request('district_name_thai','');
  $province_name_thai = request('province_name_thai','');

  $yearList = $yearList ?? [2564,2565,2566,2567,2568];

  $surveys      = $surveys ?? collect();
  $totalRows    = method_exists($surveys, 'total') ? (int)$surveys->total() : (int)$surveys->count();
  $canPaginate  = method_exists($surveys, 'links');

  $tableName   = $tableName ?? 'survey_profile64';
  $debugCount  = $debugCount ?? $totalRows;

  $houseCount = method_exists($surveys, 'count') ? $surveys->count() : count($surveys);
  $agriYesCount = collect(method_exists($surveys, 'items') ? $surveys->items() : $surveys)
      ->filter(function($row){
          $v = strtolower(trim((string) data_get($row,'AGRI','')));
          return in_array($v, ['1','y','yes','มี','true'], true);
      })->count();
@endphp

<div class="page-wrap">
  <div class="ga-page shadow-soft">

    <div class="ga-topbar">
      <div class="ga-brand">
        <div>
          <div class="ga-title">
            <i class="bi bi-table"></i>
            <span>ข้อมูลครัวเรือน {{ $survey_year ? "ปี {$survey_year}" : "ทุกปี" }}</span>
          </div>
          <div class="ga-subtitle">
            แสดงข้อมูลครัวเรือนพร้อมตัวกรองค้นหาและรายละเอียดรายแถว
          </div>
        </div>

        <span class="ga-chip">
          ทั้งหมด <strong>{{ number_format($totalRows) }}</strong> รายการ
        </span>
      </div>
    </div>

    <div class="ga-filter-card">
      <form method="GET" action="{{ route('household_64') }}" id="searchForm">
        @php
  $actionUrl = route('household_64');

  $baseQueryParams = array_filter([
      'q' => $q,
      'survey_year' => $survey_year,
      'HC' => $HC,
      'popid' => $popid,
      'TEL' => $TEL,
  ], fn($v) => $v !== '' && $v !== null);
@endphp

<div class="row g-3 align-items-end mb-3">
  <div class="col-md-3">
    <label class="ga-filter-label">อำเภอ</label>
    <div class="dropdown">
      <button class="btn ga-btn-light w-100 dropdown-toggle"
        type="button"
        data-bs-toggle="dropdown"
        data-no-loading="1">
    <i class="bi bi-geo-alt-fill me-1"></i>
    {{ !empty($district_name_thai) ? "อ.{$district_name_thai}" : "เลือกอำเภอ" }}
</button>

      <ul class="dropdown-menu rounded-4 border-0 shadow w-100">
        <li>
          <a class="dropdown-item text-danger"
             href="{{ $actionUrl }}?{{ http_build_query(array_merge($baseQueryParams, [
               'district_name_thai'=>'',
               'tambon_name_thai'=>'',
             ])) }}">
            ล้างตัวกรองอำเภอ
          </a>
        </li>

        <li><hr class="dropdown-divider"></li>

        @foreach($districtList ?? [] as $d)
          <li>
            <a class="dropdown-item"
               href="{{ $actionUrl }}?{{ http_build_query(array_merge($baseQueryParams, [
                 'district_name_thai'=>$d,
                 'tambon_name_thai'=>'',
               ])) }}">
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
        type="button"
        data-bs-toggle="dropdown"
        data-no-loading="1"
        @if(empty($district_name_thai)) disabled @endif>
    <i class="bi bi-pin-map-fill me-1"></i>
    {{ !empty($tambon_name_thai) ? "ต.{$tambon_name_thai}" : "เลือกตำบล" }}
</button>

      <ul class="dropdown-menu rounded-4 border-0 shadow w-100">
        <li>
          <a class="dropdown-item text-danger"
             href="{{ $actionUrl }}?{{ http_build_query(array_merge($baseQueryParams, [
               'district_name_thai'=>$district_name_thai,
               'tambon_name_thai'=>'',
             ])) }}">
            ล้างตัวกรองตำบล
          </a>
        </li>

        <li><hr class="dropdown-divider"></li>

        @foreach($subdistrictList ?? [] as $sd)
         <li>
    <a class="dropdown-item"
       data-no-loading="1"
       href="{{ $actionUrl }}?{{ http_build_query(array_merge($baseQueryParams, [
            'district_name_thai'=>$district_name_thai,
            'tambon_name_thai'=>$sd,
       ])) }}">
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
       href="{{ route('household_64.export', request()->query()) }}"
       onclick="showLoading(); setTimeout(hideLoading, 2500);">
      <i class="bi bi-file-earmark-excel-fill"></i>
      Export Excel
    </a>
  </div>

  <div class="col-md-3">
    <label class="ga-filter-label">รีเซ็ตตัวกรอง</label>
    <a class="btn ga-btn-light w-100" href="{{ route('household_64') }}">
      <i class="bi bi-arrow-clockwise me-1"></i>
      ล้างทั้งหมด
    </a>
  </div>
</div>
        @foreach(request()->except('q','page') as $k => $v)
          @if(is_scalar($v) && $v !== '' && $v !== null)
            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
          @endif
        @endforeach

 <div class="ga-filter-actions">

    <div class="ga-filter-actions-text">
        <i class="bi bi-info-circle"></i>

        <div>
            <div style="font-weight:700; color:#0f172a;">
                ข้อมูลตามตัวกรองปัจจุบัน
            </div>

            <div style="font-size:12px; color:#64748b;">
                กด Enter ในช่องกรองตารางเพื่อค้นหาได้ทันที
            </div>
        </div>
    </div>

  
          <div class="ga-chip">
            พบข้อมูลตามเงื่อนไข <strong>{{ number_format($debugCount) }}</strong> แถว
          </div>
        </div>
      </form>
    </div>

    <div class="row g-3 mb-3">
      <div class="col-md-4">
        <div class="ga-kpi">
          <div class="ga-kpi-label">จำนวนรายการในหน้าปัจจุบัน</div>
          <h3 class="ga-kpi-value">{{ number_format($houseCount) }}</h3>
        </div>
      </div>

      <div class="col-md-4">
        <div class="ga-kpi">
          <div class="ga-kpi-label">จำนวนครัวเรือนเกษตร</div>
          <h3 class="ga-kpi-value">{{ number_format($agriYesCount) }}</h3>
        </div>
      </div>

      <div class="col-md-4">
        <div class="ga-kpi">
          <div class="ga-kpi-label">จำนวนรายการทั้งหมด</div>
          <h3 class="ga-kpi-value">{{ number_format($totalRows) }}</h3>
        </div>
      </div>
    </div>

    <div class="ga-note">
      <i class="bi bi-info-circle me-1"></i>
      ตารางด้านล่างสามารถกรองรายคอลัมน์ได้ เช่น ปี บ้านเลขที่ หมู่บ้าน ตำบล อำเภอ จังหวัด เลขบัตร และเบอร์โทรศัพท์
    </div>

    <div class="ga-table-panel">
      <div class="ga-table-head">
        <div>
          <div class="ga-table-head-title">ตารางข้อมูลครัวเรือน</div>
          <div class="ga-table-head-sub">แสดงข้อมูลเลขครัวเรือน ที่อยู่ ข้อมูลบุคคล และข้อมูลติดต่อ</div>
        </div>
      </div>

      <form method="GET" action="{{ route('household_64') }}" id="filterForm">
        @if($q !== '')
          <input type="hidden" name="q" value="{{ $q }}">
        @endif

        <div class="table-responsive">
          <table class="table ga-table table-hover align-middle mb-0 text-nowrap">
            <thead>

<tr>
    <th>เลขครัวเรือน</th>
    <th>ปี</th>
    <th>เลขบัตรประชาชน</th>
    <th>บ้านเลขที่</th>
    <th>หมู่ที่</th>
    <th>หมู่บ้าน</th>
    <th>ตำบล</th>
    <th>อำเภอ</th>
    <th>ชื่อ</th>
    <th>โทร</th>
    <th>รายละเอียด</th>
</tr>

<tr class="filter-row">

    <th>
        <input name="HC"
               value="{{ $HC }}"
               class="form-control form-control-sm"
               placeholder="เลขครัวเรือน">
    </th>

    <th>
        <select name="survey_year" class="form-select form-select-sm">
            <option value="">ทั้งหมด</option>

            @foreach($yearList as $y)
                <option value="{{ $y }}"
                    @selected((string)$survey_year === (string)$y)>
                    {{ $y }}
                </option>
            @endforeach
        </select>
    </th>

    <th>
        <input name="popid"
               value="{{ $popid }}"
               class="form-control form-control-sm"
               placeholder="เลขบัตร">
    </th>

    <th>
        <input name="MBNO"
               value="{{ $MBNO }}"
               class="form-control form-control-sm"
               placeholder="บ้านเลขที่">
    </th>

    <th>
        <input name="MB"
               value="{{ $MB }}"
               class="form-control form-control-sm"
               placeholder="หมู่ที่">
    </th>

    <th>
        <input name="MM"
               value="{{ $MM }}"
               class="form-control form-control-sm"
               placeholder="หมู่บ้าน">
    </th>

    <th>
    <select name="tambon_name_thai"
            class="form-select form-select-sm">

        <option value="">ตำบล</option>

        @foreach($subdistrictList ?? [] as $sd)
            <option value="{{ $sd }}"
                @selected($tambon_name_thai == $sd)>
                {{ $sd }}
            </option>
        @endforeach

    </select>
</th>

<th>
    <select name="district_name_thai"
            class="form-select form-select-sm">

        <option value="">อำเภอ</option>

        @foreach($districtList ?? [] as $d)
            <option value="{{ $d }}"
                @selected($district_name_thai == $d)>
                {{ $d }}
            </option>
        @endforeach

    </select>
</th>

    <th>
        <input name="PERSON"
               value="{{ $PERSON }}"
               class="form-control form-control-sm"
               placeholder="ชื่อ">
    </th>

    <th>
        <input name="TEL"
               value="{{ $TEL }}"
               class="form-control form-control-sm"
               placeholder="โทร">
    </th>

    <th></th>

</tr>

</thead>
            <tbody>
            @forelse($surveys as $row)
              @php
                $agriVal = strtolower(trim((string) data_get($row,'AGRI','')));
                $hasAgri = in_array($agriVal, ['1','y','yes','มี','true'], true);

                $prefixVal   = trim((string) data_get($row,'PREFIX',''));
                $prefixLabel = $prefixMap[$prefixVal] ?? ($prefixVal ?: '-');
              @endphp

              
               <tr>

    <td class="fw-semibold">
        {{ data_get($row,'HC') ?: '-' }}
    </td>

    <td>
        {{ data_get($row,'survey_year') ?: '-' }}
    </td>

    <td class="font-monospace">
        {{ data_get($row,'popid') ?: '-' }}
    </td>

    <td>
        {{ data_get($row,'MBNO') ?: '-' }}
    </td>

    <td>
        {{ data_get($row,'MB') ?: '-' }}
    </td>

    <td>
        {{ data_get($row,'MM') ?: '-' }}
    </td>

    <td>
        {{ data_get($row,'tambon_name_thai') ?: '-' }}
    </td>

    <td>
        {{ data_get($row,'district_name_thai') ?: '-' }}
    </td>

    <td>
        {{ data_get($row,'PERSON') ?: '-' }}
    </td>

    <td>
        {{ data_get($row,'TEL') ?: '-' }}
    </td>

    <td class="text-end pe-3" style="width:1%;white-space:nowrap;">

    <button type="button"
            class="btn btn-sm fw-semibold d-inline-flex align-items-center gap-1"
            style="
                background:linear-gradient(135deg,#0ea5a4 0%,#2d74da 100%);
                color:#fff;
                border:none;
                border-radius:14px;
                padding:.5rem .9rem;
                box-shadow:0 8px 18px rgba(45,116,218,.18);
            "
            data-bs-toggle="modal"
            data-bs-target="#householdDetailModal"

            data-hc="{{ data_get($row,'HC') }}"
            data-year="{{ data_get($row,'survey_year') }}"
            data-survey-no="{{ data_get($row,'survey_no') }}"
            data-agri="{{ $hasAgri ? 'มี' : 'ไม่มี' }}"
            data-agri-no="{{ data_get($row,'AGRI_NO') }}"
            data-mbno="{{ data_get($row,'MBNO') }}"
            data-mb="{{ data_get($row,'MB') }}"
            data-mm="{{ data_get($row,'MM') }}"
            data-tambon="{{ data_get($row,'tambon_name_thai') }}"
            data-district="{{ data_get($row,'district_name_thai') }}"
            data-province="{{ data_get($row,'province_name_thai') }}"
            data-postcode="{{ data_get($row,'POSTCODE') }}"
            data-prefix="{{ $prefixLabel }}"
            data-person="{{ data_get($row,'PERSON') }}"
            data-popid="{{ data_get($row,'popid') }}"
            data-tel="{{ data_get($row,'TEL') }}">

        <i class="bi bi-eye"></i>
        <span>ดูรายละเอียด</span>

    </button>

</td>

</tr>
            @empty
              <tr>
                <td colspan="17" class="text-center ga-empty">ไม่มีข้อมูล</td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </form>

      @if($canPaginate)
        <div class="p-3 border-top text-center bg-white">
          {{ $surveys->links('pagination::bootstrap-5') }}
        </div>
      @endif
    </div>

  </div>
</div>
<div class="modal fade" id="householdDetailModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg" style="border-radius:18px; overflow:hidden;">

      <div class="modal-header text-white border-0"
           style="background:linear-gradient(135deg,#0B5B6B,#0B7F6F);">
        <div>
          <h6 class="modal-title fw-bold mb-1">
            <i class="bi bi-house-door-fill me-2"></i>
            รายละเอียดข้อมูลครัวเรือน
          </h6>
          <div style="font-size:12px; opacity:.85;">
            ข้อมูลจากฐานข้อมูลครัวเรือนจังหวัดพัทลุง
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" style="background:#f4f8fb; padding:18px;">

        <div class="detail-section">
          <div class="detail-section-title">
            <i class="bi bi-card-checklist"></i> ข้อมูลหลัก
          </div>

          <table class="table detail-table mb-0">
            <tbody>
              <tr>
                <th>เลขครัวเรือน</th>
                <td id="d_hc">-</td>
                <th>ปีที่สำรวจ</th>
                <td id="d_year">-</td>
              </tr>
              <tr>
                <th>ครั้งที่สำรวจ</th>
                <td id="d_surveyNo">-</td>
                <th>สมุดเกษตร</th>
                <td id="d_agri">-</td>
              </tr>
              <tr>
                <th>เลขเกษตร</th>
                <td id="d_agriNo">-</td>
                <th>รหัสไปรษณีย์</th>
                <td id="d_postcode">-</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="detail-section mt-3">
          <div class="detail-section-title">
            <i class="bi bi-geo-alt-fill"></i> ที่อยู่
          </div>

          <table class="table detail-table mb-0">
            <tbody>
              <tr>
                <th>บ้านเลขที่</th>
                <td id="d_mbno">-</td>
                <th>หมู่ที่</th>
                <td id="d_mb">-</td>
              </tr>
              <tr>
                <th>หมู่บ้าน</th>
                <td id="d_mm">-</td>
                <th>ตำบล</th>
                <td id="d_tambon">-</td>
              </tr>
              <tr>
                <th>อำเภอ</th>
                <td id="d_district">-</td>
                <th>จังหวัด</th>
                <td id="d_province">-</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="detail-section mt-3">
          <div class="detail-section-title">
            <i class="bi bi-person-vcard-fill"></i> ข้อมูลบุคคล/ติดต่อ
          </div>

          <table class="table detail-table mb-0">
            <tbody>
              <tr>
                
                <th>ชื่อผู้ให้ข้อมูล</th>
                <td id="d_person">-</td>
              </tr>
              <tr>
                <th>เลขบัตรประชาชน</th>
                <td id="d_popid" class="font-monospace">-</td>
                <th>เบอร์โทรศัพท์</th>
                <td id="d_tel" class="font-monospace">-</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>

      <div class="modal-footer border-0 bg-white">
        <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
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

function showLoadingThenSubmit(form, delay = 700){
  if (!form) return;
  showLoading();
  setTimeout(() => form.submit(), delay);
}

document.addEventListener('DOMContentLoaded', function(){
  const searchForm = document.getElementById('searchForm');
  const filterForm = document.getElementById('filterForm');

  document.addEventListener('keydown', function(e){
    if (e.key === 'Enter' && e.target.closest('#filterForm thead')) {
      e.preventDefault();
      showLoadingThenSubmit(filterForm, 500);
    }
  });

  document.querySelectorAll('#filterForm thead select').forEach(el => {
    el.addEventListener('change', () => showLoadingThenSubmit(filterForm, 500));
  });

  if (searchForm) {
    searchForm.addEventListener('submit', function(e){
      e.preventDefault();
      showLoadingThenSubmit(searchForm);
    });
  }

  if (filterForm) {
    filterForm.addEventListener('submit', function(e){
      e.preventDefault();
      showLoadingThenSubmit(filterForm);
    });
  }

 document.querySelectorAll('a[href]').forEach(link => {
  link.addEventListener('click', function(){
    if (
      link.classList.contains('dropdown-item') ||
      link.href.includes('/export') ||
      link.dataset.noLoading === '1'
    ) {
      return;
    }

    showLoading();
  });
});
const detailModal = document.getElementById('householdDetailModal');

if (detailModal) {
  detailModal.addEventListener('show.bs.modal', function (event) {
    const btn = event.relatedTarget;

    [
      'hc','year','surveyNo','agri','agriNo','mbno','mb','mm',
      'tambon','district','province','postcode','prefix','person','popid','tel'
    ].forEach(key => {
      const el = document.getElementById('d_' + key);
      if (el) el.textContent = btn.dataset[key] || '-';
    });
  });
}
  window.addEventListener('pageshow', function(){
    hideLoading();
  });

});
const householdDetailModal = document.getElementById('householdDetailModal');

if (householdDetailModal) {

    householdDetailModal.addEventListener('show.bs.modal', function (event) {

        const btn = event.relatedTarget;

        const setText = (id, value) => {
            const el = document.getElementById(id);
            if (el) el.textContent = value || '-';
        };

        setText('d_hc', btn.dataset.hc);
        setText('d_year', btn.dataset.year);
        setText('d_surveyNo', btn.dataset.surveyNo);
        setText('d_agri', btn.dataset.agri);
        setText('d_agriNo', btn.dataset.agriNo);
        setText('d_mbno', btn.dataset.mbno);
        setText('d_mb', btn.dataset.mb);
        setText('d_mm', btn.dataset.mm);
        setText('d_tambon', btn.dataset.tambon);
        setText('d_district', btn.dataset.district);
        setText('d_province', btn.dataset.province);
        setText('d_postcode', btn.dataset.postcode);
        setText('d_prefix', btn.dataset.prefix);
        setText('d_person', btn.dataset.person);
        setText('d_popid', btn.dataset.popid);
        setText('d_tel', btn.dataset.tel);

    });

}
</script>

</body>
</html>