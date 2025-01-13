# Skeleton Laravel 11 Project

## 📝 Descrição

Este projeto é um **Skeleton** desenvolvido utilizando o framework **Laravel 11**, seguindo os princípios do **SOLID** para garantir flexibilidade, manutenibilidade e escalabilidade. Além disso, utiliza o padrão **Service Repository**, promovendo uma separação clara entre as responsabilidades de acesso aos dados e lógica de negócios.

## 🌟 Funcionalidades Principais

- Estrutura modular e organizada.
- Padrão Service Repository para um código limpo e reutilizável.
- Autenticação obrigatória para acesso às rotas protegidas.
- Proteção de rotas por perfis e permissões.

## ⚙️ Requisitos

- **PHP**: Versão 8.1 ou superior
- **Composer**: Para gerenciar dependências
- **SQLite/MySQL/PostgreSQL**: Banco de dados para persistência
- **Laravel Sail**: Para facilitar o ambiente de desenvolvimento

## 📂 Estrutura do Projeto

```plaintext
├── app
│   ├── Constants
│   │   └── Constants.php
│   ├── Enums
│   │   ├── ActiveRoleUser.php
│   ├── Exceptions
│   │   └── Handler.php
│   ├── Helpers
│   │   └── ImageHelper.php
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── Api
│   │   │   │   └── V1
│   │   │   │       ├── Assessment
│   │   │   │       │   └── AssessmentController.php
│   │   │   │       ├── Auth
│   │   │   │       │   └── AuthController.php
│   │   │   │       ├── CrudController.php
│   │   │   │       ├── Permission
│   │   │   │       │   └── PermissionController.php
│   │   │   │       ├── Role
│   │   │   │       │   └── RoleController.php
│   │   │   │       ├── Traits
│   │   │   │       │   ├── CrudController.php
│   │   │   │       │   ├── ExceptionResponse.php
│   │   │   │       │   └── HasForm.php
│   │   │   │       └── User
│   │   │   │           └── UserController.php
│   │   │   └── Controller.php
│   │   ├── Requests
│   │   │   ├── Api
│   │   │   │   └── V1
│   │   │   │       ├── Assessment
│   │   │   │       │   └── AssessmentRequest.php
│   │   │   │       ├── Permission
│   │   │   │       │   ├── PermissionRequest.php
│   │   │   │       │   └── PermissionSyncRequest.php
│   │   │   │       ├── Role
│   │   │   │       │   └── RoleRequest.php
│   │   │   │       └── User
│   │   │   │           └── UserFormRequest.php
│   │   │   ├── CrudRequest.php
│   │   │   └── FormRequest.php
│   │   └── Resources
│   │       └── User
│   │           ├── UserListResource.php
│   │           └── UserResource.php
│   ├── Models
│   │   ├── Assessment.php
│   │   └── User.php
│   ├── Providers
│   │   └── AppServiceProvider.php
│   ├── Repositories
│   │   ├── Api
│   │   │   └── V1
│   │   │       ├── Assessment
│   │   │       │   └── AssessmentRepository.php
│   │   │       ├── Permission
│   │   │       │   └── PermissionRepository.php
│   │   │       ├── Role
│   │   │       │   └── RoleRepository.php
│   │   │       └── User
│   │   │           └── UserRepository.php
│   │   └── BaseRepository.php
│   └── Services
│       └── Api
│           └── V1
│               └── Upload
│                   └── ImageUploaderService.php
├── database
│   ├── database.sqlite
│   ├── factories
│   │   └── UserFactory.php
│   ├── migrations
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2025_01_10_172816_create_permission_tables.php
│   │   ├── 2025_01_10_175743_create_audits_table.php
│   │   ├── 2025_01_10_210557_create_personal_access_tokens_table.php
│   │   ├── 2025_01_10_223705_add_collumn_title_to_roles.php
│   │   └── 2025_01_11_143819_create_assessments_table.php
│   └── seeders
│       ├── DatabaseSeeder.php
│       ├── RolesAndPermissionsSeeder.php
│       └── UserSeeder.php
├── dev-setup.sh
├── routes
│   ├── api.php
│   ├── assessment
│   │   └── routes.php
│   ├── auth
│   │   └── routes.php
│   ├── console.php
│   ├── unauth
│   │   └── routes.php
│   ├── user
│   │   └── routes.php
│   └── web.php
``` 

Obs: O arquivo `.env` deve ser copiado do `.env.example`.

## 🚀 Começando

Essas instruções permitirão que você obtenha uma cópia do projeto em operação na sua máquina local para fins de desenvolvimento e teste.

### 📋 Pré-requisitos

Para instalar o software, você precisa ter o Docker instalado na sua máquina. Caso ainda não tenha o Docker, siga a documentação oficial para instalá-lo:

[Docker - Documentação Oficial](https://docs.docker.com/get-docker/)

### 🔧 Instalação

Este projeto utiliza o Docker juntamente com o utilitário do Laravel (Sail), portanto, não é necessário instalar nada além do Docker na sua máquina.

Para instalar as dependências, abra o terminal na pasta do projeto e execute o seguinte comando:

```
./dev-setup.sh
```

Aguarde até que todas as dependências sejam instaladas.

### 🔩 Executando o projeto

Para iniciar o projeto, execute os seguintes comandos:

1. Inicie o ambiente com Docker:
   ```
   ./vendor/bin/sail up -d
   ```

2. Execute as migrações para configurar o banco de dados:
   ```
   ./vendor/bin/sail artisan migrate
   ```

### 🌱 Rodando Seeders

Para preencher o banco de dados com informações de exemplo, execute os seguintes comandos:

```
./vendor/bin/sail artisan db:seed --class=DatabaseSeeder
```

## 🔒 Autenticação

Para acessar as rotas protegidas, é necessário realizar login utilizando as credenciais adequadas. Exemplo de requisição:

**POST**: `http://localhost:8080/api/auth/login`

### Request Body:
```json
{
    "email": "adm@skeleton.com",
    "password": "adm@skeleton"
}
```

### Exemplo de Resposta:
```json
{
    "accessToken": "1|nm9TPUjzfQpzFjwJeZCx4j3GhmCJ45mg8JK6DOId27fb7446",
    "user": {
        "id": 1,
        "external_id": "ac579656-d948-4511-9466-4b5b40b03a07",
        "name": "administrador",
        "email": "adm@educria.com",
        "phone": "99999999999",
        "cpf": "99999999999",
        "birth_date": "1990-01-02",
        "image": null,
        "active_role": "super_admin",
        "email_verified_at": null,
        "created_at": "2025-01-10T14:07:51.000000Z",
        "updated_at": "2025-01-10T14:07:51.000000Z",
        "deleted_at": null,
        "roles": {
            "super_admin": {
                "name": "super_admin",
                "permissions": [
                    "user_edit",
                    "user_list",
                    "user_create",
                    "user_delete",
                    "permission_edit",
                    "permission_list",
                    "permission_create",
                    "permission_delete",
                    "role_edit",
                    "role_list",
                    "role_create",
                    "role_delete",
                    "assessment_edit",
                    "assessment_list",
                    "assessment_create",
                    "assessment_delete"
                ]
            }
        }
    }
}
```


Agora você está pronto para começar a usar o Skeleton! 💀 😊
