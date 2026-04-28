<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการข้อมูลการตายจังหวัดพัทลุง</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Prompt',sans-serif;
            background:linear-gradient(135deg,#dbf4f4 0%,#eef8f6 45%,#f7fbff 100%);
            min-height:100vh;
            color:#0f172a;
        }
        .page-shell{max-width:1500px;margin:26px auto;padding:0 18px 40px;}
        .main-card{
            border:1px solid #deebf2;
            border-radius:28px;
            background:rgba(255,255,255,.94);
            box-shadow:0 18px 45px rgba(15,23,42,.08);
            overflow:hidden;
        }
        .hero{
            padding:26px;
            color:#fff;
            background:linear-gradient(135deg,#0f766e 0%,#0ea5a4 45%,#2563eb 100%);
        }
        .hero-title{font-size:28px;font-weight:700;margin-bottom:6px;}
        .hero-sub{font-size:14px;opacity:.95;}
        .section-card{
            border:1px solid #e1edf4;
            border-radius:22px;
            background:#fff;
            box-shadow:0 10px 25px rgba(15,23,42,.05);
            padding:20px;
            margin-bottom:18px;
        }
        .form-label{font-size:12px;font-weight:700;color:#64748b;}
        .form-control,.form-select{
            border-radius:14px;
            min-height:44px;
            font-size:13px;
            border:1px solid #d7e5ed;
            box-shadow:none!important;
        }
        .btn{
            border-radius:14px;
            font-size:13px;
            font-weight:700;
        }
        .btn-main{
            background:linear-gradient(135deg,#0ea5a4,#2563eb);
            color:#fff;
            border:none;
        }
        .btn-main:hover{color:#fff;}
        .import-box{
            background:#f8fbff;
            border:1px dashed #bdd7ea;
            border-radius:18px;
            padding:16px;
        }
        .hint{font-size:12px;color:#64748b;line-height:1.7;}
        .table-tools{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
            margin-bottom:14px;
        }
        .table-search{
            max-width:360px;
            position:relative;
        }
        .table-search i{
            position:absolute;
            left:14px;
            top:50%;
            transform:translateY(-50%);
            color:#64748b;
        }
        .table-search input{padding-left:40px;}
        .data-table-wrap{
            max-height:620px;
            overflow:auto;
            border:1px solid #dce8f0;
            border-radius:18px;
        }
        .table{
            margin-bottom:0;
            min-width:1200px;
        }
        .table thead th{
            position:sticky;
            top:0;
            z-index:2;
            background:#d9e7f5;
            color:#1e293b;
            text-align:center;
            vertical-align:middle;
            white-space:nowrap;
            font-size:12px;
            padding:10px;
        }
        .table tbody td{
            font-size:12px;
            vertical-align:middle;
            background:#fff;
        }
        .table tbody tr:nth-child(even) td{background:#f8fbff;}
        .table tbody tr:hover td{background:#f0fbfb;}
        .table input,.table select{
            min-height:36px;
            font-size:12px;
            border-radius:10px;
        }
        .action-btn{
            width:36px;
            height:36px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:0;
            border-radius:12px;
        }
        /* ===== PAGINATION SOFT SMALL ===== */
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
    background:#ffffff !important;
    color:#64748b !important;
    font-size:13px !important;
    font-weight:500 !important;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:none !important;
    transition:.18s ease;
}

.premium-pagination .page-link:hover{
    background:#f8fafc !important;
    color:#334155 !important;
    border-color:#cbd5e1 !important;
}

.premium-pagination .page-item.active .page-link{
    background:#eef6f7 !important;
    color:#0f766e !important;
    border-color:#bfe3df !important;
    font-weight:700 !important;
}

.premium-pagination .page-item.disabled .page-link{
    background:#f8fafc !important;
    color:#cbd5e1 !important;
    border-color:#edf2f7 !important;
}

@media (max-width:768px){
    .premium-pagination .page-link{
        min-width:28px !important;
        height:28px !important;
        font-size:12px !important;
        padding:0 6px !important;
    }

    .pagination-summary{
        font-size:12px;
    }
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
    transform:translate(-50%, -85%) rotate(45deg);
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
    font-size:18px;
    font-weight:700;
}

@keyframes needleSpin{
    0%{ transform:translate(-50%, -85%) rotate(-35deg);}
    50%{ transform:translate(-50%, -85%) rotate(45deg);}
    100%{ transform:translate(-50%, -85%) rotate(-35deg);}
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

<body>

@include('layouts.topbar')

<div class="page-shell">
    <div class="main-card">

        <div class="hero">
            <div class="d-flex justify-content-between gap-3 flex-wrap align-items-center">
                <div>
                    <div class="hero-title">
                        <i class="bi bi-pencil-square me-2"></i>
                        จัดการข้อมูลการตายจังหวัดพัทลุง
                    </div>
                    <div class="hero-sub">
                        เพิ่มข้อมูล แก้ไข ลบ และนำเข้าไฟล์ Excel 
                    </div>
                </div>

                <a href="{{ route('health.death_dashboard') }}" class="btn btn-light">
                    <i class="bi bi-bar-chart-fill me-1"></i>
                    กลับหน้า Dashboard
                </a>
            </div>
        </div>

        <div class="p-3 p-lg-4">

         
             

            <div class="section-card">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-plus-circle-fill text-success me-1"></i>
                    เพิ่มข้อมูลใหม่
                </h5>

                <form method="POST" action="{{ route('death_summary.store') }}">
                    @csrf

                    <div class="row g-3">
                                            <div class="col-md-2">
                            <label class="form-label">ปี พ.ศ.</label>
                            <select name="year_th" class="form-select" required>
                                <option value="">เลือกปี</option>

                                @for($y = date('Y') + 543 + 1; $y >= 2565; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor

                                @foreach($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                                                <div class="col-md-2">
                            <label class="form-label">เดือน</label>
                            <select name="month_no" class="form-select" required>
                                <option value="">เลือกเดือน</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>

                                                <div class="col-md-3">
                                                    <label class="form-label">จังหวัด</label>
                                                    <input type="text" name="province_name_th" class="form-control" value="พัทลุง" readonly>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label">อำเภอ</label>
                                                    <select name="district_name_th" class="form-select" required>
                                                        <option value="">เลือกอำเภอ</option>
                                                        @foreach($districts as $district)
                                                            <option value="{{ $district }}">{{ $district }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <label class="form-label">เพศ</label>
                                                    <select name="sex_name_th" class="form-select" required>
                                                        <option value="">เลือก</option>
                                                        <option value="ชาย">ชาย</option>
                                                        <option value="หญิง">หญิง</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label">กลุ่มอายุ</label>
                                                    <select name="age_group" class="form-select" required>
                                                        <option value="">เลือก</option>
                                                        <option value="0-5">0-5 ปี</option>
                                                        <option value="6-24">6-24 ปี</option>
                                                        <option value="25-59">25-59 ปี</option>
                                                        <option value="60+">60 ปีขึ้นไป</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-7">
                                                    <label class="form-label">สาเหตุการตาย</label>
                                                    <input type="text" name="cause_of_death" class="form-control" placeholder="เช่น โรคหัวใจ" required>
                                                </div>

                                                <div class="col-md-2">
                                                    <label class="form-label">จำนวนผู้เสียชีวิต</label>
                                                    <input type="number" name="death_total" class="form-control" value="0" min="0" required>
                                                </div>

                                                <div class="col-md-12 text-end">
                                                    <button class="btn btn-success px-4">
                                                        <i class="bi bi-save-fill me-1"></i>
                                                        บันทึกข้อมูลใหม่
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                <div class="import-box mt-4">
                                <form method="POST" action="{{ route('death_summary.import') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                                        <div>
                                            <div class="fw-bold">
                                                <i class="bi bi-file-earmark-excel-fill text-success me-1"></i>
                                                นำเข้าไฟล์ Excel
                                            </div>
                                            <div class="hint">
                                                หัวตาราง: ปี, เดือน, ชื่อจังหวัด, ชื่ออำเภอ, ชื่อเพศ, กลุ่มอายุ, สาเหตุการตาย, จำนวนผู้ตาย
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2 flex-wrap">
                                        <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv" required>
                                        <button class="btn btn-success px-4">
                                            <i class="bi bi-upload me-1"></i>
                                            Import
                                        </button>
                                    </div>
                                </form>
                            </div>
            </div>

                                    
                        <div class="section-card">
                            <div class="mb-3">
                                <h5 class="fw-bold mb-1">
                                    <i class="bi bi-search me-1"></i>
                                    ค้นหารายการข้อมูล
                                </h5>
                                <div class="text-muted" style="font-size:13px;">
                                    ค้นหาข้อมูลก่อนดูรายการด้านล่าง
                                </div>
                            </div>

                            <form method="GET" action="{{ route('death_summary.manage') }}" id="searchForm">
                                
<div class="row g-3 align-items-end">

    {{-- ปี --}}
    <div class="col-md-2">
        <label class="form-label">ปี</label>
        <select name="year_th" class="form-select">
            <option value="">ทั้งหมด</option>
            @foreach($years as $year)
                <option value="{{ $year }}" {{ request('year_th') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- เดือน --}}
    <div class="col-md-2">
        <label class="form-label">เดือน</label>
        <select name="month_no" class="form-select">
            <option value="">ทั้งหมด</option>
            @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ request('month_no') == $m ? 'selected' : '' }}>
                    {{ $m }}
                </option>
            @endfor
        </select>
    </div>

    {{-- อำเภอ --}}
    <div class="col-md-2">
        <label class="form-label">อำเภอ</label>
        <select name="district_name_th" class="form-select">
            <option value="">ทั้งหมด</option>
            @foreach($districts as $district)
                <option value="{{ $district }}" {{ request('district_name_th') == $district ? 'selected' : '' }}>
                    {{ $district }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- เพศ --}}
    <div class="col-md-2">
        <label class="form-label">เพศ</label>
        <select name="sex_name_th" class="form-select">
            <option value="">ทั้งหมด</option>
            <option value="ชาย" {{ request('sex_name_th') == 'ชาย' ? 'selected' : '' }}>ชาย</option>
            <option value="หญิง" {{ request('sex_name_th') == 'หญิง' ? 'selected' : '' }}>หญิง</option>
        </select>
    </div>

    {{-- สาเหตุ --}}
    <div class="col-md-3">
        <label class="form-label">ค้นหาสาเหตุการตาย</label>
        <input type="text"
               name="cause_of_death"
               value="{{ request('cause_of_death') }}"
               class="form-control"
               placeholder="เช่น โรคหัวใจ">
    </div>

    {{-- ปุ่ม --}}
    <div class="col-md-1 d-grid">
        <button class="btn btn-main">
            <i class="bi bi-search"></i>
        </button>
    </div>

</div>

                    </div>
                </form>
            </div>

            <div class="section-card">
                
                <div class="table-tools">
                    <div>
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-table me-1"></i>
                            รายการข้อมูล
                        </h5>
                        <div class="text-muted" style="font-size:12px;">
                            แสดง {{ $rows->firstItem() ?? 0 }} ถึง {{ $rows->lastItem() ?? 0 }} จากทั้งหมด {{ number_format($rows->total()) }} รายการ
                        </div>
                    </div>

                </div>

                <div class="data-table-wrap">
                    <table class="table table-bordered align-middle" id="deathTable">
                        <thead>
                            <tr>
                                <th>ปี</th>
                                <th>เดือน</th>
                                <th>จังหวัด</th>
                                <th>อำเภอ</th>
                                <th>เพศ</th>
                                <th>กลุ่มอายุ</th>
                                <th>สาเหตุการตาย</th>
                                <th>จำนวน</th>
                                <th width="120">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
            @forelse($rows as $row)
            <tr>
                <td class="text-center">{{ $row->year_th }}</td>
                <td class="text-center">{{ $row->month_no }}</td>
                <td>{{ $row->province_name_th ?? 'พัทลุง' }}</td>
                <td>{{ $row->district_name_th }}</td>
                <td class="text-center">{{ $row->sex_name_th }}</td>
                <td class="text-center">{{ $row->age_group }}</td>
                <td>{{ $row->cause_of_death }}</td>
                <td class="text-end fw-bold">{{ number_format($row->death_total) }}</td>

                <td class="text-center">
                    <button type="button"
                            class="btn btn-warning btn-sm action-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $row->id }}">
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <form method="POST"
                        action="{{ route('death_summary.destroy', $row->id) }}"
                        class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm action-btn">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </form>
                </td>
            </tr>

            {{-- Modal แก้ไข --}}
            <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content" style="border-radius:22px;">
                        <form method="POST" action="{{ route('death_summary.update', $row->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">
                                    <i class="bi bi-pencil-square me-1"></i>
                                    แก้ไขข้อมูล
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-3">
                            <label class="form-label">ปี พ.ศ.</label>
                            <select name="year_th" class="form-select" required>
                                @for($y = date('Y') + 543 + 1; $y >= 2565; $y--)
                                    <option value="{{ $y }}" {{ $row->year_th == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">เดือน</label>
                            <select name="month_no" class="form-select" required>
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $row->month_no == $m ? 'selected' : '' }}>
                                        {{ $m }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">จังหวัด</label>
                            <input type="text" name="province_name_th" value="{{ $row->province_name_th ?? 'พัทลุง' }}" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">อำเภอ</label>
                            <select name="district_name_th" class="form-select" required>
                                @foreach($districts as $district)
                                    <option value="{{ $district }}" {{ $row->district_name_th == $district ? 'selected' : '' }}>
                                        {{ $district }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">เพศ</label>
                            <select name="sex_name_th" class="form-select" required>
                                <option value="ชาย" {{ $row->sex_name_th == 'ชาย' ? 'selected' : '' }}>ชาย</option>
                                <option value="หญิง" {{ $row->sex_name_th == 'หญิง' ? 'selected' : '' }}>หญิง</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">กลุ่มอายุ</label>
                            <select name="age_group" class="form-select" required>
                                <option value="0-5" {{ $row->age_group == '0-5' ? 'selected' : '' }}>0-5 ปี</option>
                                <option value="6-24" {{ $row->age_group == '6-24' ? 'selected' : '' }}>6-24 ปี</option>
                                <option value="25-59" {{ $row->age_group == '25-59' ? 'selected' : '' }}>25-59 ปี</option>
                                <option value="60+" {{ $row->age_group == '60+' ? 'selected' : '' }}>60 ปีขึ้นไป</option>
                            </select>
                        </div>

                        <div class="col-md-9">
                            <label class="form-label">สาเหตุการตาย</label>
                            <input type="text" name="cause_of_death" value="{{ $row->cause_of_death }}" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">จำนวนผู้เสียชีวิต</label>
                            <input type="number" name="death_total" value="{{ $row->death_total }}" class="form-control text-end" min="0" required>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        ยกเลิก
                    </button>
                    <button class="btn btn-success px-4">
                        <i class="bi bi-save-fill me-1"></i>
                        บันทึกการแก้ไข
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@empty
<tr>
    <td colspan="9" class="text-center text-muted py-4">
        ไม่พบข้อมูล
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'สำเร็จ',
    text: '{{ session('success') }}',
    confirmButtonText: 'ตกลง',
    confirmButtonColor: '#0f766e',
    timer: 2200,
    timerProgressBar: true
});
</script>
@endif

@if($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'เกิดข้อผิดพลาด',
    html: `{!! implode('<br>', $errors->all()) !!}`,
    confirmButtonText: 'ปิด',
    confirmButtonColor: '#dc2626'
});
</script>
@endif

<script>
document.querySelectorAll('.delete-form').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            icon: 'warning',
            title: 'ยืนยันการลบข้อมูล?',
            text: 'เมื่อลบแล้วข้อมูลจะถูกลบออกจากตาราง',
            showCancelButton: true,
            confirmButtonText: 'ลบข้อมูล',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

document.getElementById('tableSearch')?.addEventListener('keyup', function() {
    const keyword = this.value.toLowerCase();
    document.querySelectorAll('#deathTable tbody tr').forEach(function(row) {
        row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>

              
<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay">
    <div class="loading-modal">
        <div class="loading-ring">
            <div class="loading-needle"></div>
        </div>
        <div class="loading-text">กำลังประมวลผล</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('searchForm');

    if(searchForm){
        searchForm.addEventListener('submit', function () {
            document.getElementById('loadingOverlay').style.display = 'flex';
        });
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>