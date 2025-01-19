<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/product', [App\Http\Controllers\ProductController::class, 'index'])->name('product');

    Route::get('/search', [App\Http\Controllers\ProductController::class, 'search'])->name('search');

    Route::get('/detail/{id}', [App\Http\Controllers\ProductController::class, 'detail'])->name('detail');

    Route::get('/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('edit');

    Route::put('/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('update');

    Route::get('/product_register', [App\Http\Controllers\ProductController::class, 'product_register'])->name('product_register');

    Route::post('/store', [App\Http\Controllers\ProductController::class, 'store'])->name('store');

    Route::delete('/product_delete/{id}', [App\Http\Controllers\ProductController::class, 'product_delete'])->name('product_delete');

});

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');