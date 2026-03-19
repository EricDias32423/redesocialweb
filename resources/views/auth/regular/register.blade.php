<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro · Crie sua conta</title>
    <!-- Bootstrap 5 + ícones + fonte Inter (mesmo estilo do login) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite(['resources/css/register.css'])
</head>

<body>

    <div class="card-split">
        <!-- LADO ESQUERDO: mesmo visual da tela de login, mas com indicação de cadastro -->
        <div class="brand-panel">
            <h2>"Venha para a nossa rede social e apoie sua ONG com todo coração."</h2>
        </div>

        <!-- LADO DIREITO: formulário de registro completo (igual ao seu, mas com padding e labels refinados) -->
        <div class="form-panel">
            <h3>Criar nova conta</h3>
            <div class="subtitle">Preencha os dados para se cadastrar</div>

            <form method="POST" action="{{ route('regular.register') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <!-- Nome completo -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">NOME COMPLETO</label>
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

                    <!-- E-mail -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">E-MAIL</label>
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

                    <!-- CPF -->
                    <div class="col-md-6">
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

                    <!-- Data de nascimento -->
                    <div class="col-md-6">
                        <label for="birth_date" class="form-label">DATA DE NASCIMENTO</label>
                        <input type="date"
                            class="form-control @error('birth_date') is-invalid @enderror"
                            id="birth_date"
                            name="birth_date"
                            value="{{ old('birth_date') }}">
                        @error('birth_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Telefone -->
                    <div class="col-md-6">
                        <label for="phone" class="form-label">TELEFONE</label>
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

                    <!-- Foto de perfil -->
                    <div class="col-md-6">
                        <label for="avatar" class="form-label">FOTO DE PERFIL</label>
                        <input type="file"
                            class="form-control @error('avatar') is-invalid @enderror"
                            id="avatar"
                            name="avatar">
                        <small class="text-muted small-note">Opcional</small>
                        @error('avatar')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Senha -->
                    <div class="col-md-6">
                        <label for="password" class="form-label">SENHA</label>
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

                    <!-- Confirmar senha -->
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">CONFIRMAR SENHA</label>
                        <input type="password"
                            class="form-control"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Digite a senha novamente"
                            required>
                    </div>
                </div>

                <!-- Botão criar conta (verde, arredondado) -->
                <button type="submit" class="btn-registrar">
                    <i class="fas fa-check-circle me-2"></i>Criar conta
                </button>

                <!-- Link rápido para login (canto inferior direito) -->
                <p class="text-center text-muted small mt-4 mb-0">
                    Já tem uma conta?
                    <a href="{{ route('regular.login') }}" class="bottom-link">Fazer login</a>
                </p>

                <div class="mt-3">
                    <a href="{{ route('choose.role') }}" class="text-muted small text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (opcional para alguns componentes) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>