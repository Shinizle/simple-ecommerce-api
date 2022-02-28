<?php

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductEventController;
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

                Route::group(['prefix' => 'events'], function () {
                    Route::get('get-all-events', [EventController::class, 'getAllEvents']);
                    Route::get('get-event', [EventController::class, 'getEvent']);
                    Route::post('add-new-event', [EventController::class, 'addNewEvent']);
                    Route::put('edit-event', [EventController::class, 'editEvent']);
                    Route::delete('delete-event', [EventController::class, 'deleteEvent']);
                });

                Route::group(['prefix' => 'product-events'], function () {
                    Route::get('get-all-products', [ProductEventController::class, 'getAllProducts']);
                    Route::get('get-product', [ProductEventController::class, 'getProduct']);
                    Route::post('add-product', [ProductEventController::class, 'addNewProduct']);
                    Route::put('edit-product', [ProductEventController::class, 'editProduct']);
                    Route::delete('delete-product', [ProductEventController::class, 'deleteProduct']);
                });

                Route::group(['prefix' => 'orders'], function () {
                    Route::get('get-all-orders', [OrderController::class, 'getAllOrders']);
                    Route::get('get-order', [OrderController::class, 'getOrder']);
                    Route::get('get-order-products', [OrderController::class, 'getOrderProducts']);
                    Route::post('complete-order', [OrderController::class, 'completeOrder']);
                });
            });
        });
    });
});
