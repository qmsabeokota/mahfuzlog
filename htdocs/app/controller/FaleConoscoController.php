
<?php
require_once '../model/FaleConosco.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fale = new FaleConosco();
    $fale->enviarMensagem($_POST);

    echo "<script>alert('Mensagem enviada com sucesso!'); window.location.href='../view/homepage.php';</script>";
} else {
    header('Location: ../view/homepage.php');
    exit;
}
?>
