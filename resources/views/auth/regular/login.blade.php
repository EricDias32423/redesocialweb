@extends('layouts.app')

@section('title', 'Login - Usuário')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-header bg-success text-white text-center py-3">
                <h4 class="mb-0">
                    <i class="fas fa-user me-2"></i>Login - Usuário Comum
                </h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('regular.login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Lembrar-me</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-sign-in-alt me-2"></i>Entrar
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p class="mb-2">Não tem uma conta?</p>
                    <a href="{{ route('regular.register') }}" class="btn btn-outline-success">
                        <i class="fas fa-user-plus me-2"></i>Cadastre-se
                    </a>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('choose.role') }}" class="text-muted">
                        <i class="fas fa-arrow-left me-1"></i>Voltar para escolha de tipo
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection