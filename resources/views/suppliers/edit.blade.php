@extends('layouts.master')

@section('title', 'Edit Supplier')

@section('content')
    <div class="container">

        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" value="{{ $supplier->name }}" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <textarea name="address" class="form-control">{{ $supplier->address }}</textarea>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="number" name="phone" class="form-control" value="{{ $supplier->phone }}" required>
            </div>

            <button type="submit" class="btn btn-success">Update Supplier</button>
        </form>
    </div>
@endsection