<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ศูนย์รวมข้อมูลสุขภาพจังหวัดพัทลุง</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body style="font-family:'Prompt',sans-serif; background:linear-gradient(135deg,#e9f7f4 0%,#f4fbff 50%,#eef6fb 100%); min-height:100vh; margin:0;">

@include('layouts.topbar')

<div style="min-height:100vh; padding:32px 20px;">
<div style="max-width:1150px; margin:0 auto; background:rgba(255,255,255,.92); border:1px solid rgba(255,255,255,.7); border-radius:32px; box-shadow:0 18px 45px rgba(15,23,42,.08); backdrop-filter:blur(10px); overflow:hidden;">

<!-- HEADER -->
<div style="padding:42px 32px 28px; background:linear-gradient(135deg,#f8fffd 0%,#eef9f6 45%,#f4faff 100%); border-bottom:1px solid #e6f0ef; text-align:center;">

    <div style="display:inline-flex; align-items:center; gap:8px; background:#e8faf4; color:#0f8b7d; border:1px solid #cceee3; padding:8px 16px; border-radius:999px; font-size:14px; font-weight:600; margin-bottom:18px;">
        <i class="bi bi-heart-pulse-fill"></i>
        ระบบข้อมูลสุขภาพจังหวัดพัทลุง
    </div>

    <h1 style="font-size:40px; font-weight:700; color:#0f8b7d; margin:0 0 12px 0;">
       ข้อมูลสุขภาพจังหวัดพัทลุง
    </h1>

    <p style="font-size:17px; color:#64748b; margin:0 0 12px 0; line-height:1.8;">
        แสดงข้อมูลสุขภาพจากหลายแหล่งข้อมูล เพื่อใช้ติดตามสถานการณ์ วิเคราะห์พื้นที่ และสนับสนุนการตัดสินใจเชิงนโยบาย
    </p>

    
</div>




<!-- MENU -->
<div style="padding:34px 28px 38px;">
<div class="row g-4">

<!-- CARD 1 -->
<div class="col-md-6">
<a href="{{ route('health.index') }}"
style="display:flex; align-items:center; gap:18px; text-decoration:none; background:#fff; border:1px solid #e5edf4; border-left:6px solid #0f8b7d; border-radius:24px; padding:22px; min-height:130px; box-shadow:0 10px 24px rgba(15,23,42,.05); height:100%;">

<div style="width:68px;height:68px;border-radius:20px;display:flex;align-items:center;justify-content:center;background:#e8faf4;color:#0f8b7d;font-size:30px;">
<i class="bi bi-database-fill"></i>
</div>

<div style="flex:1;">
<div style="font-size:22px;font-weight:600;color:#475569;margin-bottom:8px;">
ข้อมูลสุขภาพจากข้อมูลความยากจน (PPAOS)
</div>
<p style="color:#94a3b8;font-size:14px;margin:0;line-height:1.7;">
แสดงข้อมูลสุขภาพที่เชื่อมโยงจากข้อมูลความยากจนของประชาชนจังหวัดพัทลุง
</p>
</div>

<div style="color:#0f8b7d;"><i class="bi bi-arrow-right-circle-fill"></i></div>
</a>
</div>

<!-- CARD 2 -->
<div class="col-md-6">
<a href="{{ route('health.cardio.menu') }}"
style="display:flex; align-items:center; gap:18px; text-decoration:none; background:#fff; border:1px solid #e5edf4; border-left:6px solid #14b8a6; border-radius:24px; padding:22px; min-height:130px; box-shadow:0 10px 24px rgba(15,23,42,.05); height:100%;">

<div style="width:68px;height:68px;border-radius:20px;display:flex;align-items:center;justify-content:center;background:#e8faf4;color:#0f8b7d;font-size:30px;">
<i class="bi bi-heart-pulse-fill"></i>
</div>

<div style="flex:1;">
<div style="font-size:22px;font-weight:600;color:#475569;margin-bottom:8px;">
โรคไม่ติดต่อ
</div>
<p style="color:#94a3b8;font-size:14px;margin:0;line-height:1.7;">
ข้อมูลโรคหัวใจ เบาหวาน ความดัน หลอดเลือดสมอง และโรคสำคัญอื่น ๆ
</p>
</div>

<div style="color:#0f8b7d;"><i class="bi bi-arrow-right-circle-fill"></i></div>
</a>
</div>

<!-- CARD 3 -->
<div class="col-md-6">
<a href="{{ route('health.mortality_cause') }}"
style="display:flex; align-items:center; gap:18px; text-decoration:none; background:#fff; border:1px solid #e5edf4; border-left:6px solid #3b82f6; border-radius:24px; padding:22px; min-height:130px; box-shadow:0 10px 24px rgba(15,23,42,.05); height:100%;">

<div style="width:68px;height:68px;border-radius:20px;display:flex;align-items:center;justify-content:center;background:#eef4ff;color:#3b82f6;font-size:30px;">
<i class="bi bi-clipboard2-pulse-fill"></i>
</div>

<div style="flex:1;">
<div style="font-size:22px;font-weight:600;color:#475569;margin-bottom:8px;">
สาเหตุการเจ็บป่วยและเสียชีวิต
</div>
<p style="color:#94a3b8;font-size:14px;margin:0;line-height:1.7;">
แสดงสถิติการเจ็บป่วยและการเสียชีวิต จำแนกตามสาเหตุสำคัญ
</p>
</div>

<div style="color:#3b82f6;"><i class="bi bi-arrow-right-circle-fill"></i></div>
</a>
</div>

<!-- CARD 4 -->
<div class="col-md-6">
<a href="{{ route('health.occupation_environment') }}"
style="display:flex; align-items:center; gap:18px; text-decoration:none; background:#fff; border:1px solid #e5edf4; border-left:6px solid #f59e0b; border-radius:24px; padding:22px; min-height:130px; box-shadow:0 10px 24px rgba(15,23,42,.05); height:100%;">

<div style="width:68px;height:68px;border-radius:20px;display:flex;align-items:center;justify-content:center;background:#fff7e8;color:#d97706;font-size:30px;">
<i class="bi bi-person-workspace"></i>
</div>

<div style="flex:1;">
<div style="font-size:22px;font-weight:600;color:#475569;margin-bottom:8px;">
สุขภาพจากการประกอบอาชีพ
</div>
<p style="color:#94a3b8;font-size:14px;margin:0;line-height:1.7;">
แสดงผลกระทบด้านสุขภาพจากการทำงานและสภาพแวดล้อมการประกอบอาชีพ
</p>
</div>

<div style="color:#d97706;"><i class="bi bi-arrow-right-circle-fill"></i></div>
</a>
</div>

<!-- CARD 5 -->
<div class="col-md-6">
<a href="{{ route('health.air_pollution') }}"
style="display:flex; align-items:center; gap:18px; text-decoration:none; background:#fff; border:1px solid #e5edf4; border-left:6px solid #8b5cf6; border-radius:24px; padding:22px; min-height:130px; box-shadow:0 10px 24px rgba(15,23,42,.05); height:100%;">

<div style="width:68px;height:68px;border-radius:20px;display:flex;align-items:center;justify-content:center;background:#f5efff;color:#7c3aed;font-size:30px;">
<i class="bi bi-cloud-haze2-fill"></i>
</div>

<div style="flex:1;">
<div style="font-size:22px;font-weight:600;color:#475569;margin-bottom:8px;">
สุขภาพจากมลพิษทางอากาศ
</div>
<p style="color:#94a3b8;font-size:14px;margin:0;line-height:1.7;">
แสดงผลกระทบด้านสุขภาพที่เกี่ยวข้องกับฝุ่นควันและคุณภาพอากาศ
</p>
</div>

<div style="color:#7c3aed;"><i class="bi bi-arrow-right-circle-fill"></i></div>
</a>
</div>


        </div>
        </div>

        </div>
        </div>

        </div>
        </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>