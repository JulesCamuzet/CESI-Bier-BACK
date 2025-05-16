<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;

   
    protected $fillable = [
        'title',
        'content',
        'rate',
        'user_id',
        'product_id',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

  
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
