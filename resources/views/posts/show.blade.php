@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-newspaper me-2"></i>{{ $post->title }}</h4>
                @can('update', $post)
                    <div>
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-light me-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este post?')">
                                <i class="fas fa-trash"></i> Excluir
                            </button>
                        </form>
                    </div>
                @endcan
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    @if($post->user->logo)
                        <img src="{{ asset('storage/' . $post->user->logo) }}" 
                             class="rounded-circle me-3" 
                             style="width: 60px; height: 60px; object-fit: cover;"
                             alt="{{ $post->user->ong_name }}">
                    @else
                        <div class="bg-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-building text-white fa-2x"></i>
                        </div>
                    @endif
                    <div>
                        <h5 class="mb-1">{{ $post->user->ong_name }}</h5>
                        <p class="mb-0 text-muted">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ $post->created_at->format('d/m/Y H:i') }}
                            @if($post->category)
                                <span class="mx-2">|</span>
                                <span class="badge bg-info">
                                    <i class="fas fa-tag me-1"></i>{{ $post->category }}
                                </span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($post->image)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             class="img-fluid rounded" 
                             style="max-height: 400px;"
                             alt="{{ $post->title }}">
                    </div>
                @endif

                <div class="post-content">
                    {!! nl2br(e($post->content)) !!}
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar para o feed
                    </a>
                    
                    <div>
                        <button class="btn btn-outline-danger me-2" onclick="likePost({{ $post->id }})">
                            <i class="far fa-heart"></i> Curtir
                        </button>
                        <button class="btn btn-outline-primary" onclick="sharePost({{ $post->id }})">
                            <i class="fas fa-share-alt"></i> Compartilhar
                        </button>
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
    line-height: 1.8;
    color: #333;
}
</style>
@endpush

@push('scripts')
<script>
function likePost(id) {
    // Implementar lógica de like
    alert('Funcionalidade de like será implementada em breve!');
}

function sharePost(id) {
    // Implementar lógica de compartilhamento
    navigator.clipboard.writeText(window.location.href);
    alert('Link copiado para a área de transferência!');
}
</script>
@endpush