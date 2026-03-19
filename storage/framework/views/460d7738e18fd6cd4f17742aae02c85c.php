<?php $__env->startSection('title', 'Escolha como acessar'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="text-center mb-5 fade-in">
            <h1 class="display-4 fw-bold" style="color: var(--text-dark);">Bem-vindo!</h1>
            <p class="lead text-muted">Escolha como deseja acessar a plataforma</p>
        </div>

        <div class="row g-4">
            
            <div class="col-md-6">
                <div class="card h-100 hover-card text-center p-4">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-4">
                            <div class="rounded-circle bg-light d-inline-flex p-4">
                                <i class="fas fa-user fa-4x" style="color: var(--primary-green);"></i>
                            </div>
                        </div>
                        <h3 class="mb-3">Usuário Comum</h3>
                        <p class="text-muted flex-grow-1">
                            Acesse como cidadão para apoiar ONGs, comentar e interagir com as causas.
                        </p>
                        <div class="d-grid gap-2 mt-4">
                            <a href="<?php echo e(route('regular.login')); ?>" class="btn btn-outline-success">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                            <a href="<?php echo e(route('regular.register')); ?>" class="btn btn-success">
                                <i class="fas fa-user-plus me-2"></i>Cadastrar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6">
                <div class="card h-100 hover-card text-center p-4">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-4">
                            <div class="rounded-circle bg-light d-inline-flex p-4">
                                <i class="fas fa-building fa-4x" style="color: var(--primary-blue);"></i>
                            </div>
                        </div>
                        <h3 class="mb-3">ONG / Organização</h3>
                        <p class="text-muted flex-grow-1">
                            Cadastre sua ONG para criar posts, divulgar eventos e captar recursos.
                        </p>
                        <div class="d-grid gap-2 mt-4">
                            <a href="<?php echo e(route('ong.login')); ?>" class="btn btn-outline-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                            <a href="<?php echo e(route('ong.register')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Cadastrar ONG
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\47808487848\Herd\redesocialweb\resources\views/auth/choose-role.blade.php ENDPATH**/ ?>