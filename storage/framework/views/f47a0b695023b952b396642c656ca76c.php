<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Código de Verificação</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 500px; margin: 30px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: #28a745; padding: 20px; text-align: center; color: #fff; }
        .content { padding: 30px; text-align: center; }
        .code { font-size: 32px; font-weight: bold; color: #28a745; letter-spacing: 5px; background: #f8f9fa; padding: 15px; border-radius: 8px; display: inline-block; margin: 20px 0; }
        .footer { background: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #666; }
        .warning { color: #dc3545; font-size: 12px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>🔐 Código de Verificação</h2>
        </div>
        <div class="content">
            <p>Olá, <strong><?php echo e($userName); ?></strong>!</p>
            <p>Utilize o código abaixo para completar seu login:</p>
            <div class="code"><?php echo e($code); ?></div>
            <p>Este código é válido por <strong>7 dias</strong> e pode ser usado apenas uma vez.</p>
            <p class="warning">⚠️ Se você não solicitou este código, ignore este e-mail.</p>
        </div>
        <div class="footer">
            <p>© <?php echo e(date('Y')); ?> Rede Social de ONGs - Todos os direitos reservados</p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\47808487848\Herd\redesocialweb\resources\views/emails/two-factor-code.blade.php ENDPATH**/ ?>