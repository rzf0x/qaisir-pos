<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'laundry_id',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the laundry for this user.
     */
    public function laundry(): BelongsTo
    {
        return $this->belongsTo(Laundry::class);
    }

    /**
     * Get the subscription for this user's laundry.
     */
    public function subscription(): HasOne
    {
        // For backward compatibility
        return $this->hasOne(Subscription::class);
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is owner.
     */
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * Check if user has an active subscription.
     */
    public function hasActiveSubscription(): bool
    {
        if ($this->laundry && $this->laundry->subscription) {
            return $this->laundry->subscription->isActive();
        }
        return false;
    }

    /**
     * Check if user is on trial.
     */
    public function isOnTrial(): bool
    {
        if ($this->laundry && $this->laundry->subscription) {
            return $this->laundry->subscription->isOnTrial();
        }
        return false;
    }

    /**
     * Get the laundry services through laundry.
     */
    public function laundryServices()
    {
        return $this->laundry ? $this->laundry->laundryServices() : collect();
    }

    /**
     * Get the transactions through laundry.
     */
    public function transactions()
    {
        return $this->laundry ? $this->laundry->transactions() : collect();
    }

    /**
     * Get the daily summaries through laundry.
     */
    public function dailySummaries()
    {
        return $this->laundry ? $this->laundry->dailySummaries() : collect();
    }
}

