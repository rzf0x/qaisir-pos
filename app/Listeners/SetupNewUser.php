<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\SubscriptionService;
use App\Services\LaundryServiceService;

class SetupNewUser
{
    public function __construct(
        protected SubscriptionService $subscriptionService,
        protected LaundryServiceService $laundryServiceService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;

        // Create trial subscription
        $this->subscriptionService->createTrialSubscription($user);

        // Create default laundry services
        $this->laundryServiceService->createDefaultServices($user);
    }
}
