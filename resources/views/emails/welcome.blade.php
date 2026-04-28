<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #28a745;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .content h2 {
            color: #333;
            margin-top: 0;
        }
        .content p {
            color: #666;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌱 Rede Social de ONGs</h1>
        </div>
        
        <div class="content">
            <h2>Olá, {{ $user->name ?? $user->ong_name }}! 👋</h2>
            
            <p>Seja bem-vindo à nossa plataforma! Estamos muito felizes em ter você aqui.</p>
            
            @if($type == 'regular')
                <p>Agora você pode:</p>
                <ul>
                    <li>✅ Descobrir e apoiar ONGs incríveis</li>
                    <li>✅ Comentar e curtir posts</li>
                    <li>✅ Receber atualizações das causas que você apoia</li>
                </ul>
            @else
                <p>Agora sua ONG pode:</p>
                <ul>
                    <li>✅ Criar posts e compartilhar suas iniciativas</li>
                    <li>✅ Conectar-se com apoiadores</li>
                    <li>✅ Acompanhar estatísticas de engajamento</li>
                </ul>
            @endif
            
            <a href="{{ config('app.url') }}" class="button">Explorar a plataforma</a>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Rede Social de ONGs - Todos os direitos reservados</p>
            <p>Este e-mail foi enviado automaticamente, por favor não responda.</p>
        </div>
    </div>
</body>
</html>