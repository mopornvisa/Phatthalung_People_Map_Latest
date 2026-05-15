<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginRequired
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('login_user')) {

            return redirect()->route('home');

        }

        return $next($request);
    }
}