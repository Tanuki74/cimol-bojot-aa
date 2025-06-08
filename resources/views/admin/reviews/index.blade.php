<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ulasan Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Filter by Product -->
                    <div class="mb-6">
                        <form action="{{ route('admin.reviews') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
                            <div class="w-full sm:w-1/3">
                                <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Filter berdasarkan Produk</label>
                                <select id="product_id" name="product_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#9D3706] focus:ring focus:ring-[#9D3706] focus:ring-opacity-50">
                                    <option value="">Semua Produk</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ $productId == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="px-4 py-2 bg-[#9D3706] text-white rounded hover:bg-[#7A2805] transition">
                                    Filter
                                </button>
                                @if($productId)
                                    <a href="{{ route('admin.reviews') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Reviews Table -->
                    @if($reviews->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">Belum ada ulasan yang diberikan oleh pelanggan.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-[#9D3706] text-white">
                                    <tr>
                                        <th class="py-3 px-4 text-left">Produk</th>
                                        <th class="py-3 px-4 text-left">Pelanggan</th>
                                        <th class="py-3 px-4 text-left">Metode Pengiriman</th>
                                        <th class="py-3 px-4 text-left">Komentar Pengiriman</th>
                                        <th class="py-3 px-4 text-left">Komentar Produk</th>
                                        <th class="py-3 px-4 text-left">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($reviews as $review)
                                        <tr class="hover:bg-yellow-50 transition">
                                            <td class="py-3 px-4">
                                                <div class="flex items-center space-x-3">
                                                    @if($review->product && $review->product->image)
                                                        <img src="{{ asset('storage/' . $review->product->image) }}" alt="{{ $review->product->name }}" class="w-12 h-12 object-cover rounded">
                                                    @else
                                                        <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                            <span class="text-xs text-gray-500">No image</span>
                                                        </div>
                                                    @endif
                                                    <span class="font-medium text-[#9D3706]">{{ $review->product->name ?? 'Produk tidak tersedia' }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4">
                                                {{ $review->user->name ?? 'User tidak tersedia' }}
                                            </td>
                                            <td class="py-3 px-4">
                                                {{ $review->order->metode_pengiriman ?? '-' }}
                                            </td>
                                            <td class="py-3 px-4">
                                                <div class="max-w-xs overflow-hidden">
                                                    <p class="text-sm text-gray-700">{{ $review->delivery_comment }}</p>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4">
                                                <div class="max-w-xs overflow-hidden">
                                                    <p class="text-sm text-gray-700">{{ $review->comment }}</p>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 whitespace-nowrap">
                                                {{ $review->created_at->format('d M Y, H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
