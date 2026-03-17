@extends('layouts.app')

@section('title', 'Feed de Posts')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 text-success">
                <i class="fas fa-stream me-2"></i>Feed de Atividades
            </h1>
            @auth('ong')
                <a href="{{ route('posts.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle me-2"></i>Novo Post
                </a>
            @endauth
        </div>

        {{-- Barra de busca --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('posts.index') }}" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="search" 
                               placeholder="Buscar posts..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-select">
                            <option value="">Todas as categorias</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-search me-2"></i>Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Grid de posts --}}
        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm hover-card">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" 
                                 class="card-img-top" 
                                 style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            {{-- Info da ONG --}}
                            <div class="d-flex align-items-center mb-3">
                                @if($post->ong->logo)
                                    <img src="{{ asset('storage/' . $post->ong->logo) }}" 
                                         class="rounded-circle me-2" 
                                         style="width: 30px; height: 30px; object-fit: cover;">
                                @else
                                    <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center" 
                                         style="width: 30px; height: 30px;">
                                        <i class="fas fa-building text-white fa-sm"></i>
                                    </div>
                                @endif
                                <div>
                                    <small class="text-muted">{{ $post->ong->ong_name }}</small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>{{ $post->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>

                            <h5 class="card-title">
                                <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($post->title, 60) }}
                                </a>
                            </h5>

                            @if($post->category)
                                <span class="badge bg-success bg-opacity-10 text-success mb-2">
                                    <i class="fas fa-tag me-1"></i>{{ $post->category }}
                                </span>
                            @endif

                            <p class="card-text text-muted">
                                {{ Str::limit(strip_tags($post->content), 100) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-eye me-1"></i>Ver mais
                                </a>
                                
                                @auth('regular')
                                    <button class="btn btn-sm btn-outline-danger" onclick="likePost({{ $post->id }})">
                                        <i class="far fa-heart"></i> Apoiar
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Nenhum post encontrado</h4>
                    @auth('ong')
                        <a href="{{ route('posts.create') }}" class="btn btn-success mt-3">
                            <i class="fas fa-plus-circle me-2"></i>Seja o primeiro a postar
                        </a>
                    @endauth
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection