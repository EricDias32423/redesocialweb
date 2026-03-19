<?php $__env->startSection('title', 'Meu Painel'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 text-success">
                    <i class="fas fa-tachometer-alt me-2"></i>Meu Painel
                </h1>
                <p class="text-muted">Bem-vindo de volta, <?php echo e($user->name); ?>!</p>
            </div>
            <a href="<?php echo e(route('regular.ongs.index')); ?>" class="btn btn-success">
                <i class="fas fa-hand-holding-heart me-2"></i>Descobrir ONGs
            </a>
        </div>

        
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">ONGs Apoiadas</h6>
                                <h2 class="mb-0"><?php echo e($stats['total_ongs_supported']); ?></h2>
                            </div>
                            <i class="fas fa-hand-holding-heart fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Comentários</h6>
                                <h2 class="mb-0"><?php echo e($stats['total_comments']); ?></h2>
                            </div>
                            <i class="fas fa-comments fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Curtidas</h6>
                                <h2 class="mb-0"><?php echo e($stats['total_likes_given']); ?></h2>
                            </div>
                            <i class="fas fa-heart fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Membro desde</h6>
                                <h5 class="mb-0"><?php echo e($stats['member_since']); ?></h5>
                            </div>
                            <i class="fas fa-calendar-alt fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-history me-2 text-success"></i>Atividades Recentes</h5>
                    </div>
                    <div class="card-body">
                        <?php if(count($recentActivities) > 0): ?>
                            <div class="timeline">
                                <?php $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0">
                                            <span class="badge bg-<?php echo e($activity['color']); ?> rounded-pill p-2">
                                                <i class="<?php echo e($activity['icon']); ?>"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1"><?php echo e($activity['description']); ?></p>
                                            <small class="text-muted"><?php echo e($activity['date']->diffForHumans()); ?></small>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Nenhuma atividade recente</p>
                                <a href="<?php echo e(route('regular.ongs.index')); ?>" class="btn btn-sm btn-success">
                                    Começar a apoiar ONGs
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-star me-2 text-success"></i>ONGs Recomendadas</h5>
                        <a href="<?php echo e(route('regular.ongs.index')); ?>" class="btn btn-sm btn-outline-success">Ver todas</a>
                    </div>
                    <div class="card-body">
                        <?php if(count($recommendedOngs) > 0): ?>
                            <?php $__currentLoopData = $recommendedOngs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                    <div class="flex-shrink-0">
                                        <?php if($ong->logo): ?>
                                            <img src="<?php echo e(asset('storage/' . $ong->logo)); ?>" 
                                                 class="rounded-circle" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-building text-white"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1"><?php echo e($ong->ong_name); ?></h6>
                                        <small class="text-muted">
                                            <i class="fas fa-newspaper me-1"></i><?php echo e($ong->posts_count); ?> posts
                                        </small>
                                    </div>
                                    <div>
                                        <a href="<?php echo e(route('regular.ongs.show', $ong)); ?>" 
                                           class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-building fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Nenhuma recomendação no momento</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row mt-2">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-newspaper me-2 text-success"></i>Últimos Posts das ONGs que você apoia</h5>
                    </div>
                    <div class="card-body">
                        <?php if(isset($feedPosts) && count($feedPosts) > 0): ?>
                            <div class="row">
                                <?php $__currentLoopData = $feedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <?php if($post->image): ?>
                                                <img src="<?php echo e(asset('storage/' . $post->image)); ?>" 
                                                     class="card-img-top" 
                                                     style="height: 150px; object-fit: cover;">
                                            <?php endif; ?>
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2">
                                                    <?php if($post->ong->logo): ?>
                                                        <img src="<?php echo e(asset('storage/' . $post->ong->logo)); ?>" 
                                                             class="rounded-circle me-2" 
                                                             style="width: 30px; height: 30px; object-fit: cover;">
                                                    <?php endif; ?>
                                                    <small class="text-muted"><?php echo e($post->ong->ong_name); ?></small>
                                                </div>
                                                <h6 class="card-title"><?php echo e(Str::limit($post->title, 50)); ?></h6>
                                                <p class="card-text small text-muted">
                                                    <?php echo e(Str::limit(strip_tags($post->content), 80)); ?>

                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <a href="<?php echo e(route('posts.show', $post)); ?>" 
                                                       class="btn btn-sm btn-outline-success">
                                                        Ler mais
                                                    </a>
                                                    <small class="text-muted">
                                                        <?php echo e($post->created_at->diffForHumans()); ?>

                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Comece a apoiar ONGs para ver posts no seu feed</p>
                                <a href="<?php echo e(route('regular.ongs.index')); ?>" class="btn btn-success">
                                    <i class="fas fa-hand-holding-heart me-2"></i>Descobrir ONGs
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.timeline {
    position: relative;
    padding-left: 1rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 1.5rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #e9ecef;
}

.timeline .d-flex {
    position: relative;
    z-index: 1;
}

.timeline .badge {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\47808487848\Desktop\projeto\redesocialweb\resources\views/regular/dashboard.blade.php ENDPATH**/ ?>