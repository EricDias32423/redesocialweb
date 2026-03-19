<?php $__env->startSection('title', 'Estatísticas da ONG'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    <div class="col-12">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
            <h1 class="h2 fw-bold mb-0" style="color: var(--text-dark);">
                <i class="fas fa-chart-bar me-2" style="color: var(--primary-blue);"></i>
                Estatísticas
            </h1>
            <a href="<?php echo e(route('ong.dashboard')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
        <p class="text-muted mb-4">Acompanhe o desempenho da sua ONG</p>

        
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="small text-muted text-uppercase">Total de Posts</span>
                                <h2 class="mt-2 mb-0 fw-bold"><?php echo e($statistics['total_posts']); ?></h2>
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
                                <h2 class="mt-2 mb-0 fw-bold"><?php echo e($statistics['total_views']); ?></h2>
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
                                <h2 class="mt-2 mb-0 fw-bold"><?php echo e($statistics['total_comments']); ?></h2>
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
                                <span class="small text-muted text-uppercase">Curtidas</span>
                                <h2 class="mt-2 mb-0 fw-bold"><?php echo e($statistics['total_likes']); ?></h2>
                            </div>
                            <div class="rounded-circle bg-light p-3">
                                <i class="fas fa-heart fa-2x" style="color: var(--primary-blue);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-calendar-alt me-2" style="color: var(--primary-blue);"></i>
                            Posts por Mês
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="postsChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-tags me-2" style="color: var(--primary-blue);"></i>
                            Posts por Categoria
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="categoriesChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-fire me-2" style="color: var(--primary-blue);"></i>
                            Posts Mais Comentados
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <?php $__empty_1 = true; $__currentLoopData = $statistics['most_commented_posts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <a href="<?php echo e(route('posts.show', $post)); ?>" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                    <span class="fw-medium"><?php echo e(Str::limit($post->title, 40)); ?></span>
                                    <span class="badge rounded-pill bg-light text-dark">
                                        <?php echo e($post->comments_count); ?> <i class="fas fa-comment ms-1"></i>
                                    </span>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-5">
                                    <p class="text-muted mb-0">Nenhum dado disponível</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-star me-2" style="color: var(--primary-blue);"></i>
                            Posts Mais Curtidos
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <?php $__empty_1 = true; $__currentLoopData = $statistics['most_liked_posts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <a href="<?php echo e(route('posts.show', $post)); ?>" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                    <span class="fw-medium"><?php echo e(Str::limit($post->title, 40)); ?></span>
                                    <span class="badge rounded-pill bg-light text-dark">
                                        <?php echo e($post->likes_count); ?> <i class="fas fa-heart ms-1 text-danger"></i>
                                    </span>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-5">
                                    <p class="text-muted mb-0">Nenhum dado disponível</p>
                                </div>
                            <?php endif; ?>
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
    // Gráfico de posts por mês
    const postsCtx = document.getElementById('postsChart').getContext('2d');
    new Chart(postsCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($statistics['posts_per_month']->pluck('month')->map(function($m) {
                return \Carbon\Carbon::create()->month($m)->format('F');
            })); ?>,
            datasets: [{
                label: 'Posts',
                data: <?php echo json_encode($statistics['posts_per_month']->pluck('total')); ?>,
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                borderColor: '#007bff',
                borderWidth: 1,
                borderRadius: 6
            }]
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

    // Gráfico de categorias
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($statistics['best_performing_categories']->pluck('category')); ?>,
            datasets: [{
                data: <?php echo json_encode($statistics['best_performing_categories']->pluck('total_posts')); ?>,
                backgroundColor: [
                    'rgba(0, 123, 255, 0.7)',
                    'rgba(40, 167, 69, 0.7)',
                    'rgba(255, 193, 7, 0.7)',
                    'rgba(111, 66, 193, 0.7)',
                    'rgba(253, 126, 20, 0.7)',
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            cutout: '65%'
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\47808487848\Desktop\projeto\redesocialweb\resources\views/ong/statistics.blade.php ENDPATH**/ ?>