<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CompanyController;
use App\Http\Controllers\Api\V1\UserController;
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

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('company', [CompanyController::class, 'index']);
Route::get('user', [UserController::class, 'index']);

    Route::get('company/{id}', [CompanyController::class, 'getById']);
    Route::post('company', [CompanyController::class, 'create']);
    Route::put('company/{id}', [CompanyController::class, 'update']);
    Route::delete('company/{id}', [CompanyController::class, 'delete']);

    Route::get('user/{id}', [UserController::class, 'getById']);
    Route::post('user', [UserController::class, 'create']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::delete('user/{id}', [UserController::class, 'delete']);

Route::middleware(['auth:api'])->group(function () {
    Route::put('user/company/{id}', [UserController::class, 'appointCompanyById']);
});