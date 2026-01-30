<?php

namespace App\Services;

use App\Models\Laundry;
use App\Models\User;
use App\Models\LaundryService;

class LaundryServiceService
{
    /**
     * Create a new laundry service for a laundry.
     */
    public function createForLaundry(Laundry $laundry, array $data): LaundryService
    {
        return LaundryService::create([
            'laundry_id' => $laundry->id,
            'name' => $data['name'],
            'price_per_kg' => $data['price_per_kg'],
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    /**
     * Create a new laundry service (legacy, for user).
     */
    public function create(User $user, array $data): LaundryService
    {
        return LaundryService::create([
            'laundry_id' => $user->laundry_id,
            'user_id' => $user->id,
            'name' => $data['name'],
            'price_per_kg' => $data['price_per_kg'],
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    /**
     * Update a laundry service.
     */
    public function update(LaundryService $service, array $data): LaundryService
    {
        $service->update([
            'name' => $data['name'],
            'price_per_kg' => $data['price_per_kg'],
            'is_active' => $data['is_active'] ?? $service->is_active,
        ]);

        return $service->fresh();
    }

    /**
     * Delete a laundry service.
     */
    public function delete(LaundryService $service): void
    {
        $service->delete();
    }

    /**
     * Get all active services for a laundry.
     */
    public function getActiveServicesForLaundry(Laundry $laundry)
    {
        return LaundryService::where('laundry_id', $laundry->id)
            ->active()
            ->orderBy('name')
            ->get();
    }

    /**
     * Get all active services for a user (through their laundry).
     */
    public function getActiveServices(User $user)
    {
        if (!$user->laundry) {
            return collect();
        }
        
        return $this->getActiveServicesForLaundry($user->laundry);
    }

    /**
     * Get all services for a laundry.
     */
    public function getAllServicesForLaundry(Laundry $laundry)
    {
        return LaundryService::where('laundry_id', $laundry->id)
            ->orderBy('name')
            ->get();
    }

    /**
     * Get all services for a user (through their laundry).
     */
    public function getAllServices(User $user)
    {
        if (!$user->laundry) {
            return collect();
        }
        
        return $this->getAllServicesForLaundry($user->laundry);
    }

    /**
     * Create default services for a new laundry.
     */
    public function createDefaultServicesForLaundry(Laundry $laundry): void
    {
        $defaultServices = [
            ['name' => 'Cuci Kering', 'price_per_kg' => 5000],
            ['name' => 'Cuci Setrika', 'price_per_kg' => 7000],
            ['name' => 'Setrika Saja', 'price_per_kg' => 5000],
        ];

        foreach ($defaultServices as $service) {
            $this->createForLaundry($laundry, $service);
        }
    }

    /**
     * Create default services for a new user (legacy).
     */
    public function createDefaultServices(User $user): void
    {
        if (!$user->laundry) {
            return;
        }

        $this->createDefaultServicesForLaundry($user->laundry);
    }
}

