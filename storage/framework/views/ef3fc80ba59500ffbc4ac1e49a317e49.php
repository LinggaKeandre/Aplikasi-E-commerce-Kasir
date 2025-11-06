<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #<?php echo e($order->order_number); ?></title>
    <style>
        @page {
            size: 80mm auto;
            margin: 0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            padding: 10px;
            width: 80mm;
            margin: 0 auto;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
        }
        
        .store-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .store-info {
            font-size: 10px;
            line-height: 1.3;
        }
        
        .order-info {
            margin-bottom: 15px;
            font-size: 11px;
        }
        
        .order-info div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        
        .items {
            margin-bottom: 15px;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 10px 0;
        }
        
        .item {
            margin-bottom: 8px;
        }
        
        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .item-variant {
            font-size: 10px;
            color: #555;
            margin-left: 5px;
            margin-bottom: 2px;
        }
        
        .item-details {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }
        
        .summary {
            margin-bottom: 15px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .summary-row.total {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        
        .payment {
            margin-bottom: 15px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }
        
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 15px;
            border-top: 2px dashed #000;
            padding-top: 10px;
        }
        
        .thank-you {
            font-weight: bold;
            margin: 10px 0;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .print-button:hover {
            background: #2563eb;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button no-print">🖨️ Cetak Struk</button>
    
    <div class="header">
        <div class="store-name">ANASHOP</div>
        <div class="store-info">
            Jl. Pahlawan Revolusi No.22B<br>
            Pd. Bambu, Kec. Duren Sawit<br>
            Kota Jakarta Timur, DKI Jakarta 13430<br>
            Telp: 021-1234567
        </div>
    </div>
    
    <div class="order-info">
        <div>
            <span>No. Pesanan</span>
            <span><strong><?php echo e($order->order_number); ?></strong></span>
        </div>
        <div>
            <span>Tanggal</span>
            <span><?php echo e($order->created_at->format('d/m/Y H:i')); ?></span>
        </div>
        <div>
            <span>Kasir</span>
            <span><?php echo e($order->user->name ?? 'Admin'); ?></span>
        </div>
        <?php if($order->shipping_method !== 'kasir'): ?>
        <div>
            <span>Pelanggan</span>
            <span><?php echo e($order->shipping_name); ?></span>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="items">
        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="item">
            <div class="item-name"><?php echo e($item->product_name); ?></div>
            
            <?php if($item->variant_info && count($item->variant_info) > 0): ?>
                <div class="item-variant">
                    <?php $__currentLoopData = $item->variant_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($variant['label']); ?>: <?php echo e($variant['value']); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
            
            <div class="item-details">
                <span><?php echo e($item->quantity); ?> x Rp<?php echo e(number_format($item->final_price, 0, ',', '.')); ?></span>
                <span><strong>Rp<?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></strong></span>
            </div>
            
            <?php if($item->product_discount > 0): ?>
            <div style="font-size: 10px; color: #666;">
                Diskon <?php echo e($item->product_discount); ?>%
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
    <div class="summary">
        <div class="summary-row">
            <span>Subtotal</span>
            <span>Rp<?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></span>
        </div>
        
        <?php if($order->discount_amount > 0): ?>
        <div class="summary-row">
            <span>Diskon</span>
            <span>-Rp<?php echo e(number_format($order->discount_amount, 0, ',', '.')); ?></span>
        </div>
        <?php endif; ?>
        
        <?php if($order->shipping_cost > 0): ?>
        <div class="summary-row">
            <span>Ongkir (<?php echo e($order->shipping_method_name); ?>)</span>
            <span>Rp<?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></span>
        </div>
        <?php endif; ?>
        
        <div class="summary-row total">
            <span>TOTAL</span>
            <span>Rp<?php echo e(number_format($order->total, 0, ',', '.')); ?></span>
        </div>
    </div>
    
    <div class="payment">
        <div class="summary-row">
            <span>Metode Bayar</span>
            <span><strong><?php echo e(strtoupper($order->payment_method)); ?></strong></span>
        </div>
        <div class="summary-row">
            <span>Status</span>
            <span>
                <?php if($order->payment_status === 'paid'): ?>
                    <strong>LUNAS ✓</strong>
                <?php else: ?>
                    <?php echo e(strtoupper($order->payment_status)); ?>

                <?php endif; ?>
            </span>
        </div>
        
        <?php if($order->member_id && $order->is_verified && $order->points_awarded > 0): ?>
        <div class="summary-row" style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed #000;">
            <span>Poin Member</span>
            <span><strong>+<?php echo e($order->points_awarded); ?> Poin</strong></span>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="footer">
        <div class="thank-you">TERIMA KASIH</div>
        <div>Barang yang sudah dibeli<br>tidak dapat dikembalikan</div>
        <div style="margin-top: 10px;"><?php echo e(now()->format('d/m/Y H:i:s')); ?></div>
    </div>
    
    <script>
        // Auto print when page loads (optional)
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 500);
        // }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/kasir/struk.blade.php ENDPATH**/ ?>