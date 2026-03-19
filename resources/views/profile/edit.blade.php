@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4">
                <h4 class="mb-0 fw-bold">
                    <i class="fas fa-user-circle me-2" style="color: var(--primary-green);"></i>
                    Meu Perfil
                </h4>
                <p class="text-muted small mb-0">Gerencie suas informações pessoais</p>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success py-2 mb-4">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                {{-- Avatar atual --}}
                <div class="text-center mb-4">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" 
                             alt="Avatar" 
                             class="rounded-circle border"
                             style="width: 100px; height: 100px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-user fa-3x" style="color: var(--primary-green);"></i>
                        </div>
                    @endif
                </div>

                {{-- Abas de navegação --}}
                <ul class="nav nav-tabs border-0 mb-4" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill px-4 py-2 me-2" 
                                style="background-color: transparent; color: var(--text-dark); border: 1px solid var(--border-light);"
                                id="info-tab" data-bs-toggle="tab" data-bs-target="#info" 
                                type="button" role="tab">
                            <i class="fas fa-info-circle me-2" style="color: var(--primary-green);"></i>Informações
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-4 py-2" 
                                style="background-color: transparent; color: var(--text-dark); border: 1px solid var(--border-light);"
                                id="security-tab" data-bs-toggle="tab" data-bs-target="#security" 
                                type="button" role="tab">
                            <i class="fas fa-shield-alt me-2" style="color: var(--primary-green);"></i>Segurança
                        </button>
                    </li>
                </ul>

                <form method="POST" action="{{ route('regular.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="tab-content" id="profileTabsContent">
                        {{-- Aba de Informações --}}
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">NOME COMPLETO</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">E-MAIL</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">CPF</label>
                                    <input type="text" 
                                           class="form-control @error('cpf') is-invalid @enderror" 
                                           name="cpf" 
                                           value="{{ old('cpf', $user->cpf) }}"
                                           placeholder="000.000.000-00">
                                    @error('cpf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">DATA DE NASCIMENTO</label>
                                    <input type="date" 
                                           class="form-control @error('birth_date') is-invalid @enderror" 
                                           name="birth_date" 
                                           value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}">
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">TELEFONE</label>
                                    <input type="text" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           name="phone" 
                                           value="{{ old('phone', $user->phone) }}"
                                           placeholder="(00) 00000-0000">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label text-muted small fw-semibold">FOTO DE PERFIL</label>
                                    <div class="border rounded p-3 bg-light">
                                        <input type="file" 
                                               class="form-control @error('avatar') is-invalid @enderror" 
                                               name="avatar" 
                                               accept="image/*">
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Deixe em branco para manter a foto atual. Máx: 2MB
                                        </small>
                                    </div>
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <div id="avatar-preview" class="mt-2 text-center" style="display: none;">
                                        <img src="#" alt="Preview" class="img-fluid rounded-circle border" style="max-height: 100px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Aba de Segurança --}}
                        <div class="tab-pane fade" id="security" role="tabpanel">
                            <div class="alert alert-info border-0 bg-info bg-opacity-10 text-info py-2 mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                Preencha apenas se desejar alterar sua senha.
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label text-muted small fw-semibold">SENHA ATUAL</label>
                                    <input type="password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">NOVA SENHA</label>
                                    <input type="password" 
                                           class="form-control @error('new_password') is-invalid @enderror" 
                                           name="new_password">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">CONFIRMAR SENHA</label>
                                    <input type="password" 
                                           class="form-control" 
                                           name="new_password_confirmation">
                                </div>
                                @error('new_password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Excluir Conta
                        </button>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-save me-2"></i>Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal de exclusão --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Excluir Conta
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger mb-3">
                    <strong>Atenção!</strong> Esta ação é irreversível. Todos os seus dados serão permanentemente excluídos.
                </p>
                
                <form id="deleteForm" method="POST" action="{{ route('regular.profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">CONFIRME SUA SENHA</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password" 
                               required>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="submit" form="deleteForm" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Sim, excluir conta
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Preview do avatar
document.getElementById('avatar').addEventListener('change', function(e) {
    const preview = document.getElementById('avatar-preview');
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