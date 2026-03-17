@extends('layouts.app')

@section('title', 'Painel da ONG')

@section('content')
{{-- DEBUG - REMOVER DEPOIS --}}
<div class="alert alert-info">
    <h5>🔍 DEBUG INFORMAÇÕES:</h5>
    <ul>
        <li>Usuário logado como ONG: <strong>{{ Auth::guard('ong')->check() ? 'SIM' : 'NÃO' }}</strong></li>
        <li>Nome da ONG: <strong>{{ Auth::guard('ong')->user()->ong_name ?? 'N/A' }}</strong></li>
        <li>Rota 'posts.create' existe: <strong>{{ Route::has('posts.create') ? 'SIM' : 'NÃO' }}</strong></li>
        <li>URL gerada: <strong>{{ route('posts.create') }}</strong></li>
    </ul>
</div>
<div class="row">
    <div class="col-12">
        {{-- Header com saudação --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 text-primary">
                    <i class="fas fa-tachometer-alt me-2"></i>Painel da ONG
                </h1>
                <p class="text-muted">Bem-vindo de volta, {{ Auth::guard('ong')->user()->ong_name }}!</p>
            </div>
            
            {{-- CORRIGIDO: Verificar qual nome de rota existe --}}
            @php
                $createRoute = null;
                if (Route::has('posts.create')) {
                    $createRoute = route('posts.create');
                } elseif (Route::has('ong.posts.create')) {
                    $createRoute = route('ong.posts.create');
                }
            @endphp
            
            @if($createRoute)
                <a href="{{ $createRoute }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Novo Post
                </a>
            @else
                <span class="text-danger">Rota de criação não encontrada</span>
            @endif
        </div>

        {{-- Cards de estatísticas --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Total de Posts</h6>
                                <h2 class="mb-0">{{ $stats['total_posts'] }}</h2>
                            </div>
                            <i class="fas fa-newspaper fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Visualizações</h6>
                                <h2 class="mb-0">{{ $stats['total_views'] }}</h2>
                            </div>
                            <i class="fas fa-eye fa-3x text-white-50"></i>
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
                                <h6 class="text-white-50 mb-2">Apoiadores</h6>
                                <h2 class="mb-0">{{ $stats['total_followers'] }}</h2>
                            </div>
                            <i class="fas fa-heart fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Gráfico de atividades --}}
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Atividade Recente</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="activityChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            {{-- Informações da ONG --}}
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-building me-2 text-primary"></i>Minha ONG</h5>
                    </div>
                    <div class="card-body text-center">
                        @if(Auth::guard('ong')->user()->logo)
                            <img src="{{ asset('storage/' . Auth::guard('ong')->user()->logo) }}" 
                                 class="rounded-circle mb-3" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="bg-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                 style="width: 100px; height: 100px;">
                                <i class="fas fa-building text-white fa-3x"></i>
                            </div>
                        @endif
                        
                        <h5>{{ Auth::guard('ong')->user()->ong_name }}</h5>
                        <p class="text-muted small">
                            <i class="fas fa-envelope me-1"></i>{{ Auth::guard('ong')->user()->email }}
                        </p>
                        <p class="text-muted small">
                            <i class="fas fa-calendar me-1"></i>Membro desde {{ $stats['member_since'] }}
                        </p>
                        
                        <div class="d-grid gap-2 mt-3">
                            <a href="{{ route('ong.profile.edit') }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit me-2"></i>Editar Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Últimos posts --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-newspaper me-2 text-primary"></i>Últimos Posts</h5>
                        
                        {{-- CORRIGIDO: Verificar qual nome de rota existe para "meus posts" --}}
                        @php
                            $myPostsRoute = null;
                            if (Route::has('my-posts')) {
                                $myPostsRoute = route('my-posts');
                            } elseif (Route::has('ong.posts.index')) {
                                $myPostsRoute = route('ong.posts.index');
                            } elseif (Route::has('posts.index')) {
                                $myPostsRoute = route('posts.index');
                            }
                        @endphp
                        
                        @if($myPostsRoute)
                            <a href="{{ $myPostsRoute }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Categoria</th>
                                        <th>Data</th>
                                        <th>Comentários</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPosts as $post)
                                        <tr>
                                            <td>
                                                {{-- CORRIGIDO: Verificar rota para show --}}
                                                @php
                                                    $showRoute = null;
                                                    if (Route::has('posts.show')) {
                                                        $showRoute = route('posts.show', $post);
                                                    }
                                                @endphp
                                                
                                                @if($showRoute)
                                                    <a href="{{ $showRoute }}" class="text-decoration-none">
                                                        {{ Str::limit($post->title, 50) }}
                                                    </a>
                                                @else
                                                    {{ Str::limit($post->title, 50) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($post->category)
                                                    <span class="badge bg-info">{{ $post->category }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $post->comments_count ?? 0 }}</span>
                                            </td>
                                            <td>
                                                {{-- CORRIGIDO: Verificar rota para edit --}}
                                                @php
                                                    $editRoute = null;
                                                    if (Route::has('posts.edit')) {
                                                        $editRoute = route('posts.edit', $post);
                                                    } elseif (Route::has('ong.posts.edit')) {
                                                        $editRoute = route('ong.posts.edit', $post);
                                                    }
                                                @endphp
                                                
                                                @if($editRoute)
                                                    <a href="{{ $editRoute }}" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                
                                                {{-- CORRIGIDO: Verificar rota para destroy --}}
                                                @php
                                                    $destroyRoute = null;
                                                    if (Route::has('posts.destroy')) {
                                                        $destroyRoute = route('posts.destroy', $post);
                                                    } elseif (Route::has('ong.posts.destroy')) {
                                                        $destroyRoute = route('ong.posts.destroy', $post);
                                                    }
                                                @endphp
                                                
                                                @if($destroyRoute)
                                                    <form action="{{ $destroyRoute }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('Excluir este post?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Nenhum post criado ainda</p>
                                                
                                                @if($createRoute)
                                                    <a href="{{ route('posts.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus-circle me-2"></i>Criar primeiro post
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('activityChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Posts',
                data: [12, 19, 3, 5, 2, 3],
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }, {
                label: 'Comentários',
                data: [5, 10, 8, 12, 7, 9],
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
</script>
@endpush
@endsection