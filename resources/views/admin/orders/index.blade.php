<x-app-layout>
    <main class="mt-6 flex-1 content-area">
        <div class="py-5">
            <div class="bg-[#9D3706] overflow-hidden shadow-sm sm:rounded-lg max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-8 mb-8">
                    <h1 class="text-3xl font-bold text-yellow-300">Pesanan Masuk</h1>
                </div>

                <div class="mb-10">
                    <h2 class="text-2xl font-semibold mb-4 text-yellow-300">Pesanan Pending</h2>
                    <div class="bg-[#FFF7F0] shadow-lg rounded-2xl mb-10">
                        <div class="p-6">
                            <div class="overflow-x-auto">
                                <table class="min-w-full rounded-xl shadow divide-y divide-gray-200">
                                    <thead class="bg-[#9D3706] sticky top-0 z-10">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Gambar</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Nama User</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Nama Produk</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Bumbu Rasa</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Kategori</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Harga</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Metode Pengiriman</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($pendingOrders as $order)
                                        <tr class="hover:bg-gray-100">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <img src="{{ asset('storage/' . $order->product->image) }}" 
                                                alt="{{ $order->product->name }}" 
                                                class="h-16 w-16 object-cover rounded">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->product->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->bumbu_rasa }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->category }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $cat = $order->product->categories->where('category', $order->category)->first();
                                            @endphp
                                            @if($cat)
                                                Rp {{ number_format($cat->price, 0, ',', '.') }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->metode_pengiriman }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 text-xs font-bold rounded-full shadow @if($order->status == 'paid') bg-yellow-200 text-yellow-900 border border-yellow-400 @elseif($order->status == 'shipped') bg-blue-200 text-blue-900 border border-blue-400 @elseif($order->status == 'completed') bg-green-200 text-green-900 border border-green-400 @else bg-red-200 text-red-900 border border-red-400 @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($order->metode_pengiriman == 'Delivery' && $order->status == 'paid')
                                                <form method="POST" action="{{ route('admin.orders.shipped', $order->id) }}" style="display:inline">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Tandai pesanan ini sudah dikirim?')" class="text-blue-600 hover:text-blue-900">
                                                        Kirim
                                                    </button>
                                                </form>
                                            @elseif($order->status == 'paid' || $order->status == 'shipped')
                                                <form method="POST" action="{{ route('admin.orders.complete', $order->id) }}" style="display:inline">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menandai pesanan ini sebagai selesai?')" class="text-green-600 hover:text-green-900">
                                                        Selesai
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mb-10">
                        <h2 class="text-2xl font-semibold mb-4 text-yellow-300">Pesanan Selesai</h2>
                        <div class="bg-[#F0FFF7] shadow-lg rounded-2xl mb-10">
                            <div class="p-6">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full rounded-xl shadow divide-y divide-gray-200">
                                        <thead class="bg-[#9D3706] sticky top-0 z-10">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Gambar</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Nama User</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Nama Produk</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Bumbu Rasa</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Kategori</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Harga</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Metode Pengiriman</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-yellow-200 uppercase tracking-wider">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($completedOrders as $order)
                                            <tr class="hover:bg-gray-100">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <img src="{{ asset('storage/' . $order->product->image) }}" 
                                                        alt="{{ $order->product->name }}" 
                                                        class="h-16 w-16 object-cover rounded">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->product->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->bumbu_rasa }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->category }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $cat = $order->product->categories->where('category', $order->category)->first();
                                                    @endphp
                                                    @if($cat)
                                                        Rp {{ number_format($cat->price, 0, ',', '.') }}
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->metode_pengiriman }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>