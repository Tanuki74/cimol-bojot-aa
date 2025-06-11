<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-[#9D3706] overflow-hidden border border-3 border-[#700E0E] shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-yellow-300">Kelola Produk</h2>
                    <a href="{{ route('admin.products.create') }}" class="bg-[#700E0E] hover:bg-[#700E0E] text-white font-bold py-2 px-4 rounded">
                        Tambah Produk
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#700E0E]">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Image</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                            alt="{{ $product->name }}" 
                                            class="h-16 w-16 object-cover rounded">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-lg font-semibold text-gray-900">{{ $product->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap align-top">
                                        @if($product->categories->count() > 0)
                                            <div class="flex flex-col gap-1">
                                                @foreach($product->categories as $cat)
                                                    <span class="px-2 py-1 text-center text-xs font-semibold rounded @if(Str::contains(strtolower($cat->category), 'kecil')) bg-[#9D3706] text-white @elseif(Str::contains(strtolower($cat->category), 'besar')) bg-[#9D3706] text-white @else bg-gray-200 text-gray-800 @endif">
                                                        {{ $cat->category }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap align-top">
                                        @if($product->categories->count() > 0)
                                            <div class="flex flex-col gap-1">
                                                @foreach($product->categories as $cat)
                                                    <span class="block text-sm text-gray-600">Rp {{ number_format($cat->price, 0, ',', '.') }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap align-top">
                                        @if($product->categories->count() > 0)
                                            <div class="flex flex-col gap-1">
                                                @foreach($product->categories as $cat)
                                                    <span class="block text-sm text-gray-600">{{ $cat->stock }} unit</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.products.edit', $product) }}" 
                                                class="text-indigo-600 hover:text-indigo-900">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" 
                                                method="POST" 
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="text-red-600 hover:text-red-900">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
