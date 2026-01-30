<x-app-layout>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Riwayat Transaksi</h2>
            <p class="text-sm text-gray-500">Semua transaksi yang tercatat</p>
        </div>
        <a href="{{ route('transactions.create') }}"
            class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center shadow-lg hover:bg-slate-700 transition-colors">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

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

                <div class="p-4 rounded-xl bg-white border border-slate-200 hover:shadow-md transition-shadow">
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
                            @if ($transaction->notes)
                                <p class="text-xs text-gray-400 mt-1 italic">{{ Str::limit($transaction->notes, 30) }}
                                </p>
                            @endif
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <p class="text-sm font-bold text-slate-800">{{ $transaction->formatted_total }}</p>
                                <p class="text-xs text-gray-400">{{ $transaction->created_at->format('H:i') }}</p>
                            </div>
                            <!-- Action Buttons -->
                            <div class="flex items-center gap-1">
                                <!-- Edit Button -->
                                <a href="{{ route('transactions.edit', $transaction->id) }}"
                                    class="p-2 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <!-- Delete Button -->
                                <button type="button"
                                    onclick="confirmDelete({{ $transaction->id }}, '{{ $transaction->service_name }}')"
                                    class="p-2 rounded-lg text-red-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                    title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
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
                class="inline-flex items-center px-4 py-2 bg-slate-800 text-white text-sm font-medium rounded-xl hover:bg-slate-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Transaksi Pertama
            </a>
        </div>
    @endif

    <script>
        function confirmDelete(id, serviceName) {
            Swal.fire({
                title: 'Hapus Transaksi?',
                html: `Transaksi <strong>${serviceName}</strong> akan dihapus permanen.<br>Data tidak dapat dikembalikan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send delete request
                    fetch(`/transaksi/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Terhapus!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonColor: '#1e293b'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal menghapus transaksi',
                                    icon: 'error',
                                    confirmButtonColor: '#1e293b'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan',
                                icon: 'error',
                                confirmButtonColor: '#1e293b'
                            });
                        });
                }
            });
        }
    </script>
</x-app-layout>
