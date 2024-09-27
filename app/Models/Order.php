<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Specify the fillable properties for mass assignment
    protected $fillable = [
        'product_id',
        'supplier_id',
        'quantity',
        'purchase_price',
        'total_price',
        'amount_given',   // New field for amount given
        'amount_return'   // New field for amount returned
    ];

    // Define the relationship to the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Define the relationship to the Supplier model
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
