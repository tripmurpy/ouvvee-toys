<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasUuids;

    public const STATUS_NOT_SHIPPED = 'pending';
    public const STATUS_ON_DELIVERY = 'shipped';
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
