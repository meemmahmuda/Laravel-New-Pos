<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'customer_name', 'address', 'phone_no', 'product_id', 'quantity', 
        'selling_price', 'discount', 'total_price', 'money_taken', 'money_returned'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}