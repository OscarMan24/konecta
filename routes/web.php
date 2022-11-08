<?php

use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SaleProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;

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



Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/change-lenguaje/{lang}', [HomeController::class, 'changeLang'])->name('change.lang');

Route::group(['middleware' => ['auth']], function () {
    Route::prefix('panel')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('index.users');
        Route::get('/setting', [SettingController::class, 'index'])->name('index.setting');
        Route::get('/rol-and-permissions', [HomeController::class, 'indexroles'])->name('index.rols');
        Route::get('/category', [CategoriaController::class, 'index'])->name('index.categoria');
        Route::get('/products', [ProductsController::class, 'index'])->name('index.products');
    });
    Route::get('/shop', [SaleProductController::class, 'indexshop'])->name('index.shop');
});
