<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Inventory;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'id',
        'name',
        'image',
        'quantity',
        'minimum_level',
        'status',
        'price',
        'description',
    ];

    public function inventory()
    {
        return $this->hasOne(inventory::class);
    }

    public function stock()
    {
        return $this->hasMany(stockTracking::class);
    }

    public function sales()
    {
        return $this->hasMany(sales::class);
    }
}
