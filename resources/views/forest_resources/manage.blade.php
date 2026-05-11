
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>จัดการข้อมูลทรัพยากรป่าไม้</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Prompt',sans-serif;
    background:
        radial-gradient(circle at top left, rgba(14,165,164,.14), transparent 25%),
        radial-gradient(circle at top right, rgba(37,99,235,.10), transparent 25%),
        linear-gradient(135deg,#dbf4f4 0%,#eef8f6 45%,#f7fbff 100%);
    min-height:100vh;
    color:#0f172a;
}

.page-shell{max-width:1500px;margin:28px auto;padding:0 18px 40px;}

.main-card{
    border:1px solid #deebf2;
    border-radius:32px;
    background:rgba(255,255,255,.95);
    box-shadow:0 20px 50px rgba(15,23,42,.08);
    overflow:hidden;
}

.hero{
    padding:28px;
    background:
        radial-gradient(circle at top left, rgba(255,255,255,.18), transparent 30%),
        linear-gradient(135deg,#0f766e 0%,#0ea5a4 45%,#2563eb 100%);
    color:#fff;
}

.hero-title{font-size:30px;font-weight:800;margin-bottom:8px;}
.hero-sub{opacity:.92;font-size:14px;}

.hero-box{
    background:rgba(255,255,255,.14);
    border:1px solid rgba(255,255,255,.16);
    border-radius:20px;
    padding:16px;
    height:100%;
}

.hero-label{font-size:12px;opacity:.85;}
.hero-value{font-size:24px;font-weight:800;}

.section-card{
    background:#fff;
    border:1px solid #e2edf3;
    border-radius:24px;
    padding:22px;
    box-shadow:0 10px 25px rgba(15,23,42,.05);
    margin-bottom:18px;
}

.form-label{font-size:12px;font-weight:700;color:#64748b;}

.form-control{
    border-radius:16px;
    min-height:48px;
    border:1px solid #d8e6ed;
    font-size:13px;
    box-shadow:none !important;
}

.form-control:focus{border-color:#7dd3fc;}

.btn{border-radius:16px;min-height:48px;font-size:13px;font-weight:700;}

.import-card{
    background:linear-gradient(180deg,#f8fffb 0%,#ffffff 100%);
    border:1px solid #d9f4e5;
}

.import-icon{
    width:58px;
    height:58px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:24px;
    background:linear-gradient(135deg,#16a34a,#0f766e);
}

.import-box{
    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:18px;
    padding:14px;
    font-size:13px;
}

.table-tools{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    margin-bottom:16px;
    flex-wrap:wrap;
}

.data-table-wrap{overflow:auto;border:1px solid #dce8f0;border-radius:20px;}
.table{margin-bottom:0;min-width:900px;}

.table thead th{
    background:#d9e7f5;
    color:#1e293b;
    border:1px solid #cbdbe7;
    text-align:center;
    vertical-align:middle;
    white-space:nowrap;
    padding:12px;
    font-size:12px;
}

.table tbody td{
    border:1px solid #e2e8f0;
    font-size:13px;
    vertical-align:middle;
    background:#fff;
}

.table tbody tr:nth-child(even) td{background:#f8fbff;}
.table tbody tr:hover td{background:#f0fbfb;}

.action-btn{
    width:36px;
    height:36px;
    min-height:36px;
    border-radius:12px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:0;
}

.badge-soft{
    background:#dcfce7;
    color:#166534;
    padding:8px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.loading-overlay{
    position:fixed;
    inset:0;
    background:rgba(15,23,42,.55);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:99999;
    backdrop-filter:blur(3px);
}

.loading-box{text-align:center;}

.loading-ring{
    width:110px;
    height:110px;
    border-radius:50%;
    border:7px solid rgba(255,255,255,.95);
    position:relative;
    margin:0 auto 18px;
    animation:pulse 1.2s infinite;
}

.loading-ring::after{
    content:'';
    width:12px;
    height:40px;
    background:#fff;
    border-radius:999px;
    position:absolute;
    left:50%;
    top:12px;
    transform:translateX(-50%);
    transform-origin:center 42px;
    animation:spin 1s infinite ease-in-out;
}

.loading-text{color:#fff;font-weight:700;font-size:18px;}

@keyframes spin{
    0%{transform:translateX(-50%) rotate(-40deg);}
    50%{transform:translateX(-50%) rotate(40deg);}
    100%{transform:translateX(-50%) rotate(-40deg);}
}

@keyframes pulse{
    0%,100%{transform:scale(1);}
    50%{transform:scale(1.03);}
}
.premium-pagination{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:8px;
    margin-top:18px;
}

.pagination-summary{
    font-size:13px;
    font-weight:600;
    color:#64748b;
}

.premium-pagination .pagination{
    gap:5px;
    justify-content:center;
    flex-wrap:wrap;
    margin-bottom:0;
}

.premium-pagination .page-link{
    min-width:32px !important;
    height:32px !important;
    padding:0 8px !important;
    border-radius:999px !important;
    border:1px solid #dbe5ec !important;
    background:#fff !important;
    color:#64748b !important;
    font-size:13px !important;
    font-weight:500 !important;
    display:flex;
    align-items:center;
    justify-content:center;
}
.import-upload-group{
    border:1px solid #d8e6ed;
    border-radius:18px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 8px 18px rgba(15,23,42,.04);
}

.import-upload-group .form-control{
    border:0 !important;
    border-radius:0 !important;
    min-height:54px;
}

.import-upload-btn{
    border:0 !important;
    border-radius:0 !important;
    min-height:54px;
    padding:0 28px;
    color:#fff !important;
    background:linear-gradient(135deg,#16a34a,#0f766e);
    font-weight:800;
}

.import-upload-btn:hover{
    color:#fff !important;
    background:linear-gradient(135deg,#15803d,#0B7F6F);
}
.import-upload-group{
    display:flex;
    align-items:stretch;
    width:100%;
}

.import-upload-group .form-control{
    flex:1;
}

.import-upload-btn{
    white-space:nowrap;
}
.hero-back-btn{
    min-height:52px;
    padding:0 24px;
    border-radius:16px;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 8px 20px rgba(255,255,255,.18);
    border:none;
}
.import-upload-group{
    display:flex;
    align-items:center;
    width:100%;
    overflow:hidden;
    border-radius:18px;
    border:1px solid #d8e6ed;
    background:#fff;
}

.import-upload-group .form-control{
    flex:1;
    border:0 !important;
    border-radius:0 !important;
    height:54px;
    padding-top:14px;
}

.import-upload-btn{
    height:54px;
    padding:0 22px !important;
    border:0 !important;
    border-radius:0 !important;
    display:flex;
    align-items:center;
    justify-content:center;
    white-space:nowrap;
    background:linear-gradient(135deg,#16a34a,#0f766e);
    color:#fff !important;
    font-weight:700;
}
</style>
</head>

<body>

@include('layouts.topbar')

<div class="page-shell">
<div class="main-card">

<div class="hero">
<div class="row g-4 align-items-center">

<div class="col-lg-8">
    <div class="hero-title">
        <i class="bi bi-tree-fill me-2"></i>
        จัดการข้อมูลทรัพยากรป่าไม้
    </div>

    <div class="hero-sub">
        เพิ่มข้อมูล แก้ไข ลบ และนำเข้าไฟล์ Excel ข้อมูลทรัพยากรป่าไม้จังหวัดพัทลุง
    </div>
</div>

<div class="col-lg-4 d-flex flex-column justify-content-center">

    <div class="text-center text-lg-end mb-3">

        <a href="{{ route('forest.resources.index') }}"
           class="btn btn-light hero-back-btn">

            <i class="bi bi-bar-chart-fill me-1"></i>
            กลับหน้า Dashboard

        </a>

    </div>

    <div class="row g-3">
<div class="col-6">
<div class="hero-box">
<div class="hero-label">จำนวนป่ารวม</div>
<div class="hero-value">{{ number_format($totalForestCount ?? 0) }}</div>
</div>
</div>

<div class="col-6">
<div class="hero-box">
<div class="hero-label">พื้นที่รวม</div>
<div class="hero-value">{{ number_format($totalForestArea ?? 0,2) }}</div>
</div>
</div>
</div>
</div>

</div>
</div>

<div class="p-3 p-lg-4">



<div class="section-card">
<div class="d-flex align-items-center gap-2 mb-3">
<div class="rounded-circle d-flex align-items-center justify-content-center"
style="width:40px;height:40px;background:#dcfce7;color:#15803d;">
<i class="bi bi-plus-circle-fill"></i>
</div>

<div>
<h5 class="fw-bold mb-0">เพิ่มข้อมูลใหม่</h5>
<div class="text-muted" style="font-size:12px;">กรอกข้อมูลทรัพยากรป่าไม้</div>
</div>
</div>

<form method="POST" action="{{ route('forest.resources.store') }}">
@csrf

<div class="row g-3">
<div class="col-md-6">
<label class="form-label">ชื่อป่า</label>
<input type="text" name="forest_name" class="form-control" placeholder="เช่น ป่าสงวนแห่งชาติ" required>
</div>

<div class="col-md-3">
<label class="form-label">จำนวนป่า</label>
<input type="number" name="forest_count" class="form-control text-end" value="0" min="0" required>
</div>

<div class="col-md-3">
<label class="form-label">พื้นที่ป่าไม้ (ไร่)</label>
<input type="number" step="0.01" name="forest_area" class="form-control text-end" value="0" min="0" required>
</div>

<div class="col-12 text-end">
<button class="btn btn-success px-4">
<i class="bi bi-save-fill me-1"></i>
บันทึกข้อมูล
</button>
</div>
</div>
</form>
</div>

<div class="section-card import-card">
<form method="POST" action="{{ route('forest.resources.import') }}" enctype="multipart/form-data" id="importForm">
@csrf

<div class="row g-4 align-items-center">
<div class="col-lg-6">
<div class="d-flex align-items-center gap-3 mb-3">
<div class="import-icon"><i class="bi bi-cloud-arrow-up-fill"></i></div>

<div>
<div class="fw-bold" style="font-size:20px;">นำเข้าข้อมูลป่าไม้จาก Excel</div>
<div class="text-muted" style="font-size:12px;">อัปโหลดข้อมูลหลายรายการพร้อมกัน</div>
</div>
</div>

<div class="alert alert-warning rounded-4 mb-0" style="font-size:13px;line-height:1.8;">
<strong>⚠️ ข้อกำหนด</strong><br>
• หัวตารางต้องตรงตามตัวอย่าง<br>
• รองรับไฟล์ .xlsx .xls .csv<br>
• ระบบจะล้างข้อมูลเดิมก่อนนำเข้าใหม่
</div>
</div>

<div class="col-lg-6">
<div class="import-box mb-3">
<strong>📋 หัวตารางที่ถูกต้อง</strong>
<div class="mt-2" style="font-family:monospace;">ชื่อป่า | จำนวนป่า | พื้นที่ป่าไม้</div>
</div>

<div class="import-box mb-3">
<strong>📊 ตัวอย่างข้อมูล</strong>
<div class="mt-2" style="font-family:monospace;">ป่าสงวนแห่งชาติ | 12 | 2450.50</div>
</div>

<label class="form-label">เลือกไฟล์ Excel</label>

<div class="import-upload-group">

    <input type="file"
           name="excel_file"
           class="form-control"
           accept=".xlsx,.xls,.csv"
           required>

    <button type="submit" class="btn import-upload-btn">
        <i class="bi bi-cloud-arrow-up-fill me-1"></i>
        นำเข้า Excel
    </button>

</div>
</div>
</div>
</form>
</div>

    <div class="section-card">

<div class="mb-3">
<h5 class="fw-bold mb-1">
<i class="bi bi-search me-1"></i>
ค้นหารายการข้อมูล
</h5>

<div class="text-muted" style="font-size:12px;">
ค้นหาข้อมูลทรัพยากรป่าไม้จากชื่อป่า
</div>
</div>

<form method="GET"
      action="{{ route('forest.resources.manage') }}"
      id="searchForm">

<div class="row g-3 align-items-end">

<div class="col-md-10">
<label class="form-label">ค้นหาชื่อป่า</label>

<input type="text"
       name="keyword"
       value="{{ $keyword ?? request('keyword') }}"
       class="form-control"
       placeholder="เช่น ป่าสงวนแห่งชาติ">
</div>

<div class="col-md-2 d-grid">
<button class="btn btn-primary">
<i class="bi bi-search me-1"></i>
ค้นหา
</button>
</div>

</div>
</form>
</div>

<div class="section-card">

<div class="table-tools">
<div>
<h5 class="fw-bold mb-1">
<i class="bi bi-table me-1"></i>
รายการข้อมูลทรัพยากรป่าไม้
</h5>
<div class="text-muted" style="font-size:12px;">
แสดง {{ $rows->firstItem() ?? 0 }} ถึง {{ $rows->lastItem() ?? 0 }} จากทั้งหมด {{ number_format($rows->total()) }} รายการ
</div>
</div>

<button type="button" id="bulkDeleteBtn" class="btn btn-danger px-3" disabled>
<i class="bi bi-trash3-fill me-1"></i>
ลบรายการที่เลือก
</button>
</div>

<div class="data-table-wrap">
<table class="table align-middle">
<thead>
<tr>
<th width="50"><input type="checkbox" id="checkAll"></th>
<th>ชื่อป่า</th>
<th width="160">จำนวนป่า</th>
<th width="180">พื้นที่ป่าไม้</th>
<th width="160">สัดส่วนพื้นที่</th>
<th width="120">จัดการ</th>
</tr>
</thead>

<tbody>
@forelse($rows as $row)
@php
$percent = ($totalForestArea ?? 0) > 0
? ($row->forest_area / $totalForestArea) * 100
: 0;
@endphp

<tr>
<td class="text-center">
<input type="checkbox" class="row-check" value="{{ $row->id }}">
</td>

<td class="fw-semibold">{{ $row->forest_name }}</td>
<td class="text-end fw-bold">{{ number_format($row->forest_count) }}</td>
<td class="text-end fw-bold">{{ number_format($row->forest_area,2) }}</td>

<td class="text-end">
<span class="badge-soft">{{ number_format($percent,2) }}%</span>
</td>

<td class="text-center">
<button type="button"
        class="btn btn-warning btn-sm action-btn"
        data-bs-toggle="modal"
        data-bs-target="#editModal{{ $row->id }}">
    <i class="bi bi-pencil-square"></i>
</button>

<form method="POST"
      action="{{ route('forest.resources.destroy', $row->id) }}"
      class="d-inline delete-form">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger btn-sm action-btn">
        <i class="bi bi-trash3-fill"></i>
    </button>
</form>
</td>
</tr>

<div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content" style="border-radius:24px;">
<form method="POST" action="{{ route('forest.resources.update', $row->id) }}">
@csrf
@method('PUT')

<div class="modal-header">
<h5 class="modal-title fw-bold">
<i class="bi bi-pencil-square me-1"></i>
แก้ไขข้อมูลป่าไม้
</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<div class="mb-3">
<label class="form-label">ชื่อป่า</label>
<input type="text" name="forest_name" class="form-control" value="{{ $row->forest_name }}" required>
</div>

<div class="mb-3">
<label class="form-label">จำนวนป่า</label>
<input type="number" name="forest_count" class="form-control text-end" value="{{ $row->forest_count }}" min="0" required>
</div>

<div class="mb-3">
<label class="form-label">พื้นที่ป่าไม้ (ไร่)</label>
<input type="number" step="0.01" name="forest_area" class="form-control text-end" value="{{ $row->forest_area }}" min="0" required>
</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
<button class="btn btn-success px-4">
<i class="bi bi-save-fill me-1"></i>
บันทึก
</button>
</div>
</form>
</div>
</div>
</div>

@empty
<tr>
<td colspan="6" class="text-center text-muted py-5">
<i class="bi bi-inbox fs-1 d-block mb-2"></i>
ยังไม่มีข้อมูลทรัพยากรป่าไม้
</td>
</tr>
@endforelse
</tbody>
</table>
</div>

<div class="premium-pagination">
    <div class="pagination-summary">
        แสดง {{ $rows->firstItem() ?? 0 }}–{{ $rows->lastItem() ?? 0 }}
        จาก {{ number_format($rows->total()) }} รายการ
    </div>

    {{ $rows->onEachSide(2)->links('pagination::bootstrap-4') }}
</div>
</div>

</div>
</div>
</div>
</div>

<div id="loadingOverlay" class="loading-overlay">
<div class="loading-box">
<div class="loading-ring"></div>
<div class="loading-text">กำลังประมวลผล</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('importForm')?.addEventListener('submit', function(){
    document.getElementById('loadingOverlay').style.display = 'flex';
});

document.querySelectorAll('.delete-form').forEach(function(form){
    form.addEventListener('submit', function(e){
        e.preventDefault();

        Swal.fire({
            icon:'warning',
            title:'ยืนยันการลบ?',
            text:'เมื่อลบแล้วจะไม่สามารถกู้คืนได้',
            showCancelButton:true,
            confirmButtonText:'ลบข้อมูล',
            cancelButtonText:'ยกเลิก',
            confirmButtonColor:'#dc2626',
            cancelButtonColor:'#64748b'
        }).then((result)=>{
            if(result.isConfirmed){
                form.submit();
            }
        });
    });
});

const checkAll = document.getElementById('checkAll');
const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

function updateBulkButton(){
    const checked = document.querySelectorAll('.row-check:checked').length;
    if(bulkDeleteBtn){
        bulkDeleteBtn.disabled = checked === 0;
    }
}

checkAll?.addEventListener('change', function(){
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
    updateBulkButton();
});

document.querySelectorAll('.row-check').forEach(cb => {
    cb.addEventListener('change', updateBulkButton);
});

bulkDeleteBtn?.addEventListener('click', function(){
    const ids = Array.from(document.querySelectorAll('.row-check:checked')).map(cb => cb.value);

    Swal.fire({
        icon:'warning',
        title:'ยืนยันการลบ?',
        text:`ต้องการลบ ${ids.length} รายการใช่ไหม`,
        showCancelButton:true,
        confirmButtonText:'ลบข้อมูล',
        cancelButtonText:'ยกเลิก',
        confirmButtonColor:'#dc2626',
        cancelButtonColor:'#64748b'
    }).then((result)=>{
        if(result.isConfirmed){
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('forest.resources.bulk_destroy') }}";

            form.innerHTML = `
                @csrf
                <input type="hidden" name="ids" value="${ids.join(',')}">
            `;

            document.body.appendChild(form);
            form.submit();
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'success',
        title: 'สำเร็จ',
        text: '{{ session('success') }}',
        confirmButtonText: 'ตกลง',
        confirmButtonColor: '#16a34a',
        backdrop: 'rgba(15,23,42,0.6)',
        allowOutsideClick: false,
        allowEscapeKey: false
    });
});
</script>
@endif

@if($errors->any())
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'error',
        title: 'ไม่สำเร็จ',
        text: '{{ $errors->first() }}',
        confirmButtonText: 'ตกลง',
        confirmButtonColor: '#dc2626',
        backdrop: 'rgba(15,23,42,0.6)'
    });
});
</script>
@endif
</body>
</html>



