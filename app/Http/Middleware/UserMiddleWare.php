<?php

namespace App\Http\Middleware;

use Closure;

class UserMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $privilege)
    {
        if(\Auth::check())
		{
			if(\Auth::user()->user_type == 1)
				return $next($request);
			else if(\Auth::user()->user_type == 2)
			{
				if($privilege == 'canaccess')
					return $next($request);
			}
		}
		
		return redirect(url('/').'/login');
    }
}
