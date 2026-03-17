@extends('layouts.app')

@section('title', 'ONGs para Apoiar')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h2 text-success mb-4">
            <i class="fas fa-hand-holding-heart me-2"></i>ONGs para Apoiar
        </h1>

        <div class="row g-4">
            @foreach($ongs as $ong)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <div class="card-body text-center">
                            @if($ong->logo)
                                <img src="{{ asset('storage/' . $ong->logo) }}" 
                                     class="rounded-circle mb-3" 
                                     style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <div class="bg-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                                     style="width: 100px; height: 100px;">
                                    <i class="fas fa-building text-white fa-3x"></i>
                                </div>
                            @endif

                            <h4 class="card-title">{{ $ong->ong_name }}</h4>
                            <p class="text-muted small">
                                <i class="fas fa-map-marker-alt me-1"></i>{{ $ong->address ?? 'Localização não informada' }}
                            </p>
                            <p class="card-text">{{ Str::limit($ong->description, 100) }}</p>

                            <div class="d-flex justify-content-around mb-3">
                                <div class="text-center">
                                    <h5 class="mb-0">{{ $ong->posts_count }}</h5>
                                    <small class="text-muted">Posts</small>
                                </div>
                                <div class="text-center">
                                    <h5 class="mb-0">0</h5>
                                    <small class="text-muted">Apoiadores</small>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="#" class="btn btn-outline-success">
                                    <i class="fas fa-heart me-2"></i>Apoiar
                                </a>
                                <a href="#" class="btn btn-success">
                                    <i class="fas fa-eye me-2"></i>Ver perfil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection