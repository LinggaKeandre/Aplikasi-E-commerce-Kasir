<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
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
        
        table tbody tr:hover {
            background: #f3f4f6;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7px;
            font-weight: bold;
        }
        
        .badge-success {
            background: #dcfce7;
            color: #166534;
        }
        
        .badge-gray {
            background: #f3f4f6;
            color: #6b7280;
        }
        
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 8px;
            color: #6b7280;
        }
        
        .group-header {
            background: #eff6ff;
            font-weight: bold;
        }
        
        .subtotal-row {
            background: #f3f4f6;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TRANSAKSI KASIR</h1>
        <h2><?php echo e(config('app.name')); ?></h2>
    </div>

    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Nama Kasir:</div>
            <div class="info-value"><?php echo e($kasir->name); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Periode:</div>
            <div class="info-value"><?php echo e($periodLabel); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Cetak:</div>
            <div class="info-value"><?php echo e($printDate); ?></div>
        </div>
    </div>

    <div class="stats-box">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-label">Total Transaksi</div>
                <div class="stat-value"><?php echo e($totalTransaksi); ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value">Rp <?php echo e(number_format($totalPendapatan, 0, ',', '.')); ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Total Poin Diberikan</div>
                <div class="stat-value"><?php echo e(number_format($totalPoin, 0, ',', '.')); ?> Poin</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 10%;">Order #</th>
                <th style="width: 9%;">Tanggal</th>
                <th style="width: 6%;">Waktu</th>
                <th style="width: 15%;">Member</th>
                <th style="width: 20%;">Item</th>
                <th style="width: 5%;">Qty</th>
                <th style="width: 10%;">Harga</th>
                <th style="width: 10%;">Subtotal</th>
                <th style="width: 7%;">Pembayaran</th>
                <th style="width: 5%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $itemCount = $transaction->items->count();
                    $firstRow = true;
                ?>
                
                <?php $__currentLoopData = $transaction->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php if($firstRow): ?>
                            <td class="text-center" rowspan="<?php echo e($itemCount); ?>"><?php echo e($no); ?></td>
                            <td rowspan="<?php echo e($itemCount); ?>"><?php echo e($transaction->order_number); ?></td>
                            <td class="text-center" rowspan="<?php echo e($itemCount); ?>"><?php echo e($transaction->created_at->format('d/m/Y')); ?></td>
                            <td class="text-center" rowspan="<?php echo e($itemCount); ?>"><?php echo e($transaction->created_at->format('H:i')); ?></td>
                            <td rowspan="<?php echo e($itemCount); ?>">
                                <?php if($transaction->member): ?>
                                    <?php echo e($transaction->member->name); ?><br>
                                    <small style="color: #666;"><?php echo e($transaction->member->email); ?></small>
                                <?php else: ?>
                                    <span style="color: #999;">-</span>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                        
                        <td><?php echo e($item->product ? $item->product->title : 'Produk Dihapus'); ?></td>
                        <td class="text-center"><?php echo e($item->quantity); ?></td>
                        <td class="text-right">Rp <?php echo e(number_format($item->final_price, 0, ',', '.')); ?></td>
                        <td class="text-right">Rp <?php echo e(number_format($item->final_price * $item->quantity, 0, ',', '.')); ?></td>
                        
                        <?php if($firstRow): ?>
                            <td class="text-center" rowspan="<?php echo e($itemCount); ?>"><?php echo e(ucfirst($transaction->payment_method ?? 'cash')); ?></td>
                            <td class="text-center" rowspan="<?php echo e($itemCount); ?>">
                                <?php if($transaction->is_verified): ?>
                                    <span class="badge badge-success">✓ <?php echo e($transaction->points_awarded); ?> poin</span>
                                <?php else: ?>
                                    <span class="badge badge-gray">-</span>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                    <?php $firstRow = false; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <?php if($itemCount === 0): ?>
                    <tr>
                        <td class="text-center"><?php echo e($no); ?></td>
                        <td><?php echo e($transaction->order_number); ?></td>
                        <td class="text-center"><?php echo e($transaction->created_at->format('d/m/Y')); ?></td>
                        <td class="text-center"><?php echo e($transaction->created_at->format('H:i')); ?></td>
                        <td>
                            <?php if($transaction->member): ?>
                                <?php echo e($transaction->member->name); ?><br>
                                <small style="color: #666;"><?php echo e($transaction->member->email); ?></small>
                            <?php else: ?>
                                <span style="color: #999;">-</span>
                            <?php endif; ?>
                        </td>
                        <td colspan="4" class="text-center" style="color: #999;">Tidak ada item</td>
                        <td class="text-center"><?php echo e(ucfirst($transaction->payment_method ?? 'cash')); ?></td>
                        <td class="text-center">
                            <?php if($transaction->is_verified): ?>
                                <span class="badge badge-success">✓ <?php echo e($transaction->points_awarded); ?> poin</span>
                            <?php else: ?>
                                <span class="badge badge-gray">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                
                <tr class="subtotal-row">
                    <td colspan="8" class="text-right" style="padding-right: 10px;">TOTAL ORDER #<?php echo e($transaction->order_number); ?></td>
                    <td class="text-right">Rp <?php echo e(number_format($transaction->total, 0, ',', '.')); ?></td>
                    <td colspan="2"></td>
                </tr>
                
                <?php $no++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="11" class="text-center" style="padding: 20px; color: #999;">Tidak ada transaksi dalam periode ini</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem <?php echo e(config('app.name')); ?></p>
        <p>Dicetak pada: <?php echo e($printDate); ?> oleh <?php echo e($kasir->name); ?></p>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/kasir/exports/pdf.blade.php ENDPATH**/ ?>