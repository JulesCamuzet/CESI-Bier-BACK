<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = 'products';

    /**
     * Sérialisation personnalisée : camelCase pour l'output JSON
     */
    public function jsonSerialize(): mixed
    {
        return $this->convertKeysToCamelCase(parent::jsonSerialize());
    }


    protected $fillable = [
        'name',
        'price',
        'description',
        'stock',
        'picture',
        'status',
        'supplier_id',
        'category_id',

    ];

    /**
     * Convertit les clés snake_case en camelCase
     */
    protected function convertKeysToCamelCase(array $attributes): array
    {
        $converted = [];
        foreach ($attributes as $key => $value) {
            $converted[Str::camel($key)] = $value;
        }
        return $converted;
    }

    // Relations
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')
            ->withPivot('quantity');
    }
}
