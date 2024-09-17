<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://www.febacapital.com/images/og.png" height="100px">
    </a>
    <h1 align="center">Teste Backend PHP</h1>
    <br>
</p>

O Yii 2 Basic Project Template é um aplicativo esqueleto do [Yii 2](https://www.yiiframework.com/), ideal para criar pequenos projetos rapidamente.

Esta documentação descreve as APIs disponíveis para gerenciamento de clientes e livros com suas repectivas regras de negócio desacoplatada da CONTROLLER. Todas as APIs são protegidas por JWT (JSON Web Token) e requerem um token Bearer para autenticação.

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![build](https://github.com/yiisoft/yii2-app-basic/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-basic/actions?query=workflow%3Abuild)

## REQUISITOS

Para rodar o projeto na máquina será necessário ter instalado:

-   PHP 7.4+
-   Composer 2+
-   Docker

## INSTALAÇÃO

1. Clone o repositório:

    ```bash
    git clone https://github.com/Jogaridu/jorge_febacapital.git

    cd jorge_febacapital
    ```

2. Instale as dependências

    ```bash
    composer install
    ```

3. Configure o arquivo `.env` com suas variáveis de ambiente:
    ```
    DB_DSN=mysql:host=localhost;dbname=seu_banco_de_dados
    DB_USERNAME=seu_usuario
    DB_PASSWORD=sua_senha
    JWT_SECRET=sua_chave_secreta
    ```
4. Suba os containers para rodar o projeto

    ```bash
    docker-compose up -d
    ```

5. Conecte via terminal no container PHP
    ```bash
    docker exec -it [ID DO CONTAINER] bash
    ```
6. Execute as migrações do banco de dados:
    ```bash
    yii migrate
    ```

## Autenticação

Todas as requisições às APIs devem incluir um token `JWT` no cabeçalho Authorization.

### Comandos

1. Conecte via terminal no container PHP

    ```bash
    docker exec -it [ID DO CONTAINER] bash
    ```

2. Criar um usuário

    ```bash
    $ yii user/create [USUARIO] [SENHA] [NOME]

    Usuário criado com sucesso.
    ```

3. Logar

    ```bash
    $ auth/login [USUARIO] [SENHA]

    Token:

    [SEU TOKEN]

    Refresh token:

    [SEU REFRESH TOKEN]
    ```

4. Renovar o token de autenticação

    ```bash
    $ auth/refresh [USUARIO] [SENHA]

    Token:

    [SEU TOKEN]

    Refresh token:

    [SEU REFRESH TOKEN]
    ```

## CONSUMO DE API

### Cliente

#### Cadastrar

-   URL: `/clients`
-   Método: `POST`
-   Headers:
    `Authorization: Bearer seu_token_jwt`
-   Body:
    ```json
    {
        "name": "Nome",
        "cpf": "21548666033",
        "postal_code": "44444444",
        "address": "Teste",
        "number": "10",
        "city": "São Paulo",
        "complement": "Casa 101",
        "gender": "M"
    }
    ```
-   Resposta
    ```json
    {
        "status": "success",
        "message": "Cliente cadastrado com sucesso",
        "data": {
            "name": "Nome",
            "image": null,
            "cpf": "21548666033",
            "postal_code": "44444444",
            "address": "Rua teste",
            "number": "10",
            "city": "Jandira",
            "state": "SP",
            "complement": "123",
            "gender": "M",
            "created_at": "2024-09-17 11:00:03",
            "updated_at": "2024-09-17 11:00:03",
            "id": 1
        }
    }
    ```

#### Listar

-   URL: `/clients`
-   Método: `GET`
-   Headers:
    `Authorization: Bearer seu_token_jwt`
-   Resposta
    ```json
    {
        "status": "success",
        "message": "Dados recuperados com sucesso",
        "data": [
            {
                "id": 1,
                "name": "Nome",
                "cpf": "21548666033",
                "postal_code": "44444444",
                "address": "Rua teste",
                "number": "10",
                "city": "São Paulo",
                "state": "SP",
                "complement": "",
                "gender": "M",
                "image": null,
                "created_at": "2024-09-17 11:00:03",
                "updated_at": "2024-09-17 11:00:03"
            }
        ]
    }
    ```

### Livro

#### Cadastrar

-   URL: `/books`
-   Método: `POST`
-   Headers:
    `Authorization: Bearer seu_token_jwt`
-   Body:
    ```json
    {
        "isbn": "978-85-333-0227-3",
        "price": "10.5",
        "quantity": "10"
    }
    ```
-   Resposta
    ```json
    {
        "status": "success",
        "message": "Livro cadastrado com sucesso",
        "data": {
            "isbn": "978-85-333-0227-3",
            "title": "A Queda De Uma Estrela",
            "author": "Alexandre Luiz Demarchi E Thiago Siviero",
            "price": "10.5",
            "quantity": "10",
            "id": 1
        }
    }
    ```

#### Listar

-   URL: `/books`
-   Método: `GET`
-   Headers:
    `Authorization: Bearer seu_token_jwt`
-   Resposta
    ```json
    {
        "status": "success",
        "message": "Dados recuperados com sucesso",
        "data": [
            {
                "id": 1,
                "isbn": "978-85-333-0227-3",
                "title": "A Queda De Uma Estrela",
                "author": "Alexandre Luiz Demarchi E Thiago Siviero",
                "price": "10.50",
                "quantity": 10,
                "created_at": "2024-09-17 21:53:55",
                "updated_at": "2024-09-17 21:53:55"
            }
        ]
    }
    ```
