<x-app-layout>
<main class="max-w-screen mx-auto py-10 px-4">
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded shadow">{{ session('error') }}</div>
    @endif

    <div class="bg-[#FFF7F0] rounded-2xl shadow-xl p-8">
        <h2 class="text-3xl font-extrabold mb-6 text-[#9D3706]">Beri Ulasan</h2>
        
        <div class="bg-white rounded-xl shadow-md mb-6 overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="md:w-1/3">
                        @if($order->product && $order->product->image)
                            <img src="{{ asset('storage/' . $order->product->image) }}" alt="{{ $order->product->name ?? 'Produk' }}" class="w-full h-auto object-cover rounded-lg shadow">
                        @else
                            <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-500">Gambar tidak tersedia</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="md:w-2/3">
                        <h3 class="text-xl font-bold text-[#9D3706] mb-2">{{ $order->product->name ?? 'Produk tidak tersedia' }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-gray-600 text-sm">Bumbu:</p>
                                <p class="font-semibold">{{ $order->bumbu_rasa ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Porsi:</p>
                                <p class="font-semibold">{{ $order->category ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Jumlah:</p>
                                <p class="font-semibold">{{ $order->quantity }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Metode Pengiriman:</p>
                                <p class="font-semibold">{{ $order->metode_pengiriman }}</p>
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('reviews.store', $order->id) }}" class="mt-6">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="delivery_comment" class="block text-gray-700 font-semibold mb-2">Komentar Pengiriman:</label>
                                <textarea id="delivery_comment" name="delivery_comment" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#9D3706]" placeholder="Bagaimana pengalaman Anda dengan metode pengiriman {{ $order->metode_pengiriman }}?">{{ old('delivery_comment') }}</textarea>
                                @error('delivery_comment')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="comment" class="block text-gray-700 font-semibold mb-2">Komentar:</label>
                                <textarea id="comment" name="comment" rows="4" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#9D3706]" placeholder="Bagikan pengalaman Anda dengan produk ini...">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('user.my-orders') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">Batal</a>
                                <button type="submit" class="px-4 py-2 bg-[#9D3706] text-white rounded hover:bg-[#7A2805] transition">Kirim Ulasan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</x-app-layout>
