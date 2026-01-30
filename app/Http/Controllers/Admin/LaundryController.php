<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laundry;
use App\Models\User;
use App\Services\LaundryServiceService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LaundryController extends Controller
{
    protected LaundryServiceService $laundryServiceService;
    protected SubscriptionService $subscriptionService;

    public function __construct(
        LaundryServiceService $laundryServiceService,
        SubscriptionService $subscriptionService
    ) {
        $this->laundryServiceService = $laundryServiceService;
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Display a listing of laundries.
     */
    public function index(Request $request)
    {
        $query = Laundry::with('subscription', 'users');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $laundries = $query->latest()->paginate(15);

        return view('admin.laundries.index', compact('laundries'));
    }

    /**
     * Show the form for creating a new laundry.
     */
    public function create()
    {
        return view('admin.laundries.create');
    }

    /**
     * Store a newly created laundry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:laundries,slug|alpha_dash',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email',
            'owner_password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            // Create laundry
            $laundry = Laundry::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'] ?: Str::slug($validated['name']),
                'owner_name' => $validated['owner_name'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'description' => $validated['description'] ?? null,
                'is_active' => true,
            ]);

            // Create owner user
            $user = User::create([
                'name' => $validated['owner_name'],
                'email' => $validated['owner_email'],
                'password' => Hash::make($validated['owner_password']),
                'laundry_id' => $laundry->id,
                'role' => 'owner',
            ]);

            // Create trial subscription for laundry
            $this->subscriptionService->createTrialSubscriptionForLaundry($laundry);

            // Create default services
            $this->laundryServiceService->createDefaultServicesForLaundry($laundry);

            DB::commit();

            return redirect()
                ->route('admin.laundries.index')
                ->with('success', "Laundry '{$laundry->name}' berhasil dibuat!");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat laundry: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified laundry.
     */
    public function show(Laundry $laundry)
    {
        $laundry->load('subscription', 'users', 'laundryServices');
        
        $stats = [
            'total_transactions' => $laundry->transactions()->count(),
            'total_income' => $laundry->transactions()->sum('total'),
            'this_month_income' => $laundry->transactions()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total'),
        ];

        $recentTransactions = $laundry->transactions()
            ->latest()
            ->take(10)
            ->get();

        return view('admin.laundries.show', compact('laundry', 'stats', 'recentTransactions'));
    }

    /**
     * Show the form for editing the specified laundry.
     */
    public function edit(Laundry $laundry)
    {
        $laundry->load('users');
        return view('admin.laundries.edit', compact('laundry'));
    }

    /**
     * Update the specified laundry.
     */
    public function update(Request $request, Laundry $laundry)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('laundries')->ignore($laundry->id)],
            'owner_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $laundry->update($validated);

        return redirect()
            ->route('admin.laundries.show', $laundry)
            ->with('success', 'Laundry berhasil diperbarui!');
    }

    /**
     * Toggle laundry active status.
     */
    public function toggleActive(Laundry $laundry)
    {
        $laundry->update(['is_active' => !$laundry->is_active]);

        $status = $laundry->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return back()->with('success', "Laundry berhasil {$status}!");
    }

    /**
     * Extend subscription for laundry.
     */
    public function extendSubscription(Request $request, Laundry $laundry)
    {
        $validated = $request->validate([
            'months' => 'required|integer|min:1|max:12',
        ]);

        $this->subscriptionService->extendSubscriptionForLaundry($laundry, $validated['months']);

        return back()->with('success', "Langganan berhasil diperpanjang {$validated['months']} bulan!");
    }

    /**
     * Remove the specified laundry.
     */
    public function destroy(Laundry $laundry)
    {
        $name = $laundry->name;
        $laundry->delete();

        return redirect()
            ->route('admin.laundries.index')
            ->with('success', "Laundry '{$name}' berhasil dihapus!");
    }
}
