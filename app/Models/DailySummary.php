<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailySummary extends Model
{
    protected $fillable = [
        'laundry_id',
        'user_id',
        'date',
        'total_transactions',
        'total_income',
        'cash_income',
        'qr_income',
    ];

    /**
     * Get the laundry that owns the summary.
     */
    public function laundry(): BelongsTo
    {
        return $this->belongsTo(Laundry::class);
    }

    protected $casts = [
        'date' => 'date',
        'total_income' => 'decimal:2',
        'cash_income' => 'decimal:2',
        'qr_income' => 'decimal:2',
    ];

    /**
     * Get the user that owns the summary.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Format total income as Indonesian Rupiah.
     */
    public function getFormattedIncomeAttribute(): string
    {
        return 'Rp ' . number_format($this->total_income, 0, ',', '.');
    }
}
