<?php $__env->startSection('title', 'Meus Posts'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex flex-wrap justify-content-between align-items-center pt-4">
                <div>
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-user me-2" style="color: var(--primary-blue);"></i>
                        Meus Posts
                    </h4>
                    <p class="text-muted small mb-0">Gerencie todos os seus posts</p>
                </div>
                <a href="<?php echo e(route('posts.create')); ?>" class="btn btn-primary mt-3 mt-sm-0">
                    <i class="fas fa-plus-circle me-2"></i>Novo Post
                </a>
            </div>

            <div class="card-body">
                <?php if($posts->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Título</th>
                                    <th>Categoria</th>
                                    <th>Data</th>
                                    <th>Comentários</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo e(route('posts.show', $post)); ?>" class="text-decoration-none fw-medium">
                                                <?php echo e(Str::limit($post->title, 40)); ?>

                                            </a>
                                        </td>
                                        <td>
                                            <?php if($post->category): ?>
                                                <span class="badge bg-light text-dark">
                                                    <?php echo e($post->category); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="small text-muted">
                                                <i class="far fa-calendar me-1"></i>
                                                <?php echo e($post->created_at->format('d/m/Y H:i')); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill bg-light text-dark">
                                                <?php echo e($post->comments_count ?? 0); ?>

                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="<?php echo e(route('posts.edit', $post)); ?>" 
                                               class="btn btn-sm btn-outline-warning me-1"
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('posts.destroy', $post)); ?>" 
                                                  method="POST" 
                                                  class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Excluir este post?')"
                                                        title="Excluir">
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
                        <h5 class="text-muted fw-normal">Você ainda não tem posts</h5>
                        <p class="text-muted small mb-3">Comece a compartilhar suas iniciativas!</p>
                        <a href="<?php echo e(route('posts.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Criar primeiro post
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\47808487848\Desktop\projeto\redesocialweb\resources\views/posts/my-posts.blade.php ENDPATH**/ ?>