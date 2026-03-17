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

  .pagination{ gap:6px }
  .page-link{
    border-radius:999px!important;
    padding:6px 12px;
    border:1px solid #d7e2ea;
    color:#0B7F6F;
    font-size:13px
  }
  .page-link:hover{ background:rgba(11,127,111,.08); border-color:#0B7F6F; color:#0B7F6F }
  .page-item.active .page-link{ background:#0B7F6F; border-color:#0B7F6F; color:#fff }
  .page-item.disabled .page-link{ color:#9aa7b2; background:#fff }

  thead .filter-row th{
    background:#fff;
    position:sticky;
    top:42px;
    z-index:5;
    vertical-align:top;
  }

  .subcode{
    font-size:11px;
    color:#6b7280;
    line-height:1.1;
    margin-top:2px;
  }

  .card-shell{
    background:rgba(255,255,255,.92);
    border:1px solid rgba(148,163,184,.35);
    box-shadow:0 18px 55px rgba(2,6,23,.10);
    border-radius:18px;
    overflow:hidden;
  }

  .table > :not(caption) > * > *{
    vertical-align:middle;
  }

  .badge-soft{
    display:inline-flex;
    align-items:center;
    gap:.4rem;
    padding:.4rem .8rem;
    border-radius:999px;
    border:1px solid #0B7F6F;
    background:#E6F4F2;
    color:#0B5B6B;
    font-size:13px;
  }
</style>
</head>

<body>

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
@endphp

<div class="container my-4">

  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
    <div>
      <div class="fw-bold fs-5" style="color:{{ $teal2 }}">
        <i class="bi bi-table me-1"></i>
        ข้อมูลครัวเรือน {{ $survey_year ? "ปี {$survey_year}" : "ทุกปี" }}
      </div>
      <div class="text-muted small">
        ตารางที่ใช้: <b>{{ $tableName }}</b> |
        พบข้อมูลตามเงื่อนไข: <b>{{ number_format($debugCount) }}</b> แถว
      </div>
    </div>

    <span class="badge-soft">
      ทั้งหมด <strong>{{ number_format($totalRows) }}</strong> รายการ
    </span>
  </div>

  <div class="card-shell">

    <div class="p-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div class="fw-semibold" style="color:{{ $teal2 }}">
        <i class="bi bi-search me-1"></i> ค้นหา
      </div>

      <form method="GET" action="{{ route('household_64') }}" class="d-flex">
        @foreach(request()->except('q','page') as $k => $v)
          @if(is_scalar($v) && $v !== '' && $v !== null)
            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
          @endif
        @endforeach

        <div class="input-group input-group-sm" style="width:460px;max-width:100%;">
          <span class="input-group-text bg-white">
            <i class="bi bi-search text-secondary"></i>
          </span>
          <input name="q" value="{{ $q }}" class="form-control"
                 placeholder="ค้นหา (HC/ชื่อ/หมู่บ้าน/popid/TEL...)">
          <button class="btn fw-semibold" style="background:{{ $teal }};color:#fff;border-color:{{ $teal }};">
            ค้นหา
          </button>
        </div>
      </form>
    </div>

    <form method="GET" action="{{ route('household_64') }}" id="filterForm">
      @if($q !== '')
        <input type="hidden" name="q" value="{{ $q }}">
      @endif

      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0 text-nowrap">
          <thead class="table-light">
            <tr>
              <th>เลขครัวเรือน</th>
              <th>ปี</th>
              <th>ครั้ง</th>
              <th>สมุดเกษตร</th>
              <th>เลขเกษตร</th>
              <th>บ้านเลขที่</th>
              <th>หมู่ที่</th>
              <th>หมู่บ้าน</th>
              <th>ตำบล</th>
              <th>อำเภอ</th>
              <th>จังหวัด</th>
              <th>ไปรษณีย์</th>
              <th>คำนำหน้า</th>
              <th>ชื่อ</th>
              <th>เลขบัตร</th>
              <th>โทร</th>
            </tr>

            <tr class="filter-row">
              <th>
                <input name="HC" value="{{ $HC }}" class="form-control form-control-sm" placeholder="เลขครัวเรือน">
              </th>

              <th>
                <select name="survey_year" class="form-select form-select-sm">
                  <option value="">ทั้งหมด</option>
                  @foreach($yearList as $y)
                    <option value="{{ $y }}" @selected((string)$survey_year === (string)$y)>{{ $y }}</option>
                  @endforeach
                </select>
              </th>

              <th>
                <input name="survey_no" value="{{ $survey_no }}" class="form-control form-control-sm" placeholder="ครั้ง">
              </th>

              <th>
                <select name="AGRI" class="form-select form-select-sm">
                  <option value="">ทั้งหมด</option>
                  <option value="1" @selected($AGRI=='1' || $AGRI=='มี')>มี</option>
                  <option value="0" @selected($AGRI=='0' || $AGRI=='ไม่มี')>ไม่มี</option>
                </select>
              </th>

              <th>
                <input name="AGRI_NO" value="{{ $AGRI_NO }}" class="form-control form-control-sm" placeholder="เลขเกษตร">
              </th>

              <th>
                <input name="MBNO" value="{{ $MBNO }}" class="form-control form-control-sm" placeholder="บ้านเลขที่">
              </th>

              <th>
                <input name="MB" value="{{ $MB }}" class="form-control form-control-sm" placeholder="หมู่ที่">
              </th>

              <th>
                <input name="MM" value="{{ $MM }}" class="form-control form-control-sm" placeholder="หมู่บ้าน">
              </th>

              <th>
                <input name="tambon_name_thai"
                       value="{{ $tambon_name_thai }}"
                       class="form-control form-control-sm"
                       placeholder="ตำบล">
              </th>

              <th>
                <input name="district_name_thai"
                       value="{{ $district_name_thai }}"
                       class="form-control form-control-sm"
                       placeholder="อำเภอ">
              </th>

              <th>
                <input name="province_name_thai"
                       value="{{ $province_name_thai }}"
                       class="form-control form-control-sm"
                       placeholder="จังหวัด">
              </th>

              <th>
                <input name="POSTCODE" value="{{ $POSTCODE }}" class="form-control form-control-sm" placeholder="ไปรษณีย์">
              </th>

              <th>
                <select name="PREFIX" class="form-select form-select-sm">
                  <option value="">ทั้งหมด</option>
                  @foreach($prefixMap as $k => $label)
                    <option value="{{ $k }}" @selected((string)$PREFIX === (string)$k)>{{ $k }} - {{ $label }}</option>
                  @endforeach
                </select>
              </th>

              <th>
                <input name="PERSON" value="{{ $PERSON }}" class="form-control form-control-sm" placeholder="ชื่อ">
              </th>

              <th>
                <input name="popid" value="{{ $popid }}" class="form-control form-control-sm" placeholder="เลขบัตร">
              </th>

              <th>
                <input name="TEL" value="{{ $TEL }}" class="form-control form-control-sm" placeholder="โทร">
              </th>
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
              <td class="fw-semibold">{{ data_get($row,'HC') ?: '-' }}</td>
              <td>{{ data_get($row,'survey_year') ?: '-' }}</td>
              <td>{{ data_get($row,'survey_no') ?: '-' }}</td>

              <td>
                @if($hasAgri)
                  <span class="badge bg-success">มี</span>
                @else
                  <span class="badge bg-danger">ไม่มี</span>
                @endif
              </td>

              <td>
                {{ $hasAgri ? (data_get($row,'AGRI_NO') ?: '-') : '-' }}
              </td>

              <td>{{ data_get($row,'MBNO') ?: '-' }}</td>
              <td>{{ data_get($row,'MB') ?: '-' }}</td>
              <td>{{ data_get($row,'MM') ?: '-' }}</td>

              <td>
                {{ data_get($row,'tambon_name_thai') ?: '-' }}
                <div class="subcode">{{ data_get($row,'TMP') ?: '-' }}</div>
              </td>

              <td>
                {{ data_get($row,'district_name_thai') ?: '-' }}
                <div class="subcode">{{ data_get($row,'AMP') ?: '-' }}</div>
              </td>

              <td>
                {{ data_get($row,'province_name_thai') ?: '-' }}
                <div class="subcode">{{ data_get($row,'JUN') ?: '-' }}</div>
              </td>

              <td>{{ data_get($row,'POSTCODE') ?: '-' }}</td>

              <td>
                {{ $prefixLabel }}
                <div class="subcode">{{ $prefixVal ?: '-' }}</div>
              </td>

              <td>{{ data_get($row,'PERSON') ?: '-' }}</td>
              <td class="font-monospace">{{ data_get($row,'popid') ?: '-' }}</td>
              <td>{{ data_get($row,'TEL') ?: '-' }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="16" class="text-center text-muted py-4">ไม่มีข้อมูล</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </form>

    @if($canPaginate)
      <div class="p-2 border-top text-center bg-white">
        {{ $surveys->links('pagination::bootstrap-5') }}
      </div>
    @endif
  </div>
</div>

<script>
document.addEventListener('keydown', function(e){
  if (e.key === 'Enter' && e.target.closest('thead')) {
    e.preventDefault();
    document.getElementById('filterForm').submit();
  }
});

document.querySelectorAll('#filterForm thead select').forEach(el => {
  el.addEventListener('change', () => document.getElementById('filterForm').submit());
});
</script>

</body>
</html>