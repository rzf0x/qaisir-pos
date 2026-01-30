<x-app-layout>
    <div class="max-w-lg mx-auto text-center">
        <!-- Expired Icon -->
        <div class="mb-6">
            <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Langganan Berakhir</h2>
            <p class="text-gray-500">Masa langganan QAISIR Anda telah berakhir</p>
        </div>

        <!-- Info Card -->
        <div class="p-6 rounded-2xl bg-red-50 border border-red-100 mb-6 text-left">
            <h3 class="font-semibold text-red-800 mb-2">Apa yang terjadi?</h3>
            <ul class="space-y-2 text-sm text-red-700">
                <li class="flex items-start space-x-2">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Anda tidak dapat membuat transaksi baru</span>
                </li>
                <li class="flex items-start space-x-2">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Data transaksi lama tetap tersimpan aman</span>
                </li>
                <li class="flex items-start space-x-2">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Anda masih bisa melihat laporan</span>
                </li>
            </ul>
        </div>

        <!-- Pricing Card -->
        <div class="p-6 rounded-2xl border-2 border-indigo-200 bg-gradient-to-br from-indigo-50 to-purple-50 mb-6">
            <div class="text-center mb-4">
                <p class="text-sm text-indigo-600 font-medium mb-2">Perpanjang Sekarang</p>
                <p class="text-4xl font-bold text-gray-900">Rp 25.000</p>
                <p class="text-sm text-gray-500">per bulan</p>
            </div>

            <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20memperpanjang%20langganan%20QAISIR"
                target="_blank"
                class="block w-full py-4 rounded-2xl gradient-bg text-white font-bold text-center shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    <span>Hubungi via WhatsApp</span>
                </div>
            </a>
        </div>

        <!-- Back to Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="block w-full py-3 rounded-xl bg-gray-100 text-gray-700 font-medium text-center hover:bg-gray-200 transition-colors">
            Kembali ke Beranda
        </a>
    </div>
</x-app-layout>
