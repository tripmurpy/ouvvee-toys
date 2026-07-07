<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasUuids;

    protected $primaryKey = 'id_category';

    protected $fillable = ['category_name', 'slug', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_category', 'id_category');
    }
}
