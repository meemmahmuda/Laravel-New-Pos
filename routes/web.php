<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesReturnController;
use App\Http\Controllers\IncomeStatementController;
use App\Http\Controllers\DashboardController;

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
    return view('login');
});

Route::post('/login', function () {
    return redirect()->route('dashboard');
})->name('login.submit');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('categories', CategoryController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('products', ProductController::class);

Route::get('/income-statement/print', [IncomeStatementController::class, 'print'])->name('income_statement.print');


Route::get('orders/report', [OrderController::class, 'report'])->name('orders.report');
Route::get('/orders/report/pdf', [OrderController::class, 'generatePdf'])->name('orders.report.pdf');

Route::resource('orders', OrderController::class);
Route::resource('expenses', ExpenseController::class);
Route::get('sales/report', [SaleController::class, 'report'])->name('sales.report');
Route::get('/sales/report/pdf', [SaleController::class, 'generateReportPdf'])->name('sales.report.pdf');
Route::resource('sales', SaleController::class);
Route::resource('sales_returns', SalesReturnController::class);

Route::get('/suppliers/{id}', [SupplierController::class, 'show'])->name('suppliers.show');
Route::get('/suppliers/{supplier}/print', [SupplierController::class, 'printSupplierDetails'])->name('suppliers.print');
Route::get('/sales/{customerName}', [SaleController::class, 'show'])->name('sales.show');
Route::get('/sales/pdf/{customerId}', [SaleController::class, 'generateSalePdf'])->name('sales.sale_pdf');
Route::get('/income-statement', [IncomeStatementController::class, 'index'])->name('income_statement.index');








