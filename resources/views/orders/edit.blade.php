@extends('layouts.master')

@section('title', 'Edit Order & Purchase Bill')

@section('content')
<div class="container">
    <div class="row">
        <!-- Order Editing Form -->
        <div class="col-md-6">
            <h3>Edit Order</h3>
            <form id="orderForm">
                @csrf
                <div class="form-group">
                    <label for="product_id">Product</label>
                    <select id="product_id" name="product_id" class="form-control">
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->purchase_price }}" data-supplier="{{ $product->supplier->name }}"
                                {{ $product->id == $order->product_id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="supplier_name">Supplier</label>
                    <input type="text" id="supplier_name" class="form-control" value="{{ $order->supplier->name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="purchase_price">Purchase Price</label>
                    <input type="number" id="purchase_price" class="form-control" value="{{ $order->purchase_price }}" readonly>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" value="{{ $order->quantity }}" required>
                </div>
                <div class="form-group">
                    <label for="total_price">Total Price</label>
                    <input type="number" id="total_price" class="form-control" value="{{ $order->total_price }}" readonly>
                </div>
                <button type="button" class="btn btn-primary" id="updateOrder">Update Order</button>
            </form>
        </div>

        <!-- Purchase Bill Section -->
        <div class="col-md-6">
            <h3>Edit Purchase Bill</h3>
            <form id="purchaseForm" method="POST" action="{{ route('orders.update', $order->id) }}">
                @csrf
                @method('PUT')
                <table class="table table-bordered" id="orderSummary">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order->product->name }}</td>
                            <td><input type="number" value="{{ $order->quantity }}" class="form-control" readonly></td>
                            <td>{{ $order->purchase_price }}</td>
                            <td>{{ $order->total_price }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="form-group">
                    <label for="total_purchase">Total Purchase</label>
                    <input type="number" id="total_purchase" name="total_purchase" class="form-control" value="{{ $order->total_price }}" readonly>
                </div>
                <div class="form-group">
                    <label for="amount_given">Amount Given</label>
                    <input type="number" id="amount_given" name="amount_given" class="form-control" value="{{ old('amount_given', $order->amount_given) }}" required>
                </div>
                <div class="form-group">
                    <label for="amount_return">Amount Returned</label>
                    <input type="number" id="amount_return" name="amount_return" class="form-control" value="{{ old('amount_return', $order->amount_return) }}" readonly>
                </div>
                <input type="hidden" id="orderData" name="order_data" value="{{ json_encode([$order]) }}"> <!-- Hidden field for order data -->
                <button type="submit" class="btn btn-success" id="submitOrder">Update Purchase</button>
            </form>
        </div>
    </div>
</div>

<script>
    const orderSummary = document.getElementById('orderSummary').getElementsByTagName('tbody')[0];
    const totalPurchaseInput = document.getElementById('total_purchase');
    const amountGivenInput = document.getElementById('amount_given');
    const amountReturnInput = document.getElementById('amount_return');
    const orderDataInput = document.getElementById('orderData');

    let totalPurchaseAmount = parseFloat(totalPurchaseInput.value);
    
    document.getElementById('product_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        const supplier = selectedOption.getAttribute('data-supplier');

        document.getElementById('supplier_name').value = supplier;
        document.getElementById('purchase_price').value = price;
        calculateTotalPrice();
    });

    document.getElementById('quantity').addEventListener('input', calculateTotalPrice);

    document.getElementById('amount_given').addEventListener('input', calculateAmountReturn);

    function calculateTotalPrice() {
        const quantity = document.getElementById('quantity').value;
        const price = document.getElementById('purchase_price').value;
        const totalPrice = quantity * price;

        document.getElementById('total_price').value = totalPrice;
    }

    function calculateAmountReturn() {
        const amountGiven = amountGivenInput.value;
        const amountReturn = amountGiven - totalPurchaseAmount;
        amountReturnInput.value = amountReturn >= 0 ? amountReturn : 0;
    }
</script>
@endsection
