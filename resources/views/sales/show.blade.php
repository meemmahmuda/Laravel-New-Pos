@extends('layouts.master')

@section('title', 'Sale Details')

@section('content')
<div class="container">
    <h3>Sales Details for {{ $customerName }}</h3>
    <div class="card">
        <div class="card-body">
            <h5>Sale Records</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sale ID</th>
                        <th>Sale Date</th>
                        <th>Product Name</th> <!-- New column for Product Name -->
                        <th>Quantity</th>
                        <th>Selling Price</th>
                        <th>Discount</th>
                        <th>Total Price</th>
                        <th>Money Taken</th>
                        <th>Money Returned</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPrice = 0; // Initialize total price variable
                        $totalMoneyTaken = 0; // Initialize total money taken variable
                        $totalMoneyReturned = 0; // Initialize total money returned variable
                    @endphp
                    @foreach($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->created_at->format('d-m-Y H:i:s') }}</td>
                            <td>{{ $sale->product->name ?? 'N/A' }}</td> <!-- Display the product name -->
                            <td>{{ $sale->quantity }}</td>
                            <td>{{ $sale->selling_price }}</td>
                            <td>{{ $sale->discount }}%</td>
                            <td>{{ $sale->total_price }}</td>
                            <td>{{ $sale->money_taken }}</td>
                            <td>{{ $sale->money_returned }}</td>
                        </tr>
                        @php
                            $totalPrice += $sale->total_price; // Accumulate total price
                            $totalMoneyTaken += $sale->money_taken; // Accumulate total money taken
                            $totalMoneyReturned += $sale->money_returned; // Accumulate total money returned
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-right"><strong>Total Price:</strong></td>
                        <td>{{ $totalPrice }}</td> 
                        <td>{{ $totalMoneyTaken }}</td> <!-- Display the total money taken -->
                        <td>{{ $totalMoneyReturned }}</td> <!-- Display the total money returned -->
                    </tr>
                </tfoot>
            </table>

            <div class="mt-3">
                <a href="{{ route('sales.sale_pdf', $sales->first()->id) }}" class="btn btn-success" target="_blank">Download PDF</a>
            </div>
        </div>
    </div>
</div>
@endsection
