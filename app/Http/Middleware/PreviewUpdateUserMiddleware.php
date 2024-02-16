<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;


class PreviewUpdateUserMiddleware
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
		if(!\Auth::user() || (\Auth::user() && \Auth::user()->validated==1))
	        return $next($request);
		else
		{
			if(isset($_REQUEST['update-profile']))
				return $next($request);
			else
				return \Redirect::to('/?update-profile')->with('warning', 'Update your bio-data to start making use of our services. Please provide correct details as your details will be verified');
		}
    }
}
