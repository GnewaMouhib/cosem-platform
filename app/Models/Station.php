<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = [
        'name',
        'type',
        'city',
        'governorate',
        'latitude',
        'longitude',
        'capacity',
        'surface',
        'description',
        'images',
        'image_path',
        'installation_year',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'capacity' => 'integer',
        'surface' => 'integer',
        'images' => 'array',
        'installation_year' => 'integer',
    ];
}
