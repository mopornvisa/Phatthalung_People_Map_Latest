<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>จัดการสิทธิ์ผู้ใช้งาน | Phatthalung People Map</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root{
    --green:#0B7F6F;
    --green-dark:#075f55;
    --blue:#0B5B6B;
    --soft:#f4faf8;
    --line:#dcebe7;
    --text:#0f172a;
    --muted:#64748b;
}

*{ box-sizing:border-box; }

body{
    font-family:'Prompt',sans-serif;
    background:
        radial-gradient(circle at top left, rgba(11,127,111,.16), transparent 30%),
        linear-gradient(135deg,#eef8f6 0%,#f8fafc 48%,#edf7fb 100%);
    color:var(--text);
    font-size:14px;
    min-height:100vh;
}

.page-wrap{
    padding:28px;
}

.hero-card{
    border-radius:28px;
    background:
        linear-gradient(135deg, rgba(7,95,85,.96), rgba(11,127,111,.94)),
        radial-gradient(circle at top right, rgba(255,255,255,.35), transparent 35%);
    color:#fff;
    padding:30px;
    box-shadow:0 24px 60px rgba(11,91,107,.26);
    position:relative;
    overflow:hidden;
    margin-bottom:20px;
}
.hero-card:before{
    content:"";
    position:absolute;
    right:-80px;
    top:-80px;
    width:260px;
    height:260px;
    border-radius:50%;
    background:rgba(255,255,255,.12);
}

.hero-title{
    font-size:25px;
    font-weight:800;
    margin:0;
}

.hero-sub{
    opacity:.9;
    margin-top:6px;
    font-size:13px;
}

.btn-home{
    height:42px;
    border-radius:14px;
    border:1px solid rgba(255,255,255,.38);
    color:#fff;
    background:rgba(255,255,255,.13);
    backdrop-filter:blur(8px);
    font-weight:700;
}

.btn-home:hover{
    background:#fff;
    color:var(--green-dark);
}

.stat-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:14px;
    margin-top:22px;
}

.stat-box{
    background:rgba(255,255,255,.14);
    border:1px solid rgba(255,255,255,.22);
    border-radius:18px;
    padding:16px;
    backdrop-filter:blur(8px);
}

.stat-label{
    font-size:12px;
    opacity:.82;
}

.stat-value{
    font-size:24px;
    font-weight:800;
    line-height:1.1;
}

.main-card{
    background:rgba(255,255,255,.78);
    border:1px solid rgba(255,255,255,.85);
    border-radius:28px;
    box-shadow:0 20px 55px rgba(15,23,42,.10);
    backdrop-filter:blur(18px);
    overflow:hidden;
}

.content-pad{
    padding:22px;
}

.filter-box{
    background:rgba(255,255,255,.88);
    border:1px solid rgba(220,235,231,.95);
    border-radius:22px;
    padding:20px;
    box-shadow:0 12px 30px rgba(15,23,42,.06);
    margin-bottom:20px;
}

.form-label{
    font-size:12px;
    font-weight:700;
    color:#475569;
    margin-bottom:7px;
}

.form-control,
.form-select{
    height:44px;
    border-radius:13px;
    font-size:13px;
    border:1px solid #dbe7e4;
}

.form-control:focus,
.form-select:focus{
    border-color:var(--green);
    box-shadow:0 0 0 .18rem rgba(11,127,111,.12);
}

.btn-main{
    height:44px;
    background:linear-gradient(135deg,var(--green),var(--blue));
    color:#fff;
    border:none;
    border-radius:13px;
    font-size:13px;
    font-weight:700;
    box-shadow:0 8px 18px rgba(11,127,111,.22);
}

.btn-main:hover{
    color:#fff;
    transform:translateY(-1px);
}

.btn-clear{
    height:44px;
    border-radius:13px;
    font-size:13px;
    font-weight:700;
    background:#fff;
}

.badge-filter{
    background:#eef8f6;
    color:var(--blue);
    border:1px solid #d8ebe7;
    border-radius:999px;
    padding:8px 13px;
    font-size:12px;
    font-weight:700;
}

.table-card{
    border:1px solid var(--line);
    border-radius:20px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 8px 26px rgba(15,23,42,.05);
}

.table{
    margin-bottom:0;
    font-size:13px;
}

.table th{
    background:linear-gradient(180deg,#f8fafc,#eef5f3);
    color:#334155;
    font-size:12px;
    font-weight:800;
    text-align:center;
    vertical-align:middle;
    padding:14px 10px;
    border-bottom:1px solid var(--line);
    white-space:nowrap;
}

.table td{
    vertical-align:middle;
    padding:14px 12px;
    border-color:#edf2f7;
}

.table tbody tr:hover{
    background:#f8fcfb;
}

.user-avatar{
    width:42px;
    height:42px;
    border-radius:14px;
    background:linear-gradient(135deg,var(--green),var(--blue));
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:800;
    flex:0 0 auto;
}

.user-title{
    font-weight:800;
    color:#0f172a;
}

.user-sub{
    font-size:12px;
    color:var(--muted);
    margin-top:2px;
}

.role-admin,
.role-user{
    border-radius:999px;
    padding:7px 12px;
    font-size:12px;
    font-weight:800;
    display:inline-flex;
    align-items:center;
    gap:5px;
}

.role-admin{
    background:#fee2e2;
    color:#991b1b;
}

.role-user{
    background:#dbeafe;
    color:#1e40af;
}

.agency-pill{
    background:#f8fafc;
    color:#334155;
    border:1px solid #e2e8f0;
    border-radius:999px;
    padding:7px 12px;
    font-weight:700;
    font-size:12px;
    display:inline-block;
}

.status-pill{
    display:inline-flex;
    align-items:center;
    gap:7px;
    border-radius:999px;
    padding:7px 12px;
    font-size:12px;
    font-weight:800;
}

.status-approved{
    background:#dcfce7;
    color:#166534;
}

.status-pending{
    background:#fef3c7;
    color:#92400e;
}

.action-wrap{
    display:flex;
    justify-content:center;
    gap:8px;
    flex-wrap:wrap;
}

.action-btn{
    width:36px;
    height:36px;
    border-radius:12px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    color:white;
    text-decoration:none;
    border:none;
    font-size:15px;
    transition:.16s;
}

.action-btn:hover{
    transform:translateY(-2px);
    color:#fff;
}

.btn-approve{ background:#16a34a; }
.btn-pending{ background:#f59e0b; }
.btn-edit{ background:#2563eb; }
.btn-del{ background:#dc2626; }

.empty-box{
    text-align:center;
    padding:60px 10px;
    color:#94a3b8;
}

.empty-box i{
    font-size:46px;
    display:block;
    margin-bottom:8px;
}

.pagination{
    justify-content:center;
}

.pagination .page-link{
    font-size:13px;
    border-radius:10px;
    margin:0 3px;
    color:var(--blue);
}

.pagination .active .page-link{
    background:var(--green);
    border-color:var(--green);
}

@media(max-width:768px){
    .page-wrap{ padding:12px; }
    .hero-card{ padding:20px; border-radius:20px; }
    .stat-grid{ grid-template-columns:1fr; }
    .content-pad{ padding:14px; }
}
.table tbody tr{
    transition:.18s ease;
}

.table tbody tr:hover{
    background:#f0faf7;
    transform:scale(1.002);
}

.action-btn{
    box-shadow:0 8px 16px rgba(15,23,42,.12);
}

.stat-box{
    transition:.18s ease;
}

.stat-box:hover{
    transform:translateY(-3px);
    background:rgba(255,255,255,.20);
}
</style>
</head>

<body>

@include('layouts.topbar')

<div class="page-wrap">

    <div class="hero-card">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 position-relative">
            <div>
                <h1 class="hero-title">
                    <i class="bi bi-shield-lock-fill me-2"></i>
                    จัดการสิทธิ์ผู้ใช้งาน
                </h1>
                <div class="hero-sub">
                    ระบบฐานข้อมูลกลาง Phatthalung People Map สำหรับตรวจสอบ อนุมัติ และจัดการสิทธิ์ผู้ใช้งาน
                </div>
            </div>

            <a href="{{ url('/') }}" class="btn btn-home px-4 d-flex align-items-center">
                <i class="bi bi-house-door me-2"></i>
                กลับหน้าหลัก
            </a>
        </div>

        <div class="stat-grid position-relative">
            <div class="stat-box">
                <div class="stat-label">ผู้ใช้ทั้งหมด</div>
                <div class="stat-value">{{ number_format($users->total()) }}</div>
            </div>

            <div class="stat-box">
                <div class="stat-label">คำค้นหา</div>
                <div class="stat-value">{{ $keyword ? $keyword : '-' }}</div>
            </div>

            <div class="stat-box">
                <div class="stat-label">สิทธิ์ที่เลือก</div>
                <div class="stat-value">{{ $role ? strtoupper($role) : 'ทั้งหมด' }}</div>
            </div>
        </div>
    </div>

    <div class="main-card">
        <div class="content-pad">

            <form method="GET" action="{{ route('admin.users.index') }}" class="filter-box">
                <div class="row g-3 align-items-end">

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">ประเภท/หน่วยงาน</label>
                        <select name="agency" class="form-select">
                            <option value="">ทั้งหมด</option>
                            @foreach([
                                'บุคคลทั่วไป',
                                'องค์การบริหารส่วนจังหวัดพัทลุง',
                                'สำนักงานสาธารณสุขจังหวัดพัทลุง',
                                'มหาวิทยาลัยทักษิณ',
                                'หน่วยงานภาครัฐอื่น ๆ',
                                'ดูแลระบบ'
                            ] as $item)
                                <option value="{{ $item }}" {{ $agency == $item ? 'selected' : '' }}>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">สิทธิ์</label>
                        <select name="role" class="form-select">
                            <option value="">ทั้งหมด</option>
                            <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ $role == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <label class="form-label">ค้นหา</label>
                        <input type="text"
                               name="keyword"
                               value="{{ $keyword }}"
                               class="form-control"
                               placeholder="ค้นหา username / ชื่อ / อีเมล / เบอร์โทร / เลขบัตร">
                    </div>

                    <div class="col-lg-3 col-md-12">
                        <div class="row g-2">
                            <div class="col-6">
                                <button type="submit" class="btn btn-main w-100">
                                    <i class="bi bi-search me-1"></i>
                                    ค้นหา
                                </button>
                            </div>

                            <div class="col-6">
                                <a href="{{ route('admin.users.index') }}"
                                   class="btn btn-light border btn-clear w-100 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-arrow-clockwise me-1"></i>
                                    ล้างค่า
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

            <div class="mb-3 d-flex flex-wrap gap-2">
                <span class="badge-filter">
                    <i class="bi bi-funnel-fill me-1"></i>
                    พบข้อมูล {{ number_format($users->total()) }} รายการ
                </span>

                @if($agency)
                    <span class="badge-filter">หน่วยงาน: {{ $agency }}</span>
                @endif

                @if($role)
                    <span class="badge-filter">สิทธิ์: {{ strtoupper($role) }}</span>
                @endif

                @if($keyword)
                    <span class="badge-filter">ค้นหา: {{ $keyword }}</span>
                @endif
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th width="60">ลำดับ</th>
                                <th>บัญชีผู้ใช้</th>
                                <th>ข้อมูลส่วนตัว</th>
                                <th>สิทธิ์</th>
                                <th>หน่วยงาน</th>
                                <th>สถานะ</th>
                                <th>วันที่สมัคร</th>
                                <th width="170">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td class="text-center fw-bold">
                                    {{ $users->firstItem() + $index }}
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="user-avatar">
                                            {{ mb_substr($user->register_Name ?: $user->register_User, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="user-title">{{ $user->register_User }}</div>
                                            <div class="user-sub">
                                                <i class="bi bi-envelope me-1"></i>{{ $user->register_Gmail }}
                                            </div>
                                            <div class="user-sub">
                                                <i class="bi bi-telephone me-1"></i>{{ $user->register_Phone ?: '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="user-title">
                                        {{ $user->register_Name }} {{ $user->register_Same }}
                                    </div>
                                    <div class="user-sub">
                                        เลขบัตร: {{ $user->register_Number ?: '-' }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    @if($user->register_Type == 'admin')
                                        <span class="role-admin">
                                            <i class="bi bi-shield-check"></i>
                                            Admin
                                        </span>
                                    @else
                                        <span class="role-user">
                                            <i class="bi bi-person"></i>
                                            User
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <span class="agency-pill">
                                        {{ $user->register_Agency ?: '-' }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if($user->register_Status == 'อนุมัติแล้ว')
                                        <span class="status-pill status-approved">
                                            <i class="bi bi-check-circle-fill"></i>
                                            อนุมัติแล้ว
                                        </span>
                                    @else
                                        <span class="status-pill status-pending">
                                            <i class="bi bi-clock-fill"></i>
                                            รออนุมัติ
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center small">
                                    @if($user->created_at)
                                        <strong>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</strong>
                                        <br>
                                        <span class="text-muted">
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('H:i') }} น.
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    <div class="action-wrap">

                                        @if($user->register_Status != 'อนุมัติแล้ว')
                                            <form method="POST" action="{{ route('admin.users.approve', $user->id) }}" class="approve-form">
                                                @csrf
                                                <button type="submit" class="action-btn btn-approve" data-bs-toggle="tooltip" title="อนุมัติ">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.users.pending', $user->id) }}" class="pending-form">
                                                @csrf
                                                <button type="submit" class="action-btn btn-pending" data-bs-toggle="tooltip" title="รออนุมัติ">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="action-btn btn-edit"
                                           data-bs-toggle="tooltip"
                                           title="แก้ไข">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-del" data-bs-toggle="tooltip" title="ลบ">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-box">
                                        <i class="bi bi-inbox"></i>
                                        ไม่พบข้อมูลผู้ใช้งาน
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'สำเร็จ',
    text: '{{ session('success') }}',
    confirmButtonColor: '#0B7F6F',
    confirmButtonText: 'ตกลง'
});
</script>
@endif

<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e){
        e.preventDefault();

        Swal.fire({
            icon: 'warning',
            title: 'ยืนยันการลบ?',
            text: 'ต้องการลบผู้ใช้งานนี้ใช่หรือไม่',
            showCancelButton: true,
            confirmButtonText: 'ลบ',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if(result.isConfirmed){
                form.submit();
            }
        });
    });
});

document.querySelectorAll('.approve-form').forEach(form => {
    form.addEventListener('submit', function(e){
        e.preventDefault();

        Swal.fire({
            icon: 'question',
            title: 'ยืนยันการอนุมัติ?',
            text: 'ต้องการอนุมัติผู้ใช้งานนี้ใช่หรือไม่',
            showCancelButton: true,
            confirmButtonText: 'อนุมัติ',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if(result.isConfirmed){
                form.submit();
            }
        });
    });
});

document.querySelectorAll('.pending-form').forEach(form => {
    form.addEventListener('submit', function(e){
        e.preventDefault();

        Swal.fire({
            icon: 'warning',
            title: 'เปลี่ยนเป็นรออนุมัติ?',
            text: 'ต้องการเปลี่ยนสถานะกลับเป็นรออนุมัติใช่หรือไม่',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if(result.isConfirmed){
                form.submit();
            }
        });
    });
});

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
[...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));
</script>

</body>
</html>