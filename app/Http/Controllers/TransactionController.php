<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Services\LaundryServiceService;
use App\Models\LaundryService;
use App\Models\Transaction;
use App\Models\DailySummary;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService,
        protected LaundryServiceService $laundryServiceService
    ) {}

    /**
     * Show the transaction creation form.
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $services = $this->laundryServiceService->getActiveServices($user);

        return view('transactions.create', compact('services'));
    }

    /**
     * Store a new transaction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:100',
            'service_id' => 'required|exists:laundry_services,id',
            'weight' => 'required|numeric|min:0.1|max:1000',
            'payment_method' => 'required|in:cash,qr',
            'notes' => 'nullable|string|max:500',
        ], [
            'service_id.required' => 'Pilih jenis layanan',
            'weight.required' => 'Masukkan berat laundry',
            'weight.min' => 'Berat minimal 0.1 kg',
            'payment_method.required' => 'Pilih metode pembayaran',
        ]);

        $user = $request->user();
        
        // Check if user has laundry
        if (!$user->laundry_id) {
            return back()->withErrors(['service_id' => 'Anda belum terdaftar di laundry manapun']);
        }
        
        // Get service details
        $service = LaundryService::find($validated['service_id']);
        
        // Validate service belongs to user's laundry
        if (!$service || $service->laundry_id !== $user->laundry_id) {
            return back()->withErrors(['service_id' => 'Layanan tidak valid']);
        }

        // Create transaction
        $transaction = $this->transactionService->createTransaction($user, [
            'customer_name' => $validated['customer_name'],
            'service_name' => $service->name,
            'weight' => $validated['weight'],
            'price_per_kg' => $service->price_per_kg,
            'payment_method' => $validated['payment_method'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('transactions.success', $transaction)
            ->with('success', 'Transaksi berhasil disimpan!');
    }

    /**
     * Show transaction success page.
     */
    public function success(Request $request, $id)
    {
        $user = $request->user();
        
        // Get transaction from user's laundry
        $transaction = Transaction::where('laundry_id', $user->laundry_id)
            ->findOrFail($id);

        return view('transactions.success', compact('transaction'));
    }

    /**
     * Show transaction history.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Get transactions from user's laundry
        $transactions = Transaction::where('laundry_id', $user->laundry_id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show edit form for transaction.
     */
    public function edit(Request $request, $id)
    {
        $user = $request->user();
        
        $transaction = Transaction::where('laundry_id', $user->laundry_id)
            ->findOrFail($id);
        
        $services = $this->laundryServiceService->getActiveServices($user);

        return view('transactions.edit', compact('transaction', 'services'));
    }

    /**
     * Update transaction.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:100',
            'service_id' => 'required|exists:laundry_services,id',
            'weight' => 'required|numeric|min:0.1|max:1000',
            'payment_method' => 'required|in:cash,qr',
            'notes' => 'nullable|string|max:500',
        ], [
            'service_id.required' => 'Pilih jenis layanan',
            'weight.required' => 'Masukkan berat laundry',
            'weight.min' => 'Berat minimal 0.1 kg',
            'payment_method.required' => 'Pilih metode pembayaran',
        ]);

        $user = $request->user();
        
        $transaction = Transaction::where('laundry_id', $user->laundry_id)
            ->findOrFail($id);
        
        $service = LaundryService::find($validated['service_id']);
        
        if (!$service || $service->laundry_id !== $user->laundry_id) {
            return back()->withErrors(['service_id' => 'Layanan tidak valid']);
        }

        $oldTotal = $transaction->total;
        $oldPaymentMethod = $transaction->payment_method;
        $transactionDate = $transaction->created_at->toDateString();

        $newTotal = $validated['weight'] * $service->price_per_kg;

        DB::transaction(function () use ($transaction, $validated, $service, $newTotal, $oldTotal, $oldPaymentMethod, $transactionDate, $user) {
            // Update transaction
            $transaction->update([
                'customer_name' => $validated['customer_name'],
                'service_name' => $service->name,
                'weight' => $validated['weight'],
                'price_per_kg' => $service->price_per_kg,
                'total' => $newTotal,
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Update daily summary
            $summary = DailySummary::where('laundry_id', $user->laundry_id)
                ->where('date', $transactionDate)
                ->first();

            if ($summary) {
                // Remove old values
                $summary->decrement('total_income', $oldTotal);
                if ($oldPaymentMethod === 'cash') {
                    $summary->decrement('cash_income', $oldTotal);
                } else {
                    $summary->decrement('qr_income', $oldTotal);
                }

                // Add new values
                $summary->increment('total_income', $newTotal);
                if ($validated['payment_method'] === 'cash') {
                    $summary->increment('cash_income', $newTotal);
                } else {
                    $summary->increment('qr_income', $newTotal);
                }
            }
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diupdate!');
    }

    /**
     * Delete transaction.
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        
        $transaction = Transaction::where('laundry_id', $user->laundry_id)
            ->findOrFail($id);

        $transactionDate = $transaction->created_at->toDateString();
        $total = $transaction->total;
        $paymentMethod = $transaction->payment_method;

        DB::transaction(function () use ($transaction, $transactionDate, $total, $paymentMethod, $user) {
            // Update daily summary
            $summary = DailySummary::where('laundry_id', $user->laundry_id)
                ->where('date', $transactionDate)
                ->first();

            if ($summary) {
                $summary->decrement('total_transactions');
                $summary->decrement('total_income', $total);
                if ($paymentMethod === 'cash') {
                    $summary->decrement('cash_income', $total);
                } else {
                    $summary->decrement('qr_income', $total);
                }
            }

            // Delete transaction
            $transaction->delete();
        });

        return response()->json(['success' => true, 'message' => 'Transaksi berhasil dihapus!']);
    }
}


