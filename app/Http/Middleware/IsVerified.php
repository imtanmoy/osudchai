<?php

namespace App\Http\Middleware;

use App\Services\UserService\Exceptions\UserNotVerifiedException;
use Closure;
use Session;

class IsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws UserNotVerifiedException
     */
    public function handle($request, Closure $next)
    {
        if (!is_null($request->user()) && !$request->user()->is_verified == 1) {
            Session::flush();
            throw new UserNotVerifiedException;
        }
        return $next($request);
    }
}
