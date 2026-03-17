

<?php $__env->startSection('title', 'Feed de Posts'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 text-success">
                <i class="fas fa-stream me-2"></i>Feed de Atividades
            </h1>
            <?php if(auth()->guard('ong')->check()): ?>
                <a href="<?php echo e(route('posts.create')); ?>" class="btn btn-success">
                    <i class="fas fa-plus-circle me-2"></i>Novo Post
                </a>
            <?php endif; ?>
        </div>

        
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="<?php echo e(route('posts.index')); ?>" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="search" 
                               placeholder="Buscar posts..." value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-select">
                            <option value="">Todas as categorias</option>
                            <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category); ?>"><?php echo e($category); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-search me-2"></i>Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <?php if($post->image): ?>
                            <img src="<?php echo e(asset('storage/' . $post->image)); ?>" 
                                 class="card-img-top" 
                                 style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            
                            <div class="d-flex align-items-center mb-3">
                                <?php if($post->ong->logo): ?>
                                    <img src="<?php echo e(asset('storage/' . $post->ong->logo)); ?>" 
                                         class="rounded-circle me-2" 
                                         style="width: 30px; height: 30px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center" 
                                         style="width: 30px; height: 30px;">
                                        <i class="fas fa-building text-white fa-sm"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <small class="text-muted"><?php echo e($post->ong->ong_name); ?></small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i><?php echo e($post->created_at->diffForHumans()); ?>

                                    </small>
                                </div>
                            </div>

                            <h5 class="card-title">
                                <a href="<?php echo e(route('posts.show', $post)); ?>" class="text-decoration-none text-dark">
                                    <?php echo e(Str::limit($post->title, 60)); ?>

                                </a>
                            </h5>

                            <?php if($post->category): ?>
                                <span class="badge bg-success bg-opacity-10 text-success mb-2">
                                    <i class="fas fa-tag me-1"></i><?php echo e($post->category); ?>

                                </span>
                            <?php endif; ?>

                            <p class="card-text text-muted">
                                <?php echo e(Str::limit(strip_tags($post->content), 100)); ?>

                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?php echo e(route('posts.show', $post)); ?>" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-eye me-1"></i>Ver mais
                                </a>
                                
                                <?php if(auth()->guard('regular')->check()): ?>
                                    <button class="btn btn-sm btn-outline-danger" onclick="likePost(<?php echo e($post->id); ?>)">
                                        <i class="far fa-heart"></i> Apoiar
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Nenhum post encontrado</h4>
                    <?php if(auth()->guard('ong')->check()): ?>
                        <a href="<?php echo e(route('posts.create')); ?>" class="btn btn-success mt-3">
                            <i class="fas fa-plus-circle me-2"></i>Seja o primeiro a postar
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <?php echo e($posts->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ericl\Downloads\rede\rede\rede-social-ongs\resources\views/posts/index.blade.php ENDPATH**/ ?>