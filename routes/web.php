<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SaleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('categories', CategoryController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::resource('expenses', ExpenseController::class);
Route::resource('sales', SaleController::class);

Route::get('/suppliers/{id}', [SupplierController::class, 'show'])->name('suppliers.show');
Route::get('/suppliers/{supplier}/print', [SupplierController::class, 'printSupplierDetails'])->name('suppliers.print');
Route::get('/sales/{customerName}', [SaleController::class, 'show'])->name('sales.show');
Route::get('/sales/pdf/{customerId}', [SaleController::class, 'generateSalePdf'])->name('sales.sale_pdf');




