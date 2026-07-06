<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $primaryKey = 'id_image';

    public $timestamps = false;

    protected $fillable = ['id_product', 'image_url', 'alt_text', 'is_primary'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];
}
