<?php
/**
 * Created by PhpStorm
 * User: Neal Caffrey
 * Date: 3/23/2022
 * Time: 4:17 PM
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token == auth('api')->attempt($credentials)) {
            return response()->json([
                'status' => false,
                'errors' => 'Unanthorized'
            ], 401);
        }

        return $this->responWithToken($token);
    }
}
