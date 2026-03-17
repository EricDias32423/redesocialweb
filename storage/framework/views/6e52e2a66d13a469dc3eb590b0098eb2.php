

<?php $__env->startSection('title', 'Estatísticas da ONG'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 text-primary">
                <i class="fas fa-chart-bar me-2"></i>Estatísticas da ONG
            </h1>
            <a href="<?php echo e(route('ong.dashboard')); ?>" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>

        
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="text-white-50">Total de Posts</h5>
                        <h2 class="mb-0"><?php echo e($statistics['total_posts']); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="text-white-50">Visualizações</h5>
                        <h2 class="mb-0"><?php echo e($statistics['total_views']); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="text-white-50">Comentários</h5>
                        <h2 class="mb-0"><?php echo e($statistics['total_comments']); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="text-white-50">Curtidas</h5>
                        <h2 class="mb-0"><?php echo e($statistics['total_likes']); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Posts por Mês</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="postsChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Posts por Categoria</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="categoriesChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Posts Mais Comentados</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php $__currentLoopData = $statistics['most_commented_posts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('posts.show', $post)); ?>" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <?php echo e(Str::limit($post->title, 50)); ?>

                                    <span class="badge bg-info rounded-pill"><?php echo e($post->comments_count); ?></span>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Posts Mais Curtidos</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php $__currentLoopData = $statistics['most_liked_posts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('posts.show', $post)); ?>" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <?php echo e(Str::limit($post->title, 50)); ?>

                                    <span class="badge bg-success rounded-pill"><?php echo e($post->likes_count); ?></span>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
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
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                ]
            }]
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ericl\Downloads\rede\rede\rede-social-ongs\resources\views/ong/statistics.blade.php ENDPATH**/ ?>