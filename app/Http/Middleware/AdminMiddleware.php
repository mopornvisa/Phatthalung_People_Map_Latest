<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')
                ->with('error', 'กรุณาเข้าสู่ระบบก่อนใช้งาน');
        }

        if (session('user_role') !== 'admin') {
            return redirect()->route('home')
                ->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        return $next($request);
    }
}