<x-app-layout>
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Riwayat Transaksi</h2>
            <p class="text-sm text-gray-500">Semua transaksi yang tercatat</p>
        </div>
        <a href="{{ route('transactions.create') }}"
            class="w-10 h-10 rounded-xl gradient-bg flex items-center justify-center shadow-lg">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>
    </div>

    @if ($transactions->count() > 0)
        <!-- Transaction List -->
        <div class="space-y-3 mb-6">
            @php $currentDate = null; @endphp
            @foreach ($transactions as $transaction)
                @php $transactionDate = $transaction->created_at->format('Y-m-d'); @endphp

                @if ($currentDate !== $transactionDate)
                    @php $currentDate = $transactionDate; @endphp
                    <div class="py-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">
                            {{ $transaction->created_at->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </p>
                    </div>
                @endif

                <div class="p-4 rounded-xl bg-white card-shadow hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <p class="text-sm font-semibold text-gray-900">{{ $transaction->service_name }}</p>
                                <span
                                    class="px-2 py-0.5 text-xs rounded-full 
                                    {{ $transaction->payment_method === 'cash' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $transaction->payment_label }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500">
                                {{ $transaction->customer_name ?? 'Pelanggan' }} • {{ $transaction->weight }} kg
                            </p>
                            @if ($transaction->notes)
                                <p class="text-xs text-gray-400 mt-1 italic">{{ Str::limit($transaction->notes, 30) }}
                                </p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900">{{ $transaction->formatted_total }}</p>
                            <p class="text-xs text-gray-400">{{ $transaction->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="p-8 rounded-2xl bg-gray-50 text-center">
            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <p class="text-gray-500 text-sm mb-4">Belum ada transaksi</p>
            <a href="{{ route('transactions.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Transaksi Pertama
            </a>
        </div>
    @endif
</x-app-layout>
