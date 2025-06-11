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
    
    <!-- Statistics Cards -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Today's Revenue -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition-transform duration-300 transform hover:scale-105">
                    <div class="p-6 bg-gradient-to-r from-[#9D3706] to-[#BF6A36] text-white">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold">Pendapatan Hari Ini</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-3xl font-bold">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>
                
                <!-- Monthly Revenue -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition-transform duration-300 transform hover:scale-105">
                    <div class="p-6 bg-[#FFF7F0] text-[#9D3706] border-t-4 border-[#9D3706]">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold">Pendapatan Bulan Ini</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#9D3706] opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-3xl font-bold">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>
                
                <!-- Total Orders -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition-transform duration-300 transform hover:scale-105">
                    <div class="p-6 bg-gradient-to-r from-[#9D3706] to-[#BF6A36] text-white">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold">Total Pesanan</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <p class="text-3xl font-bold">{{ $totalOrders }}</p>
                        <div class="flex justify-between text-sm mt-3 bg-white bg-opacity-20 p-2 rounded">
                            <span>Selesai: <span class="font-bold">{{ $completedOrders }}</span></span>
                            <span>Dibatalkan: <span class="font-bold">{{ $canceledOrders }}</span></span>
                        </div>
                    </div>
                </div>
                
                <!-- New Orders -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition-transform duration-300 transform hover:scale-105">
                    <div class="p-6 bg-[#FFF7F0] text-[#9D3706] border-t-4 border-[#9D3706]">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold">Pesanan Baru</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#9D3706] opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <p class="text-3xl font-bold">{{ $newOrdersCount }}</p>
                        @if($newOrdersCount > 0)
                            <a href="{{ route('admin.orders') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-[#9D3706] text-white text-sm font-medium rounded-md hover:bg-[#7A2805] transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat Pesanan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Charts Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Bar Chart - Last 7 Days Revenue -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300 hover:shadow-lg">
                    <div class="p-4 bg-gradient-to-r from-[#9D3706] to-[#BF6A36] text-white flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Pendapatan 7 Hari Terakhir</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                    <div class="p-6 bg-white">
                        <canvas id="revenueChart" height="300"></canvas>
                    </div>
                </div>
                
                <!-- Pie Chart - Revenue by Category -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300 hover:shadow-lg">
                    <div class="p-4 bg-gradient-to-r from-[#9D3706] to-[#BF6A36] text-white flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Pendapatan per Kategori</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                    <div class="p-6 bg-white">
                        <canvas id="categoryChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Data from controller
        const last7DaysLabels = @json($last7DaysLabels);
        const last7DaysData = @json($last7DaysData);
        const categoryLabels = @json($categoryLabels);
        const categoryData = @json($categoryData);
        
        // Bar Chart - Last 7 Days Revenue
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: last7DaysLabels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: last7DaysData,
                    backgroundColor: '#9D3706',
                    borderColor: '#7A2805',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                        }
                    }
                }
            }
        });
        
        // Pie Chart - Revenue by Category
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryData,
                    backgroundColor: [
                        '#9D3706',
                        '#D9A566',
                        '#F2C879',
                        '#8C5E58',
                        '#593E25',
                        '#BF8969'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = 'Rp ' + context.raw.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                return `${label}: ${value}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>