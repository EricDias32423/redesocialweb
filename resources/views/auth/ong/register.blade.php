@extends('layouts.app')

@section('title', 'Registro de ONG')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header bg-primary text-white text-center py-4">
                <h3 class="mb-0">
                    <i class="fas fa-hand-holding-heart me-2"></i>Cadastre sua ONG
                </h3>
                <p class="text-white-50 mb-0 small">Faça parte da nossa rede de organizações</p>
            </div>
            
            <div class="card-body p-4">
                <form method="POST" action="{{ route('ong.register') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Dados do Responsável --}}
                    <div class="bg-light p-3 rounded mb-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-user-circle me-2"></i>Dados do Responsável
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('responsible_name') is-invalid @enderror" 
                                           id="responsible_name" 
                                           name="responsible_name" 
                                           placeholder="Nome completo"
                                           value="{{ old('responsible_name') }}" 
                                           required>
                                    <label for="responsible_name">
                                        <i class="fas fa-user me-2 text-primary"></i>Nome do Responsável
                                    </label>
                                    @error('responsible_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Dados da ONG --}}
                    <div class="bg-light p-3 rounded mb-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-building me-2"></i>Dados da ONG
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('ong_name') is-invalid @enderror" 
                                           id="ong_name" 
                                           name="ong_name" 
                                           placeholder="Nome da ONG"
                                           value="{{ old('ong_name') }}" 
                                           required>
                                    <label for="ong_name">
                                        <i class="fas fa-tag me-2 text-primary"></i>Nome da ONG
                                    </label>
                                    @error('ong_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('cnpj') is-invalid @enderror" 
                                           id="cnpj" 
                                           name="cnpj" 
                                           placeholder="00.000.000/0000-00"
                                           value="{{ old('cnpj') }}">
                                    <label for="cnpj">
                                        <i class="fas fa-id-card me-2 text-primary"></i>CNPJ (opcional)
                                    </label>
                                    @error('cnpj')
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
                                        <i class="fas fa-align-left me-2 text-primary"></i>Descrição (opcional)
                                    </label>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           placeholder="(00) 00000-0000"
                                           value="{{ old('phone') }}">
                                    <label for="phone">
                                        <i class="fas fa-phone me-2 text-primary"></i>Telefone (opcional)
                                    </label>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('address') is-invalid @enderror" 
                                           id="address" 
                                           name="address" 
                                           placeholder="Endereço completo"
                                           value="{{ old('address') }}">
                                    <label for="address">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>Endereço (opcional)
                                    </label>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="logo" class="form-label text-primary">
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
                                
                                <div id="logo-preview" class="mt-2 text-center" style="display: none;">
                                    <img src="#" alt="Preview" class="img-fluid rounded" style="max-height: 100px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Credenciais de Acesso --}}
                    <div class="bg-light p-3 rounded mb-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-lock me-2"></i>Credenciais de Acesso
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           placeholder="contato@ong.org"
                                           value="{{ old('email') }}" 
                                           required>
                                    <label for="email">
                                        <i class="fas fa-envelope me-2 text-primary"></i>E-mail institucional
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
                                        <i class="fas fa-key me-2 text-primary"></i>Senha
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
                                        <i class="fas fa-check-circle me-2 text-primary"></i>Confirmar senha
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Termos --}}
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label" for="terms">
                            Concordo com os <a href="#" class="text-primary">Termos de Uso</a> e 
                            <a href="#" class="text-primary">Política de Privacidade</a>
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-check-circle me-2"></i>Cadastrar ONG
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-light text-center py-3">
                <div class="small">
                    <span class="text-muted">Já tem uma conta?</span>
                    <a href="{{ route('ong.login') }}" class="text-primary fw-bold ms-2">
                        <i class="fas fa-sign-in-alt me-1"></i>Fazer login
                    </a>
                </div>
            </div>
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

// Validação de senha
document.getElementById('password').addEventListener('keyup', function() {
    const password = this.value;
    if (password.length < 8) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
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
@endsection