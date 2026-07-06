<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $primaryKey = 'id_order_item';

    public $timestamps = false;

    protected $fillable = ['id_order', 'id_product', 'quantity', 'price_each', 'total_price'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
