<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class SubscriptionCompanyDateMiddleware
 * @package App\Http\Middleware
 */
class SubscriptionCompanyDateMiddleware
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
        if($request->company->checkAccessGrantedForSubscribe()){
            return $next($request);
        }
        abort(403);
    }
}