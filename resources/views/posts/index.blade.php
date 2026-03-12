@extends('layouts.app')

@section('title', 'Feed de Posts')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-stream me-2"></i>Feed de Atividades</h4>
            </div>
            <div class="card-body">
                @forelse($posts as $post)
                    <div class="card mb-3 post-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                @if($post->user->logo)
                                    <img src="{{ asset('storage/' . $post->user->logo) }}" 
                                         class="rounded-circle me-3" 
                                         style="width: 50px; height: 50px; object-fit: cover;"
                                         alt="{{ $post->user->ong_name }}">
                                @else
                                    <div class="bg-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-building text-white"></i>
                                    </div>
                                @endif
                                <div>
                                    <h5 class="mb-0">{{ $post->user->ong_name }}</h5>
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $post->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>

                            <h4 class="card-title">{{ $post->title }}</h4>
                            
                            @if($post->category)
                                <span class="badge bg-info mb-2">
                                    <i class="fas fa-tag me-1"></i>{{ $post->category }}
                                </span>
                            @endif

                            <p class="card-text">{{ Str::limit($post->content, 200) }}</p>

                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" 
                                     class="img-fluid rounded mb-3" 
                                     style="max-height: 300px; width: auto;"
                                     alt="{{ $post->title }}">
                            @endif

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-success">
                                    <i class="fas fa-eye me-1"></i>Ler mais
                                </a>
                                
                                <div>
                                    <span class="me-3">
                                        <i class="far fa-heart text-danger"></i> 0
                                    </span>
                                    <span>
                                        <i class="far fa-comment text-primary"></i> 0
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Nenhum post encontrado</h4>
                        @auth
                            <a href="{{ route('posts.create') }}" class="btn btn-success mt-3">
                                <i class="fas fa-plus-circle me-2"></i>Criar primeiro post
                            </a>
                        @endauth
                    </div>
                @endforelse

                <div class="d-flex justify-content-center mt-4">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.post-card {
    transition: transform 0.2s;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.post-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}
</style>
@endpush