<?php

namespace App\Http\Controllers;

use App\Models\SalesReturn;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;

class SalesReturnController extends Controller
{
    public function index()
    {
        $salesReturns = SalesReturn::with('sale.product')->orderBy('created_at', 'desc')->get();
        return view('sales_returns.index', compact('salesReturns'));
    }

    public function create()
    {
        $sales = Sale::with('product')->get();
        return view('sales_returns.create', compact('sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $sale = Sale::findOrFail($request->sale_id);
        $product = $sale->product;
        $quantityReturned = $request->quantity;

        if ($quantityReturned > $sale->quantity) {
            return redirect()->back()->withErrors(['quantity' => 'The quantity returned cannot exceed the quantity sold.']);
        }

        // Calculate the total price for the returned items
        $returnedSubtotal = $sale->selling_price * $quantityReturned;
        $discountAmount = ($sale->discount / 100) * $returnedSubtotal;
        $returnedTotalPrice = $returnedSubtotal - $discountAmount;

        // Create the sales return record
        SalesReturn::create([
            'sale_id' => $sale->id,
            'quantity' => $quantityReturned,
            'total_price' => $returnedTotalPrice,
        ]);

        // Update the product stock by adding the returned quantity
        $product->increment('stock', $quantityReturned);

        // Deduct the returned amount from the sale's total price
        $sale->total_price -= $returnedTotalPrice;
        $sale->quantity -= $quantityReturned;
        $sale->save();

        return redirect()->route('sales_returns.index')->with('success', 'Sales return processed successfully!');
    }

    public function destroy(SalesReturn $salesReturn)
    {
        $sale = $salesReturn->sale;

        // Revert the total price in the sale
        $sale->total_price += $salesReturn->total_price;
        $sale->quantity += $salesReturn->quantity;
        $sale->save();

        // Restore the stock
        $salesReturn->sale->product->decrement('stock', $salesReturn->quantity);

        // Delete the sales return record
        $salesReturn->delete();

        return redirect()->route('sales_returns.index')->with('success', 'Sales return deleted successfully.');
    }
}