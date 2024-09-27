<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use PDF;

class SaleController extends Controller
{
    // Display a listing of the sales
// Display a listing of the sales
public function index()
{
    // Get all sales grouped by customer name
    $sales = Sale::with('product')
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy('customer_name'); // Group sales by customer name

    return view('sales.index', compact('sales'));
}
    

    // Show the form for creating a new sale
    public function create()
    {
        // Load available products
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    public function show($customerName)
    {
        // Assuming you have a Sale model with a 'customer_name' field
        $sales = Sale::where('customer_name', $customerName)->with('product')->get();
    
        // Check if there are sales for the customer
        if ($sales->isEmpty()) {
            return redirect()->route('sales.index')->with('error', 'No sales found for this customer.');
        }
    
        return view('sales.show', compact('sales', 'customerName'));
    }
    
    public function generateSalePdf($saleId)
    {
        // Fetch the sale and related customer information
        $sales = Sale::where('id', $saleId)->get();
        $customerName = $sales->first()->customer_name;
    
        // Load the view and pass the sales and customer data
        $pdf = PDF::loadView('sales.sale_pdf', compact('sales', 'customerName'));
    
        // Return the generated PDF as a download
        return $pdf->download('sale-details.pdf');
    }


    // Store a newly created sale in the database
    public function store(Request $request)
    {
        // Validate the request input
        $request->validate([
            'money_taken' => 'required|numeric|min:0',
            'sales_data' => 'required|json', // Validate the sales data as JSON
        ]);
    
        // Decode the sales data from JSON
        $salesData = json_decode($request->sales_data, true);
    
        $totalSalesAmount = 0; // Initialize total sales amount
    
        foreach ($salesData as $sale) {
            $product = Product::findOrFail($sale['product_id']);
    
            // Validate product stock
            if ($product->stock < $sale['quantity']) {
                return redirect()->back()->withErrors(['quantity' => 'The quantity cannot be greater than the available stock.']);
            }
    
            // Calculate subtotal, discount, and total price for each sale
            $subtotal = $product->selling_price * $sale['quantity'];
            $totalSalesAmount += $subtotal; // Update total sales amount
    
            // Create the new sale
            Sale::create([
                'customer_name' => $request->customer_name,
                'address' => $request->address,
                'phone_no' => $request->phone_no,
                'product_id' => $product->id,
                'quantity' => $sale['quantity'],
                'selling_price' => $product->selling_price,
                'total_price' => $subtotal,
                'discount' => $sale['discount'] ?? 0,
                'money_taken' => $request->money_taken,
                'money_returned' => max($request->money_taken - $totalSalesAmount, 0),
            ]);
    
            // Update product stock
            $product->decrement('stock', $sale['quantity']);
        }
    
        return redirect()->route('sales.index')->with('success', 'Sale created successfully!');
    }
    

    // Show the form for editing the specified sale
    public function edit(Sale $sale)
    {
        // Load available products
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.edit', compact('sale', 'products'));
    }

    // Update the specified sale in the database
    public function update(Request $request, Sale $sale)
    {
        // Validate the request input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0|max:100',
            'money_taken' => 'nullable|numeric|min:0',
        ]);

        // Find the product
        $product = Product::findOrFail($request->product_id);

        // Adjust stock only if the quantity has changed
        if ($request->quantity != $sale->quantity) {
            $product->increment('stock', $sale->quantity);  // Revert old stock
            if ($request->quantity > $product->stock) {
                return redirect()->back()->withErrors(['quantity' => 'The quantity cannot be greater than the available stock.']);
            }
            $product->decrement('stock', $request->quantity);  // Deduct new stock
        }

        // Calculate subtotal, discount, and total price
        $subtotal = $product->selling_price * $request->quantity;
        $discountAmount = ($request->discount / 100) * $subtotal;
        $totalPrice = max($subtotal - $discountAmount, 0);

        // Calculate money returned
        $moneyReturned = max($request->money_taken - $totalPrice, 0);

        // Update the sale
        $sale->update([
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'selling_price' => $product->selling_price,
            'total_price' => $totalPrice,
            'discount' => $request->discount,
            'money_taken' => $request->money_taken,
            'money_returned' => $moneyReturned,
        ]);

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }

    // Remove the specified sale from the database
    public function destroy(Sale $sale)
    {
        // Restore the product stock
        $product = Product::findOrFail($sale->product_id);
        $product->increment('stock', $sale->quantity);

        // Delete the sale
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }


    public function printInvoice($id)
    {
        $sale = Sale::findOrFail($id);

        // Load your PDF view and pass the sale data
        $pdf = PDF::loadView('sales.invoice', ['sale' => $sale]);

        return $pdf->stream('invoice.pdf'); // or use ->download('invoice.pdf') to force download
    }

  
    
public function report(Request $request)
{
    // Get the date and month from the request
    $date = $request->input('date');
    $month = $request->input('month');
    
    // Initialize the query
    $query = Sale::with('product.category');
    
    // Filter by date if provided
    if ($date) {
        // Ensure the date is in Y-m-d format
        $query->whereDate('created_at', $date);
    }
    // Filter by month if provided (ignore date)
    elseif ($month) {
        $year = now()->year;
        $startDate = "$year-$month-01";
        // Ensure the end date includes the last day of the month
        $endDate = now()->year($year)->month($month)->endOfMonth()->format('Y-m-d');
        $query->whereBetween('created_at', [$startDate, $endDate]);
    } 
    // If neither date nor month is provided, use today's date
    else {
        $date = now()->format('Y-m-d');
        $query->whereDate('created_at', $date);
    }
    
    // Fetch sales data and eager load relationships
    $sales = $query->get();
    
    // Initialize array to store report data
    $reportData = [];
    
    foreach ($sales as $sale) {
        $category = $sale->product->category->name;
        $productName = $sale->product->name;
        $unitsSold = $sale->quantity;
        $unitPrice = $sale->selling_price;
        $discount = $sale->discount;
        
        // Calculate total sales and net sales
        $subtotal = $unitPrice * $unitsSold;
        $discountAmount = ($discount / 100) * $subtotal;
        $totalSales = $subtotal;
        $netSales = $subtotal - $discountAmount;
    
        // Add data to report array
        $reportData[] = [
            'category' => $category,
            'product_name' => $productName,
            'units_sold' => $unitsSold,
            'unit_price' => number_format($unitPrice, 2),
            'discount' => number_format($discountAmount, 2),
            'total_sales' => number_format($totalSales, 2),
            'net_sales' => number_format($netSales, 2),
        ];
    }
    
    // Pass data to the view
    return view('sales.report', [
        'reportData' => $reportData,
        'selectedDate' => $date,
        'selectedMonth' => $month
    ]);
}

}