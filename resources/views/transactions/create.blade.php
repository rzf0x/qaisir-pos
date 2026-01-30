<x-app-layout>
    <div x-data="transactionForm()" class="max-w-lg mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900">Transaksi Baru</h2>
            <p class="text-sm text-gray-500">Catat laundry pelanggan</p>
        </div>

        <form @submit.prevent="submitForm" action="{{ route('transactions.store') }}" method="POST">
            @csrf

            <!-- Customer Name (Optional) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pelanggan (Opsional)</label>
                <input type="text" name="customer_name" x-model="customerName" placeholder="Contoh: Ibu Siti"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-lg">
                @error('customer_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Service Selection -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan *</label>
                <div class="grid grid-cols-1 gap-2">
                    @foreach ($services as $service)
                        <label class="relative">
                            <input type="radio" name="service_id" value="{{ $service->id }}"
                                x-model="selectedService" @change="updatePrice({{ $service->price_per_kg }})"
                                class="sr-only peer">
                            <div
                                class="p-4 rounded-xl border-2 border-gray-200 cursor-pointer transition-all
                                        peer-checked:border-indigo-500 peer-checked:bg-indigo-50
                                        hover:border-gray-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $service->name }}</p>
                                        <p class="text-sm text-gray-500">Rp
                                            {{ number_format($service->price_per_kg, 0, ',', '.') }} / kg</p>
                                    </div>
                                    <div
                                        class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center
                                                peer-checked:border-indigo-500 peer-checked:bg-indigo-500">
                                        <svg x-show="selectedService == {{ $service->id }}" class="w-4 h-4 text-white"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('service_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Weight Input -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Berat (kg) *</label>
                <div class="relative">
                    <input type="number" name="weight" x-model="weight" @input="calculateTotal" step="0.1"
                        min="0.1" placeholder="0.0"
                        class="w-full px-4 py-4 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-2xl font-bold text-center">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium">kg</span>
                </div>
                @error('weight')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Quick Weight Buttons -->
                <div class="flex flex-wrap gap-2 mt-3">
                    @foreach ([1, 2, 3, 5, 10] as $kg)
                        <button type="button" @click="setWeight({{ $kg }})"
                            class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200 transition-colors">
                            {{ $kg }} kg
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Total Display -->
            <div class="mb-4 p-4 rounded-xl bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-100">
                <p class="text-sm text-gray-600 mb-1">Total Hari Ini</p>
                <p class="text-3xl font-bold text-indigo-600" x-text="formattedTotal">Rp 0</p>
            </div>

            <!-- Payment Method -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran *</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative">
                        <input type="radio" name="payment_method" value="cash" x-model="paymentMethod"
                            class="sr-only peer" checked>
                        <div
                            class="p-4 rounded-xl border-2 border-gray-200 cursor-pointer transition-all text-center
                                    peer-checked:border-green-500 peer-checked:bg-green-50
                                    hover:border-gray-300">
                            <div
                                class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">Tunai</p>
                        </div>
                    </label>
                    <label class="relative">
                        <input type="radio" name="payment_method" value="qr" x-model="paymentMethod"
                            class="sr-only peer">
                        <div
                            class="p-4 rounded-xl border-2 border-gray-200 cursor-pointer transition-all text-center
                                    peer-checked:border-blue-500 peer-checked:bg-blue-50
                                    hover:border-gray-300">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-900">QR / Transfer</p>
                        </div>
                    </label>
                </div>
                @error('payment_method')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes (Optional) -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                <textarea name="notes" x-model="notes" rows="2" placeholder="Contoh: Ambil besok sore"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all"></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" :disabled="!canSubmit"
                :class="canSubmit ? 'gradient-bg hover:shadow-xl' : 'bg-gray-300 cursor-not-allowed'"
                class="w-full py-4 rounded-2xl text-white font-bold text-lg shadow-lg transform transition-all duration-200">
                <span x-show="!loading" class="flex items-center justify-center space-x-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Transaksi</span>
                </span>
                <span x-show="loading" class="flex items-center justify-center space-x-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>Menyimpan...</span>
                </span>
            </button>
        </form>
    </div>

    <script>
        function transactionForm() {
            return {
                customerName: '',
                selectedService: null,
                pricePerKg: 0,
                weight: '',
                paymentMethod: 'cash',
                notes: '',
                loading: false,

                get total() {
                    if (!this.weight || !this.pricePerKg) return 0;
                    return parseFloat(this.weight) * parseFloat(this.pricePerKg);
                },

                get formattedTotal() {
                    return 'Rp ' + this.total.toLocaleString('id-ID');
                },

                get canSubmit() {
                    return this.selectedService && this.weight > 0 && !this.loading;
                },

                updatePrice(price) {
                    this.pricePerKg = price;
                },

                setWeight(kg) {
                    this.weight = kg;
                },

                calculateTotal() {
                    // Reactive update handled by getter
                },

                submitForm() {
                    if (!this.canSubmit) return;
                    this.loading = true;
                    this.$el.submit();
                }
            }
        }
    </script>
</x-app-layout>
