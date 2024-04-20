<?php

use App\Http\Controllers\authController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashController;
use App\Http\Controllers\ProductController;
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

Route::get('/', [DashController::class, 'index'])->name('dashboards')->middleware('auth:sanctum');

Route::get('/product', [ProductController::class, 'index'])->name('product.page')->middleware('auth:sanctum');
Route::get('/productAdd', [ProductController::class, 'addProdcut'])->name('add.product')->middleware('auth:sanctum');
Route::get('/productEdit', [ProductController::class, 'editProdcut'])->name('edit.product')->middleware('auth:sanctum');

route::get('/loginPage', [authController::class, 'index'])->name('login.page');

Route::get('/stock', [StockTrackingController::class, 'index'])->name('stock.page')->middleware();
Route::get('/stockAdd', [StockTrackingController::class, 'add'])->name('add.Track');
Route::get('/stockEdit', [StockTrackingController::class, 'edit'])->name('edit.Track');
