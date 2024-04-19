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

Route::post('api/accessToken', [AuthenticatedSessionController::class, 'store'])->name('logins');
// Route::post('accessToken', [authController::class, 'store'])->name('token');

Route::post('adduser', [Controller::class, 'create']);

Route::post('editProduct/{id}', [ProductController::class, 'edits']);
Route::delete('product/delete/{id?}', [ProductController::class, 'delete']);
Route::get('allProduct', [ProductController::class, 'allProduct'])->middleware('guest:sanctum');
Route::get('selectProduct/{id?}', [ProductController::class, 'selectProduct'])->middleware('guest:sanctum');
Route::post('addproduct', [ProductController::class, 'add']);



Route::get('notifications', [InventoryController::class, 'notify']);
Route::post('markAllRead', [InventoryController::class, 'markAllAsRead']);
accessToken

Route::post('stockTrans', [StockTrackingController::class, 'create']);
Route::delete('deleteStock/{id?}', [StockTrackingController::class, 'delete']);
Route::get('allTransaction', [StockTrackingController::class, 'allTran']);
Route::post('editTrans/{id}', [StockTrackingController::class, 'update']);
Route::get('selectTrans/{id?}', [StockTrackingController::class, 'selectTrans']);