@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $post->title }}</h4>
                @auth('ong')
                    @if(Auth::guard('ong')->id() === $post->ong_id)
                        <div>
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-light me-2">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Tem certeza?')">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
            <div class="card-body">
                {{-- Info da ONG --}}
                <div class="d-flex align-items-center mb-4">
                    @if($post->ong->logo)
                        <img src="{{ asset('storage/' . $post->ong->logo) }}" 
                             class="rounded-circle me-3" 
                             style="width: 60px; height: 60px; object-fit: cover;">
                    @else
                        <div class="bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-building text-white fa-2x"></i>
                        </div>
                    @endif
                    <div>
                        <h5 class="mb-1">{{ $post->ong->ong_name }}</h5>
                        <p class="mb-0 text-muted">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ $post->created_at->format('d/m/Y H:i') }}
                            @if($post->category)
                                <span class="mx-2">|</span>
                                <span class="badge bg-success">{{ $post->category }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($post->image)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             class="img-fluid rounded" 
                             style="max-height: 400px;">
                    </div>
                @endif

                <div class="post-content">
                    {!! nl2br(e($post->content)) !!}
                </div>

                <hr>

                {{-- Seção de apoio para usuários --}}
                @auth('regular')
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5><i class="fas fa-hand-holding-heart text-success me-2"></i>Apoiar esta causa</h5>
                            <p>Você pode ajudar de várias formas:</p>
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="btn btn-outline-success w-100 mb-2">
                                        <i class="fas fa-share me-2"></i>Compartilhar
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-outline-primary w-100 mb-2">
                                        <i class="fas fa-donate me-2"></i>Doar
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-outline-info w-100 mb-2">
                                        <i class="fas fa-calendar me-2"></i>Voluntariar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endauth

                {{-- Seção de comentários --}}
                <div class="comments-section">
                    <h5><i class="fas fa-comments me-2"></i>Comentários</h5>
                    
                    @auth('regular')
                        <form class="mb-4">
                            <div class="mb-3">
                                <textarea class="form-control" rows="3" 
                                          placeholder="Deixe seu comentário..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane me-2"></i>Comentar
                            </button>
                        </form>
                    @endauth

                    <div class="comments-list">
                        {{-- Lista de comentários --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection