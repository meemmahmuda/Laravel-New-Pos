@extends('layouts.master')
@section('title', 'Sales Report')

@section('content')
<div class="container">

    <!-- Container for forms with flexbox layout -->
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <!-- Form for selecting date -->
        <form action="{{ route('sales.report') }}" method="GET" style="margin-right: 20px;">
            <div class="form-group">
                <label for="date">Select Date:</label>
                <input type="date" id="date" name="date" value="{{ $selectedDate }}" class="form-control" style="width: 200px;">
            </div>
            <button type="submit" class="btn btn-primary">Generate Date Report</button>
        </form>

        <!-- Form for selecting month -->
        <form action="{{ route('sales.report') }}" method="GET">
            <div class="form-group">
                <label for="month">Select Month:</label>
                <select id="month" name="month" class="form-control" style="width: 150px;">
                    <option value="">Select Month</option>
                    @foreach(range(1, 12) as $monthOption)
                        <option value="{{ $monthOption }}" {{ $selectedMonth == $monthOption ? 'selected' : '' }}>
                            {{ \DateTime::createFromFormat('!m', $monthOption)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Generate Month Report</button>
        </form>
    </div>

    <!-- Display report data -->
    @if (!empty($reportData))
    <table class="table table-bordered mt-4">
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

    <!-- Print PDF Button -->
    <div style="text-align: center;">
        <a href="{{ route('sales.report.pdf', ['date' => $selectedDate, 'month' => $selectedMonth]) }}" class="btn btn-success mt-3">
            Print PDF
        </a>
    </div>

    @else
    <p class="mt-4">No sales data available for the selected date or month.</p>
    @endif
</div>
@endsection
