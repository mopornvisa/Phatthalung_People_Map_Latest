<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ศูนย์รวมข้อมูลสุขภาพจังหวัดพัทลุง</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Prompt',sans-serif;
    background:
        radial-gradient(circle at top left,#dff8ef 0,#f7fbff 32%,transparent 55%),
        linear-gradient(135deg,#eefbf7 0%,#f7fbff 55%,#edf6fb 100%);
    min-height:100vh;
    color:#0f172a;
}

.health-wrap{
    max-width:1180px;
    margin:0 auto;
    padding:34px 18px 50px;
}

.health-shell{
    background:rgba(255,255,255,.88);
    border:1px solid rgba(255,255,255,.9);
    border-radius:34px;
    box-shadow:0 24px 60px rgba(15,23,42,.10);
    overflow:hidden;
    backdrop-filter:blur(14px);
}

.health-hero{
    position:relative;
    padding:46px 34px 38px;
    background:linear-gradient(135deg,#0B7F6F 0%,#0B5B6B 100%);
    color:#fff;
    overflow:hidden;
}

.health-hero::after{
    content:"";
    position:absolute;
    width:260px;
    height:260px;
    right:-80px;
    top:-90px;
    border-radius:50%;
    background:rgba(255,255,255,.13);
}

.health-hero::before{
    content:"";
    position:absolute;
    width:190px;
    height:190px;
    left:-70px;
    bottom:-90px;
    border-radius:50%;
    background:rgba(255,255,255,.10);
}

.hero-content{
    position:relative;
    z-index:2;
}

.hero-badge{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:rgba(255,255,255,.16);
    border:1px solid rgba(255,255,255,.28);
    padding:8px 16px;
    border-radius:999px;
    font-size:14px;
    font-weight:600;
    margin-bottom:16px;
}

.health-hero h1{
    font-size:38px;
    font-weight:700;
    margin-bottom:12px;
}

.health-hero p{
    max-width:760px;
    color:rgba(255,255,255,.82);
    font-size:16px;
    line-height:1.8;
    margin:0;
}

.menu-area{
    padding:32px;
}

.menu-title{
    font-size:20px;
    font-weight:700;
    color:#0B5B6B;
    margin-bottom:6px;
}

.menu-sub{
    color:#64748b;
    font-size:14px;
    margin-bottom:22px;
}

.health-card{
    position:relative;
    display:flex;
    gap:18px;
    height:100%;
    min-height:158px;
    padding:24px;
    background:#fff;
    border:1px solid #e5edf4;
    border-radius:26px;
    text-decoration:none;
    box-shadow:0 12px 28px rgba(15,23,42,.06);
    transition:.25s ease;
    overflow:hidden;
}

.health-card:hover{
    transform:translateY(-6px);
    box-shadow:0 20px 44px rgba(15,23,42,.12);
    border-color:#bde8df;
}

.health-card::after{
    content:"";
    position:absolute;
    right:-35px;
    bottom:-35px;
    width:110px;
    height:110px;
    border-radius:50%;
    background:var(--soft);
}

.card-icon{
    width:68px;
    height:68px;
    min-width:68px;
    border-radius:22px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:var(--soft);
    color:var(--main);
    font-size:30px;
}

.card-bodyx{
    position:relative;
    z-index:2;
    flex:1;
}

.card-bodyx h3{
    font-size:21px;
    font-weight:700;
    color:#334155;
    margin:0 0 8px;
}

.card-bodyx p{
    font-size:14px;
    color:#64748b;
    line-height:1.75;
    margin:0;
}

.card-arrow{
    position:relative;
    z-index:2;
    color:var(--main);
    font-size:25px;
    align-self:center;
}

.source-box{
    margin-top:26px;
    padding:16px 18px;
    border-radius:20px;
    background:#f8fbff;
    border:1px dashed #cfe2e8;
    color:#64748b;
    font-size:13px;
}

@media(max-width:768px){
    .health-hero{
        padding:34px 24px;
    }

    .health-hero h1{
        font-size:29px;
    }

    .menu-area{
        padding:24px;
    }

    .health-card{
        flex-direction:column;
    }
}
</style>
</head>

<body>

@include('layouts.topbar')

<div class="health-wrap">
<div class="health-shell">

    {{-- HERO --}}
    <div class="health-hero">
        <div class="hero-content">

            <div class="hero-badge">
                <i class="bi bi-heart-pulse-fill"></i>
                ข้อมูลสุขภาพจังหวัดพัทลุง
            </div>

            <h1>ศูนย์รวมข้อมูลสุขภาพจังหวัดพัทลุง</h1>

            <p>
                แสดงข้อมูลสุขภาพจากหลายแหล่งข้อมูล เพื่อใช้ติดตามสถานการณ์ วิเคราะห์พื้นที่
                และสนับสนุนการตัดสินใจเชิงนโยบายในระดับจังหวัด อำเภอ และพื้นที่
            </p>

        </div>
    </div>

    {{-- MENU --}}
    <div class="menu-area">

        <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
            <div>
                <div class="menu-title">
                    เลือกชุดข้อมูลที่ต้องการดู
                </div>

                <div class="menu-sub">
                    กดเลือกเมนูด้านล่างเพื่อเข้าสู่หน้ารายงานและแดชบอร์ด
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- CARD 1 --}}
<div class="col-md-6">
    <a href="{{ route('dashboard') }}"
       class="health-card"
       style="--main:#f59e0b; --soft:#fff7e8;">

        <div class="card-icon">
            <i class="bi bi-bar-chart-fill"></i>
        </div>

        <div class="card-bodyx">
            <h3>ภาพรวมครัวเรือนยากจน</h3>

            <p>
                แสดงข้อมูลภาพรวมครัวเรือนยากจนของจังหวัดพัทลุง
                พร้อมข้อมูลด้านสุขภาพ การศึกษา รายได้ และคุณภาพชีวิต
                เพื่อใช้ติดตามและวิเคราะห์เชิงพื้นที่
            </p>
        </div>

        <div class="card-arrow">
            <i class="bi bi-arrow-right-circle-fill"></i>
        </div>

    </a>
</div>

            {{-- CARD 2 --}}
            <div class="col-md-6">
                <a href="{{ route('health.index') }}"
                   class="health-card"
                   style="--main:#0B7F6F; --soft:#e8faf4;">

                    <div class="card-icon">
                        <i class="bi bi-database-fill"></i>
                    </div>

                    <div class="card-bodyx">
                        <h3>ข้อมูลสุขภาพจากข้อมูลความยากจน</h3>

                        <p>
                            แสดงข้อมูลสุขภาพที่เชื่อมโยงจากฐานข้อมูลความยากจนของประชาชนจังหวัดพัทลุง
                            พร้อมใช้ประกอบการวิเคราะห์เชิงพื้นที่
                        </p>
                    </div>

                    <div class="card-arrow">
                        <i class="bi bi-arrow-right-circle-fill"></i>
                    </div>

                </a>
            </div>

            {{-- CARD 3 --}}
            <div class="col-md-6">
                <a href="{{ route('health.cardio.menu') }}"
                   class="health-card"
                   style="--main:#14b8a6; --soft:#ecfdf5;">

                    <div class="card-icon">
                        <i class="bi bi-activity"></i>
                    </div>

                    <div class="card-bodyx">
                        <h3>โรคไม่ติดต่อ</h3>

                        <p>
                            รวมข้อมูลโรคหัวใจ เบาหวาน ความดัน หลอดเลือดสมอง
                            และโรคสำคัญอื่น ๆ เพื่อดูแนวโน้มและเปรียบเทียบรายพื้นที่
                        </p>
                    </div>

                    <div class="card-arrow">
                        <i class="bi bi-arrow-right-circle-fill"></i>
                    </div>

                </a>
            </div>

            {{-- CARD 4 --}}
            <div class="col-md-6">
                <a href="{{ route('health.death_dashboard') }}"
                   class="health-card"
                   style="--main:#dc2626; --soft:#fff1f2;">

                    <div class="card-icon">
                        <i class="bi bi-heartbreak-fill"></i>
                    </div>

                    <div class="card-bodyx">
                        <h3>ข้อมูลการเสียชีวิต</h3>

                        <p>
                            แสดงสถิติการเสียชีวิต จำแนกตามปี อำเภอ เพศ กลุ่มอายุ
                            และสาเหตุการตาย พร้อมใช้สำหรับติดตามสถานการณ์สุขภาพ
                        </p>
                    </div>

                    <div class="card-arrow">
                        <i class="bi bi-arrow-right-circle-fill"></i>
                    </div>

                </a>
            </div>

        </div>

        <div class="source-box">
            <i class="bi bi-info-circle me-1"></i>
            ข้อมูลในระบบใช้เพื่อสนับสนุนการวิเคราะห์ ติดตามสถานการณ์
            และประกอบการตัดสินใจเชิงพื้นที่
        </div>

    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>