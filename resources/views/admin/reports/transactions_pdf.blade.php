<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            background-color: #9D3706;
            color: white;
            padding: 10px 15px;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        .date-range {
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status {
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: bold;
        }
        .status-paid {
            background-color: #e6f3ff;
            color: #0066cc;
        }
        .status-shipped {
            background-color: #fff8e6;
            color: #cc8800;
        }
        .status-completed {
            background-color: #e6ffe6;
            color: #008800;
        }
        .status-canceled {
            background-color: #ffe6e6;
            color: #cc0000;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        CIMOLBOJOT - LAPORAN TRANSAKSI
    </div>
    
    <div class="date-range">
        <strong>Periode:</strong> 
        {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : 'Semua' }} 
        sampai 
        {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : 'Sekarang' }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Produk</th>
                <th>Quantity</th>
                <th>Price Total</th>
                <th>Metode Pengambilan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalQuantity = 0;
                $totalPrice = 0;
            @endphp
            
            @forelse($orders as $index => $order)
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
                    $totalQuantity += $order->quantity;
                    $totalPrice += $price;
                    
                    $statusClass = '';
                    switch($order->status) {
                        case 'paid':
                            $statusClass = 'status-paid';
                            break;
                        case 'shipped':
                            $statusClass = 'status-shipped';
                            break;
                        case 'completed':
                            $statusClass = 'status-completed';
                            break;
                        case 'canceled':
                            $statusClass = 'status-canceled';
                            break;
                    }
                    
                    $statusText = [
                        'paid' => 'Dibayar',
                        'shipped' => 'Dikirim',
                        'completed' => 'Selesai',
                        'canceled' => 'Dibatalkan'
                    ][$order->status] ?? $order->status;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>{{ $order->user->name ?? 'User tidak tersedia' }}</td>
                    <td>{{ $order->product->name ?? 'Produk tidak tersedia' }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>Rp {{ number_format($price, 0, ',', '.') }}</td>
                    <td>{{ $order->metode_pengiriman }}</td>
                    <td><span class="status {{ $statusClass }}">{{ $statusText }}</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">
                        Tidak ada data transaksi untuk periode yang dipilih.
                    </td>
                </tr>
            @endforelse
            
            @if(count($orders) > 0)
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;">Total:</td>
                    <td>{{ $totalQuantity }}</td>
                    <td>Rp {{ number_format($totalPrice, 0, ',', '.') }}</td>
                    <td colspan="2"></td>
                </tr>
            @endif
        </tbody>
    </table>
    
    <div class="footer">
        Laporan dibuat pada: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}
    </div>
</body>
</html>
