<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TransactionsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithTitle, WithEvents
{
    protected $kasirId;
    protected $dateFrom;
    protected $dateTo;
    protected $customerId;
    protected $productId;

    public function __construct($kasirId, $dateFrom = null, $dateTo = null, $customerId = null, $productId = null)
    {
        $this->kasirId = $kasirId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->customerId = $customerId;
        $this->productId = $productId;
    }

    public function collection()
    {
        $query = Order::where('user_id', $this->kasirId)
            ->where('shipping_method', 'kasir')
            ->with(['member', 'items.product']);

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }
        
        // Filter by customer (member)
        if ($this->customerId) {
            $query->where('member_id', $this->customerId);
        }
        
        // Filter by product
        if ($this->productId) {
            $query->whereHas('items', function($q) {
                $q->where('product_id', $this->productId);
            });
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();
        
        // Transform data menjadi flat array
        $rows = collect();
        $no = 1;
        
        foreach ($transactions as $order) {
            // Filter items by product if specified
            $items = $this->productId 
                ? $order->items->where('product_id', $this->productId) 
                : $order->items;
            
            foreach ($items as $index => $item) {
                $rows->push([
                    $index === 0 ? $no : '', // No hanya di row pertama
                    $index === 0 ? $order->order_number : '',
                    $index === 0 ? $order->created_at->format('d/m/Y') : '',
                    $index === 0 ? $order->created_at->format('H:i:s') : '',
                    $index === 0 ? ($order->member ? $order->member->email : '-') : '',
                    $index === 0 ? ($order->member ? $order->member->name : '-') : '',
                    $item->product ? $item->product->title : 'Produk Dihapus',
                    $item->quantity,
                    'Rp ' . number_format($item->final_price, 0, ',', '.'),
                    'Rp ' . number_format($item->final_price * $item->quantity, 0, ',', '.'),
                    $index === 0 ? 'Rp ' . number_format($order->total, 0, ',', '.') : '',
                    $index === 0 ? ucfirst($order->payment_method ?? 'cash') : '',
                    $index === 0 ? ($order->points_awarded ?? 0) . ' poin' : '',
                    $index === 0 ? ($order->is_verified ? 'Verified' : 'Not Verified') : ''
                ]);
            }
            
            // Jika tidak ada items (after filter), tetap tampilkan order
            if ($items->count() === 0) {
                $rows->push([
                    $no,
                    $order->order_number,
                    $order->created_at->format('d/m/Y'),
                    $order->created_at->format('H:i:s'),
                    $order->member ? $order->member->email : '-',
                    $order->member ? $order->member->name : '-',
                    '-',
                    0,
                    'Rp 0',
                    'Rp 0',
                    'Rp ' . number_format($order->total, 0, ',', '.'),
                    ucfirst($order->payment_method ?? 'cash'),
                    ($order->points_awarded ?? 0) . ' poin',
                    $order->is_verified ? 'Verified' : 'Not Verified'
                ]);
            }
            
            $no++;
        }
        
        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Order Number',
            'Tanggal',
            'Waktu',
            'Email Member',
            'Nama Member',
            'Item',
            'Qty',
            'Harga Satuan',
            'Subtotal',
            'Total Order',
            'Metode Pembayaran',
            'Poin Diberikan',
            'Status Verifikasi'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style header
        $sheet->getStyle('A1:N1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB'] // Blue-600
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Set row height header
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Style semua cell dengan border
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:N' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC']
                ]
            ]
        ]);

        // Alignment untuk kolom tertentu
        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C2:D' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H2:H' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I2:K' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        
        return [];
    }

    public function title(): string
    {
        return 'Laporan Transaksi Kasir - Anashop';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Set properties untuk mengganti "Laravel" default
                $event->sheet->getDelegate()->getParent()->getProperties()
                    ->setCreator('Anashop')
                    ->setLastModifiedBy('Anashop')
                    ->setTitle('Laporan Transaksi Kasir')
                    ->setSubject('Laporan Transaksi Kasir')
                    ->setDescription('Laporan transaksi kasir dari sistem Anashop')
                    ->setKeywords('laporan transaksi kasir anashop')
                    ->setCategory('Laporan');
            },
        ];
    }
}
