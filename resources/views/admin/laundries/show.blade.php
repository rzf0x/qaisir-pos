<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6">
        <a href="{{ route('admin.laundries.index') }}"
            class="inline-flex items-center text-gray-500 hover:text-slate-700 mb-2">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">{{ $laundry->name }}</h2>
                <p class="text-gray-500">Detail dan statistik laundry</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.laundries.edit', $laundry) }}"
                    class="inline-flex items-center px-4 py-2 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.laundries.toggle-active', $laundry) }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 rounded-xl font-medium transition-colors
                                   {{ $laundry->is_active ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                        {{ $laundry->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="p-6 rounded-2xl bg-white card-shadow">
            <p class="text-sm text-gray-500 mb-1">Total Transaksi</p>
            <p class="text-3xl font-bold text-slate-800">{{ number_format($stats['total_transactions']) }}</p>
        </div>
        <div class="p-6 rounded-2xl bg-white card-shadow">
            <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
            <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($stats['total_income'], 0, ',', '.') }}</p>
        </div>
        <div class="p-6 rounded-2xl bg-white card-shadow">
            <p class="text-sm text-gray-500 mb-1">Pendapatan Bulan Ini</p>
            <p class="text-2xl font-bold text-green-600">Rp
                {{ number_format($stats['this_month_income'], 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Laundry Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white rounded-2xl card-shadow p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Laundry</h3>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-16 h-16 rounded-2xl gradient-bg flex items-center justify-center">
                            <span class="text-white font-bold text-2xl">{{ substr($laundry->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-slate-800 text-lg">{{ $laundry->name }}</p>
                            <a href="{{ url('/' . $laundry->slug) }}" target="_blank"
                                class="text-sm text-blue-600 hover:text-blue-800">
                                qaisir.com/{{ $laundry->slug }} ↗
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                        <div>
                            <p class="text-sm text-gray-500">Pemilik</p>
                            <p class="font-medium text-slate-800">{{ $laundry->owner_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            @if ($laundry->is_active)
                                <span
                                    class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                    <span class="w-2 h-2 rounded-full bg-green-500 mr-1"></span>
                                    Aktif
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
                                    <span class="w-2 h-2 rounded-full bg-gray-400 mr-1"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Telepon</p>
                            <p class="font-medium text-slate-800">{{ $laundry->phone ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Terdaftar</p>
                            <p class="font-medium text-slate-800">{{ $laundry->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    @if ($laundry->address)
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500">Alamat</p>
                            <p class="font-medium text-slate-800">{{ $laundry->address }}</p>
                        </div>
                    @endif

                    @if ($laundry->description)
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500">Deskripsi</p>
                            <p class="text-slate-700">{{ $laundry->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-2xl card-shadow p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Transaksi Terbaru</h3>
                @if ($recentTransactions->count() > 0)
                    <div class="space-y-3">
                        @foreach ($recentTransactions as $transaction)
                            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                                <div>
                                    <p class="font-medium text-slate-800">{{ $transaction->service_name }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $transaction->customer_name ?: 'Tanpa nama' }} • {{ $transaction->weight }}
                                        kg
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-slate-800">{{ $transaction->formatted_total }}</p>
                                    <p class="text-xs text-gray-400">{{ $transaction->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Belum ada transaksi</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Subscription -->
            <div class="bg-white rounded-2xl card-shadow p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Status Langganan</h3>
                @if ($laundry->subscription)
                    <div class="text-center">
                        <span
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                            @if ($laundry->subscription->status === 'trial') bg-amber-100 text-amber-700
                            @elseif($laundry->subscription->status === 'active') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ $laundry->subscription->status_label }}
                        </span>

                        @if ($laundry->subscription->status === 'trial' && $laundry->subscription->trial_ends_at)
                            <p class="mt-3 text-sm text-gray-500">
                                Berakhir: {{ $laundry->subscription->trial_ends_at->format('d M Y') }}
                            </p>
                            <p class="text-sm text-amber-600">
                                {{ $laundry->subscription->remaining_trial_days }} hari lagi
                            </p>
                        @elseif($laundry->subscription->status === 'active' && $laundry->subscription->expires_at)
                            <p class="mt-3 text-sm text-gray-500">Berlaku hingga:</p>
                            <p class="text-sm font-medium text-green-600">
                                {{ $laundry->subscription->expires_at->format('d M Y') }}
                            </p>
                        @endif
                    </div>

                    <!-- Extend Subscription -->
                    <form method="POST" action="{{ route('admin.laundries.extend-subscription', $laundry) }}"
                        class="mt-4 pt-4 border-t border-gray-100">
                        @csrf
                        <label class="block text-sm font-medium text-gray-700 mb-2">Perpanjang Langganan</label>
                        <div class="flex space-x-2">
                            <select name="months" class="flex-1 px-3 py-2 rounded-xl border border-gray-200 text-sm">
                                <option value="1">1 Bulan</option>
                                <option value="3">3 Bulan</option>
                                <option value="6">6 Bulan</option>
                                <option value="12">12 Bulan</option>
                            </select>
                            <button type="submit"
                                class="px-4 py-2 rounded-xl bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition-colors">
                                Perpanjang
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-gray-500 text-center">Tidak ada data langganan</p>
                @endif
            </div>

            <!-- Services -->
            <div class="bg-white rounded-2xl card-shadow p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Layanan
                    ({{ $laundry->laundryServices->count() }})</h3>
                @if ($laundry->laundryServices->count() > 0)
                    <div class="space-y-2">
                        @foreach ($laundry->laundryServices as $service)
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center">
                                    <span
                                        class="w-2 h-2 rounded-full mr-2 {{ $service->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                                    <span class="text-sm text-slate-700">{{ $service->name }}</span>
                                </div>
                                <span class="text-sm font-medium text-slate-800">
                                    Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}/kg
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Belum ada layanan</p>
                @endif
            </div>

            <!-- Users -->
            <div class="bg-white rounded-2xl card-shadow p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Akun Pengguna</h3>
                @if ($laundry->users->count() > 0)
                    <div class="space-y-3">
                        @foreach ($laundry->users as $user)
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center">
                                    <span
                                        class="text-sm font-medium text-slate-600">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-slate-800">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Tidak ada pengguna</p>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
