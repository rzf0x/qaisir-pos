<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LaundryServiceService;
use App\Models\LaundryService;

class LaundryServiceController extends Controller
{
    public function __construct(
        protected LaundryServiceService $laundryServiceService
    ) {}

    /**
     * Display all laundry services.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $services = $this->laundryServiceService->getAllServices($user);

        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created service.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'price_per_kg' => 'required|numeric|min:100|max:1000000',
        ], [
            'name.required' => 'Nama layanan wajib diisi',
            'price_per_kg.required' => 'Harga per kg wajib diisi',
            'price_per_kg.min' => 'Harga minimal Rp 100',
        ]);

        $this->laundryServiceService->create($request->user(), $validated);

        return redirect()->route('services.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing a service.
     */
    public function edit(Request $request, $id)
    {
        $user = $request->user();
        $service = LaundryService::where('user_id', $user->id)->findOrFail($id);

        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified service.
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $service = LaundryService::where('user_id', $user->id)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'price_per_kg' => 'required|numeric|min:100|max:1000000',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama layanan wajib diisi',
            'price_per_kg.required' => 'Harga per kg wajib diisi',
        ]);

        $this->laundryServiceService->update($service, $validated);

        return redirect()->route('services.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Remove the specified service.
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $service = LaundryService::where('user_id', $user->id)->findOrFail($id);

        $this->laundryServiceService->delete($service);

        return redirect()->route('services.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}
