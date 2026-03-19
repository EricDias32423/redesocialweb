@extends('layouts.app')

@section('title', 'Login - Usuário')

@section('content')
<div class="row justify-content-center fade-in">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white text-center py-4 border-0">
                <div class="mb-3">
                    <div class="rounded-circle bg-light d-inline-flex p-3">
                        <i class="fas fa-user fa-3x" style="color: var(--primary-green);"></i>
                    </div>
                </div>
                <h4 class="mb-1 fw-bold">Bem-vindo de volta</h4>
                <p class="text-muted small">Faça login para continuar</p>
            </div>

            <div class="card-body px-4 py-3">
                <form method="POST" action="{{ route('regular.login') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="form-label text-muted small fw-semibold">E-MAIL</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="seu@email.com"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label text-muted small fw-semibold">SENHA</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="••••••••"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label small" for="remember">Lembrar-me</label>
                        </div>
                        <a href="#" class="small text-decoration-none" style="color: var(--primary-green);">Esqueceu a senha?</a>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-success py-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Entrar
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-white text-center py-4 border-0">
                <p class="mb-2 text-muted small">Ainda não tem uma conta?</p>
                <a href="{{ route('regular.register') }}" class="btn btn-outline-success px-4">
                    <i class="fas fa-user-plus me-2"></i>Criar conta
                </a>
                <div class="mt-3">
                    <a href="{{ route('choose.role') }}" class="text-muted small text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection