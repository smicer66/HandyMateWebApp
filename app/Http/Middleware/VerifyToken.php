<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


class VerifyToken
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
        try{
			$arr = getallheaders();
			//dd($arr);
			$authHeader = $arr['Authorization'];
			//dd($authHeader);
			
			//list($jwt) = sscanf( $authHeader, 'Bearer %s');
            //list($jwt) = sscanf( $authHeader, 'Bearer %s');
			//dd($jwt);
            $jwt = $authHeader;
            $user = JWTAuth::toUser($jwt);

        }catch (JWTException $e) {
            dd($e);
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status'=>422]);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status'=>422]);
            }else{
                return response()->json(['status'=>422]);
            }
        }
        return $next($request);
    }
}