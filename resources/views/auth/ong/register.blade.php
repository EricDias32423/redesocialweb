@extends('layouts.app')

@section('title', 'Registro de ONG')

@section('content')
<div class="row justify-content-center fade-in">
    <div class="col-md-10 col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white text-center py-4 border-0">
                <div class="mb-3">
                    <div class="rounded-circle bg-light d-inline-flex p-3">
                        <i class="fas fa-hand-holding-heart fa-3x" style="color: var(--primary-blue);"></i>
                    </div>
                </div>
                <h4 class="mb-1 fw-bold">Cadastre sua ONG</h4>
                <p class="text-muted small">Faça parte da nossa rede de organizações</p>
            </div>

            <div class="card-body px-4 py-3">
                <form method="POST" action="{{ route('ong.register') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Dados do Responsável --}}
                    <div class="mb-4">
                        <h5 class="text-muted fw-semibold mb-3 small">DADOS DO RESPONSÁVEL</h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="responsible_name" class="form-label text-muted small fw-semibold">NOME COMPLETO</label>
                                <input type="text" 
                                       class="form-control @error('responsible_name') is-invalid @enderror" 
                                       id="responsible_name" 
                                       name="responsible_name" 
                                       value="{{ old('responsible_name') }}" 
                                       placeholder="Nome do responsável legal"
                                       required>
                                @error('responsible_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Dados da ONG --}}
                    <div class="mb-4">
                        <h5 class="text-muted fw-semibold mb-3 small">DADOS DA ONG</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="ong_name" class="form-label text-muted small fw-semibold">NOME DA ONG</label>
                                <input type="text" 
                                       class="form-control @error('ong_name') is-invalid @enderror" 
                                       id="ong_name" 
                                       name="ong_name" 
                                       value="{{ old('ong_name') }}" 
                                       placeholder="Ex: Associação Esperança"
                                       required>
                                @error('ong_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="cnpj" class="form-label text-muted small fw-semibold">CNPJ</label>
                                <input type="text" 
                                       class="form-control @error('cnpj') is-invalid @enderror" 
                                       id="cnpj" 
                                       name="cnpj" 
                                       value="{{ old('cnpj') }}"
                                       placeholder="00.000.000/0000-00">
                                @error('cnpj')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label text-muted small fw-semibold">DESCRIÇÃO</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="3"
                                          placeholder="Fale um pouco sobre a missão da sua ONG...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label text-muted small fw-semibold">TELEFONE</label>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}"
                                       placeholder="(00) 00000-0000">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="address" class="form-label text-muted small fw-semibold">ENDEREÇO</label>
                                <input type="text" 
                                       class="form-control @error('address') is-invalid @enderror" 
                                       id="address" 
                                       name="address" 
                                       value="{{ old('address') }}"
                                       placeholder="Cidade, estado">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="logo" class="form-label text-muted small fw-semibold">LOGO DA ONG</label>
                                <input type="file" 
                                       class="form-control @error('logo') is-invalid @enderror" 
                                       id="logo" 
                                       name="logo" 
                                       accept="image/*">
                                <small class="text-muted">Formatos: JPG, PNG, GIF (máx. 2MB)</small>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <div id="logo-preview" class="mt-2 text-center" style="display: none;">
                                    <img src="#" alt="Preview" class="img-fluid rounded border" style="max-height: 120px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Credenciais de Acesso --}}
                    <div class="mb-4">
                        <h5 class="text-muted fw-semibold mb-3 small">CREDENCIAIS DE ACESSO</h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="email" class="form-label text-muted small fw-semibold">E-MAIL INSTITUCIONAL</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="contato@ong.org"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label text-muted small fw-semibold">SENHA</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Mínimo 8 caracteres"
                                       required>
                                <small class="text-muted">Mínimo 8 caracteres</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label text-muted small fw-semibold">CONFIRMAR SENHA</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Digite a senha novamente"
                                       required>
                            </div>
                        </div>
                    </div>

                    {{-- Termos --}}
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label small" for="terms">
                            Concordo com os <a href="#" class="text-decoration-none" style="color: var(--primary-blue);">Termos de Uso</a> e 
                            <a href="#" class="text-decoration-none" style="color: var(--primary-blue);">Política de Privacidade</a>
                        </label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="fas fa-check-circle me-2"></i>Cadastrar ONG
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-white text-center py-4 border-0">
                <p class="mb-2 text-muted small">Já tem uma conta?</p>
                <a href="{{ route('ong.login') }}" class="btn btn-outline-primary px-4">
                    <i class="fas fa-sign-in-alt me-2"></i>Fazer login
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