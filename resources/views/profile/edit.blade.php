<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>แก้ไขข้อมูลส่วนตัว</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<style>
body{font-family:'Prompt',sans-serif;background:#f4f7f7;font-size:14px;}
.page-wrap{padding:30px;}
.card-box{max-width:760px;margin:auto;background:#fff;border-radius:18px;border:1px solid #dfe7e6;box-shadow:0 8px 24px rgba(15,23,42,.06);overflow:hidden;}
.card-head{padding:22px 26px;border-bottom:1px solid #e5eceb;}
.card-head h4{font-size:20px;font-weight:700;color:#0B5B6B;margin:0;}
.form-label{font-size:13px;font-weight:600;color:#475569;}
.form-control,.form-select{height:42px;border-radius:10px;font-size:13px;}
.btn-save{background:#0B7F6F;color:white;border-radius:10px;font-weight:600;}
.btn-save:hover{background:#09685C;color:white;}
</style>
</head>

<body>
@include('layouts.topbar')

<div class="page-wrap">
    <div class="card-box">

        <div class="card-head d-flex justify-content-between align-items-center">
            <h4><i class="bi bi-person-lines-fill me-2"></i>แก้ไขข้อมูลส่วนตัว</h4>

            <a href="{{ url('/') }}" class="btn btn-light border rounded-3">
                <i class="bi bi-arrow-left me-1"></i>กลับ
            </a>
        </div>

        <div class="p-4">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf

                <div class="row g-3">
<div class="col-md-4">
    <label class="form-label">ชื่อผู้ใช้</label>

    <input type="text"
           name="username"
           class="form-control"
           value="{{ old('username', $user->register_User) }}"
           required>
</div>
                    <div class="col-md-4">
    <label class="form-label">ชื่อ</label>

    <input type="text"
           name="first_name"
           class="form-control"
           value="{{ old('first_name', $user->register_Name) }}"
           required>
</div>



<div class="col-md-4">
    <label class="form-label">นามสกุล</label>

    <input type="text"
           name="last_name"
           class="form-control"
           value="{{ old('last_name', $user->register_Same) }}"
           required>
</div>

                    <div class="col-md-6">
                        <label class="form-label">อีเมล</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $user->register_Gmail) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">เบอร์โทร</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ old('phone', $user->register_Phone) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">เลขบัตรประชาชน</label>
                        <input type="text" name="citizen_id" maxlength="13" class="form-control"
                               value="{{ old('citizen_id', $user->register_Number) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">ประเภท/หน่วยงาน</label>
                        <select name="agency_id" class="form-select" required>
                            @foreach([
                                'บุคคลทั่วไป',
                                'องค์การบริหารส่วนจังหวัดพัทลุง',
                                'สำนักงานสาธารณสุขจังหวัดพัทลุง',
                                'มหาวิทยาลัยทักษิณ',
                                'หน่วยงานภาครัฐอื่น ๆ'
                            ] as $agency)
                                <option value="{{ $agency }}"
                                    {{ old('agency_id', $user->register_Agency) == $agency ? 'selected' : '' }}>
                                    {{ $agency }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
<hr class="my-4">

<div class="d-flex justify-content-between align-items-center
            p-3 rounded-4 mb-3"
     style="background:#f8fafc;border:1px solid #e2e8f0;">

    <div>

        <div class="fw-bold text-dark">
            <i class="bi bi-key-fill text-primary me-1"></i>
            เปลี่ยนรหัสผ่าน
        </div>

        <div style="font-size:12px;color:#64748b;">
            กดเพื่อเปลี่ยนรหัสผ่านบัญชีผู้ใช้
        </div>

    </div>

    <button type="button"
            class="btn btn-outline-primary rounded-pill px-3"
            onclick="togglePasswordBox()">

        <i class="bi bi-pencil-square me-1"></i>
        เปลี่ยนรหัสผ่าน

    </button>

</div>

<div id="passwordBox" style="display:none;">

    <div class="row g-3">

        <div class="col-md-4">

            <label class="form-label">
                รหัสผ่านปัจจุบัน
            </label>

            <input type="password"
                   name="current_password"
                   class="form-control"
                   placeholder="รหัสผ่านเดิม">

        </div>

        <div class="col-md-4">

            <label class="form-label">
                รหัสผ่านใหม่
            </label>

            <input type="password"
                   name="new_password"
                   class="form-control"
                   placeholder="อย่างน้อย 8 ตัวอักษร">

        </div>

        <div class="col-md-4">

            <label class="form-label">
                ยืนยันรหัสผ่านใหม่
            </label>

            <input type="password"
                   name="new_password_confirmation"
                   class="form-control">

        </div>

    </div>

</div>
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ url('/') }}" class="btn btn-light border px-4">ยกเลิก</a>

                    <button type="submit" class="btn btn-save px-4">
                        <i class="bi bi-save me-1"></i>บันทึก
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
@if($errors->any())
<script>
Swal.fire({
    icon:'warning',
    title:'ข้อมูลไม่ถูกต้อง',
    html:`{!! implode('<br>', $errors->all()) !!}`,
    confirmButtonColor:'#0B7F6F'
});
</script>
@endif
@if(session('success'))
<script>
Swal.fire({
    icon:'success',
    title:'สำเร็จ',
    text:'{{ session('success') }}',
    confirmButtonColor:'#0B7F6F'
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon:'error',
    title:'เกิดข้อผิดพลาด',
    text:'{{ session('error') }}',
    confirmButtonColor:'#dc3545'
});
</script>
@endif

<script>
function togglePasswordBox(){

    const box = document.getElementById('passwordBox');

    if(box.style.display === 'none'){
        box.style.display = 'block';
    }else{
        box.style.display = 'none';
    }

}
</script>

</body>
</html>