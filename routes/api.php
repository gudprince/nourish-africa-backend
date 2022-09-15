<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ForgotPasswordController;


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

Route::group(['middleware'  =>  'auth:api'], function () {
    
    Route::controller(UserController::class)->group(function () {
        Route::get('/v1/users', 'index');
        Route::get('/v1/users/{id}', 'find');
        Route::put('/v1/users/{id}', 'update');
        Route::delete('/v1/users/{id}', 'delete');
    });

    Route::controller(CompanyController::class)->group(function () {
        Route::get('/v1/companies', 'index');
        Route::post('/v1/companies', 'save');
        Route::get('/v1/companies/{id}', 'find');
        Route::put('/v1/companies/{id}', 'update');
        Route::delete('/v1/companies/{id}', 'delete');
        Route::get('/v1/user-companies', 'userCompany');
    });

});

Route::controller(AuthController::class)->group(function () {
    Route::post('/v1/register', 'register');
    Route::post('/v1/login', 'login');
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('/v1/change-password', 'changePassword');
});
