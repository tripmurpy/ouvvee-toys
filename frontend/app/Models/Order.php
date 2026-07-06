<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'id_order';

    public const CREATED_AT = 'order_date';
    public const UPDATED_AT = null;

    protected $fillable = [
        'id_user',
        'id_address',
        'order_code',
        'subtotal',
        'shipping_cost',
        'total_price',
        'order_status',
    ];

    protected $casts = [
        'order_date' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'order_code';
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'id_order', 'id_order');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id_order', 'id_order');
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class, 'id_order', 'id_order');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
