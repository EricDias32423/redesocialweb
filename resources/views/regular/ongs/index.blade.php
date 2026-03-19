@extends('layouts.app')

@section('title', 'ONGs para Apoiar')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 fw-bold mb-1" style="color: var(--text-dark);">
                    <i class="fas fa-hand-holding-heart me-2" style="color: var(--primary-green);"></i>
                    ONGs para Apoiar
                </h1>
                <p class="text-muted">Conheça e apoie organizações que fazem a diferença</p>
            </div>
            
            {{-- Barra de busca simples --}}
            <form action="{{ route('regular.ongs.index') }}" method="GET" class="mt-3 mt-sm-0">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Buscar ONG..." value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="row g-4">
            @forelse($ongs as $ong)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body text-center p-4">
                            {{-- Logo --}}
                            <div class="mb-3">
                                @if($ong->logo)
                                    <img src="{{ asset('storage/' . $ong->logo) }}" 
                                         class="rounded-circle border"
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                                         style="width: 100px; height: 100px;">
                                        <i class="fas fa-building fa-3x" style="color: var(--primary-green);"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Nome --}}
                            <h4 class="fw-semibold mb-2">{{ $ong->ong_name }}</h4>
                            
                            {{-- Localização --}}
                            <p class="small text-muted mb-3">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $ong->address ?? 'Localização não informada' }}
                            </p>

                            {{-- Descrição --}}
                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($ong->description ?? 'Sem descrição disponível', 100) }}
                            </p>

                            {{-- Estatísticas --}}
                            <div class="d-flex justify-content-around mb-4">
                                <div class="text-center">
                                    <span class="fw-bold d-block">{{ $ong->posts_count ?? 0 }}</span>
                                    <small class="text-muted">Posts</small>
                                </div>
                                <div class="text-center">
                                    <span class="fw-bold d-block">0</span>
                                    <small class="text-muted">Apoiadores</small>
                                </div>
                            </div>

                            {{-- Botões --}}
                            <div class="d-flex gap-2">
                                <a href="{{ route('regular.ongs.show', $ong) }}" class="btn btn-primary flex-grow-1">
                                    <i class="fas fa-eye me-2"></i>Ver perfil
                                </a>
                                @auth('regular')
                                    <form action="{{ route('regular.ongs.support', $ong) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-building fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted fw-normal">Nenhuma ONG encontrada</h4>
                        @if(request('search'))
                            <p class="text-muted">Tente outros termos de busca.</p>
                            <a href="{{ route('regular.ongs.index') }}" class="btn btn-outline-secondary mt-3">
                                <i class="fas fa-times me-2"></i>Limpar busca
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Paginação --}}
        @if($ongs->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $ongs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.hover-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.hover-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.08) !important;
}
</style>
@endpush