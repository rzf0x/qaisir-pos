<x-app-layout>
    <div class="max-w-lg mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('services.index') }}"
                class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <h2 class="text-xl font-bold text-gray-900">Tambah Layanan</h2>
            <p class="text-sm text-gray-500">Buat layanan laundry baru</p>
        </div>

        <form action="{{ route('services.store') }}" method="POST">
            @csrf

            <!-- Service Name -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Layanan *</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Cuci Setrika"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-lg"
                    required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price Per KG -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Harga per Kg *</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium">Rp</span>
                    <input type="number" name="price_per_kg" value="{{ old('price_per_kg') }}" placeholder="5000"
                        min="100"
                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-lg"
                        required>
                </div>
                @error('price_per_kg')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Quick Price Buttons -->
                <div class="flex flex-wrap gap-2 mt-3">
                    @foreach ([5000, 7000, 8000, 10000, 12000] as $price)
                        <button type="button"
                            onclick="document.querySelector('input[name=price_per_kg]').value = {{ $price }}"
                            class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200 transition-colors">
                            Rp {{ number_format($price, 0, ',', '.') }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-4 rounded-2xl gradient-bg text-white font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Layanan</span>
                </div>
            </button>
        </form>
    </div>
</x-app-layout>
