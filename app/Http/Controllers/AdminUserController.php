<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\SystemLog;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim((string) $request->get('keyword', ''));
        $agency  = trim((string) $request->get('agency', ''));
        $role    = trim((string) $request->get('role', ''));

        $query = Register::query();

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('register_User', 'like', "%{$keyword}%")
                  ->orWhere('register_Name', 'like', "%{$keyword}%")
                  ->orWhere('register_Same', 'like', "%{$keyword}%")
                  ->orWhere('register_Gmail', 'like', "%{$keyword}%")
                  ->orWhere('register_Phone', 'like', "%{$keyword}%")
                  ->orWhere('register_Number', 'like', "%{$keyword}%");
            });
        }

        if ($agency !== '') {
            $query->where('register_Agency', $agency);
        }

        if ($role !== '') {
            $query->where('register_Type', $role);
        }

        $users = $query
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact(
            'users',
            'keyword',
            'agency',
            'role'
        ));
    }

    public function approve($id)
    {
        $user = Register::findOrFail($id);

        $user->register_Status = 'อนุมัติแล้ว';
        $user->save();

        $this->logActivity(
            'อนุมัติผู้ใช้งาน',
            'อนุมัติผู้ใช้: ' . $user->register_User
        );

        return back()->with('success', 'อนุมัติผู้ใช้งานแล้ว');
    }

    public function pending($id)
    {
        $user = Register::findOrFail($id);

        $user->register_Status = 'รออนุมัติ';
        $user->save();

        $this->logActivity(
            'เปลี่ยนสถานะผู้ใช้งาน',
            'เปลี่ยนเป็นรออนุมัติ: ' . $user->register_User
        );

        return back()->with('success', 'เปลี่ยนสถานะเป็นรออนุมัติแล้ว');
    }

    public function edit($id)
    {
        $user = Register::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|max:30',
            'last_name'  => 'required|max:50',
            'email'      => 'required|email|max:50',
            'phone'      => 'nullable|max:10',
            'agency_id'  => 'required',
            'role'       => 'required|in:admin,user',
        ]);

        $user = Register::findOrFail($id);

        $user->update([
            'register_Name'   => $request->first_name,
            'register_Same'   => $request->last_name,
            'register_Gmail'  => $request->email,
            'register_Phone'  => $request->phone,
            'register_Agency' => $request->agency_id,
            'register_Type'   => $request->role,
        ]);

        $this->logActivity(
            'แก้ไขผู้ใช้งาน',
            'แก้ไขข้อมูลผู้ใช้: ' . $user->register_User
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }

    public function destroy($id)
    {
        $user = Register::findOrFail($id);

        $username = $user->register_User;

        $this->logActivity(
            'ลบผู้ใช้งาน',
            'ลบผู้ใช้: ' . $username
        );

        $user->delete();

        return back()->with('success', 'ลบผู้ใช้งานสำเร็จ');
    }

   private function logActivity($action, $detail = null)
{
    SystemLog::create([
        'user_id'    => session('user_id'),
        'username'   => session('username') ?? session('login_user'),
        'role'       => session('user_role') ?? session('login_type'),
        'agency'     => session('user_agency'),
        'action'     => $action,
        'detail'     => $detail,
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);
}
}