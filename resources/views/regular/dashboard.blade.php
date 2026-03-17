@extends('layouts.app')

@section('title', 'Meu Painel')

@section('content')
<div class="row">
    <div class="col-12">
        {{-- Header com saudação --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 text-success">
                    <i class="fas fa-tachometer-alt me-2"></i>Meu Painel
                </h1>
                <p class="text-muted">Bem-vindo de volta, {{ $user->name }}!</p>
            </div>
            <a href="{{ route('regular.ongs.index') }}" class="btn btn-success">
                <i class="fas fa-hand-holding-heart me-2"></i>Descobrir ONGs
            </a>
        </div>

        {{-- Cards de estatísticas --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">ONGs Apoiadas</h6>
                                <h2 class="mb-0">{{ $stats['total_ongs_supported'] }}</h2>
                            </div>
                            <i class="fas fa-hand-holding-heart fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Comentários</h6>
                                <h2 class="mb-0">{{ $stats['total_comments'] }}</h2>
                            </div>
                            <i class="fas fa-comments fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Curtidas</h6>
                                <h2 class="mb-0">{{ $stats['total_likes_given'] }}</h2>
                            </div>
                            <i class="fas fa-heart fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Membro desde</h6>
                                <h5 class="mb-0">{{ $stats['member_since'] }}</h5>
                            </div>
                            <i class="fas fa-calendar-alt fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Atividades Recentes --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-history me-2 text-success"></i>Atividades Recentes</h5>
                    </div>
                    <div class="card-body">
                        @if(count($recentActivities) > 0)
                            <div class="timeline">
                                @foreach($recentActivities as $activity)
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0">
                                            <span class="badge bg-{{ $activity['color'] }} rounded-pill p-2">
                                                <i class="{{ $activity['icon'] }}"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">{{ $activity['description'] }}</p>
                                            <small class="text-muted">{{ $activity['date']->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Nenhuma atividade recente</p>
                                <a href="{{ route('regular.ongs.index') }}" class="btn btn-sm btn-success">
                                    Começar a apoiar ONGs
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ONGs Recomendadas --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-star me-2 text-success"></i>ONGs Recomendadas</h5>
                        <a href="{{ route('regular.ongs.index') }}" class="btn btn-sm btn-outline-success">Ver todas</a>
                    </div>
                    <div class="card-body">
                        @if(count($recommendedOngs) > 0)
                            @foreach($recommendedOngs as $ong)
                                <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                    <div class="flex-shrink-0">
                                        @if($ong->logo)
                                            <img src="{{ asset('storage/' . $ong->logo) }}" 
                                                 class="rounded-circle" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-building text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ $ong->ong_name }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-newspaper me-1"></i>{{ $ong->posts_count }} posts
                                        </small>
                                    </div>
                                    <div>
                                        <a href="{{ route('regular.ongs.show', $ong) }}" 
                                           class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-building fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Nenhuma recomendação no momento</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Últimos Posts das ONGs Apoiadas --}}
        <div class="row mt-2">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-newspaper me-2 text-success"></i>Últimos Posts das ONGs que você apoia</h5>
                    </div>
                    <div class="card-body">
                        @if(isset($feedPosts) && count($feedPosts) > 0)
                            <div class="row">
                                @foreach($feedPosts as $post)
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100 border-0 shadow-sm">
                                            @if($post->image)
                                                <img src="{{ asset('storage/' . $post->image) }}" 
                                                     class="card-img-top" 
                                                     style="height: 150px; object-fit: cover;">
                                            @endif
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2">
                                                    @if($post->ong->logo)
                                                        <img src="{{ asset('storage/' . $post->ong->logo) }}" 
                                                             class="rounded-circle me-2" 
                                                             style="width: 30px; height: 30px; object-fit: cover;">
                                                    @endif
                                                    <small class="text-muted">{{ $post->ong->ong_name }}</small>
                                                </div>
                                                <h6 class="card-title">{{ Str::limit($post->title, 50) }}</h6>
                                                <p class="card-text small text-muted">
                                                    {{ Str::limit(strip_tags($post->content), 80) }}
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <a href="{{ route('posts.show', $post) }}" 
                                                       class="btn btn-sm btn-outline-success">
                                                        Ler mais
                                                    </a>
                                                    <small class="text-muted">
                                                        {{ $post->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Comece a apoiar ONGs para ver posts no seu feed</p>
                                <a href="{{ route('regular.ongs.index') }}" class="btn btn-success">
                                    <i class="fas fa-hand-holding-heart me-2"></i>Descobrir ONGs
                                </a>
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
.timeline {
    position: relative;
    padding-left: 1rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 1.5rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #e9ecef;
}

.timeline .d-flex {
    position: relative;
    z-index: 1;
}

.timeline .badge {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}
</style>
@endpush
@endsection