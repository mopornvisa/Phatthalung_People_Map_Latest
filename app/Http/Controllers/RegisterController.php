<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username'   => 'required|max:50|unique:mysql_help.registers,register_User',
            'password'   => 'required|min:6|max:50',
            'first_name' => 'required|max:30',
            'last_name'  => 'required|max:50',
            'citizen_id' => 'required|digits:13|unique:mysql_help.registers,register_Number',
            'phone'      => 'required|max:10',
            'email'      => 'required|email|max:50|unique:mysql_help.registers,register_Gmail',
            'agency_id'  => 'required',
        ], [

            'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            'username.unique'   => 'ชื่อผู้ใช้นี้ถูกใช้งานแล้ว',

            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min'      => 'รหัสผ่านอย่างน้อย 6 ตัวอักษร',

            'first_name.required' => 'กรุณากรอกชื่อ',
            'last_name.required'  => 'กรุณากรอกนามสกุล',

            'citizen_id.required' => 'กรุณากรอกเลขบัตรประชาชน',
            'citizen_id.digits'   => 'เลขบัตรประชาชนต้องมี 13 หลัก',
            'citizen_id.unique'   => 'เลขบัตรประชาชนนี้ถูกใช้งานแล้ว',

            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์',

            'email.required' => 'กรุณากรอกอีเมล',
            'email.email'    => 'รูปแบบอีเมลไม่ถูกต้อง',
            'email.unique'   => 'อีเมลนี้ถูกใช้งานแล้ว',

            'agency_id.required' => 'กรุณาเลือกประเภทผู้ใช้',
        ]);

        try {

            Register::create([

                'register_User'     => $request->username,

                // hash password
                'register_Password' => Hash::make($request->password),

                'register_Name'     => $request->first_name,
                'register_Same'     => $request->last_name,

                'register_Number'   => $request->citizen_id,
                'register_Phone'    => $request->phone,
                'register_Gmail'    => $request->email,

                // role
                'register_Type' => $request->agency_id === 'ดูแลระบบ' ? 'admin' : 'user',

                // agency
                'register_Agency'   => $request->agency_id,

                // เพิ่มตรงนี้
                'register_Status'   => 'รออนุมัติ',
            ]);

            return redirect('/login')
                ->with('success', 'ลงทะเบียนเรียบร้อย กรุณารอผู้ดูแลระบบอนุมัติ');

        } catch (\Exception $e) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'เกิดข้อผิดพลาด : ' . $e->getMessage());
        }
    }
}