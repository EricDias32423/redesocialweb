@extends('layouts.app')

@section('title', $ong->ong_name)

@section('content')
<div class="row">
    <div class="col-12">
        {{-- Header da ONG --}}
        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
            {{-- Capa --}}
            <div class="ong-cover" style="height: 200px; background: linear-gradient(135deg, #e9ecef, #dee2e6);"></div>
            
            {{-- Informações da ONG --}}
            <div class="px-4 pb-4" style="margin-top: -75px;">
                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="d-flex align-items-end">
                            {{-- Logo --}}
                            <div class="me-4">
                                @if($ong->logo)
                                    <img src="{{ asset('storage/' . $ong->logo) }}" 
                                         alt="{{ $ong->ong_name }}"
                                         class="rounded-circle border border-4 border-white shadow-sm"
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-light border border-4 border-white shadow-sm 
                                                d-flex align-items-center justify-content-center"
                                         style="width: 150px; height: 150px;">
                                        <i class="fas fa-building fa-4x" style="color: var(--primary-green);"></i>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Nome e badges --}}
                            <div class="mb-3">
                                <h1 class="h2 fw-bold mb-2">{{ $ong->ong_name }}</h1>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge bg-light text-dark px-3 py-2">
                                        <i class="fas fa-check-circle me-1" style="color: var(--primary-green);"></i>
                                        ONG Verificada
                                    </span>
                                    <span class="badge bg-light text-dark px-3 py-2">
                                        <i class="fas fa-calendar me-1" style="color: var(--primary-blue);"></i>
                                        Membro desde {{ $ong->created_at->format('Y') }}
                                    </span>
                                </div>
                                
                                {{-- Estatísticas rápidas --}}
                                <div class="d-flex gap-4">
                                    <div class="text-center">
                                        <span class="fw-bold d-block h5 mb-0">{{ $stats['total_posts'] }}</span>
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
                    
                    {{-- Botões de ação --}}
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        @auth('regular')
                            @if($userSupported)
                                <form action="{{ route('regular.ongs.unsupport', $ong) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="fas fa-heart-broken me-2"></i>Deixar de apoiar
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('regular.ongs.support', $ong) }}" method="POST" class="d-inline">
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

        {{-- Conteúdo principal --}}
        <div class="row g-4">
            {{-- Coluna da esquerda - Informações --}}
            <div class="col-lg-4">
                {{-- Sobre a ONG --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-info-circle me-2" style="color: var(--primary-green);"></i>
                            Sobre
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        @if($ong->description)
                            <p class="card-text">{{ $ong->description }}</p>
                        @else
                            <p class="text-muted fst-italic">Nenhuma descrição fornecida.</p>
                        @endif
                        
                        <hr class="my-4">
                        
                        {{-- Contato --}}
                        <h6 class="fw-semibold mb-3">Contato</h6>
                        
                        @if($ong->email)
                            <p class="d-flex align-items-center mb-2">
                                <i class="fas fa-envelope text-muted me-2" style="width: 20px;"></i>
                                <a href="mailto:{{ $ong->email }}" class="text-decoration-none">{{ $ong->email }}</a>
                            </p>
                        @endif
                        
                        @if($ong->phone)
                            <p class="d-flex align-items-center mb-2">
                                <i class="fas fa-phone text-muted me-2" style="width: 20px;"></i>
                                <a href="tel:{{ $ong->phone }}" class="text-decoration-none">{{ $ong->phone }}</a>
                            </p>
                        @endif
                        
                        @if($ong->address)
                            <p class="d-flex align-items-center mb-2">
                                <i class="fas fa-map-marker-alt text-muted me-2" style="width: 20px;"></i>
                                <span>{{ $ong->address }}</span>
                            </p>
                        @endif
                        
                        @if($ong->website)
                            <p class="d-flex align-items-center mb-2">
                                <i class="fas fa-globe text-muted me-2" style="width: 20px;"></i>
                                <a href="{{ $ong->website }}" target="_blank" class="text-decoration-none">{{ $ong->website }}</a>
                            </p>
                        @endif
                        
                        {{-- Redes sociais --}}
                        @if($ong->social_media && count($ong->social_media) > 0)
                            <hr class="my-4">
                            <h6 class="fw-semibold mb-3">Redes Sociais</h6>
                            <div class="d-flex gap-2">
                                @if(isset($ong->social_media['facebook']))
                                    <a href="{{ $ong->social_media['facebook'] }}" target="_blank" 
                                       class="btn btn-outline-primary btn-sm rounded-circle">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                @endif
                                @if(isset($ong->social_media['instagram']))
                                    <a href="{{ $ong->social_media['instagram'] }}" target="_blank" 
                                       class="btn btn-outline-danger btn-sm rounded-circle">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                                @if(isset($ong->social_media['twitter']))
                                    <a href="{{ $ong->social_media['twitter'] }}" target="_blank" 
                                       class="btn btn-outline-info btn-sm rounded-circle">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                
                {{-- Informações adicionais --}}
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
                            <span class="fw-medium">{{ $ong->cnpj ?? 'Não informado' }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Fundação:</span>
                            <span class="fw-medium">{{ $ong->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
                
                {{-- Apoiadores recentes --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-users me-2" style="color: var(--primary-green);"></i>
                            Apoiadores Recentes
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        @if(isset($recentSupporters) && $recentSupporters->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($recentSupporters as $supporter)
                                    <div class="list-group-item border-0 px-0 d-flex align-items-center">
                                        @if($supporter->avatar)
                                            <img src="{{ asset('storage/' . $supporter->avatar) }}" 
                                                 class="rounded-circle me-2" 
                                                 style="width: 30px; height: 30px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2"
                                                 style="width: 30px; height: 30px;">
                                                <i class="fas fa-user fa-xs text-muted"></i>
                                            </div>
                                        @endif
                                        <span class="small">{{ $supporter->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center py-3">Seja o primeiro apoiador!</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Coluna da direita - Posts da ONG --}}
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
                        @if($posts->count() > 0)
                            <div class="row g-4">
                                @foreach($posts as $post)
                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm post-card" data-category="{{ $post->category }}">
                                            <div class="row g-0">
                                                @if($post->image)
                                                    <div class="col-md-4">
                                                        <img src="{{ asset('storage/' . $post->image) }}" 
                                                             class="img-fluid rounded-start h-100"
                                                             style="object-fit: cover; max-height: 200px;">
                                                    </div>
                                                @endif
                                                <div class="{{ $post->image ? 'col-md-8' : 'col-12' }}">
                                                    <div class="card-body">
                                                        <h5 class="card-title">
                                                            <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-dark fw-semibold">
                                                                {{ $post->title }}
                                                            </a>
                                                        </h5>
                                                        
                                                        @if($post->category)
                                                            <span class="badge bg-light text-dark mb-2">
                                                                <i class="fas fa-tag me-1"></i>{{ $post->category }}
                                                            </span>
                                                        @endif
                                                        
                                                        <p class="card-text text-muted small">
                                                            {{ Str::limit(strip_tags($post->content), 150) }}
                                                        </p>
                                                        
                                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                                            <div class="small text-muted">
                                                                <i class="far fa-calendar me-1"></i>
                                                                {{ $post->created_at->format('d/m/Y') }}
                                                                <span class="mx-2">•</span>
                                                                <i class="far fa-comment me-1"></i>
                                                                {{ $post->comments_count ?? 0 }}
                                                            </div>
                                                            
                                                            <a href="{{ route('posts.show', $post) }}" 
                                                               class="btn btn-sm btn-outline-primary">
                                                                Ler mais
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="d-flex justify-content-center mt-4">
                                {{ $posts->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted fw-normal">Nenhum post publicado ainda</h5>
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
    box-shadow: 0 8px 16px rgba(0,0,0,0.05) !important;
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
            text: '{{ Str::limit($ong->description ?? "Conheça esta ONG", 100) }}',
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
@endpush
@endsection