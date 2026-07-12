<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class deliveryAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('delivery')->check()) {
            return $next($request);
        } else {
            notify()->error('Please login first');
            return redirect()->route('delivery.login');
        }
    }
}
