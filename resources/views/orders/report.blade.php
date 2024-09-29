@extends('layouts.master')
@section('title', 'Purchase Report')

@section('content')
<div class="container">

    <!-- Container for forms with flexbox layout -->
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <!-- Form for selecting date -->
        <form action="{{ route('orders.report') }}" method="GET" style="margin-right: 20px;">
            <div class="form-group">
                <label for="date">Select Date:</label>
                <input type="date" id="date" name="date" value="{{ $selectedDate }}" class="form-control" style="width: 200px;">
            </div>
            <button type="submit" class="btn btn-primary">Generate Date Report</button>
        </form>

        <!-- Form for selecting month -->
        <form action="{{ route('orders.report') }}" method="GET">
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

    <!-- Display report data if available -->
    @if (!empty($reportData))
    <table class="table table-bordered mt-4">
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

    <!-- Print PDF Button -->
    <div style="text-align: center;">
        <a href="{{ route('orders.report.pdf', ['date' => $selectedDate, 'month' => $selectedMonth]) }}" class="btn btn-success mt-3">
            Print PDF
        </a>
    </div>

    @else
    <p class="mt-4">No orders available for the selected date or month.</p>
    @endif
</div>

<!-- JavaScript to clear form and handle input conflict -->
<script>
    document.getElementById('date').addEventListener('input', function() {
        document.getElementById('month').value = ''; // Clear month if date is selected
    });

    document.getElementById('month').addEventListener('input', function() {
        document.getElementById('date').value = ''; // Clear date if month is selected
    });

    document.getElementById('clearForm').addEventListener('click', function() {
        document.getElementById('reportForm').reset();
    });
</script>
@endsection
