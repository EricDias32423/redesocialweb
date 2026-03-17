

<?php $__env->startSection('title', 'Painel da ONG'); ?>

<?php $__env->startSection('content'); ?>

<div class="alert alert-info">
    <h5>🔍 DEBUG INFORMAÇÕES:</h5>
    <ul>
        <li>Usuário logado como ONG: <strong><?php echo e(Auth::guard('ong')->check() ? 'SIM' : 'NÃO'); ?></strong></li>
        <li>Nome da ONG: <strong><?php echo e(Auth::guard('ong')->user()->ong_name ?? 'N/A'); ?></strong></li>
        <li>Rota 'posts.create' existe: <strong><?php echo e(Route::has('posts.create') ? 'SIM' : 'NÃO'); ?></strong></li>
        <li>URL gerada: <strong><?php echo e(route('posts.create')); ?></strong></li>
    </ul>
</div>
<div class="row">
    <div class="col-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 text-primary">
                    <i class="fas fa-tachometer-alt me-2"></i>Painel da ONG
                </h1>
                <p class="text-muted">Bem-vindo de volta, <?php echo e(Auth::guard('ong')->user()->ong_name); ?>!</p>
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
                <a href="<?php echo e($createRoute); ?>" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Novo Post
                </a>
            <?php else: ?>
                <span class="text-danger">Rota de criação não encontrada</span>
            <?php endif; ?>
        </div>

        
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Total de Posts</h6>
                                <h2 class="mb-0"><?php echo e($stats['total_posts']); ?></h2>
                            </div>
                            <i class="fas fa-newspaper fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Visualizações</h6>
                                <h2 class="mb-0"><?php echo e($stats['total_views']); ?></h2>
                            </div>
                            <i class="fas fa-eye fa-3x text-white-50"></i>
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
                                <h6 class="text-white-50 mb-2">Apoiadores</h6>
                                <h2 class="mb-0"><?php echo e($stats['total_followers']); ?></h2>
                            </div>
                            <i class="fas fa-heart fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Atividade Recente</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="activityChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-building me-2 text-primary"></i>Minha ONG</h5>
                    </div>
                    <div class="card-body text-center">
                        <?php if(Auth::guard('ong')->user()->logo): ?>
                            <img src="<?php echo e(asset('storage/' . Auth::guard('ong')->user()->logo)); ?>" 
                                 class="rounded-circle mb-3" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                 style="width: 100px; height: 100px;">
                                <i class="fas fa-building text-white fa-3x"></i>
                            </div>
                        <?php endif; ?>
                        
                        <h5><?php echo e(Auth::guard('ong')->user()->ong_name); ?></h5>
                        <p class="text-muted small">
                            <i class="fas fa-envelope me-1"></i><?php echo e(Auth::guard('ong')->user()->email); ?>

                        </p>
                        <p class="text-muted small">
                            <i class="fas fa-calendar me-1"></i>Membro desde <?php echo e($stats['member_since']); ?>

                        </p>
                        
                        <div class="d-grid gap-2 mt-3">
                            <a href="<?php echo e(route('ong.profile.edit')); ?>" class="btn btn-outline-primary">
                                <i class="fas fa-edit me-2"></i>Editar Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-newspaper me-2 text-primary"></i>Últimos Posts</h5>
                        
                        
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
                            <a href="<?php echo e($myPostsRoute); ?>" class="btn btn-sm btn-outline-primary">Ver todos</a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Categoria</th>
                                        <th>Data</th>
                                        <th>Comentários</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $recentPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td>
                                                
                                                <?php
                                                    $showRoute = null;
                                                    if (Route::has('posts.show')) {
                                                        $showRoute = route('posts.show', $post);
                                                    }
                                                ?>
                                                
                                                <?php if($showRoute): ?>
                                                    <a href="<?php echo e($showRoute); ?>" class="text-decoration-none">
                                                        <?php echo e(Str::limit($post->title, 50)); ?>

                                                    </a>
                                                <?php else: ?>
                                                    <?php echo e(Str::limit($post->title, 50)); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($post->category): ?>
                                                    <span class="badge bg-info"><?php echo e($post->category); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($post->created_at->format('d/m/Y')); ?></td>
                                            <td>
                                                <span class="badge bg-secondary"><?php echo e($post->comments_count ?? 0); ?></span>
                                            </td>
                                            <td>
                                                
                                                <?php
                                                    $editRoute = null;
                                                    if (Route::has('posts.edit')) {
                                                        $editRoute = route('posts.edit', $post);
                                                    } elseif (Route::has('ong.posts.edit')) {
                                                        $editRoute = route('ong.posts.edit', $post);
                                                    }
                                                ?>
                                                
                                                <?php if($editRoute): ?>
                                                    <a href="<?php echo e($editRoute); ?>" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                <?php endif; ?>
                                                
                                                
                                                <?php
                                                    $destroyRoute = null;
                                                    if (Route::has('posts.destroy')) {
                                                        $destroyRoute = route('posts.destroy', $post);
                                                    } elseif (Route::has('ong.posts.destroy')) {
                                                        $destroyRoute = route('ong.posts.destroy', $post);
                                                    }
                                                ?>
                                                
                                                <?php if($destroyRoute): ?>
                                                    <form action="<?php echo e($destroyRoute); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('Excluir este post?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Nenhum post criado ainda</p>
                                                
                                                <?php if($createRoute): ?>
                                                    <a href="<?php echo e(route('posts.create')); ?>" class="btn btn-primary">
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
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Posts',
                data: [12, 19, 3, 5, 2, 3],
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }, {
                label: 'Comentários',
                data: [5, 10, 8, 12, 7, 9],
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ericl\Downloads\rede\rede\rede-social-ongs\resources\views/ong/dashboard.blade.php ENDPATH**/ ?>