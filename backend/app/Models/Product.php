<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    protected $primaryKey = 'id_product';

    protected $fillable = [
        'id_category',
        'slug',
        'product_name',
        'price',
        'description',
        'image_url',
        'model_url',
        'stock',
        'recommended_age',
        'safety_note',
        'size',
        'weight_gram',
        'status',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'id_product', 'id_product');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_product', 'id_product');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
}
