<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style type="text/css">
            .pattern{
                background: radial-gradient(
                    closest-side,
                    rgba(165, 158, 17, 1) 0%,
                    rgba(152, 0, 0, 1) 100%
                );
                position: relative;
                overflow: hidden;
            }
            .content-area {
                min-height: calc(100vh - 160px); /* Subtract header and footer height */
            }
        </style>
    </head>
    <body class="antialiased font-sans min-h-screen">
        <div class="pattern flex flex-col">
            <div class="relative flex-1 flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                        </div>
                    </header>
                    @if (Route::has('login'))
                        <livewire:welcome.navigation />
                    @endif
                    <main class="mt-6 flex-1">
                        <div class="py-5">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="mb-8">
                                    <h1 class="text-3xl font-bold text-yellow-300">Daftar Menu</h1>
                                </div>
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 min-h-[400px]">
                                @foreach($products->unique('name') as $product)
                                    @php
                                        $categories = $product->categories;
                                        $minPrice = $categories->min('price');
                                        $maxPrice = $categories->max('price');
                                        $totalStock = $categories->sum('stock');
                                    @endphp
                                    <div class="bg-white text-center overflow-hidden shadow-sm sm:rounded-lg">
                                        <div class="p-6">
                                            <a href="{{ route('login') }}">
                                                <div class="aspect-w-16 aspect-h-9 mb-4">
                                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                                        alt="{{ $product->name }}" 
                                                        class="w-full h-full object-cover rounded-lg">
                                                </div>
                                                <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $product->name }}</h2>
                                                <p class="text-xl font-bold text-red-600">
                                                    @if ($minPrice === $maxPrice)
                                                        Rp {{ number_format($minPrice, 0, ',', '.') }}
                                                    @else
                                                        Rp {{ number_format($minPrice, 0, ',', '.') }} - Rp {{ number_format($maxPrice, 0, ',', '.') }}
                                                    @endif
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </main>
                    <footer class="py-4 text-center text-sm text-black dark:text-white/70">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
