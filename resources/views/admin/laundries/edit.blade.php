<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6">
        <a href="{{ route('admin.laundries.show', $laundry) }}"
            class="inline-flex items-center text-gray-500 hover:text-slate-700 mb-2">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Edit Laundry</h2>
        <p class="text-gray-500">{{ $laundry->name }}</p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.laundries.update', $laundry) }}" class="max-w-2xl">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl card-shadow p-6 space-y-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Laundry *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $laundry->name) }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200 @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">URL Slug *</label>
                <div class="flex items-center">
                    <span
                        class="px-4 py-3 bg-gray-100 rounded-l-xl border border-r-0 border-gray-200 text-gray-500 text-sm">qaisir.com/</span>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $laundry->slug) }}"
                        class="flex-1 px-4 py-3 rounded-r-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200 @error('slug') border-red-500 @enderror"
                        required>
                </div>
                @error('slug')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Owner Name -->
            <div>
                <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik *</label>
                <input type="text" name="owner_name" id="owner_name"
                    value="{{ old('owner_name', $laundry->owner_name) }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200 @error('owner_name') border-red-500 @enderror"
                    required>
                @error('owner_name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $laundry->phone) }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200">
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="address" id="address" rows="2"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200">{{ old('address', $laundry->address) }}</textarea>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200">{{ old('description', $laundry->description) }}</textarea>
            </div>

            <!-- Active Status -->
            <div class="flex items-center justify-between py-4 border-t border-gray-100">
                <div>
                    <p class="font-medium text-slate-800">Status Aktif</p>
                    <p class="text-sm text-gray-500">Laundry yang nonaktif tidak dapat diakses publik</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                        {{ $laundry->is_active ? 'checked' : '' }}>
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-slate-800">
                    </div>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <form method="POST" action="{{ route('admin.laundries.destroy', $laundry) }}"
                    onsubmit="return confirm('Yakin ingin menghapus laundry ini? Semua data akan hilang!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-red-600 hover:text-red-700 font-medium">
                        Hapus Laundry
                    </button>
                </form>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.laundries.show', $laundry) }}"
                        class="px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-3 rounded-xl gradient-bg text-white font-medium shadow-lg hover:shadow-xl transition-shadow">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-admin-layout>
