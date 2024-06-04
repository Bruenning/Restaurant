## Projeto para teste da Empresa Digiliza


## Comandos para executar:

```bash

# criar .env
$ cp .env.example .env

# Instale as dependências
$ npm install
$ composer install

# Execute as migrações
$ php artisan migrate --seed

# gerar chave
$ php artisan key:generate

#inicia o server
$ php artisan server

# Execute a aplicação em modo de desenvolvimento
$ npm run dev
