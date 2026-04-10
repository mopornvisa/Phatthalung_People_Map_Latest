<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลสถานะสุขภาพ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body style="font-family:'Prompt',sans-serif; background:linear-gradient(135deg,#e9f7f4 0%,#f4fbff 50%,#eef6fb 100%); min-height:100vh; margin:0;">

@include('layouts.topbar')

<div style="min-height:100vh; padding:32px 20px;">
    <div style="max-width:1150px; margin:0 auto; background:rgba(255,255,255,.92); border:1px solid rgba(255,255,255,.7); border-radius:32px; box-shadow:0 18px 45px rgba(15,23,42,.08); backdrop-filter:blur(10px); overflow:hidden;">

        <!-- HEADER -->
        <div style="padding:42px 32px 26px; background:linear-gradient(135deg,#f8fffd 0%,#eef9f6 45%,#f4faff 100%); border-bottom:1px solid #e6f0ef; text-align:center;">
            <div style="display:inline-flex; align-items:center; gap:8px; background:#e8faf4; color:#0f8b7d; border:1px solid #cceee3; padding:8px 16px; border-radius:999px; font-size:14px; font-weight:600; margin-bottom:18px;">
                <i class="bi bi-heart-pulse-fill"></i>
                เมนูข้อมูลสุขภาพ
            </div>

            <h1 style="font-size:42px; font-weight:700; color:#0f8b7d; margin:0 0 10px 0;">
                ข้อมูลสถานะสุขภาพ
            </h1>

            <p style="font-size:17px; color:#64748b; margin:0;">
                เลือกหมวดหมู่ย่อยที่ต้องการ
            </p>
        </div>

        <!-- CARD MENU -->
        <div style="padding:34px 28px 38px;">
            <div class="row g-4">

                <!-- ✅ เพิ่มใหม่: ไปหน้า health.blade.php -->
                <div class="col-md-6">
                    <a href="{{ route('health.index') }}"
                       style="display:flex; align-items:center; gap:18px; text-decoration:none; background:linear-gradient(135deg,#ffffff 0%,#f8fcff 100%); border:1px solid #e5edf4; border-left:6px solid #0f8b7d; border-radius:24px; padding:22px; min-height:120px; box-shadow:0 10px 24px rgba(15,23,42,.05); height:100%;">
                        
                        <div style="width:68px; height:68px; min-width:68px; border-radius:20px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#e8faf4 0%,#e6fffb 100%); color:#6480a0; font-size:30px;">
                            <i class="bi bi-house-door"></i>
                        </div>

                        <div style="flex:1;">
                            <div style="font-size:24px; font-weight:600; color:#6b7a96; margin-bottom:8px;">
                                เมนูหลักข้อมูลสุขภาพ
                            </div>
                            <p style="color:#94a3b8; font-size:14px; margin:0;">
                                ไปยังหน้าหลักของระบบข้อมูลสุขภาพ
                            </p>
                        </div>

                        <div style="width:44px; height:44px; border-radius:999px; background:#f1f8fd; display:flex; align-items:center; justify-content:center;">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- CARD 1 -->
                <div class="col-md-6">
                    <a href="{{ route('health.cardio.menu') }}"
                       style="display:flex; align-items:center; gap:18px; text-decoration:none; background:linear-gradient(135deg,#ffffff 0%,#f8fcff 100%); border:1px solid #e5edf4; border-left:6px solid #14b8a6; border-radius:24px; padding:22px; min-height:120px; box-shadow:0 10px 24px rgba(15,23,42,.05); height:100%;">
                        
                        <div style="width:68px; height:68px; border-radius:20px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#e8fff8 0%,#e6f4ff 100%); font-size:30px;">
                            <i class="bi bi-heart-pulse"></i>
                        </div>

                        <div style="flex:1;">
                            <div style="font-size:24px; font-weight:600; color:#6b7a96;">โรคไม่ติดต่อที่สำคัญ</div>
                            <p style="color:#94a3b8; font-size:14px; margin:0;">แสดงแนวโน้มและการกระจายของผู้ป่วยในพื้นที่</p>
                        </div>

                        <div style="width:44px; height:44px; border-radius:999px; background:#f1f8fd; display:flex; align-items:center; justify-content:center;">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- CARD 2 -->
                <div class="col-md-6">
                    <a href="{{ route('health.mortality_cause') }}"
                       style="display:flex; align-items:center; gap:18px; text-decoration:none; background:linear-gradient(135deg,#ffffff 0%,#f8fcff 100%); border:1px solid #e5edf4; border-left:6px solid #60a5fa; border-radius:24px; padding:22px; min-height:120px; box-shadow:0 10px 24px rgba(15,23,42,.05); height:100%;">
                        
                        <div style="width:68px; height:68px; border-radius:20px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#edf7ff 0%,#eef4ff 100%); font-size:30px;">
                            <i class="bi bi-clipboard2-pulse"></i>
                        </div>

                        <div style="flex:1;">
                            <div style="font-size:24px; font-weight:600; color:#6b7a96;">สาเหตุการเจ็บป่วยและการเสียชีวิต</div>
                            <p style="color:#94a3b8; font-size:14px; margin:0;">ข้อมูลสถิติและการจำแนกตามสาเหตุ</p>
                        </div>

                        <div style="width:44px; height:44px; border-radius:999px; background:#f1f8fd; display:flex; align-items:center; justify-content:center;">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- CARD 3 -->
                <div class="col-md-6">
                    <a href="{{ route('health.occupation_environment') }}"
                       style="display:flex; align-items:center; gap:18px; text-decoration:none; background:linear-gradient(135deg,#ffffff 0%,#f8fcff 100%); border:1px solid #e5edf4; border-left:6px solid #f59e0b; border-radius:24px; padding:22px; min-height:120px; box-shadow:0 10px 24px rgba(15,23,42,.05); height:100%;">
                        
                        <div style="width:68px; height:68px; border-radius:20px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#fff7e8 0%,#fff2e2 100%); font-size:30px;">
                            <i class="bi bi-person-workspace"></i>
                        </div>

                        <div style="flex:1;">
                            <div style="font-size:24px; font-weight:600; color:#6b7a96;">โรคจากการประกอบอาชีพ</div>
                            <p style="color:#94a3b8; font-size:14px; margin:0;">ผลกระทบจากอาชีพและสิ่งแวดล้อม</p>
                        </div>

                        <div style="width:44px; height:44px; border-radius:999px; background:#f1f8fd; display:flex; align-items:center; justify-content:center;">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- CARD 4 -->
                <div class="col-md-6">
                    <a href="{{ route('health.air_pollution') }}"
                       style="display:flex; align-items:center; gap:18px; text-decoration:none; background:linear-gradient(135deg,#ffffff 0%,#f8fcff 100%); border:1px solid #e5edf4; border-left:6px solid #8b5cf6; border-radius:24px; padding:22px; min-height:120px; box-shadow:0 10px 24px rgba(15,23,42,.05); height:100%;">
                        
                        <div style="width:68px; height:68px; border-radius:20px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#f5efff 0%,#eef2ff 100%); font-size:30px;">
                            <i class="bi bi-cloud-haze2"></i>
                        </div>

                        <div style="flex:1;">
                            <div style="font-size:24px; font-weight:600; color:#6b7a96;">โรคจากมลพิษทางอากาศ</div>
                            <p style="color:#94a3b8; font-size:14px; margin:0;">ข้อมูลสุขภาพจากคุณภาพอากาศ</p>
                        </div>

                        <div style="width:44px; height:44px; border-radius:999px; background:#f1f8fd; display:flex; align-items:center; justify-content:center;">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>