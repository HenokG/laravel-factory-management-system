<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Psy\Util\Json;

class CheckCompanyIdMiddleware
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
        if (!$request->company_id && !($request->toArray() && $request->toArray()[0]['company_id'])) {
            return new Response('Please Provide an Appropriate Parameter');
        }
        return $next($request);
    }
}
