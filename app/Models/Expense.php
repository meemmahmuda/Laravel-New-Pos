<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'salaries_wages',
        'rent',
        'utilities',
        'other_expenses',
        'transportation_cost',
        'total_expense'
    ];

    // Calculate total expense automatically
    public function calculateTotalExpense()
    {
        return $this->salaries_wages + $this->rent + $this->utilities + $this->other_expenses + $this->transportation_cost;
    }
}