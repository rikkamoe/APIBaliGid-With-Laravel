<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminWisataController;

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

// Auth Routes http://127.0.0.1:8000/api/auth/{routes}
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/wisata', [AdminWisataController::class, 'create']);
    Route::get('/wisata', [AdminWisataController::class, 'index']);
});

// General Routes http://127.0.0.1:8000/api/{routes}
Route::group([
    'middleware' => 'api',
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});


