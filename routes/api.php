<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\UserController;
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

Route::prefix('v1')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::get('member-status-update', [MemberController::class, 'statusCheck']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('dashboard', [DashboardController::class, 'index']);
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'getUser']);
        Route::apiResources([
            'members' => MemberController::class,
            'invoice' => InvoiceController::class,
            'expense' => ExpenseController::class,
            'users'   => UserController::class,
        ]);
    });
});
