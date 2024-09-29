@extends('layouts.master')
@section('title', 'Sales Return List')

@section('content')

<div class="container">
    <a href="{{ route('sales_returns.create') }}" class="btn btn-primary">Add Sales Return</a>
    <table class="table table-bordered mt-3">
        <thead>
            <tr style="text-align: center;">
                <th>Sale ID</th>
                <th>Product Name</th>
                <th>Quantity Returned</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salesReturns as $return)
                <tr>
                    <td style="text-align: center;">{{ $return->sale->id }}</td>
                    <td>{{ $return->sale->product->name }}</td>
                    <td style="text-align: center;">{{ $return->quantity }}</td>
                    <td>{{ $return->total_price }}</td>
                    <td style="text-align: center;">
                        <form action="{{ route('sales_returns.destroy', $return->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection