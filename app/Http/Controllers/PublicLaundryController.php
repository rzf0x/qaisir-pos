<?php

namespace App\Http\Controllers;

use App\Models\Laundry;

class PublicLaundryController extends Controller
{
    /**
     * Display the public laundry page.
     */
    public function show(string $slug)
    {
        $laundry = Laundry::where('slug', $slug)
            ->where('is_active', true)
            ->with('laundryServices')
            ->firstOrFail();

        $services = $laundry->laundryServices()->active()->get();

        return view('public.laundry', compact('laundry', 'services'));
    }
}
