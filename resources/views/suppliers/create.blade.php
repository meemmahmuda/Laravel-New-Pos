@extends('layouts.master')

@section('title', 'Add New Supplier')

@section('content')
    <div class="container">

        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <textarea name="address" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="number" name="phone" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Add Supplier</button>
        </form>
    </div>
@endsection