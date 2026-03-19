<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONG · Cadastro institucional</title>
    <!-- Bootstrap 5 + ícones + fonte Inter (mesmo estilo) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite(['resources/css/registerong.css'])
</head>

<body>

    <div class="card-split">
        <!-- LADO ESQUERDO: painel azul com apelo institucional -->
        <div class="brand-panel">
            <h2> "Transforme seu propósito em ação. Cadastre sua ONG e faça a diferença."</h2>
        </div>

        <!-- LADO DIREITO: formulário completo de cadastro da ONG -->
        <div class="form-panel">
            <h3>Cadastre sua ONG</h3>
            <div class="subtitle">Faça parte da nossa rede de organizações</div>

            <form method="POST" action="{{ route('ong.register') }}" enctype="multipart/form-data">
                @csrf

                <!-- DADOS DO RESPONSÁVEL -->
                <h5>DADOS DO RESPONSÁVEL</h5>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label for="responsible_name" class="form-label">NOME COMPLETO</label>
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

                <!-- DADOS DA ONG -->
                <h5>DADOS DA ONG</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="ong_name" class="form-label">NOME DA ONG</label>
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
                        <label for="cnpj" class="form-label">CNPJ</label>
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
                        <label for="description" class="form-label">DESCRIÇÃO</label>
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

                    <div class="col-md-6">
                        <label for="address" class="form-label">ENDEREÇO</label>
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
                        <label for="logo" class="form-label">LOGO DA ONG</label>
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

                <!-- CREDENCIAIS DE ACESSO -->
                <h5>CREDENCIAIS DE ACESSO</h5>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label for="email" class="form-label">E-MAIL INSTITUCIONAL</label>
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
                        <label for="password" class="form-label">SENHA</label>
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
                        <label for="password_confirmation" class="form-label">CONFIRMAR SENHA</label>
                        <input type="password"
                            class="form-control"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Digite a senha novamente"
                            required>
                    </div>
                </div>

                <!-- TERMOS -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="terms" required>
                    <label class="form-check-label small" for="terms">
                        Concordo com os <a href="#" class="bottom-link">Termos de Uso</a> e
                        <a href="#" class="bottom-link">Política de Privacidade</a>
                    </label>
                </div>

                <!-- BOTÃO CADASTRAR -->
                <button type="submit" class="btn-cadastrar-ong">
                    <i class="fas fa-check-circle me-2"></i>Cadastrar ONG
                </button>

                <!-- LINK RÁPIDO PARA LOGIN -->
                <p class="text-center text-muted small mt-4 mb-0">
                    Já tem uma conta institucional?
                    <a href="{{ route('ong.login') }}" class="bottom-link">Fazer login</a>
                </p>

                <div class="mt-3">
                    <a href="{{ route('choose.role') }}" class="text-muted small text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- scripts de preview e validação (adaptados do original) -->
    <script>
        // Preview da logo
        document.getElementById('logo')?.addEventListener('change', function(e) {
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

        // Validação simples de senha (visual)
        document.getElementById('password')?.addEventListener('keyup', function() {
            const password = this.value;
            if (password.length < 8 && password.length > 0) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });

        document.getElementById('password_confirmation')?.addEventListener('keyup', function() {
            const password = document.getElementById('password').value;
            const confirm = this.value;

            if (password !== confirm && confirm.length > 0) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>