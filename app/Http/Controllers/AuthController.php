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
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'logout']]);
    }

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

        if ($user->id) {
            return response()->json([
                'status' => true,
                'data'  => $user,
                'message' => '注册成功'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => '注册失败'
            ]);
        }
    }

    /**
     * 登录
     * @param Request $request
     * @return false|string
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials = [
            'email' => '1@qq.com',
            'password' => 'liuchuanqi7'
        ];
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => '登录失败'
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $this->respondWithToken($token),
            'message' => '登录成功'
        ]);
    }

    //刷新
    public function refresh()
    {
        return response([
            'status' => true,
            'data' => $this->respondWithToken(auth('api')->refresh()),
            'message' => '刷新成功'
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => \auth('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * 退出登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        \auth('api')->logout();

        return response()->json([
            'status' => true,
            'message' => '退出成功'
        ]);
    }

    //用户信息
    public function user()
    {
        $data = \auth('api')->user();
        return response([
            'status' => true,
            'data' => $data
        ]);
    }
}
