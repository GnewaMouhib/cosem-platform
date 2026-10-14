<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Year extends Model
{
    protected $fillable = [
        'name',
        'harvest_year',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'harvest_year' => 'integer',
        'is_active' => 'boolean',
    ];

    public function annualStats(): HasMany
    {
        return $this->hasMany(AnnualStat::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Aggregated multi-year series for the admin analytics charts.
     * Ordered by harvest_year ascending; campaigns without stats are zero-filled.
     */
    public static function chartSeries(): array
    {
        $years = self::with('annualStats')->orderBy('harvest_year')->get();

        $series = [
            'labels'   => [],
            'durum'    => [],
            'soft'     => [],
            'barley'   => [],
            'pulses'   => [],
            'hectares' => [],
            'cert'     => [],
        ];

        foreach ($years as $y) {
            $s = $y->annualStats->first();

            $series['labels'][]   = $y->name;
            $series['durum'][]    = (float) ($s?->durum_wheat_qx ?? 0);
            $series['soft'][]     = (float) ($s?->soft_wheat_qx ?? 0);
            $series['barley'][]   = (float) ($s?->barley_qx ?? 0);
            $series['pulses'][]   = (float) ($s?->pulses_qx ?? 0);
            $series['hectares'][] = (float) ($s?->total_hectares ?? 0);
            $series['cert'][]     = $s?->certified_seed_pct !== null ? (float) $s->certified_seed_pct : null;
        }

        return $series;
    }
}
