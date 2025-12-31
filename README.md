# SaaS Market

Este projeto é um sistema web desenvolvido como parte dos requisitos para a graduação no curso de **Sistemas de Informação** da **Universidade Federal de Viçosa (UFV)**.

O sistema foi projetado para atuar como uma plataforma de gestão empresarial (SaaS - Software as a Service), oferecendo funcionalidades para controle de vendas, fornecedores, orçamentos e muito mais.

## 🎓 Contexto Acadêmico

Desenvolvido por **Matheus Rocha Vieira**, este projeto demonstra a aplicação prática de conhecimentos adquiridos durante a graduação, incluindo:
- Arquitetura de Software (MVC)
- Desenvolvimento Web (PHP, HTML, CSS, JavaScript)
- Banco de Dados
- Segurança da Informação

## 🚀 Funcionalidades

O sistema conta com diversos módulos para gestão completa:

- **Painel Administrativo (Admin)**: Gerenciamento de usuários, backups e configurações do sistema.
- **Gestão de Usuários**: Cadastro, edição, controle de acesso e permissões.
- **Vendas e Pedidos (Orders)**: Controle de pedidos realizados.
- **Contas (Bills)**: Gestão financeira de contas a pagar/receber.
- **Orçamentos (Budgets)**: Criação e acompanhamento de orçamentos.
- **Produtos e Fornecedores (Products & Suppliers)**: Cadastro e gestão de estoque e parceiros comerciais.
- **Tarefas (Jobs/Todo)**: Sistema de acompanhamento de tarefas.
- **Arquivos (Files/Downloads)**: Gerenciamento de arquivos e downloads.
- **Relatórios de Erros (Bugs)**: Monitoramento de falhas no sistema.

## 📂 Estrutura do Projeto

Abaixo está a estrutura de diretórios do projeto, gerada com o comando `tree`. O projeto segue o padrão arquitetural **MVC (Model-View-Controller)** de forma personalizada.

```
.
├── LICENSE
├── LICENSE.md
├── Procfile
├── README.md
├── _installation
│   ├── homestead_bills.sql
│   ├── homestead_blocked_ips.sql
│   ├── homestead_budgets.sql
│   ├── homestead_failed_logins.sql
│   ├── homestead_files.sql
│   ├── homestead_forgotten_passwords.sql
│   ├── homestead_ip_failed_logins.sql
│   ├── homestead_jobs.sql
│   ├── homestead_notifications.sql
│   ├── homestead_orders.sql
│   ├── homestead_products.sql
│   ├── homestead_suppliers.sql
│   ├── homestead_todo.sql
│   ├── homestead_users.sql
│   └── script.sql
├── app
│   ├── backups
│   ├── config
│   │   ├── config.php
│   │   └── javascript.php
│   ├── controllers
│   │   ├── AdminController.php
│   │   ├── BillsController.php
│   │   ├── BudgetsController.php
│   │   ├── DownloadsController.php
│   │   ├── ErrorsController.php
│   │   ├── FilesController.php
│   │   ├── JobsController.php
│   │   ├── LoginController.php
│   │   ├── OrdersController.php
│   │   ├── ProductsController.php
│   │   ├── SuppliersController.php
│   │   └── UserController.php
│   ├── core
│   │   ├── App.php
│   │   ├── Component.php
│   │   ├── Config.php
│   │   ├── Controller.php
│   │   ├── Cookie.php
│   │   ├── Email.php
│   │   ├── Encryption.php
│   │   ├── Environment.php
│   │   ├── Handler.php
│   │   ├── Logger.php
│   │   ├── Redirector.php
│   │   ├── Request.php
│   │   ├── Response.php
│   │   ├── Session.php
│   │   ├── View.php
│   │   └── components
│   │       ├── AuthComponent.php
│   │       └── SecurityComponent.php
│   ├── logs
│   │   └── log.txt
│   ├── models
│   │   ├── Admin.php
│   │   ├── Bills.php
│   │   ├── Budgets.php
│   │   ├── Database.php
│   │   ├── File.php
│   │   ├── Jobs.php
│   │   ├── Login.php
│   │   ├── Model.php
│   │   ├── Orders.php
│   │   ├── Pagination.php
│   │   ├── Permission.php
│   │   ├── Product.php
│   │   ├── Supplier.php
│   │   ├── Uploader.php
│   │   ├── User.php
│   │   └── Validation.php
│   ├── uploads
│   ├── utility
│   │   └── Utility.php
│   └── views
│       ├── admin
│       │   ├── backups.php
│       │   └── users
│       │       ├── index.php
│       │       ├── users.php
│       │       └── viewUser.php
│       ├── alerts
│       │   ├── errors.php
│       │   └── success.php
│       ├── bills
│       │   ├── index.php
│       │   ├── orders.php
│       │   └── updateForm.php
│       ├── budgets
│       │   ├── budgets.php
│       │   ├── index.php
│       │   └── updateForm.php
│       ├── bugs
│       │   └── index.php
│       ├── dashboard
│       │   ├── index.php
│       │   └── updates.php
│       ├── errors
│       │   ├── 400.php
│       │   ├── 401.php
│       │   ├── 403.php
│       │   ├── 404.php
│       │   └── 500.php
│       ├── files
│       │   ├── files.php
│       │   └── index.php
│       ├── jobs
│       │   ├── index.php
│       │   ├── orders.php
│       │   └── updateForm.php
│       ├── layout
│       │   ├── default
│       │   │   ├── footer.php
│       │   │   ├── header.php
│       │   │   └── navigation.php
│       │   ├── errors
│       │   │   ├── footer.php
│       │   │   └── header.php
│       │   └── login
│       │       ├── footer.php
│       │       └── header.php
│       ├── login
│       │   ├── index.php
│       │   ├── passwordUpdated.php
│       │   ├── updatePassword.php
│       │   └── userVerified.php
│       ├── orders
│       │   ├── index.php
│       │   ├── orders.php
│       │   └── updateForm.php
│       ├── pagination
│       │   ├── default.php
│       │   └── products.php
│       ├── suppliers
│       │   ├── index.php
│       │   ├── newSupplier.php
│       │   ├── productUpdateForm.php
│       │   ├── products.php
│       │   ├── supplier.php
│       │   ├── supplierUpdateForm.php
│       │   ├── suppliers.php
│       │   └── viewSupplier.php
│       └── user
│           └── profile.php
├── composer.json
├── composer.lock
└── public
    ├── browserconfig.xml
    ├── css
    │   ├── compressor.min.css
    │   ├── font-awesome.min.css
    │   └── fonts
    │       ├── FontAwesome.otf
    │       ├── fontawesome-webfont.eot
    │       ├── fontawesome-webfont.svg
    │       ├── fontawesome-webfont.ttf
    │       └── fontawesome-webfont.woff
    ├── humans.txt
    ├── img
    │   ├── backgrounds
    │   │   └── BoletoBradesco_29062018_185241.pdf
    │   ├── icons
    │   │   ├── android-chrome-192x192.png
    │   │   ├── android-chrome-512x512.png
    │   │   ├── apple-touch-icon-114x114.png
    │   │   ├── apple-touch-icon-120x120.png
    │   │   ├── apple-touch-icon-144x144.png
    │   │   ├── apple-touch-icon-152x152.png
    │   │   ├── apple-touch-icon-180x180.png
    │   │   ├── apple-touch-icon-57x57.png
    │   │   ├── apple-touch-icon-60x60.png
    │   │   ├── apple-touch-icon-72x72.png
    │   │   ├── apple-touch-icon-76x76.png
    │   │   ├── apple-touch-icon.png
    │   │   ├── favicon-16x16.png
    │   │   ├── favicon-32x32.png
    │   │   ├── favicon.ico
    │   │   ├── logo.svg
    │   │   ├── mstile-144x144.png
    │   │   ├── mstile-150x150.png
    │   │   └── safari-pinned-tab.svg
    │   └── profile_pictures
    │       ├── 6b86b273ff34fce19d6b804eff5a3f5747ada4ea.jpeg
    │       └── default.png
    ├── index.php
    ├── js
    │   ├── compressor.min.js
    │   ├── jquery.min.js
    │   └── main.js
    └── site.webmanifest
```

## 🛠️ Instalação e Configuração

Para rodar este projeto localmente, siga os passos abaixo:

1.  **Clone o repositório:**
    ```bash
    git clone https://github.com/matheusrv/saas-market.git
    cd saas-market
    ```

2.  **Instale as dependências:**
    Certifique-se de ter o Composer instalado.
    ```bash
    composer install
    ```

3.  **Configure o Banco de Dados:**
    - Crie um banco de dados MySQL.
    - Importe os scripts SQL localizados na pasta `_installation/` para estruturar o banco de dados.

4.  **Configuração da Aplicação:**
    - Verifique e edite o arquivo `app/config/config.php` para ajustar as credenciais do banco de dados e outras configurações de ambiente (URL, paths, etc.).

5.  **Execução:**
    - Aponte seu servidor web (Apache/Nginx) para a pasta `public/` ou utilize o servidor embutido do PHP para testes:
    ```bash
    php -S localhost:8000 -t public
    ```

## 👨‍💻 Autor

**Matheus Rocha Vieira**
*   Email: matheusrv@email.com
*   Curso: Sistemas de Informação - UFV

---
*Este projeto é apenas para fins educacionais e de demonstração.*
