<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory; // Don't forget to include the HasFactory trait if you're using factories

    protected $fillable = [
        'customer_name', 'address', 'phone_no', 'product_id', 'quantity', 
        'selling_price', 'discount', 'total_price', 'money_taken', 'money_returned'
    ];

    // Define the relationship to a single product
    public function product()
    {
        return $this->belongsTo(Product::class); // This establishes a belongsTo relationship with Product
    }
}
