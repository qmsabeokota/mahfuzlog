

<?php
require_once '../lib/Database.php';

class Cotacao {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function listarPorCliente($clienteId) {
        $sql = "SELECT * FROM cotacoes WHERE cliente_id = :cliente_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':cliente_id' => $clienteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function registrar($dados) {
        $sql = "INSERT INTO cotacoes (
            cliente_id, remetente, cliente_remetente, endereco_remetente,
            destinatario, cliente_destinatario, endereco_destinatario,
            tomador, endereco_tomador, pagamento,
            mercadoria, largura, altura, comprimento, volume, peso, observacoes,
            valor_frete, data_cotacao, status
        ) VALUES (
            :cliente_id, :remetente, :cliente_remetente, :endereco_remetente,
            :destinatario, :cliente_destinatario, :endereco_destinatario,
            :tomador, :endereco_tomador, :pagamento,
            :mercadoria, :largura, :altura, :comprimento, :volume, :peso, :observacoes,
            :valor_frete, NOW(), :status
        )";
        $stmt = $this->conn->prepare($sql);
    
        // Define status padrão 'Em análise' caso não esteja no array $dados
        $status = isset($dados['status']) ? $dados['status'] : 'Em análise';
    
        $stmt->execute([
            ':cliente_id' => $dados['cliente_id'],
            ':remetente' => $dados['remetente'],
            ':cliente_remetente' => $dados['cliente_remetente'],
            ':endereco_remetente' => $dados['endereco_remetente'],
            ':destinatario' => $dados['destinatario'],
            ':cliente_destinatario' => $dados['cliente_destinatario'],
            ':endereco_destinatario' => $dados['endereco_destinatario'],
            ':tomador' => $dados['tomador'],
            ':endereco_tomador' => $dados['endereco_tomador'],
            ':pagamento' => $dados['pagamento'],
            ':mercadoria' => $dados['mercadoria'],
            ':largura' => $dados['largura'],
            ':altura' => $dados['altura'],
            ':comprimento' => $dados['comprimento'],
            ':volume' => $dados['volume'],
            ':peso' => $dados['peso'],  // Certifique que a chave é 'peso' no array
            ':observacoes' => $dados['observacoes'],
            ':valor_frete' => $dados['valor_frete'],
            ':status' => $status
        ]);
    
        return $this->conn->lastInsertId();
    }
    
}
?>
