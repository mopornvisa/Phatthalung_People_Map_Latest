<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>System Logs | Phatthalung People Map</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

body{
    font-family:'Prompt',sans-serif;
    background:linear-gradient(135deg,#eef8f6,#f8fafc);
    color:#0f172a;
}

.log-wrap{
    padding:28px;
}

.log-hero{
    background:linear-gradient(135deg,#075f55,#0B7F6F,#0B5B6B);
    color:white;
    border-radius:26px;
    padding:26px;
    box-shadow:0 20px 50px rgba(11,91,107,.22);
    margin-bottom:20px;
}

.log-hero h3{
    font-size:25px;
    font-weight:800;
    margin:0;
}

.filter-card,
.table-card{
    background:white;
    border:1px solid #dcebe7;
    border-radius:22px;
    box-shadow:0 10px 28px rgba(15,23,42,.07);
}

.filter-card{
    padding:18px;
    margin-bottom:18px;
}

.form-control,
.form-select{
    height:46px;
    border-radius:14px;
    font-size:13px;
    border:1px solid #d8e8ef;
}

.form-control:focus,
.form-select:focus{
    border-color:#0B7F6F;
    box-shadow:0 0 0 .15rem rgba(11,127,111,.15);
}

.btn-main{
    height:46px;
    border-radius:14px;
    background:#0B7F6F;
    border:none;
    color:white;
    font-weight:700;
}

.btn-main:hover{
    background:#09685C;
    color:white;
}

.btn-clear{
    height:46px;
    border-radius:14px;
    font-weight:700;
}

.table th{
    background:#f8fafc;
    color:#475569;
    font-size:12px;
    white-space:nowrap;
}

.table td{
    font-size:13px;
    vertical-align:middle;
}

.badge-action{
    border-radius:999px;
    padding:7px 12px;
    font-size:12px;
    font-weight:800;
}

.action-login{
    background:#dcfce7;
    color:#166534;
}

.action-logout{
    background:#fee2e2;
    color:#991b1b;
}

.action-edit{
    background:#dbeafe;
    color:#1e40af;
}

.action-default{
    background:#eef8f6;
    color:#0B5B6B;
}

.ip-pill{
    background:#f1f5f9;
    border-radius:999px;
    padding:6px 10px;
    font-size:12px;
}

.empty-box{
    text-align:center;
    padding:60px 10px;
    color:#94a3b8;
}

.empty-box i{
    font-size:44px;
    display:block;
    margin-bottom:10px;
}

@media(max-width:768px){

    .log-wrap{
        padding:14px;
    }

}

</style>
</head>

<body>

@include('layouts.topbar')

<div class="log-wrap">

    <div class="log-hero d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h3>
                <i class="bi bi-clock-history me-2"></i>
                ประวัติการใช้งานระบบ
            </h3>

            <div class="mt-1 opacity-75">
                ตรวจสอบการเข้าสู่ระบบ การแก้ไขข้อมูล และกิจกรรมต่าง ๆ ของระบบ
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap">

            <a href="{{ route('admin.dashboard') }}"
               class="btn btn-light rounded-pill px-4 fw-bold">

                <i class="bi bi-speedometer2 me-1"></i>
                Dashboard

            </a>

            <a href="{{ route('admin.users.index') }}"
               class="btn btn-outline-light rounded-pill px-4 fw-bold">

                <i class="bi bi-people-fill me-1"></i>
                Users

            </a>

        </div>

    </div>

    <form method="GET" class="filter-card">

        <div class="row g-3 align-items-end">

            <div class="col-lg-4">

                <label class="form-label fw-bold">
                    ค้นหา
                </label>

                <input type="text"
                       name="keyword"
                       value="{{ $keyword }}"
                       class="form-control"
                       placeholder="username / action / IP">

            </div>

            <div class="col-lg-3">

                <label class="form-label fw-bold">
                    ประเภทกิจกรรม
                </label>

                <select name="action" class="form-select">

                    <option value="">
                        ทั้งหมด
                    </option>

                    @foreach($actions as $item)

                        <option value="{{ $item }}"
                            {{ $action == $item ? 'selected' : '' }}>

                            {{ $item }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-lg-2">

                <label class="form-label fw-bold">
                    วันที่
                </label>

                <input type="date"
                       name="date"
                       value="{{ $date }}"
                       class="form-control">

            </div>

            <div class="col-lg-3">

                <div class="row g-2">

                    <div class="col-6">

                        <button type="submit"
                                class="btn btn-main w-100">

                            <i class="bi bi-search me-1"></i>
                            ค้นหา

                        </button>

                    </div>

                    <div class="col-6">

                        <a href="{{ route('system.logs.index') }}"
                           class="btn btn-light border btn-clear w-100 d-flex align-items-center justify-content-center">

                            ล้างค่า

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </form>

    <div class="table-card overflow-hidden">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>

                    <tr>

                        <th width="70">#</th>
                        <th>ผู้ใช้งาน</th>
                        <th>สิทธิ์</th>
                        <th>กิจกรรม</th>
                        <th>รายละเอียด</th>
                        <th>IP</th>
                        <th>เวลา</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($logs as $log)

                    @php

                        $badgeClass = 'action-default';

                        if($log->action == 'เข้าสู่ระบบ'){
                            $badgeClass = 'action-login';
                        }

                        if($log->action == 'ออกจากระบบ'){
                            $badgeClass = 'action-logout';
                        }

                        if(str_contains($log->action,'แก้ไข')){
                            $badgeClass = 'action-edit';
                        }

                    @endphp

                    <tr>

                        <td class="text-center fw-bold">
                            {{ $log->id }}
                        </td>

                        <td>

                            <div class="fw-bold">
                                {{ $log->username ?? '-' }}
                            </div>

                            <small class="text-muted">
                                {{ $log->agency ?? '-' }}
                            </small>

                        </td>

                        <td>

                            <span class="badge bg-dark">
                                {{ $log->role ?? '-' }}
                            </span>

                        </td>

                        <td>

                            <span class="badge-action {{ $badgeClass }}">
                                {{ $log->action }}
                            </span>

                        </td>

                        <td>
                            {{ $log->detail ?? '-' }}
                        </td>

                        <td>

                            <span class="ip-pill">
                                {{ $log->ip_address ?? '-' }}
                            </span>

                        </td>

                        <td class="text-nowrap">

                            {{ $log->created_at
                                ? $log->created_at->format('d/m/Y H:i')
                                : '-' }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7">

                            <div class="empty-box">

                                <i class="bi bi-inbox"></i>

                                ไม่มีข้อมูลประวัติการใช้งาน

                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-3">
        {{ $logs->links() }}
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>