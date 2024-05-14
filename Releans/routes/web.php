<?php

use App\Http\Controllers\authController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\salesController;
use App\Http\Controllers\shopcontroller;
use App\Http\Controllers\StockTrackingController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return ['Laravel' => app()->version()];
// });

// require __DIR__ . '/auth.php';

Route::middleware(['auth:sanctum', 'check.role:admin'])->group(function () {
    Route::get('/stockAdd', [StockTrackingController::class, 'add'])->name('add.Track');
    Route::get('/stockEdit', [StockTrackingController::class, 'edit'])->name('edit.Track');
    route::get('/allUser', [UsersController::class, 'index'])->name('user.page');
});

Route::middleware(['auth:sanctum', 'check.role:admin,manager'])->group(function () {
    Route::get('/', [DashController::class, 'index'])->name('dashboards');
    Route::get('/product', [ProductController::class, 'index'])->name('product.page');
    Route::get('/productAdd', [ProductController::class, 'addProdcut'])->name('add.product');
    Route::get('/productEdit', [ProductController::class, 'editProdcut'])->name('edit.product');
    Route::get('/stock', [StockTrackingController::class, 'index'])->name('stock.page');
    route::get('/sale', [salesController::class, 'index'])->name('sale.page');
});

Route::middleware(['auth:sanctum'])->group(function () {
    route::get('/shop', [shopcontroller::class, 'index'])->name('shop.page');
    route::get('/selectProduct', [shopcontroller::class, 'show'])->name('select.page');
});


route::get('/loginPage', [authController::class, 'index'])->name('login.page');
route::get('/signupPage', [authController::class, 'signup'])->name('signup.page');


////////////////////// 

route::get('/addUsers', [UsersController::class, 'add'])->name('add.page');
route::get('/ProfileUsers', [UsersController::class, 'store'])->name('Profile.page');
