# mahfuzlog
MahfuzLog - TCC SENAI JORGE MAHFUZ

# 📦 Sistema de Cotações - Flutter + PHP (MVC)

Este projeto é composto por **duas partes integradas**:
- **Frontend Mobile** desenvolvido em **Flutter** (`flutter_cotacoes`)
- **Backend/API** desenvolvido em **PHP** (`htdocs`), utilizando **arquitetura MVC**

O objetivo do sistema é gerenciar e acompanhar **cotações de serviços/produtos**, permitindo o cadastro, aprovação, atualização e listagem das cotações tanto via **aplicativo mobile** quanto via **painel administrativo web**.

---

## 🧭 Sumário

1. [Visão Geral](#visão-geral)
2. [Tecnologias Utilizadas](#tecnologias-utilizadas)
3. [Estrutura de Pastas](#estrutura-de-pastas)
4. [Configuração do Backend (PHP)](#configuração-do-backend-php)
5. [Configuração do Frontend (Flutter)](#configuração-do-frontend-flutter)
6. [Integração Flutter ↔ PHP](#integração-flutter--php)
7. [Erros Comuns](#erros-comuns)
8. [Contribuição](#contribuição)
9. [Licença](#licença)

---

## 🧩 Visão Geral

O sistema tem como principal objetivo centralizar e automatizar o processo de **cotações**.  
Usuários podem registrar novas solicitações, enquanto administradores podem aprovar, editar ou remover cotações através de um painel web.

A aplicação **Flutter** consome os endpoints do **backend PHP**, trocando dados via **requisições HTTP (JSON)**.

---

## 🛠 Tecnologias Utilizadas

### Backend
- **PHP 8+**
- **MySQL/MariaDB**
- **Arquitetura MVC**
- **APIs RESTful**
- **HTML, CSS, JavaScript (para o painel administrativo)**

### Frontend
- **Flutter 3.x+**
- **Dart**
- **HTTP Package** para integração com a API
- **Gerenciamento de estado** (provavelmente via `setState` ou `Provider`)

---

## 📁 Estrutura de Pastas

### Backend (`htdocs`)
```
htdocs/
 ├── api_cotacoes/            # Endpoints da API
 │   ├── cadastrar.php
 │   ├── listar_cotacoes.php
 │   ├── login.php
 │   └── ...
 ├── app/
 │   ├── admin/               # Painel administrativo
 │   ├── controller/          # Controladores PHP (MVC)
 │   └── model/               # (se existir) classes de modelo
 ├── conexao.php              # Configuração de conexão com o banco
 └── index.php
```

### Frontend (`flutter_cotacoes`)
```
flutter_cotacoes/
 ├── lib/
 │   ├── main.dart            # Ponto de entrada da aplicação
 │   ├── screens/             # Telas principais
 │   ├── services/            # Comunicação com a API PHP
 │   └── widgets/             # Componentes reutilizáveis
 ├── pubspec.yaml             # Dependências Flutter
 └── README.md
```

---

## ⚙️ Configuração do Backend (PHP)

### 1. Instalar ambiente local
Você pode usar **XAMPP**, **WAMP** ou **Laragon**:
- PHP 8.0 ou superior  
- MySQL ou MariaDB  

### 2. Configurar o projeto
1. Copie a pasta `htdocs/` para o diretório do seu servidor local:
   ```
   C:\xampp\htdocs\cotacoes\
   ```
2. Verifique o arquivo `conexao.php` e ajuste as credenciais:
   ```php
   <?php
   $conn = new mysqli("localhost", "root", "", "banco_cotacoes");
   if ($conn->connect_error) {
       die("Erro de conexão: " . $conn->connect_error);
   }
   ?>
   ```

### 3. Criar o banco de dados
No phpMyAdmin ou terminal MySQL:
```sql
CREATE DATABASE banco_cotacoes;
USE banco_cotacoes;
-- Crie as tabelas conforme as necessidades do projeto
```

### 4. Testar a API
Acesse no navegador:
```
http://localhost/cotacoes/api_cotacoes/listar_cotacoes.php
```
Se estiver tudo certo, deverá retornar um JSON.

---

## 📱 Configuração do Frontend (Flutter)

### 1. Pré-requisitos
- Flutter 3.x+  
- Dart SDK  
- Android Studio ou VS Code  

Verifique a instalação:
```bash
flutter doctor
```

### 2. Instalar dependências
Dentro da pasta do projeto:
```bash
cd flutter_cotacoes
flutter pub get
```

### 3. Configurar o endpoint da API
Procure no código (geralmente em `services/api_service.dart`):
```dart
const String baseUrl = "http://localhost/cotacoes/api_cotacoes/";
```
Se for rodar no **emulador Android**, altere `localhost` para:
```
http://10.0.2.2/cotacoes/api_cotacoes/
```
*(em dispositivos reais, use o IP local da máquina hospedeira).*

### 4. Executar o app
```bash
flutter run
```

---

## 🔗 Integração Flutter ↔ PHP

O app Flutter consome os endpoints PHP via requisições HTTP:
- `listar_cotacoes.php` → Listagem de cotações  
- `cadastrar_cotacao.php` → Cadastro de novas cotações  
- `login.php` → Autenticação de usuários  
- `atualizar_cotacao.php` → Atualização e aprovação  

Todas as respostas são enviadas em formato **JSON**.

---

## ⚠️ Erros Comuns

| Erro | Causa provável | Solução |
|------|----------------|----------|
| `Connection refused` | API PHP inacessível | Verifique se o servidor Apache está rodando e o IP está correto |
| `JSON parse error` | API retornando HTML (erro PHP) | Veja o log de erros do PHP |
| `Database connection failed` | Credenciais incorretas | Ajuste `conexao.php` |
| `Null data in Flutter` | Endpoint incorreto | Confirme a URL da API no app |

---

## 🤝 Contribuição

Sinta-se à vontade para contribuir!  
Sugestões de melhorias e correções são bem-vindas.

1. Faça um fork do repositório  
2. Crie uma branch: `git checkout -b feature/nova-funcionalidade`  
3. Commit suas alterações: `git commit -m 'Adiciona nova funcionalidade'`  
4. Faça um push: `git push origin feature/nova-funcionalidade`  
5. Abra um Pull Request 🎉

---

## 🪪 Licença

Este projeto é distribuído sob a **Mozilla Public License Version 2.0 (MPL-2.0)**.  
Você pode usá-lo, modificá-lo e redistribuí-lo livremente, desde que mantenha os avisos de copyright e disponibilize as alterações sob a mesma licença.

---

📘 **Autor:** Equipe MahfuzLog
📧 **Contato:** rocketoficiial@gmail.com  
📅 **Última atualização:** Novembro de 2025
