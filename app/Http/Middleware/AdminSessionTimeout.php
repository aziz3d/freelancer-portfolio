<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminSessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->is('admin/*')) {
            return $next($request);
        }
        if ($request->is('admin/login') || 
            $request->is('admin/logout') || 
            $request->is('admin/forgot-password') || 
            $request->is('admin/reset-password') || 
            $request->is('admin/reset-password/*')) {
            return $next($request);
        }

        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please login to access the admin panel.');
        }

        $timeout = 30 * 60;
        $lastActivity = Session::get('admin_last_activity');
        $currentTime = time();

        if ($lastActivity && ($currentTime - $lastActivity) > $timeout) {
            Auth::logout();
            Session::flush();
            Session::regenerate();
            
            return redirect()->route('admin.login')
                ->with('error', 'Your session has expired due to inactivity. Please login again.')
                ->with('session_expired', true);
        }

        Session::put('admin_last_activity', $currentTime);

        return $next($request);
    }
}