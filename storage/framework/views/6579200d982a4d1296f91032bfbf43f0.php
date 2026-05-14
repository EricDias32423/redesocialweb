

<?php $__env->startSection('title', 'Mensagens'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-comments me-2"></i>Minhas Mensagens
                    </h4>
                </div>

                <div class="card-body p-0">
                    <?php if($conversations->isEmpty()): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Nenhuma conversa ainda</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $other = $userType === 'regular' ? $conversation->ong : $conversation->regularUser;
                                    $otherName = $other->name ?? $other->ong_name ?? 'Contato';
                                    $lastMessage = $conversation->lastMessage();
                                    $unreadCount = $conversation->unreadCountFor($user->id, $userType);
                                ?>

                                <a href="<?php echo e(route($routePrefix . '.chat.show', $conversation)); ?>" 
                                   class="list-group-item list-group-item-action border-0 border-bottom py-3 <?php echo e($unreadCount > 0 ? 'bg-light' : ''); ?>">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">
                                                <?php echo e($otherName); ?>

                                                <?php if($unreadCount > 0): ?>
                                                    <span class="badge bg-danger ms-2"><?php echo e($unreadCount); ?></span>
                                                <?php endif; ?>
                                            </h6>
                                            <?php if($lastMessage): ?>
                                                <p class="mb-0 text-muted small">
                                                    <strong><?php echo e($lastMessage->senderName()); ?>:</strong>
                                                    <?php echo e(Str::limit($lastMessage->content, 50)); ?>

                                                </p>
                                            <?php else: ?>
                                                <p class="mb-0 text-muted small">Nenhuma mensagem ainda</p>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-muted">
                                            <?php if($lastMessage): ?>
                                                <?php echo e($lastMessage->created_at->diffForHumans()); ?>

                                            <?php endif; ?>
                                        </small>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\47808487848\Herd\redesocialweb\resources\views/chat/index.blade.php ENDPATH**/ ?>