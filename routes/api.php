<?php

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductEventController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\AuthController;
use App\Http\Controllers\Customer\PromotionController;
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

        /*
         * ROUTE GROUP FOR ADMINISTRATOR ROLE
         */

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
                    Route::put('update-status', [EventController::class, 'updateStatus']);
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

        /*
         * ROUTE GROUP FOR CUSTOMER ROLE
         */

        Route::group(['middleware' => ['role:'.\App\Models\User::CUSTOMER, 'auth']], function () {
            Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
                Route::group(['prefix' => 'products'], function () {
                    Route::get('get-all-products', [CustomerProductController::class, 'getAllProducts']);
                    Route::get('get-product', [CustomerProductController::class, 'getProduct']);
                });

                Route::group(['prefix' => 'promotions'], function () {
                    Route::group(['prefix' => 'events'], function () {
                        Route::get('get-all-events', [PromotionController::class, 'getAllEvents']);
                        Route::get('get-detail-event', [PromotionController::class, 'getDetailEvent']);
                    });
                    Route::group(['prefix' => 'product-events'], function () {
                        Route::get('get-all-product-events', [PromotionController::class, 'getAllProductEvents']);
                        Route::get('get-detail-product-event', [PromotionController::class, 'getDetailProductEvent']);
                    });
                });

                Route::group(['prefix' => 'carts'], function () {
                    Route::get('get-user-carts', [CartController::class, 'getUserCart']);
                    Route::get('get-cart', [CartController::class, 'getCart']);
                    Route::post('add-to-cart', [CartController::class, 'addToCart']);
                    Route::put('update-item-cart', [CartController::class, 'updateItemCart']);
                    Route::delete('remove-from-cart', [CartController::class, 'removeFromCart']);
                });

                Route::post('checkout', [CheckoutController::class, 'handle']);
            });
        });
    });
});
