<?php
require_once '../Database.php';
$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE clientes SET nome = :nome, email = :email WHERE id = :id");
    $stmt->execute([
        ':nome' => $_POST['nome'],
        ':email' => $_POST['email'],
        ':id' => $_POST['id']
    ]);
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM clientes WHERE id = :id");
$stmt->execute([':id' => $id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<form method="post">
    <input type="hidden" name="id" value="<?= $cliente['id'] ?>">
    <input type="text" name="nome" value="<?= $cliente['nome'] ?>" required>
    <input type="email" name="email" value="<?= $cliente['email'] ?>" required>
    <button type="submit">Salvar</button>
</form>
