@extends('layouts.master')
@section('title', 'Edit Expense')

@section('content')
<div class="container">

    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="salaries_wages">Salaries and Wages</label>
            <input type="number" name="salaries_wages" value="{{ $expense->salaries_wages }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="rent">Rent</label>
            <input type="number" name="rent" value="{{ $expense->rent }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="utilities">Utilities</label>
            <input type="number" name="utilities" value="{{ $expense->utilities }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="other_expenses">Other Expenses</label>
            <input type="number" name="other_expenses" value="{{ $expense->other_expenses }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="transportation_cost">Transportation Cost</label>
            <input type="number" name="transportation_cost" value="{{ $expense->transportation_cost }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Expense</button>
    </form>
</div>
@endsection