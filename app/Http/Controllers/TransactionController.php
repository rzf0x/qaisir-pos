<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Services\LaundryServiceService;
use App\Models\LaundryService;

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
        
        // Get service details
        $service = LaundryService::find($validated['service_id']);
        
        if (!$service || $service->user_id !== $user->id) {
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
        $transaction = $user->transactions()->findOrFail($id);

        return view('transactions.success', compact('transaction'));
    }

    /**
     * Show transaction history.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $transactions = $user->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('transactions.index', compact('transactions'));
    }
}
