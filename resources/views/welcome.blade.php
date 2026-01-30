<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="theme-color" content="#1e293b">
    <meta name="description"
        content="QAISIR - Kasir Laundry Simpel untuk UMKM Indonesia. Catat transaksi dengan cepat dan lihat omzet harian tanpa ribet.">

    <title>QAISIR - Kasir Laundry Simpel untuk UMKM</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-pattern {
            background-color: #f8fafc;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23475569' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body class="antialiased">
    <div class="min-h-screen hero-pattern">
        <!-- Header -->
        <header class="px-6 py-4">
            <div class="max-w-6xl mx-auto flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl gradient-bg flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">QAISIR</span>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-slate-800 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 rounded-xl gradient-bg text-white text-sm font-medium shadow-lg hover:shadow-xl transition-all">
                        Coba Gratis
                    </a>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="px-6 py-12 md:py-20">
            <div class="max-w-6xl mx-auto text-center">
                <div
                    class="inline-flex items-center px-4 py-2 rounded-full bg-slate-100 text-slate-700 text-sm font-medium mb-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    7 Hari Uji Coba Gratis
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                    Kasir Laundry <span class="gradient-text">Simpel</span><br>
                    untuk UMKM Indonesia
                </h1>

                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto mb-8">
                    Catat transaksi dengan cepat dan lihat <strong>uang masuk & omzet harian</strong> tanpa ribet.
                    Dibuat khusus untuk laundry kiloan.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
                    <a href="{{ route('register') }}"
                        class="w-full sm:w-auto px-8 py-4 rounded-2xl gradient-bg text-white font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        Mulai Gratis Sekarang
                    </a>
                    <a href="#features"
                        class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white text-gray-700 font-semibold text-lg shadow border border-gray-200 hover:border-gray-300 transition-all">
                        Lihat Fitur
                    </a>
                </div>

                <!-- Hero Image/Mockup -->
                <div class="relative max-w-md mx-auto float-animation">
                    <div class="bg-white rounded-3xl shadow-2xl p-6 border border-gray-100">
                        <div class="bg-gray-50 rounded-2xl p-4 mb-4">
                            <p class="text-xs text-gray-500 mb-1">Uang Masuk Hari Ini</p>
                            <p class="text-3xl font-bold gradient-text">Rp 1.250.000</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-blue-50 rounded-xl p-3">
                                <p class="text-xs text-gray-500">Transaksi</p>
                                <p class="text-xl font-bold text-gray-900">24</p>
                            </div>
                            <div class="bg-green-50 rounded-xl p-3">
                                <p class="text-xs text-gray-500">Tunai</p>
                                <p class="text-xl font-bold text-gray-900">Rp 980K</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="px-6 py-16 bg-white">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Kenapa Pilih QAISIR?</h2>
                    <p class="text-gray-600">Dibuat khusus untuk kebutuhan laundry kiloan UMKM</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="p-6 rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200">
                        <div class="w-14 h-14 rounded-2xl gradient-bg flex items-center justify-center mb-4 shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Super Cepat</h3>
                        <p class="text-gray-600">Input transaksi dalam hitungan detik. Tidak perlu banyak klik, langsung
                            simpan dan lanjut.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="p-6 rounded-2xl bg-gradient-to-br from-green-50 to-teal-50 border border-green-100">
                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-r from-green-500 to-teal-500 flex items-center justify-center mb-4 shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Omzet Jelas</h3>
                        <p class="text-gray-600">Langsung lihat uang masuk hari ini, minggu ini, atau bulan ini. Tidak
                            pakai istilah akuntansi yang ribet.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-100">
                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-r from-blue-500 to-cyan-500 flex items-center justify-center mb-4 shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Mobile Friendly</h3>
                        <p class="text-gray-600">Bisa diakses dari HP. Tombol besar, mudah diklik. Cocok untuk kasir
                            yang sibuk.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section class="px-6 py-16 bg-gray-50">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Mudah Digunakan</h2>
                    <p class="text-gray-600">3 langkah simpel untuk setiap transaksi</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-slate-700">1</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Pilih Layanan</h3>
                        <p class="text-gray-600">Cuci Kering, Cuci Setrika, atau layanan lainnya</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-slate-700">2</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Input Berat</h3>
                        <p class="text-gray-600">Masukkan berat laundry dalam kilogram</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-slate-700">3</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Simpan</h3>
                        <p class="text-gray-600">Total otomatis dihitung, langsung tersimpan</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing -->
        <section class="px-6 py-16 bg-white">
            <div class="max-w-xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Harga Terjangkau</h2>
                <p class="text-gray-600 mb-8">Investasi kecil untuk efisiensi besar</p>

                <div class="p-8 rounded-3xl border-2 border-slate-200 bg-gradient-to-br from-slate-50 to-slate-100">
                    <p class="text-sm text-slate-600 font-medium mb-2">Paket Bulanan</p>
                    <div class="flex items-end justify-center mb-4">
                        <span class="text-5xl font-extrabold text-gray-900">Rp 25.000</span>
                        <span class="text-gray-500 ml-2">/bulan</span>
                    </div>

                    <ul class="space-y-3 mb-8 text-left max-w-xs mx-auto">
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">Transaksi tanpa batas</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">Laporan lengkap</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">Data aman di cloud</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">7 hari uji coba gratis</span>
                        </li>
                    </ul>

                    <a href="{{ route('register') }}"
                        class="block w-full py-4 rounded-2xl gradient-bg text-white font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        Mulai Uji Coba Gratis
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="px-6 py-8 bg-gray-900 text-white">
            <div class="max-w-6xl mx-auto text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <div class="w-8 h-8 rounded-lg gradient-bg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold">QAISIR</span>
                </div>
                <p class="text-gray-400 text-sm mb-4">Kasir Laundry Simpel untuk UMKM Indonesia</p>
                <p class="text-gray-500 text-xs">&copy; {{ date('Y') }} QAISIR. Dibuat dengan ❤️ di Indonesia.</p>
            </div>
        </footer>
    </div>
</body>

</html>
