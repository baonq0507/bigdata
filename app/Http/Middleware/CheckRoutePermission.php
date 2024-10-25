<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoutePermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $routeName = $request->route()->getName();

        // Kiểm tra xem người dùng có quyền truy cập route không
        if (!$user->canAccessRoute($routeName)) {
            // Nếu không, chuyển hướng họ đến trang hoặc route khác
            return redirect('unauthorized');
        }

        return $next($request);
    }
}
