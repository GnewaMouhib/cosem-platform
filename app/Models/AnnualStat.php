<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnualStat extends Model
{
    protected $fillable = [
        'year_id',
        'durum_wheat_qx',
        'soft_wheat_qx',
        'barley_qx',
        'oats_qx',
        'pulses_qx',
        'feves_qx',
        'pois_chiches_qx',
        'feveroles_qx',
        'lentilles_qx',
        'total_hectares',
        'total_multipliers',
        'member_multipliers',
        'certified_seed_pct',
        'prebasic_seed_pct',
        'financing_partner',
    ];

    protected $casts = [
        'durum_wheat_qx' => 'decimal:2',
        'soft_wheat_qx' => 'decimal:2',
        'barley_qx' => 'decimal:2',
        'oats_qx' => 'decimal:2',
        'pulses_qx' => 'decimal:2',
        'feves_qx' => 'decimal:2',
        'pois_chiches_qx' => 'decimal:2',
        'feveroles_qx' => 'decimal:2',
        'lentilles_qx' => 'decimal:2',
        'total_hectares' => 'decimal:2',
        'total_multipliers' => 'integer',
        'member_multipliers' => 'integer',
        'certified_seed_pct' => 'decimal:2',
        'prebasic_seed_pct' => 'decimal:2',
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function cerealsTotal(): float
    {
        return (float) ($this->durum_wheat_qx + $this->soft_wheat_qx + $this->barley_qx + $this->oats_qx);
    }

    public function pulsesTotal(): float
    {
        $breakdownSum = (float) ($this->feves_qx + $this->pois_chiches_qx + $this->feveroles_qx + $this->lentilles_qx);

        return $breakdownSum > 0 ? $breakdownSum : (float) $this->pulses_qx;
    }
}
