<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Display the form for creating multiple orders
    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        
        return view('orders.create', compact('products', 'suppliers'));
    }
    

    // Store multiple orders in the database
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'orders' => 'required|array',
            'orders.*.product_id' => 'required|exists:products,id',
            'orders.*.supplier_id' => 'required|exists:suppliers,id',
            'orders.*.quantity' => 'required|integer|min:1',
            'orders.*.purchase_price' => 'required|integer|min:0',
            'orders.*.amount_given' => 'nullable|integer|min:0',
            'orders.*.amount_return' => 'nullable|integer|min:0',
        ]);

        // Loop through each order and create it
        foreach ($request->orders as $orderData) {
            Order::create([
                'product_id' => $orderData['product_id'],
                'supplier_id' => $orderData['supplier_id'],
                'quantity' => $orderData['quantity'],
                'purchase_price' => $orderData['purchase_price'],
                'total_price' => $orderData['quantity'] * $orderData['purchase_price'], // Calculate total price
                'amount_given' => $orderData['amount_given'],
                'amount_return' => $orderData['amount_return'],
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Orders created successfully.');
    }
}
