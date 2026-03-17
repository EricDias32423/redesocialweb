

<?php $__env->startSection('title', 'Meus Posts'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-user me-2"></i>Meus Posts</h4>
                <a href="<?php echo e(route('posts.create')); ?>" class="btn btn-light btn-sm">
                    <i class="fas fa-plus-circle me-1"></i>Novo Post
                </a>
            </div>
            <div class="card-body">
                <?php if($posts->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Categoria</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo e(route('posts.show', $post)); ?>">
                                                <?php echo e(Str::limit($post->title, 50)); ?>

                                            </a>
                                        </td>
                                        <td>
                                            <?php if($post->category): ?>
                                                <span class="badge bg-info"><?php echo e($post->category); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($post->created_at->format('d/m/Y H:i')); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('posts.edit', $post)); ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('posts.destroy', $post)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Excluir este post?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($posts->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Você ainda não tem posts</h4>
                        <a href="<?php echo e(route('posts.create')); ?>" class="btn btn-success mt-3">
                            <i class="fas fa-plus-circle me-2"></i>Criar primeiro post
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ericl\Downloads\rede\rede\rede-social-ongs\resources\views/posts/my-posts.blade.php ENDPATH**/ ?>