<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasUuids;
    use Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_BUYER = 'buyer';

    protected $primaryKey = 'id_user';

    protected $fillable = ['name', 'email', 'password', 'password_hash', 'phone', 'role'];

    protected $hidden = ['password', 'password_hash', 'remember_token'];

    protected $casts = [
        'password_hash' => 'hashed',
    ];

    public function getAuthPasswordName(): string
    {
        return 'password_hash';
    }

    public function setPasswordAttribute(string $value): void
    {
        $this->setAttribute('password_hash', $value);
    }

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
