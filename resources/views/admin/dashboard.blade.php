<x-admin-layout>

    <!-- Stats Grid -->
    <div class="flex flex-wrap gap-4 mb-6">
        <!-- Total Laundries -->
        <div class="flex-1 min-w-[200px] p-5 rounded-2xl bg-white border border-slate-200">
            <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <p class="text-sm text-gray-500 mb-1">Total Laundry</p>
            <p class="text-3xl font-bold text-slate-800">{{ $stats['total_laundries'] }}</p>
            <p class="text-xs text-green-600 mt-1">{{ $stats['active_laundries'] }} aktif</p>
        </div>

        <!-- Total Users -->
        <div class="flex-1 min-w-[200px] p-5 rounded-2xl bg-white border border-slate-200">
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <p class="text-sm text-gray-500 mb-1">Total Pengguna</p>
            <p class="text-3xl font-bold text-slate-800">{{ $stats['total_users'] }}</p>
            <p class="text-xs text-gray-400 mt-1">pemilik laundry</p>
        </div>

        <!-- Total Transactions -->
        <div class="flex-1 min-w-[200px] p-5 rounded-2xl bg-white border border-slate-200">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <p class="text-sm text-gray-500 mb-1">Total Transaksi</p>
            <p class="text-3xl font-bold text-slate-800">{{ number_format($stats['total_transactions']) }}</p>
            <p class="text-xs text-blue-600 mt-1">{{ $stats['today_transactions'] }} hari ini</p>
        </div>

        <!-- Total Income -->
        <div class="flex-1 min-w-[200px] p-5 rounded-2xl bg-white border border-slate-200">
            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
            <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($stats['total_income'], 0, ',', '.') }}</p>
            <p class="text-xs text-green-600 mt-1">Rp {{ number_format($stats['today_income'], 0, ',', '.') }} hari ini
            </p>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Laundries -->
        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-800">Laundry Terbaru</h3>
                <a href="{{ route('admin.laundries.index') }}" class="text-sm text-slate-600 hover:text-slate-800">Lihat
                    Semua</a>
            </div>

            @if ($recentLaundries->count() > 0)
                <div class="space-y-3">
                    @foreach ($recentLaundries as $laundry)
                        <div
                            class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl gradient-bg flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ substr($laundry->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800">{{ $laundry->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $laundry->owner_name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if ($laundry->subscription)
                                    <span
                                        class="px-2 py-1 text-xs rounded-full
                                        @if ($laundry->subscription->status === 'trial') bg-amber-100 text-amber-700
                                        @elseif($laundry->subscription->status === 'active') bg-green-100 text-green-700
                                        @else bg-red-100 text-red-700 @endif">
                                        {{ $laundry->subscription->status_label }}
                                    </span>
                                @endif
                                <p class="text-xs text-gray-400 mt-1">{{ $laundry->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Belum ada laundry terdaftar</p>
            @endif
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-800">Transaksi Terbaru</h3>
            </div>

            @if ($recentTransactions->count() > 0)
                <div class="space-y-3">
                    @foreach ($recentTransactions as $transaction)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                            <div>
                                <p class="font-medium text-slate-800">{{ $transaction->service_name }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $transaction->laundry->name ?? 'Unknown' }} • {{ $transaction->weight }} kg
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-slate-800">{{ $transaction->formatted_total }}</p>
                                <p class="text-xs text-gray-400">{{ $transaction->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Belum ada transaksi</p>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6">
        <a href="{{ route('admin.laundries.create') }}"
            class="inline-flex items-center px-6 py-3 rounded-xl gradient-bg text-white font-medium shadow-lg hover:shadow-xl transition-shadow">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Laundry Baru
        </a>
    </div>
</x-admin-layout>
