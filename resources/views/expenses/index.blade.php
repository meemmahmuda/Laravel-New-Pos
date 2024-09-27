@extends('layouts.master')
@section('title', 'Expense List')

@section('content')
<div class="container">
    <a href="{{ route('expenses.create') }}" class="btn btn-primary">Add New Expense</a>

    <table class="table table-bordered mt-3">
        <thead>
            <tr style="text-align: center;">
                <th>SL No.</th>
                <th>Salaries and Wages</th>
                <th>Rent</th>
                <th>Utilities</th>
                <th>Other Expenses</th>
                <th>Transportation Cost</th>
                <th>Total Expense</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $expense->salaries_wages }}</td>
                <td>{{ $expense->rent }}</td>
                <td>{{ $expense->utilities }}</td>
                <td>{{ $expense->other_expenses }}</td>
                <td>{{ $expense->transportation_cost }}</td>
                <td>{{ $expense->total_expense }}</td>
                <td style="text-align: center;">
                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection