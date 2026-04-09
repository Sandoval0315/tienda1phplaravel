<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'category', 'brand', 
        'stock', 'image', 'sizes', 'colors'
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'price' => 'decimal:2'
    ];
}