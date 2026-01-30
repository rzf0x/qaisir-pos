<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laundry;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_laundries' => Laundry::count(),
            'active_laundries' => Laundry::active()->count(),
            'total_users' => User::where('role', 'owner')->count(),
            'total_transactions' => Transaction::count(),
            'today_transactions' => Transaction::whereDate('created_at', today())->count(),
            'total_income' => Transaction::sum('total'),
            'today_income' => Transaction::whereDate('created_at', today())->sum('total'),
        ];

        $recentLaundries = Laundry::with('subscription')
            ->latest()
            ->take(5)
            ->get();

        $recentTransactions = Transaction::with('laundry')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentLaundries', 'recentTransactions'));
    }
}
