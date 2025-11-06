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

class AdminReportsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithTitle, WithEvents
{
    protected $dateFrom;
    protected $dateTo;
    protected $type;
    protected $customerId;
    protected $productId;

    public function __construct($dateFrom = null, $dateTo = null, $type = 'all', $customerId = null, $productId = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->type = $type;
        $this->customerId = $customerId;
        $this->productId = $productId;
    }

    public function collection()
    {
        $query = Order::with(['user', 'member', 'items.product']);

        if ($this->dateFrom && $this->dateTo) {
            $query->whereBetween('created_at', [$this->dateFrom, $this->dateTo]);
        } elseif ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        } elseif ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }
        
        if ($this->type === 'kasir') {
            $query->where('shipping_method', 'kasir');
        } elseif ($this->type === 'online') {
            $query->where('shipping_method', '!=', 'kasir');
        }
        
        // Filter by customer (check both user_id for online orders and member_id for kasir orders)
        if ($this->customerId) {
            $query->where(function($q) {
                $q->where('user_id', $this->customerId)
                  ->orWhere('member_id', $this->customerId);
            });
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
                // Tentukan customer dan kasir berdasarkan shipping_method
                $customerName = '-';
                $customerEmail = '-';
                $kasirName = '-';
                
                if ($order->shipping_method === 'kasir') {
                    // Untuk transaksi kasir: member adalah customer, user adalah kasir
                    if ($order->member) {
                        $customerName = $order->member->name;
                        $customerEmail = $order->member->email;
                    }
                    if ($order->user) {
                        $kasirName = $order->user->name;
                    }
                } else {
                    // Untuk transaksi online: user adalah customer, kasir kosong
                    if ($order->user) {
                        $customerName = $order->user->name;
                        $customerEmail = $order->user->email;
                    }
                }
                
                $rows->push([
                    $index === 0 ? $no : '',
                    $index === 0 ? $order->order_number : '',
                    $index === 0 ? $order->created_at->format('d/m/Y') : '',
                    $index === 0 ? $order->created_at->format('H:i:s') : '',
                    $index === 0 ? ($order->shipping_method === 'kasir' ? 'Kasir' : 'Online') : '',
                    $index === 0 ? $customerName : '',
                    $index === 0 ? $customerEmail : '',
                    $index === 0 ? $kasirName : '',
                    $item->product ? $item->product->title : 'Produk Dihapus',
                    $item->quantity,
                    'Rp ' . number_format($item->final_price, 0, ',', '.'),
                    'Rp ' . number_format($item->final_price * $item->quantity, 0, ',', '.'),
                    $index === 0 ? 'Rp ' . number_format((float)$order->total, 0, ',', '.') : '',
                    $index === 0 ? ucfirst($order->payment_method ?? '-') : '',
                    $index === 0 ? ucfirst($order->status) : '',
                    $index === 0 ? ($order->points_awarded ?? 0) : '',
                    $index === 0 ? ($order->is_verified ? 'Yes' : 'No') : ''
                ]);
            }
            
            // Jika tidak ada items (after filter)
            if ($items->count() === 0) {
                // Tentukan customer dan kasir berdasarkan shipping_method
                $customerName = '-';
                $customerEmail = '-';
                $kasirName = '-';
                
                if ($order->shipping_method === 'kasir') {
                    if ($order->member) {
                        $customerName = $order->member->name;
                        $customerEmail = $order->member->email;
                    }
                    if ($order->user) {
                        $kasirName = $order->user->name;
                    }
                } else {
                    if ($order->user) {
                        $customerName = $order->user->name;
                        $customerEmail = $order->user->email;
                    }
                }
                
                $rows->push([
                    $no,
                    $order->order_number,
                    $order->created_at->format('d/m/Y'),
                    $order->created_at->format('H:i:s'),
                    $order->shipping_method === 'kasir' ? 'Kasir' : 'Online',
                    $customerName,
                    $customerEmail,
                    $kasirName,
                    '-',
                    0,
                    'Rp 0',
                    'Rp 0',
                    'Rp ' . number_format((float)$order->total, 0, ',', '.'),
                    ucfirst($order->payment_method ?? '-'),
                    ucfirst($order->status),
                    $order->points_awarded ?? 0,
                    $order->is_verified ? 'Yes' : 'No'
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
            'Tipe',
            'Pelanggan',
            'Email',
            'Kasir',
            'Item',
            'Qty',
            'Harga Satuan',
            'Subtotal',
            'Total Order',
            'Metode Bayar',
            'Status',
            'Poin',
            'Verified'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style header
        $sheet->getStyle('A1:Q1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB']
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

        $sheet->getRowDimension(1)->setRowHeight(25);

        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:Q' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC']
                ]
            ]
        ]);

        // Alignment
        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C2:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J2:J' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K2:M' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        
        return [];
    }

    public function title(): string
    {
        return 'Laporan Penjualan - Anashop';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Set properties untuk mengganti "Laravel" default
                $event->sheet->getDelegate()->getParent()->getProperties()
                    ->setCreator('Anashop')
                    ->setLastModifiedBy('Anashop')
                    ->setTitle('Laporan Penjualan')
                    ->setSubject('Laporan Transaksi Penjualan')
                    ->setDescription('Laporan penjualan dari sistem Anashop')
                    ->setKeywords('laporan penjualan anashop')
                    ->setCategory('Laporan');
            },
        ];
    }
}
