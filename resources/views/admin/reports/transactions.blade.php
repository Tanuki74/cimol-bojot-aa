<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded shadow">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="bg-[#9D3706] text-white p-4 rounded-t-lg">
                        <h2 class="text-xl font-bold">Riwayat Pesanan</h2>
                    </div>

                    <!-- Date Filter Form -->
                    <div class="bg-[#FFF7F0] p-6 mb-6 rounded-b-lg shadow-md">
                        <form action="{{ route('admin.reports.transactions') }}" method="GET" class="flex flex-wrap items-end gap-4">
                            <div class="w-full md:w-auto">
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dari</label>
                                <input type="date" id="start_date" name="start_date" value="{{ $startDate ?? '' }}" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#9D3706] focus:ring focus:ring-[#9D3706] focus:ring-opacity-50">
                            </div>
                            
                            <div class="w-full md:w-auto">
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai</label>
                                <input type="date" id="end_date" name="end_date" value="{{ $endDate ?? '' }}" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#9D3706] focus:ring focus:ring-[#9D3706] focus:ring-opacity-50">
                            </div>
                            
                            <div class="w-full md:w-auto">
                                <button type="submit" class="px-4 py-2 bg-[#9D3706] text-white rounded hover:bg-[#7A2805] transition">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Results Table -->
                    <div class="overflow-x-auto">
                        <div class="flex justify-end mb-4">
                            @if(count($orders) > 0 && $startDate && $endDate)
                                <a href="{{ route('admin.reports.transactions.download', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
                                   class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                    Unduh Laporan
                                </a>
                            @elseif(count($orders) > 0 && (!$startDate || !$endDate))
                                <button type="button" disabled 
                                    class="px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed">
                                    Unduh Laporan
                                </button>
                            @endif
                        </div>

                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-[#9D3706] text-white">
                                <tr>
                                    <th class="py-3 px-4 text-left">No</th>
                                    <th class="py-3 px-4 text-left">Tanggal</th>
                                    <th class="py-3 px-4 text-left">Customer</th>
                                    <th class="py-3 px-4 text-left">Produk</th>
                                    <th class="py-3 px-4 text-left">Quantity</th>
                                    <th class="py-3 px-4 text-left">Price Total</th>
                                    <th class="py-3 px-4 text-left">Metode Pengambilan</th>
                                    <th class="py-3 px-4 text-left">Status Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($orders as $index => $order)
                                    <tr class="hover:bg-yellow-50 transition">
                                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="py-3 px-4">{{ $order->user->name ?? 'User tidak tersedia' }}</td>
                                        <td class="py-3 px-4">{{ $order->product->name ?? 'Produk tidak tersedia' }}</td>
                                        <td class="py-3 px-4">{{ $order->quantity }}</td>
                                        <td class="py-3 px-4">
                                            @php
                                                $price = 0;
                                                if ($order->product && $order->product->categories) {
                                                    foreach ($order->product->categories as $category) {
                                                        if ($category->category == $order->category) {
                                                            $price = $category->price * $order->quantity;
                                                            break;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            {{ number_format($price, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4">{{ $order->metode_pengiriman }}</td>
                                        <td class="py-3 px-4">
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
                                            <span class="inline-block {{ $statusClass }} px-3 py-1 rounded-full text-xs font-semibold">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-6 text-center text-gray-500">
                                            Tidak ada data transaksi untuk periode yang dipilih.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
