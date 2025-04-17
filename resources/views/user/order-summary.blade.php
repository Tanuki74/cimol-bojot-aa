<x-app-layout>
<main class="max-w-2xl mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-4">Ringkasan Pesanan</h2>
        <div class="mb-4">
            <span class="font-semibold">Metode Pengiriman:</span> {{ $metode }}
        </div>
        <table class="w-full text-left border-collapse mb-6">
            <thead>
                <tr>
                    <th class="p-2 border-b">Gambar</th>
                    <th class="p-2 border-b">Produk</th>
                    <th class="p-2 border-b">Bumbu</th>
                    <th class="p-2 border-b">Porsi</th>
                    <th class="p-2 border-b">Qty</th>
                    <th class="p-2 border-b">Harga</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <tr>
                        <td class="p-2 border-b"><img src="{{ asset('storage/products/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded"></td>
                        <td class="p-2 border-b">{{ $item['name'] }}</td>
                        <td class="p-2 border-b">{{ $item['bumbu_rasa'] ?? '-' }}</td>
                        <td class="p-2 border-b">{{ $item['category_name'] ?? '-' }}</td>
                        <td class="p-2 border-b">{{ $item['quantity'] }}</td>
                        <td class="p-2 border-b">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-xl font-bold mb-4">Total Bayar: Rp {{ number_format($total, 0, ',', '.') }}</div>
        <div class="mb-4">
            <span class="font-semibold">Scan QR untuk Pembayaran:</span>
            <div class="mt-2">
                {!! QrCode::size(180)->generate('Pembayaran pesanan CIMOLBOJOT, total: Rp ' . number_format($total, 0, ',', '.')) !!}
            </div>
        </div>
        <a href="{{ route('cart.view') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Kembali ke Keranjang</a>
    </div>
</main>
</x-app-layout>
