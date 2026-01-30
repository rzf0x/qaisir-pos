<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Subscription extends Model
{
    protected $fillable = [
        'laundry_id',
        'user_id',
        'trial_ends_at',
        'expires_at',
        'status',
    ];

    /**
     * Get the laundry that owns the subscription.
     */
    public function laundry(): BelongsTo
    {
        return $this->belongsTo(Laundry::class);
    }

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the subscription.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if subscription is on trial.
     */
    public function isOnTrial(): bool
    {
        return $this->status === 'trial' && $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Check if subscription is active.
     */
    public function isActive(): bool
    {
        if ($this->status === 'active' && $this->expires_at && $this->expires_at->isFuture()) {
            return true;
        }
        
        return $this->isOnTrial();
    }

    /**
     * Check if subscription is expired.
     */
    public function isExpired(): bool
    {
        return !$this->isActive();
    }

    /**
     * Get remaining trial days.
     */
    public function getRemainingTrialDaysAttribute(): int
    {
        if (!$this->trial_ends_at || $this->trial_ends_at->isPast()) {
            return 0;
        }
        
        return (int) now()->diffInDays($this->trial_ends_at, false);
    }

    /**
     * Get status label in Indonesian.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'trial' => 'Masa Uji Coba',
            'active' => 'Aktif',
            'expired' => 'Kadaluarsa',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get status color for UI.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'trial' => 'yellow',
            'active' => 'green',
            'expired' => 'red',
            default => 'gray',
        };
    }
}
