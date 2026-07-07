<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasUuids;

    protected $primaryKey = 'id_review';

    public const UPDATED_AT = null;

    protected $fillable = ['id_user', 'id_product', 'id_order', 'rating', 'comment'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
