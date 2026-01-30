<x-app-layout>
    <!-- Welcome Section -->
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">Halo, {{ auth()->user()->name }}! 👋</h2>
        <p class="text-sm text-gray-500">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
    </div>

    <!-- Trial Warning -->
    @if ($subscription && $subscription->isOnTrial())
        <div class="mb-4 p-4 rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-amber-800">Masa Uji Coba</p>
                    <p class="text-xs text-amber-600">Sisa {{ $subscription->remaining_trial_days }} hari lagi</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Subscription Expired Warning -->
    @if ($isExpired)
        <div class="mb-4 p-4 rounded-2xl bg-gradient-to-r from-red-50 to-pink-50 border border-red-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-red-800">Langganan Berakhir</p>
                        <p class="text-xs text-red-600">Perpanjang untuk lanjut transaksi</p>
                    </div>
                </div>
                <a href="{{ route('subscription.status') }}"
                    class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-xl hover:bg-red-700 transition-colors">
                    Perpanjang
                </a>
            </div>
        </div>
    @endif

    <!-- Main Summary Cards -->
    <div class="grid grid-cols-1 gap-4 mb-6">
        <!-- Total Income Today -->
        <div class="p-6 rounded-2xl bg-gradient-to-br from-slate-700 to-slate-800 text-white card-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-white/80 bg-white/20 px-2 py-1 rounded-full">Hari Ini</span>
            </div>
            <p class="text-sm text-white/80 mb-1">Uang Masuk Hari Ini</p>
            <p class="text-3xl font-bold number-animate">{{ $todaySummary['formatted_income'] }}</p>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Transaction Count -->
            <div class="p-5 rounded-2xl bg-white card-shadow">
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <p class="text-xs text-gray-500 mb-1">Jumlah Transaksi</p>
                <p class="text-2xl font-bold text-slate-800">{{ $todaySummary['total_transactions'] }}</p>
            </div>

            <!-- Cash Income -->
            <div class="p-5 rounded-2xl bg-white card-shadow">
                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <p class="text-xs text-gray-500 mb-1">Tunai Diterima</p>
                <p class="text-xl font-bold text-slate-800">{{ $todaySummary['formatted_cash'] }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Action Button -->
    @if (!$isExpired)
        <a href="{{ route('transactions.create') }}"
            class="block w-full p-4 mb-6 rounded-2xl gradient-bg text-white text-center font-semibold text-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200">
            <div class="flex items-center justify-center space-x-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Transaksi Baru</span>
            </div>
        </a>
    @endif

    <!-- Recent Transactions -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-slate-800">Transaksi Hari Ini</h3>
            <a href="{{ route('transactions.index') }}" class="text-sm text-slate-600 font-medium hover:text-slate-800">
                Lihat Semua
            </a>
        </div>

        @if ($recentTransactions->count() > 0)
            <div class="space-y-3">
                @foreach ($recentTransactions->take(5) as $transaction)
                    <div class="p-4 rounded-xl bg-white card-shadow hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-1">
                                    <p class="text-sm font-semibold text-slate-800">{{ $transaction->service_name }}</p>
                                    <span
                                        class="px-2 py-0.5 text-xs rounded-full 
                                        {{ $transaction->payment_method === 'cash' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $transaction->payment_label }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500">
                                    {{ $transaction->customer_name ?? 'Pelanggan' }} • {{ $transaction->weight }} kg
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-slate-800">{{ $transaction->formatted_total }}</p>
                                <p class="text-xs text-gray-400">{{ $transaction->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 rounded-2xl bg-gray-50 text-center">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <p class="text-gray-500 text-sm mb-4">Belum ada transaksi hari ini</p>
                @if (!$isExpired)
                    <a href="{{ route('transactions.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-slate-800 text-white text-sm font-medium rounded-xl hover:bg-slate-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Transaksi
                    </a>
                @endif
            </div>
        @endif
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-2 gap-3">
        <a href="{{ route('reports.index') }}"
            class="p-4 rounded-xl bg-white card-shadow hover:shadow-md transition-shadow flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-800">Laporan</p>
                <p class="text-xs text-gray-500">Lihat omzet</p>
            </div>
        </a>
        <a href="{{ route('services.index') }}"
            class="p-4 rounded-xl bg-white card-shadow hover:shadow-md transition-shadow flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-800">Layanan</p>
                <p class="text-xs text-gray-500">Kelola harga</p>
            </div>
        </a>
    </div>
</x-app-layout>
