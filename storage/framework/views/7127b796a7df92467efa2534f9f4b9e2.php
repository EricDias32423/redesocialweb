<?php $__env->startSection('title', 'Feed de Posts'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 fw-bold mb-1" style="color: var(--text-dark);">
                    <i class="fas fa-stream me-2" style="color: var(--primary-green);"></i>
                    Feed de Atividades
                </h1>
                <p class="text-muted">Acompanhe as últimas atualizações das ONGs</p>
            </div>
            <?php if(auth()->guard('ong')->check()): ?>
                <a href="<?php echo e(route('posts.create')); ?>" class="btn btn-primary mt-3 mt-sm-0">
                    <i class="fas fa-plus-circle me-2"></i>Novo Post
                </a>
            <?php endif; ?>
        </div>

        
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="<?php echo e(route('posts.index')); ?>" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" 
                                   name="search" 
                                   placeholder="Buscar posts por título ou conteúdo..."
                                   value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-select">
                            <option value="">Todas as categorias</option>
                            <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category); ?>" <?php echo e(request('category') == $category ? 'selected' : ''); ?>>
                                    <?php echo e($category); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <?php if($post->image): ?>
                            <img src="<?php echo e(asset('storage/' . $post->image)); ?>" 
                                 class="card-img-top" 
                                 style="height: 200px; object-fit: cover; border-radius: 0.5rem 0.5rem 0 0;">
                        <?php else: ?>
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 200px; border-radius: 0.5rem 0.5rem 0 0;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            
                            <div class="d-flex align-items-center mb-3">
                                <?php if($post->ong->logo): ?>
                                    <img src="<?php echo e(asset('storage/' . $post->ong->logo)); ?>" 
                                         class="rounded-circle me-2" 
                                         style="width: 30px; height: 30px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2"
                                         style="width: 30px; height: 30px;">
                                        <i class="fas fa-building text-muted fa-sm"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <small class="fw-medium"><?php echo e($post->ong->ong_name); ?></small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i><?php echo e($post->created_at->diffForHumans()); ?>

                                    </small>
                                </div>
                            </div>

                            <h5 class="card-title fw-semibold mb-2">
                                <a href="<?php echo e(route('posts.show', $post)); ?>" class="text-decoration-none text-dark">
                                    <?php echo e(Str::limit($post->title, 50)); ?>

                                </a>
                            </h5>

                            <?php if($post->category): ?>
                                <span class="badge bg-light text-dark mb-2">
                                    <i class="fas fa-tag me-1"></i><?php echo e($post->category); ?>

                                </span>
                            <?php endif; ?>

                            <p class="card-text text-muted small">
                                <?php echo e(Str::limit(strip_tags($post->content), 120)); ?>

                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="<?php echo e(route('posts.show', $post)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>Ler mais
                                </a>
                                
                                <div class="small text-muted">
                                    <i class="far fa-comment me-1"></i> <?php echo e($post->comments_count ?? 0); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted fw-normal">Nenhum post encontrado</h4>
                        <p class="text-muted mb-3">
                            <?php if(request('search') || request('category')): ?>
                                Tente outros termos de busca ou limpe os filtros.
                            <?php else: ?>
                                Seja o primeiro a compartilhar uma notícia!
                            <?php endif; ?>
                        </p>
                        <div>
                            <?php if(request('search') || request('category')): ?>
                                <a href="<?php echo e(route('posts.index')); ?>" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-times me-2"></i>Limpar filtros
                                </a>
                            <?php endif; ?>
                            <?php if(auth()->guard('ong')->check()): ?>
                                <a href="<?php echo e(route('posts.create')); ?>" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Criar post
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="d-flex justify-content-center mt-5">
            <?php echo e($posts->withQueryString()->links()); ?>

        </div>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\47808487848\Desktop\projeto\redesocialweb\resources\views/posts/index.blade.php ENDPATH**/ ?>