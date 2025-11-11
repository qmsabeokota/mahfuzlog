-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS sistema_cadastro;
USE sistema_cadastro;

-- Tabela de clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(2) NOT NULL,
    nome VARCHAR(255) NOT NULL,
    cpf_cnpj VARCHAR(25) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    endereco TEXT NOT NULL,
    bairro VARCHAR(255) NOT NULL,
    cidade VARCHAR(255) NOT NULL,
    estado VARCHAR(2) NOT NULL,
    cep VARCHAR(15) NOT NULL
);

-- Tabela de entregadores
CREATE TABLE IF NOT EXISTS entregadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cpf_cnpj VARCHAR(25) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    cidade VARCHAR(100),
    estado VARCHAR(2)
);

-- Tabela de cotações
CREATE TABLE IF NOT EXISTS cotacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    remetente VARCHAR(100),
    cliente_remetente VARCHAR(100),
    endereco_remetente TEXT,
    destinatario VARCHAR(100),
    cliente_destinatario VARCHAR(100),
    endereco_destinatario TEXT,
    tomador VARCHAR(100),
    endereco_tomador TEXT,
    pagamento ENUM('pix', 'cartao') NOT NULL,
    mercadoria VARCHAR(100),
    largura DECIMAL(10,2),
    altura DECIMAL(10,2),
    comprimento DECIMAL(10,2),
    volume DECIMAL(10,2),
    peso DECIMAL(10,2),
    observacoes TEXT,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Em análise', 'Aprovado', 'Cancelado', 'Pendente') DEFAULT 'Em análise',
    valor_frete DECIMAL(10,2) NOT NULL,
    data_cotacao DATETIME NOT NULL,
    CONSTRAINT fk_cliente_cotacao FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

CREATE INDEX idx_cliente_cotacao ON cotacoes(cliente_id);

-- Tabela de agendamentos
CREATE TABLE IF NOT EXISTS agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    remetente VARCHAR(100),
    cliente_remetente VARCHAR(100),
    endereco_remetente TEXT,
    destinatario VARCHAR(100),
    cliente_destinatario VARCHAR(100),
    endereco_destinatario TEXT,
    tomador VARCHAR(100),
    endereco_tomador TEXT,
    pagamento ENUM('pix', 'cartao') NOT NULL,
    mercadoria VARCHAR(100),
    largura DECIMAL(10,2),
    altura DECIMAL(10,2),
    comprimento DECIMAL(10,2),
    volume DECIMAL(10,2),
    peso DECIMAL(10,2),
    observacoes TEXT,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Em análise', 'Aprovado', 'Cancelado', 'Pendente', 'Agendado') DEFAULT 'Em análise',
    valor_frete DECIMAL(10,2) NOT NULL,
    data_cotacao DATETIME NOT NULL,
    data_entrega_estimanda DATETIME DEFAULT NULL,
    CONSTRAINT fk_cliente_agendamento FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

CREATE INDEX idx_cliente_agendamento ON agendamentos(cliente_id);

-- Tabela fale conosco
CREATE TABLE IF NOT EXISTS fale_conosco (
    id INT AUTO_INCREMENT PRIMARY KEY,
    assunto VARCHAR(100) NOT NULL,
    tipo_cliente VARCHAR(50) NOT NULL,
    cpf_cnpj VARCHAR(25) NOT NULL,
    empresa VARCHAR(100) NOT NULL,
    contato VARCHAR(100) NOT NULL,
    celular VARCHAR(20) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100) NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela administradores
CREATE TABLE IF NOT EXISTS administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

-- Inserção de conta administrador padrão
INSERT INTO administradores (nome, email, senha)
VALUES (
    'Administrador Geral',
    'admin@empresa.com',
    '$2y$10$7oLXqg30/txarhd6E5qb2OrDmKAnBoL5z1KDPOQq9CMmtyuZe8Xu2'  -- senha: 123456
);

-- Inserção de entregador de exemplo (corrigido)
INSERT INTO entregadores (nome, cpf_cnpj, email, senha, telefone, cidade, estado)
VALUES (
    'Gustavo',
    '50604984847',
    'rocketoficiial@gmail.com',
    '$2y$10$7oLXqg30/txarhd6E5qb2OrDmKAnBoL5z1KDPOQq9CMmtyuZe8Xu2',  -- senha: 123456
    '11943181417',
    'São Paulo',
    'SP'
);
