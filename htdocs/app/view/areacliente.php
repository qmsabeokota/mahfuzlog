<?php

require_once '../controller/AreaClienteController.php';

if (!isset($_SESSION['cliente_id']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header('Location: login.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Área do Cliente - Mahfuz Log</title>
  <link rel="stylesheet" href="../public/css/style_cliente.css">
</head>
<body>
<header>
  <img src="../public/img/logo.jpg" alt="Mahfuz Log" class="logo">
  <nav id="mobile-menu">
    <ul class="menu">
      <li><a href="#">Olá, <?= htmlspecialchars($_SESSION['cliente_nome']) ?></a></li>
      <li><a href="homepage.php">PÁGINA INICIAL</a></li>
      <li><a href="logout.php">SAIR</a></li>
    </ul>
  </nav>
  <div class="hamburger" id="hamburger">
    <span></span>
    <span></span>
    <span></span>
  </div>
</header>

<main class="container">
  <h1>Bem-vindo, <?php echo $_SESSION['cliente_nome'] ?? 'Cliente'; ?>!</h1>

  <div class="actions">
    <h2>Histórico de Cotações</h2>
    <a class="btn" href="cotacao.php">Nova Cotação</a>
      <?php if ($cotacoes): ?>
        <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>Data</th>
          <th>Remetente</th>
          <th>Destinatário</th>
          <th>Pagamento</th>
          <th>Mercadoria</th>
          <th>Status</th>
          <th>Valor</th>
          <th>Efetuar</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cotacoes as $cotacao): ?>
        <tr>
          <td><?= date("d/m/Y", strtotime($cotacao['data'])) ?></td>
          <td><?= htmlspecialchars($cotacao['remetente']) ?></td>
          <td><?= htmlspecialchars($cotacao['destinatario']) ?></td>
          <td><?= htmlspecialchars($cotacao['pagamento']) ?></td>
          <td><?= htmlspecialchars($cotacao['mercadoria']) ?></td>
          <td><?= htmlspecialchars($cotacao['status']) ?></td>
          <td><?= htmlspecialchars($cotacao['valor_frete']) ?></td>
          
          <td>
      <form action="../controller/PagamentoController.php" method="post">
          <input type="hidden" name="metodo" value="mercadopago">
          <input type="hidden" name="cotacao_id" value="<?= $cotacao['id'] ?>">
          <button type="submit">PAMAGENTO</button>
      </form>
  </td>


            
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
      <p>Você ainda não realizou nenhuma cotação.</p>
    </div>
    <?php endif; ?>
  </div>

  <div class="actions">
    <h2>Agendamentos</h2>
    <?php if ($agendamentos): ?>
      <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>Data</th>
          <th>Remetente</th>
          <th>Destinatário</th>
          <th>Pagamento</th>
          <th>Mercadoria</th>
          <th>Status</th>
          <th>Valor</th>
          <th>previsão</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($agendamentos as $agendamento): ?>
        <tr>
          <td><?= date("d/m/Y", strtotime($agendamento['data'])) ?></td>
          <td><?= htmlspecialchars($agendamento['remetente']) ?></td>
          <td><?= htmlspecialchars($agendamento['destinatario']) ?></td>
          <td><?= htmlspecialchars($agendamento['pagamento']) ?></td>
          <td><?= htmlspecialchars($agendamento['mercadoria']) ?></td>
          <td><?= htmlspecialchars($agendamento['status']) ?></td>
          <td><?= htmlspecialchars($agendamento['valor_frete']) ?></td>
          <td><?= htmlspecialchars($agendamento['data_entrega_estimanda']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
      <p>Você ainda não possui agendamentos.</p>
    </div>
    <?php endif; ?>
  </div>

  
  

  <div class="card">
        <h2>⚙️ Meu Perfil</h2>
        <a class="btn" href="atualizar_cadastro.php">Atualizar Cadastro</a>
        <a class="btn" href="atualizar_cadastro.php">Alterar Senha</a>
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
