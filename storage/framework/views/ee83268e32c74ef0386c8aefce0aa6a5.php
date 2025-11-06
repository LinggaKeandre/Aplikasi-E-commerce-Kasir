

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Header -->
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">🎁 Daily Rewards</h1>
        <p class="text-gray-600">Login setiap hari untuk mendapatkan poin gratis!</p>
        <?php if($dailyReward->streak > 0): ?>
            <p class="text-sm text-blue-600 font-semibold mt-2">🔥 Streak: <?php echo e($dailyReward->streak); ?> kali 7 hari sempurna</p>
        <?php endif; ?>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            <p class="font-bold">Berhasil!</p>
            <p><?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <p class="font-bold">Error</p>
            <p><?php echo e(session('error')); ?></p>
        </div>
    <?php endif; ?>

    <!-- Daily Rewards Grid -->
    <div class="bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 rounded-2xl shadow-2xl p-6 mb-6">
        <!-- Days Header -->
        <div class="grid grid-cols-7 gap-2 mb-4">
            <?php $__currentLoopData = ['DAY 1', 'DAY 2', 'DAY 3', 'DAY 4', 'DAY 5', 'DAY 6', 'DAY 7']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="text-center text-yellow-400 font-bold text-xs md:text-sm">
                    <?php echo e($label); ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Rewards Cards -->
        <div class="grid grid-cols-7 gap-2">
            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dayData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="relative">
                    <!-- Card Container -->
                    <div class="aspect-square rounded-lg overflow-hidden border-2 transition-all duration-300
                        <?php echo e($dayData['claimed'] ? 'bg-gray-400 border-gray-500 opacity-60' : 
                           ($dayData['current'] ? 'bg-gradient-to-br from-green-400 to-green-600 border-green-300 shadow-lg shadow-green-500/50 animate-pulse' : 
                           ($dayData['day'] == 2 ? 'bg-gradient-to-br from-yellow-400 to-orange-500 border-yellow-300' :
                           ($dayData['day'] == 3 ? 'bg-gradient-to-br from-blue-400 to-blue-600 border-blue-300' :
                           ($dayData['day'] == 7 ? 'bg-gradient-to-br from-yellow-500 to-yellow-600 border-yellow-400' :
                           'bg-gradient-to-br from-cyan-400 to-cyan-600 border-cyan-300'))))); ?>">
                        
                        <div class="p-2 h-full flex flex-col items-center justify-center text-center">
                            <!-- Icon/Image -->
                            <div class="mb-1">
                                <?php if($dayData['day'] == 1): ?>
                                    <!-- Coins Icon -->
                                    <svg class="w-8 h-8 md:w-10 md:h-10 text-yellow-900" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                    </svg>
                                <?php elseif($dayData['day'] == 2): ?>
                                    <!-- Stack of Coins -->
                                    <div class="text-2xl md:text-3xl">💰</div>
                                <?php elseif($dayData['day'] == 3): ?>
                                    <!-- Game Controller -->
                                    <div class="text-2xl md:text-3xl">🎮</div>
                                <?php elseif($dayData['day'] == 4): ?>
                                    <!-- Airplane -->
                                    <div class="text-2xl md:text-3xl">✈️</div>
                                <?php elseif($dayData['day'] == 5): ?>
                                    <!-- Motorcycle/Suspension -->
                                    <div class="text-2xl md:text-3xl">🏍️</div>
                                <?php elseif($dayData['day'] == 6): ?>
                                    <!-- Big Coins -->
                                    <div class="text-2xl md:text-3xl">💎</div>
                                <?php elseif($dayData['day'] == 7): ?>
                                    <!-- Jet Fighter -->
                                    <div class="text-2xl md:text-3xl">🚀</div>
                                <?php endif; ?>
                            </div>

                            <!-- Points -->
                            <div class="font-bold text-white text-xs md:text-sm mb-0.5">
                                <?php echo e($dayData['points']); ?> POIN
                            </div>

                            <!-- Day Label -->
                            <div class="text-xs font-bold text-white opacity-90">
                                DAY <?php echo e($dayData['day']); ?>

                            </div>

                            <!-- Claimed/Current Badge -->
                            <?php if($dayData['claimed']): ?>
                                <div class="absolute top-1 right-1 bg-gray-700 text-white text-xs px-1.5 py-0.5 rounded">
                                    ✓
                                </div>
                            <?php elseif($dayData['current']): ?>
                                <div class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg">
                                    TODAY
                                </div>
                            <?php elseif($dayData['locked']): ?>
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Claim Button -->
    <div class="text-center mb-6">
        <?php if($canClaim): ?>
            <?php
                $currentDayData = collect($days)->firstWhere('current', true);
                $currentPoints = $currentDayData['points'] ?? 0;
            ?>
            <form action="<?php echo e(route('daily-rewards.claim')); ?>" method="POST" 
                  onsubmit="return confirm('Claim Daily Reward Day <?php echo e($dailyReward->current_day); ?> (<?php echo e($currentPoints); ?> poin)?')">
                <?php echo csrf_field(); ?>
                <button type="submit" 
                        class="bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 
                               text-gray-900 font-black text-xl md:text-2xl px-12 py-4 rounded-full shadow-2xl 
                               transform hover:scale-105 transition-all duration-300 border-4 border-yellow-300">
                    🎁 CLAIM NOW
                </button>
            </form>
        <?php else: ?>
            <div class="inline-block bg-gray-400 text-gray-700 font-bold text-xl px-12 py-4 rounded-full shadow-lg border-4 border-gray-300 cursor-not-allowed">
                ✓ Claimed Today
            </div>
            <p class="text-gray-600 mt-3 text-sm">Kembali besok untuk claim lagi!</p>
        <?php endif; ?>
    </div>

    <!-- Reset Info -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-start gap-4">
            <div class="bg-blue-500 rounded-full p-3 text-white flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-800 mb-2">📅 Cara Kerja Daily Rewards</h3>
                <ul class="text-gray-700 text-sm space-y-2">
                    <li>• Login setiap hari untuk claim poin gratis</li>
                    <li>• Poin bertambah dari Day 1 (5 poin) sampai Day 7 (25 poin)</li>
                    <li>• Jika melewatkan 1 hari, progress akan reset ke Day 1</li>
                    <li>• Setelah Day 7, akan kembali ke Day 1 dengan streak +1</li>
                    <li>• Reset otomatis setiap jam 00:00 WIB</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Aplikasi Kasir v2\resources\views/member/daily-rewards.blade.php ENDPATH**/ ?>