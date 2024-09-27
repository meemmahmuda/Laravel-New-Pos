<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('address');
            $table->string('phone_no');
            $table->unsignedBigInteger('product_id'); // Change to unsignedBigInteger
            $table->integer('quantity');
            $table->decimal('selling_price', 10, 2);
            $table->decimal('discount', 10, 2)->default(0)->nullable();
            $table->decimal('total_price', 10, 2); // Calculate this in application logic
            $table->decimal('money_taken', 10, 2)->nullable(); // Made nullable
            $table->decimal('money_returned', 10, 2)->nullable(); // Made nullable
            $table->timestamps();
        
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
