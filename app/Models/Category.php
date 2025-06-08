<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'product_id',
        'category',
        'price',
        'stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withPivot('price');
    }
}
