<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Display a listing of the orders
    public function index()
    {
        // Get all suppliers who have made purchases
        $suppliers = Supplier::has('orders')->get();
        return view('orders.index', compact('suppliers'));
    }
    
    public function show($id)
    {
        // Find the supplier by ID and eager load orders and products
        $supplier = Supplier::with('orders.product')->findOrFail($id);
    
        return view('suppliers.show', compact('supplier'));
    }
    

    // Show the form for creating a new order
    public function create()
    {
        // Load products with their suppliers
        $products = Product::with('supplier')->get();
        return view('orders.create', compact('products'));
    }

    // Store a newly created order in the database
// Store a newly created order in the database
public function store(Request $request)
{
    // Validate the request input
    $request->validate([
        'order_data' => 'required', // Add validation for the serialized order data
        'amount_given' => 'required|integer|min:0',
    ]);

    // Decode the order data
    $orders = json_decode($request->order_data, true);

    // Iterate through the orders and store them
    foreach ($orders as $order) {
        // Find the product and calculate total price
        $product = Product::findOrFail($order['product_id']);
        $totalPrice = $product->purchase_price * $order['quantity'];

        // Update the product stock
        $product->stock = ($product->stock ?? 0) + $order['quantity'];
        $product->save();  // Save the updated stock

        // Create the new order
        Order::create([
            'product_id' => $product->id,
            'supplier_id' => $product->supplier_id,
            'quantity' => $order['quantity'],
            'purchase_price' => $product->purchase_price,
            'total_price' => $totalPrice,
            'amount_given' => $request->amount_given,
            'amount_return' => $request->amount_return,
        ]);
    }

    return redirect()->route('orders.index')->with('success', 'Order created successfully.');
}


    // Show the form for editing the specified order
    public function edit(Order $order)
    {
        // Load products with their suppliers for the dropdown
        $products = Product::with('supplier')->get();
        return view('orders.edit', compact('order', 'products'));
    }

    // Update the specified order in the database
    public function update(Request $request, Order $order)
    {
        // Validate the request input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'amount_given' => 'nullable|integer|min:0', // Validate amount given
            'amount_return' => 'nullable|integer|min:0', // Validate amount returned
        ]);

        // Find the product and calculate total price
        $product = Product::findOrFail($request->product_id);
        $totalPrice = $product->purchase_price * $request->quantity;

        // Update the order
        $order->update([
            'product_id' => $product->id,
            'supplier_id' => $product->supplier_id,
            'quantity' => $request->quantity,
            'purchase_price' => $product->purchase_price,
            'total_price' => $totalPrice,
            'amount_given' => $request->amount_given,
            'amount_return' => $request->amount_return,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    // Remove the specified order from the database
    public function destroy(Order $order)
    {
        // Find the product associated with the order
        $product = Product::findOrFail($order->product_id);
    
        // Deduct the order quantity from the product's stock
        if ($product->stock >= $order->quantity) {
            $product->stock -= $order->quantity;
        } else {
            // If somehow the stock is less than the order quantity, set stock to 0
            $product->stock = 0;
        }
    
        // Save the updated product stock
        $product->save();
    
        // Delete the order
        $order->delete();
    
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully and stock updated.');
    }
    
}
