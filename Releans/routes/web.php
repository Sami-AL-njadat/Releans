<?php

use App\Http\Controllers\authController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\shopcontroller;
use App\Http\Controllers\StockTrackingController;

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

Route::get('/', [DashController::class, 'index'])->name('dashboards');

Route::get('/product', [ProductController::class, 'index'])->name('product.page');
Route::get('/productAdd', [ProductController::class, 'addProdcut'])->name('add.product');
Route::get('/productEdit', [ProductController::class, 'editProdcut'])->name('edit.product');

route::get('/loginPage', [authController::class, 'index'])->name('login.page');
route::get('/shop', [shopcontroller::class, 'index'])->name('shop.page');
route::get('/selectProduct', [shopcontroller::class, 'show'])->name('select.page');
route::get('/sss', [shopcontroller::class, 'sss'])->name('ss.page');
route::get('/signupPage', [authController::class, 'signup'])->name('signup.page');

Route::get('/stock', [StockTrackingController::class, 'index'])->name('stock.page');
Route::get('/stockAdd', [StockTrackingController::class, 'add'])->name('add.Track');
Route::get('/stockEdit', [StockTrackingController::class, 'edit'])->name('edit.Track');
