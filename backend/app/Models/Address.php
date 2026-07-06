<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $primaryKey = 'id_address';

    protected $fillable = [
        'id_user',
        'recipient_name',
        'phone',
        'province',
        'city',
        'district',
        'detail_address',
        'postal_code',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];
}
