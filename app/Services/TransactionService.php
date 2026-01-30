<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use App\Models\DailySummary;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    /**
     * Create a new transaction.
     */
    public function createTransaction(User $user, array $data): Transaction
    {
        return DB::transaction(function () use ($user, $data) {
            // Calculate total
            $total = $data['weight'] * $data['price_per_kg'];
            
            // Create transaction
            $transaction = Transaction::create([
                'laundry_id' => $user->laundry_id,
                'user_id' => $user->id,
                'customer_name' => $data['customer_name'] ?? null,
                'service_name' => $data['service_name'],
                'weight' => $data['weight'],
                'price_per_kg' => $data['price_per_kg'],
                'total' => $total,
                'payment_method' => $data['payment_method'],
                'notes' => $data['notes'] ?? null,
            ]);

            // Update daily summary
            $this->updateDailySummary($user, $transaction);

            return $transaction;
        });
    }

    /**
     * Update the daily summary after a transaction.
     */
    protected function updateDailySummary(User $user, Transaction $transaction): void
    {
        $today = Carbon::today();
        
        $summary = DailySummary::firstOrCreate(
            ['laundry_id' => $user->laundry_id, 'date' => $today],
            ['user_id' => $user->id, 'total_transactions' => 0, 'total_income' => 0, 'cash_income' => 0, 'qr_income' => 0]
        );

        $summary->increment('total_transactions');
        $summary->increment('total_income', $transaction->total);

        if ($transaction->payment_method === 'cash') {
            $summary->increment('cash_income', $transaction->total);
        } else {
            $summary->increment('qr_income', $transaction->total);
        }
    }

    /**
     * Get today's summary for a user.
     */
    public function getTodaySummary(User $user): array
    {
        $today = Carbon::today();
        
        $summary = DailySummary::where('laundry_id', $user->laundry_id)
            ->where('date', $today)
            ->first();

        if (!$summary) {
            return [
                'total_transactions' => 0,
                'total_income' => 0,
                'cash_income' => 0,
                'qr_income' => 0,
                'formatted_income' => 'Rp 0',
                'formatted_cash' => 'Rp 0',
            ];
        }

        return [
            'total_transactions' => $summary->total_transactions,
            'total_income' => $summary->total_income,
            'cash_income' => $summary->cash_income,
            'qr_income' => $summary->qr_income,
            'formatted_income' => 'Rp ' . number_format($summary->total_income, 0, ',', '.'),
            'formatted_cash' => 'Rp ' . number_format($summary->cash_income, 0, ',', '.'),
        ];
    }

    /**
     * Get summary for a date range.
     */
    public function getSummary(User $user, Carbon $startDate, Carbon $endDate): array
    {
        $summaries = DailySummary::where('laundry_id', $user->laundry_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $totalTransactions = $summaries->sum('total_transactions');
        $totalIncome = $summaries->sum('total_income');
        $cashIncome = $summaries->sum('cash_income');
        $qrIncome = $summaries->sum('qr_income');

        return [
            'total_transactions' => $totalTransactions,
            'total_income' => $totalIncome,
            'cash_income' => $cashIncome,
            'qr_income' => $qrIncome,
            'formatted_income' => 'Rp ' . number_format($totalIncome, 0, ',', '.'),
            'formatted_cash' => 'Rp ' . number_format($cashIncome, 0, ',', '.'),
            'formatted_qr' => 'Rp ' . number_format($qrIncome, 0, ',', '.'),
        ];
    }

    /**
     * Get recent transactions for a user.
     */
    public function getRecentTransactions(User $user, int $limit = 10)
    {
        return Transaction::where('laundry_id', $user->laundry_id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get transactions for today.
     */
    public function getTodayTransactions(User $user)
    {
        return Transaction::where('laundry_id', $user->laundry_id)
            ->today()
            ->orderBy('created_at', 'desc')
            ->get();
    }
}

