<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/addToCart', [App\Http\Controllers\Api\TransactionController::class, 'addToCart'])->name('addToCart');
Route::post('/payNow', [App\Http\Controllers\Api\TransactionController::class, 'payNow'])->name('payNow');
Route::post('/topupNow', [App\Http\Controllers\Api\WalletController::class, 'topupNow'])->name('topupNow');
Route::get('/download/{order_id}', [App\Http\Controllers\Api\TransactionController::class, 'download'])->name('download');
Route::post('/acceptRequest', [App\Http\Controllers\Api\WalletController::class, 'acceptRequest'])->name('acceptRequest');
Route::post('/product/store', [App\Http\Controllers\Api\ProductController::class, 'store'])->name('product.store');
Route::put('/product/update/{id}', [App\Http\Controllers\Api\ProductController::class, 'update'])->name('product.update');
Route::delete('/product/destroy/{id}', [App\Http\Controllers\Api\ProductController::class, 'destroy'])->name('product.destroy');
Route::post('/transaction/{id}', [App\Http\Controllers\Api\TransactionController::class, 'take'])->name('transaction.take');
Route::delete('/transaction/destroy{id}', [App\Http\Controllers\Api\TransactionController::class, 'destroy'])->name('transaction.destroy');
Route::resource('/user', App\Http\Controllers\Api\UserController::class);
