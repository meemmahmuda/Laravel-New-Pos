
@extends('layouts.master')

@section('title', 'Products List')

@section('content')
    <div class="container">
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-bordered mt-3">
            <thead>
                <tr style="text-align: center;">
                    <th>SL No.</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Supplier</th>
                    <th>Category</th>
                    <th>Purchase Price</th>
                    <th>Selling Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <!-- Check if the stock is 10 or less, if so apply the 'table-danger' class -->
                    <tr class="{{ $product->stock <= 10 ? 'table-danger' : '' }}">
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->supplier->name ?? 'N/A' }}</td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td>{{ $product->purchase_price }}</td>
                        <td>{{ $product->selling_price }}</td>
                        <td>{{ $product->stock ?? 'N/A' }}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
