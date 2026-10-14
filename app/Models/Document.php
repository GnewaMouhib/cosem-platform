<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'category',
        'file_path',
        'campaign_year',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];
}
