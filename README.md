
## Clone o projeto do GitHub:

1. git clone git@github.com:fabiotmourao/finance.git

2. Entre no diretório do projeto:
    cd /none-do-projeto

## Inicie os serviços:

Subir os containers execute: 

-  docker compose -f "docker-compose.yml" up -d --build 


Execute o comando stop o serviços e start :

-  docker-compose stop
-  docker-compose start

## Instalação

1. Instale as dependências:
-  composer install e npm install

2. Crie um arquivo `.env` a partir do arquivo `.env.example`:
   cp .env.example .env

   Configure o banco de dados no arquivo `.env`:

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3308
        DB_DATABASE=
        DB_USERNAME=
        DB_PASSWORD=

3. Gere uma chave de aplicativo:
-  docker-compose exec app php artisan key:generate
    
    ou

-  sail artisan key:generate

4. Migre as tabelas do banco de dados:
-  docker-compose exec app php artisan migrate

    ou

-  sail artisan migrate


#### O aplicativo agora pode ser acessado no navegador em http://localhost:7000 


### O projeto usa as seguintes dependências:

* Laravel
* Docker 
* Bootstrap
