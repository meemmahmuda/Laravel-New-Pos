<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturn extends Model
{
    protected $fillable = [
        'sale_id', 'quantity', 'total_price',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}