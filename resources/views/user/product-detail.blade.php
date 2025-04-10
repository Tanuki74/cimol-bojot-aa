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
                                        <p class="text-xl font-bold text-red-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <!-- Add to Cart Form -->
                                        <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="space-y-2">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Varian Bumbu Rasa</label>
                                                    <div class="flex items-center space-x-4">
                                                        <div class="flex items-center">
                                                            <input type="radio" name="bumbu_rasa" value="Original" 
                                                                class="form-radio h-4 w-4 text-red-600"
                                                                {{ $product->bumbu_rasa == 'Original' ? 'checked' : '' }}>
                                                            <label class="ml-2 text-sm text-gray-700">Original</label>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <input type="radio" name="bumbu_rasa" value="Pedas" 
                                                                class="form-radio h-4 w-4 text-red-600"
                                                                {{ $product->bumbu_rasa == 'Pedas' ? 'checked' : '' }}>
                                                            <label class="ml-2 text-sm text-gray-700">Pedas</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="flex flex-col space-y-4">
                                                        @foreach ($product->categories as $category)
                                                            <div class="flex items-center justify-between">
                                                                <div class="flex items-center space-x-4">
                                                                    <input type="radio" name="category_id" value="{{ $category->id }}"
                                                                        class="form-radio h-4 w-4 text-red-600"
                                                                        {{ $loop->first ? 'checked' : '' }}>
                                                                    <label class="ml-2 text-sm text-gray-700">
                                                                        {{ $category->category }}
                                                                        <span class="ml-2 text-gray-600">
                                                                            (Rp {{ number_format($category->price, 0, ',', '.') }})
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <p class="text-sm text-gray-600">
                                                                    Stock: {{ $category->stock }} unit
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