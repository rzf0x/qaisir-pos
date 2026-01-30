<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'laundry_id',
        'user_id',
        'customer_name',
        'service_name',
        'weight',
        'price_per_kg',
        'total',
        'payment_method',
        'notes',
    ];

    /**
     * Get the laundry that owns the transaction.
     */
    public function laundry(): BelongsTo
    {
        return $this->belongsTo(Laundry::class);
    }

    protected $casts = [
        'weight' => 'decimal:2',
        'price_per_kg' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for today's transactions.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope for transactions within date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Format total as Indonesian Rupiah.
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    /**
     * Get payment method label.
     */
    public function getPaymentLabelAttribute(): string
    {
        return $this->payment_method === 'cash' ? 'Tunai' : 'QR/Transfer';
    }
}
