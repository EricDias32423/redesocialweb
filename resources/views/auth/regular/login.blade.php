<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login · Crie sua conta</title>
    <!-- Bootstrap 5 + ícones + fonte Inter -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite(['resources/css/login.css'])
</head>

<body>

    <div class="card-split">
        <!-- LADO ESQUERDO: "CRIA SUA CONTA" (exatamente como a imagem) -->
        <div class="brand-panel">
            <h2>"Venha para a nossa rede social e apoie sua ONG com todo coração."</h2>
        </div>

        <!-- LADO DIREITO: login funcional (Bem-vindo de volta / formulário) 
         mantenho exatamente como estava, apenas refinando alinhamentos -->
        <div class="form-panel">
            <h3>Bem-vindo de volta</h3>

            <form method="POST" action="{{ route('regular.login') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                    <label for="email">E-mail</label>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-2">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Senha" required>
                    <label for="password">Senha</label>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-row">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label small text-secondary" for="remember">Lembrar-me</label>
                    </div>
                    <a href="#" class="link-password">Esqueceu a senha?</a>
                </div>

                <button type="submit" class="btn-entrar">
                    <i class="fas fa-arrow-right-to-bracket me-2"></i>ENTRAR
                </button>

                <!-- link rápido "Ainda não tem conta?" (sutil) -->
                <p class="text-center text-muted small mt-4 mb-0">
                    Ainda não tem uma conta?
                    <a href="{{ route('regular.register') }}" class="text-decoration-none fw-semibold" style="color: var(--primary-green);">Criar conta</a>
                </p>

                <div class="mt-3">
                    <a href="{{ route('choose.role') }}" class="text-muted small text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- (opcional) Bootstrap JS para controle de floating labels, etc -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>