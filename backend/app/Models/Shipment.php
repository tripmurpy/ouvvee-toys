<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    public const STATUS_NOT_SHIPPED = 'not_shipped';
    public const STATUS_ON_DELIVERY = 'on_delivery';
    public const STATUS_DELIVERED = 'delivered';

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
