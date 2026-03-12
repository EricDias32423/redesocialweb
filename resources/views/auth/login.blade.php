@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header bg-success text-white text-center py-4">
                <h3 class="mb-0">
                    <i class="fas fa-sign-in-alt me-2"></i>Bem-vindo de volta!
                </h3>
            </div>
            
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        @foreach($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               placeholder="nome@exemplo.com"
                               value="{{ old('email') }}" 
                               required 
                               autofocus>
                        <label for="email">
                            <i class="fas fa-envelope me-2 text-success"></i>E-mail
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
                            <i class="fas fa-lock me-2 text-success"></i>Senha
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
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Entrar
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-light text-center py-3">
                <div class="small">
                    <span class="text-muted">Ainda não tem uma conta?</span>
                    <a href="{{ route('register') }}" class="text-success fw-bold ms-2">
                        <i class="fas fa-user-plus me-1"></i>Registre sua ONG agora!
                    </a>
                </div>
            </div>
        </div>

        <!-- Links úteis -->
        <div class="text-center mt-3">
            <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                <i class="fas fa-arrow-left me-1"></i>Voltar para a página inicial
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label {
    color: #28a745;
    opacity: 1;
}

.form-floating > label i {
    font-size: 1rem;
}

.card {
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush
@endsection