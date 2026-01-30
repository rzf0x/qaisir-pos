<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Models\Transaction;
use App\Models\DailySummary;
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
        
        // Ensure user has laundry
        if (!$user->laundry_id) {
            return redirect()->route('dashboard')->with('error', 'Anda harus memiliki laundry untuk melihat laporan.');
        }

        $period = $request->get('period', 'today');

        // Determine date range based on period
        switch ($period) {
            case 'week':
                $startDate = Carbon::now()->subDays(6)->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                $periodLabel = '7 Hari Terakhir';
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfDay();
                $periodLabel = 'Bulan Ini (' . Carbon::now()->locale('id')->isoFormat('MMMM Y') . ')';
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
        $transactions = Transaction::where('laundry_id', $user->laundry_id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get daily breakdown for charts (if week or month)
        $dailyBreakdown = [];
        if ($period !== 'today') {
            $dailyBreakdown = DailySummary::where('laundry_id', $user->laundry_id)
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
            
            // Fill missing dates with 0
            if ($period === 'week') {
                $dates = [];
                for ($i = 0; $i < 7; $i++) {
                    $date = Carbon::now()->subDays(6 - $i);
                    $dates[$date->format('d/m')] = [
                        'date' => $date->format('d/m'),
                        'income' => 0,
                        'transactions' => 0,
                    ];
                }
                
                foreach ($dailyBreakdown as $item) {
                    if (isset($dates[$item['date']])) {
                        $dates[$item['date']] = $item;
                    }
                }
                
                $dailyBreakdown = collect(array_values($dates));
            }
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

