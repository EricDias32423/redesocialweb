<?php $__env->startSection('title', $post->title); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            
            <div class="card-header bg-white border-0 pt-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h1 class="h3 fw-bold mb-1"><?php echo e($post->title); ?></h1>
                        <div class="d-flex align-items-center gap-3">
                            <span class="small text-muted">
                                <i class="far fa-calendar me-1"></i>
                                <?php echo e($post->created_at->format('d/m/Y H:i')); ?>

                            </span>
                            <?php if($post->category): ?>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-tag me-1"></i><?php echo e($post->category); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        
                        <?php if(auth()->guard('ong')->check()): ?>
                            <?php if(Auth::guard('ong')->id() === $post->ong_id): ?>
                                <a href="<?php echo e(route('posts.edit', $post)); ?>" 
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('posts.destroy', $post)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Excluir este post?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="card-body">
                
                <div class="d-flex align-items-center justify-content-between mb-4 p-3 bg-light rounded">
                    <div class="d-flex align-items-center">
                        <?php if($post->ong->logo): ?>
                            <img src="<?php echo e(asset('storage/' . $post->ong->logo)); ?>" 
                                 class="rounded-circle me-3" 
                                 style="width: 50px; height: 50px; object-fit: cover;">
                        <?php else: ?>
                            <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-3"
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-building text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div>
                            <h5 class="mb-1 fw-semibold"><?php echo e($post->ong->ong_name); ?></h5>
                            <p class="mb-0 small text-muted">
                                <i class="fas fa-envelope me-1"></i><?php echo e($post->ong->email); ?>

                            </p>
                        </div>
                    </div>

                    
                    <?php if(auth()->guard('regular')->check()): ?>
                        <?php if($userSupportsOng): ?>
                            <form action="<?php echo e(route('regular.ongs.unsupport', $post->ong)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-heart-broken me-2"></i>Deixar de apoiar
                                </button>
                            </form>
                        <?php else: ?>
                            <form action="<?php echo e(route('regular.ongs.support', $post->ong)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-heart me-2"></i>Apoiar ONG
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                
                <?php if($post->image): ?>
                    <div class="text-center mb-4">
                        <img src="<?php echo e(asset('storage/' . $post->image)); ?>" 
                             class="img-fluid rounded" 
                             style="max-height: 400px;">
                    </div>
                <?php endif; ?>

                
                <div class="post-content">
                    <?php echo nl2br(e($post->content)); ?>

                </div>

                <hr class="my-4">

                
                <?php if(auth()->guard('regular')->check()): ?>
                    <div class="bg-light rounded p-4 mb-4">
                        <h5 class="fw-semibold mb-3">
                            <i class="fas fa-hand-holding-heart me-2" style="color: var(--primary-green);"></i>
                            Interagir com esta causa
                        </h5>
                        <p class="small text-muted mb-3">
                            Escolha como deseja participar:
                        </p>
                        <div class="row g-2">
                            
                            <div class="col-md-4">
                                <button class="btn btn-outline-danger w-100" 
                                        onclick="likePost(<?php echo e($post->id); ?>)">
                                    <i class="fas fa-heart me-2"></i>
                                    Curtir (<?php echo e($post->likes_count ?? 0); ?>)
                                </button>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <button class="btn btn-outline-primary w-100" onclick="sharePost()">
                                    <i class="fas fa-share me-2"></i>Compartilhar
                                </button>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <button class="btn btn-outline-secondary w-100" 
                                        disabled
                                        title="Funcionalidade em desenvolvimento">
                                    <i class="fas fa-calendar me-2"></i>Voluntariar
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                
                <div class="comments-section">
                    <h5 class="fw-semibold mb-4">
                        <i class="fas fa-comments me-2" style="color: var(--primary-blue);"></i>
                        Comentários
                    </h5>
                    
                    <?php if(auth()->guard('regular')->check()): ?>
                        <form class="mb-4" onsubmit="submitComment(event, <?php echo e($post->id); ?>)">
                            <div class="mb-3">
                                <textarea class="form-control" rows="3" 
                                          placeholder="Deixe seu comentário..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Comentar
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if(auth()->guard('ong')->check()): ?>
                        <form class="mb-4" onsubmit="submitComment(event, <?php echo e($post->id); ?>)">
                            <div class="mb-3">
                                <textarea class="form-control" rows="3" 
                                          placeholder="Deixe seu comentário como ONG..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Comentar
                            </button>
                        </form>
                    <?php endif; ?>

                    <div class="comments-list" id="comments-list">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.post-content {
    font-size: 1.1rem;
    line-height: 1.7;
    color: var(--text-dark);
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Curtir post

function likePost(postId) {
    const button = event.currentTarget;
    
    fetch(`/posts/${postId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            // Tenta extrair a mensagem de erro do corpo da resposta
            return response.json().then(errData => {
                throw new Error(errData.message || 'Erro na requisição');
            }).catch(() => {
                // Se não conseguir parsear o JSON, usa o status
                throw new Error(`Erro ${response.status}: ${response.statusText}`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Atualiza o contador
            const currentText = button.innerHTML;
            const newText = currentText.replace(/\d+/, data.count);
            button.innerHTML = newText;
            
            // Atualiza a cor
            if (data.liked) {
                button.classList.remove('btn-outline-danger');
                button.classList.add('btn-danger');
            } else {
                button.classList.remove('btn-danger');
                button.classList.add('btn-outline-danger');
            }
        }
    })
    .catch(error => {
        console.error('Erro detalhado:', error);
        alert('Erro ao curtir: ' + error.message);
    });
}

// Compartilhar post
function sharePost() {
    if (navigator.share) {
        navigator.share({
            title: '<?php echo e($post->title); ?>',
            text: '<?php echo e(Str::limit(strip_tags($post->content), 100)); ?>',
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Link copiado!');
    }
}

// Enviar comentário
function submitComment(event, postId) {
    event.preventDefault();
    const form = event.target;
    const textarea = form.querySelector('textarea');
    const comment = textarea.value.trim();
    
    if (!comment) {
        alert('Escreva um comentário.');
        return;
    }
    
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
    
    // URL CORRETA: /comments/1 (rota comments.store)
    fetch(`/comments/${postId}`, {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
        'Content-Type': 'application/json',
        'Accept': 'application/json'  // 👈 IMPORTANTE
    },
    body: JSON.stringify({ content: comment })
})
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro na requisição');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            textarea.value = '';
            // Recarrega a página para mostrar o novo comentário
            // (simples por enquanto, depois podemos fazer AJAX)
            location.reload();
        } else {
            alert(data.message || 'Erro ao comentar.');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao enviar comentário.');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Comentar';
    });
}

function loadComments(postId) {
    fetch(`/posts/${postId}/comments`)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('comments-list');
            
            if (data.success && data.comments.length > 0) {
                let html = '';
                data.comments.forEach(comment => {
                    html += `
                        <div class="comment-item p-3 border-bottom">
                            <div class="d-flex justify-content-between">
                                <strong>${comment.author_name}</strong>
                                <small class="text-muted">${comment.created_at}</small>
                            </div>
                            <p class="mb-0 mt-2">${comment.content}</p>
                        </div>
                    `;
                });
                container.innerHTML = html;
            } else {
                container.innerHTML = '<p class="text-muted text-center py-4">Nenhum comentário ainda.</p>';
            }
        });
}

// Chamar ao enviar comentário (dentro do .then)
if (data.success) {
    textarea.value = '';
    loadComments(postId); // em vez de location.reload()
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ericl\Downloads\projetas\redesocialweb\resources\views/posts/show.blade.php ENDPATH**/ ?>