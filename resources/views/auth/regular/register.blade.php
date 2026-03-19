@extends('layouts.app')

@section('title', 'Cadastro - Usuário')

@section('content')
<div class="row justify-content-center fade-in">
    <div class="col-md-10 col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white text-center py-4 border-0">
                <div class="mb-3">
                    <div class="rounded-circle bg-light d-inline-flex p-3">
                        <i class="fas fa-user-plus fa-3x" style="color: var(--primary-green);"></i>
                    </div>
                </div>
                <h4 class="mb-1 fw-bold">Criar nova conta</h4>
                <p class="text-muted small">Preencha os dados para se cadastrar</p>
            </div>

            <div class="card-body px-4 py-3">
                <form method="POST" action="{{ route('regular.register') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label text-muted small fw-semibold">NOME COMPLETO</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Seu nome completo"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
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

                        <div class="col-md-6">
                            <label for="cpf" class="form-label text-muted small fw-semibold">CPF</label>
                            <input type="text" 
                                   class="form-control @error('cpf') is-invalid @enderror" 
                                   id="cpf" 
                                   name="cpf" 
                                   value="{{ old('cpf') }}"
                                   placeholder="000.000.000-00">
                            @error('cpf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="birth_date" class="form-label text-muted small fw-semibold">DATA DE NASCIMENTO</label>
                            <input type="date" 
                                   class="form-control @error('birth_date') is-invalid @enderror" 
                                   id="birth_date" 
                                   name="birth_date" 
                                   value="{{ old('birth_date') }}">
                            @error('birth_date')
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
                            <label for="avatar" class="form-label text-muted small fw-semibold">FOTO DE PERFIL</label>
                            <input type="file" 
                                   class="form-control @error('avatar') is-invalid @enderror" 
                                   id="avatar" 
                                   name="avatar">
                            <small class="text-muted">Opcional</small>
                            @error('avatar')
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

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success py-2">
                            <i class="fas fa-check-circle me-2"></i>Criar conta
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-white text-center py-4 border-0">
                <p class="mb-2 text-muted small">Já tem uma conta?</p>
                <a href="{{ route('regular.login') }}" class="btn btn-outline-success px-4">
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