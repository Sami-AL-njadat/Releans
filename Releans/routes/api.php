<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\authController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockTrackingController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\shopcontroller;
use App\Http\Controllers\UsersController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'check.role:admin'])->group(function () {

    Route::post('editTrans/{id}', [StockTrackingController::class, 'update']);
    Route::delete('deleteStock/{id?}', [StockTrackingController::class, 'delete']);
});


Route::middleware(['auth:sanctum', 'check.role:admin,manager,user'])->group(function () {
    Route::get('notifications', [InventoryController::class, 'notify']);

    Route::post('markAllRead', [InventoryController::class, 'markAllAsRead']);
    Route::post('stockTrans', [StockTrackingController::class, 'create']);
    Route::get('allTransaction', [StockTrackingController::class, 'allTran']);
    Route::get('selectTrans/{id?}', [StockTrackingController::class, 'selectTrans']);


    Route::post('editProduct/{id}', [ProductController::class, 'edits']);
    Route::delete('product/delete/{id?}', [ProductController::class, 'delete']);
    Route::get('allProduct', [ProductController::class, 'allProduct']);
    Route::get('selectProduct/{id?}', [ProductController::class, 'selectProduct']);
    Route::post('addproduct', [ProductController::class, 'add']);
});

// Route::post('ton/accessToken', [AuthenticatedSessionController::class, 'store'])->name('afterlogin');
Route::post('login/accessToken', [authController::class, 'store'])->name('logins');
Route::delete('logout/delete/{token?}', [AuthController::class, 'destroy'])->middleware(['auth:sanctum']);
Route::post('createUser', [AuthController::class, 'create']);


Route::post('addUsers', [UsersController::class, 'create']);
Route::get('allUsers', [UsersController::class, 'show']);

Route::delete('user/delete/{id?}', [UsersController::class, 'delete']);








Route::post('newSale/{id?}', [shopcontroller::class, 'sale'])->middleware(['auth:sanctum']);
Route::get('salesReport', [shopcontroller::class, 'generateSalesReport'])->name('sale.pdf');
Route::get('inventoryReport', [shopcontroller::class, 'generateInventoryReport'])->name('inventory.pdf');
Route::get('popularReport', [shopcontroller::class, 'generatePopularReport'])->name('popular.pdf');