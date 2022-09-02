<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

	protected $guarded = [];

	protected $hidden = [];

	public function generateToken()
	{
		$this->api_token = Str::uuid();
		$this->save();
	}

	public function removeToken()
	{
		$this->api_token = null;
		$this->save();
	}

	public function role()
	{
		return $this->belongsTo(UserRole::class, 'user_role_id', 'id');
	}

	public function cart()
	{
		return $this->hasMany(ProductUser::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}
}
