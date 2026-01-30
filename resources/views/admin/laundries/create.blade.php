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
        <h2 class="text-2xl font-bold text-slate-800">Tambah Laundry Baru</h2>
        <p class="text-gray-500">Daftarkan laundry baru beserta akun pemiliknya</p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.laundries.store') }}" class="max-w-2xl">
        @csrf

        <div class="bg-white rounded-2xl card-shadow p-6 space-y-6">
            <!-- Laundry Info Section -->
            <div>
                <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-gray-100">Info Laundry</h3>

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Laundry *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        placeholder="Contoh: Laundry Bersih Kilat"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200 @error('name') border-red-500 @enderror"
                        required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="mb-4">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">URL Slug</label>
                    <div class="flex items-center">
                        <span
                            class="px-4 py-3 bg-gray-100 rounded-l-xl border border-r-0 border-gray-200 text-gray-500 text-sm">qaisir.com/</span>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                            placeholder="laundry-bersih-kilat"
                            class="flex-1 px-4 py-3 rounded-r-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200 @error('slug') border-red-500 @enderror">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Kosongkan untuk generate otomatis dari nama</p>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                        placeholder="Contoh: 08123456789"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200">
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="address" id="address" rows="2" placeholder="Alamat lengkap laundry"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200">{{ old('address') }}</textarea>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" placeholder="Deskripsi singkat laundry (opsional)"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Owner Info Section -->
            <div>
                <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-gray-100">Info Pemilik (Akun
                    Login)</h3>

                <!-- Owner Name -->
                <div class="mb-4">
                    <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik *</label>
                    <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}"
                        placeholder="Nama lengkap pemilik"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200 @error('owner_name') border-red-500 @enderror"
                        required>
                    @error('owner_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Owner Email -->
                <div class="mb-4">
                    <label for="owner_email" class="block text-sm font-medium text-gray-700 mb-1">Email Pemilik
                        *</label>
                    <input type="email" name="owner_email" id="owner_email" value="{{ old('owner_email') }}"
                        placeholder="email@example.com"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200 @error('owner_email') border-red-500 @enderror"
                        required>
                    @error('owner_email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Owner Password -->
                <div>
                    <label for="owner_password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                    <input type="password" name="owner_password" id="owner_password" placeholder="Minimal 8 karakter"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200 @error('owner_password') border-red-500 @enderror"
                        required>
                    @error('owner_password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium mb-1">Yang akan dibuat:</p>
                        <ul class="list-disc list-inside space-y-1 text-blue-600">
                            <li>Akun laundry dengan halaman publik</li>
                            <li>Akun login untuk pemilik</li>
                            <li>3 layanan default (Cuci Kering, Cuci Setrika, Setrika Saja)</li>
                            <li>Masa trial 7 hari gratis</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.laundries.index') }}"
                    class="px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 rounded-xl gradient-bg text-white font-medium shadow-lg hover:shadow-xl transition-shadow">
                    Tambah Laundry
                </button>
            </div>
        </div>
    </form>
</x-admin-layout>
