<x-app-layout>
    <main class="mt-6 flex-1 content-area">
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="space-y-8">
                                <!-- Product Image -->
                                <div class="aspect-w-16 aspect-h-9">
                                    <img src="{{ asset('storage/products/' . $product->image) }}" 
                                        alt="{{ $product->name }}" 
                                        class="w-full h-full object-cover rounded-lg">
                                </div>

                                <!-- Product Details -->
                                <div>
                                    <div class="space-y-4">
                                    <p class="text-2xl font-bold text-gray-600">{{ $product->name }}</p>
                                    @php
                                        $categories = $product->categories;
                                        $minPrice = $categories->min('price');
                                        $maxPrice = $categories->max('price');
                                        $totalStock = $categories->sum('stock');
                                    @endphp
                                        <p class="text-xl font-bold text-red-600">
                                            @if ($minPrice === $maxPrice)
                                                Rp {{ number_format($minPrice, 0, ',', '.') }}
                                            @else
                                                Rp {{ number_format($minPrice, 0, ',', '.') }} - Rp {{ number_format($maxPrice, 0, ',', '.') }}
                                            @endif
                                        </p>
                                        <!-- Add to Cart Form -->
                                        @if(session('success'))
                                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-2">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        @if(session('error'))
                                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-2">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                        <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                                            <input type="hidden" name="redirect_to_cart" value="1">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="space-y-4">
                                                <div>
                                                <label class="block text-lg font-bold text-gray-700">Varian Bumbu Rasa</label>
                                                    <div class="space-y-4">
                                                        <div class="flex items-center">
                                                            <input type="radio" name="bumbu_rasa" value="Asin Pedas Level 0" 
                                                                class="form-radio h-4 w-4 text-red-600"
                                                                {{ $product->bumbu_rasa == 'Asin Pedas Level 0' ? 'checked' : '' }}>
                                                            <label class="ml-2 text-md text-gray-700">Asin Pedas Level 0</label>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <input type="radio" name="bumbu_rasa" value="Asin Pedas Level 1" 
                                                                class="form-radio h-4 w-4 text-red-600"
                                                                {{ $product->bumbu_rasa == 'Asin Pedas Level 1' ? 'checked' : '' }}>
                                                            <label class="ml-2 text-md text-gray-700">Asin Pedas Level 1</label>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <input type="radio" name="bumbu_rasa" value="Asin Pedas Level 2" 
                                                                class="form-radio h-4 w-4 text-red-600"
                                                                {{ $product->bumbu_rasa == 'Asin Pedas Level 2' ? 'checked' : '' }}>
                                                            <label class="ml-2 text-md text-gray-700">Asin Pedas Level 2</label>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <input type="radio" name="bumbu_rasa" value="Asin Pedas Level 3" 
                                                                class="form-radio h-4 w-4 text-red-600"
                                                                {{ $product->bumbu_rasa == 'Asin Pedas Level 3' ? 'checked' : '' }}>
                                                            <label class="ml-2 text-md text-gray-700">Asin Pedas Level 3</label>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <input type="radio" name="bumbu_rasa" value="Asin Pedas Level Extra" 
                                                                class="form-radio h-4 w-4 text-red-600"
                                                                {{ $product->bumbu_rasa == 'Asin Pedas Level Extra' ? 'checked' : '' }}>
                                                            <label class="ml-2 text-md text-gray-700">Asin Pedas Level Extra</label>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <input type="radio" name="bumbu_rasa" value="Ayam Bawang" 
                                                                class="form-radio h-4 w-4 text-red-600"
                                                                {{ $product->bumbu_rasa == 'Ayam Bawang' ? 'checked' : '' }}>
                                                            <label class="ml-2 text-md text-gray-700">Ayam Bawang</label>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <input type="radio" name="bumbu_rasa" value="Jagung Bakar" 
                                                                class="form-radio h-4 w-4 text-red-600"
                                                                {{ $product->bumbu_rasa == 'Jagung Bakar' ? 'checked' : '' }}>
                                                            <label class="ml-2 text-md text-gray-700">Jagung Bakar</label>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <input type="radio" name="bumbu_rasa" value="Balado" 
                                                                class="form-radio h-4 w-4 text-red-600"
                                                                {{ $product->bumbu_rasa == 'Balado' ? 'checked' : '' }}>
                                                            <label class="ml-2 text-md text-gray-700">Balado</label>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <input type="radio" name="bumbu_rasa" value="Barbeque" 
                                                                class="form-radio h-4 w-4 text-red-600"
                                                                {{ $product->bumbu_rasa == 'Barbeque' ? 'checked' : '' }}>
                                                            <label class="ml-2 text-md text-gray-700">Barbeque</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="flex flex-col space-y-4">
                                                        <p class="text-lg font-bold text-gray-700">Porsi</p>
                                                        @foreach ($product->categories as $category)
                                                            <div class="flex items-center justify-between">
                                                                <div class="flex items-center space-x-4">
                                                                    <input type="radio" name="category_id" value="{{ $category->id }}"
                                                                        class="form-radio h-4 w-4 text-red-600"
                                                                        {{ $loop->first ? 'checked' : '' }}>
                                                                    <label class="ml-2 text-md text-gray-700">
                                                                        {{ $category->category }}
                                                                        <span class="ml-2 text-gray-600">
                                                                            (Rp {{ number_format($category->price, 0, ',', '.') }})
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <p class="text-sm text-gray-600">
                                                                    Stock: {{ $category->stock }} 
                                                                </p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>
                                            <button type="submit" 
                                                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 w-full">
                                                Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<script>
function updateMaxQuantity() {
    const categoryId = document.querySelector('input[name="category_id"]:checked').value;
    const category = @json($product->categories);
    const selectedCategory = category.find(c => c.id == categoryId);
    const quantityInput = document.getElementById('quantity');
    quantityInput.max = selectedCategory.stock;
}
</script>
</x-app-layout>