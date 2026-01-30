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
            <h2 class="text-xl font-bold text-gray-900">Edit Layanan</h2>
            <p class="text-sm text-gray-500">Ubah detail layanan</p>
        </div>

        <form action="{{ route('services.update', $service->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Service Name -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Layanan *</label>
                <input type="text" name="name" value="{{ old('name', $service->name) }}"
                    placeholder="Contoh: Cuci Setrika"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-lg"
                    required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price Per KG -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Harga per Kg *</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium">Rp</span>
                    <input type="number" name="price_per_kg" value="{{ old('price_per_kg', $service->price_per_kg) }}"
                        placeholder="5000" min="100"
                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-lg"
                        required>
                </div>
                @error('price_per_kg')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <label class="flex items-center space-x-3 p-4 rounded-xl bg-gray-50 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ $service->is_active ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <div>
                        <p class="font-medium text-gray-900">Layanan Aktif</p>
                        <p class="text-sm text-gray-500">Layanan akan muncul di form transaksi</p>
                    </div>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-4 rounded-2xl gradient-bg text-white font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 mb-4">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Perubahan</span>
                </div>
            </button>
        </form>

        <!-- Delete Form -->
        <form action="{{ route('services.destroy', $service->id) }}" method="POST"
            onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="w-full py-3 rounded-xl bg-red-50 text-red-600 font-medium hover:bg-red-100 transition-colors">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Hapus Layanan</span>
                </div>
            </button>
        </form>
    </div>
</x-app-layout>
