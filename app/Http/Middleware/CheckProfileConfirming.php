<?php

namespace App\Http\Middleware;

use App\Entity\User\User;
use Closure;

class CheckProfileConfirming
{
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        if(!$user->hasFilledProfile()) {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
