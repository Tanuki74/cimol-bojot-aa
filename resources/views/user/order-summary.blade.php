<x-app-layout>
<main class="max-w-screen mx-auto py-10 px-4">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">{{ session('success') }}</div>
    @endif

    <div class="bg-[#FFF7F0] rounded-2xl shadow-xl p-8">
        <h2 class="text-3xl font-extrabold mb-6 text-[#9D3706]">Ringkasan Pesanan</h2>
        <div class="mb-6 flex items-center gap-3">
            <span class="font-semibold text-[#9D3706]">Metode Pengiriman:</span>
            <span class="inline-block bg-yellow-200 text-[#9D3706] font-bold px-4 py-1 rounded-full shadow">{{ $metode }}</span>
        </div>
        <div class="overflow-x-auto rounded-xl">
        <table class="w-full text-left border-collapse mb-6 bg-white rounded-xl shadow">
            <thead class="bg-[#9D3706] sticky top-0 z-10 rounded-t-xl">
                <tr>
                    <th class="p-3 border-b text-yellow-200">Gambar</th>
                    <th class="p-3 border-b text-yellow-200">Produk</th>
                    <th class="p-3 border-b text-yellow-200">Bumbu</th>
                    <th class="p-3 border-b text-yellow-200">Porsi</th>
                    <th class="p-3 border-b text-yellow-200">Qty</th>
                    <th class="p-3 border-b text-yellow-200">Harga</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <tr class="hover:bg-yellow-50 transition">
                        <td class="p-2 border-b align-middle"><img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded shadow"></td>
                        <td class="p-2 border-b align-middle font-semibold text-[#9D3706]">{{ $item['name'] }}</td>
                        <td class="p-2 border-b">{{ $item['bumbu_rasa'] ?? '-' }}</td>
                        <td class="p-2 border-b">{{ $item['category_name'] ?? '-' }}</td>
                        <td class="p-2 border-b align-middle">
                            <span class="inline-block bg-yellow-200 text-[#9D3706] px-3 py-1 rounded-full font-bold shadow">{{ $item['quantity'] }}</span>
                        </td>
                        <td class="p-2 border-b align-middle">
                            <span class="inline-block bg-yellow-100 text-[#9D3706] px-3 py-1 rounded-full font-semibold shadow">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="bg-white rounded-2xl shadow-md p-6 mt-4">
            <div class="text-xl font-bold mb-4">Total Bayar: Rp {{ number_format($total, 0, ',', '.') }}</div>
            <div class="flex flex-col items-center justify-center">
                <span class="font-semibold">Scan QR untuk Pembayaran:</span>
                <div class="mt-2 mb-6">
                    {!! QrCode::size(180)->generate('Pembayaran pesanan CIMOLBOJOT, total: Rp ' . number_format($total, 0, ',', '.')) !!}
                </div>
                <div class="flex flex-col sm:flex-row gap-4 w-full justify-center">
                    <form method="POST" action="{{ route('order.place') }}">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-semibold">Pesan</button>
                    </form>
                    <form method="POST" action="{{ route('order.cancel') }}">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold">Batalkan Pesanan</button>
                    </form>
                    <a href="{{ route('cart.view') }}" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-center font-semibold">Kembali ke Keranjang</a>
                </div>
            </div>
        </div>
    </div>
</main>
</x-app-layout>
