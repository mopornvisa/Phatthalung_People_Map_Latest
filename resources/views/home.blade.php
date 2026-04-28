{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Phatthalung People Map</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root{ --teal:#0B7F6F; --teal2:#0B5B6B; --muted:#64748b; --shadow2:0 28px 60px rgba(11,91,107,.15); }
    *{ box-sizing:border-box; }
    body{
      font-family:'Prompt',system-ui,sans-serif;
      color:#0f172a;
      background:radial-gradient(circle at 10% 0%,rgba(255,255,255,.92),transparent 28%),
                 radial-gradient(circle at 95% 12%,rgba(207,239,243,.85),transparent 30%),
                 linear-gradient(135deg,#CFEFF3 0%,#DFF7EF 52%,#F0F8FB 100%);
      overflow-x:hidden;
    }
    a{ text-decoration:none; }
    .page-wrap{ padding:22px 18px 0; }

    .hero-arch{
      border-radius:36px; overflow:hidden; position:relative; min-height:560px;
      box-shadow:var(--shadow2); background:#0B5B6B; border:1px solid rgba(255,255,255,.7);
    }
    .hero-arch::before{
      content:""; position:absolute; inset:0;
      background:linear-gradient(120deg,rgba(6,47,43,.86),rgba(11,127,111,.58),rgba(255,255,255,.06)),
                 url("{{ asset('images/phatthalung1.jpg') }}");
      background-size:cover; background-position:center; transform:scale(1.02); z-index:0;
      animation:slowZoom 14s ease-in-out infinite alternate;
    }
    .hero-arch::after{
      content:""; position:absolute; inset:0;
      background-image:linear-gradient(rgba(255,255,255,.065) 1px, transparent 1px),
                       linear-gradient(90deg,rgba(255,255,255,.065) 1px, transparent 1px);
      background-size:42px 42px; opacity:.42; z-index:1;
    }
    .hero-content{ position:relative; z-index:2; padding:68px 56px; color:#fff; }
    .hero-chip{
      display:inline-flex; align-items:center; gap:8px; padding:8px 16px; border-radius:999px;
      background:rgba(255,255,255,.18); border:1px solid rgba(255,255,255,.22);
      backdrop-filter:blur(10px); font-weight:700; margin-bottom:20px; animation:floatSoft 4.5s ease-in-out infinite;
    }
    .hero-title{
      font-size:clamp(2.35rem,5vw,4.25rem); font-weight:800; letter-spacing:-.04em;
      line-height:1.16; margin-bottom:16px; text-shadow:0 5px 18px rgba(0,0,0,.22); max-width:900px;
    }
    .hero-desc{ max-width:780px; font-size:1.1rem; line-height:1.9; opacity:.95; margin-bottom:28px; }
    .hero-actions{ display:flex; gap:12px; flex-wrap:wrap; }
    .btn-main,.btn-glass{
      display:inline-flex; align-items:center; gap:10px; padding:13px 24px; border-radius:18px;
      font-weight:800; transition:.22s ease; position:relative; overflow:hidden;
    }
    .btn-main{ background:#fff; color:var(--teal2); box-shadow:0 14px 30px rgba(0,0,0,.16); }
    .btn-main:hover{ transform:translateY(-2px); color:var(--teal); }
    .btn-glass{ background:rgba(255,255,255,.16); color:#fff; border:1px solid rgba(255,255,255,.25); backdrop-filter:blur(10px); }
    .btn-glass:hover{ transform:translateY(-2px); color:#fff; background:rgba(255,255,255,.22); }
    .btn-main::after,.btn-glass::after{
      content:""; position:absolute; top:-60%; left:-40%; width:45%; height:220%;
      background:linear-gradient(90deg,transparent,rgba(255,255,255,.45),transparent);
      transform:rotate(12deg); animation:shineMove 4s ease-in-out infinite; pointer-events:none;
    }
    .hero-logo-float{
      position:absolute; right:54px; bottom:42px; width:142px; height:142px; border-radius:34px;
      background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.25);
      backdrop-filter:blur(12px); padding:18px; z-index:3; box-shadow:0 20px 40px rgba(0,0,0,.16);
      animation:floatSoft 5s ease-in-out infinite, pulseGlow 4s ease-in-out infinite;
    }
    .hero-logo-float img{ width:100%; height:100%; object-fit:contain; }
    .hero-badges{ display:flex; flex-wrap:wrap; gap:10px; margin-top:26px; }
    .mini-badge{
      display:inline-flex; align-items:center; gap:8px; padding:8px 14px; border-radius:999px;
      background:rgba(255,255,255,.13); border:1px solid rgba(255,255,255,.18);
      backdrop-filter:blur(10px); color:#fff; font-weight:600; font-size:.92rem;
    }

    .section-space{ padding:68px 0 28px; }
    .section-heading{ text-align:center; margin-bottom:36px; }
    .section-kicker{
      display:inline-flex; align-items:center; gap:8px; background:rgba(11,127,111,.08); color:var(--teal);
      border:1px solid rgba(11,127,111,.10); padding:7px 14px; border-radius:999px;
      font-size:.88rem; font-weight:800; margin-bottom:10px; animation:floatSoft 4.5s ease-in-out infinite;
    }
    .section-heading h2{ color:var(--teal2); font-size:clamp(2rem,4vw,3rem); font-weight:800; letter-spacing:-.03em; margin-bottom:8px; }
    .section-heading p{ color:var(--muted); font-size:1.05rem; margin:0; }
    .strategy-card{
      height:100%; display:block; border-radius:28px; padding:28px 22px; background:rgba(255,255,255,.82);
      border:1px solid rgba(255,255,255,.78); box-shadow:0 14px 32px rgba(2,6,23,.07);
      backdrop-filter:blur(14px); transition:.28s ease; color:inherit; overflow:hidden; position:relative; animation:fadeUp .75s ease both;
    }
    .strategy-card::before{ content:""; position:absolute; inset:0; background:radial-gradient(circle at top right,var(--soft),transparent 36%); pointer-events:none; }
    .strategy-card:hover{ transform:translateY(-8px); box-shadow:0 26px 48px rgba(11,127,111,.15); }
    .strategy-inner{ position:relative; z-index:1; }
    .strategy-icon{
      width:76px; height:76px; border-radius:24px; display:flex; align-items:center; justify-content:center;
      color:#fff; font-size:1.9rem; margin-bottom:16px; box-shadow:0 14px 28px rgba(2,6,23,.14); transition:.25s ease;
    }
    .strategy-card:hover .strategy-icon{ transform:scale(1.08) rotate(-5deg); }
    .strategy-tag{ display:inline-flex; padding:6px 12px; border-radius:999px; font-size:.76rem; font-weight:800; background:var(--soft); color:var(--main); margin-bottom:10px; }
    .strategy-card h5{ color:var(--teal2); font-weight:800; font-size:1.12rem; line-height:1.45; margin-bottom:10px; }
    .strategy-card p{ color:var(--muted); line-height:1.78; font-size:.94rem; margin-bottom:18px; }
    .strategy-link{ display:flex; justify-content:space-between; align-items:center; padding-top:14px; border-top:1px solid rgba(15,23,42,.06); color:var(--main); font-weight:800; font-size:.9rem; }
    .strategy-link i{ animation:arrowNudge 1.4s ease-in-out infinite; }

    .info-strip{ padding:28px 0 74px; }
    .info-panel{
      border-radius:32px; background:linear-gradient(135deg,#0B5B6B,#0B7F6F); color:#fff;
      padding:30px; box-shadow:0 22px 44px rgba(11,127,111,.22); overflow:hidden; position:relative;
    }
    .info-panel::after{ content:""; position:absolute; width:240px; height:240px; border-radius:50%; background:rgba(255,255,255,.10); right:-80px; top:-90px; }
    .info-item{ position:relative; z-index:1; text-align:center; padding:20px 12px; border-right:1px solid rgba(255,255,255,.16); }
    .info-item:last-child{border-right:0}
    .info-number{ font-size:2.35rem; font-weight:800; line-height:1; }
    .info-label{ margin-top:8px; opacity:.86; }

    .site-footer{
      background:rgba(255,255,255,.82); border-top:1px solid rgba(11,127,111,.10);
      box-shadow:0 -12px 30px rgba(2,6,23,.04); padding:34px 0; color:#475569; position:relative; overflow:hidden;
    }
    .site-footer::before{ content:""; position:absolute; width:240px; height:240px; border-radius:50%; background:rgba(11,127,111,.08); right:-70px; top:-90px; }
    .footer-logo{ width:62px; height:62px; border-radius:18px; background:rgba(11,127,111,.10); padding:8px; overflow:hidden; flex-shrink:0; }
    .footer-logo img{ width:100%; height:100%; object-fit:contain; }
    .footer-title{ color:var(--teal2); font-weight:800; margin-bottom:2px; }

    @keyframes floatSoft{ 0%,100%{ transform:translateY(0); } 50%{ transform:translateY(-10px); } }
    @keyframes pulseGlow{ 0%,100%{ box-shadow:0 20px 40px rgba(0,0,0,.16); } 50%{ box-shadow:0 20px 40px rgba(0,0,0,.16),0 0 34px rgba(255,255,255,.28); } }
    @keyframes shineMove{ 0%{ transform:translateX(-120%) rotate(12deg); } 100%{ transform:translateX(140%) rotate(12deg); } }
    @keyframes fadeUp{ from{ opacity:0; transform:translateY(18px); } to{ opacity:1; transform:translateY(0); } }
    @keyframes slowZoom{ from{ transform:scale(1.02); filter:saturate(1); } to{ transform:scale(1.08); filter:saturate(1.12); } }
    @keyframes arrowNudge{ 0%,100%{ transform:translateX(0); } 50%{ transform:translateX(5px); } }

    @media(max-width:991.98px){
      .page-wrap{padding:12px 10px 0}
      .hero-content{padding:44px 24px}
      .hero-logo-float{ position:relative; right:auto; bottom:auto; margin:0 0 26px; }
      .hero-arch{min-height:auto}
      .info-item{ border-right:0; border-bottom:1px solid rgba(255,255,255,.16); }
      .info-item:last-child{border-bottom:0}
    }
    @media (prefers-reduced-motion: reduce){ *,*::before,*::after{ animation:none!important; transition:none!important; } }
  </style>
</head>

<body>

@include('layouts.topbar')

<div class="page-wrap">
  <section class="hero-arch">
    <div class="hero-content">
      <div class="hero-logo-float">
        <img src="{{ asset('images/phatthalung-logo.png') }}" alt="Phatthalung Logo">
      </div>

      <div class="hero-chip">
        <i class="bi bi-stars"></i>
        Phatthalung People Map
      </div>

      <h1 class="hero-title">
        ระบบฐานข้อมูลพัทลุงโมเดล<br>
    
      </h1>

      <p class="hero-desc">
        เชื่อมโยงข้อมูลครัวเรือน ข้อมูลสุขภาพ ข้อมูลสวัสดิการ และข้อมูลเชิงพื้นที่
        เพื่อสนับสนุนการลดความยากจนและยกระดับคุณภาพชีวิตประชาชนจังหวัดพัทลุง
      </p>

      <div class="hero-actions">
        <a href="{{ route('home') }}" class="btn-main">
          <i class="bi bi-speedometer2"></i>
          หน้าหลัก
        </a>

        <a href="#strategies" class="btn-glass">
          <i class="bi bi-grid-3x3-gap-fill"></i>
          ดู 4 ยุทธศาสตร์
        </a>
      </div>

      <div class="hero-badges">
        <span class="mini-badge"><i class="bi bi-database-check"></i> Data Integration</span>
        <span class="mini-badge"><i class="bi bi-heart-pulse"></i> Health & Welfare</span>
        <span class="mini-badge"><i class="bi bi-graph-up-arrow"></i> Decision Support</span>
      </div>
    </div>
  </section>
</div>

<section class="section-space" id="strategies">
  <div class="container">
    <div class="section-heading">
      <div class="section-kicker">
        <i class="bi bi-compass-fill"></i>
        4 ยุทธศาสตร์หลัก
      </div>
      <h2>พัทลุงมหานครแห่งความสุข</h2>
      <p>เชื่อมโยงข้อมูลเพื่อขับเคลื่อนการพัฒนาคุณภาพชีวิตของประชาชน</p>
    </div>

    <div class="row g-4">
      <div class="col-md-6 col-xl-3">
        <a href="{{ route('health_status') }}" class="strategy-card" style="--main:#dc6b6b;--soft:rgba(220,107,107,.12);">
          <div class="strategy-inner">
            <div class="strategy-icon" style="background:linear-gradient(135deg,#dc6b6b,#b64d4d);"><i class="bi bi-heart-pulse-fill"></i></div>
            <div class="strategy-tag">ยุทธศาสตร์ที่ 1</div>
            <h5>เมืองคนคุณภาพชีวิตที่ดี</h5>
            <p>สุขภาพ บ้านสุขภาวะ สวัสดิการ ความปลอดภัย และคุณภาพชีวิตทุกช่วงวัย</p>
            <div class="strategy-link"><span>ดูข้อมูลสุขภาพ</span><i class="bi bi-arrow-right"></i></div>
          </div>
        </a>
      </div>

      <div class="col-md-6 col-xl-3">
        <a href="{{ route('dashboard') }}" class="strategy-card" style="--main:#c58a42;--soft:rgba(197,138,66,.13);">
          <div class="strategy-inner">
            <div class="strategy-icon" style="background:linear-gradient(135deg,#d8a15f,#b77935);"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="strategy-tag">ยุทธศาสตร์ที่ 2</div>
            <h5>เมืองเศรษฐกิจยั่งยืน</h5>
            <p>เศรษฐกิจเกื้อกูล สินค้าและบริการสร้างสรรค์จากฐานภูมิปัญญาและทรัพยากรพื้นที่</p>
            <div class="strategy-link"><span>ดูข้อมูลภาพรวม</span><i class="bi bi-arrow-right"></i></div>
          </div>
        </a>
      </div>

      <div class="col-md-6 col-xl-3">
        <a href="{{ route('dashboard') }}" class="strategy-card" style="--main:#29967f;--soft:rgba(41,150,127,.12);">
          <div class="strategy-inner">
            <div class="strategy-icon" style="background:linear-gradient(135deg,#35b79c,#227967);"><i class="bi bi-tree-fill"></i></div>
            <div class="strategy-tag">ยุทธศาสตร์ที่ 3</div>
            <h5>เมืองสิ่งแวดล้อมยั่งยืน</h5>
            <p>คนอยู่ได้ ป่าอยู่ดี จัดการน้ำ อาหารใกล้บ้าน อาหารเป็นยา และสิ่งแวดล้อมสมดุล</p>
            <div class="strategy-link"><span>ดูข้อมูลพื้นที่</span><i class="bi bi-arrow-right"></i></div>
          </div>
        </a>
      </div>

      <div class="col-md-6 col-xl-3">
        <a href="{{ route('welfare.index') }}" class="strategy-card" style="--main:#8b5aa5;--soft:rgba(139,90,165,.12);">
          <div class="strategy-inner">
            <div class="strategy-icon" style="background:linear-gradient(135deg,#a56ac4,#70428a);"><i class="bi bi-people-fill"></i></div>
            <div class="strategy-tag">ยุทธศาสตร์ที่ 4</div>
            <h5>เมืองของพลเมือง</h5>
            <p>พลเมืองเข้มแข็ง การศึกษา วัฒนธรรม ทุนปัญญา และการมีส่วนร่วมของชุมชน</p>
            <div class="strategy-link"><span>ดูข้อมูลสวัสดิการ</span><i class="bi bi-arrow-right"></i></div>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>



<footer class="site-footer">
  <div class="container">
    <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
      <div class="d-flex align-items-center gap-3">
        <div class="footer-logo">
          <img src="{{ asset('images/phatthalung-logo.png') }}" alt="logo">
        </div>
        <div>
          <div class="footer-title">Phatthalung People Map</div>
          <div>ระบบฐานข้อมูลพัทลุงโมเดลและเครื่องมือสนับสนุนการตัดสินใจเพื่อการพัฒนาจังหวัดพัทลุง</div>
        </div>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
