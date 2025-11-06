<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class MigrateVariantStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:variant-structure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate variant structure from values array to options array with prices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting variant structure migration...');
        
        $products = Product::whereNotNull('variants')->get();
        $converted = 0;
        $skipped = 0;
        
        foreach ($products as $product) {
            $variants = $product->variants;
            
            if (!is_array($variants) || empty($variants)) {
                continue;
            }
            
            $needsConversion = false;
            $newVariants = [];
            
            foreach ($variants as $variant) {
                // Check if this is old structure (has 'values' instead of 'options')
                if (isset($variant['values']) && is_array($variant['values'])) {
                    $needsConversion = true;
                    $options = [];
                    
                    foreach ($variant['values'] as $value) {
                        $options[] = [
                            'value' => $value,
                            'price' => null // No price in old structure
                        ];
                    }
                    
                    $newVariants[] = [
                        'type' => $variant['type'],
                        'options' => $options
                    ];
                } else {
                    // Already new structure
                    $newVariants[] = $variant;
                }
            }
            
            if ($needsConversion) {
                $product->variants = $newVariants;
                $product->save();
                $converted++;
                $this->line("✓ Converted product: {$product->title}");
            } else {
                $skipped++;
                $this->line("- Skipped product (already new structure): {$product->title}");
            }
        }
        
        $this->info("\nMigration completed!");
        $this->info("Converted: {$converted} products");
        $this->info("Skipped: {$skipped} products");
        
        return Command::SUCCESS;
    }
}
