
# Sistema de Agendamento de Serviços Técnicos

Sistema web desenvolvido para gerenciar o agendamento de serviços técnicos, permitindo o controle de clientes, serviços, técnicos e agendamentos em um ambiente simples e intuitivo.

---

# Objetivo do Projeto

O objetivo deste sistema é facilitar o gerenciamento de atendimentos técnicos, permitindo que empresas organizem melhor seus serviços, acompanhem o status dos atendimentos e mantenham o controle das informações relacionadas aos clientes e técnicos.

---

# Funcionalidades

## Autenticação
- Cadastro de usuários
- Login com verificação de senha criptografada
- Controle de acesso por perfil (Administrador e Técnico)
- Bloqueio de login para usuários desativados

---

## Administração de Usuários
- Criar usuários técnicos
- Editar usuários
- Desativar técnicos (soft delete)
- Reativar técnicos
- Bloqueio de exclusão caso existam agendamentos vinculados

---

## Gestão de Clientes
- Criar clientes
- Editar clientes
- Excluir clientes
- Cadastro de:
  - Nome
  - Telefone
  - Email

---

## Gestão de Serviços
- Criar serviços
- Editar serviços
- Excluir serviços

---

## Gestão de Agendamentos
- Criar agendamentos
- Editar agendamentos
- Excluir agendamentos
- Definir status do atendimento

Status possíveis:
- Não feito
- Em andamento
- Feito

---

# Tecnologias Utilizadas

## Backend
- PHP

## Frontend
- HTML5
- CSS3

## Banco de Dados
- MySQL

## Servidor
- Apache (XAMPP)

---

# Arquitetura do Sistema

O sistema segue uma arquitetura web simples baseada em três camadas:

Apresentação  
HTML + CSS

Aplicação  
PHP

Persistência de Dados  
MySQL

---

# Estrutura do Projeto

```
agendamento_tecnico
│
├── conexao
│   ├── conexao.php
│   └── autorizacao.php
│
├── public
│   ├── login.php
│   ├── registro.php
│   ├── tela_inicial.php
│   │
│   ├── usuarios
│   │   ├── usuarios.php
│   │   └── usuario_editar.php
│   │
│   ├── clientes
│   │   ├── clientes.php
│   │   ├── cliente_criar.php
│   │   └── cliente_editar.php
│   │
│   ├── servicos
│   │   ├── servicos.php
│   │   ├── servico_criar.php
│   │   └── servico_editar.php
│   │
│   └── agendamentos
│       ├── agendamentos.php
│       ├── agendamento_criar.php
│       └── agendamento_editar.php
│
├── style
│   ├── login.css
│   ├── usuarios.css
│   └── agendamentos.css
│
└── README.md
```

---

# Segurança Implementada

- Senhas armazenadas com `password_hash()`
- Verificação de senha com `password_verify()`
- Prepared Statements com PDO
- Controle de sessão com `$_SESSION`
- Controle de acesso por perfil de usuário

---

# Requisitos do Sistema

Para executar o sistema é necessário:

- PHP 7.4 ou superior
- MySQL ou MariaDB
- Apache
- XAMPP ou similar

---

# Como Executar o Projeto

1. Clone o repositório

```
git clone https://github.com/seuusuario/agendamento_tecnico.git
```

2. Copie a pasta para o diretório do servidor

Exemplo no XAMPP:

```
htdocs/agendamento_tecnico
```

3. Crie o banco de dados no MySQL

  Os comandos de criação do banco de dados estão dentro do arquivo Bancodados.txt .

4. Crie o usuário administrador.

Execute na url o seguinte caminho:

```
localhost/agendamento_tecnico/scripts/criar_admin.php
```
Caso apareça a seguinte mensagem: "Administrador criado com sucesso! 🚀", o usuário admin foi criado.

6. Acesse no navegador

```
http://localhost/agendamento_tecnico
```
---

# Autor

Projeto desenvolvido como sistema de estudo e prática em desenvolvimento web utilizando PHP e MySQL.
