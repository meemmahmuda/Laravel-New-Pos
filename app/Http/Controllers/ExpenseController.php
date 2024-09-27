<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        // Get all expenses
        $expenses = Expense::orderBy('created_at', 'desc')->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        // Return the form view
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'salaries_wages' => 'required|numeric',
            'rent' => 'required|numeric',
            'utilities' => 'required|numeric',
            'other_expenses' => 'required|numeric',
            'transportation_cost' => 'required|numeric',
        ]);

        // Create new expense and calculate total
        $expense = new Expense($request->all());
        $expense->total_expense = $expense->calculateTotalExpense();
        $expense->save();

        return redirect()->route('expenses.index')->with('success', 'Expense created successfully');
    }

    public function edit(Expense $expense)
    {
        // Return the edit form
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        // Validate input
        $request->validate([
            'salaries_wages' => 'required|numeric',
            'rent' => 'required|numeric',
            'utilities' => 'required|numeric',
            'other_expenses' => 'required|numeric',
            'transportation_cost' => 'required|numeric',
        ]);

        // Update expense and recalculate total
        $expense->update($request->all());
        $expense->total_expense = $expense->calculateTotalExpense();
        $expense->save();

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully');
    }

    public function destroy(Expense $expense)
    {
        // Delete expense
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully');
    }
}