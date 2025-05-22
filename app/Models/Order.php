<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total_cost',
        'payment_key',
        'payment_url',
        'adress',   
        'zip_code',
        'city',
        'country',
    ];

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

    // Relation Many-to-Many avec produits via la table pivot order_items
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}


    // Relation avec utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
