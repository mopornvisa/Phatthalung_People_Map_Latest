<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การป่วยด้วยโรคไม่ติดต่อ</title>

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
            max-width:1180px;
            margin:34px auto;
            padding:0 18px 32px;
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
            background:rgba(255,255,255,.94);
            border:1px solid rgba(255,255,255,.8);
            border-radius:30px;
            box-shadow:0 18px 45px rgba(15,23,42,.08);
            backdrop-filter:blur(10px);
            overflow:hidden;
        }

        .panel-head{
            padding:24px 26px 16px;
            border-bottom:1px solid #ecf4f3;
        }

        .panel-title{
            font-size:24px;
            font-weight:700;
            color:#0f766e;
            margin:0;
        }

        .filter-bar{
            padding:18px 26px 10px;
            border-bottom:1px solid #edf2f7;
            background:linear-gradient(180deg,#fbfffe 0%,#f8fcfb 100%);
        }

        .search-box{
            position:relative;
        }

        .search-box .bi-search{
            position:absolute;
            top:50%;
            left:14px;
            transform:translateY(-50%);
            color:#94a3b8;
            font-size:15px;
        }

        .search-input{
            width:100%;
            border:1px solid #dbe7f3;
            border-radius:16px;
            padding:12px 14px 12px 40px;
            font-size:14px;
            outline:none;
            box-shadow:none;
        }

        .search-input:focus{
            border-color:#14b8a6;
            box-shadow:0 0 0 4px rgba(20,184,166,.08);
        }

        .quick-tags{
            display:flex;
            flex-wrap:wrap;
            gap:8px;
            margin-top:12px;
        }

        .quick-tag{
            border:none;
            background:#f1f5f9;
            color:#334155;
            border-radius:999px;
            padding:8px 14px;
            font-size:13px;
            font-weight:500;
            cursor:pointer;
            transition:.2s ease;
        }

        .quick-tag:hover,
        .quick-tag.active{
            background:#0f8b7d;
            color:#fff;
        }

        .menu-list{
            padding:14px 18px 22px;
        }

        .group-title{
            display:flex;
            align-items:center;
            gap:10px;
            font-size:18px;
            font-weight:700;
            color:#0f172a;
            margin:22px 8px 10px;
        }

        .group-title:first-child{
            margin-top:6px;
        }

        .group-dot{
            width:12px;
            height:12px;
            border-radius:50%;
            background:linear-gradient(135deg,#14b8a6 0%,#06b6d4 100%);
            box-shadow:0 0 0 5px rgba(20,184,166,.10);
        }

        .menu-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:12px;
        }

        .menu-item{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:14px;
            padding:18px 16px;
            text-decoration:none;
            color:inherit;
            border-radius:22px;
            transition:all .22s ease;
            border:1px solid #eef2f7;
            background:linear-gradient(135deg,#ffffff 0%,#fbfffe 100%);
            min-height:120px;
        }

        .menu-item:hover{
            background:linear-gradient(135deg,#f7fffd 0%,#effcf8 100%);
            border-color:#d9f3ec;
            transform:translateY(-1px);
            box-shadow:0 10px 24px rgba(15,23,42,.06);
        }

        .menu-left{
            display:flex;
            align-items:flex-start;
            gap:14px;
            min-width:0;
        }

        .menu-no{
            width:42px;
            height:42px;
            min-width:42px;
            border-radius:14px;
            background:linear-gradient(135deg,#dffaf3 0%, #e8faf4 100%);
            border:1px solid #cceee3;
            color:#0f8b7d;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
            font-size:16px;
        }

        .menu-icon{
            width:48px;
            height:48px;
            min-width:48px;
            border-radius:16px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:linear-gradient(135deg,#e6fffa 0%,#ecfeff 100%);
            color:#0f8b7d;
            font-size:22px;
            border:1px solid #d8f3ed;
        }

        .menu-text{
            min-width:0;
        }

        .menu-badge{
            display:inline-block;
            margin-bottom:6px;
            padding:4px 10px;
            border-radius:999px;
            background:#f0fdfa;
            color:#0f766e;
            border:1px solid #cceee3;
            font-size:11px;
            font-weight:700;
            letter-spacing:.2px;
        }

        .menu-title{
            font-size:18px;
            font-weight:600;
            color:#0f172a;
            line-height:1.45;
            margin-bottom:4px;
        }

        .menu-sub{
            font-size:13px;
            color:#64748b;
            margin:0;
            line-height:1.6;
        }

        .menu-arrow{
            width:40px;
            height:40px;
            min-width:40px;
            border-radius:14px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#0f8b7d;
            background:#f0fdfa;
            border:1px solid #d9f3ec;
            font-size:18px;
            transition:all .22s ease;
            margin-top:2px;
        }

        .menu-item:hover .menu-arrow{
            transform:translateX(2px);
            background:#e8faf4;
        }

        .menu-item.hidden{
            display:none !important;
        }

        .group-wrap.hidden{
            display:none !important;
        }

        @media (max-width: 992px){
            .menu-grid{
                grid-template-columns:1fr;
            }
        }

        @media (max-width: 768px){
            .page-wrap{
                margin:24px auto;
            }

            .panel-head,
            .filter-bar{
                padding-left:18px;
                padding-right:18px;
            }

            .menu-list{
                padding:12px;
            }

            .menu-title{
                font-size:17px;
            }

            .menu-item{
                min-height:auto;
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
            กลับหน้าเมนูโรคไม่ติดต่อ
        </a>

        <div class="count-badge">
            <i class="bi bi-grid-1x2-fill me-1"></i>
            ทั้งหมด 19 รายการ
        </div>
    </div>

    <div class="menu-panel">
        <div class="panel-head">
            <h2 class="panel-title">การป่วยด้วยโรคไม่ติดต่อ</h2>
        </div>

        <div class="filter-bar">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="menuSearch" class="search-input" placeholder="ค้นหาชื่อรายงาน เช่น เบาหวาน, มะเร็ง, หลอดเลือดสมอง, ตาย, รายใหม่">
            </div>

            <div class="quick-tags">
                <button class="quick-tag active" data-filter="all">ทั้งหมด</button>
                <button class="quick-tag" data-filter="หัวใจ">หัวใจ</button>
                <button class="quick-tag" data-filter="หลอดเลือดสมอง">หลอดเลือดสมอง</button>
                <button class="quick-tag" data-filter="ความดัน">ความดัน</button>
                <button class="quick-tag" data-filter="เบาหวาน">เบาหวาน</button>
                <button class="quick-tag" data-filter="ทางเดินหายใจ">ทางเดินหายใจ</button>
                <button class="quick-tag" data-filter="มะเร็ง">มะเร็ง</button>
                <button class="quick-tag" data-filter="เปรียบเทียบ">เปรียบเทียบ</button>
            </div>
        </div>

        <div class="menu-list">

            <div class="group-wrap" data-group="หัวใจ">
                <div class="group-title"><span class="group-dot"></span>โรคหัวใจและหลอดเลือด</div>
                <div class="menu-grid">
                    <a href="{{ route('health.cardio_incidence') }}" class="menu-item" data-keywords="หัวใจ หลอดเลือด รายใหม่ cardio หัวใจและหลอดเลือด">
                        <div class="menu-left">
                            <div class="menu-no">1</div>
                            <div class="menu-icon"><i class="bi bi-heart-pulse-fill"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">หัวใจ</div>
                                <div class="menu-title">อัตราป่วยรายใหม่โรคหัวใจและหลอดเลือด</div>
                                <p class="menu-sub">แสดงข้อมูลจำนวนผู้ป่วยรายปีและรายอำเภอ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>

                    <a href="{{ route('health.cardio-incidence-all') }}" class="menu-item" data-keywords="หัวใจ หลอดเลือด อัตราป่วย cardio ตามอายุ">
                        <div class="menu-left">
                            <div class="menu-no">2</div>
                            <div class="menu-icon"><i class="bi bi-heart-pulse-fill"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">หัวใจ</div>
                                <div class="menu-title">อัตราป่วยโรคหัวใจและหลอดเลือด</div>
                                <p class="menu-sub">จำนวนผู้ป่วยเทียบประชากร แยกตามปี อำเภอ และอายุ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>

                    <a href="{{ route('health.cardio-mortality') }}" class="menu-item" data-keywords="หัวใจ หลอดเลือด ตาย mortality ป่วยตาย เสียชีวิต">
                        <div class="menu-left">
                            <div class="menu-no">3</div>
                            <div class="menu-icon"><i class="bi bi-heartbreak-fill"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">หัวใจ</div>
                                <div class="menu-title">อัตราป่วยตายโรคหัวใจและหลอดเลือด</div>
                                <p class="menu-sub">จำนวนผู้ป่วย ผู้เสียชีวิต และร้อยละการป่วยตาย</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div class="group-wrap" data-group="หลอดเลือดสมอง">
                <div class="group-title"><span class="group-dot"></span>โรคหลอดเลือดสมอง</div>
                <div class="menu-grid">
                    <a href="{{ route('health.stroke-incidence-all') }}" class="menu-item" data-keywords="หลอดเลือดสมอง stroke อัตราป่วย ตามอายุ">
                        <div class="menu-left">
                            <div class="menu-no">4</div>
                            <div class="menu-icon"><i class="bi bi-activity"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">หลอดเลือดสมอง</div>
                                <div class="menu-title">อัตราป่วยโรคหลอดเลือดสมอง</div>
                                <p class="menu-sub">จำนวนผู้ป่วยเทียบประชากร แยกตามปี อำเภอ และอายุ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div class="group-wrap" data-group="ความดัน">
                <div class="group-title"><span class="group-dot"></span>โรคความดันโลหิตสูง</div>
                <div class="menu-grid">
                    <a href="{{ route('ht.incidence100k') }}" class="menu-item" data-keywords="ความดัน รายใหม่ ht hypertension">
                        <div class="menu-left">
                            <div class="menu-no">5</div>
                            <div class="menu-icon"><i class="bi bi-clipboard2-pulse-fill"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">ความดัน</div>
                                <div class="menu-title">อัตราป่วยรายใหม่โรคความดันโลหิตสูง</div>
                                <p class="menu-sub">แสดงข้อมูลจำนวนผู้ป่วยรายปีและรายอำเภอ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>

                    <a href="{{ route('health.ht-mortality') }}" class="menu-item" data-keywords="ความดัน ตาย mortality ป่วยตาย เสียชีวิต">
                        <div class="menu-left">
                            <div class="menu-no">6</div>
                            <div class="menu-icon"><i class="bi bi-heartbreak-fill"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">ความดัน</div>
                                <div class="menu-title">อัตราป่วยตายโรคความดันโลหิตสูง</div>
                                <p class="menu-sub">จำนวนผู้ป่วย ผู้เสียชีวิต และร้อยละการป่วยตาย</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>

                    <a href="{{ route('health.ht-incidence-all') }}" class="menu-item" data-keywords="ความดัน อัตราป่วย ตามอายุ">
                        <div class="menu-left">
                            <div class="menu-no">7</div>
                            <div class="menu-icon"><i class="bi bi-clipboard2-pulse-fill"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">ความดัน</div>
                                <div class="menu-title">อัตราป่วยโรคความดันโลหิตสูง</div>
                                <p class="menu-sub">จำนวนผู้ป่วยเทียบประชากร แยกตามปี อำเภอ และอายุ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div class="group-wrap" data-group="เบาหวาน">
                <div class="group-title"><span class="group-dot"></span>โรคเบาหวาน</div>
                <div class="menu-grid">
                    <a href="{{ route('dm.incidence.100k') }}" class="menu-item" data-keywords="เบาหวาน รายใหม่ dm diabetes">
                        <div class="menu-left">
                            <div class="menu-no">8</div>
                            <div class="menu-icon"><i class="bi bi-droplet-fill"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">เบาหวาน</div>
                                <div class="menu-title">อัตราป่วยรายใหม่โรคเบาหวาน</div>
                                <p class="menu-sub">แสดงข้อมูลรายปีและรายอำเภอ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>

                    <a href="{{ route('health.dm-incidence-all') }}" class="menu-item" data-keywords="เบาหวาน อัตราป่วย ตามอายุ">
                        <div class="menu-left">
                            <div class="menu-no">9</div>
                            <div class="menu-icon"><i class="bi bi-droplet-fill"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">เบาหวาน</div>
                                <div class="menu-title">อัตราป่วยโรคเบาหวาน</div>
                                <p class="menu-sub">จำนวนผู้ป่วยเทียบประชากร แยกตามปี อำเภอ และอายุ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>

                    <a href="{{ route('health.dm-mortality') }}" class="menu-item" data-keywords="เบาหวาน ตาย mortality ป่วยตาย เสียชีวิต">
                        <div class="menu-left">
                            <div class="menu-no">10</div>
                            <div class="menu-icon"><i class="bi bi-heartbreak-fill"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">เบาหวาน</div>
                                <div class="menu-title">อัตราป่วยตายโรคเบาหวาน</div>
                                <p class="menu-sub">จำนวนผู้ป่วย ผู้เสียชีวิต และร้อยละการป่วยตาย</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div class="group-wrap" data-group="ทางเดินหายใจ">
                <div class="group-title"><span class="group-dot"></span>โรคทางเดินหายใจ</div>
                <div class="menu-grid">
                    <a href="{{ route('copd.incidence.100k') }}" class="menu-item" data-keywords="ปอดอุดกั้นเรื้อรัง copd รายใหม่ ทางเดินหายใจ">
                        <div class="menu-left">
                            <div class="menu-no">11</div>
                            <div class="menu-icon"><i class="bi bi-lungs-fill"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">ทางเดินหายใจ</div>
                                <div class="menu-title">อัตราป่วยรายใหม่โรคปอดอุดกั้นเรื้อรัง</div>
                                <p class="menu-sub">แสดงข้อมูลรายปีและรายอำเภอ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>

                    <a href="{{ route('health.copd-incidence-all') }}" class="menu-item" data-keywords="ปอดอุดกั้นเรื้อรัง copd อัตราป่วย ตามอายุ">
                        <div class="menu-left">
                            <div class="menu-no">12</div>
                            <div class="menu-icon"><i class="bi bi-lungs-fill"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">ทางเดินหายใจ</div>
                                <div class="menu-title">อัตราป่วยโรคปอดอุดกั้นเรื้อรัง</div>
                                <p class="menu-sub">จำนวนผู้ป่วยเทียบประชากร แยกตามปี อำเภอ และอายุ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>

                    <a href="{{ route('health.copd-mortality') }}" class="menu-item" data-keywords="ปอดอุดกั้นเรื้อรัง copd ตาย mortality เสียชีวิต">
                        <div class="menu-left">
                            <div class="menu-no">13</div>
                            <div class="menu-icon"><i class="bi bi-heartbreak-fill"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">ทางเดินหายใจ</div>
                                <div class="menu-title">อัตราป่วยตายโรคปอดอุดกั้นเรื้อรัง</div>
                                <p class="menu-sub">จำนวนผู้ป่วย ผู้เสียชีวิต และร้อยละการป่วยตาย</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>

                    <a href="{{ route('as.incidence.100k') }}" class="menu-item" data-keywords="หืด asthma รายใหม่ ทางเดินหายใจ">
                        <div class="menu-left">
                            <div class="menu-no">14</div>
                            <div class="menu-icon"><i class="bi bi-wind"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">ทางเดินหายใจ</div>
                                <div class="menu-title">อัตราป่วยรายใหม่โรคหืด</div>
                                <p class="menu-sub">แสดงข้อมูลผู้ป่วยรายปีและรายอำเภอ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>

                    <a href="{{ route('health.emph-incidence-all') }}" class="menu-item" data-keywords="ถุงลมโป่งพอง emphysema emph ทางเดินหายใจ">
                        <div class="menu-left">
                            <div class="menu-no">15</div>
                            <div class="menu-icon"><i class="bi bi-wind"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">ทางเดินหายใจ</div>
                                <div class="menu-title">อัตราป่วยโรคถุงลมโป่งพอง</div>
                                <p class="menu-sub">จำนวนผู้ป่วยเทียบประชากร แยกตามปี อำเภอ และอายุ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div class="group-wrap" data-group="มะเร็ง">
                <div class="group-title"><span class="group-dot"></span>โรคมะเร็ง</div>
                <div class="menu-grid">
                    <a href="{{ route('health.bc-incidence-all') }}" class="menu-item" data-keywords="มะเร็ง เต้านม breast cancer bc">
                        <div class="menu-left">
                            <div class="menu-no">16</div>
                            <div class="menu-icon"><i class="bi bi-gender-female"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">มะเร็ง</div>
                                <div class="menu-title">อัตราป่วยโรคมะเร็งเต้านม</div>
                                <p class="menu-sub">จำนวนผู้ป่วยเทียบประชากร แยกตามปี อำเภอ และอายุ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>

                    <a href="{{ route('health.cc-incidence-all') }}" class="menu-item" data-keywords="มะเร็ง ปากมดลูก cervical cancer cc">
                        <div class="menu-left">
                            <div class="menu-no">17</div>
                            <div class="menu-icon"><i class="bi bi-gender-female"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">มะเร็ง</div>
                                <div class="menu-title">อัตราป่วยโรคมะเร็งปากมดลูก</div>
                                <p class="menu-sub">จำนวนผู้ป่วยเทียบประชากร แยกตามปี อำเภอ และอายุ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>

                    <a href="{{ route('health.lc-incidence-all') }}" class="menu-item" data-keywords="มะเร็ง ปอด lung cancer lc">
                        <div class="menu-left">
                            <div class="menu-no">18</div>
                            <div class="menu-icon"><i class="bi bi-lungs-fill"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">มะเร็ง</div>
                                <div class="menu-title">อัตราป่วยโรคมะเร็งปอด</div>
                                <p class="menu-sub">จำนวนผู้ป่วยเทียบประชากร แยกตามปี อำเภอ และอายุ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div class="group-wrap" data-group="เปรียบเทียบ">
                <div class="group-title"><span class="group-dot"></span>เปรียบเทียบข้อมูล</div>
                <div class="menu-grid">
                    <a href="{{ route('health.cardio_compare') }}" class="menu-item" data-keywords="เปรียบเทียบ ลดลง ปีเก่า ปีใหม่ หัวใจ หลอดเลือด">
                        <div class="menu-left">
                            <div class="menu-no">19</div>
                            <div class="menu-icon"><i class="bi bi-graph-down-arrow"></i></div>
                            <div class="menu-text">
                                <div class="menu-badge">เปรียบเทียบ</div>
                                <div class="menu-title">เปรียบเทียบอัตราป่วยโรคหัวใจและหลอดเลือดรายปี</div>
                                <p class="menu-sub">แสดงข้อมูลเปรียบเทียบปีเก่าและปีใหม่รายอำเภอ</p>
                            </div>
                        </div>
                        <div class="menu-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    const searchInput = document.getElementById('menuSearch');
    const menuItems = document.querySelectorAll('.menu-item');
    const groupWraps = document.querySelectorAll('.group-wrap');
    const quickTags = document.querySelectorAll('.quick-tag');

    function filterMenu() {
        const keyword = (searchInput.value || '').toLowerCase().trim();
        const activeTag = document.querySelector('.quick-tag.active')?.dataset.filter || 'all';

        menuItems.forEach(item => {
            const text = item.innerText.toLowerCase();
            const keywords = (item.dataset.keywords || '').toLowerCase();

            const matchKeyword = !keyword || text.includes(keyword) || keywords.includes(keyword);
            const matchTag = activeTag === 'all' || text.includes(activeTag.toLowerCase()) || keywords.includes(activeTag.toLowerCase());

            item.classList.toggle('hidden', !(matchKeyword && matchTag));
        });

        groupWraps.forEach(group => {
            const visibleItems = group.querySelectorAll('.menu-item:not(.hidden)');
            group.classList.toggle('hidden', visibleItems.length === 0);
        });
    }

    searchInput.addEventListener('input', filterMenu);

    quickTags.forEach(btn => {
        btn.addEventListener('click', function () {
            quickTags.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterMenu();
        });
    });
</script>

</body>
</html>