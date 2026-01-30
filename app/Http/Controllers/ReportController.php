<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService
    ) {}

    /**
     * Display the reports page.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $period = $request->get('period', 'today');

        // Determine date range based on period
        switch ($period) {
            case 'week':
                $startDate = Carbon::now()->subDays(7)->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                $periodLabel = '7 Hari Terakhir';
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfDay();
                $periodLabel = 'Bulan Ini';
                break;
            default: // today
                $startDate = Carbon::today();
                $endDate = Carbon::now()->endOfDay();
                $periodLabel = 'Hari Ini';
                break;
        }

        // Get summary for the period
        $summary = $this->transactionService->getSummary($user, $startDate, $endDate);

        // Get transactions for the period
        $transactions = $user->transactions()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get daily breakdown for charts (if week or month)
        $dailyBreakdown = [];
        if ($period !== 'today') {
            $dailyBreakdown = $user->dailySummaries()
                ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
                ->orderBy('date')
                ->get()
                ->map(function ($summary) {
                    return [
                        'date' => $summary->date->format('d/m'),
                        'income' => $summary->total_income,
                        'transactions' => $summary->total_transactions,
                    ];
                });
        }

        return view('reports.index', compact(
            'summary',
            'transactions',
            'period',
            'periodLabel',
            'dailyBreakdown',
            'startDate',
            'endDate'
        ));
    }
}
