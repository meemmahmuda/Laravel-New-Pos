@extends('layouts.master')

@section('title', 'Purchases List')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Create New Order</a> -->
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Supplier</th>
                        <th>Quantity</th>
                        <th>Purchase Price</th>
                        <th>Total Price</th>
                        <th>Amount Given</th>
                        <th>Amount Returned</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->product->name }}</td>
                            <td>{{ $order->product->supplier->name }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->purchase_price }}</td>
                            <td>{{ $order->total_price }}</td>
                            <td>{{ $order->amount_given }}</td>
                            <td>{{ $order->amount_return }}</td>
                            <td>
                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
