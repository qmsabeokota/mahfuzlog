<?php
session_start();
require_once '../model/Usuario.php';

if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit;
}

$usuario = new Usuario();
$cliente = $usuario->buscarPorId($_SESSION['cliente_id']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Cadastro</title>
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
    <div class="form-box">
        <h2 class="titulo">Atualizar Cadastro</h2>
        <div class="form" id="form">
            <form action="../controller/AtualizarController.php" method="POST">
                <label for="tipo">Tipo de Cliente:</label>
                <select disabled name="tipo" id="tipo" required  >
                    <option value="" >Selecione</option>
                    <option value="PF" <?= ($cliente['tipo'] ?? '') === 'PF' ? 'selected' : '' ?>>Pessoa Física</option>
                    <option value="PJ" <?= ($cliente['tipo'] ?? '') === 'PJ' ? 'selected' : '' ?>>Pessoa Jurídica</option> 
                    </select><br><br>

                <div class="input-group">
                    <input type="text" name="nome" placeholder="Nome/Razão Social:" id="nome" required  readonly
                           value="<?= htmlspecialchars($cliente['nome'] ?? '') ?>">
                </div>

                <div class="input-group">
                    <input type="text" name="cpf_cnpj" placeholder="CPF/CNPJ" id="cpfcnpj" required readonly
                           value="<?= htmlspecialchars($cliente['cpf_cnpj'] ?? '') ?>">
                </div>

                <div class="input-group">
                    <input type="email" name="email" placeholder="E-mail:" id="email" required 
                           value="<?= htmlspecialchars($cliente['email'] ?? '') ?>">
                </div>

                <div class="input-group">
                    <input type="password" name="senha" placeholder="Nova senha (opcional)" id="senha">
                </div>

                <div class="input-group">
                    <input type="password" name="senharepeat" placeholder="Confirmar nova senha" id="senharepeat">
                </div>

                <div class="input-group">
                    <input type="text" name="telefone" placeholder="Celular:" id="telefone" required 
                           value="<?= htmlspecialchars($cliente['telefone'] ?? '') ?>">
                </div>

                <div class="input-group">
                    <input type="text" name="endereco" placeholder="Endereço (Rua, Número, Complemento):" id="endereco" required 
                           value="<?= htmlspecialchars($cliente['endereco'] ?? '') ?>">
                </div>

                <div class="input-group">
                    <input type="text" name="bairro" placeholder="Bairro:" id="bairro" required 
                           value="<?= htmlspecialchars($cliente['bairro'] ?? '') ?>">
                </div>

                <div class="input-group">
                    <input type="text" name="cidade" placeholder="Cidade:" id="cidade" required 
                           value="<?= htmlspecialchars($cliente['cidade'] ?? '') ?>">
                </div>

                <div class="input-group">
                    <input type="text" name="estado" placeholder="Estado:" id="estado" required 
                           value="<?= htmlspecialchars($cliente['estado'] ?? '') ?>">
                </div>

                <div class="input-group">
                    <input type="text" name="cep" placeholder="CEP:" id="cep" required 
                           value="<?= htmlspecialchars($cliente['cep'] ?? '') ?>">
                </div>

                <button type="submit">Finalizar alteração!</button>
            </form>
        </div>
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
