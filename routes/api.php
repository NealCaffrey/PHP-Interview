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
    Route::get('/category', [\App\Http\Controllers\CategoryController::class, 'index']);
    Route::get('/knowledge', [\App\Http\Controllers\CategoryController::class, 'knowledge']);
    Route::get('/knowledgeInfo', [\App\Http\Controllers\CategoryController::class, 'knowledgeInfo']);
});
