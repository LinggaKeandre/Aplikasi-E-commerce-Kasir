

<?php $__env->startSection('content'); ?>
    <div class="max-w-6xl mx-auto py-6" x-data="{ 
        selectAll: false, 
        selected: [],
        items: {
            <?php $__currentLoopData = $cart?->items ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($item->id); ?>: { 
                originalPrice: <?php echo e($item->variant_price ?? $item->product->price); ?>,
                finalPrice: <?php echo e($item->final_price); ?>, 
                discount: <?php echo e($item->product->discount ?? 0); ?>,
                qty: <?php echo e($item->quantity); ?> 
            },
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        },
        availableItems: [
            <?php $__currentLoopData = $cart?->items ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $product = $item->product;
                    $productVariants = $product->variants ?? [];
                    $hasVariants = count($productVariants) > 0;
                    $isIncomplete = $hasVariants && !$item->variant_size;
                ?>
                <?php if(!$isIncomplete): ?>
                    <?php echo e($item->id); ?>,
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ],
        toggleAll() {
            if(this.selectAll) {
                this.selected = [...this.availableItems];
            } else {
                this.selected = [];
            }
        },
        getTotalOriginal() {
            let total = 0;
            this.selected.forEach(id => {
                if(this.items[id]) {
                    total += this.items[id].originalPrice * this.items[id].qty;
                }
            });
            return total;
        },
        getTotalDiscount() {
            let totalDiscount = 0;
            this.selected.forEach(id => {
                if(this.items[id]) {
                    const item = this.items[id];
                    const discountPerItem = item.originalPrice - item.finalPrice;
                    totalDiscount += discountPerItem * item.qty;
                }
            });
            return totalDiscount;
        },
        getSubtotal() {
            return this.getTotalOriginal() - this.getTotalDiscount();
        },
        getSelectedCount() {
            return this.selected.length;
        }
    }">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Keranjang Belanja</h1>
            <?php if($cart && $cart->items->count()): ?>
                <div class="text-sm text-gray-600">
                    <span class="font-semibold"><?php echo e($cart->items->count()); ?></span> produk
                </div>
            <?php endif; ?>
        </div>

        <!-- Flash Messages -->
        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span><?php echo e(session('success')); ?></span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span><?php echo e(session('error')); ?></span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        <?php endif; ?>
        <?php if(session('info')): ?>
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <span><?php echo e(session('info')); ?></span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-blue-700 hover:text-blue-900">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        <?php endif; ?>

        <?php if($cart && $cart->items->count()): ?>
            <div class="grid grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="col-span-2 space-y-3">
                    <!-- Select All -->
                    <div class="bg-white rounded-lg shadow-sm p-4 flex items-center gap-3 border border-gray-200">
                        <input type="checkbox" x-model="selectAll" @change="toggleAll()" class="w-5 h-5 text-blue-600 rounded">
                        <span class="text-sm font-medium text-gray-700">Pilih Semua</span>
                    </div>

                    <!-- Cart Items List -->
                    <?php
                        $dividerShown = false;
                        $hasIncomplete = ($cart->incompleteCount ?? 0) > 0;
                        $hasComplete = $cart->items->count() > ($cart->incompleteCount ?? 0);
                    ?>
                    
                    <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $product = $item->product;
                            $productVariants = $product->variants ?? [];
                            $hasVariants = count($productVariants) > 0;
                            
                            // Cek incomplete: jika produk punya varian tapi cart item belum punya variant_size
                            $isIncomplete = $hasVariants && !$item->variant_size;
                        ?>
                        
                        <!-- Divider: tampil sekali di antara grup incomplete dan complete -->
                        <?php if(!$dividerShown && !$isIncomplete && $hasIncomplete && $hasComplete): ?>
                            <div class="relative my-6">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t-2 border-gray-300 border-dashed"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span class="bg-gray-50 px-4 py-1 text-xs font-medium text-gray-500 rounded-full border border-gray-300">
                                        Item dengan varian lengkap
                                    </span>
                                </div>
                            </div>
                            <?php $dividerShown = true; ?>
                        <?php endif; ?>
                        
                        <div class="bg-white rounded-lg shadow-sm border-2 overflow-hidden transition-all hover:shadow-md 
                                    <?php echo e($isIncomplete ? 'border-orange-400' : 'border-gray-200'); ?>" 
                             x-data="{ 
                                 qty: <?php echo e($item->quantity); ?>,
                                 editingVariant: false,
                                 <?php $__currentLoopData = $productVariants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variantIndex => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 selected<?php echo e(ucfirst(strtolower(str_replace(' ', '', $variant['type'])))); ?>: '<?php echo e($item->{'variant_' . strtolower(str_replace(' ', '_', $variant['type']))} ?? $variant['options'][0]['value'] ?? ''); ?>',
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             }"
                             x-init="$watch('qty', value => items[<?php echo e($item->id); ?>].qty = value)">
                            
                            <!-- Warning Banner if variant incomplete -->
                            <?php if($isIncomplete): ?>
                                <div class="bg-orange-100 border-b border-orange-200 px-4 py-2 flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-xs text-orange-800">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="font-semibold">
                                            Varian belum lengkap! Silakan pilih varian.
                                        </span>
                                    </div>
                                    <button @click="editingVariant = true" class="text-xs bg-orange-600 text-white px-3 py-1 rounded hover:bg-orange-700 transition">
                                        Pilih Varian
                                    </button>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-4">
                                <div class="flex gap-4 items-start">
                                    <!-- Checkbox - Disabled if variant incomplete -->
                                    <div class="flex items-start pt-1 flex-shrink-0">
                                        <input type="checkbox" 
                                               value="<?php echo e($item->id); ?>" 
                                               x-model="selected" 
                                               <?php echo e($isIncomplete ? 'disabled' : ''); ?>

                                               class="w-5 h-5 text-blue-600 rounded <?php echo e($isIncomplete ? 'opacity-40 cursor-not-allowed' : 'cursor-pointer'); ?>">
                                    </div>

                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="block w-20 h-20">
                                            <img src="<?php echo e($product->image_url); ?>" 
                                                 alt="<?php echo e($product->title); ?>"
                                                 class="w-full h-full object-cover rounded border border-gray-200 hover:opacity-80 transition aspect-square">
                                        </a>
                                    </div>

                                    <!-- Product Info - Flex grow to take available space -->
                                    <div class="flex-grow min-w-0">
                                        <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="block mb-1">
                                            <h3 class="font-medium text-gray-900 line-clamp-2 hover:text-blue-600 transition text-sm">
                                                <?php echo e($product->title); ?>

                                            </h3>
                                        </a>
                                        
                                        <!-- Variant Display or Edit Form -->
                                        <?php if($hasVariants): ?>
                                            <!-- View Mode -->
                                            <div x-show="!editingVariant" class="mb-2">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="text-xs text-gray-600">Variasi:</span>
                                                    <?php if($item->variant_size): ?>
                                                        <span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded font-medium border border-blue-200">
                                                            <?php echo e($item->variant_size); ?>

                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-xs text-orange-600 font-medium">Belum lengkap</span>
                                                    <?php endif; ?>
                                                    <?php if($item->variant_color && count($productVariants) > 1): ?>
                                                        <span class="text-xs bg-purple-50 text-purple-700 px-2 py-1 rounded font-medium border border-purple-200">
                                                            <?php echo e($item->variant_color); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                    <button @click="editingVariant = true" 
                                                            class="text-xs text-blue-600 hover:text-blue-700 flex items-center gap-1 font-medium">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                        </svg>
                                                        <?php echo e($item->variant_size ? 'Ubah' : 'Pilih'); ?>

                                                    </button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Stock Info (only show when not editing) -->
                                        <div x-show="!editingVariant">
                                            <?php if($product->stock <= 5): ?>
                                                <p class="text-xs text-red-600 mb-1">tersisa <?php echo e($product->stock); ?> buah</p>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Price, Quantity, Total, Delete - Only show when not editing -->
                                        <div x-show="!editingVariant" class="flex items-center gap-4 mt-3">
                                            <?php if(!$isIncomplete): ?>
                                                <!-- Price Section -->
                                                <div class="text-left flex-shrink-0">
                                                    <?php if($product->discount): ?>
                                                        <div class="text-xs text-gray-400 line-through">
                                                            Rp<?php echo e(number_format($item->variant_price ?? $product->price, 0, ',', '.')); ?>

                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="text-base font-semibold text-gray-900">
                                                        Rp<?php echo e(number_format($item->final_price, 0, ',', '.')); ?>

                                                    </div>
                                                </div>

                                                <!-- Quantity Controls -->
                                                <div class="flex items-center gap-2 flex-shrink-0">
                                                    <button @click="if(qty>1) qty--" 
                                                            class="w-7 h-7 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100 transition">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                        </svg>
                                                    </button>
                                                    <input type="number" 
                                                           x-model="qty" 
                                                           min="1" 
                                                           max="<?php echo e($product->stock); ?>"
                                                           class="w-12 text-center border border-gray-300 rounded text-sm py-1 focus:outline-none focus:border-blue-500">
                                                    <button @click="if(qty < <?php echo e($product->stock); ?>) qty++" 
                                                            class="w-7 h-7 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100 transition">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <!-- Total Price -->
                                                <div class="text-left font-bold text-orange-600 flex-shrink-0 ml-auto">
                                                    Rp<span x-text="(<?php echo e($item->final_price); ?> * qty).toLocaleString('id-ID')"></span>
                                                </div>
                                            <?php else: ?>
                                                <!-- Placeholder when variant incomplete -->
                                                <div class="flex-1 text-center py-2 bg-orange-50 rounded-lg border border-orange-200">
                                                    <p class="text-sm text-orange-700 font-medium">
                                                        Harga akan ditampilkan setelah varian dipilih
                                                    </p>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Delete Button -->
                                            <div class="flex items-center flex-shrink-0">
                                                <form method="POST" action="<?php echo e(route('cart.remove', $item->id)); ?>" 
                                                      @submit.prevent="if(confirm('Hapus produk ini dari keranjang?')) $el.submit()">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition p-1">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                
                                <!-- Edit Variant Form - Full Width Below Main Content -->
                                <?php if($hasVariants): ?>
                                    <div x-show="editingVariant" x-cloak class="mt-3 ml-9">
                                        <form method="POST" action="<?php echo e(route('cart.updateVariant', $item->id)); ?>" 
                                              class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-lg p-4">
                                            <?php echo csrf_field(); ?>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                <?php $__currentLoopData = $productVariants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variantIndex => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div>
                                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                                            <?php echo e($variant['type']); ?>

                                                        </label>
                                                        <select name="variant_<?php echo e(strtolower(str_replace(' ', '_', $variant['type']))); ?>" 
                                                                required
                                                                class="w-full text-sm border-2 border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                                            <option value="">Pilih <?php echo e($variant['type']); ?></option>
                                                            <?php $__currentLoopData = $variant['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($option['value']); ?>"
                                                                        <?php if($variantIndex === 0 && $item->variant_size === $option['value']): ?> selected
                                                                        <?php elseif($variantIndex === 1 && $item->variant_color === $option['value']): ?> selected
                                                                        <?php endif; ?>>
                                                                    <?php echo e($option['value']); ?><?php if(!empty($option['price'])): ?> (Rp <?php echo e(number_format($option['price'], 0, ',', '.')); ?>)<?php endif; ?>
                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <div class="flex gap-2 mt-4">
                                                <button type="submit" 
                                                        class="flex-1 text-sm bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 font-semibold transition shadow-sm hover:shadow-md">
                                                    💾 Simpan Variasi
                                                </button>
                                                <button type="button" 
                                                        @click="editingVariant = false" 
                                                        class="flex-1 text-sm bg-white text-gray-700 px-4 py-2.5 rounded-lg hover:bg-gray-100 border-2 border-gray-300 font-medium transition">
                                                    ✕ Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Summary Sidebar -->
                <div class="col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 sticky top-4">
                        <h3 class="font-bold text-lg mb-4 text-gray-800">Ringkasan Belanja</h3>
                        
                        <div class="space-y-3 mb-4 pb-4 border-b border-gray-200">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Harga (<span x-text="getSelectedCount()"></span> barang)</span>
                                <span class="font-semibold text-gray-900">Rp <span x-text="getTotalOriginal().toLocaleString('id-ID')"></span></span>
                            </div>
                            <div class="flex justify-between text-sm" x-show="getTotalDiscount() > 0">
                                <span class="text-gray-600">Kamu Hemat</span>
                                <span class="font-semibold text-red-600">- Rp <span x-text="getTotalDiscount().toLocaleString('id-ID')"></span></span>
                            </div>
                        </div>

                        <div class="flex justify-between mb-6 items-center">
                            <span class="font-bold text-gray-800">Total</span>
                            <span class="font-bold text-xl text-blue-600">Rp <span x-text="getSubtotal().toLocaleString('id-ID')"></span></span>
                        </div>

                        <a href="#"
                           @click.prevent="if(selected.length > 0) { 
                               const form = document.createElement('form');
                               form.method = 'POST';
                               form.action = '<?php echo e(route('checkout.index')); ?>';
                               const csrfInput = document.createElement('input');
                               csrfInput.type = 'hidden';
                               csrfInput.name = '_token';
                               csrfInput.value = '<?php echo e(csrf_token()); ?>';
                               form.appendChild(csrfInput);
                               selected.forEach(id => {
                                   const input = document.createElement('input');
                                   input.type = 'hidden';
                                   input.name = 'items[]';
                                   input.value = id;
                                   form.appendChild(input);
                               });
                               document.body.appendChild(form);
                               form.submit();
                           }"
                           :class="selected.length === 0 ? 'bg-gray-400 cursor-not-allowed pointer-events-none' : 'bg-blue-600 hover:bg-blue-700'"
                           class="block w-full text-white py-3 rounded-lg font-semibold transition shadow-md hover:shadow-lg mb-3 text-center">
                            Checkout (<span x-text="selected.length"></span>)
                        </a>

                        <a href="<?php echo e(route('home')); ?>" class="block text-center text-blue-600 text-sm hover:text-blue-700 transition">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <div class="max-w-sm mx-auto">
                    <svg class="w-32 h-32 mx-auto mb-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Keranjang Belanja Kosong</h3>
                    <p class="text-gray-600 mb-6">Yuk, mulai belanja dan masukkan produk favoritmu ke keranjang!</p>
                    <a href="<?php echo e(route('home')); ?>" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                        Mulai Belanja
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/cart/index.blade.php ENDPATH**/ ?>