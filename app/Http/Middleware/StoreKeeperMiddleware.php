<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreKeeperMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ((Auth::user()->role != 'super_admin') && (Auth::user()->role != 'admin') && (Auth::user()->role != 'manager') && (Auth::user()->role != 'storekeeper')) {
            return redirect()->back()->with(['failed' => 'You have no permission to view this']);
        }
        return $next($request);
    }
}
