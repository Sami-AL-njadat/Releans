<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stockTracking extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'quantities', 'type', 'description', 'reason'];



    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function sales()
    {
        return $this->hasMany(sales::class);
    }
}
