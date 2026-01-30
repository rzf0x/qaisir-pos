<x-app-layout>
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Layanan Laundry</h2>
            <p class="text-sm text-gray-500">Kelola jenis layanan & harga</p>
        </div>
        <a href="{{ route('services.create') }}"
            class="px-4 py-2 rounded-xl gradient-bg text-white text-sm font-medium shadow-lg flex items-center space-x-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah</span>
        </a>
    </div>

    @if ($services->count() > 0)
        <!-- Services List -->
        <div class="space-y-3">
            @foreach ($services as $service)
                <div class="p-4 rounded-xl bg-white card-shadow hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-12 h-12 rounded-xl {{ $service->is_active ? 'bg-indigo-100' : 'bg-gray-100' }} flex items-center justify-center">
                                <svg class="w-6 h-6 {{ $service->is_active ? 'text-indigo-600' : 'text-gray-400' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $service->name }}</p>
                                <p class="text-sm text-gray-500">Rp
                                    {{ number_format($service->price_per_kg, 0, ',', '.') }} / kg</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if (!$service->is_active)
                                <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-500 text-xs">Nonaktif</span>
                            @endif
                            <a href="{{ route('services.edit', $service->id) }}"
                                class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="p-8 rounded-2xl bg-gray-50 text-center">
            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <p class="text-gray-500 text-sm mb-4">Belum ada layanan</p>
            <a href="{{ route('services.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Layanan
            </a>
        </div>
    @endif

    <!-- Info Box -->
    <div class="mt-6 p-4 rounded-xl bg-blue-50 border border-blue-100">
        <div class="flex items-start space-x-3">
            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-blue-800">Tip</p>
                <p class="text-xs text-blue-600">Layanan yang Anda buat akan muncul di form transaksi. Pastikan harga
                    sudah benar sebelum input transaksi.</p>
            </div>
        </div>
    </div>
</x-app-layout>
