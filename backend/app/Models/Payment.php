<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasUuids;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_FAILED = 'failed';

    protected $primaryKey = 'id_payment';

    public $timestamps = false;

    protected $fillable = ['id_order', 'id_payment_method', 'payment_status', 'paid_at'];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'id_payment_method', 'id_payment_method');
    }
}
