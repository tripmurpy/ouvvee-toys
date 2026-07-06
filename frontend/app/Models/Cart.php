<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'id_cart';

    protected $fillable = ['id_user', 'status'];

    public const UPDATED_AT = null;

    public function items()
    {
        return $this->hasMany(CartItem::class, 'id_cart', 'id_cart');
    }
}
