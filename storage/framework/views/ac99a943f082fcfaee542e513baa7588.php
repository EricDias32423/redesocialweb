<?php $__env->startSection('title', 'ONGs para Apoiar'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 fw-bold mb-1" style="color: var(--text-dark);">
                    <i class="fas fa-hand-holding-heart me-2" style="color: var(--primary-green);"></i>
                    ONGs para Apoiar
                </h1>
                <p class="text-muted">Conheça e apoie organizações que fazem a diferença</p>
            </div>
            
            
            <form action="<?php echo e(route('regular.ongs.index')); ?>" method="GET" class="mt-3 mt-sm-0">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Buscar ONG..." value="<?php echo e(request('search')); ?>">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = $ongs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body text-center p-4">
                            
                            <div class="mb-3">
                                <?php if($ong->logo): ?>
                                    <img src="<?php echo e(asset('storage/' . $ong->logo)); ?>" 
                                         class="rounded-circle border"
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                                         style="width: 100px; height: 100px;">
                                        <i class="fas fa-building fa-3x" style="color: var(--primary-green);"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            
                            <h4 class="fw-semibold mb-2"><?php echo e($ong->ong_name); ?></h4>
                            
                            
                            <p class="small text-muted mb-3">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                <?php echo e($ong->address ?? 'Localização não informada'); ?>

                            </p>

                            
                            <p class="card-text text-muted small mb-3">
                                <?php echo e(Str::limit($ong->description ?? 'Sem descrição disponível', 100)); ?>

                            </p>

                            
                            <div class="d-flex justify-content-around mb-4">
                                <div class="text-center">
                                    <span class="fw-bold d-block"><?php echo e($ong->posts_count ?? 0); ?></span>
                                    <small class="text-muted">Posts</small>
                                </div>
                                <div class="text-center">
                                    <span class="fw-bold d-block">0</span>
                                    <small class="text-muted">Apoiadores</small>
                                </div>
                            </div>

                            
                            <div class="d-flex gap-2">
                                <a href="<?php echo e(route('regular.ongs.show', $ong)); ?>" class="btn btn-primary flex-grow-1">
                                    <i class="fas fa-eye me-2"></i>Ver perfil
                                </a>
                                <?php if(auth()->guard('regular')->check()): ?>
                                    <form action="<?php echo e(route('regular.ongs.support', $ong)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-outline-success">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-building fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted fw-normal">Nenhuma ONG encontrada</h4>
                        <?php if(request('search')): ?>
                            <p class="text-muted">Tente outros termos de busca.</p>
                            <a href="<?php echo e(route('regular.ongs.index')); ?>" class="btn btn-outline-secondary mt-3">
                                <i class="fas fa-times me-2"></i>Limpar busca
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        
        <?php if($ongs->hasPages()): ?>
            <div class="d-flex justify-content-center mt-5">
                <?php echo e($ongs->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.hover-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.hover-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.08) !important;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\47808487848\Herd\redesocialweb\resources\views/regular/ongs/index.blade.php ENDPATH**/ ?>