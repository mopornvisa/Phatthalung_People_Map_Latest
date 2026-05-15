<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Admin Dashboard | Phatthalung People Map</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Prompt',sans-serif;
    background:linear-gradient(135deg,#eef8f6,#f8fafc);
    color:#0f172a;
}

.page-wrap{
    padding:28px;
}

.hero{
    background:linear-gradient(135deg,#075f55,#0B7F6F,#0B5B6B);
    color:white;
    border-radius:26px;
    padding:28px;
    box-shadow:0 20px 50px rgba(11,91,107,.24);
    margin-bottom:20px;
}

.hero h1{
    font-size:26px;
    font-weight:800;
    margin:0;
}

.hero p{
    margin:6px 0 0;
    opacity:.9;
}

.stat-card{
    background:white;
    border:1px solid #dcebe7;
    border-radius:22px;
    padding:22px;
    box-shadow:0 10px 28px rgba(15,23,42,.07);
    height:100%;
}

.stat-icon{
    width:48px;
    height:48px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:22px;
    margin-bottom:14px;
}

.bg-green{background:#0B7F6F;}
.bg-blue{background:#2563eb;}
.bg-orange{background:#f59e0b;}
.bg-red{background:#dc2626;}

.stat-label{
    color:#64748b;
    font-size:13px;
    font-weight:600;
}

.stat-value{
    font-size:32px;
    font-weight:800;
    line-height:1;
    margin-top:6px;
}

.card-box{
    background:white;
    border:1px solid #dcebe7;
    border-radius:22px;
    box-shadow:0 10px 28px rgba(15,23,42,.07);
    overflow:hidden;
}

.card-head{
    padding:18px 22px;
    border-bottom:1px solid #e5eceb;
    font-weight:800;
    color:#0B5B6B;
}

.table th{
    background:#f8fafc;
    font-size:12px;
    color:#475569;
    white-space:nowrap;
}

.table td{
    font-size:13px;
    vertical-align:middle;
}

.badge-action{
    background:#eef8f6;
    color:#0B5B6B;
    border:1px solid #d8ebe7;
    border-radius:999px;
    padding:6px 10px;
    font-weight:700;
    font-size:12px;
}

.quick-btn{
    border-radius:14px;
    height:44px;
    font-weight:700;
}

@media(max-width:768px){
    .page-wrap{padding:14px;}
}
</style>
</head>

<body>

@include('layouts.topbar')

<div class="page-wrap">

    <div class="hero d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>
                <i class="bi bi-speedometer2 me-2"></i>
                Admin Dashboard
            </h1>
            <p>ภาพรวมผู้ใช้งาน ระบบสิทธิ์ และกิจกรรมล่าสุดของระบบ</p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.users.index') }}" class="btn btn-light quick-btn px-4">
                <i class="bi bi-people-fill me-1"></i>
                จัดการผู้ใช้
            </a>

            <a href="{{ route('system.logs.index') }}" class="btn btn-outline-light quick-btn px-4">
                <i class="bi bi-clock-history me-1"></i>
                System Logs
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-green">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-label">ผู้ใช้งานทั้งหมด</div>
                <div class="stat-value">{{ number_format($totalUsers) }}</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-orange">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-label">รออนุมัติ</div>
                <div class="stat-value">{{ number_format($pendingUsers) }}</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-blue">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="stat-label">ผู้ดูแลระบบ</div>
                <div class="stat-value">{{ number_format($adminUsers) }}</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-red">
                    <i class="bi bi-activity"></i>
                </div>
                <div class="stat-label">กิจกรรมวันนี้</div>
                <div class="stat-value">{{ number_format($todayLogs) }}</div>
            </div>
        </div>

    </div>

    <div class="card-box">
        <div class="card-head d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-clock-history me-2"></i>
                กิจกรรมล่าสุด
            </div>

            <a href="{{ route('system.logs.index') }}" class="btn btn-sm btn-success rounded-pill px-3">
                ดูทั้งหมด
            </a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th width="70">#</th>
                        <th>ผู้ใช้</th>
                        <th>สิทธิ์</th>
                        <th>หน่วยงาน</th>
                        <th>กิจกรรม</th>
                        <th>รายละเอียด</th>
                        <th>เวลา</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($latestLogs as $log)
                    <tr>
                        <td class="text-center fw-bold">{{ $log->id }}</td>

                        <td>
                            <strong>{{ $log->username ?? '-' }}</strong>
                            <div class="text-muted small">{{ $log->ip_address }}</div>
                        </td>

                        <td>{{ $log->role ?? '-' }}</td>

                        <td>{{ $log->agency ?? '-' }}</td>

                        <td>
                            <span class="badge-action">
                                {{ $log->action }}
                            </span>
                        </td>

                        <td>{{ $log->detail ?? '-' }}</td>

                        <td class="text-nowrap">
                            {{ $log->created_at ? $log->created_at->format('d/m/Y H:i') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            ยังไม่มีประวัติการใช้งาน
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>