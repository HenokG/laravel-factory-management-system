<?php

namespace App\Http\Middleware;

use App\Util\FinalConstants;
use Closure;
use Illuminate\Support\Facades\Session;

class RedirectToAccountTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //if user in session is factory manager and url contains factorymanager/
        if ((Session::get(FinalConstants::SESSION_DEPARTMENT_LABEL) == FinalConstants::DEPARTMENT_FACTORY_MANAGEMENT_LABEL) && strpos($request->route()->uri, 'factorymanager') !== false) {
            return $next($request);
        }
        //for shift manager
        else if ((Session::get(FinalConstants::SESSION_DEPARTMENT_LABEL) == FinalConstants::DEPARTMENT_PRODUCTION_MANAGEMENT_LABEL) && strpos($request->route()->uri, 'shiftmanager') !== false) {
            return $next($request);
        }
        // else if user is sales then can't access factorymanager routes
        else if ((Session::get(FinalConstants::SESSION_DEPARTMENT_LABEL) == FinalConstants::DEPARTMENT_SALES_LABEL) && strpos($request->route()->uri, 'factorymanager') == false) {
            return $next($request);
        }
        //for secretary
        else if ((Session::get(FinalConstants::SESSION_DEPARTMENT_LABEL) == FinalConstants::DEPARTMENT_SECRETARY_LABEL) && strpos($request->route()->uri, 'secretary') == false) {
            return $next($request);
        }else{
            dd(strpos($request->route()->uri, 'factorymanager'));
        }
    }
}
