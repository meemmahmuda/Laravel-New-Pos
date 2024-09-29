<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Order;
use App\Models\Sale;
use App\Models\SalesReturn;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::count();  
        $suppliers = Supplier::count();  
        $products = Product::count();  
        $orders = Order::count();  
        $purchases = Order::sum('total_price');  
        $sales = Sale::sum('total_price');  
        $salesreturn = SalesReturn::sum('total_price');  
    
        return view('dashboard', compact('categories', 'suppliers', 'products', 'orders', 'purchases', 'sales', 'salesreturn'));
    }
}