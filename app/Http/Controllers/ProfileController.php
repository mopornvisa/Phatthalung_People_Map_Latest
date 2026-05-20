<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Register::find(session('user_id'));

        if (!$user) {
            return redirect('/login')->with('error', 'กรุณาเข้าสู่ระบบก่อน');
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Register::find(session('user_id'));

        if (!$user) {
            return redirect('/login')->with('error', 'กรุณาเข้าสู่ระบบก่อน');
        }

        $changePassword =
            $request->filled('current_password') ||
            $request->filled('new_password') ||
            $request->filled('new_password_confirmation');

        if ($changePassword) {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);

            if (!Hash::check($request->current_password, $user->register_Password)) {
                return back()
                    ->withInput()
                    ->with('error', 'รหัสผ่านปัจจุบันไม่ถูกต้อง กรุณาใส่ใหม่');
            }
        }

        $request->validate([
            'username'   => 'required|unique:mysql_help.registers,register_User,' . $user->id . ',id',
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email',
            'phone'      => 'nullable',
            'citizen_id' => 'nullable|max:13',
            'agency_id'  => 'required',
        ], [
            'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            'username.unique'   => 'ชื่อผู้ใช้นี้ถูกใช้งานแล้ว',
        ]);

        $user->register_User   = $request->username;
        $user->register_Name   = $request->first_name;
        $user->register_Same   = $request->last_name;
        $user->register_Gmail  = $request->email;
        $user->register_Phone  = $request->phone;
        $user->register_Number = $request->citizen_id;
        $user->register_Agency = $request->agency_id;

        if ($changePassword) {
            $user->register_Password = Hash::make($request->new_password);
        }

        $user->save();

        session([
            'username'       => $user->register_User,
            'login_user'     => $user->register_User,
            'user_firstname' => $user->register_Name,
            'user_lastname'  => $user->register_Same,
            'user_agency'    => $user->register_Agency,
        ]);

        return back()->with('success', 'อัปเดตข้อมูลสำเร็จ');
    }
}