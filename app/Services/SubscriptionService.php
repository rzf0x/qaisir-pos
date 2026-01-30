<?php

namespace App\Services;

use App\Models\Laundry;
use App\Models\User;
use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionService
{
    /**
     * Create a trial subscription for a new user (legacy).
     */
    public function createTrialSubscription(User $user): Subscription
    {
        return Subscription::create([
            'user_id' => $user->id,
            'trial_ends_at' => Carbon::now()->addDays(7),
            'status' => 'trial',
        ]);
    }

    /**
     * Create a trial subscription for a laundry.
     */
    public function createTrialSubscriptionForLaundry(Laundry $laundry): Subscription
    {
        return Subscription::create([
            'laundry_id' => $laundry->id,
            'trial_ends_at' => Carbon::now()->addDays(7),
            'status' => 'trial',
        ]);
    }

    /**
     * Update subscription status based on current date.
     */
    public function updateSubscriptionStatus(Subscription $subscription): void
    {
        // Check if trial has expired
        if ($subscription->status === 'trial' && $subscription->trial_ends_at && $subscription->trial_ends_at->isPast()) {
            $subscription->update(['status' => 'expired']);
            return;
        }

        // Check if active subscription has expired
        if ($subscription->status === 'active' && $subscription->expires_at && $subscription->expires_at->isPast()) {
            $subscription->update(['status' => 'expired']);
            return;
        }
    }

    /**
     * Activate subscription for a period.
     */
    public function activateSubscription(Subscription $subscription, int $months = 1): void
    {
        $expiresAt = Carbon::now()->addMonths($months);
        
        $subscription->update([
            'status' => 'active',
            'expires_at' => $expiresAt,
        ]);
    }

    /**
     * Extend subscription for a laundry.
     */
    public function extendSubscriptionForLaundry(Laundry $laundry, int $months = 1): void
    {
        $subscription = $laundry->subscription;
        
        if (!$subscription) {
            // Create new subscription
            $subscription = Subscription::create([
                'laundry_id' => $laundry->id,
                'expires_at' => Carbon::now()->addMonths($months),
                'status' => 'active',
            ]);
            return;
        }

        // Extend existing subscription
        $baseDate = $subscription->expires_at && $subscription->expires_at->isFuture()
            ? $subscription->expires_at
            : Carbon::now();

        $subscription->update([
            'status' => 'active',
            'expires_at' => $baseDate->addMonths($months),
        ]);
    }

    /**
     * Check if user can create transactions.
     */
    public function canCreateTransaction(User $user): bool
    {
        if (!$user->laundry || !$user->laundry->subscription) {
            return false;
        }

        // Update status first
        $this->updateSubscriptionStatus($user->laundry->subscription);
        
        return $user->laundry->subscription->isActive();
    }
}

