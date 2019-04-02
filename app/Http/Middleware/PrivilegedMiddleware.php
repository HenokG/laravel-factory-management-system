<?php

namespace App\Http\Middleware;

use App\Util\FinalConstants;
use Closure;
use Illuminate\Support\Facades\Session;

class PrivilegedMiddleware
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
        $department = Session::has(FinalConstants::SESSION_DEPARTMENT_LABEL);

        if ($department) {

            if ($department == FinalConstants::DEPARTMENT_SALES_LABEL) {

                return $next($request);

            } else if ($department == FinalConstants::DEPARTMENT_MANAGEMENT_LABEL) {

                //handle management department

            }

        } else {
            //for support and stuff and developers
        }
        return $next($request);
    }
}
