<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $primaryKey = 'id_shipping_method';

    public $timestamps = false;

    protected $fillable = ['method_name', 'description'];

    public function rates()
    {
        return $this->hasMany(ShippingRate::class, 'id_shipping_method', 'id_shipping_method');
    }
}
