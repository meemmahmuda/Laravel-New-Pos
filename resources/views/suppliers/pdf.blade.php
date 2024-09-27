<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Details</title>
    <link rel="stylesheet" href="{{ public_path('css/app.css') }}"> <!-- Optional: Include your CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        h3, h4 {
            color: #0056b3;
        }

        h1 {
            text-align: center;
        }

        .container {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #eaeaea;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Purchase Invoice</h1>
        <h3>Supplier: {{ $supplier->name }}</h3>
        <p>Phone: {{ $supplier->phone }}</p>
        <p>Date: {{ now()->format('Y-m-d') }}</p>

        <h4>Purchase Products</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Purchase Price</th>
                    <th>Total Price</th>
                    <th>Amount Given</th>
                    <th>Amount Returned</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $overallTotalPrice = 0; // Initialize overall total price
                    $totalAmountGiven = 0; // Initialize total amount given
                @endphp
                @forelse($supplier->orders as $order)
                    @php
                        $totalPrice = $order->quantity * $order->purchase_price; // Calculate individual total price
                        $overallTotalPrice += $totalPrice; // Add to overall total price
                        $totalAmountGiven += $order->amount_given; // Add to total amount given
                    @endphp
                    <tr>
                        <td>{{ $order->product->name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ number_format($order->purchase_price, 2) }}</td>
                        <td>{{ number_format($totalPrice, 2) }}</td>
                        <td>{{ number_format($order->amount_given, 2) }}</td>
                        <td>{{ number_format($order->amount_given - $totalPrice, 2) }}</td> <!-- Calculate amount returned -->
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No orders found for this supplier.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Overall Total Price:</th>
                    <th>{{ number_format($overallTotalPrice, 2) }}</th> <!-- Overall Total Price -->
                    <th>{{ number_format($totalAmountGiven, 2) }}</th> <!-- Total Amount Given -->
                    <th>{{ number_format($totalAmountGiven - $overallTotalPrice, 2) }}</th> <!-- Total Amount Returned -->
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
