<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTRoleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'status' => false,
                    'message' => '无此用户'
                ], 404);
            }
            return $next($request);
        } catch (TokenExpiredException $e) {

            return response()->json([
                'status' => false,
                'message' => 'token 过期'
            ]);

        } catch (TokenInvalidException $e) {

            return response()->json([
                'status' => false,
                'message' => 'token 无效'
            ]);

        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => '缺少token'
            ]);

        }

    }
}
