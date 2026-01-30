<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Services\SubscriptionService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService,
        protected SubscriptionService $subscriptionService
    ) {}

    /**
     * Display the dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Redirect admin to admin dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        // Get laundry subscription
        $subscription = null;
        if ($user->laundry && $user->laundry->subscription) {
            $subscription = $user->laundry->subscription;
            $this->subscriptionService->updateSubscriptionStatus($subscription);
        }

        // Get today's summary
        $todaySummary = $this->transactionService->getTodaySummary($user);
        
        // Get recent transactions
        $recentTransactions = $this->transactionService->getTodayTransactions($user);

        // Check if expired
        $isExpired = $subscription ? $subscription->isExpired() : true;

        return view('dashboard', compact(
            'todaySummary',
            'recentTransactions',
            'subscription',
            'isExpired'
        ));
    }
}

