<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\SystemLog;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = Register::count();

        $pendingUsers = Register::where('register_Status', '!=', 'อนุมัติแล้ว')
            ->count();

        $adminUsers = Register::where('register_Type', 'admin')
            ->count();

        $todayLogs = SystemLog::whereDate('created_at', Carbon::today())
            ->count();

        $latestLogs = SystemLog::orderByDesc('id')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'pendingUsers',
            'adminUsers',
            'todayLogs',
            'latestLogs'
        ));
    }
}