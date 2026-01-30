<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaundryService extends Model
{
    protected $fillable = [
        'laundry_id',
        'user_id',
        'name',
        'price_per_kg',
        'is_active',
    ];

    protected $casts = [
        'price_per_kg' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the laundry that owns the service.
     */
    public function laundry(): BelongsTo
    {
        return $this->belongsTo(Laundry::class);
    }

    /**
     * Get the user that owns the service (legacy).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for active services only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

