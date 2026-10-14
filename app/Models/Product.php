<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
	use HasFactory, softdeletes; 

	protected $fillable=[
		'sku',
		'name',
		'category',
		'unit',
		'price',
		'stock',
		'photo',
		'user_id'
	];

    public function stockMutations()
    {
    	return $this->hasMany(StockMutation::class);
    }

    public function User()
    {
    	return $this->belongsTo(User::class);
    }
}
