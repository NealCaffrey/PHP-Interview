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
//首页
Route::prefix('index')->group(function () {
    Route::get('/category', [\App\Http\Controllers\IndexController::class, 'category']);
    Route::get('/knowledge/{categoryId}', [\App\Http\Controllers\IndexController::class, 'knowledge']);
    Route::get('/knowledgeInfo/{id}', [\App\Http\Controllers\IndexController::class, 'knowledgeInfo']);//知识点详情
    Route::get('/search/{keyword}', [\App\Http\Controllers\IndexController::class, 'search']);
    Route::get('/rank', [\App\Http\Controllers\IndexController::class, 'rankList']);
    Route::get('/version', [\App\Http\Controllers\IndexController::class, 'version']);
    Route::get('/help', [\App\Http\Controllers\IndexController::class, 'help']);
});

Route::prefix('auth')->group(function () {
    Route::any('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');//登录
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);//注册
});

Route::prefix('user')->group(function () {
    Route::get('/collection', [\App\Http\Controllers\UserController::class, 'collectionList']); //收藏列表
    Route::post('/collection', [\App\Http\Controllers\UserController::class, 'collection']);//收藏
    Route::get('/browse', [\App\Http\Controllers\UserController::class, 'browseList']);//浏览列表
    Route::post('sign', [\App\Http\Controllers\UserController::class, 'sign']);//签到
    Route::get('/exam', [\App\Http\Controllers\UserController::class, 'generateExam']);//生成试卷
});
