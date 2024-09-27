@extends('layouts.master')

@section('title', 'Purchases List')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->name }}</td>
                            <td>
                                <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-info btn-sm">Details</a>
                                
                                <!-- Delete button -->
                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">No suppliers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
