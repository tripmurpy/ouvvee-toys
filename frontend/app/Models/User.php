<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = ['name', 'email', 'password', 'phone', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class, 'id_user', 'id_user');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'id_user', 'id_user');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_user', 'id_user');
    }

    public function wishlists()
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'id_user', 'id_product')->withTimestamps();
    }
}
