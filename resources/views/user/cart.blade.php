<x-app-layout>
<main class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Keranjang Belanja</h1>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-2">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-2">
            {{ session('error') }}
        </div>
    @endif
    @php $cart = session('cart', []); $total = 0; @endphp
    @if(count($cart) === 0)
        <p class="text-gray-600">Keranjang kosong.</p>
    @else
    <div class="overflow-x-auto">
    <table class="w-full text-left border-collapse mb-4">
        <thead>
            <tr>
                <th class="p-2 border-b">Gambar</th>
                <th class="p-2 border-b">Produk</th>
                <th class="p-2 border-b">Harga</th>
                <th class="p-2 border-b">Jumlah</th>
                <th class="p-2 border-b">Subtotal</th>
                <th class="p-2 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $id => $item)
                @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                <tr>
                    <td class="p-2 border-b"><img src="{{ asset('storage/products/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded"></td>
                    <td class="p-2 border-b">{{ $item['name'] }}</td>
                    <td class="p-2 border-b">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td class="p-2 border-b">
                        <form action="{{ route('cart.update') }}" method="POST" style="display:inline-block">
                            @csrf
                            <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" class="w-16 form-input" onchange="this.form.submit()">
                        </form>
                    </td>
                    <td class="p-2 border-b">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    <td class="p-2 border-b">
                        <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <div class="flex justify-between items-center">
        <div class="text-xl font-bold">Total: Rp {{ number_format($total, 0, ',', '.') }}</div>
    </div>
    <div class="mt-6" x-data="{ open: false }">
        <button @click="open = true" type="button" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Checkout</button>
        <!-- Modal Pop Up -->
        <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40" style="display: none;">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
                <h2 class="text-xl font-bold mb-4">Pilih Metode Pengiriman</h2>
                <form method="POST" action="{{ route('checkout.submit') }}">
                    @csrf
                    <div class="space-y-4">
                        <label class="flex items-center">
                            <input type="radio" name="metode_pengiriman" value="Ambil di Toko" class="form-radio h-4 w-4 text-green-600" checked>
                            <span class="ml-2">Ambil di Toko</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="metode_pengiriman" value="Delivery" class="form-radio h-4 w-4 text-green-600">
                            <span class="ml-2">Delivery</span>
                        </label>
                        <!-- Tambahkan opsi lain jika perlu -->
                    </div>
                    <div class="flex justify-end mt-6 space-x-2">
                        <button type="button" @click="open = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</main>
</x-app-layout>

        <!-- Tambah Alpine.js jika belum ada -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
