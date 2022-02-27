<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Customer\AuthController;
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


Route::group(['prefix' => 'v1'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:api'], function() {
        Route::group(['middleware' => ['role:'.\App\Models\User::ADMINISTRATOR, 'auth']], function () {
            Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
                Route::group(['prefix' => 'products'], function () {
                    Route::get('get-all-products', [ProductController::class, 'getAllProducts']);
                    Route::get('get-product', [ProductController::class, 'getProduct']);
                    Route::post('add-new-product', [ProductController::class, 'addNewProduct']);
                    Route::put('edit-product', [ProductController::class, 'editProduct']);
                    Route::delete('delete-product', [ProductController::class, 'deleteProduct']);
                });
            });
        });
    });
});
