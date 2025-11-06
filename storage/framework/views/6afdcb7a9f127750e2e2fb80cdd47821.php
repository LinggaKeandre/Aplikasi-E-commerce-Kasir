

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            Permintaan Pembatalan Pesanan
        </h1>
        <p class="text-sm text-gray-600">Review dan kelola permintaan pembatalan dari pelanggan</p>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg flex items-center gap-3">
            <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-green-700 font-medium"><?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <?php if($requests->count() > 0): ?>
            <div class="divide-y divide-gray-200">
                <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center <?php echo e($request->status === 'pending' ? 'bg-yellow-100' : ($request->status === 'approved' ? 'bg-green-100' : 'bg-red-100')); ?>">
                                        <?php if($request->status === 'pending'): ?>
                                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        <?php elseif($request->status === 'approved'): ?>
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        <?php else: ?>
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-800">Order #<?php echo e($request->order->order_number); ?></h3>
                                        <p class="text-sm text-gray-600"><?php echo e($request->created_at->format('d M Y, H:i')); ?></p>
                                    </div>
                                    <?php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                        ];
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold <?php echo e($statusColors[$request->status]); ?>">
                                        <?php echo e(ucfirst($request->status)); ?>

                                    </span>
                                </div>

                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 mb-1">Pelanggan</p>
                                        <p class="font-semibold text-gray-800"><?php echo e($request->user->name); ?></p>
                                        <p class="text-xs text-gray-600"><?php echo e($request->user->email); ?></p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 mb-1">Total Pesanan</p>
                                        <p class="font-bold text-lg text-gray-800">Rp<?php echo e(number_format($request->order->total, 0, ',', '.')); ?></p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 mb-1">Status Order</p>
                                        <p class="font-semibold text-gray-800"><?php echo e(ucfirst($request->order->status)); ?></p>
                                    </div>
                                </div>

                                
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-4">
                                    <p class="text-sm font-semibold text-blue-900 mb-1">Alasan Pembatalan:</p>
                                    <p class="text-blue-800"><?php echo e($request->readable_reason); ?></p>
                                    <?php if($request->reason_detail): ?>
                                        <p class="text-sm text-blue-700 mt-2 italic">"<?php echo e($request->reason_detail); ?>"</p>
                                    <?php endif; ?>
                                </div>

                                
                                <?php if($request->admin_note): ?>
                                    <div class="bg-gray-50 border-l-4 border-gray-400 p-4 rounded mb-4">
                                        <p class="text-sm font-semibold text-gray-700 mb-1">Catatan Admin:</p>
                                        <p class="text-gray-700"><?php echo e($request->admin_note); ?></p>
                                        <?php if($request->reviewer): ?>
                                            <p class="text-xs text-gray-500 mt-2">
                                                Direview oleh <?php echo e($request->reviewer->name); ?> - <?php echo e($request->reviewed_at->format('d M Y, H:i')); ?>

                                            </p>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            
                            <?php if($request->status === 'pending'): ?>
                                <div class="flex flex-col gap-2">
                                    <button onclick="openReviewModal(<?php echo e($request->id); ?>, 'approve')" 
                                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium text-sm flex items-center gap-2 whitespace-nowrap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Setujui
                                    </button>
                                    <button onclick="openReviewModal(<?php echo e($request->id); ?>, 'reject')" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium text-sm flex items-center gap-2 whitespace-nowrap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Tolak
                                    </button>
                                    <a href="<?php echo e(route('admin.orders.show', $request->order->id)); ?>" 
                                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium text-sm text-center whitespace-nowrap">
                                        Lihat Order
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="p-6 border-t border-gray-200">
                <?php echo e($requests->links()); ?>

            </div>
        <?php else: ?>
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum Ada Permintaan Pembatalan</h3>
                <p class="text-gray-500">Permintaan pembatalan akan muncul di sini</p>
            </div>
        <?php endif; ?>
    </div>
</div>


<div id="reviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
        <div id="modalHeader" class="px-6 py-4 rounded-t-xl">
            <h3 id="modalTitle" class="text-xl font-bold text-white"></h3>
        </div>
        
        <form id="reviewForm" method="POST">
            <?php echo csrf_field(); ?>
            <div class="p-6">
                <input type="hidden" name="action" id="modalAction">
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Catatan untuk Pelanggan
                    </label>
                    <textarea name="admin_note" 
                              rows="4" 
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Berikan catatan atau penjelasan (opsional)..."
                              maxlength="500"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Maksimal 500 karakter</p>
                </div>
            </div>
            
            <div class="px-6 pb-6 flex gap-3">
                <button type="button" 
                        onclick="closeReviewModal()"
                        class="flex-1 px-4 py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold">
                    Batal
                </button>
                <button type="submit" 
                        id="modalSubmit"
                        class="flex-1 px-4 py-2 text-white rounded-lg font-semibold">
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openReviewModal(requestId, action) {
    const modal = document.getElementById('reviewModal');
    const form = document.getElementById('reviewForm');
    const header = document.getElementById('modalHeader');
    const title = document.getElementById('modalTitle');
    const actionInput = document.getElementById('modalAction');
    const submitBtn = document.getElementById('modalSubmit');
    
    form.action = `/admin/orders/cancellations/${requestId}/review`;
    actionInput.value = action;
    
    if (action === 'approve') {
        header.className = 'px-6 py-4 rounded-t-xl bg-gradient-to-r from-green-600 to-green-700';
        title.textContent = 'Setujui Pembatalan';
        submitBtn.className = 'flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold';
        submitBtn.textContent = 'Setujui Pembatalan';
    } else {
        header.className = 'px-6 py-4 rounded-t-xl bg-gradient-to-r from-red-600 to-red-700';
        title.textContent = 'Tolak Pembatalan';
        submitBtn.className = 'flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold';
        submitBtn.textContent = 'Tolak Pembatalan';
    }
    
    modal.classList.remove('hidden');
}

function closeReviewModal() {
    document.getElementById('reviewModal').classList.add('hidden');
    document.getElementById('reviewForm').reset();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/admin/orders/cancellation-requests.blade.php ENDPATH**/ ?>