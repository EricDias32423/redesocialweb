📌 Sobre o projeto

API RESTful desenvolvida em Laravel para gerenciar uma rede social de ONGs, fornecendo endpoints para autenticação, cadastro de usuários, posts, comentários e curtidas.
🎯 Objetivo (MVP)

    Cadastro de dois tipos de usuários (ONGs e Usuários Comuns)

    Autenticação via token (Laravel Sanctum)

    CRUD de posts (apenas ONGs)

    Sistema de curtidas e comentários

    Relacionamento entre ONGs e apoiadores

    Dashboard com estatísticas para ONGs

🚀 Tecnologias utilizadas

    PHP 8.2.12

    Laravel 12.54.1

    MySQL / MariaDB

    Laravel Sanctum (autenticação via token)

    Laravel CORS

    Composer

📦 Estrutura do Banco de Dados

    Principais tabelas

    Tabela	                   Descrição

regular_users              Usuários comuns da plataforma
ongs                       Organizações (ONGs)
posts                      Publicações criadas pelas ONGs
comments                   Comentários (polimórfico: usuários e ONGs)
likes                      Curtidas (polimórfico)
ong_user                   Relacionamento ONG × Usuário (apoiadores)




Relacionamentos
    ongs (1) ─── (N) posts
    posts (1) ─── (N) comments
    posts (1) ─── (N) likes
    regular_users (N) ─── (N) ongs (através de ong_user)


⚙️ Instalação e configuração
    Pré-requisitos

    PHP >= 8.2

    Composer

    MySQL ou MariaDB



Passos para instalação
 No bash
    # Clonar repositório
git clone https://github.com/EricDias32423/redesocialweb.git
cd ongs-backend

# Instalar dependências
composer install

# Copiar arquivo de ambiente
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate

# Configurar banco de dados no .env
# DB_DATABASE=rede_social_ongs
# DB_USERNAME=root
# DB_PASSWORD=

# Executar migrations
php artisan migrate

# Criar link simbólico para armazenamento
php artisan storage:link

# Iniciar servidor
php artisan serve --host=0.0.0.0 --port=8000




🔒 Autenticação : A API utiliza Laravel Sanctum para autenticação via token.




✅ Códigos de Resposta
Código  	Significado
200         	OK
201     	Created (recurso criado)
401     	Unauthorized (não autenticado)
403     	Forbidden (sem permissão)
404     	Not Found
422	        Unprocessable Entity (erro de validação)
500	        Internal Server Error







Autores
Eric Luciano M. Dias
Guilherme de Oliveira Pinheiro