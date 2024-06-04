<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'maximum_stock',
        'stock',
        'minimum_stock',
        'minimum_stock_unit',
        'notified',
        'unit',
        'description',
    ];
    
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
