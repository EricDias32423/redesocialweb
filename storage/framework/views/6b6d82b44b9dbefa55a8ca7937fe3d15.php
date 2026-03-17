<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Rede Social de ONGs - <?php echo $__env->yieldContent('title'); ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <i class="fas fa-hand-holding-heart me-2"></i>Rede Social de ONGs
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    
                    <?php if(auth()->guard('regular')->guest()): ?>
                        <?php if(auth()->guard('ong')->guest()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('choose.role')); ?>">
                                    <i class="fas fa-user-circle me-1"></i>Acessar
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>

                    
                        <?php if(auth()->guard('regular')->check()): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i>
                                    <?php echo e(Auth::guard('regular')->user()->name); ?>

                                    <span class="badge bg-light text-success ms-2">Usuário</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('regular.dashboard')); ?>">
                                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        
                                        <a class="dropdown-item" href="<?php echo e(route('regular.profile.edit')); ?>">
                                            <i class="fas fa-user-cog me-2"></i>Meu Perfil
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('regular.ongs.index')); ?>">
                                            <i class="fas fa-hand-holding-heart me-2"></i>Descobrir ONGs
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="<?php echo e(route('regular.logout')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i>Sair
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                    
                    <?php if(auth()->guard('ong')->check()): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                                <i class="fas fa-home me-1"></i>Início
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('posts.index') ? 'active' : ''); ?>" href="<?php echo e(route('posts.index')); ?>">
                                <i class="fas fa-stream me-1"></i>Feed
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('posts.create') ? 'active' : ''); ?>" 
                            href="<?php echo e(route('posts.create')); ?>">  <!-- ISSO DEVE FUNCIONAR AGORA -->
                                <i class="fas fa-plus-circle me-1"></i>Novo Post
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('my-posts') ? 'active' : ''); ?>" href="<?php echo e(route('my-posts')); ?>">
                                <i class="fas fa-newspaper me-1"></i>Meus Posts
                            </a>
                        </li>
                        
                        
                       
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="ongDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php if(Auth::guard('ong')->user()->logo): ?>
                                    <img src="<?php echo e(asset('storage/' . Auth::guard('ong')->user()->logo)); ?>" 
                                        class="rounded-circle me-1" 
                                        style="width: 25px; height: 25px; object-fit: cover;"
                                        alt="Logo">
                                <?php else: ?>
                                    <i class="fas fa-building me-1"></i>
                                <?php endif; ?>
                                <?php echo e(Auth::guard('ong')->user()->ong_name); ?>

                                <span class="badge bg-light text-primary ms-2">ONG</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="ongDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('ong.dashboard')); ?>">
                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li>
                                    
                                    <a class="dropdown-item" href="<?php echo e(route('ong.profile.edit')); ?>">
                                        <i class="fas fa-building me-2"></i>Perfil da ONG
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('posts.create')); ?>">
                                        <i class="fas fa-plus-circle me-2"></i>Novo Post
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('my-posts')); ?>">
                                        <i class="fas fa-newspaper me-2"></i>Meus Posts
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('ong.statistics')); ?>">
                                        <i class="fas fa-chart-bar me-2"></i>Estatísticas
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="<?php echo e(route('ong.logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            
            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Por favor, corrija os seguintes erros:</strong>
                    <ul class="mb-0 mt-2">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © <?php echo e(date('Y')); ?> Rede Social de ONGs - Todos os direitos reservados
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    
    <script>
        $(document).ready(function() {
            // Active class para links normais
            var currentUrl = window.location.pathname;
            $('.navbar-nav .nav-link').each(function() {
                if ($(this).attr('href') === currentUrl) {
                    $(this).addClass('active');
                }
            });

            // Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\ericl\Downloads\rede\rede\rede-social-ongs\resources\views/layouts/app.blade.php ENDPATH**/ ?>