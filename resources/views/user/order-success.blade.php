<x-app-layout>
    <main class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-[#9D3706] rounded-lg shadow p-6 text-center">
            <h2 class="text-2xl font-bold mb-4 text-yellow-300">Pesanan Berhasil!</h2>
            <p class="mb-6 text-yellow-100">Terima kasih, pesanan Anda telah berhasil dikirim.<br>Silakan cek halaman riwayat pesanan atau tunggu konfirmasi dari admin.</p>
            <a href="{{ route('user.dashboard') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Kembali ke Dashboard</a>
        </div>
    </main>
</x-app-layout>
