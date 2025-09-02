<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'authenticateLogin'])->name('login');

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::controller(ProductController::class)
            ->prefix('/products')
            ->group(function () {
                Route::get('/', 'index')->name('products');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/delete/{id}', 'destroy')->name('delete');
                Route::delete('/media/{media}', 'destroyMedia')->name('destroyMedia');
            });

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
