<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sales extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'product_id', 'trans_id', 'total_price'];

    public function product()
    {
        return $this->belongsTo(Product::class , 'product_id');
    }



    public function user()
    {
        return $this->belongsTo(User::class , 'user_id') ;
    }

    public function stock()
    {
        return $this->belongsTo(stockTracking::class , 'trans_id') ;
    }
}