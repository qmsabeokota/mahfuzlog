<?php
session_start();

// Verifica se veio um ID de cotação
if (isset($_POST['cotacao_id'])) {
    $_SESSION['cotacao_id'] = (int)$_POST['cotacao_id'];

    // Redireciona para a página de pagamento
    header('Location: pagamento.php');
    exit;
} else {
    echo "Nenhuma cotação selecionada.";
}
