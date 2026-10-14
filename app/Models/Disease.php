<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    protected $fillable = [
        'name',
        'scientific_name',
        'affected_crops',
        'symptoms',
        'cultural_practices',
        'chemical_treatment',
        'image_path',
    ];

    protected $casts = [
        'affected_crops' => 'array',
    ];
}
