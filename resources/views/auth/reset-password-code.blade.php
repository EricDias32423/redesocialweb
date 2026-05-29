<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Redefinir senha com código</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container" style="max-width:540px;margin-top:40px;">
        <h3>Redefinir senha</h3>
        <p>Informe seu e-mail, o código recebido e a nova senha.</p>

        <div id="alert"></div>

        <form id="resetForm">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">Código (6 dígitos)</label>
                <input type="text" id="code" class="form-control" maxlength="6" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nova senha</label>
                <input type="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar senha</label>
                <input type="password" id="password_confirmation" class="form-control" required>
            </div>
            <button class="btn btn-primary" type="submit">Redefinir senha</button>
            <a href="{{ route('password.request') }}" class="btn btn-link">Enviar novo código</a>
        </form>
    </div>

    <script>
    document.getElementById('resetForm').addEventListener('submit', async function(e){
        e.preventDefault();
        const payload = {
            email: document.getElementById('email').value,
            code: document.getElementById('code').value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('password_confirmation').value,
        };
        const alertBox = document.getElementById('alert');
        alertBox.innerHTML = '';

        try {
            const res = await fetch('/api/password/reset-code', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(payload)
            });
            const json = await res.json();
            if (res.ok) {
                alertBox.innerHTML = '<div class="alert alert-success">' + (json.message || 'Senha alterada com sucesso.') + '</div>';
                setTimeout(function(){
                    window.location.href = '{{ route("choose.role") }}';
                }, 1200);
            } else {
                alertBox.innerHTML = '<div class="alert alert-danger">' + (json.message || 'Erro: verifique os campos.') + '</div>';
            }
        } catch (err) {
            alertBox.innerHTML = '<div class="alert alert-danger">Erro ao enviar. Tente novamente.</div>';
        }
    });
    </script>
</body>
</html>
