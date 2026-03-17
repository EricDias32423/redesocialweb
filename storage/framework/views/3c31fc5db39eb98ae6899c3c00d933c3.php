

<?php $__env->startSection('title', 'Registro de ONG'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header bg-primary text-white text-center py-4">
                <h3 class="mb-0">
                    <i class="fas fa-hand-holding-heart me-2"></i>Cadastre sua ONG
                </h3>
                <p class="text-white-50 mb-0 small">Faça parte da nossa rede de organizações</p>
            </div>
            
            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('ong.register')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    
                    <div class="bg-light p-3 rounded mb-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-user-circle me-2"></i>Dados do Responsável
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control <?php $__errorArgs = ['responsible_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="responsible_name" 
                                           name="responsible_name" 
                                           placeholder="Nome completo"
                                           value="<?php echo e(old('responsible_name')); ?>" 
                                           required>
                                    <label for="responsible_name">
                                        <i class="fas fa-user me-2 text-primary"></i>Nome do Responsável
                                    </label>
                                    <?php $__errorArgs = ['responsible_name'];
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
                            </div>
                        </div>
                    </div>

                    
                    <div class="bg-light p-3 rounded mb-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-building me-2"></i>Dados da ONG
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control <?php $__errorArgs = ['ong_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="ong_name" 
                                           name="ong_name" 
                                           placeholder="Nome da ONG"
                                           value="<?php echo e(old('ong_name')); ?>" 
                                           required>
                                    <label for="ong_name">
                                        <i class="fas fa-tag me-2 text-primary"></i>Nome da ONG
                                    </label>
                                    <?php $__errorArgs = ['ong_name'];
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
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control <?php $__errorArgs = ['cnpj'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="cnpj" 
                                           name="cnpj" 
                                           placeholder="00.000.000/0000-00"
                                           value="<?php echo e(old('cnpj')); ?>">
                                    <label for="cnpj">
                                        <i class="fas fa-id-card me-2 text-primary"></i>CNPJ (opcional)
                                    </label>
                                    <?php $__errorArgs = ['cnpj'];
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
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              id="description" 
                                              name="description" 
                                              placeholder="Descrição da ONG"
                                              style="height: 100px"><?php echo e(old('description')); ?></textarea>
                                    <label for="description">
                                        <i class="fas fa-align-left me-2 text-primary"></i>Descrição (opcional)
                                    </label>
                                    <?php $__errorArgs = ['description'];
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
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="phone" 
                                           name="phone" 
                                           placeholder="(00) 00000-0000"
                                           value="<?php echo e(old('phone')); ?>">
                                    <label for="phone">
                                        <i class="fas fa-phone me-2 text-primary"></i>Telefone (opcional)
                                    </label>
                                    <?php $__errorArgs = ['phone'];
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
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="address" 
                                           name="address" 
                                           placeholder="Endereço completo"
                                           value="<?php echo e(old('address')); ?>">
                                    <label for="address">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>Endereço (opcional)
                                    </label>
                                    <?php $__errorArgs = ['address'];
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
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="logo" class="form-label text-primary">
                                    <i class="fas fa-image me-2"></i>Logo da ONG (opcional)
                                </label>
                                <input type="file" 
                                       class="form-control <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="logo" 
                                       name="logo" 
                                       accept="image/*">
                                <small class="text-muted">Formatos: JPG, PNG, GIF. Máx: 2MB</small>
                                <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                
                                <div id="logo-preview" class="mt-2 text-center" style="display: none;">
                                    <img src="#" alt="Preview" class="img-fluid rounded" style="max-height: 100px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="bg-light p-3 rounded mb-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-lock me-2"></i>Credenciais de Acesso
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
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
                                           placeholder="contato@ong.org"
                                           value="<?php echo e(old('email')); ?>" 
                                           required>
                                    <label for="email">
                                        <i class="fas fa-envelope me-2 text-primary"></i>E-mail institucional
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
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
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
                                        <i class="fas fa-key me-2 text-primary"></i>Senha
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
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Confirmar senha"
                                           required>
                                    <label for="password_confirmation">
                                        <i class="fas fa-check-circle me-2 text-primary"></i>Confirmar senha
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label" for="terms">
                            Concordo com os <a href="#" class="text-primary">Termos de Uso</a> e 
                            <a href="#" class="text-primary">Política de Privacidade</a>
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-check-circle me-2"></i>Cadastrar ONG
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-light text-center py-3">
                <div class="small">
                    <span class="text-muted">Já tem uma conta?</span>
                    <a href="<?php echo e(route('ong.login')); ?>" class="text-primary fw-bold ms-2">
                        <i class="fas fa-sign-in-alt me-1"></i>Fazer login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Preview da logo
document.getElementById('logo').addEventListener('change', function(e) {
    const preview = document.getElementById('logo-preview');
    const img = preview.querySelector('img');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});

// Validação de senha
document.getElementById('password').addEventListener('keyup', function() {
    const password = this.value;
    if (password.length < 8) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
});

document.getElementById('password_confirmation').addEventListener('keyup', function() {
    const password = document.getElementById('password').value;
    const confirm = this.value;
    
    if (password !== confirm) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ericl\Downloads\rede\rede\rede-social-ongs\resources\views/auth/ong/register.blade.php ENDPATH**/ ?>