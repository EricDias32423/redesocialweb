<?php $__env->startSection('title', 'Login - ONG'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center fade-in">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white text-center py-4 border-0">
                <div class="mb-3">
                    <div class="rounded-circle bg-light d-inline-flex p-3">
                        <i class="fas fa-building fa-3x" style="color: var(--primary-blue);"></i>
                    </div>
                </div>
                <h4 class="mb-1 fw-bold">Bem-vinda, ONG</h4>
                <p class="text-muted small">Acesse sua conta institucional</p>
            </div>

            <div class="card-body px-4 py-3">
                <form method="POST" action="<?php echo e(route('ong.login')); ?>">
                    <?php echo csrf_field(); ?>
                    
                    <div class="mb-4">
                        <label for="email" class="form-label text-muted small fw-semibold">E-MAIL INSTITUCIONAL</label>
                        <input type="email" 
                               class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="email" 
                               name="email" 
                               value="<?php echo e(old('email')); ?>" 
                               placeholder="contato@ong.org"
                               required 
                               autofocus>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label text-muted small fw-semibold">SENHA</label>
                        <input type="password" 
                               class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="password" 
                               name="password" 
                               placeholder="••••••••"
                               required>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                            <label class="form-check-label small" for="remember">Lembrar-me</label>
                        </div>
                        <a href="#" class="small text-decoration-none" style="color: var(--primary-blue);">Esqueceu a senha?</a>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Entrar
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-white text-center py-4 border-0">
                <p class="mb-2 text-muted small">Ainda não tem uma conta?</p>
                <a href="<?php echo e(route('ong.register')); ?>" class="btn btn-outline-primary px-4">
                    <i class="fas fa-plus-circle me-2"></i>Registrar ONG
                </a>
                <div class="mt-3">
                    <a href="<?php echo e(route('choose.role')); ?>" class="text-muted small text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ericl\Downloads\projetas\redesocialweb\resources\views/auth/ong/login.blade.php ENDPATH**/ ?>