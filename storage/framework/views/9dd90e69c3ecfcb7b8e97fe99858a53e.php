<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Esqueci a senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container" style="max-width:540px;margin-top:40px;">
        <h3>Esqueci a senha</h3>
        <p>Informe o e-mail da sua conta e enviaremos um código para redefinir a senha.</p>

        <div id="alert"></div>

        <form id="forgotForm">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" id="email" class="form-control" required>
            </div>
            <button class="btn btn-primary" type="submit">Enviar código</button>
            <a href="<?php echo e(route('password.reset.code')); ?>" class="btn btn-link">Já tenho o código</a>
        </form>
    </div>

    <script>
    document.getElementById('forgotForm').addEventListener('submit', async function(e){
        e.preventDefault();
        const email = document.getElementById('email').value;
        const alertBox = document.getElementById('alert');
        alertBox.innerHTML = '';

        try {
            const res = await fetch('/api/password/forgot', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({email})
            });
            const json = await res.json();
            alertBox.innerHTML = '<div class="alert alert-success">' + (json.message || 'Seus passos foram enviados por e-mail.') + '</div>';
        } catch (err) {
            alertBox.innerHTML = '<div class="alert alert-danger">Erro ao enviar. Tente novamente.</div>';
        }
    });
    </script>
</body>
</html>
<?php /**PATH C:\Users\47808487848\Herd\redesocialweb\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>