@extends('layouts.app')

@section('title', 'Cadastro - Usuário')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg">
            <div class="card-header bg-success text-white text-center py-3">
                <h4 class="mb-0">
                    <i class="fas fa-user-plus me-2"></i>Cadastro - Usuário Comum
                </h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('regular.register') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nome Completo</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
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

                        <div class="col-md-6 mb-3">
                            <label for="cpf" class="form-label">CPF</label>
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

                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label">Data de Nascimento</label>
                            <input type="date" 
                                   class="form-control @error('birth_date') is-invalid @enderror" 
                                   id="birth_date" 
                                   name="birth_date" 
                                   value="{{ old('birth_date') }}">
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Telefone</label>
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

                        <div class="col-md-6 mb-3">
                            <label for="avatar" class="form-label">Foto de Perfil</label>
                            <input type="file" 
                                   class="form-control @error('avatar') is-invalid @enderror" 
                                   id="avatar" 
                                   name="avatar">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
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

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle me-2"></i>Cadastrar
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p class="mb-2">Já tem uma conta?</p>
                    <a href="{{ route('regular.login') }}" class="btn btn-outline-success">
                        <i class="fas fa-sign-in-alt me-2"></i>Fazer login
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