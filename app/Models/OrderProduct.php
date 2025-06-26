<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_products'; 

    public function jsonSerialize(): mixed
{
  return $this->convertKeysToCamelCase(parent::jsonSerialize());
}

protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
    ];

    protected function convertKeysToCamelCase(array $attributes): array
    {
        $converted = [];
        foreach ($attributes as $key => $value) {
            $converted[Str::camel($key)] = $value;
        }
        return $converted;
    }

    public $timestamps = false; 

    // Relations
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
