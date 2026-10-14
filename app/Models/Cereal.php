<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cereal extends Model
{
    protected $fillable = [
        'category',
        'name',
        'type',
        'breeder',
        'optimal_cycle',
        'yield_potential',
        'description',
        'disease_resistance',
        'targeted_zone',
        'grain_quality',
        'image_path',
        'order_index',
    ];

    protected $casts = [
        'order_index' => 'integer',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->category));
    }
}
