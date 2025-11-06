<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9px;
            color: #333;
            padding: 15px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #2563EB;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 18px;
            color: #1e40af;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 14px;
            color: #666;
            font-weight: normal;
        }
        
        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            width: 120px;
            padding: 3px 0;
            font-weight: bold;
        }
        
        .info-value {
            display: table-cell;
            padding: 3px 0;
        }
        
        .stats-box {
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
        }
        
        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 5px;
        }
        
        .stat-label {
            font-size: 8px;
            color: #666;
            text-transform: uppercase;
        }
        
        .stat-value {
            font-size: 13px;
            font-weight: bold;
            color: #1e40af;
            margin-top: 3px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        table thead {
            background: #2563EB;
            color: white;
        }
        
        table th {
            padding: 8px 5px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            border: 1px solid #1e40af;
        }
        
        table td {
            padding: 6px 5px;
            border: 1px solid #e5e7eb;
            font-size: 8px;
        }
        
        table tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7px;
            font-weight: bold;
        }
        
        .badge-kasir { background: #e9d5ff; color: #6b21a8; }
        .badge-online { background: #fed7aa; color: #c2410c; }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-gray { background: #f3f4f6; color: #6b7280; }
        
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 8px;
            color: #6b7280;
        }
        
        .subtotal-row {
            background: #f3f4f6;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN {{ strtoupper($typeLabel) }}</h1>
        <h2>{{ config('app.name') }}</h2>
    </div>

    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Tipe Laporan:</div>
            <div class="info-value">{{ $typeLabel }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Periode:</div>
            <div class="info-value">{{ $periodLabel }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Cetak:</div>
            <div class="info-value">{{ $printDate }}</div>
        </div>
    </div>

    <div class="stats-box">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-label">Total Transaksi</div>
                <div class="stat-value">{{ $totalTransaksi }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Total Poin Diberikan</div>
                <div class="stat-value">{{ number_format($totalPoin, 0, ',', '.') }} Poin</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 10%;">Order #</th>
                <th style="width: 8%;">Tanggal</th>
                <th style="width: 5%;">Waktu</th>
                <th style="width: 6%;">Tipe</th>
                <th style="width: 12%;">Pelanggan</th>
                <th style="width: 10%;">Kasir</th>
                <th style="width: 16%;">Item</th>
                <th style="width: 4%;">Qty</th>
                <th style="width: 9%;">Harga</th>
                <th style="width: 9%;">Subtotal</th>
                <th style="width: 6%;">Metode</th>
                <th style="width: 4%;">Poin</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($transactions as $transaction)
                @php
                    $itemCount = $transaction->items->count();
                    $firstRow = true;
                @endphp
                
                @foreach($transaction->items as $index => $item)
                    <tr>
                        @if($firstRow)
                            <td class="text-center" rowspan="{{ $itemCount }}">{{ $no }}</td>
                            <td rowspan="{{ $itemCount }}">{{ $transaction->order_number }}</td>
                            <td class="text-center" rowspan="{{ $itemCount }}">{{ $transaction->created_at->format('d/m/Y') }}</td>
                            <td class="text-center" rowspan="{{ $itemCount }}">{{ $transaction->created_at->format('H:i') }}</td>
                            <td class="text-center" rowspan="{{ $itemCount }}">
                                @if($transaction->shipping_method === 'kasir')
                                    <span class="badge badge-kasir">Kasir</span>
                                @else
                                    <span class="badge badge-online">Online</span>
                                @endif
                            </td>
                            <td rowspan="{{ $itemCount }}">
                                @if($transaction->shipping_method === 'kasir' && $transaction->member)
                                    {{ $transaction->member->name }}<br>
                                    <small style="color: #666;">{{ $transaction->member->email }}</small>
                                @elseif($transaction->shipping_method !== 'kasir' && $transaction->user)
                                    {{ $transaction->user->name }}<br>
                                    <small style="color: #666;">{{ $transaction->user->email }}</small>
                                @else
                                    <span style="color: #999;">-</span>
                                @endif
                            </td>
                            <td class="text-center" rowspan="{{ $itemCount }}">
                                @if($transaction->shipping_method === 'kasir')
                                    {{ $transaction->user ? $transaction->user->name : '-' }}
                                @else
                                    <span style="color: #999;">-</span>
                                @endif
                            </td>
                        @endif
                        
                        <td>{{ $item->product ? $item->product->title : 'Produk Dihapus' }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">Rp {{ number_format($item->final_price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->final_price * $item->quantity, 0, ',', '.') }}</td>
                        
                        @if($firstRow)
                            <td class="text-center" rowspan="{{ $itemCount }}">{{ ucfirst($transaction->payment_method ?? '-') }}</td>
                            <td class="text-center" rowspan="{{ $itemCount }}">
                                @if($transaction->is_verified)
                                    <span class="badge badge-success">{{ $transaction->points_awarded }}</span>
                                @else
                                    <span class="badge badge-gray">-</span>
                                @endif
                            </td>
                        @endif
                    </tr>
                    @php $firstRow = false; @endphp
                @endforeach
                
                @if($itemCount === 0)
                    <tr>
                        <td class="text-center">{{ $no }}</td>
                        <td>{{ $transaction->order_number }}</td>
                        <td class="text-center">{{ $transaction->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">{{ $transaction->created_at->format('H:i') }}</td>
                        <td class="text-center">
                            @if($transaction->shipping_method === 'kasir')
                                <span class="badge badge-kasir">Kasir</span>
                            @else
                                <span class="badge badge-online">Online</span>
                            @endif
                        </td>
                        <td>
                            @if($transaction->shipping_method === 'kasir' && $transaction->member)
                                {{ $transaction->member->name }}<br>
                                <small style="color: #666;">{{ $transaction->member->email }}</small>
                            @elseif($transaction->shipping_method !== 'kasir' && $transaction->user)
                                {{ $transaction->user->name }}<br>
                                <small style="color: #666;">{{ $transaction->user->email }}</small>
                            @else
                                <span style="color: #999;">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($transaction->shipping_method === 'kasir')
                                {{ $transaction->user ? $transaction->user->name : '-' }}
                            @else
                                <span style="color: #999;">-</span>
                            @endif
                        </td>
                        <td colspan="4" class="text-center" style="color: #999;">Tidak ada item</td>
                        <td class="text-center">{{ ucfirst($transaction->payment_method ?? '-') }}</td>
                        <td class="text-center">
                            @if($transaction->is_verified)
                                <span class="badge badge-success">{{ $transaction->points_awarded }}</span>
                            @else
                                <span class="badge badge-gray">-</span>
                            @endif
                        </td>
                    </tr>
                @endif
                
                <tr class="subtotal-row">
                    <td colspan="10" class="text-right" style="padding-right: 10px;">TOTAL ORDER #{{ $transaction->order_number }}</td>
                    <td class="text-right">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                    <td colspan="2"></td>
                </tr>
                
                @php $no++; @endphp
            @empty
                <tr>
                    <td colspan="12" class="text-center" style="padding: 20px; color: #999;">Tidak ada transaksi dalam periode ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem {{ config('app.name') }}</p>
        <p>Dicetak pada: {{ $printDate }}</p>
    </div>
</body>
</html>
