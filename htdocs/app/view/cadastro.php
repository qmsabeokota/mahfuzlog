<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../public/css/cadastro.css">
</head>
<body>
<header>
    <img src="../public/img/logo.jpg" alt="Mahfuz Log" class="logo">
    <nav>
        <ul class="menu">
            <li><a href="areacliente.php">ÁREA DO CLIENTE</a></li>
            <li><a href="faleconosco.php">FALE CONOSCO</a></li>
            <li><a href="homepage.php">PÁGINA INICIAL</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="titulo">
            <img class="prancheta" src="../public/img/prancheta.png" alt="Mahfuz Log" class="logo">

        <h2>Crie sua conta<br></br> para agendar entregas!</h2>
    </div>
    <div class="form-box">
        <form id="form" action="../controller/CadastroController.php" method="POST">
            <div class="radio-group">
                <label><input type="radio" id="tipo" name="tipo"> Pessoa juridica</label>
                <label><input type="radio"id="tipo" name="tipo"> Pessoa Física</label>
            </div>

            <div class="input-group">
                <span>👤</span>
                <input type="text" id="nome" name="nome" placeholder="Nome completo">
            </div>

            <div class="input-group">
                <span>📋</span>
                <input type="text"id="cpf_cnpj" name="cpf_cnpj" placeholder="CPF ou CNPJ">
            </div>

            <div class="input-group">
                <span>📧</span>
                <input type="email" id="email" name="email" placeholder="E-mail">
            </div>

            <div class="input-group">
                <span>📞</span>
                <input type="text" id="telefone" name="telefone" placeholder="Telefone">
            </div>

            <div class="input-group">
                <span>🧭</span>
                <input type="text"  id="cep" name="cep" placeholder="Cep">
            </div>

            <div class="input-group">
                <span>📍</span>
                <input type="text"  id="endereco" name="endereco" placeholder="Endereço completo">
            </div>
            <div class="input-group">
                <span>📌</span>
                <input type="text" id="bairro" name="bairro" placeholder="Bairro">
            </div>
            
            <div class="input-group">
                <span>🗺️</span>
                <input type="text" id="cidade" name="cidade" placeholder="Cidade">
            </div>

            <div class="input-group">
                <span>🖇️</span>
                <input type="text" id="estado" name="estado" placeholder="UF" maxlength="2">
            </div>

            <div class="input-group">
                <span>🔒</span>
                <input type="password"id="senha" name="senha" placeholder="Criar senha">
            </div>

            <div class="input-group">
                <span>🔒</span>
                <input type="password" id="senharepeat" name="senharepeat" placeholder="Confirmar senha">
            </div>

            <button type="submit">Criar Conta</button>

            <p>Já possui cadastro? <a href="login.php">Entrar</a></p>

            <div class="links">
                <a href="#">Política de Privacidade</a>
                <a href="#">Termos de Uso</a>
            </div>
        </form>         
    </div>
</main>

<script>
    const form = document.getElementById('form');
    const senha = document.getElementById('senha');
    const confirmarSenha = document.getElementById('senharepeat');

    form.addEventListener('submit', function (e) {
        if (senha.value.trim() !== confirmarSenha.value.trim()) {
            e.preventDefault();
            alert('As senhas não coincidem.');
        }
    });
</script>



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
</body>
</html>
