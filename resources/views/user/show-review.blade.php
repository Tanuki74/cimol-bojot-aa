<x-app-layout>
<main class="max-w-screen mx-auto py-10 px-4">
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded shadow">{{ session('error') }}</div>
    @endif

    <div class="bg-[#FFF7F0] rounded-2xl shadow-xl p-8">
        <h2 class="text-3xl font-extrabold mb-6 text-[#9D3706]">Ulasan Saya</h2>
        
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
                        
                        <div class="mt-6 bg-yellow-50 p-4 rounded-lg">
                            <div class="mb-4">
                                <h4 class="font-bold text-[#9D3706] mb-2">Komentar Pengiriman:</h4>
                                <p class="text-gray-700">{{ $order->review->delivery_comment }}</p>
                            </div>
                            
                            <div>
                                <h4 class="font-bold text-[#9D3706] mb-2">Komentar Produk:</h4>
                                <p class="text-gray-700">{{ $order->review->comment }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-6 text-right">
                            <a href="{{ route('user.my-orders') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Kembali ke Pesanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</x-app-layout>
