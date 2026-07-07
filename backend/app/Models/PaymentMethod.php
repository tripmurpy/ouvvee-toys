<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasUuids;

    protected $primaryKey = 'id_payment_method';

    public $timestamps = false;

    protected $fillable = ['method_name', 'description'];
}
