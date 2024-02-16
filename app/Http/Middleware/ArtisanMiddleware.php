<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;


class ArtisanMiddleware
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
		
		$role = 'Artisan';
		if(!in_array(\Auth::user()->role_type, explode('|', $role)))
		{
        	return response('Unauthorized.', 401);
		}
		return $next($request);
    }
}
