{{-- Existing supplier details view --}}
@extends('layouts.master')

@section('title', 'Supplier Details')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Supplier: {{ $supplier->name }}</h3>
            <p>Phone: {{ $supplier->phone }}</p>
            <p>Date: {{ now()->format('Y-m-d') }}</p>

            <a href="{{ route('suppliers.print', $supplier->id) }}" class="btn btn-primary" target="_blank">Print Invoice</a>

            <h4>Purchase Products</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Purchase Price</th>
                        <th>Total Price</th>
                        <th>Amount Given</th>
                        <th>Amount Returned</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $overallTotalPrice = 0; // Initialize total price
                        $totalAmountGiven = 0; // Initialize total amount given
                    @endphp
                    @forelse($supplier->orders as $order)
                        @php
                            $totalPrice = $order->quantity * $order->purchase_price; // Calculate individual total price
                            $overallTotalPrice += $totalPrice; // Add to overall total
                            $totalAmountGiven += $order->amount_given; // Add to total amount given
                        @endphp
                        <tr>
                            <td>{{ $order->product->name }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ number_format($order->purchase_price, 2) }}</td>
                            <td>{{ number_format($totalPrice, 2) }}</td> <!-- Individual Total Price -->
                            <td>{{ number_format($order->amount_given, 2) }}</td> <!-- Display amount given for each order -->
                            <td>{{ number_format($order->amount_given - $totalPrice, 2) }}</td> <!-- Amount Returned Calculation -->
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No orders found for this supplier.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Overall Total Price:</th>
                        <th>{{ number_format($overallTotalPrice, 2) }}</th> <!-- Overall Total Price -->
                        <th>{{ number_format($totalAmountGiven, 2) }}</th> <!-- Total Amount Given -->
                        <th>{{ number_format($totalAmountGiven - $overallTotalPrice, 2) }}</th> <!-- Total Amount Returned -->
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
