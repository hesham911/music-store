<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Artists\ArtistController;
use App\Http\Controllers\Api\v1\Albums\AlbumController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function (){
    /*Auth Routes*/
    Route::controller(AuthController::class)->prefix('users')->group(function () {
        Route::post('login', 'login')->name('login');
        Route::post('register', 'register')->name('register');
        Route::post('/password/reset', 'resetPassword')->name('password.reset');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', 'logout')->name('auth.logout');
            Route::post('user/delete', 'deleteUser')->name('auth.delete');
            Route::get('portfolio', 'getAuthenticatedUser')->name('auth.user');
            Route::post('/password/email', 'sendPasswordResetLinkEmail')->name('password.email');
        });
    });

    /*Artists Routes*/
    Route::controller(ArtistController::class)->prefix('artists')->group(function () {
        Route::get('/','index');
        Route::get('artist/{id}','show');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('store','store');
        });
    });

    /*Album Routes*/
    Route::controller(AlbumController::class)->prefix('albums')->group(function () {
        Route::get('/','index');
        Route::get('album/{id}','show');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('store','store');
        });
    });
});
