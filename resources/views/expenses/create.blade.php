@extends('layouts.master')
@section('title', 'Create Expense'
@section('content')
<div class="container">

    <form action="{{ route('expenses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="salaries_wages">Salaries and Wages</label>
            <input type="number" name="salaries_wages" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="rent">Rent</label>
            <input type="number" name="rent" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="utilities">Utilities</label>
            <input type="number" name="utilities" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="other_expenses">Other Expenses</label>
            <input type="number" name="other_expenses" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="transportation_cost">Transportation Cost</label>
            <input type="number" name="transportation_cost" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Expense</button>
    </form>
</div>
@endsection