<x-app-layout>
    <div class="max-w-lg mx-auto text-center">
        <!-- Success Icon -->
        <div class="mb-6">
            <div
                class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4 animate-bounce">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Transaksi Berhasil! 🎉</h2>
            <p class="text-gray-500">Transaksi telah disimpan</p>
        </div>

        <!-- Transaction Summary Card -->
        <div class="p-6 rounded-2xl bg-white card-shadow mb-6 text-left">
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                    <span class="text-gray-500">Layanan</span>
                    <span class="font-semibold text-gray-900">{{ $transaction->service_name }}</span>
                </div>

                @if ($transaction->customer_name)
                    <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                        <span class="text-gray-500">Pelanggan</span>
                        <span class="font-semibold text-gray-900">{{ $transaction->customer_name }}</span>
                    </div>
                @endif

                <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                    <span class="text-gray-500">Berat</span>
                    <span class="font-semibold text-gray-900">{{ $transaction->weight }} kg</span>
                </div>

                <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                    <span class="text-gray-500">Harga per kg</span>
                    <span class="font-semibold text-gray-900">Rp
                        {{ number_format($transaction->price_per_kg, 0, ',', '.') }}</span>
                </div>

                <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                    <span class="text-gray-500">Pembayaran</span>
                    <span
                        class="px-3 py-1 rounded-full text-sm font-medium 
                        {{ $transaction->payment_method === 'cash' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ $transaction->payment_label }}
                    </span>
                </div>

                @if ($transaction->notes)
                    <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                        <span class="text-gray-500">Catatan</span>
                        <span class="text-gray-700 text-sm">{{ $transaction->notes }}</span>
                    </div>
                @endif

                <div class="flex justify-between items-center pt-2">
                    <span class="text-lg font-semibold text-gray-900">Total</span>
                    <span class="text-2xl font-bold text-indigo-600">{{ $transaction->formatted_total }}</span>
                </div>
            </div>
        </div>

        <!-- Time -->
        <p class="text-sm text-gray-400 mb-6">
            {{ $transaction->created_at->locale('id')->isoFormat('dddd, D MMMM Y • HH:mm') }}
        </p>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="{{ route('transactions.create') }}"
                class="block w-full py-4 rounded-2xl gradient-bg text-white font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Transaksi Baru</span>
                </div>
            </a>

            <a href="{{ route('dashboard') }}"
                class="block w-full py-4 rounded-2xl bg-gray-100 text-gray-700 font-semibold text-lg hover:bg-gray-200 transition-colors">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</x-app-layout>
