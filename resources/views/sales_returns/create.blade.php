@extends('layouts.master')
@section('title', 'Sales Return Create')

@section('content')

<div class="container">

    <form action="{{ route('sales_returns.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="sale_id">Select Sale</label>
            <select name="sale_id" id="sale_id" class="form-control" required>
                @foreach ($sales as $sale)
                    <option value="{{ $sale->id }}" data-quantity="{{ $sale->quantity }}">
                        {{ $sale->product->name }} - Qty Sold: {{ $sale->quantity }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity Returned</label>
            <input type="number" name="quantity" id="quantity" class="form-control" required min="1">
        </div>

        <button type="submit" class="btn btn-primary">Process Return</button>
    </form>
</div>

<script>
    document.getElementById('sale_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const maxQuantity = selectedOption.getAttribute('data-quantity');
        const quantityInput = document.getElementById('quantity');
        quantityInput.setAttribute('max', maxQuantity);
    });

    document.getElementById('quantity').addEventListener('input', function() {
        const maxQuantity = parseInt(this.getAttribute('max'), 10);
        const currentQuantity = parseInt(this.value, 10);

        if (currentQuantity > maxQuantity) {
            alert('The quantity returned cannot exceed the quantity sold.');
            this.value = maxQuantity; // Set the quantity to the maximum allowed
        }
    });
</script>

@endsection