<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LaundryServiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PublicLaundryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\LaundryController as AdminLaundryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest routes
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Laundry management
    Route::resource('laundries', AdminLaundryController::class);
    Route::post('laundries/{laundry}/toggle-active', [AdminLaundryController::class, 'toggleActive'])->name('laundries.toggle-active');
    Route::post('laundries/{laundry}/extend-subscription', [AdminLaundryController::class, 'extendSubscription'])->name('laundries.extend-subscription');
});

// Owner (laundry) routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard (for owners)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Subscription
    Route::get('/langganan', [SubscriptionController::class, 'status'])->name('subscription.status');
    Route::get('/langganan/berakhir', [SubscriptionController::class, 'expired'])->name('subscription.expired');

    // Routes that require active subscription
    Route::middleware(['subscription.active'])->group(function () {
        // Transactions
        Route::get('/transaksi', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transaksi/baru', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/transaksi', [TransactionController::class, 'store'])->name('transactions.store');
        Route::get('/transaksi/{id}/sukses', [TransactionController::class, 'success'])->name('transactions.success');
        Route::get('/transaksi/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::put('/transaksi/{id}', [TransactionController::class, 'update'])->name('transactions.update');
        Route::delete('/transaksi/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    });

    // Laundry Services (CRUD)
    Route::resource('layanan', LaundryServiceController::class)->names([
        'index' => 'services.index',
        'create' => 'services.create',
        'store' => 'services.store',
        'edit' => 'services.edit',
        'update' => 'services.update',
        'destroy' => 'services.destroy',
    ]);

    // Reports
    Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public laundry page (must be at the end to avoid conflicts)
// Exclude reserved routes from the slug pattern
Route::get('/{slug}', [PublicLaundryController::class, 'show'])
    ->name('laundry.public')
    ->where('slug', '^(?!login|register|logout|forgot-password|reset-password|verify-email|confirm-password|admin|dashboard|transaksi|layanan|laporan|langganan|profile|password).*$');

require __DIR__.'/auth.php';


