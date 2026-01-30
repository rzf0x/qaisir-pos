<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="theme-color" content="#1e293b">
    <meta name="description" content="{{ $laundry->description ?: 'Laundry ' . $laundry->name }}">

    <title>{{ $laundry->name }} - QAISIR</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50" style="font-family: 'Inter', sans-serif;">
    <!-- Header -->
    <header class="gradient-bg">
        <div class="max-w-lg mx-auto px-4 py-8 text-center">
            <!-- Logo -->
            <div class="w-20 h-20 rounded-2xl bg-white/20 flex items-center justify-center mx-auto mb-4">
                <span class="text-white font-bold text-3xl">{{ substr($laundry->name, 0, 1) }}</span>
            </div>

            <h1 class="text-2xl font-bold text-white mb-2">{{ $laundry->name }}</h1>

            @if ($laundry->description)
                <p class="text-slate-300 text-sm">{{ $laundry->description }}</p>
            @endif
        </div>
    </header>

    <!-- Content -->
    <main class="max-w-lg mx-auto px-4 py-6 -mt-4">
        <!-- Contact Info -->
        @if ($laundry->phone || $laundry->address)
            <div class="bg-white rounded-2xl card-shadow p-5 mb-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Informasi Kontak</h2>

                @if ($laundry->phone)
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Telepon</p>
                            <a href="tel:{{ $laundry->phone }}" class="font-medium text-slate-800 hover:text-green-600">
                                {{ $laundry->phone }}
                            </a>
                        </div>
                    </div>
                @endif

                @if ($laundry->address)
                    <div class="flex items-start">
                        <div
                            class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Alamat</p>
                            <p class="font-medium text-slate-800">{{ $laundry->address }}</p>
                        </div>
                    </div>
                @endif

                @if ($laundry->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $laundry->phone) }}?text=Halo, saya ingin tanya tentang layanan laundry"
                        target="_blank"
                        class="mt-4 w-full flex items-center justify-center px-6 py-3 rounded-xl bg-green-500 text-white font-medium hover:bg-green-600 transition-colors">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        Chat via WhatsApp
                    </a>
                @endif
            </div>
        @endif

        <!-- Services -->
        <div class="bg-white rounded-2xl card-shadow p-5 mb-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Layanan Kami</h2>

            @if ($services->count() > 0)
                <div class="space-y-3">
                    @foreach ($services as $service)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="font-medium text-slate-800">{{ $service->name }}</span>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-slate-800">Rp
                                    {{ number_format($service->price_per_kg, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">per kg</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada layanan tersedia</p>
            @endif
        </div>

        <!-- CTA -->
        @if ($laundry->phone)
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-3">Ingin cuci laundry?</p>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $laundry->phone) }}?text=Halo, saya ingin order laundry"
                    target="_blank"
                    class="inline-flex items-center px-8 py-4 rounded-2xl gradient-bg text-white font-semibold shadow-lg hover:shadow-xl transition-shadow">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Hubungi Kami
                </a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="text-center py-6 text-sm text-gray-400">
        <p>Powered by <a href="{{ url('/') }}" class="text-slate-600 hover:text-slate-800">QAISIR</a></p>
    </footer>
</body>

</html>
