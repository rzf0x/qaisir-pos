<x-app-layout>
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">Laporan Usaha</h2>
        <p class="text-sm text-gray-500">Pantau perkembangan laundry Anda</p>
    </div>

    <!-- Period Tabs -->
    <div class="flex space-x-2 mb-6 overflow-x-auto pb-2">
        <a href="{{ route('reports.index', ['period' => 'today']) }}"
            class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-all
                  {{ $period === 'today' ? 'gradient-bg text-white shadow-lg' : 'bg-white text-gray-600 card-shadow hover:bg-gray-50' }}">
            Hari Ini
        </a>
        <a href="{{ route('reports.index', ['period' => 'week']) }}"
            class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-all
                  {{ $period === 'week' ? 'gradient-bg text-white shadow-lg' : 'bg-white text-gray-600 card-shadow hover:bg-gray-50' }}">
            7 Hari Terakhir
        </a>
        <a href="{{ route('reports.index', ['period' => 'month']) }}"
            class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-all
                  {{ $period === 'month' ? 'gradient-bg text-white shadow-lg' : 'bg-white text-gray-600 card-shadow hover:bg-gray-50' }}">
            Bulan Ini
        </a>
    </div>

    <!-- Period Label -->
    <div class="mb-4">
        <p class="text-sm text-gray-500">
            📅 {{ $periodLabel }}
            @if ($period !== 'today')
                <span class="text-gray-400">({{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }})</span>
            @endif
        </p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 gap-4 mb-6">
        <!-- Total Income -->
        <div class="p-6 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white card-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span
                    class="text-xs font-medium text-white/80 bg-white/20 px-2 py-1 rounded-full">{{ $periodLabel }}</span>
            </div>
            <p class="text-sm text-white/80 mb-1">Total Uang Masuk</p>
            <p class="text-3xl font-bold number-animate">{{ $summary['formatted_income'] }}</p>
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
                <p class="text-2xl font-bold text-gray-900">{{ $summary['total_transactions'] }}</p>
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
                <p class="text-xl font-bold text-gray-900">{{ $summary['formatted_cash'] }}</p>
            </div>
        </div>

        <!-- QR Income -->
        <div class="p-4 rounded-xl bg-white card-shadow flex items-center space-x-4">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">QR / Transfer</p>
                <p class="text-lg font-bold text-gray-900">{{ $summary['formatted_qr'] }}</p>
            </div>
        </div>
    </div>

    <!-- Daily Breakdown (for week/month) -->
    @if ($period !== 'today' && count($dailyBreakdown) > 0)
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Harian</h3>
            <div class="space-y-2">
                @foreach ($dailyBreakdown as $day)
                    <div class="p-3 rounded-xl bg-white card-shadow flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $day['date'] }}</p>
                            <p class="text-xs text-gray-500">{{ $day['transactions'] }} transaksi</p>
                        </div>
                        <p class="text-sm font-bold text-indigo-600">Rp
                            {{ number_format($day['income'], 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Transaction List -->
    <div>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Transaksi</h3>

        @if ($transactions->count() > 0)
            <div class="space-y-2">
                @foreach ($transactions as $transaction)
                    <div class="p-3 rounded-xl bg-white card-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $transaction->service_name }}</p>
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
                                <p class="text-sm font-bold text-gray-900">{{ $transaction->formatted_total }}</p>
                                <p class="text-xs text-gray-400">{{ $transaction->created_at->format('d/m H:i') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 rounded-2xl bg-gray-50 text-center">
                <p class="text-gray-500 text-sm">Belum ada transaksi pada periode ini</p>
            </div>
        @endif
    </div>
</x-app-layout>
