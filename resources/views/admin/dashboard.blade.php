<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-yellow-300 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    @if(isset($newOrdersCount) && $newOrdersCount > 0)
        <div class="mb-4">
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p class="font-bold">Ada {{ $newOrdersCount }} pesanan baru!</p>
                <p>Segera proses pesanan yang masuk melalui menu <a href="{{ route('admin.orders') }}" class="underline font-semibold">Pesanan Masuk</a>.</p>
            </div>
        </div>
    @endif
</x-app-layout>