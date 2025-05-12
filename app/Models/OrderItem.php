<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    // Définir la relation entre OrderItem et Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
