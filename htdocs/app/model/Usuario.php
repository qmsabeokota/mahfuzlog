<?php
require_once '../lib/Database.php';

class Usuario {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function autenticar($email, $senha) {
        $sql = "SELECT * FROM clientes WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente && password_verify($senha, $cliente['senha'])) {
            return $cliente;
        }

        return false;
    }

    public function cadastrar($dados) {
        $sql = "INSERT INTO clientes (
                    tipo, nome, cpf_cnpj, email, senha,
                    telefone, endereco, bairro, cidade, estado, cep
                ) VALUES (
                    :tipo, :nome, :cpf_cnpj, :email, :senha,
                    :telefone, :endereco, :bairro, :cidade, :estado, :cep
                )";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':tipo'     => $dados['tipo'],
            ':nome'     => $dados['nome'],
            ':cpf_cnpj' => $dados['cpf_cnpj'],
            ':email'    => $dados['email'],
            ':senha'    => $dados['senha'], // deve vir com hash
            ':telefone' => $dados['telefone'],
            ':endereco' => $dados['endereco'],
            ':bairro'   => $dados['bairro'],
            ':cidade'   => $dados['cidade'],
            ':estado'   => $dados['estado'],
            ':cep'      => $dados['cep']
        ]);
    }

    public function atualizar($id, $dados) {
        $sql = "UPDATE clientes SET 
                    tipo = :tipo,
                    nome = :nome,
                    cpf_cnpj = :cpf_cnpj,
                    email = :email,
                    telefone = :telefone,
                    endereco = :endereco,
                    bairro = :bairro,
                    cidade = :cidade,
                    estado = :estado,
                    cep = :cep
                    " . (isset($dados['senha']) ? ", senha = :senha" : "") . "
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        // Montar array de parâmetros
        $params = [
            ':tipo'     => $dados['tipo'],
            ':nome'     => $dados['nome'],
            ':cpf_cnpj' => $dados['cpf_cnpj'],
            ':email'    => $dados['email'],
            ':telefone' => $dados['telefone'],
            ':endereco' => $dados['endereco'],
            ':bairro'   => $dados['bairro'],
            ':cidade'   => $dados['cidade'],
            ':estado'   => $dados['estado'],
            ':cep'      => $dados['cep'],
            ':id'       => $id
        ];

        if (isset($dados['senha'])) {
            $params[':senha'] = $dados['senha']; // já deve estar com hash
        }

        return $stmt->execute($params);
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM clientes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
