<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class OrderItem extends Model
{
    use HasFactory;

    // Définir la relation entre OrderItem et Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function jsonSerialize(): mixed
    {
        return $this->convertKeysToCamelCase(parent::jsonSerialize());
    }

    protected function convertKeysToCamelCase(array $attributes): array
    {
        $converted = [];
        foreach ($attributes as $key => $value) {
            $converted[Str::camel($key)] = $value;
        }
        return $converted;
    }
}
