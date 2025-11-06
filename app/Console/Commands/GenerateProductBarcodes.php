<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class GenerateProductBarcodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'barcode:generate {--force : Regenerate semua barcode termasuk yang sudah ada}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate barcode otomatis untuk produk yang belum punya barcode';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');
        
        if ($force) {
            $products = Product::all();
            $this->info('🔄 Mode: Regenerate ALL barcodes (Force)');
        } else {
            $products = Product::whereNull('barcode')->get();
            $this->info('🔄 Mode: Generate untuk produk tanpa barcode saja');
        }

        if ($products->isEmpty()) {
            $this->warn('⚠️  Tidak ada produk yang perlu di-generate barcode.');
            return 0;
        }

        $this->info("📦 Ditemukan {$products->count()} produk");
        
        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        $success = 0;
        $failed = 0;

        foreach ($products as $product) {
            try {
                // Format: SKU-{ID dengan padding 6 digit}
                // Contoh: SKU-000001, SKU-000042, SKU-001234
                $barcode = 'SKU-' . str_pad($product->id, 6, '0', STR_PAD_LEFT);
                
                $product->barcode = $barcode;
                $product->save();
                
                $success++;
            } catch (\Exception $e) {
                $failed++;
                $this->newLine();
                $this->error("❌ Gagal generate barcode untuk produk ID {$product->id}: {$e->getMessage()}");
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        
        $this->info("✅ Berhasil: {$success} produk");
        if ($failed > 0) {
            $this->error("❌ Gagal: {$failed} produk");
        }
        
        $this->newLine();
        $this->info('🎉 Selesai!');
        
        return 0;
    }
}
