@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-user-circle me-2"></i>Meu Perfil - {{ $user->ong_name }}</h4>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Logo atual -->
                    <div class="text-center mb-4">
                        @if($user->logo)
                            <img src="{{ asset('storage/' . $user->logo) }}" 
                                 alt="Logo da ONG" 
                                 class="rounded-circle img-thumbnail"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center"
                                 style="width: 150px; height: 150px;">
                                <i class="fas fa-building text-white fa-4x"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Abas de navegação -->
                    <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                                <i class="fas fa-info-circle me-2"></i>Informações Básicas
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">
                                <i class="fas fa-shield-alt me-2"></i>Segurança
                            </button>
                        </li>
                    </ul>

                    <!-- Conteúdo das abas -->
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Aba de Informações -->
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user text-success me-2"></i>Nome do Responsável
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope text-success me-2"></i>E-mail
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="ong_name" class="form-label">
                                        <i class="fas fa-building text-success me-2"></i>Nome da ONG
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('ong_name') is-invalid @enderror" 
                                           id="ong_name" 
                                           name="ong_name" 
                                           value="{{ old('ong_name', $user->ong_name) }}"
                                           required>
                                    @error('ong_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">
                                        <i class="fas fa-align-left text-success me-2"></i>Descrição da ONG
                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4">{{ old('description', $user->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="logo" class="form-label">
                                        <i class="fas fa-image text-success me-2"></i>Logo da ONG
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('logo') is-invalid @enderror" 
                                           id="logo" 
                                           name="logo" 
                                           accept="image/*">
                                    <small class="text-muted">Deixe em branco para manter a logo atual</small>
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <!-- Preview da nova logo -->
                                    <div id="logo-preview" class="mt-2" style="display: none;">
                                        <img src="#" alt="Preview" class="img-fluid rounded" style="max-height: 100px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aba de Segurança -->
                        <div class="tab-pane fade" id="security" role="tabpanel">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Preencha apenas se desejar alterar sua senha.
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="current_password" class="form-label">
                                        <i class="fas fa-lock text-success me-2"></i>Senha Atual
                                    </label>
                                    <input type="password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" 
                                           name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="new_password" class="form-label">
                                        <i class="fas fa-key text-success me-2"></i>Nova Senha
                                    </label>
                                    <input type="password" 
                                           class="form-control @error('new_password') is-invalid @enderror" 
                                           id="new_password" 
                                           name="new_password">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="new_password_confirmation" class="form-label">
                                        <i class="fas fa-check-circle text-success me-2"></i>Confirmar Nova Senha
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="new_password_confirmation" 
                                           name="new_password_confirmation">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Salvar Alterações
                        </button>
                        
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Excluir Conta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Excluir Conta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger">
                    <strong>Atenção!</strong> Esta ação é irreversível. Todos os seus dados, incluindo posts e histórico, serão permanentemente excluídos.
                </p>
                
                <form id="deleteForm" method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Digite sua senha para confirmar:
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="delete_password" 
                               name="password" 
                               required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="submit" form="deleteForm" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Sim, excluir minha conta
                </button>
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

// Validação de senha em tempo real
document.getElementById('new_password').addEventListener('keyup', validatePassword);
document.getElementById('new_password_confirmation').addEventListener('keyup', validatePassword);

function validatePassword() {
    const password = document.getElementById('new_password').value;
    const confirm = document.getElementById('new_password_confirmation').value;
    
    if (password && password.length < 8) {
        document.getElementById('new_password').classList.add('is-invalid');
    } else {
        document.getElementById('new_password').classList.remove('is-invalid');
    }
    
    if (confirm && password !== confirm) {
        document.getElementById('new_password_confirmation').classList.add('is-invalid');
    } else {
        document.getElementById('new_password_confirmation').classList.remove('is-invalid');
    }
}
</script>
@endpush
@endsection