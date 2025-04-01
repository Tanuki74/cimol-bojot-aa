<x-app-layout>
    <main class="mt-6 flex-1 content-area">
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Our Products</h1>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 min-h-[400px]">
                    @if($products->isEmpty())
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-600">No products available at the moment</p>
                        </div>
                    @else
                        @foreach($products as $product)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <div class="aspect-w-16 aspect-h-9 mb-4">
                                        <img src="{{ asset('storage/products/' . $product->image) }}" 
                                            alt="{{ $product->name }}" 
                                            class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $product->name }}</h2>
                                                            <p class="text-gray-600 mb-2">{{ $product->category->name }}</p>
                                                            <p class="text-xl font-bold text-red-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="text-gray-500 mt-2">Stock: {{ $product->stock }} units</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </main>
    <footer class="py-4 text-center text-sm text-black dark:text-white/70">
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </footer>
</x-app-layout>