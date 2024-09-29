<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale Details PDF</title>
    <style>
        body {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h3 class="text-center">Sales Details for {{ $customerName }}</h3>

    <h5>Sale Records</h5>
    <table>
        <thead>
            <tr>
                <th>Sale ID</th>
                <th>Sale Date</th>
                <th>Product Name</th> <!-- Added Product Name column -->
                <th>Quantity</th>
                <th>Selling Price</th>
                <th>Discount</th>
                <th>Total Price</th>
                <th>Money Taken</th>
                <th>Money Returned</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPrice = 0;
                $totalMoneyTaken = 0;
                $totalMoneyReturned = 0;
            @endphp
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->created_at->format('d-m-Y H:i:s') }}</td>
                    <td>{{ $sale->product->name ?? 'N/A' }}</td> <!-- Display the product name -->
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ $sale->selling_price }}</td>
                    <td>{{ $sale->discount }}%</td>
                    <td>{{ $sale->total_price }}</td>
                    <td>{{ $sale->money_taken }}</td>
                    <td>{{ $sale->money_returned }}</td>
                </tr>
                @php
                    $totalPrice += $sale->total_price;
                    $totalMoneyTaken += $sale->money_taken;
                    $totalMoneyReturned += $sale->money_returned;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right"><strong>Total Price:</strong></td>
                <td>{{ $totalPrice }}</td>
                <td>{{ $totalMoneyTaken }}</td>
                <td>{{ $totalMoneyReturned }}</td>
                <td>{{ $totalMoneyReturned }}</td>
            </tr>
        </tfoot>
    </table>

    <h5>Customer Information</h5>
    <p><strong>Name:</strong> {{ $sales->first()->customer_name }}</p>
    <p><strong>Address:</strong> {{ $sales->first()->address }}</p>
    <p><strong>Phone No:</strong> {{ $sales->first()->phone_no }}</p>

    <h5>Sale Date</h5>
    <p><strong>Date:</strong> {{ $sales->first()->created_at->format('d-m-Y H:i:s') }}</p>

    <h5>Payment Information</h5>
    <p><strong>Money Taken:</strong> {{ $totalMoneyTaken }}</p>
    <p><strong>Money Returned:</strong> {{ $totalMoneyReturned }}</p>
</body>
</html>
