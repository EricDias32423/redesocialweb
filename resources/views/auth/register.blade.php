@extends('layouts.app')

@section('title', 'Registro de ONG')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header bg-success text-white text-center py-4">
                <h3 class="mb-0">
                    <i class="fas fa-hand-holding-heart me-2"></i>Cadastre sua ONG
                </h3>
                <p class="text-white-50 mb-0 small">Faça parte da nossa rede social</p>
            </div>
            
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Por favor, corrija os seguintes erros:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Dados do Responsável -->
                    <div class="bg-light p-3 rounded mb-4">
                        <h5 class="text-success mb-3">
                            <i class="fas fa-user-circle me-2"></i>Dados do Responsável
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           placeholder="Seu nome completo"
                                           value="{{ old('name') }}" 
                                           required>
                                    <label for="name">
                                        <i class="fas fa-user me-2 text-success"></i>Nome do Responsável
                                    </label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dados da ONG -->
                    <div class="bg-light p-3 rounded mb-4">
                        <h5 class="text-success mb-3">
                            <i class="fas fa-building me-2"></i>Dados da ONG
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('ong_name') is-invalid @enderror" 
                                           id="ong_name" 
                                           name="ong_name" 
                                           placeholder="Nome da ONG"
                                           value="{{ old('ong_name') }}" 
                                           required>
                                    <label for="ong_name">
                                        <i class="fas fa-tag me-2 text-success"></i>Nome da ONG
                                    </label>
                                    @error('ong_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              placeholder="Descrição da ONG"
                                              style="height: 100px">{{ old('description') }}</textarea>
                                    <label for="description">
                                        <i class="fas fa-align-left me-2 text-success"></i>Descrição (opcional)
                                    </label>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="logo" class="form-label text-success">
                                    <i class="fas fa-image me-2"></i>Logo da ONG (opcional)
                                </label>
                                <input type="file" 
                                       class="form-control @error('logo') is-invalid @enderror" 
                                       id="logo" 
                                       name="logo" 
                                       accept="image/*">
                                <small class="text-muted">Formatos: JPG, PNG, GIF. Máx: 2MB</small>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <!-- Preview da imagem -->
                                <div id="logo-preview" class="mt-2 text-center" style="display: none;">
                                    <img src="#" alt="Preview da logo" class="img-fluid rounded" style="max-height: 100px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Credenciais de Acesso -->
                    <div class="bg-light p-3 rounded mb-4">
                        <h5 class="text-success mb-3">
                            <i class="fas fa-lock me-2"></i>Credenciais de Acesso
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           placeholder="email@exemplo.com"
                                           value="{{ old('email') }}" 
                                           required>
                                    <label for="email">
                                        <i class="fas fa-envelope me-2 text-success"></i>E-mail para login
                                    </label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Senha"
                                           required>
                                    <label for="password">
                                        <i class="fas fa-key me-2 text-success"></i>Senha
                                    </label>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Confirmar senha"
                                           required>
                                    <label for="password_confirmation">
                                        <i class="fas fa-check-circle me-2 text-success"></i>Confirmar senha
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Termos e Condições -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label" for="terms">
                            Concordo com os <a href="#" class="text-success">Termos de Uso</a> e 
                            <a href="#" class="text-success">Política de Privacidade</a>
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-check-circle me-2"></i>Cadastrar ONG
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-light text-center py-3">
                <div class="small">
                    <span class="text-muted">Já tem uma conta?</span>
                    <a href="{{ route('login') }}" class="text-success fw-bold ms-2">
                        <i class="fas fa-sign-in-alt me-1"></i>Faça login aqui
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

@push('scripts')
<script>
// Preview da logo
document.getElementById('logo').addEventListener('change', function(e) {
    const preview = document.getElementById('logo-preview');
    const img = preview.querySelector('img');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});

// Validação de senha em tempo real
document.getElementById('password').addEventListener('keyup', function() {
    const password = this.value;
    const confirm = document.getElementById('password_confirmation').value;
    
    if (password.length < 8) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
    
    if (confirm && password !== confirm) {
        document.getElementById('password_confirmation').classList.add('is-invalid');
    } else {
        document.getElementById('password_confirmation').classList.remove('is-invalid');
    }
});

document.getElementById('password_confirmation').addEventListener('keyup', function() {
    const password = document.getElementById('password').value;
    const confirm = this.value;
    
    if (password !== confirm) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
});
</script>
@endpush

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

.bg-light {
    background-color: #f8f9fa !important;
}

.card {
    animation: slideIn 0.5s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Estilo para validação */
.is-invalid {
    border-color: #dc3545;
}

.is-invalid ~ label {
    color: #dc3545;
}

.invalid-feedback {
    font-size: 0.875rem;
}
</style>
@endpush
@endsection