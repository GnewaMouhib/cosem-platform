<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pulse extends Model
{
    protected $fillable = [
        'name',
        'variety',
        'optimal_cycle',
        'yield_potential',
        'disease_resistance',
        'grain_quality',
        'targeted_zone',
        'description',
        'image_path',
    ];
}
