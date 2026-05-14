@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            {{-- HEADER COM TÍTULO E BOTÕES --}}
            <div class="card-header bg-white border-0 pt-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h1 class="h3 fw-bold mb-1">{{ $post->title }}</h1>
                        <div class="d-flex align-items-center gap-3">
                            <span class="small text-muted">
                                <i class="far fa-calendar me-1"></i>
                                {{ $post->created_at->format('d/m/Y H:i') }}
                            </span>
                            @if($post->category)
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-tag me-1"></i>{{ $post->category }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        {{-- BOTÕES DE EDIÇÃO (apenas para ONG autora) --}}
                        @auth('ong')
                            @if(Auth::guard('ong')->id() === $post->ong_id)
                                <a href="{{ route('posts.edit', $post) }}" 
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Excluir este post?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>

            {{-- CORPO DO POST --}}
            <div class="card-body">
                {{-- INFO DA ONG COM BOTÃO DE APOIAR --}}
                <div class="d-flex align-items-center justify-content-between mb-4 p-3 bg-light rounded">
                    <div class="d-flex align-items-center">
                        @if($post->ong->logo)
                            <img src="{{ asset('storage/' . $post->ong->logo) }}" 
                                 class="rounded-circle me-3" 
                                 style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-3"
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-building text-muted"></i>
                            </div>
                        @endif
                        <div>
                            <h5 class="mb-1 fw-semibold">{{ $post->ong->ong_name }}</h5>
                            <p class="mb-0 small text-muted">
                                <i class="fas fa-envelope me-1"></i>{{ $post->ong->email }}
                            </p>
                        </div>
                    </div>

                    {{-- BOTÃO DE APOIAR ONG (apenas para usuários comuns) --}}
                    @auth('regular')
                        @if($userSupportsOng)
                            <form action="{{ route('regular.ongs.unsupport', $post->ong) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-heart-broken me-2"></i>Deixar de apoiar
                                </button>
                            </form>
                        @else
                            <form action="{{ route('regular.ongs.support', $post->ong) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-heart me-2"></i>Apoiar ONG
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>

                {{-- IMAGEM DO POST --}}
                @if($post->image)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             class="img-fluid rounded" 
                             style="max-height: 400px;">
                    </div>
                @endif

                {{-- CONTEÚDO DO POST --}}
                <div class="post-content">
                    {!! nl2br(e($post->content)) !!}
                </div>

                <hr class="my-4">

                {{-- SEÇÃO DE INTERAÇÃO (Curtir/Compartilhar/Voluntariar) --}}
                @auth('regular')
                    <div class="bg-light rounded p-4 mb-4">
                        <h5 class="fw-semibold mb-3">
                            <i class="fas fa-hand-holding-heart me-2" style="color: var(--primary-green);"></i>
                            Interagir com esta causa
                        </h5>
                        <p class="small text-muted mb-3">
                            Escolha como deseja participar:
                        </p>
                        <div class="row g-2">
                            {{-- BOTÃO DE CURTIR (movido para cá) --}}
                            <div class="col-md-4">
                                <button class="btn {{ $userLiked ? 'btn-danger' : 'btn-outline-danger' }} w-100" 
                                        onclick="likePost({{ $post->id }})">
                                    <i class="fas fa-heart me-2"></i>
                                    Curtir (<span class="likes-count">{{ $post->likes_count ?? 0 }}</span>)
                                </button>
                            </div>
                            
                            {{-- BOTÃO DE COMPARTILHAR --}}
                            <div class="col-md-4">
                                <button class="btn btn-outline-primary w-100" onclick="sharePost()">
                                    <i class="fas fa-share me-2"></i>Compartilhar
                                </button>
                            </div>
                            
                            {{-- BOTÃO DE VOLUNTARIADO (desabilitado) --}}
                            <div class="col-md-4">
                                <button class="btn btn-outline-secondary w-100" 
                                        disabled
                                        title="Funcionalidade em desenvolvimento">
                                    <i class="fas fa-calendar me-2"></i>Voluntariar
                                </button>
                            </div>
                        </div>
                    </div>
                @endauth

                {{-- SEÇÃO DE COMENTÁRIOS --}}
                <div class="comments-section">
                    <h5 class="fw-semibold mb-4">
                        <i class="fas fa-comments me-2" style="color: var(--primary-blue);"></i>
                        Comentários
                    </h5>
                    
                    @auth('regular')
                        <form class="mb-4" onsubmit="submitComment(event, {{ $post->id }})">
                            <div class="mb-3">
                                <textarea class="form-control" rows="3" 
                                          placeholder="Deixe seu comentário..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Comentar
                            </button>
                        </form>
                    @endauth

                    @auth('ong')
                        <form class="mb-4" onsubmit="submitComment(event, {{ $post->id }})">
                            <div class="mb-3">
                                <textarea class="form-control" rows="3" 
                                          placeholder="Deixe seu comentário como ONG..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Comentar
                            </button>
                        </form>
                    @endauth

                    <div class="comments-list" id="comments-list">
                        {{-- Comentários serão carregados aqui --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
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
@endpush

@push('scripts')
<script>
function likePost(postId) {
    const button = event.currentTarget;
    const count = button.querySelector('.likes-count');
    fetch(`/posts/${postId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            count.textContent = data.count;
            if (data.liked) {
                button.classList.remove('btn-outline-danger');
                button.classList.add('btn-danger');
            } else {
                button.classList.remove('btn-danger');
                button.classList.add('btn-outline-danger');
            }
        }
    })
    .catch(error => console.error('Erro ao curtir:', error));
}

function sharePost() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $post->title }}',
            text: '{{ Str::limit(strip_tags($post->content), 100) }}',
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Link copiado!');
    }
}

function escapeHtml(unsafe) {
    if (!unsafe) return '';
    return unsafe.replace(/&/g, "&amp;")
                 .replace(/</g, "&lt;")
                 .replace(/>/g, "&gt;")
                 .replace(/"/g, "&quot;")
                 .replace(/'/g, "&#039;");
}

function loadComments(postId) {
    console.log('🔍 Carregando comentários para o post:', postId);
    
    fetch(`/posts/${postId}/comments`)
        .then(response => {
            console.log('📡 Status da resposta:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.text();
        })
        .then(text => {
            console.log('📄 Resposta bruta (primeiros 200 caracteres):', text.substring(0, 200));
            
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                console.error('❌ Erro ao fazer parse do JSON:', e.message);
                document.getElementById('comments-list').innerHTML = `
                    <div class="alert alert-danger">
                        <strong>Erro ao carregar comentários:</strong> Resposta não é um JSON válido.<br>
                        <small>Verifique o console para mais detalhes.</small>
                    </div>
                `;
                return;
            }
            
            const container = document.getElementById('comments-list');
            if (!container) {
                console.error('❌ Elemento comments-list não encontrado');
                return;
            }
            
            if (data.success && data.data && data.data.length > 0) {
                let html = '';
                data.data.forEach(comment => {
                    html += `
                        <div class="comment-item p-3 border-bottom">
                            <div class="d-flex justify-content-between">
                                <strong>${escapeHtml(comment.author_name)}</strong>
                                <small class="text-muted">${escapeHtml(comment.created_at)}</small>
                            </div>
                            <p class="mb-0 mt-2">${escapeHtml(comment.content)}</p>
                        </div>
                    `;
                });
                container.innerHTML = html;
                console.log(`✅ Carregados ${data.data.length} comentários`);
            } else {
                container.innerHTML = '<p class="text-muted text-center py-4">Nenhum comentário ainda.</p>';
                console.log('📭 Nenhum comentário encontrado');
            }
        })
        .catch(error => {
            console.error('❌ Erro ao carregar comentários:', error);
            document.getElementById('comments-list').innerHTML = `
                <div class="alert alert-warning">
                    <strong>Erro ao carregar comentários:</strong> ${error.message}<br>
                    <small>Verifique se o servidor está respondendo corretamente.</small>
                </div>
            `;
        });
}

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
    
    console.log('📤 Enviando comentário para o post:', postId);
    
    fetch(`/comments/${postId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ content: comment })
    })
    .then(response => {
        console.log('📡 Status da resposta ao comentar:', response.status);
        if (!response.ok) {
            return response.text().then(text => {
                console.error('❌ Resposta de erro:', text);
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('✅ Resposta ao comentar:', data);
        if (data.success) {
            textarea.value = '';
            loadComments(postId);
        } else {
            alert(data.message || data.error || 'Erro ao comentar.');
        }
    })
    .catch(error => {
        console.error('❌ Erro ao enviar comentário:', error);
        alert('Erro ao enviar comentário: ' + error.message);
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Comentar';
    });
}

// Carregar comentários quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Página carregada, post ID: {{ $post->id }}');
    loadComments({{ $post->id }});
});
</script>
@endpush
