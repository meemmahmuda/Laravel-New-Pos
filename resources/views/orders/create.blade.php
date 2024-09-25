@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Create Multiple Orders</h1>
    <form action="{{ route('orders.store') }}" method="POST" id="order-form">
        @csrf

        <div id="orders-container">
            <div class="order-item">
                <h3>Order Item</h3>
                <label for="product_id">Product:</label>
                <select name="orders[0][product_id]" required>
                    <!-- Populate with products -->
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>

                <label for="supplier_id">Supplier:</label>
                <select name="orders[0][supplier_id]" required>
                    <!-- Populate with suppliers -->
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>

                <label for="quantity">Quantity:</label>
                <input type="number" name="orders[0][quantity]" min="1" required>

                <label for="purchase_price">Purchase Price:</label>
                <input type="number" name="orders[0][purchase_price]" min="0" required>

                <label for="amount_given">Amount Given:</label>
                <input type="number" name="orders[0][amount_given]">

                <label for="amount_return">Amount Return:</label>
                <input type="number" name="orders[0][amount_return]">

                <button type="button" class="remove-order">Remove Order</button>
            </div>
        </div>

        <button type="button" id="add-order">Add Another Order</button>
        <button type="submit">Submit Orders</button>
    </form>
</div>

<script>
    let orderIndex = 1;

    document.getElementById('add-order').addEventListener('click', function() {
        const container = document.getElementById('orders-container');
        const newOrder = document.createElement('div');
        newOrder.classList.add('order-item');
        newOrder.innerHTML = `
            <h3>Order Item</h3>
            <label for="product_id">Product:</label>
            <select name="orders[${orderIndex}][product_id]" required>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>

            <label for="supplier_id">Supplier:</label>
            <select name="orders[${orderIndex}][supplier_id]" required>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>

            <label for="quantity">Quantity:</label>
            <input type="number" name="orders[${orderIndex}][quantity]" min="1" required>

            <label for="purchase_price">Purchase Price:</label>
            <input type="number" name="orders[${orderIndex}][purchase_price]" min="0" required>

            <label for="amount_given">Amount Given:</label>
            <input type="number" name="orders[${orderIndex}][amount_given]">

            <label for="amount_return">Amount Return:</label>
            <input type="number" name="orders[${orderIndex}][amount_return]">

            <button type="button" class="remove-order">Remove Order</button>
        `;
        container.appendChild(newOrder);
        orderIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-order')) {
            e.target.parentElement.remove();
        }
    });
</script>
@endsection
