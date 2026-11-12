<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    protected $fillable = [
        'name',
        'scientific_name',
        'category',
        'target_crops',
        'affected_crops',
        'period',
        'symptoms',
        'control_methods',
        'cultural_practices',
        'chemical_treatment',
        'image_path',
    ];

    protected $casts = [
        'affected_crops' => 'array',
    ];

    /**
     * Scope to retrieve pests (ravageurs) only.
     */
    public function scopeRavageurs(Builder $query): Builder
    {
        return $query->where('category', 'ravageur');
    }

    /**
     * Scope to retrieve fungal diseases (maladies fongiques) only.
     */
    public function scopeMaladies(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->where('category', '!=', 'ravageur')
              ->orWhereNull('category');
        });
    }

    /**
     * Returns true if this record is a pest.
     */
    public function isRavageur(): bool
    {
        return strtolower((string) $this->category) === 'ravageur';
    }
}
