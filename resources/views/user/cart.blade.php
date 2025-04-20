<x-app-layout>
<main class="max-w-screen mx-auto p-6">
    <div class="content-area bg-[#9D3706] mt-8 mb-8 p-6 rounded-2xl shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-yellow-300">Keranjang Belanja</h1>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 shadow">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 shadow">{{ session('error') }}</div>
        @endif
        @php $cart = session('cart', []); $total = 0; @endphp
        @if(count($cart) === 0)
            <div class="bg-[#9D3706]/10 rounded-xl py-12 px-4 text-center shadow text-yellow-300 font-semibold text-lg">Keranjang kosong.</div>
        @else
        <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse mb-8 rounded-xl shadow-lg bg-[#FFF7F0] p-4">
            <thead class="bg-[#700E0E] sticky top-0 z-10 rounded-t-xl">
                <tr>
                    <th class="p-3 border-b text-yellow-200">Gambar</th>
                    <th class="p-3 border-b text-yellow-200">Produk</th>
                    <th class="p-3 border-b text-yellow-200">Harga</th>
                    <th class="p-3 border-b text-yellow-200">Jumlah</th>
                    <th class="p-3 border-b text-yellow-200">Subtotal</th>
                    <th class="p-3 border-b text-yellow-200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $id => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <tr class="hover:bg-yellow-50 transition">
                        <td class="p-2 border-b align-middle"><img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded shadow"></td>
                        <td class="p-2 border-b align-middle font-semibold text-[#9D3706]">{{ $item['name'] }}</td>
                        <td class="p-2 border-b align-middle">
                            <span class="inline-block bg-yellow-200 text-[#9D3706] px-3 py-1 rounded-full font-bold shadow">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                        </td>
                        <td class="p-2 border-b align-middle">
                            <form action="{{ route('cart.update') }}" method="POST" style="display:inline-block">
                                @csrf
                                <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" class="w-16 form-input rounded text-center font-bold border-yellow-300 focus:ring-[#9D3706] focus:border-[#9D3706]" onchange="this.form.submit()">
                            </form>
                        </td>
                        <td class="p-2 border-b align-middle">
                            <span class="inline-block bg-yellow-100 text-[#9D3706] px-3 py-1 rounded-full font-semibold shadow">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </td>
                        <td class="p-2 border-b align-middle">
                            <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-3 py-1 rounded shadow transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <div class="flex justify-between items-center mt-4">
            <div class="text-xl font-bold text-yellow-300">Total: Rp {{ number_format($total, 0, ',', '.') }}</div>
        </div>
        <div class="mt-6" x-data="{ open: false }">
            <button @click="open = true" type="button" class="bg-green-600 text-white px-6 py-3 rounded-lg font-bold text-lg shadow hover:bg-green-700">Checkout</button>
            <!-- Modal Pop Up -->
            <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40" style="display: none;">
                <div class="bg-[#9D3706] rounded-xl shadow-xl w-full max-w-2xl p-8 relative text-center">
                    <h2 class="text-2xl font-bold text-white mb-2">Pilih Metode Pengambilan Pesanan</h2>
                    <p class="mb-8 text-yellow-200">Silakan pilih cara yang paling nyaman untuk menerima pesanan Anda:</p>
                    <form method="POST" action="{{ route('checkout.submit') }}" x-data="{ metode: 'Ambil di Gerai' }">
                        @csrf
                        <div class="flex flex-col sm:flex-row justify-center gap-8 mb-8">
                            <button type="button"
                                :class="metode === 'Ambil di Gerai' ? 'bg-yellow-100 ring-4 ring-yellow-300' : 'bg-white'"
                                class="flex flex-col items-center px-6 py-4 rounded-xl shadow-lg focus:outline-none transition-all duration-200 w-40 group"
                                @click.prevent="metode = 'Ambil di Gerai'">
                                <span class="bg-white rounded-full p-4 mb-2 shadow flex items-center justify-center">
                                    <img src="https://img.icons8.com/ios-filled/50/shop.png" alt="Ambil di Gerai" class="w-10 h-10">
                                </span>
                                <span class="mt-1 font-bold text-gray-700 group-hover:text-orange-700">Ambil di Gerai</span>
                            </button>
                            <button type="button"
                                :class="metode === 'Delivery' ? 'bg-yellow-100 ring-4 ring-yellow-300' : 'bg-white'"
                                class="flex flex-col items-center px-6 py-4 rounded-xl shadow-lg focus:outline-none transition-all duration-200 w-40 group"
                                @click.prevent="metode = 'Delivery'">
                                <span class="bg-white rounded-full p-4 mb-2 shadow flex items-center justify-center">
                                    <img src="https://img.icons8.com/ios-filled/50/delivery.png" alt="Diantar Ke Lokasi" class="w-10 h-10">
                                </span>
                                <span class="mt-1 font-bold text-gray-700 group-hover:text-orange-700">Diantar Ke Lokasi</span>
                            </button>
                        </div>
                        <input type="hidden" name="metode_pengiriman" :value="metode">
                        <div class="flex justify-end mt-4 space-x-2">
                            <button type="button" @click="open = false" class="px-5 py-2 bg-gray-200 rounded hover:bg-gray-300 font-semibold">Batal</button>
                            <button type="submit" class="px-5 py-2 bg-green-600 text-white rounded font-bold hover:bg-green-700">Konfirmasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</main>
</x-app-layout>

        <!-- Tambah Alpine.js jika belum ada -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
