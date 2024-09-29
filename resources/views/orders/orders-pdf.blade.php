<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Report PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Purchase Report</h2>

    @if($date)
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($date)->format('d M, Y') }}</p>
    @elseif($month)
        <p><strong>Month:</strong> {{ \DateTime::createFromFormat('!m', $month)->format('F') }}</p>
    @endif

    @if (!empty($reportData))
    <table>
        <thead>
            <tr>
                <th>Supplier</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Purchase Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $data)
                <tr>
                    <td>{{ $data['supplier'] }}</td>
                    <td>{{ $data['product_name'] }}</td>
                    <td>{{ $data['quantity'] }}</td>
                    <td>TK {{ $data['purchase_price'] }}</td>
                    <td>TK {{ $data['total_price'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @else
    <p>No orders available for the selected date or month.</p>
    @endif
</div>

</body>
</html>
