@extends('layouts.app')

@section('title', 'Feed de Notícias')

@section('content')
<div class="row">
    <div class="col-12">
        {{-- Header com saudação --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 text-success">
                    <i class="fas fa-stream me-2"></i>Feed de Notícias
                </h1>
                <p class="text-muted">Acompanhe as últimas atualizações das ONGs</p>
            </div>
            @auth
                <a href="{{ route('posts.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle me-2"></i>Novo Post
                </a>
            @endauth
        </div>

        {{-- Barra de busca e filtros --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('home') }}" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-success text-white">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" 
                                   class="form-control" 
                                   name="search" 
                                   placeholder="Buscar por título ou conteúdo..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-select">
                            <option value="">Todas as categorias</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-filter me-2"></i>Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Grid de posts --}}
        @if($posts->count() > 0)
            <div class="row g-4">
                @foreach($posts as $post)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-card border-0">
                            {{-- Imagem do post --}}
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $post->title }}"
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="fas fa-image fa-4x text-secondary"></i>
                                </div>
                            @endif

                            <div class="card-body">
                                {{-- Informações da ONG --}}
                                <div class="d-flex align-items-center mb-3">
                                    @if($post->user->logo)
                                        <img src="{{ asset('storage/' . $post->user->logo) }}" 
                                             class="rounded-circle me-2" 
                                             style="width: 30px; height: 30px; object-fit: cover;"
                                             alt="{{ $post->user->ong_name }}">
                                    @else
                                        <div class="bg-success rounded-circle me-2 d-flex align-items-center justify-content-center" 
                                             style="width: 30px; height: 30px;">
                                            <i class="fas fa-building text-white fa-sm"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <small class="text-muted">{{ $post->user->ong_name }}</small>
                                        <br>
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i>
                                            {{ $post->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>

                                {{-- Título e categoria --}}
                                <h5 class="card-title mb-2">
                                    <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($post->title, 60) }}
                                    </a>
                                </h5>
                                
                                @if($post->category)
                                    <span class="badge bg-success bg-opacity-10 text-success mb-2">
                                        <i class="fas fa-tag me-1"></i>{{ $post->category }}
                                    </span>
                                @endif

                                {{-- Resumo do conteúdo --}}
                                <p class="card-text text-muted">
                                    {{ Str::limit(strip_tags($post->content), 100) }}
                                </p>

                                {{-- Rodapé do card com estatísticas --}}
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-eye me-1"></i>Ler mais
                                    </a>
                                    <div>
                                        <small class="text-muted me-2">
                                            <i class="far fa-heart text-danger"></i> 0
                                        </small>
                                        <small class="text-muted">
                                            <i class="far fa-comment text-primary"></i> 0
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginação --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $posts->withQueryString()->links() }}
            </div>
        @else
            {{-- Mensagem quando não há posts --}}
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-newspaper fa-5x text-muted"></i>
                </div>
                <h3 class="text-muted mb-3">Nenhum post encontrado</h3>
                <p class="text-muted mb-4">
                    @if(request('search') || request('category'))
                        Tente outros termos de busca ou limpe os filtros.
                    @else
                        Seja o primeiro a compartilhar uma notícia!
                    @endif
                </p>
                <div>
                    <a href="{{ route('home') }}" class="btn btn-outline-success me-2">
                        <i class="fas fa-times me-2"></i>Limpar filtros
                    </a>
                    @auth
                        <a href="{{ route('posts.create') }}" class="btn btn-success">
                            <i class="fas fa-plus-circle me-2"></i>Criar post
                        </a>
                    @endauth
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Modal de boas-vindas para novos usuários --}}
@auth
    @if(auth()->user()->posts->count() == 0)
        <div class="modal fade" id="welcomeModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-hand-peace me-2"></i>Bem-vindo à Rede Social de ONGs!
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <i class="fas fa-hand-holding-heart fa-4x text-success mb-3"></i>
                        <h5>Que bom ter você aqui! 🎉</h5>
                        <p class="text-muted">
                            Comece compartilhando sua primeira postagem e conecte-se com outras ONGs.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('posts.create') }}" class="btn btn-success">
                            <i class="fas fa-plus-circle me-2"></i>Criar primeiro post
                        </a>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Agora não
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endauth
@endsection

@push('styles')
<style>
.hover-card {
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.card-img-top {
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}

.pagination {
    gap: 5px;
}

.page-link {
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    color: var(--bs-success);
}

.page-item.active .page-link {
    background-color: var(--bs-success);
    color: white;
}

.page-link:hover {
    background-color: rgba(40, 167, 69, 0.1);
    color: var(--bs-success);
}
</style>
@endpush

@push('scripts')
<script>
// Mostrar modal de boas-vindas para novos usuários
document.addEventListener('DOMContentLoaded', function() {
    @auth
        @if(auth()->user()->posts->count() == 0)
            var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
            setTimeout(() => {
                welcomeModal.show();
            }, 1000);
        @endif
    @endauth
});

// Animação de scroll para novos posts
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = 1;
            entry.target.style.transform = 'translateY(0)';
        }
    });
});

document.querySelectorAll('.col-md-6.col-lg-4').forEach((el) => {
    el.style.opacity = 0;
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.5s, transform 0.5s';
    observer.observe(el);
});
</script>
@endpush