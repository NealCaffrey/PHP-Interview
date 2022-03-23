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
Route::prefix('interview')->group(function () {
    Route::get('/category', [\App\Http\Controllers\IndexController::class, 'category']);
    Route::get('/knowledge/{categoryId}', [\App\Http\Controllers\IndexController::class, 'knowledge']);
    Route::get('/collection', [\App\Http\Controllers\IndexController::class, 'collection']);
    Route::get('/search/{keyword}', [\App\Http\Controllers\IndexController::class, 'search']);
    Route::get('/knowledgeInfo/{id}', [\App\Http\Controllers\IndexController::class, 'knowledgeInfo']);
    Route::get('/exam', [\App\Http\Controllers\IndexController::class, 'generateExam']);
});
