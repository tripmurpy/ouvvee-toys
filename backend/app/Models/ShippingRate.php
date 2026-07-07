<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    use HasUuids;

    protected $primaryKey = 'id_shipping_rate';

    public $timestamps = false;

    protected $fillable = [
        'id_shipping_method',
        'min_weight_gram',
        'max_weight_gram',
        'base_cost',
        'cost_per_kg',
    ];
}
