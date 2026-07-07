<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasUuids;

    protected $primaryKey = 'id_cart_item';

    public $timestamps = false;

    protected $fillable = ['id_cart', 'id_product', 'quantity'];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'id_cart', 'id_cart');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
