CREATE DATABASE restaurante;

USE restaurante;

-- Tabela de Usuários
CREATE TABLE tb_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    data_nascimento DATE,
    telefone VARCHAR(20),
    senha VARCHAR(255) NOT NULL,
    cep VARCHAR(10),
    rua VARCHAR(255),
    numero VARCHAR(10),
    bairro VARCHAR(100),
    complemento VARCHAR(100),
    cidade VARCHAR(100),
    estado CHAR(2)
);

-- Dados de exemplo para tb_usuario
INSERT INTO tb_usuario (nome, email, data_nascimento, telefone, senha, cep, rua, numero, bairro, complemento, cidade, estado)
VALUES 
('João Silva', 'joao@gmail.com', '1990-05-12', '11987654321', PASSWORD('123456'), '01000-000', 'Rua A', '123', 'Centro', '', 'São Paulo', 'SP'),
('Maria Oliveira', 'maria@gmail.com', '1985-09-22', '11912345678', PASSWORD('abcdef'), '02000-000', 'Rua B', '456', 'Vila Nova', '', 'Rio de Janeiro', 'RJ');

-- Tabela de Categorias
CREATE TABLE tb_categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL
);

-- Dados de exemplo para tb_categoria
INSERT INTO tb_categoria (nome)
VALUES 
('Entradas'), ('Pratos Principais'), ('Bebidas'), ('Sobremesas');

-- Tabela de Itens do Cardápio
CREATE TABLE tb_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idCategoria INT,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    foto BLOB,
    preco DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (idCategoria) REFERENCES tb_categoria(id)
);

-- Dados de exemplo para tb_itens
INSERT INTO tb_itens (idCategoria, nome, descricao, preco)
VALUES 
(1, 'Bruschetta', 'Pão italiano com tomates frescos e manjericão.', 15.00),
(2, 'Lasanha', 'Lasanha tradicional com molho à bolonhesa.', 30.00),
(3, 'Refrigerante', 'Lata de refrigerante gelado.', 5.00),
(4, 'Tiramisu', 'Sobremesa italiana com café e mascarpone.', 20.00);

-- Tabela de Itens do Pedido
CREATE TABLE tb_itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idUsuario INT,
    idItem INT,
    quantidade INT NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    finalizado BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (idUsuario) REFERENCES tb_usuario(id),
    FOREIGN KEY (idItem) REFERENCES tb_itens(id)
);


