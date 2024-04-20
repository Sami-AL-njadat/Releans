<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\authController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockTrackingController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Controller;

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

Route::post('ton/accessToken', [AuthenticatedSessionController::class, 'store'])->name('afterlogin');
Route::post('login/accessToken', [authController::class, 'store'])->name('logins');
Route::delete('logout/delete/{token?}', [AuthController::class, 'destroy']);
// Route::post('accessToken', [authController::class, 'store'])->name('token')->name('afterlogin');

Route::post('adduser', [Controller::class, 'create']);

Route::post('editProduct/{id}', [ProductController::class, 'edits']);
Route::delete('product/delete/{id?}', [ProductController::class, 'delete']);
Route::get('allProduct', [ProductController::class, 'allProduct'])->middleware('auth:sanctum');
Route::get('selectProduct/{id?}', [ProductController::class, 'selectProduct']);
Route::post('addproduct', [ProductController::class, 'add']);



Route::get('notifications', [InventoryController::class, 'notify']);
Route::post('markAllRead', [InventoryController::class, 'markAllAsRead']);
Route::post('stockTrans', [StockTrackingController::class, 'create']);
Route::delete('deleteStock/{id?}', [StockTrackingController::class, 'delete']);
Route::get('allTransaction', [StockTrackingController::class, 'allTran']);
Route::post('editTrans/{id}', [StockTrackingController::class, 'update']);
Route::get('selectTrans/{id?}', [StockTrackingController::class, 'selectTrans']);
