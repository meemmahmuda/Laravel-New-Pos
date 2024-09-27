<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use PDF;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->get();
        return view('suppliers.index', compact('suppliers'));
    }

    public function printSupplierDetails($id)
    {
        $supplier = Supplier::with('orders.product')->findOrFail($id);
    
        // Load the PDF view and pass the supplier data
        $pdf = PDF::loadView('suppliers.pdf', compact('supplier'));
    
        return $pdf->stream('supplier-details.pdf'); // or use ->download('supplier-details.pdf') to force download
    }

    public function show($id)
    {
        $supplier = Supplier::with('orders.product')->findOrFail($id);
        return view('suppliers.show', compact('supplier'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')
        ->with('success', 'Supplier created successfully.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        $supplier->update($request->all());

        return redirect()->route('suppliers.index')
        ->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')
        ->with('success', 'Supplier deleted successfully.');
    }
}