<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1e293b">
    <meta name="description" content="QAISIR - Kasir Laundry Simpel untuk UMKM Indonesia">

    <title>{{ config('app.name', 'QAISIR') }} - Kasir Laundry</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 4px;
        }

        /* Safe area for mobile */
        .safe-bottom {
            padding-bottom: env(safe-area-inset-bottom, 1rem);
        }

        /* Glass effect */
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Primary gradient background - Slate */
        .gradient-bg {
            background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
        }

        /* Light slate gradient */
        .gradient-bg-light {
            background: linear-gradient(135deg, #334155 0%, #64748b 100%);
        }

        /* Card shadow */
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Animate pulse for numbers */
        @keyframes number-pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.02);
            }
        }

        .number-animate:hover {
            animation: number-pulse 0.5s ease-in-out;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50" style="font-family: 'Inter', sans-serif;">
    <div class="min-h-screen pb-20" x-data="{ mobileMenuOpen: false }">
        <!-- Top Header -->
        <header class="glass sticky top-0 z-40 border-b border-gray-200/50">
            <div class="px-4 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl gradient-bg flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-800">QAISIR</h1>
                        <p class="text-xs text-gray-500">Kasir Laundry</p>
                    </div>
                </div>

                <!-- Subscription Badge -->
                @if (auth()->user()->laundry && auth()->user()->laundry->subscription)
                    @php $sub = auth()->user()->laundry->subscription; @endphp
                    <a href="{{ route('subscription.status') }}"
                        class="flex items-center space-x-1 px-3 py-1.5 rounded-full text-xs font-medium
                            @if ($sub->status === 'trial') bg-amber-100 text-amber-700
                            @elseif($sub->status === 'active') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                        <span
                            class="w-2 h-2 rounded-full 
                                @if ($sub->status === 'trial') bg-amber-500 animate-pulse
                                @elseif($sub->status === 'active') bg-green-500
                                @else bg-red-500 @endif"></span>
                        <span>{{ $sub->status_label }}</span>
                    </a>
                @endif
            </div>
        </header>

        <!-- Flash Messages -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed top-16 left-4 right-4 z-50">
                <div class="bg-green-500 text-white px-4 py-3 rounded-xl shadow-lg flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="ml-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="fixed top-16 left-4 right-4 z-50">
                <div class="bg-red-500 text-white px-4 py-3 rounded-xl shadow-lg flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="ml-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main class="px-4 py-4">
            {{ $slot }}
        </main>

        <!-- Bottom Navigation -->
        <nav class="fixed bottom-0 left-0 right-0 glass border-t border-gray-200/50 z-50 safe-bottom">
            <div class="flex items-center justify-around py-2">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    class="flex flex-col items-center py-2 px-4 rounded-xl transition-all duration-200
                              {{ request()->routeIs('dashboard') ? 'text-slate-800 bg-slate-100' : 'text-gray-500 hover:text-slate-800' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-xs mt-1 font-medium">Beranda</span>
                </a>

                <!-- New Transaction (Center Button - Prominent) -->
                <a href="{{ route('transactions.create') }}" class="flex flex-col items-center -mt-6">
                    <div
                        class="w-14 h-14 rounded-2xl gradient-bg flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-200">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="text-xs mt-1 font-medium text-slate-700">Transaksi</span>
                </a>

                <!-- Menu -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex flex-col items-center py-2 px-4 rounded-xl transition-all duration-200
                                       {{ request()->routeIs('services.*') || request()->routeIs('reports.*') || request()->routeIs('transactions.index') ? 'text-slate-800 bg-slate-100' : 'text-gray-500 hover:text-slate-800' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span class="text-xs mt-1 font-medium">Menu</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute bottom-full right-0 mb-2 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden"
                        x-cloak>
                        <a href="{{ route('transactions.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-slate-50 transition-colors">
                            <svg class="w-5 h-5 mr-3 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span class="text-sm font-medium">Riwayat Transaksi</span>
                        </a>
                        <a href="{{ route('reports.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-slate-50 transition-colors">
                            <svg class="w-5 h-5 mr-3 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span class="text-sm font-medium">Laporan Usaha</span>
                        </a>
                        <a href="{{ route('services.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-slate-50 transition-colors">
                            <svg class="w-5 h-5 mr-3 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span class="text-sm font-medium">Layanan Laundry</span>
                        </a>
                        <hr class="my-1 border-gray-100">
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-slate-50 transition-colors">
                            <svg class="w-5 h-5 mr-3 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm font-medium">Profil Saya</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span class="text-sm font-medium">Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</body>

</html>
