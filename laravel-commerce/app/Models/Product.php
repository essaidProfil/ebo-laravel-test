<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    // Définir les champs qui peuvent être assignés en masse
    protected $fillable = ['name', 'description', 'price', 'stock'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
}

