<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../public/css/login.css">
</head>
<body>
    <header>
        <img src="../public/img/logo.jpg" alt="Mahfuz Log" class="logo">
        <nav id="mobile-menu">
            <ul class="menu">
                <li><a href="areacliente.php">ÁREA DO CLIENTE</a></li>
                <li><a href="faleconosco.php">FALE CONOSCO</a></li>
                <li><a href="homepage.php">PÁGINA INICIAL</a></li>
            </ul>
        </nav>
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>
    
    <main class="login-container">
        
            <div class="form-box">
                <h2 class="titulo">LOGIN</h2>
                <form action="../controller/LoginController.php" method="POST">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" required>

                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" required>

                    <button type="submit">Faça seu login!</button>
                    <!-- <button class = "cadastro" type="submit"><a href="cadastro.php">Cadastrar</a></button> -->
                    <a href="cadastro.php" class="botao-cadastro">Cadastrar</a>
                </form>
            </div>
           <div class="imagem-caminhao">
               <!--  <img src="../public/img/caminhaologin2.png" alt="Imagem Caminhão">-->
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
