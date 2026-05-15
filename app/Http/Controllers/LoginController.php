<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Hash;
use App\Models\SystemLog;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ]);

        $user = Register::where('register_User', $request->username)->first();

        if (!$user) {
            return back()
                ->withInput()
                ->with('error', 'ไม่พบบัญชีผู้ใช้งาน');
        }

        if (!Hash::check($request->password, $user->register_Password)) {
            return back()
                ->withInput()
                ->with('error', 'รหัสผ่านไม่ถูกต้อง');
        }

        if ($user->register_Status !== 'อนุมัติแล้ว') {
            return back()
                ->withInput()
                ->with('error', 'บัญชีของคุณอยู่ระหว่างรอผู้ดูแลระบบอนุมัติ');
        }

      session([
    'user_id'        => $user->id,
    'username'       => $user->register_User,
    'user_role'      => $user->register_Type,
    'user_firstname' => $user->register_Name,
    'user_lastname'  => $user->register_Same,
    'user_agency'    => $user->register_Agency,

    // ของเดิม เก็บไว้กันหน้าอื่นพัง
    'login_user'     => $user->register_User,
    'login_type'     => $user->register_Type,
]);
SystemLog::create([
    'user_id'    => $user->id,
    'username'   => $user->register_User,
    'role'       => $user->register_Type,
    'agency'     => $user->register_Agency,
    'action'     => 'เข้าสู่ระบบ',
    'detail'     => 'เข้าสู่ระบบสำเร็จ',
    'ip_address' => $request->ip(),
    'user_agent' => $request->userAgent(),
]);
        return redirect('/');
    }

   public function logout(Request $request)
{
    SystemLog::create([
    'user_id'    => session('user_id'),
    'username'   => session('username') ?? session('login_user'),
    'role'       => session('user_role') ?? session('login_type'),
    'agency'     => session('user_agency'),
    'action'     => 'ออกจากระบบ',
    'detail'     => 'ผู้ใช้ออกจากระบบ',
    'ip_address' => $request->ip(),
    'user_agent' => $request->userAgent(),
]);
    $request->session()->flush();

    return redirect('/')
        ->with('success', 'ออกจากระบบเรียบร้อยแล้ว');
}

}