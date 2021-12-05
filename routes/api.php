<?php

use App\Http\Controllers\Api\Login\LoginController;
use App\Http\Controllers\Api\UserBankLogin\UserBankLoginResource;
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

Route::get('login', function () {
    return abort(401);
})->name('login');

Route::post('login', [LoginController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('user_bank_login', UserBankLoginResource::class);
});
