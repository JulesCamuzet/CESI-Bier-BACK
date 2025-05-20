<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Supplier extends Model
{
    use HasFactory;

    public function jsonSerialize(): mixed
{
  return $this->convertKeysToCamelCase(parent::jsonSerialize());
}

protected $fillable = [
        'name',
        'description',
        'picture',
        'location',
    ];

    protected function convertKeysToCamelCase(array $attributes): array
    {
        $converted = [];
        foreach ($attributes as $key => $value) {
            $converted[Str::camel($key)] = $value;
        }
        return $converted;
    }

    // Relations possibles
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
