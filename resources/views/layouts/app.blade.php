<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rede Social de ONGs - @yield('title')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    @vite(['resources/css/style.css'])
    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-hand-holding-heart me-2"></i>Rede Social de ONGs
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    {{-- Verifica se NINGUÉM está logado (nem regular, nem ong) --}}
                    @guest('regular')
                    @guest('ong')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('choose.role') }}">
                            <i class="fas fa-user-circle me-1"></i>Acessar
                        </a>
                    </li>
                    @endguest
                    @endguest

                    {{-- MENU PARA USUÁRIO COMUM (RegularUser) --}}
                    @auth('regular')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
                            {{ Auth::guard('regular')->user()->name }}
                            <span class="badge bg-light text-success ms-2">Usuário</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('regular.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                {{-- CORRIGIDO: usar regular.profile.edit --}}
                                <a class="dropdown-item" href="{{ route('regular.profile.edit') }}">
                                    <i class="fas fa-user-cog me-2"></i>Meu Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('regular.ongs.index') }}">
                                    <i class="fas fa-hand-holding-heart me-2"></i>Descobrir ONGs
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('regular.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Sair
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endauth

                    {{-- MENU PARA ONG --}}
                    @auth('ong')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('posts.index') ? 'active' : '' }}" href="{{ route('posts.index') }}">
                            <i class="fas fa-stream me-1"></i>Feed
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('posts.create') ? 'active' : '' }}"
                            href="{{ route('posts.create') }}"> <!-- ISSO DEVE FUNCIONAR AGORA -->
                            <i class="fas fa-plus-circle me-1"></i>Novo Post
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('my-posts') ? 'active' : '' }}" href="{{ route('my-posts') }}">
                            <i class="fas fa-newspaper me-1"></i>Meus Posts
                        </a>
                    </li>

                    {{-- Dropdown da ONG --}}

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="ongDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(Auth::guard('ong')->user()->logo)
                            <img src="{{ asset('storage/' . Auth::guard('ong')->user()->logo) }}"
                                class="rounded-circle me-1"
                                style="width: 25px; height: 25px; object-fit: cover;"
                                alt="Logo">
                            @else
                            <i class="fas fa-building me-1"></i>
                            @endif
                            {{ Auth::guard('ong')->user()->ong_name }}
                            <span class="badge bg-light text-primary ms-2">ONG</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="ongDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('ong.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                {{-- CORRIGIDO: usar ong.profile.edit em vez de profile.ong.edit --}}
                                <a class="dropdown-item" href="{{ route('ong.profile.edit') }}">
                                    <i class="fas fa-building me-2"></i>Perfil da ONG
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('posts.create') }}">
                                    <i class="fas fa-plus-circle me-2"></i>Novo Post
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('posts.index') }}">
                                    <i class="fas fa-plus-circle me-2"></i>Feed
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('my-posts') }}">
                                    <i class="fas fa-newspaper me-2"></i>Meus Posts
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('ong.statistics') }}">
                                    <i class="fas fa-chart-bar me-2"></i>Estatísticas
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('ong.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Sair
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            {{-- Mensagens de sucesso --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Mensagens de erro --}}
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Erros de validação --}}
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Por favor, corrija os seguintes erros:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Conteúdo principal da página --}}
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © {{ date('Y') }} Rede Social de ONGs - Todos os direitos reservados
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Script para active class no menu --}}
    <script>
        $(document).ready(function() {
            // Active class para links normais
            var currentUrl = window.location.pathname;
            $('.navbar-nav .nav-link').each(function() {
                if ($(this).attr('href') === currentUrl) {
                    $(this).addClass('active');
                }
            });

            // Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    @stack('scripts')
</body>

</html>