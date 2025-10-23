# 🚀 Sistema de Gerenciamento de Pedidos

Sistema completo de gerenciamento de pedidos desenvolvido em Laravel 12 com funcionalidades de CRUD, logging automático e cancelamento de pedidos pendentes.

## 🛠️ Instalação

### Pré-requisitos

-   PHP 8.2+
-   Composer
-   MySQL 8.0+
-   Git

### Passo a Passo

1. **Clone o repositório**

    ```bash
    git clone <url-do-repositorio>
    cd teste-accenture
    ```

2. **Instale as dependências**

    ```bash
    composer install
    ```

3. **Configure o ambiente**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configure o banco de dados no arquivo `.env`**

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=accenture
    DB_USERNAME=seu_usuario
    DB_PASSWORD=sua_senha
    ```

5. **Execute as migrações com seeders**

    ```bash
    php artisan migrate --seed
    ```

    > **Nota**: As migrações incluem as tabelas necessárias para o sistema de jobs (`jobs`, `failed_jobs`, `job_batches`)

6. **Inicie o servidor**

    ```bash
    php artisan serve
    ```

7. **Acesse o sistema**

    Abra seu navegador em: `http://localhost:8000`

## 🎨 Funcionalidades

### 📊 Dashboard

-   Estatísticas
-   Cards informativos (clientes, produtos, pedidos)
-   Gráficos (CDN apexcharts)
-   Últimos pedidos

### 👥 Gestão de Clientes

-   ✅ CRUD completo
-   ✅ Busca
-   ✅ Ativar/desativar clientes
-   ✅ Validações de email único

### 📦 Gestão de Produtos

-   ✅ CRUD completo
-   ✅ Upload de imagens
-   ✅ Gestão de estoque automática
-   ✅ Categorias e preços

### 🛒 Gestão de Pedidos

-   ✅ CRUD completo
-   ✅ Cálculos automáticos
-   ✅ Controle de estoque
-   ✅ Status: Pendente, Pago, Cancelado

### 💰 Pedidos Pagos

-   ✅ Visualização de pedidos pagos
-   ✅ Busca
-   ✅ Detalhes completos

### 📝 Sistema de Logs

-   ✅ Logging automático de todas as ações
-   ✅ Filtros por ação, data e descrição
-   ✅ Estatísticas por tipo de ação
-   ✅ Interface responsiva

## ⏰ Job/Cron Automático

Sistema que cancela automaticamente pedidos pendentes há mais de 7 dias.

### Execução Manual

```bash
# Modo teste (não altera dados)
php artisan pedidos:cancelar-pendentes --dry-run

# Execução real
php artisan pedidos:cancelar-pendentes
```

### Execução Automática

```bash
# Configurar cron no servidor
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

### Configuração de Jobs

Para que os jobs funcionem corretamente, certifique-se de que:

1. **As tabelas de jobs foram criadas** (incluídas nas migrações):

    - `jobs` - Fila de jobs pendentes
    - `failed_jobs` - Jobs que falharam
    - `job_batches` - Lotes de jobs

2. **Configure o driver de queue no `.env`**:

    ```env
    QUEUE_CONNECTION=database
    ```

3. **Execute o worker de jobs**:
    ```bash
    php artisan queue:work
    ```

## 🛠️ Tecnologias

-   **Backend**: Laravel 12, PHP 8.2+, MySQL 8.0
-   **Frontend**: Blade Templates, Tabler UI, Boxicons
-   **Ferramentas**: Composer, Artisan CLI

## ⏱️ Desenvolvimento

**Tempo total: 15 horas**

-   Setup e Configuração: 2h
-   Sistema de Logging: 3h
-   CRUD Completo: 4h
-   Job/Cron Automático: 3h
-   Interface e UX: 2h
-   Testes e Refinamentos: 1h

---
