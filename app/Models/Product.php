<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',

        'image',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
