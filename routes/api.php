<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifyController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
Route::group([
    'middleware' => ['api','checkPassword'],
    'prefix' => 'user'

], function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::post('refresh', [UserController::class, 'refresh'])->middleware('verifiedphone');
    Route::get('user-profile', [UserController::class, 'userProfile'])->middleware('verifiedphone');
});

//Route::get('/verify', [VerifyController::class,'getVerify'])->name('getverify');
Route::post('/verify', [VerifyController::class,'postVerify'])->name('verify');
