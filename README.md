# Cadastro de Eventos

Este projeto é uma API Rest em JSON para cadastro de events, utilizando PHP com Laravel, implementação de services, injeção de dependências e DTO.

## Tecnologias Utilizadas

- **PHP e Laravel**: Amplamente utilizados para o desenvolvimento backend moderno.
- **Mysql**: Sistema de gerenciamento de banco de dados relacional.
- **Swagger**: Para documentação automática da API.

## Iniciando com Laravel

### Inicie seu Banco de dados Mysql

```sh
docker compose -f docker-composer.yaml up -d
```

### 1. Instale as Dependências

```sh
composer install
```

### 2. Configure o Arquivo .env

### 3. Gere a Chave de Aplicação Única

```sh
php artisan key:generate
```

### 4. Rode as Migrations

```sh
php artisan migrate
```

### 5. Inicie seu Servidor

```sh
php artisan serve
```

### Teste suas Rotas em rest.http com swagger em localhost:8000/api/documentation
