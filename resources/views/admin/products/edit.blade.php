<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-yellow-300">Edit Product</h2>
                </div>

                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-yellow-300">Name</label>
                        <input type="text" name="name" id="name" value="{{ $product->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-yellow-300">Category</label>
                        <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="Porsi Kecil" {{ $product->category == 'Porsi Kecil' ? 'selected' : '' }}>Porsi Kecil</option>
                            <option value="Porsi Besar" {{ $product->category == 'Porsi Besar' ? 'selected' : '' }}>Porsi Besar</option>
                        </select>
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-yellow-300">Stock</label>
                        <input type="number" name="stock" id="stock" value="{{ $product->stock }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-yellow-300">Price</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="price" id="price" value="{{ $product->price }}" min="0" step="0.01" class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-yellow-300">Product Image</label>
                        @if($product->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}" class="h-32 w-32 object-cover rounded">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full">
                        <p class="mt-1 text-sm text-yellow-300">Upload a new product image (JPEG, PNG, JPG up to 2MB) or leave empty to keep the current image</p>
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('admin.products.index') }}" class="bg-gray-200 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" class="bg-[#700E0E] hover:bg-[#700E0E] text-white font-bold py-2 px-4 rounded">
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
