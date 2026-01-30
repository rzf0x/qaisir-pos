<?php

namespace Database\Seeders;

use App\Models\Laundry;
use App\Models\User;
use App\Services\SubscriptionService;
use App\Services\LaundryServiceService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $subscriptionService = new SubscriptionService();
        $laundryServiceService = new LaundryServiceService();

        // Create Admin User
        User::create([
            'name' => 'Admin QAISIR',
            'email' => 'admin@qaisir.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Demo Laundry 1
        $laundry1 = Laundry::create([
            'name' => 'Laundry Bersih Kilat',
            'slug' => 'bersih-kilat',
            'owner_name' => 'Budi Santosa',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No. 123, Jakarta',
            'description' => 'Laundry kiloan cepat dan bersih, bebas antar jemput',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Budi Santosa',
            'email' => 'demo@qaisir.com',
            'password' => Hash::make('password123'),
            'laundry_id' => $laundry1->id,
            'role' => 'owner',
        ]);

        $subscriptionService->createTrialSubscriptionForLaundry($laundry1);
        $laundryServiceService->createDefaultServicesForLaundry($laundry1);

        // Create Demo Laundry 2
        $laundry2 = Laundry::create([
            'name' => 'Cuci Kilat Express',
            'slug' => 'cuci-kilat',
            'owner_name' => 'Siti Rahayu',
            'phone' => '08987654321',
            'address' => 'Jl. Sudirman No. 45, Bandung',
            'description' => 'Laundry express 1 hari selesai',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Siti Rahayu',
            'email' => 'demo2@qaisir.com',
            'password' => Hash::make('password123'),
            'laundry_id' => $laundry2->id,
            'role' => 'owner',
        ]);

        $subscriptionService->createTrialSubscriptionForLaundry($laundry2);
        $laundryServiceService->createDefaultServicesForLaundry($laundry2);
    }
}
