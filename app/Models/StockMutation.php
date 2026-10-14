<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMutation extends Model
{
    use HasFactory, softdeletes;

    protected $fillable=[
    	'product_id',
    	'user_id',
    	'type',
    	'quantity',
    	'stock_before',
    	'stock_after',
    	'notes',
    	'photo',
    ];

    public function Product()
    {
    	return $this->belongsTo(Product::class);
    }

    public function User()
    {
    	return $this->belongsTo(User::class);
    }

}
