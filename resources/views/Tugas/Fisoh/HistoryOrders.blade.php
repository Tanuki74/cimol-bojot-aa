<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            Riwayat Pesanan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div style="background:#9D3706; border:4px solid #700E0E; box-shadow: 0 4px 6px rgba(0,0,0,0.1);" class="sm:rounded-lg p-6">
                <div style="background:white; border-radius:0.375rem; overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; border:1px solid #ccc;">
                    <thead>
                        <tr>
                            <th style="color:white; background-color:black; padding:12px; border:1px solid gray;">Image</th>
                            <th style="color:white; background-color:black; padding:12px; border:1px solid gray;">Name</th>
                            <th style="color:white; background-color:black; padding:12px; border:1px solid gray;">Category</th>
                            <th style="color:white; background-color:black; padding:12px; border:1px solid gray;">Quantity</th>
                            <th style="color:white; background-color:black; padding:12px; border:1px solid gray;">Total Price</th>
                            <th style="color:white; background-color:black; padding:12px; border:1px solid gray;">Metode Pengambilan</th>
                            <th style="color:white; background-color:black; padding:12px; border:1px solid gray;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr style="background:white; color:black;">
                                <td style="border:1px solid #ccc; padding:12px;">
                                    <img src="{{ asset('storage/products/' . $order->product->image) }}" alt="{{ $order->product->name }}" class="w-16 h-16 object-cover rounded">
                                </td>
                                <td style="border:1px solid #ccc; padding:12px;">{{ $order->product->name }}</td>
                                <td style="border:1px solid #ccc; padding:12px;">
                                    @foreach ($order->product->categories as $category)
                                        {{ $category->name }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </td>
                                <td style="border:1px solid #ccc; padding:12px;">{{ $order->quantity }}</td>
                                <td style="border:1px solid #ccc; padding:12px;">
                                    @foreach ($order->product->categories as $category)
                                        {{ number_format($category->price, 2) }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </td>
                                <td style="border:1px solid #ccc; padding:12px;">{{ $order->metode_pengiriman }}</td>
                                <td style="border:1px solid #ccc; padding:12px;">
                                    <a href="#" class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-4 py-2 rounded">
                                        Lihat Ulasan
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>