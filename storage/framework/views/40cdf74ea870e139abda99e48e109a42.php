

<?php $__env->startSection('title', 'Verificar Código'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white text-center py-4 border-0">
                <div class="mb-3">
                    <div class="rounded-circle bg-light d-inline-flex p-3">
                        <i class="fas fa-shield-alt fa-3x" style="color: var(--primary-blue);"></i>
                    </div>
                </div>
                <h4 class="mb-1 fw-bold">Verificação em duas etapas</h4>
                <p class="text-muted small">Digite o código enviado para seu e-mail</p>
            </div>

            <div class="card-body px-4 py-3">
                <?php if(session('success')): ?>
                    <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success py-2 mb-3">
                        <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger py-2 mb-3">
                        <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('2fa.verify.submit')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="user_id" value="<?php echo e($user_id); ?>">

                    <div class="mb-4">
                        <label for="code" class="form-label text-muted small fw-semibold">CÓDIGO DE VERIFICAÇÃO</label>
                        <div class="text-center">
                            <input type="text" 
                                   class="form-control text-center <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="code" 
                                   name="code" 
                                   placeholder="000000"
                                   maxlength="6"
                                   style="font-size: 2rem; letter-spacing: 0.5rem;"
                                   required>
                            <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback text-center"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                O código é válido por <strong>2 minutos</strong>.
                            </small>
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="fas fa-check-circle me-2"></i>Verificar
                        </button>
                    </div>
                </form>

                <div class="text-center">
                    <form method="POST" action="<?php echo e(route('2fa.resend')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="user_id" value="<?php echo e($user_id); ?>">
                        <button type="submit" class="btn btn-link text-muted small">
                            <i class="fas fa-redo-alt me-1"></i>Reenviar código
                        </button>
                    </form>
                    <a href="<?php echo e(route('regular.login')); ?>" class="text-muted small text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>Voltar para o login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\47808487848\Herd\redesocialweb\resources\views/auth/verify-2fa.blade.php ENDPATH**/ ?>