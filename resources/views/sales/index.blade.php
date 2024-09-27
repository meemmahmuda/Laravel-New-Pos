@extends('layouts.master')

@section('title', 'Sales List')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-3">
                <a href="{{ route('sales.create') }}" class="btn btn-primary">Create Sale</a> <!-- Create Sale Button -->
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($sales as $customerName => $customerSales)
    <tr>
        <td>{{ $customerName }}</td>
        <td>
        <a href="{{ route('sales.show', $customerName) }}" class="btn btn-info btn-sm">Details</a>

            
            <!-- Assuming you're deleting the first sale of the customer -->
            <form action="{{ route('sales.destroy', $customerSales->first()->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this sale?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="2" class="text-center">No sales found.</td>
    </tr>
@endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
