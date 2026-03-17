@extends('layouts.app')

@section('title', 'Meu Perfil - Usuário')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-user-circle me-2"></i>Meu Perfil - {{ $user->name }}</h4>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Avatar atual --}}
                <div class="text-center mb-4">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" 
                             alt="Avatar do usuário" 
                             class="rounded-circle img-thumbnail"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center"
                             style="width: 150px; height: 150px;">
                            <i class="fas fa-user text-white fa-4x"></i>
                        </div>
                    @endif
                </div>

                {{-- Abas de navegação --}}
                <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" 
                                type="button" role="tab">
                            <i class="fas fa-info-circle me-2"></i>Informações Pessoais
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" 
                                type="button" role="tab">
                            <i class="fas fa-shield-alt me-2"></i>Segurança
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="preferences-tab" data-bs-toggle="tab" data-bs-target="#preferences" 
                                type="button" role="tab">
                            <i class="fas fa-sliders-h me-2"></i>Preferências
                        </button>
                    </li>
                </ul>

                <form method="POST" action="{{ route('regular.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="tab-content" id="profileTabsContent">
                        {{-- Aba de Informações Pessoais --}}
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user text-success me-2"></i>Nome Completo
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

                                <div class="col-md-6 mb-3">
                                    <label for="cpf" class="form-label">
                                        <i class="fas fa-id-card text-success me-2"></i>CPF
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('cpf') is-invalid @enderror" 
                                           id="cpf" 
                                           name="cpf" 
                                           value="{{ old('cpf', $user->cpf) }}"
                                           placeholder="000.000.000-00">
                                    @error('cpf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="birth_date" class="form-label">
                                        <i class="fas fa-calendar-alt text-success me-2"></i>Data de Nascimento
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('birth_date') is-invalid @enderror" 
                                           id="birth_date" 
                                           name="birth_date" 
                                           value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}">
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone text-success me-2"></i>Telefone
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', $user->phone) }}"
                                           placeholder="(00) 00000-0000">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="avatar" class="form-label">
                                        <i class="fas fa-camera text-success me-2"></i>Foto de Perfil
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('avatar') is-invalid @enderror" 
                                           id="avatar" 
                                           name="avatar" 
                                           accept="image/*">
                                    <small class="text-muted">Deixe em branco para manter a foto atual. Tamanho máx: 2MB</small>
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    {{-- Preview da nova foto --}}
                                    <div id="avatar-preview" class="mt-2 text-center" style="display: none;">
                                        <img src="#" alt="Preview" class="img-fluid rounded-circle" style="max-height: 100px; max-width: 100px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Aba de Segurança --}}
                        <div class="tab-pane fade" id="security" role="tabpanel">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Dica:</strong> Preencha apenas se desejar alterar sua senha. Deixe em branco para manter a senha atual.
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
                                    <small class="text-muted">Obrigatório apenas se for alterar a senha</small>
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
                                    <small class="text-muted">Mínimo 8 caracteres</small>
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

                            {{-- Força da senha --}}
                            <div class="mt-3" id="password-strength" style="display: none;">
                                <label class="form-label">Força da senha:</label>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" id="strength-bar" role="progressbar" style="width: 0%;"></div>
                                </div>
                                <small class="text-muted" id="strength-text"></small>
                            </div>
                        </div>

                        {{-- Aba de Preferências --}}
                        <div class="tab-pane fade" id="preferences" role="tabpanel">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <h5 class="text-success"><i class="fas fa-bell me-2"></i>Notificações</h5>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="email_notifications" 
                                               name="email_notifications" {{ $user->settings['email_notifications'] ?? true ? 'checked' : '' }}>
                                        <label class="form-check-label" for="email_notifications">
                                            Receber notificações por e-mail
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="post_notifications" 
                                               name="post_notifications" {{ $user->settings['post_notifications'] ?? true ? 'checked' : '' }}>
                                        <label class="form-check-label" for="post_notifications">
                                            Notificar quando ONGs que sigo postarem
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="comment_notifications" 
                                               name="comment_notifications" {{ $user->settings['comment_notifications'] ?? true ? 'checked' : '' }}>
                                        <label class="form-check-label" for="comment_notifications">
                                            Notificar quando alguém comentar em posts que comentei
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <h5 class="text-success mt-3"><i class="fas fa-globe me-2"></i>Privacidade</h5>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="show_email" 
                                               name="show_email" {{ $user->settings['show_email'] ?? false ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_email">
                                            Mostrar meu e-mail no perfil público
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="show_phone" 
                                               name="show_phone" {{ $user->settings['show_phone'] ?? false ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_phone">
                                            Mostrar meu telefone no perfil público
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="show_birth_date" 
                                               name="show_birth_date" {{ $user->settings['show_birth_date'] ?? false ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_birth_date">
                                            Mostrar minha data de nascimento no perfil público
                                        </label>
                                    </div>
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

{{-- Modal de exclusão --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Excluir Conta
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Atenção!</strong> Esta ação é irreversível. Todos os seus dados serão permanentemente excluídos.
                </div>
                
                <p>Para confirmar a exclusão da sua conta, digite sua senha abaixo:</p>
                
                <form id="deleteForm" method="POST" action="{{ route('regular.profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Sua senha:
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="delete_password" 
                               name="password" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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

@push('styles')
<style>
    .nav-tabs .nav-link {
        color: #495057;
        font-weight: 500;
        border: none;
        padding: 0.75rem 1.25rem;
    }
    
    .nav-tabs .nav-link.active {
        color: #28a745;
        background-color: transparent;
        border-bottom: 3px solid #28a745;
    }
    
    .nav-tabs .nav-link:hover {
        border-bottom: 3px solid #dee2e6;
    }
    
    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
    
    #avatar-preview img {
        border: 3px solid #28a745;
        padding: 3px;
    }
</style>
@endpush

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

// Validação de senha em tempo real
document.getElementById('new_password').addEventListener('keyup', function() {
    const password = this.value;
    const confirmField = document.getElementById('new_password_confirmation');
    const strengthDiv = document.getElementById('password-strength');
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');
    
    if (password.length > 0) {
        strengthDiv.style.display = 'block';
        
        // Calcular força da senha
        let strength = 0;
        let feedback = '';
        
        if (password.length >= 8) strength += 25;
        if (password.match(/[a-z]+/)) strength += 25;
        if (password.match(/[A-Z]+/)) strength += 25;
        if (password.match(/[0-9]+/)) strength += 15;
        if (password.match(/[$@#&!]+/)) strength += 10;
        
        strengthBar.style.width = strength + '%';
        
        if (strength < 30) {
            strengthBar.className = 'progress-bar bg-danger';
            feedback = 'Senha fraca';
        } else if (strength < 60) {
            strengthBar.className = 'progress-bar bg-warning';
            feedback = 'Senha média';
        } else if (strength < 80) {
            strengthBar.className = 'progress-bar bg-info';
            feedback = 'Senha boa';
        } else {
            strengthBar.className = 'progress-bar bg-success';
            feedback = 'Senha forte';
        }
        
        strengthText.textContent = feedback;
        
        // Validar confirmação
        if (confirmField.value && password !== confirmField.value) {
            confirmField.classList.add('is-invalid');
        } else {
            confirmField.classList.remove('is-invalid');
        }
    } else {
        strengthDiv.style.display = 'none';
    }
});

document.getElementById('new_password_confirmation').addEventListener('keyup', function() {
    const password = document.getElementById('new_password').value;
    const confirm = this.value;
    
    if (password !== confirm) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
});

// Máscara para CPF
document.getElementById('cpf').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        e.target.value = value;
    }
});

// Máscara para telefone
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        if (value.length > 2) {
            value = '(' + value.substring(0,2) + ') ' + value.substring(2);
        }
        if (value.length > 10) {
            value = value.substring(0,10) + '-' + value.substring(10);
        }
        e.target.value = value;
    }
});
</script>
@endpush
@endsection