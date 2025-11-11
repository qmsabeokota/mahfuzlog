<?php
session_start();
require_once '../lib/Database.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$cotacoes = $conn->query("SELECT c.*, cl.nome AS cliente_nome FROM cotacoes c JOIN clientes cl ON c.cliente_id = cl.id")->fetchAll(PDO::FETCH_ASSOC);
$agendamentos = $conn->query("SELECT a.*, cl.nome AS cliente_nome FROM agendamentos a JOIN clientes cl ON a.cliente_id = cl.id ORDER BY a.data DESC")->fetchAll(PDO::FETCH_ASSOC);
$clientes = $conn->query("SELECT * FROM clientes")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Área do Cliente - Mahfuz Log</title>
    <link rel="stylesheet" href="dashboard.css">
    
</head>
<body>
    
<header>
    <img src="../public/img/logo.jpg" alt="Mahfuz Log" class="logo">
    <nav id="mobile-menu">
        <ul class="menu">
            <li><a href="#">Olá, Administrador!</a></li>
            <li><a href="../view/logout.php">SAIR</a></li>
        </ul>
    </nav>
    <div class="hamburger" id="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </div>
</header>

<main class="container">
  
  
<h2>Cotações</h2>
<div class="table-responsive">
<table>
    <tr>
        <th>ID</th><th>Cliente</th><th>Data</th><th>Status</th><th>Ações</th>
    </tr>
    
    <?php foreach ($cotacoes as $cot): ?>
    <tr>
        <td><?= $cot['id'] ?></td>
        <td><?= $cot['cliente_nome'] ?></td>
        <td><?= $cot['data_cotacao'] ?></td>
        <td><?= $cot['status'] ?></td>
        <td>
            <form method="post" action="atualizar_status.php">
                <input type="hidden" name="cotacao_id" value="<?= $cot['id'] ?>">
                <select name="novo_status">
                    <option value="Em análise" <?= $cot['status'] == 'Em análise' ? 'selected' : '' ?>>Em análise</option>
                    <option value="Aprovado" <?= $cot['status'] == 'Aprovado' ? 'selected' : '' ?>>Aprovado</option>
                    <option value="Rejeitado" <?= $cot['status'] == 'Rejeitado' ? 'selected' : '' ?>>Rejeitado</option>
                </select>                
                <button type="submit">Atualizar</button>
                <a href="deletar_cotacao.php?id=<?= $cot['id'] ?>" onclick="return confirm('Deseja excluir esta Cotação?')">Excluir</a>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</div>

<h2>Agendamentos</h2>
<div class="table-responsive">
<table >
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Remetente</th>
        <th>Destinatário</th>
        <th>Status</th>
        <th>Valor Frete</th>
        <th>Data Entrega Estimada</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($agendamentos as $ag): ?>
    <tr>
        <td><?= $ag['id'] ?></td>
        <td><?= $ag['cliente_nome'] ?></td>
        <td><?= htmlspecialchars($ag['remetente']) ?></td>
        <td><?= htmlspecialchars($ag['destinatario']) ?></td>
        <td><?= $ag['status'] ?></td>
        <td>R$ <?= number_format($ag['valor_frete'], 2, ',', '.') ?></td>
        <td><?= $ag['data_entrega_estimanda'] ? date('d/m/Y', strtotime($ag['data_entrega_estimanda'])) : '—' ?></td>
        <td>
            <form method="post" action="atualizar_status_agendamento.php">
                <input type="hidden" name="agendamento_id" value="<?= $ag['id'] ?>">
                <select name="novo_status">
                    <option value="Em análise" <?= $ag['status'] == 'Em análise' ? 'selected' : '' ?>>Em análise</option>
                    <option value="Aprovado" <?= $ag['status'] == 'Aprovado' ? 'selected' : '' ?>>Aprovado</option>
                    <option value="Cancelado" <?= $ag['status'] == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                    <option value="Agendado" <?= $ag['status'] == 'Agendado' ? 'selected' : '' ?>>Agendado</option>
                </select>
                <button type="submit">Atualizar</button>
                <a href="deletar_agendamento.php?id=<?= $ag['id'] ?>" onclick="return confirm('Deseja excluir este agendamento?')">Excluir</a>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</div>

<h2>Usuários</h2>
<div class="table-responsive">
<table>
    <tr>
        <th>ID</th><th>Nome</th><th>Email</th><th>Ações</th>
    </tr>
    <?php foreach ($clientes as $cli): ?>
    <tr>
        <td><?= $cli['id'] ?></td>
        <td><?= $cli['nome'] ?></td>
        <td><?= $cli['email'] ?></td>
        <td>
            <a href="editar_usuario.php?id=<?= $cli['id'] ?>">Editar</a> |
            <a href="deletar_usuario.php?id=<?= $cli['id'] ?>" onclick="return confirm('Deseja excluir este usuário?')">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
    </main>
    
<footer class="footer">
    <div class="footer-container">
        <div class="footer-logo">
            <img src="../public/img/logo.jpg" alt="Mahfuz Log" />
            <p>&copy; 2025 Mahfuz Log - Todos os direitos reservados</p>
        </div>
        <div class="footer-links">
            <h4>Links</h4>
            <ul>
                <li><a href="areacliente.php"><i class="fas fa-user"></i> Área do Cliente</a></li>
                <li><a href="faleconosco.php"><i class="fas fa-envelope"></i> Fale Conosco</a></li>
                <li><a href="cotacaobasica.php"><i class="fas fa-truck"></i> Simular Frete</a></li>
            </ul>
        </div>
        <div class="footer-social">
            <h4>Redes Sociais</h4>
            <ul>
                <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                <li><a href="#"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
            </ul>
        </div>
    </div>
</footer>
<script>
  const hamburger = document.getElementById('hamburger');
  const menu = document.getElementById('mobile-menu');

  hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    menu.classList.toggle('active');
  });
</script>
</body>
</html>
