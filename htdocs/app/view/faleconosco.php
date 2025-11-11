<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fale Conosco - Mahfuz Log</title>
  <link rel="stylesheet" href="../public/css/faleconosco.css">
</head>
<body>
<header>
        <img src="../public/img/logo.jpg" alt="Mahfuz Log" class="logo">
        <nav id="mobile-menu">
            <ul  class="menu">
                <li><a href="../view/areacliente.php">ÁREA DO CLIENTE</a></li>
                <li><a href="../view/Cotacao.php">COTAÇÃO</a></li>
                <li><a href="../view/homepage.php">PÁGINA INICIAL</a></li>
            </ul>
        </nav>
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

  <main>
    <h1>Sua opinião é importante! Envie suas sugestões, críticas e elogios.</h1>
    <p>A Mahfuz Log se importa com seus clientes e tem uma equipe preparada para ajudar no que for preciso.</p>

    <form class="form-container" action="../controller/FaleConoscoController.php" method="post">
      <label for="assunto">Assunto</label>
      <input type="text" name="assunto" required>

      <div class="row">
        <div>
          <label for="tipo_cliente">Tipo de Cliente</label>
          <input type="text" name="tipo_cliente" required>
        </div>
        <div>
          <label for="cpf_cnpj">CPF/CNPJ</label>
          <input type="text" name="cpf_cnpj" required>
        </div>
      </div>

      <label for="empresa">Nome da Empresa</label>
      <input type="text" name="empresa" required>

      <label for="contato">Nome de Contato</label>
      <input type="text" name="contato" required>

      <div class="row">
        <div>
          <label for="celular">Celular</label>
          <input type="text" name="celular" required>
        </div>
        <div>
          <label for="telefone">Telefone (Opcional)</label>
          <input type="text" name="telefone">
        </div>
      </div>

      <label for="email">E-mail</label>
      <input type="email" name="email" required>

      <label for="mensagem">Escreva um breve texto da sua solicitação</label>
      <textarea name="mensagem" rows="5" required></textarea>

      <button type="submit">ENVIAR</button>
    </form>
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
  document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.getElementById('hamburger');
    const menu = document.getElementById('mobile-menu');

    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('active');
      menu.classList.toggle('active');
    });
  });
</script>
</body>
</html>
