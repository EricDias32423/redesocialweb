<?php $__env->startSection('title', 'Escolha como acessar'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="text-center mb-5">
            <h1 class="display-4 text-success">Bem-vindo!</h1>
            <p class="lead">Escolha como deseja acessar a plataforma</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 shadow-lg border-0 hover-card">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="fas fa-user fa-5x text-success"></i>
                        </div>
                        <h3 class="mb-3">Usuário Comum</h3>
                        <p class="text-muted mb-4">
                            Acesse como cidadão para apoiar ONGs, comentar e interagir com as causas.
                        </p>
                        <div class="d-grid gap-2">
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
                <div class="card h-100 shadow-lg border-0 hover-card">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="fas fa-building fa-5x text-primary"></i>
                        </div>
                        <h3 class="mb-3">ONG / Organização</h3>
                        <p class="text-muted mb-4">
                            Cadastre sua ONG para criar posts, divulgar eventos e captar recursos.
                        </p>
                        <div class="d-grid gap-2">
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

<?php $__env->startPush('styles'); ?>
<style>
.hover-card {
    transition: transform 0.3s, box-shadow 0.3s;
}

.hover-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 30px rgba(0,0,0,0.1) !important;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\47808487848\Downloads\sa\redesocialweb\resources\views/auth/choose-role.blade.php ENDPATH**/ ?>