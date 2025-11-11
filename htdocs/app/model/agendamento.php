<?php
require_once '../lib/Database.php'; // ou o caminho certo da sua classe de conexão

class Agendamento {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection(); // OK agora que é estático
    }

    public function listarPorCliente($clienteId) {
        $stmt = $this->conn->prepare("SELECT * FROM agendamentos WHERE cliente_id = ?");
        $stmt->execute([$clienteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}