<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

	protected $guarded = [];

	protected $hidden = [];

	public function products()
	{
		return $this->belongsToMany(Product::class, OrderProduct::class);
	}
}
