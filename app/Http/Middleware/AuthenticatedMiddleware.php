<?php

namespace App\Http\Middleware;

use App\Util\FinalConstants;
use Closure;
use Illuminate\Support\Facades\Session;

class AuthenticatedMiddleware
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
        $isLoggedIn = Session::has(FinalConstants::SESSION_LOGGEDINUSER_LABEL);
//
//        $isLoggedInAdmin = Session::has(FinalConstants::SESSION_LOGGEDIN_ADMINID_LABEL);

        if ($isLoggedIn) {
            return $next($request);
        }
        return redirect('/login');
    }
}
