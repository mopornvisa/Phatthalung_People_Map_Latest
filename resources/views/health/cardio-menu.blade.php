<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โรคหัวใจและหลอดเลือด</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body{
            font-family:'Prompt',sans-serif;
            background:
                radial-gradient(circle at top right, rgba(20,184,166,.10), transparent 22%),
                radial-gradient(circle at bottom left, rgba(13,148,136,.08), transparent 25%),
                linear-gradient(135deg,#e9f7f4 0%,#f4fbff 50%,#eef6fb 100%);
            min-height:100vh;
            margin:0;
            color:#0f172a;
        }

        .page-wrap{
            max-width:1080px;
            margin:34px auto;
            padding:0 18px 32px;
        }

        .hero{
            background: linear-gradient(135deg, #0f8b7d 0%, #14b8a6 55%, #67e8f9 100%);
            border-radius: 30px;
            padding: 34px 34px 28px;
            box-shadow: 0 22px 50px rgba(15,139,125,.18);
            color:#fff;
            position:relative;
            overflow:hidden;
            margin-bottom:24px;
        }

        .hero::before{
            content:"";
            position:absolute;
            width:240px;
            height:240px;
            border-radius:50%;
            background:rgba(255,255,255,.10);
            top:-90px;
            right:-70px;
        }

        .hero::after{
            content:"";
            position:absolute;
            width:130px;
            height:130px;
            border-radius:50%;
            background:rgba(255,255,255,.10);
            bottom:-40px;
            right:120px;
        }

        .hero-content{
            position:relative;
            z-index:1;
        }

        .hero-chip{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:8px 14px;
            border-radius:999px;
            background:rgba(255,255,255,.16);
            border:1px solid rgba(255,255,255,.24);
            font-size:13px;
            font-weight:600;
            margin-bottom:16px;
        }

        .hero-title{
            font-size:36px;
            font-weight:700;
            margin-bottom:8px;
            line-height:1.3;
        }

        .hero-subtitle{
            font-size:15px;
            opacity:.95;
            margin:0;
            max-width:760px;
        }

        .toolbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:14px;
            flex-wrap:wrap;
            margin-bottom:18px;
        }

        .back-btn{
            display:inline-flex;
            align-items:center;
            gap:8px;
            text-decoration:none;
            color:#475569;
            background:#fff;
            border:1px solid #dbe7f3;
            border-radius:999px;
            padding:10px 18px;
            box-shadow:0 6px 18px rgba(15,23,42,.05);
        }

        .count-badge{
            background:#f0fdfa;
            color:#0f766e;
            border:1px solid #cceee3;
            border-radius:999px;
            padding:10px 16px;
            font-size:14px;
            font-weight:600;
        }

        .menu-panel{
            background:rgba(255,255,255,.92);
            border:1px solid rgba(255,255,255,.8);
            border-radius:30px;
            box-shadow:0 18px 45px rgba(15,23,42,.08);
            backdrop-filter:blur(10px);
            overflow:hidden;
        }

        .panel-head{
            padding:24px 26px 14px;
            border-bottom:1px solid #ecf4f3;
        }

        .panel-title{
            font-size:22px;
            font-weight:700;
            color:#0f766e;
            margin:0 0 6px;
        }

        .panel-desc{
            margin:0;
            font-size:14px;
            color:#64748b;
        }

        .menu-list{
            padding:8px 16px 18px;
        }

        .menu-item{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:18px;
            padding:18px 14px;
            text-decoration:none;
            color:inherit;
            border-radius:22px;
            transition:all .22s ease;
            border:1px solid transparent;
        }

        .menu-item + .menu-item{
            margin-top:6px;
        }

        .menu-item:hover{
            background:linear-gradient(135deg,#f7fffd 0%,#effcf8 100%);
            border-color:#d9f3ec;
            transform:translateY(-1px);
        }

        .menu-left{
            display:flex;
            align-items:center;
            gap:16px;
            min-width:0;
        }

        .menu-no{
            width:46px;
            height:46px;
            min-width:46px;
            border-radius:16px;
            background:linear-gradient(135deg,#dffaf3 0%, #e8faf4 100%);
            border:1px solid #cceee3;
            color:#0f8b7d;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
            font-size:18px;
        }

        .menu-icon{
            width:52px;
            height:52px;
            min-width:52px;
            border-radius:18px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:linear-gradient(135deg,#e6fffa 0%,#ecfeff 100%);
            color:#0f8b7d;
            font-size:24px;
            border:1px solid #d8f3ed;
        }

        .menu-text{
            min-width:0;
        }

        .menu-title{
            font-size:20px;
            font-weight:600;
            color:#0f172a;
            line-height:1.45;
            margin-bottom:4px;
        }

        .menu-sub{
            font-size:13px;
            color:#64748b;
            margin:0;
        }

        .menu-arrow{
            width:42px;
            height:42px;
            min-width:42px;
            border-radius:14px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#0f8b7d;
            background:#f0fdfa;
            border:1px solid #d9f3ec;
            font-size:18px;
            transition:all .22s ease;
        }

        .menu-item:hover .menu-arrow{
            transform:translateX(2px);
            background:#e8faf4;
        }

        @media (max-width: 768px){
            .page-wrap{
                margin:24px auto;
            }

            .hero{
                padding:28px 22px 24px;
                border-radius:24px;
            }

            .hero-title{
                font-size:28px;
            }

            .menu-title{
                font-size:17px;
            }

            .menu-item{
                padding:16px 10px;
                align-items:flex-start;
            }

            .menu-left{
                align-items:flex-start;
            }

            .menu-arrow{
                margin-top:4px;
            }
        }
    </style>
</head>
<body>

    @include('layouts.topbar')

    <div class="page-wrap">

        

        <div class="toolbar">
            <a href="{{ route('health_status') }}" class="back-btn">
                <i class="bi bi-arrow-left"></i>
                กลับหน้าเมนูโรคไม่ติดต่อที่สำคัญ
            </a>

            <div class="count-badge">
                <i class="bi bi-grid-1x2-fill me-1"></i>
                ทั้งหมด 4 รายการ
            </div>
        </div>

        <div class="menu-panel">
            <div class="panel-head">
                <h2 class="panel-title">การป่วยด้วยโรคไม่ติดต่อที่สำคัญ</h2>
                <p class="panel-desc">เลือกหัวข้อที่ต้องการเพื่อดูรายละเอียดข้อมูลรายงาน</p>
            </div>

            <div class="menu-list">

                <a href="{{ route('health.cardio_incidence') }}" class="menu-item">
                    <div class="menu-left">
                        <div class="menu-no">1</div>
                        <div class="menu-icon">
                            <i class="bi bi-activity"></i>
                        </div>
                        <div class="menu-text">
                            <div class="menu-title">อัตราป่วยรายใหม่โรคหัวใจและหลอดเลือด</div>
                            <p class="menu-sub">แสดงข้อมูลผู้ป่วยรายใหม่ แยกตามปีและพื้นที่</p>
                        </div>
                    </div>
                    <div class="menu-arrow">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </a>

                <a href="{{ route('health.cardio-incidence-all') }}" class="menu-item">
                    <div class="menu-left">
                        <div class="menu-no">2</div>
                        <div class="menu-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="menu-text">
                            <div class="menu-title">อัตราป่วยด้วยโรคหัวใจและหลอดเลือดต่อประชากร</div>
                            <p class="menu-sub">แสดงอัตราป่วยเทียบกับจำนวนประชากรในแต่ละพื้นที่</p>
                        </div>
                    </div>
                    <div class="menu-arrow">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </a>

                <a href="{{ route('health.cardio-mortality') }}" class="menu-item">
                    <div class="menu-left">
                        <div class="menu-no">3</div>
                        <div class="menu-icon">
                            <i class="bi bi-heartbreak"></i>
                        </div>
                        <div class="menu-text">
                            <div class="menu-title">จำนวนผู้ป่วยตายโรคหัวใจและหลอดเลือด</div>
                            <p class="menu-sub">แสดงข้อมูลการเสียชีวิตจากโรคหัวใจและหลอดเลือด</p>
                        </div>
                    </div>
                    <div class="menu-arrow">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </a>

                <a href="{{ route('ht.incidence100k') }}" class="menu-item">
    <div class="menu-left">
        <div class="menu-no">4</div>
        <div class="menu-icon">
            <i class="bi bi-heart-pulse-fill"></i>
        </div>
        <div class="menu-text">
            <div class="menu-title">
                อัตราป่วยรายใหม่ของโรคความดันโลหิตสูงต่อแสนประชากรในปีงบประมาณ
            </div>
            <p class="menu-sub">
                แสดงข้อมูลจำนวนผู้ป่วยและอัตราป่วยต่อแสนประชากร รายปีและรายอำเภอ
            </p>
        </div>
    </div>
    <div class="menu-arrow">
        <i class="bi bi-chevron-right"></i>
    </div>
</a>

            </div>
        </div>

    </div>

</body>
</html>