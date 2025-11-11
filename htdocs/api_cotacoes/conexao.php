<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sistema_cadastro";

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die(json_encode(["status" => "erro", "mensagem" => "Falha na conexão: " . $conn->connect_error]));
}

$conn->set_charset("utf8");
?>
