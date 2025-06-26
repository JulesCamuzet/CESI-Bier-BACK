<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    public function jsonSerialize(): mixed
{
  return $this->convertKeysToCamelCase(parent::jsonSerialize());
}

protected $fillable = [
        'name',
    ];

    protected function convertKeysToCamelCase(array $attributes): array
    {
        $converted = [];
        foreach ($attributes as $key => $value) {
            $converted[Str::camel($key)] = $value;
        }
        return $converted;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
