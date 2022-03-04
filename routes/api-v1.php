<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\UserController;
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


Route::group(['prefix' => 'v1'], function ($app){
    $app->group(['prefix' => 'auth'], function ($app){
        $app->post('register', [AuthController::class, 'register']);

        $app->post('login', [AuthController::class, 'login'])->name('login');
        $app->post('logout', [AuthController::class, 'logout']);
        $app->post('refresh', [AuthController::class, 'refresh']);
    });

    $app->group(['prefix' => 'admin', 'middleware' => 'auth'], function ($app){
        $app->group(['prefix' => 'publisher'], function ($app){
            $app->post('/publish', [PublisherController::class, 'create']);
        });

        $app->group(['prefix' => 'book'], function ($app){
            $app->post('/', [BookController::class, 'create']);
        });
    });

    $app->group(['prefix' => 'client'], function ($app){
        $app->group(['prefix' => 'book'], function ($app){
            $app->get('/', [BookController::class, 'index']);
        });
    });
});
