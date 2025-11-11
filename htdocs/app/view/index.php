<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <title>MahfuzLog</title>
</head>
<body>

<header>
    <img src="../public/img/logo.jpg" alt="Mahfuz Log" class="logo">
    <nav id="mobile-menu">
        <ul class="menu">
            <li><a href="areacliente.php">Área do Cliente</a></li>
            <li><a href="faleconosco.php">Fale Conosco</a></li>
            <li><a href="areacliente.php">Login</a></li>
        </ul>
    </nav>
     <div class="hamburger" id="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </div>
</header>

<div class="banner">
    <img src="../public/img/banner.png" alt="Banner">
    <button class="cotar-frete" onclick="window.location.href='cotacaobasica.php'" >Simular frete</button>
</div>
        <section class="infos">
        <div>
            <div class="icone">⚡</div>
            <h3>Rapidez</h3>
            <p>Entregamos com agilidade para garantir sua satisfação.</p>
        </div>
        <div>
            <div class="icone">🔒</div>
            <h3>Segurança</h3>
            <p>Seus produtos são transportados com total segurança.</p>
        </div>
        <div>
            <div class="icone">📦</div>
            <h3>Rastreamento</h3>
            <p>Acompanhe sua entrega em tempo real com nosso sistema.</p>
        </div>
    </section>

        
    
     <section class="passo-a-passo">
    <h2>Como funciona</h2>
    <div class="etapas">
        <div class="etapa">
            <div class="icone">📝</div>
            <p>Simule</p>
        </div>
        <div class="etapa">
            <div class="icone">👤</div>
            <p>Cadastre-se</p>
        </div>
        <div class="etapa">
            <div class="icone">💰</div>
            <p>Cotação</p>
        </div>
        <div class="etapa">
            <div class="icone">📅</div>
            <p>Agende</p>
        </div>
    </div>
</section>


        
  <section class="depoimentos">
    <h2>O que dizem sobre nós</h2>
    <div class="cards-depoimentos">
        <div class="card-depoimento">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Cliente 1">
            <h3>Ana Silva</h3>
            <p class="cargo">Empresária</p>
            <p class="texto">"O serviço foi impecável! Agilidade e segurança que superaram minhas expectativas. Recomendo fortemente!"</p>
        </div>
        <div class="card-depoimento">
            <img src="https://randomuser.me/api/portraits/men/46.jpg" alt="Cliente 2">
            <h3>Lucas Ferreira</h3>
            <p class="cargo">Autônomo</p>
            <p class="texto">"Nunca foi tão fácil e rápido organizar meus fretes. Profissionalismo em cada detalhe."</p>
        </div>
        <div class="card-depoimento">
            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Cliente 3">
            <h3>Mariana Costa</h3>
            <p class="cargo">Gerente de Logística</p>
            <p class="texto">"O sistema revolucionou nossa operação. Atendimento ágil, sistema intuitivo e preços justos."</p>
        </div>
    </div>
</section>


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


<div id="form-cotacao" style="display:none;">
    <form action="cotar.php" method="POST">
        <input type="text" name="origem" placeholder="Origem" required>
        <input type="text" name="destino" placeholder="Destino" required>
        <input type="submit" value="Enviar">
    </form>
</div>

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
