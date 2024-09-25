<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // If your table name is not 'orders', specify it explicitly
    protected $table = 'orders';

    // Specify the fillable properties for mass assignment
    protected $fillable = [
        'product_id',
        'supplier_id',
        'quantity',
        'purchase_price',
        'total_price',
        'amount_given',
        'amount_return'
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
