<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cotação</title>
    <link rel="stylesheet" href="../public/css/cotacao.css">
    <script>
        // Função para calcular o frete em tempo real
        function calcularFrete() {
            // Pegando os valores dos campos
            var largura = parseFloat(document.getElementsByName("largura")[0].value);
            var altura = parseFloat(document.getElementsByName("altura")[0].value);
            var comprimento = parseFloat(document.getElementsByName("comprimento")[0].value);
            var pesoReal = parseFloat(document.getElementsByName("peso")[0].value);

            // Validando se os campos não estão vazios
            if (isNaN(largura) || isNaN(altura) || isNaN(comprimento) || isNaN(pesoReal) || largura === 0 || altura === 0 || comprimento === 0 || pesoReal === 0) {
                document.getElementById("resultado_frete").innerText = "Preencha todos os campos corretamente!";
                return;
            }

            // Cálculo do volume (em m³)
            var volume = (largura * altura * comprimento) / 1000000; // Convertendo de cm³ para m³

            // Exibindo o volume calculado
            document.getElementsByName("volume")[0].value = volume.toFixed(6); // Exibindo 6 casas decimais no volume

            // Cálculo do peso volumétrico
            var pesoVolumetrico = (largura * altura * comprimento) / 6000;

            // O peso cobrado é o maior entre o peso real e o volumétrico
            var pesoCobrado = Math.max(pesoReal, pesoVolumetrico);

            // Calculando o valor do frete (por exemplo, 5 reais por kg)
            var valorFrete = pesoCobrado * 5;

            // Atualizando o valor do frete no campo do formulário
            document.getElementsByName("valor_frete")[0].value = valorFrete.toFixed(2);
            document.getElementById("resultado_frete").innerText = "Valor estimado do frete: R$ " + valorFrete.toFixed(2);
        }
    </script>
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

<h2 class="titulo">Realize sua cotação de forma rápida!</h2>

<form action="../controller/CotacaoController.php" method="post" class="formulario">
    <!-- Bloco 1: Remetente/Destinatário -->
    <fieldset>
        <legend>Remetente</legend>
        <input type="text" name="remetente" placeholder="Remetente" required>
        <label>Cliente:</label>
        <input type="text" name="cliente_remetente" placeholder="Cliente" required>
        <label>Endereço:</label>
        <textarea name="endereco_remetente" required></textarea>
    </fieldset>

    <fieldset>
        <legend>Destinatário</legend>
        <input type="text" name="destinatario" placeholder="Destinatário" required>
        <label>Cliente:</label>
        <input type="text" name="cliente_destinatario" placeholder="Cliente" required>
        <label>Endereço:</label>
        <textarea name="endereco_destinatario" required></textarea>
    </fieldset>

    <!-- Bloco 2: Tomador e pagamento -->
    <fieldset>
        <legend>Tomador</legend>
        <input type="text" name="tomador" placeholder="Tomador" required>
        <label>Endereço:</label>
        <textarea name="endereco_tomador" required></textarea>
    </fieldset>

    <fieldset>
        <legend>Forma de Pagamento</legend>
        <select name="pagamento" required>
            <option value="pix">Pix</option>
            <option value="cartao">Cartão</option>
        </select>
    </fieldset>

    <!-- Bloco 3: Mercadoria -->
    <fieldset>
        <legend>Mercadoria</legend>
        <input type="text" name="mercadoria" placeholder="Mercadoria" required>
        <label>Medidas:</label>
        <input type="number" name="largura" placeholder="Largura (cm)" oninput="calcularFrete()" required> x 
        <input type="number" name="altura" placeholder="Altura (cm)" oninput="calcularFrete()" required> x 
        <input type="number" name="comprimento" placeholder="Comprimento (cm)" oninput="calcularFrete()" required> cm
        <br>
        <label>Volume (m³):</label>
        <input type="number" name="volume" step="0.01" readonly>
        <label>Peso (kg):</label>
        <input type="number" name="peso" step="0.01" oninput="calcularFrete()" required>
        <label>Observações:</label>
        <input type="text" name="observacoes">
    </fieldset>

    <!-- Exibindo o valor estimado do frete -->
    <div id="resultado_frete" style="margin-top: 15px; font-size: 18px; color: green;"></div>

    <input type="hidden" name="valor_frete">

    <div class="botoes">
        <button type="submit">ENVIAR</button>
    </div>
</form>


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
