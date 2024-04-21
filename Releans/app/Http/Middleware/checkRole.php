<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login.page');
        }

        if (in_array($user->role, $roles)) {
            return $next($request);
        }
        if ($user->role === 'manager' && $request->route()->getName() !== 'shop.page') {

            return redirect()->back()->with('error', 'You are not authorized to access this page.');
        }

        if ($request->route()->getName() === 'shop.page') {
            return redirect()->back()->with('error', 'You are not authorized to access this page.');
        }

        return redirect()->route('shop.page');
    }
}