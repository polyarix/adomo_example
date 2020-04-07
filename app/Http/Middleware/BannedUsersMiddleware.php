<?php

namespace App\Http\Middleware;

use App\Entity\User\User;
use Closure;

class BannedUsersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        $allowedRoutes = ['logout', 'user.banned'];

        if($user && $user->isUnderBan() && !$request->routeIs($allowedRoutes)) {
            return redirect()->route('user.banned');
        }
        return $next($request);
    }
}
