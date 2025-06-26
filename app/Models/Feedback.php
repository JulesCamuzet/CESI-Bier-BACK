<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Feedback extends Model
{
    use HasFactory;

   
    public function jsonSerialize(): mixed
{
  return $this->convertKeysToCamelCase(parent::jsonSerialize());
}

protected $fillable = [
        'title',
        'content',
        'rate',
        'user_id',
        'product_id',
    ];

    protected function convertKeysToCamelCase(array $attributes): array
    {
        $converted = [];
        foreach ($attributes as $key => $value) {
            $converted[Str::camel($key)] = $value;
        }
        return $converted;
    }

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

  
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
