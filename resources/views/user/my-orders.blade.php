<x-app-layout>
<main class="max-w-screen mx-auto py-10 px-4">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded shadow">{{ session('error') }}</div>
    @endif

    <div class="bg-[#FFF7F0] rounded-2xl shadow-xl p-8">
        <h2 class="text-3xl font-extrabold mb-6 text-[#9D3706]">Pesanan Saya</h2>
        
        @if($orders->isEmpty())
            <div class="bg-white rounded-xl p-8 text-center">
                <p class="text-lg text-gray-600">Anda belum memiliki pesanan.</p>
                <a href="{{ route('user.dashboard') }}" class="inline-block mt-4 px-6 py-2 bg-[#9D3706] text-white rounded-lg hover:bg-[#7A2805] transition">Belanja Sekarang</a>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md mb-6 overflow-hidden">
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-[#9D3706] sticky top-0 z-10 rounded-t-xl">
                                <tr>
                                    <th class="p-3 border-b text-yellow-200">Gambar</th>
                                    <th class="p-3 border-b text-yellow-200">Produk</th>
                                    <th class="p-3 border-b text-yellow-200">Bumbu</th>
                                    <th class="p-3 border-b text-yellow-200">Porsi</th>
                                    <th class="p-3 border-b text-yellow-200">Qty</th>
                                    <th class="p-3 border-b text-yellow-200">Pengiriman</th>
                                    <th class="p-3 border-b text-yellow-200">Tanggal</th>
                                    <th class="p-3 border-b text-yellow-200">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $date => $orderGroup)
                                    @foreach($orderGroup as $order)
                                        <tr class="hover:bg-yellow-50 transition">
                                            <td class="p-2 border-b align-middle">
                                                @if($order->product && $order->product->image)
                                                    <img src="{{ asset('storage/' . $order->product->image) }}" alt="{{ $order->product->name ?? 'Produk' }}" class="w-16 h-16 object-cover rounded shadow">
                                                @else
                                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                        <span class="text-gray-500 text-xs">No Image</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="p-2 border-b align-middle font-semibold text-[#9D3706]">
                                                {{ $order->product->name ?? 'Produk tidak tersedia' }}
                                            </td>
                                            <td class="p-2 border-b">{{ $order->bumbu_rasa ?? '-' }}</td>
                                            <td class="p-2 border-b">{{ $order->category ?? '-' }}</td>
                                            <td class="p-2 border-b align-middle">
                                                <span class="inline-block bg-yellow-200 text-[#9D3706] px-3 py-1 rounded-full font-bold shadow">{{ $order->quantity }}</span>
                                            </td>
                                            <td class="p-2 border-b">{{ $order->metode_pengiriman }}</td>
                                            <td class="p-2 border-b">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</td>
                                            <td class="p-2 border-b align-middle">
                                                @php
                                                    $statusClass = [
                                                        'paid' => 'bg-blue-100 text-blue-800',
                                                        'shipped' => 'bg-yellow-100 text-yellow-800',
                                                        'completed' => 'bg-green-100 text-green-800',
                                                        'canceled' => 'bg-red-100 text-red-800'
                                                    ][$order->status] ?? 'bg-gray-100 text-gray-800';
                                                    
                                                    $statusText = [
                                                        'paid' => 'Dibayar',
                                                        'shipped' => 'Dikirim',
                                                        'completed' => 'Selesai',
                                                        'canceled' => 'Dibatalkan'
                                                    ][$order->status] ?? $order->status;
                                                @endphp
                                                <div class="flex flex-col gap-2">
                                                    <span class="inline-block {{ $statusClass }} px-3 py-1 rounded-full font-semibold">
                                                        {{ $statusText }}
                                                    </span>
                                                    
                                                    @if($order->status === 'completed' && !$order->review)
                                                        <a href="{{ route('reviews.create', $order->id) }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded-full font-semibold text-xs text-center transition">
                                                            Beri Ulasan
                                                        </a>
                                                    @elseif($order->review)
                                                        <a href="{{ route('reviews.show', $order->id) }}" class="inline-block bg-teal-600 hover:bg-teal-700 text-white px-3 py-1 rounded-full font-semibold text-xs text-center transition">
                                                            Lihat Ulasan
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="mt-6">
            <a href="{{ route('user.dashboard') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Kembali ke Dashboard</a>
        </div>
    </div>
</main>
</x-app-layout>
