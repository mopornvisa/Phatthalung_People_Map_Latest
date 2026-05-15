<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>ลงทะเบียน | Phatthalung People Map</title>

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

.register-card{
    width:100%;
    max-width:620px;
    background:rgba(255,255,255,.95);
    border:1px solid rgba(255,255,255,.75);
    border-radius:30px;
    padding:24px;
    box-shadow:0 22px 55px rgba(15,23,42,.24);
    backdrop-filter:blur(14px);
}

.logo-box{
    width:82px;
    height:82px;
    margin:auto;
    border-radius:24px;
    background:linear-gradient(135deg,#ecfffb,#ffffff);
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

.main-title{
    color:#0B5B6B;
    font-size:22px;
    font-weight:800;
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

.form-control,
.form-select{
    height:44px;
    border-radius:14px;
    border:1px solid #d8e8ef;
    font-size:13px;
    background:#fff;
}

.btn-register{
    height:46px;
    border:none;
    border-radius:14px;
    background:linear-gradient(135deg,#0B7F6F,#0B5B6B);
    color:#fff;
    font-weight:700;
    font-size:14px;
    box-shadow:0 10px 24px rgba(11,127,111,.20);
}

.btn-register:hover{
    color:#fff;
    transform:translateY(-1px);
}

.eye-btn{
    position:absolute;
    right:17px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    color:#64748b;
    font-size:18px;
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
    font-size:13px;
}

.back-link:hover{
    color:#0B7F6F;
}

@media(max-width:768px){

    .register-card{
        padding:28px 22px;
        border-radius:28px;
    }

}
</style>
</head>

<body class="d-flex align-items-center justify-content-center p-3">

<div class="register-card">

    <div class="text-center">

        <div class="logo-box">
            <img src="{{ asset('images/phatthalung-logo.png') }}">
        </div>

        <div class="main-title">
            ลงทะเบียนผู้ใช้งาน
        </div>

        <div class="sub-title">
            Phatthalung People Map • ระบบฐานข้อมูลพัทลุงโมเดล
        </div>

    </div>

    <form method="POST" action="{{ url('/register') }}">
        @csrf

        <div class="row g-3">

            <div class="col-md-6">
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

            <div class="col-md-6">
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

            <div class="col-md-6">
                <label class="form-label">
                    <i class="bi bi-person-fill me-1"></i>
                    ชื่อ
                </label>

                <input type="text"
                       name="first_name"
                       value="{{ old('first_name') }}"
                       class="form-control"
                       placeholder="ชื่อ"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    <i class="bi bi-person-vcard-fill me-1"></i>
                    นามสกุล
                </label>

                <input type="text"
                       name="last_name"
                       value="{{ old('last_name') }}"
                       class="form-control"
                       placeholder="นามสกุล"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    <i class="bi bi-credit-card-2-front-fill me-1"></i>
                    เลขบัตรประชาชน
                </label>

                <input type="text"
                       name="citizen_id"
                       value="{{ old('citizen_id') }}"
                       maxlength="13"
                       class="form-control"
                       placeholder="เลขบัตรประชาชน 13 หลัก"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    <i class="bi bi-telephone-fill me-1"></i>
                    เบอร์โทรศัพท์
                </label>

                <input type="tel"
                       name="phone"
                       value="{{ old('phone') }}"
                       class="form-control"
                       placeholder="0812345678"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    <i class="bi bi-envelope-fill me-1"></i>
                    อีเมล
                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="form-control"
                       placeholder="example@email.com"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    <i class="bi bi-buildings-fill me-1"></i>
                    หน่วยงาน / ประเภทผู้ใช้
                </label>

                <select name="agency_id" class="form-select" required>

                    <option value="">
                        -- เลือกประเภท/หน่วยงาน --
                    </option>

                    <option value="บุคคลทั่วไป">บุคคลทั่วไป</option>

                    <option value="องค์การบริหารส่วนจังหวัดพัทลุง">
                        องค์การบริหารส่วนจังหวัดพัทลุง
                    </option>

                    <option value="สำนักงานสาธารณสุขจังหวัดพัทลุง">
                        สำนักงานสาธารณสุขจังหวัดพัทลุง
                    </option>

                    <option value="มหาวิทยาลัยทักษิณ">
                        มหาวิทยาลัยทักษิณ
                    </option>

                    <option value="หน่วยงานภาครัฐอื่น ๆ">
                        หน่วยงานภาครัฐอื่น ๆ
                    </option>

                    <option value="ดูแลระบบ">
                        ดูแลระบบ
                    </option>

                </select>
            </div>

        </div>

        <button type="submit" class="btn btn-register w-100 mt-4">
            <i class="bi bi-person-plus-fill me-2"></i>
            ลงทะเบียนเข้าใช้งานระบบ
        </button>

    </form>

    <div class="text-center mt-4">
        <span class="text-muted small">มีบัญชีอยู่แล้ว?</span>

        <a href="{{ route('login.form') }}" class="soft-link small">
            เข้าสู่ระบบ
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

@if($errors->any())
<script>
Swal.fire({
    icon:'warning',
    title:'ข้อมูลไม่ถูกต้อง',
    html:`{!! implode('<br>', $errors->all()) !!}`,
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