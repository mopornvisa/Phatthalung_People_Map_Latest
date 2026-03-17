{{-- resources/views/sqlsrv_test.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />

  <title>SQLSRV Test</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    body{
      font-family:'Prompt',system-ui,sans-serif;
      min-height:100vh;
      background:
        radial-gradient(1200px 600px at 10% 0%, rgba(11,127,111,.10), transparent 55%),
        radial-gradient(1000px 600px at 90% 0%, rgba(15,155,216,.12), transparent 55%),
        linear-gradient(135deg,#CFEFF3 0%,#DFF7EF 50%,#F0F8FB 100%);
    }
    .pagination{ gap:6px; }
    .page-link{
      border-radius:999px!important;
      padding:6px 12px;
      border:1px solid #d7e2ea;
      color:#0B7F6F;
      font-size:13px;
    }
    .page-link:hover{ background:rgba(11,127,111,.08); border-color:#0B7F6F; color:#0B7F6F; }
    .page-item.active .page-link{ background:#0B7F6F; border-color:#0B7F6F; color:#fff; }
    .page-item.disabled .page-link{ color:#9aa7b2; background:#fff; }

    .shadow-soft{ box-shadow:0 12px 28px rgba(2,6,23,.08)!important; }
    thead th{ position: sticky; top: 0; z-index: 5; background: #f8fafc; }
  </style>
</head>

<body>

@include('layouts.topbar')

@php
  $teal  = '#0B7F6F';
  $teal2 = '#0B5B6B';
@endphp

<div class="container my-4">

  {{-- HEADER --}}
  <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
    <div class="fw-bold fs-5" style="color:{{ $teal2 }}">
      <i class="bi bi-database-check me-1"></i>
      SQL Server Test (sqlsrv)
    </div>

    <span style="display:inline-flex;align-items:center;gap:.4rem;
                 padding:.4rem .8rem;border-radius:999px;
                 border:1px solid {{ $teal }};
                 background:#E6F4F2;
                 color:{{ $teal2 }};
                 font-size:13px;">
      ทั้งหมด <strong>{{ number_format((int)$count) }}</strong> แถว
    </span>
  </div>

  {{-- CARD --}}
  <div style="background:rgba(255,255,255,.92);
              border:1px solid rgba(148,163,184,.35);
              box-shadow:0 18px 55px rgba(2,6,23,.10);
              border-radius:18px;">

    {{-- BAR --}}
    <div class="p-3 border-bottom">
      <div class="fw-semibold mb-3" style="color:{{ $teal2 }}">
        <i class="bi bi-table me-1"></i> เลือกตารางและค้นหาข้อมูล
      </div>

      <form method="GET" action="{{ route('sqlsrv.test') }}" class="row g-2 align-items-end">
        <div class="col-12 col-lg-4">
          <label class="form-label small text-muted mb-1">ตาราง</label>
          <select name="table" class="form-select form-select-sm">
            @foreach($tables as $t)
              <option value="{{ $t['full'] }}" @selected($selected === $t['full'])>
                {{ $t['full'] }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-12 col-lg-3">
          <label class="form-label small text-muted mb-1">ค้นหาทุกคอลัมน์</label>
          <input
            type="text"
            name="keyword"
            value="{{ request('keyword') }}"
            class="form-control form-control-sm"
            placeholder="พิมพ์คำค้น เช่น ชื่อ, HC, รหัส"
          >
        </div>

        <div class="col-12 col-lg-2">
          <label class="form-label small text-muted mb-1">ปี</label>
          <input
            type="number"
            name="year"
            value="{{ request('year') }}"
            class="form-control form-control-sm"
            placeholder="เช่น 2564"
          >
        </div>

        <div class="col-12 col-lg-1">
          <label class="form-label small text-muted mb-1">แถว</label>
          <select name="limit" class="form-select form-select-sm">
            @foreach([20,50,100,200] as $n)
              <option value="{{ $n }}" @selected((int)request('limit',20)===$n)>{{ $n }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-12 col-lg-2 d-flex gap-2">
          <button class="btn btn-sm fw-semibold w-100"
                  style="background:{{ $teal }};color:#fff;border-color:{{ $teal }};">
            <i class="bi bi-search me-1"></i> ค้นหา
          </button>

          <a href="{{ route('sqlsrv.test', ['table' => $selected]) }}"
             class="btn btn-sm btn-outline-secondary w-100">
            ล้าง
          </a>
        </div>
      </form>

      @if(request('keyword') || request('year'))
        <div class="mt-2 small text-muted">
          @if(request('keyword'))
            คำค้น: <span class="fw-semibold text-dark">"{{ request('keyword') }}"</span>
          @endif

          @if(request('keyword') && request('year'))
            <span class="mx-2">|</span>
          @endif

          @if(request('year'))
            ปี: <span class="fw-semibold text-dark">{{ request('year') }}</span>
          @endif
        </div>
      @endif
    </div>

    {{-- ERROR --}}
    @if(!empty($error))
      <div class="p-3 border-bottom">
        <div class="alert alert-danger mb-0">
          <div class="fw-semibold"><i class="bi bi-exclamation-triangle me-1"></i> เกิดข้อผิดพลาด</div>
          <div class="small mt-1" style="white-space:pre-wrap">{{ $error }}</div>
        </div>
      </div>
    @endif

    {{-- TABLE --}}
    <div class="table-responsive" style="max-height:70vh;">
      <table class="table table-bordered table-hover align-middle mb-0 text-nowrap">
        <thead class="table-light">
          <tr>
            @forelse($cols as $c)
              <th class="small text-muted">{{ $c }}</th>
            @empty
              <th class="text-muted">ไม่มีคอลัมน์</th>
            @endforelse
          </tr>
        </thead>

        <tbody>
          @forelse($rows as $r)
            @php $arr = (array)$r; @endphp
            <tr>
              @foreach($cols as $c)
                <td style="max-width:260px; overflow:hidden; text-overflow:ellipsis;">
                  {{ $arr[$c] ?? '' }}
                </td>
              @endforeach
            </tr>
          @empty
            <tr>
              <td colspan="{{ max(count($cols), 1) }}" class="text-center text-muted py-4">
                ไม่มีข้อมูล
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="p-2 border-top text-center bg-white small text-muted">
      แสดงข้อมูลตามเงื่อนไขที่เลือก และค้นหาได้ทั้งคำค้นทั่วไปกับปี
    </div>

  </div>
</div>

</body>
</html>