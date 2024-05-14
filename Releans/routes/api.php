<?php


use App\Http\Controllers\authController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockTrackingController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\salesController;
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

////// #### -- auth just for only for admin


Route::middleware(['auth:sanctum', 'check.role:admin'])->group(function () {

    Route::post('editTrans/{id}', [StockTrackingController::class, 'update']);
    Route::delete('deleteStock/{id?}', [StockTrackingController::class, 'delete']);
    Route::delete('user/delete/{id?}', [UsersController::class, 'delete']);
    Route::post('newUser', [UsersController::class, 'create']);
    Route::post('user/{id}/role', [UsersController::class, 'updateRole']);
    Route::get('allSale', [salesController::class, 'show']);
});



////// #### -- auth just for all type of user


Route::middleware(['auth:sanctum', 'check.role:admin,manager,user'])->group(function () {


    Route::delete('logout/delete/{token?}', [AuthController::class, 'destroy']);
    Route::post('editProfileInfo/{id?}', [UsersController::class, 'edit']);
    Route::post('PassWordRest/{id?}', [UsersController::class, 'passWord']);
    Route::get('allUsers', [UsersController::class, 'show']);
    Route::post('newSale/{id?}', [shopcontroller::class, 'sale']);



    Route::get('allProduct', [ProductController::class, 'allProduct']);
    Route::get('selectProduct/{id?}', [ProductController::class, 'selectProduct']);
});






////// #### -- auth just for admin & manager


Route::middleware(['auth:sanctum', 'check.role:admin,manager'])->group(function () {


    Route::get('salesReport', [shopcontroller::class, 'generateSalesReport'])->name('sale.pdf');
    Route::get('inventoryReport', [shopcontroller::class, 'generateInventoryReport'])->name('inventory.pdf');
    Route::get('popularReport', [shopcontroller::class, 'generatePopularReport'])->name('popular.pdf');

    Route::post('updateSale/{id?}', [shopcontroller::class, 'updateSaleStatus']);


    Route::get('notifications', [InventoryController::class, 'notify']);
    Route::post('markAllRead', [InventoryController::class, 'markAllAsRead']);
    Route::post('stockTrans', [StockTrackingController::class, 'create']);
    Route::get('allTransaction', [StockTrackingController::class, 'allTran']);
    Route::get('selectTrans/{id?}', [StockTrackingController::class, 'selectTrans']);


    Route::post('editProduct/{id}', [ProductController::class, 'edits']);
    Route::delete('product/delete/{id?}', [ProductController::class, 'delete']);

    Route::post('addproduct', [ProductController::class, 'add']);
});




Route::post('login/accessToken', [authController::class, 'store'])->name('logins');
Route::post('createUser', [AuthController::class, 'create']);