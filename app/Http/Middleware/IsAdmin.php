<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if ($user && $user->is_admin) {
            return $next($request);
        }

        if (!$user) {
            return redirect()->route('login');
        }

        abort(403);
    }
}
