<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasUuids;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    private const IMAGE_BY_SLUG = [
        'orbital-carrier-ship' => 'images/products/royal-castle-miniature-figure.png',
        'dragonborn-display-figure' => 'images/products/red-dragon-head-figure.png',
        'excavator-relic-mk-ii' => 'images/products/yellow-loader-track-figure.png',
        'crimson-crab-drone' => 'images/products/pink-crab-robot-figure.png',
        'ashen-builder-unit' => 'images/products/bulldozer-track-figure.png',
        'ruin-sentinel-type-zero' => 'images/products/blue-security-robot-figure.png',
        'mechanical-arm-display-figure' => 'images/products/mechanical-arm-display-figure.png',
    ];

    private const IMAGE_BY_KEYWORD = [
        'mech' => 'images/products/white-battle-mech-figure.png',
        'golem' => 'images/products/stone-golem-figure.png',
        'castle' => 'images/products/royal-castle-miniature-figure.png',
        'dragon' => 'images/products/red-dragon-head-figure.png',
        'crab' => 'images/products/pink-crab-robot-figure.png',
        'loader' => 'images/products/yellow-loader-track-figure.png',
        'bulldozer' => 'images/products/bulldozer-track-figure.png',
        'arm' => 'images/products/mechanical-arm-display-figure.png',
        'robot' => 'images/products/blue-security-robot-figure.png',
    ];

    private const MODEL_BY_SLUG = [
        'orbital-carrier-ship' => 'models/products/ship.glb',
        'dragonborn-display-figure' => 'models/products/dragonborn.glb',
        'excavator-relic-mk-ii' => 'models/products/excavator.glb',
        'crimson-crab-drone' => 'models/products/robot_crab.glb',
        'ashen-builder-unit' => 'models/products/bulldozer.glb',
        'ruin-sentinel-type-zero' => 'models/products/robot_police.glb',
        'blue-security-robot-figure' => 'models/products/robot_police.glb',
        'bulldozer-track-figure' => 'models/products/bulldozer.glb',
        'mechanical-arm-display-figure' => 'models/products/robot_arm.glb',
        'pink-crab-robot-figure' => 'models/products/robot_crab.glb',
        'red-dragon-head-figure' => 'models/products/dragonborn.glb',
        'royal-castle-miniature-figure' => 'models/products/castle2.glb',
        'stone-golem-figure' => 'models/products/monster.glb',
        'white-battle-mech-figure' => 'models/products/mech (2).glb',
        'yellow-loader-track-figure' => 'models/products/excavator.glb',
    ];

    private const MODEL_BY_KEYWORD = [
        'ship' => 'models/products/ship.glb',
        'dragon' => 'models/products/dragonborn.glb',
        'loader' => 'models/products/excavator.glb',
        'excavator' => 'models/products/excavator.glb',
        'crab' => 'models/products/robot_crab.glb',
        'bulldozer' => 'models/products/bulldozer.glb',
        'robot' => 'models/products/robot_police.glb',
        'arm' => 'models/products/robot_arm.glb',
        'castle' => 'models/products/castle2.glb',
        'golem' => 'models/products/monster.glb',
        'mech' => 'models/products/mech (2).glb',
    ];

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

    public function displayImagePath(): ?string
    {
        $imagePath = $this->existingPublicAssetPath($this->image_url);
        if ($imagePath) {
            return $imagePath;
        }

        $mappedPath = self::IMAGE_BY_SLUG[$this->slug] ?? $this->keywordImagePath();

        return $this->existingPublicAssetPath($mappedPath);
    }

    public function displayModelPath(): ?string
    {
        $modelPath = $this->existingPublicAssetPath($this->model_url);
        if ($modelPath) {
            return $modelPath;
        }

        // ponytail: keep catalog 3D live even while admin/import data still ships null model_url; remove slug map after product media is complete in DB.
        $mappedPath = self::MODEL_BY_SLUG[$this->slug] ?? $this->keywordModelPath();

        return $this->existingPublicAssetPath($mappedPath);
    }

    private function keywordImagePath(): ?string
    {
        $haystack = str($this->slug.' '.$this->product_name)->lower()->toString();

        foreach (self::IMAGE_BY_KEYWORD as $keyword => $path) {
            if (str_contains($haystack, $keyword)) {
                return $path;
            }
        }

        return null;
    }

    private function keywordModelPath(): ?string
    {
        $haystack = str($this->slug.' '.$this->product_name)->lower()->toString();

        foreach (self::MODEL_BY_KEYWORD as $keyword => $path) {
            if (str_contains($haystack, $keyword)) {
                return $path;
            }
        }

        return null;
    }

    private function existingPublicAssetPath(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $path = ltrim(parse_url($path, PHP_URL_PATH) ?: $path, '/');

        return file_exists(public_path($path)) ? $path : null;
    }
}
