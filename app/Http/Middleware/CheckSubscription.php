<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\SubscriptionService;

class CheckSubscription
{
    public function __construct(
        protected SubscriptionService $subscriptionService
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Update subscription status
        if ($user->subscription) {
            $this->subscriptionService->updateSubscriptionStatus($user->subscription);
        }

        // Check if can create transactions
        if (!$this->subscriptionService->canCreateTransaction($user)) {
            return redirect()->route('subscription.expired')
                ->with('error', 'Langganan Anda sudah berakhir. Silakan perpanjang untuk melanjutkan.');
        }

        return $next($request);
    }
}
