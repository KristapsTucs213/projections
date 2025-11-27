<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::redirect('/', '/products');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/show', [ProductController::class, 'show'])->name('products.show');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::patch('/products/{product}/up', [ProductController::class, 'increseQuantity'])->name('products.up');
Route::patch('/products/{product}/down', [ProductController::class, 'decreaseQuantity'])->name('products.down');
Route::patch('/products/{product}/add-tag', [ProductController::class, 'addTag'])->name('products.addTag');
Route::put('/products/{product}/update-tags', [ProductController::class, 'updateTags'])->name('products.updateTags');