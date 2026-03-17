    @extends('layouts.app')

@section('title', $ong->ong_name)

@section('content')
<div class="row">
    <div class="col-12">
        {{-- Header da ONG --}}
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-body p-0">
                {{-- Capa (opcional) --}}
                <div class="ong-cover bg-success" style="height: 200px; background: linear-gradient(135deg, #28a745, #20c997);">
                    {{-- Espaço para capa personalizada futuramente --}}
                </div>
                
                {{-- Informações da ONG --}}
                <div class="px-4 pb-4" style="margin-top: -75px;">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex align-items-end">
                                {{-- Logo --}}
                                <div class="me-4">
                                    @if($ong->logo)
                                        <img src="{{ asset('storage/' . $ong->logo) }}" 
                                             alt="{{ $ong->ong_name }}"
                                             class="rounded-circle border border-4 border-white shadow"
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary rounded-circle border border-4 border-white shadow 
                                                    d-flex align-items-center justify-content-center"
                                             style="width: 150px; height: 150px;">
                                            <i class="fas fa-building text-white fa-4x"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- Nome e badges --}}
                                <div class="mb-3">
                                    <h1 class="h2 mb-2">{{ $ong->ong_name }}</h1>
                                    <div class="mb-2">
                                        <span class="badge bg-success me-2">
                                            <i class="fas fa-check-circle me-1"></i>ONG Verificada
                                        </span>
                                        <span class="badge bg-info">
                                            <i class="fas fa-calendar me-1"></i>
                                            Membro desde {{ $ong->created_at->format('Y') }}
                                        </span>
                                    </div>
                                    
                                    {{-- Estatísticas rápidas --}}
                                    <div class="d-flex">
                                        <div class="me-4 text-center">
                                            <h5 class="mb-0">{{ $stats['total_posts'] }}</h5>
                                            <small class="text-muted">Posts</small>
                                        </div>
                                        <div class="me-4 text-center">
                                            <h5 class="mb-0">{{ $stats['total_followers'] }}</h5>
                                            <small class="text-muted">Apoiadores</small>
                                        </div>
                                        <div class="text-center">
                                            <h5 class="mb-0">{{ $stats['total_projects'] }}</h5>
                                            <small class="text-muted">Projetos</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Botões de ação --}}
                        <div class="col-md-4 d-flex align-items-end justify-content-end">
                            @auth('regular')
                                @if($userSupported)
                                    <form action="{{ route('regular.ongs.unsupport', $ong) }}" method="POST" class="me-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-heart-broken me-2"></i>Deixar de Apoiar
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('regular.ongs.support', $ong) }}" method="POST" class="me-2">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-heart me-2"></i>Apoiar esta ONG
                                        </button>
                                    </form>
                                @endif
                            @endauth
                            
                            <button class="btn btn-outline-primary" onclick="shareOng()">
                                <i class="fas fa-share-alt me-2"></i>Compartilhar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Conteúdo principal --}}
        <div class="row">
            {{-- Coluna da esquerda - Informações --}}
            <div class="col-md-4">
                {{-- Sobre a ONG --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-success"></i>Sobre</h5>
                    </div>
                    <div class="card-body">
                        @if($ong->description)
                            <p class="card-text">{{ $ong->description }}</p>
                        @else
                            <p class="text-muted fst-italic">Nenhuma descrição fornecida.</p>
                        @endif
                        
                        <hr>
                        
                        {{-- Contato --}}
                        <h6 class="mb-3"><i class="fas fa-address-card me-2 text-success"></i>Contato</h6>
                        
                        @if($ong->email)
                            <p class="mb-2">
                                <i class="fas fa-envelope me-2 text-muted"></i>
                                <a href="mailto:{{ $ong->email }}">{{ $ong->email }}</a>
                            </p>
                        @endif
                        
                        @if($ong->phone)
                            <p class="mb-2">
                                <i class="fas fa-phone me-2 text-muted"></i>
                                <a href="tel:{{ $ong->phone }}">{{ $ong->phone }}</a>
                            </p>
                        @endif
                        
                        @if($ong->address)
                            <p class="mb-2">
                                <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                {{ $ong->address }}
                            </p>
                        @endif
                        
                        @if($ong->website)
                            <p class="mb-2">
                                <i class="fas fa-globe me-2 text-muted"></i>
                                <a href="{{ $ong->website }}" target="_blank">{{ $ong->website }}</a>
                            </p>
                        @endif
                        
                        {{-- Redes sociais --}}
                        @if($ong->social_media && count($ong->social_media) > 0)
                            <hr>
                            <h6 class="mb-3"><i class="fas fa-share-alt me-2 text-success"></i>Redes Sociais</h6>
                            <div class="d-flex gap-2">
                                @if(isset($ong->social_media['facebook']))
                                    <a href="{{ $ong->social_media['facebook'] }}" target="_blank" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                @endif
                                @if(isset($ong->social_media['instagram']))
                                    <a href="{{ $ong->social_media['instagram'] }}" target="_blank" 
                                       class="btn btn-outline-danger btn-sm">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                                @if(isset($ong->social_media['twitter']))
                                    <a href="{{ $ong->social_media['twitter'] }}" target="_blank" 
                                       class="btn btn-outline-info btn-sm">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                
                {{-- Informações adicionais --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-chart-pie me-2 text-success"></i>Informações</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">CNPJ:</span>
                            <span class="fw-bold">{{ $ong->cnpj ?? 'Não informado' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Fundação:</span>
                            <span class="fw-bold">{{ $ong->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Categorias:</span>
                            <span class="fw-bold">
                                @if(isset($ong->categories) && count($ong->categories) > 0)
                                    {{ implode(', ', $ong->categories) }}
                                @else
                                    Não informado
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                
                {{-- Apoiadores recentes --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-users me-2 text-success"></i>Apoiadores Recentes</h5>
                    </div>
                    <div class="card-body">
                        @if(isset($recentSupporters) && count($recentSupporters) > 0)
                            @foreach($recentSupporters as $supporter)
                                <div class="d-flex align-items-center mb-2">
                                    @if($supporter->avatar)
                                        <img src="{{ asset('storage/' . $supporter->avatar) }}" 
                                             class="rounded-circle me-2" 
                                             style="width: 30px; height: 30px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center"
                                             style="width: 30px; height: 30px;">
                                            <i class="fas fa-user text-white fa-xs"></i>
                                        </div>
                                    @endif
                                    <span>{{ $supporter->name }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted text-center py-3">Seja o primeiro apoiador!</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Coluna da direita - Posts da ONG --}}
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-newspaper me-2 text-success"></i>Posts Recentes</h5>
                        <div>
                            <select class="form-select form-select-sm" id="postFilter" style="width: auto;">
                                <option value="all">Todos</option>
                                <option value="Educação">Educação</option>
                                <option value="Saúde">Saúde</option>
                                <option value="Meio Ambiente">Meio Ambiente</option>
                                <option value="Direitos Humanos">Direitos Humanos</option>
                                <option value="Animais">Animais</option>
                                <option value="Cultura">Cultura</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($posts->count() > 0)
                            @foreach($posts as $post)
                                <div class="card mb-3 border-0 shadow-sm post-card" data-category="{{ $post->category }}">
                                    @if($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" 
                                             class="card-img-top" 
                                             style="max-height: 300px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-dark">
                                                {{ $post->title }}
                                            </a>
                                        </h5>
                                        
                                        @if($post->category)
                                            <span class="badge bg-success bg-opacity-10 text-success mb-2">
                                                <i class="fas fa-tag me-1"></i>{{ $post->category }}
                                            </span>
                                        @endif
                                        
                                        <p class="card-text">{{ Str::limit(strip_tags($post->content), 200) }}</p>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="text-muted me-3">
                                                    <i class="far fa-calendar me-1"></i>
                                                    {{ $post->created_at->format('d/m/Y') }}
                                                </small>
                                                <small class="text-muted me-3">
                                                    <i class="far fa-comment me-1"></i>
                                                    {{ $post->comments_count ?? 0 }}
                                                </small>
                                                <small class="text-muted">
                                                    <i class="far fa-heart me-1"></i>
                                                    {{ $post->likes_count ?? 0 }}
                                                </small>
                                            </div>
                                            
                                            <a href="{{ route('posts.show', $post) }}" 
                                               class="btn btn-sm btn-outline-success">
                                                Ler mais
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            {{-- Paginação --}}
                            <div class="d-flex justify-content-center mt-4">
                                {{ $posts->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Nenhum post publicado ainda</h5>
                                <p class="text-muted">Esta ONG ainda não possui posts.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.ong-cover {
    border-radius: 0.5rem 0.5rem 0 0;
}

.post-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.post-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
}

.border-4 {
    border-width: 4px !important;
}
</style>
@endpush

@push('scripts')
<script>
function shareOng() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $ong->ong_name }}',
            text: '{{ Str::limit($ong->description, 100) }}',
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

// Atualizar contador de apoiadores em tempo real (se usar pusher/websockets)
// ...
</script>
@endpush
@endsection