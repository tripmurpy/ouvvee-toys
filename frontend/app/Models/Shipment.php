<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $primaryKey = 'id_shipment';

    public $timestamps = false;

    protected $fillable = [
        'id_order',
        'id_shipping_method',
        'shipping_cost',
        'tracking_number',
        'shipment_status',
    ];

    public function method()
    {
        return $this->belongsTo(ShippingMethod::class, 'id_shipping_method', 'id_shipping_method');
    }
}
