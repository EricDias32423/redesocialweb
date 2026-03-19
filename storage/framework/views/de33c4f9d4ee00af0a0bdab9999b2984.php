<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONG · Login institucional</title>
    <!-- Bootstrap 5 + ícones + fonte Inter (mesmo estilo das telas anteriores) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/loginong.css']); ?>
</head>

<body>

    <div class="card-split">
        <!-- LADO ESQUERDO: azul para ONG, com elementos visuais institucionais -->
        <div class="brand-panel">
            <div class="brand-icon">
                <h2>Faça acesso e cadastre sua ONG</h2>
            </div>
        </div>

        <!-- LADO DIREITO: formulário de login da ONG (adaptado do original) -->
        <div class="form-panel">
            <h3>Bem-vinda, ONG</h3>
            <div class="subtitle">Acesse sua conta institucional</div>

            <form method="POST" action="<?php echo e(route('ong.login')); ?>">
                <?php echo csrf_field(); ?>

                <!-- E-mail institucional -->
                <div class="mb-4">
                    <label for="email" class="form-label">E-MAIL INSTITUCIONAL</label>
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

                <!-- Senha -->
                <div class="mb-4">
                    <label for="password" class="form-label">SENHA</label>
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

                <!-- Lembrar-me e esqueceu senha -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                        <label class="form-check-label small" for="remember">Lembrar-me</label>
                    </div>
                    <a href="#" class="small text-decoration-none bottom-link">Esqueceu a senha?</a>
                </div>

                <!-- Botão entrar (azul) -->
                <button type="submit" class="btn-entrar-ong">
                    <i class="fas fa-sign-in-alt me-2"></i>Entrar
                </button>

                <!-- Link rápido para registro (rodapé do form) -->
                <p class="text-center text-muted small mt-4 mb-0">
                    Ainda não tem uma conta institucional?
                    <a href="<?php echo e(route('ong.register')); ?>" class="bottom-link">Registrar ONG</a>
                </p>

                <div class="mt-3">
                    <a href="<?php echo e(route('choose.role')); ?>" class="text-muted small text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html><?php /**PATH C:\Users\47808487848\Herd\redesocialweb\resources\views/auth/ong/login.blade.php ENDPATH**/ ?>