@extends('layouts.app')

@section('title', 'Login - ONG')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header bg-primary text-white text-center py-4">
                <h3 class="mb-0">
                    <i class="fas fa-building me-2"></i>Login - ONG
                </h3>
                <p class="text-white-50 mb-0 small">Acesse sua conta institucional</p>
            </div>
            
            <div class="card-body p-4">
                <form method="POST" action="{{ route('ong.login') }}">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               placeholder="nome@ong.com"
                               value="{{ old('email') }}" 
                               required 
                               autofocus>
                        <label for="email">
                            <i class="fas fa-envelope me-2 text-primary"></i>E-mail
                        </label>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Senha"
                               required>
                        <label for="password">
                            <i class="fas fa-lock me-2 text-primary"></i>Senha
                        </label>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            <i class="far fa-check-square me-1"></i>Lembrar-me
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Entrar
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-light text-center py-3">
                <div class="small">
                    <span class="text-muted">Ainda não tem uma conta?</span>
                    <a href="{{ route('ong.register') }}" class="text-primary fw-bold ms-2">
                        <i class="fas fa-plus-circle me-1"></i>Registrar ONG
                    </a>
                </div>
                <div class="small mt-2">
                    <a href="{{ route('choose.role') }}" class="text-muted">
                        <i class="fas fa-arrow-left me-1"></i>Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection