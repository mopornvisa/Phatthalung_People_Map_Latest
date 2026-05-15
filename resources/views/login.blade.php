<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>เข้าสู่ระบบ | Phatthalung People Map</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Prompt',sans-serif;
    min-height:100vh;
    background:
        linear-gradient(rgba(5,43,40,.62),rgba(5,43,40,.62)),
        url("{{ asset('images/phatthalung1.jpg') }}");
    background-size:cover;
    background-position:center;
}
.login-card{
    width:100%;
    max-width:390px;
    background:rgba(255,255,255,.95);
    border:1px solid rgba(255,255,255,.75);
    border-radius:28px;
    padding:26px 24px;
    box-shadow:0 22px 55px rgba(15,23,42,.24);
    backdrop-filter:blur(14px);
}

.logo-box{
    width:82px;
    height:82px;
    margin:auto;
    border-radius:24px;
    background:linear-gradient(135deg,#e9faf6,#ffffff);
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 10px 24px rgba(11,127,111,.16);
    margin-bottom:14px;
}

.logo-box img{
    width:62px;
    height:62px;
    object-fit:contain;
}

.title{
    color:#0B5B6B;
    font-weight:800;
    font-size:23px;
    margin-bottom:2px;
}

.sub-title{
    color:#64748b;
    font-size:12px;
    margin-bottom:20px;
}

.form-label{
    font-size:12px;
    font-weight:700;
    color:#475569;
    margin-bottom:5px;
}

.form-control{
    height:45px;
    border-radius:14px;
    border:1px solid #d8e8ef;
    font-size:13px;
    background:#fff;
}

.form-control:focus{
    border-color:#0B7F6F;
    box-shadow:0 0 0 .18rem rgba(11,127,111,.13);
}

.btn-login{
    height:46px;
    border-radius:14px;
    border:none;
    background:linear-gradient(135deg,#0B7F6F,#0B5B6B);
    color:#fff;
    font-weight:700;
    font-size:14px;
    box-shadow:0 10px 24px rgba(11,127,111,.20);
}

.btn-login:hover{
    color:#fff;
    transform:translateY(-1px);
}

.soft-link{
    color:#0B5B6B;
    font-weight:700;
    text-decoration:none;
}

.soft-link:hover{
    color:#0B7F6F;
}

.back-link{
    color:#64748b;
    text-decoration:none;
    font-size:12px;
}

.back-link:hover{
    color:#0B7F6F;
}

.eye-btn{
    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    color:#64748b;
    font-size:16px;
}

@media(max-width:576px){

    .login-card{
        padding:22px 18px;
        border-radius:24px;
    }

}

</style>
</head>

<body class="d-flex align-items-center justify-content-center p-3">

<div class="login-card">

    <div class="text-center">
        <div class="logo-box">
            <img src="{{ asset('images/phatthalung-logo.png') }}" alt="logo">
        </div>

        <div class="title">
            เข้าสู่ระบบ
        </div>

        <div class="sub-title">
            Phatthalung People Map • ระบบฐานข้อมูลพัทลุงโมเดล
        </div>
    </div>

    <form method="POST" action="{{ url('/login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">
                <i class="bi bi-person-circle me-1"></i>
                ชื่อผู้ใช้
            </label>

            <input type="text"
                   name="username"
                   value="{{ old('username') }}"
                   class="form-control"
                   placeholder="กรอกชื่อผู้ใช้"
                   required>
        </div>

        <div class="mb-2">
            <label class="form-label">
                <i class="bi bi-lock-fill me-1"></i>
                รหัสผ่าน
            </label>

            <div class="position-relative">
                <input type="password"
                       name="password"
                       id="password"
                       class="form-control pe-5"
                       placeholder="กรอกรหัสผ่าน"
                       required>

                <span onclick="togglePassword()" class="eye-btn">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </span>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label small text-muted" for="remember">
                    จดจำฉันไว้
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-login w-100">
            <i class="bi bi-box-arrow-in-right me-2"></i>
            เข้าสู่ระบบ
        </button>
    </form>

    <div class="text-center mt-4">
        <span class="text-muted small">ยังไม่มีบัญชี?</span>
        <a href="{{ route('register.form') }}" class="soft-link small">
            ลงทะเบียน
        </a>
    </div>

    <div class="text-center mt-3">
        <a href="{{ url('/') }}" class="back-link">
            <i class="bi bi-arrow-left me-1"></i>
            กลับหน้าหลัก
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon:'success',
    title:'สำเร็จ',
    text:'{{ session('success') }}',
    confirmButtonColor:'#0B7F6F',
    confirmButtonText:'ตกลง'
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon:'error',
    title:'เกิดข้อผิดพลาด',
    text:'{{ session('error') }}',
    confirmButtonColor:'#dc3545',
    confirmButtonText:'ตกลง'
});
</script>
@endif

<script>
function togglePassword(){
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if(password.type === 'password'){
        password.type = 'text';
        eyeIcon.classList.remove('bi-eye');
        eyeIcon.classList.add('bi-eye-slash');
    }else{
        password.type = 'password';
        eyeIcon.classList.remove('bi-eye-slash');
        eyeIcon.classList.add('bi-eye');
    }
}
</script>

</body>
</html>