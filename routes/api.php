<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//首页
Route::prefix('index')->group(function () {
    Route::get('/category', [\App\Http\Controllers\IndexController::class, 'category']);
    Route::get('/knowledge/{categoryId}', [\App\Http\Controllers\IndexController::class, 'knowledge']);
    Route::get('/collection', [\App\Http\Controllers\IndexController::class, 'collection']);
    Route::get('/search/{keyword}', [\App\Http\Controllers\IndexController::class, 'search']);
    Route::get('/knowledgeInfo/{id}', [\App\Http\Controllers\IndexController::class, 'knowledgeInfo']);
});
//用户相关
Route::prefix('member')->group(function () {
    Route::get('/info', [\App\Http\Controllers\MemberController::class, 'getMemberInfo']);
    Route::get('/collection', [\App\Http\Controllers\MemberController::class, 'collectionList']);
    Route::get('/browse', [\App\Http\Controllers\MemberController::class, 'browseList']);
    Route::post('sign', [\App\Http\Controllers\MemberController::class, 'sign']);
    Route::get('/exam', [\App\Http\Controllers\MemberController::class, 'generateExam']);
    Route::get('/version', [\App\Http\Controllers\MemberController::class, 'version']);
    Route::get('/help', [\App\Http\Controllers\MemberController::class, 'help']);
});
Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
});
