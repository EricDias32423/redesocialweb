<?php $__env->startSection('title', $ong->ong_name); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        
        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
            
            <div class="ong-cover" style="height: 200px; background: linear-gradient(135deg, #e9ecef, #dee2e6);"></div>
            
            
            <div class="px-4 pb-4" style="margin-top: -75px;">
                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="d-flex align-items-end">
                            
                            <div class="me-4">
                                <?php if($ong->logo): ?>
                                    <img src="<?php echo e(asset('storage/' . $ong->logo)); ?>" 
                                         alt="<?php echo e($ong->ong_name); ?>"
                                         class="rounded-circle border border-4 border-white shadow-sm"
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-light border border-4 border-white shadow-sm 
                                                d-flex align-items-center justify-content-center"
                                         style="width: 150px; height: 150px;">
                                        <i class="fas fa-building fa-4x" style="color: var(--primary-green);"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            
                            <div class="mb-3">
                                <h1 class="h2 fw-bold mb-2"><?php echo e($ong->ong_name); ?></h1>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge bg-light text-dark px-3 py-2">
                                        <i class="fas fa-check-circle me-1" style="color: var(--primary-green);"></i>
                                        ONG Verificada
                                    </span>
                                    <span class="badge bg-light text-dark px-3 py-2">
                                        <i class="fas fa-calendar me-1" style="color: var(--primary-blue);"></i>
                                        Membro desde <?php echo e($ong->created_at->format('Y')); ?>

                                    </span>
                                </div>
                                
                                
                                <div class="d-flex gap-4">
                                    <div class="text-center">
                                        <span class="fw-bold d-block h5 mb-0"><?php echo e($stats['total_posts']); ?></span>
                                        <small class="text-muted">Posts</small>
                                    </div>
                                    <div class="text-center">
                                        <span class="fw-bold d-block h5 mb-0">0</span>
                                        <small class="text-muted">Apoiadores</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <?php if(auth()->guard('regular')->check()): ?>
                            <?php if($userSupported): ?>
                                <form action="<?php echo e(route('regular.ongs.unsupport', $ong)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="fas fa-heart-broken me-2"></i>Deixar de apoiar
                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="<?php echo e(route('regular.ongs.support', $ong)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-heart me-2"></i>Apoiar esta ONG
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <button class="btn btn-outline-primary" onclick="shareOng()">
                            <i class="fas fa-share-alt me-2"></i>Compartilhar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row g-4">
            
            <div class="col-lg-4">
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-info-circle me-2" style="color: var(--primary-green);"></i>
                            Sobre
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <?php if($ong->description): ?>
                            <p class="card-text"><?php echo e($ong->description); ?></p>
                        <?php else: ?>
                            <p class="text-muted fst-italic">Nenhuma descrição fornecida.</p>
                        <?php endif; ?>
                        
                        <hr class="my-4">
                        
                        
                        <h6 class="fw-semibold mb-3">Contato</h6>
                        
                        <?php if($ong->email): ?>
                            <p class="d-flex align-items-center mb-2">
                                <i class="fas fa-envelope text-muted me-2" style="width: 20px;"></i>
                                <a href="mailto:<?php echo e($ong->email); ?>" class="text-decoration-none"><?php echo e($ong->email); ?></a>
                            </p>
                        <?php endif; ?>
                        
                        <?php if($ong->phone): ?>
                            <p class="d-flex align-items-center mb-2">
                                <i class="fas fa-phone text-muted me-2" style="width: 20px;"></i>
                                <a href="tel:<?php echo e($ong->phone); ?>" class="text-decoration-none"><?php echo e($ong->phone); ?></a>
                            </p>
                        <?php endif; ?>
                        
                        <?php if($ong->address): ?>
                            <p class="d-flex align-items-center mb-2">
                                <i class="fas fa-map-marker-alt text-muted me-2" style="width: 20px;"></i>
                                <span><?php echo e($ong->address); ?></span>
                            </p>
                        <?php endif; ?>
                        
                        <?php if($ong->website): ?>
                            <p class="d-flex align-items-center mb-2">
                                <i class="fas fa-globe text-muted me-2" style="width: 20px;"></i>
                                <a href="<?php echo e($ong->website); ?>" target="_blank" class="text-decoration-none"><?php echo e($ong->website); ?></a>
                            </p>
                        <?php endif; ?>
                        
                        
                        <?php if($ong->social_media && count($ong->social_media) > 0): ?>
                            <hr class="my-4">
                            <h6 class="fw-semibold mb-3">Redes Sociais</h6>
                            <div class="d-flex gap-2">
                                <?php if(isset($ong->social_media['facebook'])): ?>
                                    <a href="<?php echo e($ong->social_media['facebook']); ?>" target="_blank" 
                                       class="btn btn-outline-primary btn-sm rounded-circle">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if(isset($ong->social_media['instagram'])): ?>
                                    <a href="<?php echo e($ong->social_media['instagram']); ?>" target="_blank" 
                                       class="btn btn-outline-danger btn-sm rounded-circle">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if(isset($ong->social_media['twitter'])): ?>
                                    <a href="<?php echo e($ong->social_media['twitter']); ?>" target="_blank" 
                                       class="btn btn-outline-info btn-sm rounded-circle">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-chart-pie me-2" style="color: var(--primary-green);"></i>
                            Informações
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">CNPJ:</span>
                            <span class="fw-medium"><?php echo e($ong->cnpj ?? 'Não informado'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Fundação:</span>
                            <span class="fw-medium"><?php echo e($ong->created_at->format('d/m/Y')); ?></span>
                        </div>
                    </div>
                </div>
                
                
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-users me-2" style="color: var(--primary-green);"></i>
                            Apoiadores Recentes
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <?php if(isset($recentSupporters) && $recentSupporters->count() > 0): ?>
                            <div class="list-group list-group-flush">
                                <?php $__currentLoopData = $recentSupporters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supporter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item border-0 px-0 d-flex align-items-center">
                                        <?php if($supporter->avatar): ?>
                                            <img src="<?php echo e(asset('storage/' . $supporter->avatar)); ?>" 
                                                 class="rounded-circle me-2" 
                                                 style="width: 30px; height: 30px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2"
                                                 style="width: 30px; height: 30px;">
                                                <i class="fas fa-user fa-xs text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                        <span class="small"><?php echo e($supporter->name); ?></span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center py-3">Seja o primeiro apoiador!</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 d-flex flex-wrap justify-content-between align-items-center pt-4">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-newspaper me-2" style="color: var(--primary-green);"></i>
                            Posts Recentes
                        </h5>
                        <select class="form-select form-select-sm w-auto" id="postFilter">
                            <option value="all">Todas as categorias</option>
                            <option value="Educação">Educação</option>
                            <option value="Saúde">Saúde</option>
                            <option value="Meio Ambiente">Meio Ambiente</option>
                            <option value="Direitos Humanos">Direitos Humanos</option>
                            <option value="Animais">Animais</option>
                            <option value="Cultura">Cultura</option>
                        </select>
                    </div>
                    <div class="card-body">
                        <?php if($posts->count() > 0): ?>
                            <div class="row g-4">
                                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm post-card" data-category="<?php echo e($post->category); ?>">
                                            <div class="row g-0">
                                                <?php if($post->image): ?>
                                                    <div class="col-md-4">
                                                        <img src="<?php echo e(asset('storage/' . $post->image)); ?>" 
                                                             class="img-fluid rounded-start h-100"
                                                             style="object-fit: cover; max-height: 200px;">
                                                    </div>
                                                <?php endif; ?>
                                                <div class="<?php echo e($post->image ? 'col-md-8' : 'col-12'); ?>">
                                                    <div class="card-body">
                                                        <h5 class="card-title">
                                                            <a href="<?php echo e(route('posts.show', $post)); ?>" class="text-decoration-none text-dark fw-semibold">
                                                                <?php echo e($post->title); ?>

                                                            </a>
                                                        </h5>
                                                        
                                                        <?php if($post->category): ?>
                                                            <span class="badge bg-light text-dark mb-2">
                                                                <i class="fas fa-tag me-1"></i><?php echo e($post->category); ?>

                                                            </span>
                                                        <?php endif; ?>
                                                        
                                                        <p class="card-text text-muted small">
                                                            <?php echo e(Str::limit(strip_tags($post->content), 150)); ?>

                                                        </p>
                                                        
                                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                                            <div class="small text-muted">
                                                                <i class="far fa-calendar me-1"></i>
                                                                <?php echo e($post->created_at->format('d/m/Y')); ?>

                                                                <span class="mx-2">•</span>
                                                                <i class="far fa-comment me-1"></i>
                                                                <?php echo e($post->comments_count ?? 0); ?>

                                                            </div>
                                                            
                                                            <a href="<?php echo e(route('posts.show', $post)); ?>" 
                                                               class="btn btn-sm btn-outline-primary">
                                                                Ler mais
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            
                            <div class="d-flex justify-content-center mt-4">
                                <?php echo e($posts->links()); ?>

                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted fw-normal">Nenhum post publicado ainda</h5>
                                <p class="text-muted">Esta ONG ainda não possui posts.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.ong-cover {
    border-radius: 0.5rem 0.5rem 0 0;
}
.post-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.post-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.05) !important;
}
.border-4 {
    border-width: 4px !important;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function shareOng() {
    if (navigator.share) {
        navigator.share({
            title: '<?php echo e($ong->ong_name); ?>',
            text: '<?php echo e(Str::limit($ong->description ?? "Conheça esta ONG", 100)); ?>',
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Link copiado para a área de transferência!');
    }
}

// Filtro de posts por categoria
document.getElementById('postFilter').addEventListener('change', function() {
    const category = this.value;
    const posts = document.querySelectorAll('.post-card');
    
    posts.forEach(post => {
        if (category === 'all' || post.dataset.category === category) {
            post.style.display = 'block';
        } else {
            post.style.display = 'none';
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\47808487848\Desktop\projeto\redesocialweb\resources\views/regular/ongs/show.blade.php ENDPATH**/ ?>