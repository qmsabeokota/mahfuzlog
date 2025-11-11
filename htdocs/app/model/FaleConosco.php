<?php
require_once '../lib/Database.php';

class FaleConosco {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function enviarMensagem($dados) {
        $sql = "INSERT INTO fale_conosco (
                    assunto, tipo_cliente, cpf_cnpj, empresa, contato,
                    celular, telefone, email, mensagem
                ) VALUES (
                    :assunto, :tipo_cliente, :cpf_cnpj, :empresa, :contato,
                    :celular, :telefone, :email, :mensagem
                )";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':assunto' => $dados['assunto'],
            ':tipo_cliente' => $dados['tipo_cliente'],
            ':cpf_cnpj' => $dados['cpf_cnpj'],
            ':empresa' => $dados['empresa'],
            ':contato' => $dados['contato'],
            ':celular' => $dados['celular'],
            ':telefone' => $dados['telefone'],
            ':email' => $dados['email'],
            ':mensagem' => $dados['mensagem']
        ]);
    }
}
?>
