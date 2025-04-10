<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-[#9D3706] overflow-hidden border border-3 border-[#700E0E] shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-yellow-300">Add New Product</h2>
                </div>

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" name="name" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Categories</label>
                        <div class="mt-1">
                            <div id="categoryContainer" class="space-y-4">
                                <!-- First category will be added by JavaScript -->
                            </div>
                            <button type="button" onclick="addCategory()" 
                                class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Add Category
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Product Image</label>
                        <p class="text-sm text-gray-500 mb-1">Hanya file gambar yang diperbolehkan (jpg, jpeg, png, gif, svg). Maksimal ukuran 2MB.</p>
                        <input type="file" name="image" 
                            accept="image/*"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('admin.products.index') }}" class="bg-gray-200 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" class="bg-[#700E0E] hover:bg-[#700E0E] text-white font-bold py-2 px-4 rounded">
                            Tambah Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function addCategory() {
    const container = document.getElementById('categoryContainer');
    const categoryCount = container.children.length;
    
    container.innerHTML += `
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" name="categories[${categoryCount}][category]" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Price</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="categories[${categoryCount}][price]" 
                        class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Stock</label>
                <input type="number" name="categories[${categoryCount}][stock]" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
        </div>
    `;
    
    if (categoryCount === 0) {
        // Add first category automatically
        addCategory();
    }
}
</script>
</x-app-layout>