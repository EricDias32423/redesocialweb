<?php $__env->startSection('title', 'Painel da ONG'); ?>

<?php $__env->startSection('content'); ?>


<div class="row g-4">
    <div class="col-12">
        
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 fw-bold mb-1" style="color: var(--text-dark);">
                    <i class="fas fa-tachometer-alt me-2" style="color: var(--primary-blue);"></i>
                    Painel da ONG
                </h1>
                <p class="text-muted mb-0">
                    <i class="fas fa-calendar-alt me-1"></i>
                    <?php echo e(now()->format('d F, Y')); ?>

                </p>
            </div>
            
            <?php
                $createRoute = null;
                if (Route::has('posts.create')) {
                    $createRoute = route('posts.create');
                } elseif (Route::has('ong.posts.create')) {
                    $createRoute = route('ong.posts.create');
                }
            ?>
            
            <?php if($createRoute): ?>
                <a href="<?php echo e($createRoute); ?>" class="btn btn-primary mt-3 mt-sm-0">
                    <i class="fas fa-plus-circle me-2"></i>Novo Post
                </a>
            <?php else: ?>
                <span class="text-danger bg-light px-3 py-2 rounded">Rota de criação não encontrada</span>
            <?php endif; ?>
        </div>

        
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="small text-muted text-uppercase">Total de Posts</span>
                                <h2 class="mt-2 mb-0 fw-bold"><?php echo e($stats['total_posts']); ?></h2>
                            </div>
                            <div class="rounded-circle bg-light p-3">
                                <i class="fas fa-newspaper fa-2x" style="color: var(--primary-blue);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="small text-muted text-uppercase">Visualizações</span>
                                <h2 class="mt-2 mb-0 fw-bold"><?php echo e($stats['total_views']); ?></h2>
                            </div>
                            <div class="rounded-circle bg-light p-3">
                                <i class="fas fa-eye fa-2x" style="color: var(--primary-blue);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="small text-muted text-uppercase">Comentários</span>
                                <h2 class="mt-2 mb-0 fw-bold"><?php echo e($stats['total_comments']); ?></h2>
                            </div>
                            <div class="rounded-circle bg-light p-3">
                                <i class="fas fa-comments fa-2x" style="color: var(--primary-blue);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="small text-muted text-uppercase">Apoiadores</span>
                                <h2 class="mt-2 mb-0 fw-bold"><?php echo e($stats['total_followers']); ?></h2>
                            </div>
                            <div class="rounded-circle bg-light p-3">
                                <i class="fas fa-heart fa-2x" style="color: var(--primary-blue);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-chart-line me-2" style="color: var(--primary-blue);"></i>
                            Atividade Recente
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="activityChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-building me-2" style="color: var(--primary-blue);"></i>
                            Minha ONG
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <?php if(Auth::guard('ong')->user()->logo): ?>
                                <img src="<?php echo e(asset('storage/' . Auth::guard('ong')->user()->logo)); ?>" 
                                     class="rounded-circle border border-2"
                                     style="width: 100px; height: 100px; object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                                     style="width: 100px; height: 100px;">
                                    <i class="fas fa-building fa-3x" style="color: var(--primary-blue);"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <h5 class="fw-bold mb-1"><?php echo e(Auth::guard('ong')->user()->ong_name); ?></h5>
                        <p class="small text-muted mb-3">
                            <i class="fas fa-envelope me-1"></i><?php echo e(Auth::guard('ong')->user()->email); ?>

                        </p>
                        
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                <i class="fas fa-calendar me-1"></i>Desde <?php echo e($stats['member_since']); ?>

                            </span>
                        </div>
                        
                        <a href="<?php echo e(route('ong.profile.edit')); ?>" class="btn btn-outline-primary w-100">
                            <i class="fas fa-edit me-2"></i>Editar Perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 d-flex flex-wrap justify-content-between align-items-center pt-4">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-newspaper me-2" style="color: var(--primary-blue);"></i>
                            Últimos Posts
                        </h5>
                        
                        <?php
                            $myPostsRoute = null;
                            if (Route::has('my-posts')) {
                                $myPostsRoute = route('my-posts');
                            } elseif (Route::has('ong.posts.index')) {
                                $myPostsRoute = route('ong.posts.index');
                            } elseif (Route::has('posts.index')) {
                                $myPostsRoute = route('posts.index');
                            }
                        ?>
                        
                        <?php if($myPostsRoute): ?>
                            <a href="<?php echo e($myPostsRoute); ?>" class="btn btn-sm btn-outline-primary">
                                Ver todos <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Título</th>
                                        <th>Categoria</th>
                                        <th>Data</th>
                                        <th class="text-center">Comentários</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $recentPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td>
                                                <?php
                                                    $showRoute = Route::has('posts.show') ? route('posts.show', $post) : null;
                                                ?>
                                                
                                                <?php if($showRoute): ?>
                                                    <a href="<?php echo e($showRoute); ?>" class="text-decoration-none fw-medium">
                                                        <?php echo e(Str::limit($post->title, 40)); ?>

                                                    </a>
                                                <?php else: ?>
                                                    <?php echo e(Str::limit($post->title, 40)); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($post->category): ?>
                                                    <span class="badge bg-light text-dark"><?php echo e($post->category); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">—</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="small text-muted">
                                                    <i class="far fa-calendar me-1"></i>
                                                    <?php echo e($post->created_at->format('d/m/Y')); ?>

                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge rounded-pill bg-light text-dark">
                                                    <?php echo e($post->comments_count ?? 0); ?>

                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <?php
                                                    $editRoute = Route::has('posts.edit') ? route('posts.edit', $post) : null;
                                                    $destroyRoute = Route::has('posts.destroy') ? route('posts.destroy', $post) : null;
                                                ?>
                                                
                                                <?php if($editRoute): ?>
                                                    <a href="<?php echo e($editRoute); ?>" class="btn btn-sm btn-outline-warning me-1">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                <?php endif; ?>
                                                
                                                <?php if($destroyRoute): ?>
                                                    <form action="<?php echo e($destroyRoute); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                onclick="return confirm('Excluir este post?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                                <p class="text-muted mb-3">Nenhum post criado ainda</p>
                                                
                                                <?php if($createRoute): ?>
                                                    <a href="<?php echo e($createRoute); ?>" class="btn btn-primary">
                                                        <i class="fas fa-plus-circle me-2"></i>Criar primeiro post
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('activityChart').getContext('2d');
    
    // Cores mais suaves para o gráfico
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [
                {
                    label: 'Posts',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.05)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Comentários',
                    data: [5, 10, 8, 12, 7, 9],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.05)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f0f0f0'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\47808487848\Herd\redesocialweb\resources\views/ong/dashboard.blade.php ENDPATH**/ ?>