<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Laundry extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'owner_name',
        'phone',
        'address',
        'logo',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($laundry) {
            if (empty($laundry->slug)) {
                $laundry->slug = Str::slug($laundry->name);
            }
        });
    }

    /**
     * Get the users for this laundry.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the laundry services.
     */
    public function laundryServices(): HasMany
    {
        return $this->hasMany(LaundryService::class);
    }

    /**
     * Get the transactions.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the daily summaries.
     */
    public function dailySummaries(): HasMany
    {
        return $this->hasMany(DailySummary::class);
    }

    /**
     * Get the subscription.
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    /**
     * Check if laundry has active subscription.
     */
    public function hasActiveSubscription(): bool
    {
        return $this->subscription && $this->subscription->isActive();
    }

    /**
     * Get the public URL.
     */
    public function getUrlAttribute(): string
    {
        return url('/' . $this->slug);
    }

    /**
     * Scope for active laundries.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
