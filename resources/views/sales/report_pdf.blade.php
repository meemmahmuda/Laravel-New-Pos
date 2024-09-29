<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Sales Report</h2>
    <p>Date: {{ $date ?? 'N/A' }}</p>
    <p>Month: {{ $month ?? 'N/A' }}</p>

    @if (!empty($reportData))
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Product Name</th>
                <th>Units Sold</th>
                <th>Unit Price</th>
                <th>Discount</th>
                <th>Total Sales</th>
                <th>Net Sales</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $data)
            <tr>
                <td>{{ $data['category'] }}</td>
                <td>{{ $data['product_name'] }}</td>
                <td>{{ $data['units_sold'] }}</td>
                <td>TK {{ $data['unit_price'] }}</td>
                <td>TK {{ $data['discount'] }}</td>
                <td>TK {{ $data['total_sales'] }}</td>
                <td>TK {{ $data['net_sales'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No sales data available.</p>
    @endif
</body>
</html>
