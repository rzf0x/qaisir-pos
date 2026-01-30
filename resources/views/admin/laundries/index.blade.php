<x-admin-layout>
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Kelola Laundry</h2>
            <p class="text-gray-500">Daftar semua laundry yang terdaftar</p>
        </div>
        <a href="{{ route('admin.laundries.create') }}"
            class="inline-flex items-center px-4 py-2 rounded-xl gradient-bg text-white font-medium shadow-lg hover:shadow-xl transition-shadow">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Laundry
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-2xl card-shadow p-4 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama laundry, pemilik, atau slug..."
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200">
            </div>
            <div>
                <select name="status"
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-2 focus:ring-slate-200">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <button type="submit"
                class="px-6 py-2 rounded-xl bg-slate-100 text-slate-700 font-medium hover:bg-slate-200 transition-colors">
                Cari
            </button>
        </form>
    </div>

    <!-- Laundries Table -->
    <div class="bg-white rounded-2xl card-shadow overflow-hidden">
        @if ($laundries->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Laundry</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                URL</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Langganan</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Terdaftar</th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($laundries as $laundry)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-xl gradient-bg flex items-center justify-center flex-shrink-0">
                                            <span
                                                class="text-white font-bold text-sm">{{ substr($laundry->name, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-medium text-slate-800">{{ $laundry->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $laundry->owner_name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ url('/' . $laundry->slug) }}" target="_blank"
                                        class="text-sm text-blue-600 hover:text-blue-800">
                                        /{{ $laundry->slug }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($laundry->is_active)
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Aktif</span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($laundry->subscription)
                                        <span
                                            class="px-2 py-1 text-xs rounded-full
                                            @if ($laundry->subscription->status === 'trial') bg-amber-100 text-amber-700
                                            @elseif($laundry->subscription->status === 'active') bg-green-100 text-green-700
                                            @else bg-red-100 text-red-700 @endif">
                                            {{ $laundry->subscription->status_label }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $laundry->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.laundries.show', $laundry) }}"
                                            class="p-2 text-gray-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.laundries.edit', $laundry) }}"
                                            class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $laundries->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <p class="text-gray-500 mb-4">Belum ada laundry terdaftar</p>
                <a href="{{ route('admin.laundries.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-slate-800 text-white rounded-xl font-medium hover:bg-slate-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Laundry Pertama
                </a>
            </div>
        @endif
    </div>
</x-admin-layout>
