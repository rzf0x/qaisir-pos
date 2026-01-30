<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display the expired subscription page.
     */
    public function expired(Request $request)
    {
        $user = $request->user();
        $subscription = $user->subscription;

        return view('subscription.expired', compact('subscription'));
    }

    /**
     * Display the subscription status page.
     */
    public function status(Request $request)
    {
        $user = $request->user();
        $subscription = $user->subscription;

        return view('subscription.status', compact('subscription'));
    }
}
