@extends('housing.layout')
@section('title','Dashboard สภาพบ้าน')
@section('content')

@php
  $teal  = '#0B7F6F';
  $teal2 = '#0B5B6B';

  $surveyYear = request('survey_year', '');
  $yearList = [2564,2565,2566,2567,2568];

  $cards = [
    ['label' => 'ครัวเรือนทั้งหมด',        'val' => $kpi['total'] ?? 0,       'icon' => 'bi-people'],
    ['label' => 'เคสด่วนมาก (คะแนน ≥ 75)', 'val' => $kpi['urgent'] ?? 0,      'icon' => 'bi-exclamation-triangle'],
    ['label' => 'บ้านทรุดโทรม',            'val' => $kpi['poor_house'] ?? 0,  'icon' => 'bi-house-heart'],
    ['label' => 'น้ำไม่เพียงพอ',           'val' => $kpi['water_short'] ?? 0, 'icon' => 'bi-droplet-half'],
  ];
@endphp

<style>
  :root{
    --teal: {{ $teal }};
    --teal2: {{ $teal2 }};
  }

  .pagination{
    gap:6px;
    margin-bottom:0;
  }

  .page-link{
    border-radius:999px !important;
    padding:6px 12px;
    border:1px solid #d7e2ea;
    color: var(--teal);
    font-size:13px;
  }

  .page-link:hover{
    background: rgba(11,127,111,.08);
    border-color: var(--teal);
    color: var(--teal);
  }

  .page-item.active .page-link{
    background: var(--teal) !important;
    border-color: var(--teal) !important;
    color:#fff !important;
  }

  .page-item.disabled .page-link{
    opacity:.55;
  }

  .kpi{
    border-radius:14px;
  }

  .kpi .icon{
    width:46px;
    height:46px;
    border-radius:14px;
    background: rgba(11,127,111,.12);
    color: var(--teal);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
  }

  .pp-title{
    background: linear-gradient(135deg, rgba(11,127,111,.12), rgba(11,91,107,.06));
    border-radius:14px;
  }

  .pp-note{
    font-size:12px;
    color:#6c757d;
  }
</style>

{{-- KPI --}}
<div class="row g-3 mb-3">
  @foreach($cards as $c)
    <div class="col-6 col-md-3">
      <div class="card kpi shadow-sm border-0">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="icon">
            <i class="bi {{ $c['icon'] }}"></i>
          </div>
          <div>
            <div class="text-secondary" style="font-size:12px;">{{ $c['label'] }}</div>
            <div class="fw-semibold fs-4">{{ number_format((int) ($c['val'] ?? 0)) }}</div>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>

{{-- หัวข้อ + ค้นหา --}}
<div class="card shadow-sm border-0 mb-3">
  <div class="card-body pp-title">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
      <div class="fw-semibold" style="color:var(--teal2);">
        <i class="bi bi-clipboard-check me-1"></i>
        สรุปข้อมูลสภาพบ้านและการเข้าถึงบริการ (เพื่อประกอบการพิจารณา)
      </div>

      <form method="GET" action="{{ route('housing.dashboard') }}" class="d-flex gap-2 flex-wrap">
        <select name="survey_year" class="form-select form-select-sm" style="width:120px;">
          <option value="">ทุกปี</option>
          @foreach($yearList as $y)
            <option value="{{ $y }}" @selected((string) $surveyYear === (string) $y)>{{ $y }}</option>
          @endforeach
        </select>

        <div class="input-group input-group-sm" style="width:260px;">
          <span class="input-group-text bg-white">
            <i class="bi bi-search"></i>
          </span>
          <input
            type="text"
            class="form-control"
            name="house_id"
            placeholder="ค้นหา รหัสครัวเรือน"
            value="{{ $houseId ?? request('house_id') }}"
          >
        </div>

        <button type="submit" class="btn btn-sm btn-success">ค้นหา</button>

        <a class="btn btn-sm btn-outline-secondary" href="{{ route('housing.dashboard') }}">
          ล้างค่า
        </a>
      </form>
    </div>

    <div class="pp-note mt-2">
      หมายเหตุ: ระบบจัดลำดับจากคะแนนความเร่งด่วนสูง → ต่ำ เพื่อช่วยคัดกรองการช่วยเหลือเชิงพื้นที่
    </div>
  </div>
</div>

{{-- รายการทั้งหมด --}}
<div class="card shadow-sm border-0">
  <div class="card-body">
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div class="fw-semibold">
        <i class="bi bi-list-ul me-1 text-primary"></i>
        รายการครัวเรือน (แสดงทั้งหมด)
      </div>

      <div class="text-secondary" style="font-size:12px;">
        จำนวนทั้งหมด:
        <b>{{ method_exists($rows, 'total') ? number_format($rows->total()) : number_format(count($rows ?? [])) }}</b>

        @if(method_exists($rows, 'firstItem') && $rows->total() > 0)
          <span class="ms-2">แสดง {{ number_format($rows->firstItem()) }}–{{ number_format($rows->lastItem()) }}</span>
        @endif
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th style="width:120px;">สถานะ</th>
            <th style="width:90px;">ปี</th>
            <th style="min-width:220px;">ครัวเรือน</th>
            <th style="min-width:220px;">พื้นที่</th>
            <th style="min-width:240px;">เจ้าบ้าน</th>
            <th style="min-width:240px;">สถานะการดำเนินการ</th>
            <th class="text-end" style="width:140px;">ดำเนินการ</th>
          </tr>
        </thead>

        <tbody>
          @forelse($rows as $r)
            @php
              $get = fn($k, $d = '') => is_array($r) ? ($r[$k] ?? $d) : ($r->$k ?? $d);

              $houseIdRow = trim((string) $get('house_Id', $get('house_id', '')));
              $status = $helpStatusMap[$houseIdRow] ?? null;

              $badgeClass = $status ? match($status) {
                'ดำเนินการ'   => 'bg-warning text-dark',
                'รอดำเนินการ' => 'bg-secondary',
                'เสร็จสิ้น'   => 'bg-success',
                'ติดตามผล'    => 'bg-info text-dark',
                default        => 'bg-light text-dark border',
              } : '';

              $yearValue = trim((string) $get('survey_Year', $get('survey_year', '')));
              $yearValue = $yearValue !== '' ? $yearValue : '-';

              $title = trim((string) $get('survey_Householder_title', ''));
              $fname = trim((string) $get('survey_Householder_fname', ''));
              $lname = trim((string) $get('survey_Householder_lname', ''));
              $fullName = trim($title . ' ' . $fname . ' ' . $lname);

              $houseNumber = trim((string) $get('house_Number', '-'));
              $villageNo   = trim((string) $get('village_No', $get('village_no', '-')));
              $villageName = trim((string) $get('village_Name', $get('village_name', '')));

              $villageText = trim(
                'บ้านเลขที่ ' . ($houseNumber !== '' ? $houseNumber : '-') . ' ' .
                'หมู่ ' . ($villageNo !== '' ? $villageNo : '-') . ' ' .
                $villageName
              );

              $subdistrict = trim((string) $get('survey_Subdistrict', $get('subdistrict', '-')));
              $district    = trim((string) $get('survey_District', $get('district', '-')));
              $province    = trim((string) $get('survey_Province', 'พัทลุง'));
              $postcode    = trim((string) $get('survey_Postcode', ''));

              $cid = trim((string) $get('survey_Householder_cid', ''));
            @endphp

            <tr>
              <td>
                <span class="badge {{ $get('badge', 'bg-secondary') }}">{{ $get('level', '-') }}</span>
                <div class="text-muted small">คะแนน {{ $get('score', 0) }}</div>
              </td>

              <td>
                <span class="fw-semibold" style="color:var(--teal);">
                  {{ $yearValue }}
                </span>
              </td>

              <td>
                <div class="fw-semibold">{{ $houseIdRow !== '' ? $houseIdRow : '-' }}</div>
                <div class="small text-muted">{{ $villageText !== '' ? $villageText : '-' }}</div>
              </td>

              <td>
                <div>ต.{{ $subdistrict !== '' ? $subdistrict : '-' }}</div>
                <div class="small text-muted">
                  อ.{{ $district !== '' ? $district : '-' }}
                  จ.{{ $province !== '' ? $province : '-' }}
                  {{ $postcode }}
                </div>
              </td>

              <td>
                <div>{{ $fullName !== '' ? $fullName : '-' }}</div>
                <div class="small text-muted">
                  เลขประจำตัวประชาชน {{ $cid !== '' ? $cid : '-' }}
                </div>
              </td>

              <td>
                @if($status)
                  <span class="badge rounded-pill {{ $badgeClass }}">{{ $status }}</span>
                @else
                  <span class="text-muted small">ยังไม่มีบันทึกการช่วยเหลือ</span>
                @endif
              </td>

              <td class="text-end">
                @if($houseIdRow !== '')
                  <a
                    href="{{ route('housing.show', $houseIdRow) }}?survey_year={{ $yearValue !== '-' ? urlencode($yearValue) : '' }}"
                    class="btn btn-sm text-white"
                    style="background:#0B7F6F;border-color:#0B7F6F;"
                  >
                    ดูรายละเอียด
                  </a>
                @else
                  <span class="text-muted small">ไม่มีรหัสครัวเรือน</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted">
                ไม่พบข้อมูล
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if(method_exists($rows, 'links'))
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
        <div class="small text-muted">
          หน้า {{ $rows->currentPage() }} / {{ $rows->lastPage() }}
        </div>
        <div>
          {{ $rows->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
      </div>
    @endif
  </div>
</div>

@endsection