@extends('layouts.master')

@section('title', 'Create Sale & Sales Bill')

@section('content')
<div class="container">
    <div class="row">
        <!-- Sale Creation Form -->
        <div class="col-md-6">
            <h3>Create Sale</h3>
            <form id="saleForm">
                @csrf
                <div class="form-group">
                    <label for="customer_name">Customer Name</label>
                    <input type="text" id="customer_name" name="customer_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="phone_no">Phone No</label>
                    <input type="number" id="phone_no" name="phone_no" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="product_id">Product</label>
                    <select id="product_id" name="product_id" class="form-control">
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-stock="{{ $product->stock }}">
                                {{ $product->name }} (Stock: {{ $product->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="selling_price">Selling Price</label>
                    <input type="number" id="selling_price" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="discount">Discount (%)</label>
                    <input type="number" id="discount" class="form-control" placeholder="Enter discount percentage">
                </div>
                <div class="form-group">
                    <label for="total_price">Total Price</label>
                    <input type="number" id="total_price" class="form-control" readonly>
                </div>
                <button type="button" class="btn btn-primary" id="addSale">Add Sale</button>
            </form>
        </div>

        <!-- Sales Bill Section -->
        <div class="col-md-6">
            <h3>Sales Bill</h3>
            <form id="salesBillForm" method="POST" action="{{ route('sales.store') }}">
                @csrf
                <table class="table table-bordered" id="salesSummary">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic sales rows will go here -->
                    </tbody>
                </table>

                <div class="form-group">
                    <label for="total_sales">Total Sales</label>
                    <input type="number" id="total_sales" name="total_sales" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="money_taken">Money Taken</label>
                    <input type="number" id="money_taken" name="money_taken" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="money_returned">Money Returned</label>
                    <input type="number" id="money_returned" name="money_returned" class="form-control" readonly>
                </div>
                
                <!-- Hidden fields for customer details -->
                <input type="hidden" id="customer_name_input" name="customer_name">
                <input type="hidden" id="address_input" name="address">
                <input type="hidden" id="phone_no_input" name="phone_no">
                
                <input type="hidden" id="salesData" name="sales_data"> <!-- Hidden field for sales data -->
                <button type="submit" class="btn btn-success" id="submitSales">Submit Sale</button>
            </form>
        </div>
    </div>
</div>

<script>
    const salesSummary = document.getElementById('salesSummary').getElementsByTagName('tbody')[0];
    const totalSalesInput = document.getElementById('total_sales');
    const moneyTakenInput = document.getElementById('money_taken');
    const moneyReturnedInput = document.getElementById('money_returned');
    const salesDataInput = document.getElementById('salesData');

    let totalSalesAmount = 0;
    let sales = []; // This will hold the created sales

    document.getElementById('product_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const sellingPrice = selectedOption.getAttribute('data-price');
        document.getElementById('selling_price').value = sellingPrice;
        calculateTotalPrice();
    });

    document.getElementById('quantity').addEventListener('input', calculateTotalPrice);
    document.getElementById('discount').addEventListener('input', calculateTotalPrice);
    document.getElementById('money_taken').addEventListener('input', calculateMoneyReturned);

    document.getElementById('addSale').addEventListener('click', function () {
        const productSelect = document.getElementById('product_id');
        const productName = productSelect.options[productSelect.selectedIndex].text;
        const productId = productSelect.value;
        const quantity = document.getElementById('quantity').value;
        const sellingPrice = document.getElementById('selling_price').value;
        const totalPrice = document.getElementById('total_price').value;
        const discount = document.getElementById('discount').value;

        if (!productId || !quantity || !sellingPrice) {
            alert('Please select a product and enter quantity.');
            return;
        }

        // Add sale to summary
        const newRow = salesSummary.insertRow();
        newRow.innerHTML = `
            <td>${productName}</td>
            <td>${quantity}</td>
            <td>${sellingPrice}</td>
            <td>${discount}</td>
            <td>${totalPrice}</td>
        `;

        // Update total sales amount
        totalSalesAmount += parseFloat(totalPrice);
        totalSalesInput.value = totalSalesAmount;

        // Add sale to sales array
        sales.push({
            product_id: productId,
            quantity: quantity,
            price: sellingPrice,
            discount: discount,
            total_price: totalPrice
        });

        // Reset form for the next sale
        document.getElementById('product_id').value = '';
        document.getElementById('selling_price').value = '';
        document.getElementById('quantity').value = '';
        document.getElementById('total_price').value = '';
        document.getElementById('discount').value = '';

        calculateMoneyReturned();
    });

    document.getElementById('salesBillForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Set the values for the hidden fields
        document.getElementById('customer_name_input').value = document.getElementById('customer_name').value;
        document.getElementById('address_input').value = document.getElementById('address').value;
        document.getElementById('phone_no_input').value = document.getElementById('phone_no').value;

        // Set the sales data into the hidden input field
        salesDataInput.value = JSON.stringify(sales);

        // Check if any sales are added before submission
        if (sales.length === 0) {
            alert('Please add at least one sale before submitting.');
            return;
        }

        // Submit the form after setting the sales data
        this.submit();
    });

    function calculateTotalPrice() {
        const quantity = document.getElementById('quantity').value;
        const sellingPrice = document.getElementById('selling_price').value;
        const discount = document.getElementById('discount').value;

        let totalPrice = quantity * sellingPrice;

        if (discount) {
            totalPrice -= (totalPrice * (discount / 100));
        }

        document.getElementById('total_price').value = totalPrice;
    }

    function calculateMoneyReturned() {
        const moneyTaken = moneyTakenInput.value;
        const moneyReturned = moneyTaken - totalSalesAmount;
        moneyReturnedInput.value = moneyReturned >= 0 ? moneyReturned : 0;
    }
</script>
@endsection
