

<?php $__env->startSection('title', 'Login - ONG'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header bg-primary text-white text-center py-4">
                <h3 class="mb-0">
                    <i class="fas fa-building me-2"></i>Login - ONG
                </h3>
                <p class="text-white-50 mb-0 small">Acesse sua conta institucional</p>
            </div>
            
            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('ong.login')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="form-floating mb-3">
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
                               placeholder="nome@ong.com"
                               value="<?php echo e(old('email')); ?>" 
                               required 
                               autofocus>
                        <label for="email">
                            <i class="fas fa-envelope me-2 text-primary"></i>E-mail
                        </label>
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

                    <div class="form-floating mb-3">
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
                               placeholder="Senha"
                               required>
                        <label for="password">
                            <i class="fas fa-lock me-2 text-primary"></i>Senha
                        </label>
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

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="remember">
                            <i class="far fa-check-square me-1"></i>Lembrar-me
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Entrar
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-light text-center py-3">
                <div class="small">
                    <span class="text-muted">Ainda não tem uma conta?</span>
                    <a href="<?php echo e(route('ong.register')); ?>" class="text-primary fw-bold ms-2">
                        <i class="fas fa-plus-circle me-1"></i>Registrar ONG
                    </a>
                </div>
                <div class="small mt-2">
                    <a href="<?php echo e(route('choose.role')); ?>" class="text-muted">
                        <i class="fas fa-arrow-left me-1"></i>Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ericl\Downloads\rede\rede\rede-social-ongs\resources\views/auth/ong/login.blade.php ENDPATH**/ ?>