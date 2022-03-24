<?php
/**
 * Created by PhpStorm
 * User: Neal Caffrey
 * Date: 3/23/2022
 * Time: 4:17 PM
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    /**
     * 注册
     * @param Request $request
     * @return User|array
     */
    public function register(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:20'
        ]);
        if ($valid->fails()) {
            return [
                'status' => false,
                'message' => $valid->errors()->first()
            ];
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return $user;
    }

    /**
     * 登录
     * @param Request $request
     * @return false|string
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
//        if (!$token = Auth::attempt($credentials)) {
//            return 'error' . $token;
//        }
        if (!$token = JWTAuth::attempt($credentials)) {
            return 'error' . $token;
        }

        return $token;
    }

    public function logout()
    {
        JWTAuth::invalidate();
        return '退出成功';
    }

    public function user()
    {
        $user  = User::find(Auth::user()->id);
        return response([
            'status' => true,
            'data' => $user
        ]);
    }

    public function refresh()
    {
        return response([
            'status' => true
        ]);
    }
}
