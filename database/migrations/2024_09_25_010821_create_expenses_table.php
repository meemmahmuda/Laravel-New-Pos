<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->decimal('salaries_wages', 10, 2);
            $table->decimal('rent', 10, 2);
            $table->decimal('utilities', 10, 2);
            $table->decimal('other_expenses', 10, 2);
            $table->decimal('transportation_cost', 10, 2);
            $table->decimal('total_expense', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}