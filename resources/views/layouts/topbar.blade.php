{{-- resources/views/layouts/topbar.blade.php --}}
@php
  $teal  = $teal  ?? '#0B7F6F';
  $teal2 = $teal2 ?? '#0B5B6B';

  $homeUrl      = Route::has('home') ? route('home') : url('/');
  $dashboardUrl = Route::has('dashboard') ? route('dashboard') : url('/');
  $householdUrl = Route::has('household_64') ? route('household_64') : null;
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&display=swap');

body{
    font-family:'Prompt',sans-serif;
}

/* ===============================
   TOPBAR STYLE
=============================== */

.top-header{
    background:rgba(255,255,255,.82);
    backdrop-filter:blur(16px);
    border-bottom:1px solid rgba(11,127,111,.08);
    box-shadow:0 10px 24px rgba(15,23,42,.05);
}

.top-header .navbar-brand{
    gap:12px;
}

.logo{
    width:42px;
    height:42px;
    border-radius:14px;
    object-fit:cover;
    border:1px solid #dfe9e6;
}

.brand-title{
    font-weight:800;
    font-size:1.05rem;
    color:#0B5B6B;
    line-height:1.2;
}

.brand-sub{
    font-size:.74rem;
    color:#64748b;
}

.top-header .navbar-nav{
    gap:8px;
}

.top-header .nav-link{
    color:#27404a !important;
    font-size:.92rem;
    font-weight:600;
    padding:12px 16px !important;
    border-radius:14px;
    transition:.22s ease;
}

.top-header .nav-link:hover{
    background:#e9f8f2;
    color:#0B7F6F !important;
}

.top-header .nav-link.active{
    background:linear-gradient(135deg,#0B7F6F,#0A6D61);
    color:#fff !important;
    box-shadow:0 10px 18px rgba(11,127,111,.18);
}

.top-header .dropdown-menu{
    border:none;
    border-radius:18px;
    padding:10px;
    min-width:240px;
    box-shadow:0 18px 34px rgba(15,23,42,.10);
}

.top-header .dropdown-item{
    border-radius:12px;
    padding:11px 14px;
    font-size:.92rem;
    transition:.18s ease;
}

.top-header .dropdown-item:hover{
    background:#eefaf6;
    color:#0B7F6F;
    transform:translateX(4px);
}

.navbar-toggler{
    border:none !important;
    box-shadow:none !important;
}

@media(max-width:991.98px){

.top-header .nav-link{
    padding:11px 14px !important;
}

}
.dropdown-submenu .submenu{
    display:none;
    position:absolute;
    top:0;
    left:100%;
    margin-left:4px;
    min-width:220px;
    border:none;
    border-radius:16px;
    padding:8px;
}

.dropdown-submenu:hover > .submenu{
    display:block;
}
</style>

{{-- HEADER --}}
<nav class="navbar navbar-expand-lg sticky-top top-header" style="z-index:1030;">
<div class="container-fluid px-3 px-lg-4">

<a class="navbar-brand d-flex align-items-center" href="{{ $homeUrl }}">
    <img src="{{ asset('images/phatthalung-logo.png') }}" class="logo">

    <div>
        <div class="brand-title">Phatthalung People Map</div>
        <div class="brand-sub">ระบบฐานข้อมูลพัทลุงโมเดล</div>
    </div>
</a>

<button class="navbar-toggler ms-auto"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#mainNav">
    <i class="bi bi-list fs-2 text-success"></i>
</button>

<div class="collapse navbar-collapse" id="mainNav">

<ul class="navbar-nav ms-auto align-items-lg-center">

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
href="{{ $homeUrl }}">
<i class="bi bi-house-fill me-1"></i>
หน้าหลัก
</a>
</li>

<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle"
href="#"
data-bs-toggle="dropdown">
<i class="bi bi-bullseye me-1"></i>
ภารกิจ / ยุทธศาสตร์
</a>

<ul class="dropdown-menu dropdown-menu-end">

    <!-- เมืองคนคุณภาพชีวิตที่ดี -->
    <li class="dropdown-submenu position-relative">
        <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">
            <span>
                <i class="bi bi-stars me-2"></i>
                เมืองคนคุณภาพชีวิตที่ดี
            </span>
            <i class="bi bi-chevron-right small"></i>
        </a>

        <!-- เมนูย่อย ต้องมีแค่ UL เดียว -->
        <ul class="dropdown-menu submenu shadow">

            <li>
                <a class="dropdown-item" href="{{ route('health_status') }}">
                    <i class="bi bi-heart-pulse-fill me-2"></i>
                    ด้านสุขภาพ
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="{{ route('welfare.index') }}">
                    <i class="bi bi-shield-check me-2"></i>
                    ด้านสวัสดิการ
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="{{ route('dashboard') }}">
    <i class="bi bi-house-heart-fill me-2"></i>
    ด้านที่อยู่อาศัย
</a>
            </li>

        </ul>
    </li>

    <!-- เมนูหลักอื่น -->
    <li>
        <a class="dropdown-item" href="{{ $dashboardUrl }}">
            <i class="bi bi-graph-up-arrow me-2"></i>
            เมืองเศรษฐกิจยั่งยืน
        </a>
    </li>

    <li>
        <a class="dropdown-item" href="{{ $dashboardUrl }}">
            <i class="bi bi-tree-fill me-2"></i>
            เมืองสิ่งแวดล้อมยั่งยืน
        </a>
    </li>

    <li>
        <a class="dropdown-item" href="{{ route('welfare.index') }}">
            <i class="bi bi-people-fill me-2"></i>
            เมืองของพลเมือง
        </a>
    </li>

</ul>
</li>

<li class="nav-item">
<a class="nav-link" href="{{ $dashboardUrl }}">
<i class="bi bi-bar-chart-fill me-1"></i>
ข้อมูลภาพรวม
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="{{ route('health_status') }}">
<i class="bi bi-heart-pulse-fill me-1"></i>
ข้อมูลสุขภาพ
</a>
</li>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('welfare.index') ? 'active' : '' }}"
href="{{ route('welfare.index') }}">
<i class="bi bi-gift-fill me-1"></i>
สวัสดิการ
</a>
</li>

@if($householdUrl)
<li class="nav-item">
<a class="nav-link" href="{{ $householdUrl }}">
<i class="bi bi-people-fill me-1"></i>
ครัวเรือน
</a>
</li>
@endif

@if(session('user_firstname'))

<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle"
href="#"
data-bs-toggle="dropdown">
<i class="bi bi-person-circle me-1"></i>
{{ session('user_firstname') }}
</a>

<ul class="dropdown-menu dropdown-menu-end">
<li>
<a class="dropdown-item text-danger" href="{{ url('/logout') }}">
<i class="bi bi-box-arrow-right me-2"></i>
ออกจากระบบ
</a>
</li>
</ul>
</li>

@else

<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle"
href="#"
data-bs-toggle="dropdown">
<i class="bi bi-person-circle me-1"></i>
บัญชีผู้ใช้
</a>

<ul class="dropdown-menu dropdown-menu-end">
<li>
<a class="dropdown-item" href="{{ url('/login') }}">
<i class="bi bi-box-arrow-in-right me-2"></i>
เข้าสู่ระบบ
</a>
</li>

<li>
<a class="dropdown-item" href="{{ url('/register') }}">
<i class="bi bi-person-plus me-2"></i>
ลงทะเบียน
</a>
</li>
</ul>
</li>

@endif

</ul>
</div>
</div>
</nav>