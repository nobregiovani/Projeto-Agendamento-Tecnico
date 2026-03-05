<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    $id = $_GET['id'] ?? null;
    if (!$id) die("Cliente inválido");

    // Busca cliente
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
    $stmt->execute([$id]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) die("Cliente não encontrado");

?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../style/clientes.css">
        <link rel="shortcut icon" href="imagens/favicon.png" type="image/x-icon">
        <title>Editar Cliente</title>
    </head>
    <body>

    <h2>Editar Cliente</h2>

    <?php if (!empty($_SESSION['msg_erro'])): ?>
        <p style="color:red"><?= $_SESSION['msg_erro']; unset($_SESSION['msg_erro']); ?></p>
    <?php endif; ?>

    <form method="POST" action="cliente_salvar.php">

        <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required><br><br>

        <label>Telefone:</label><br>
        <input type="text" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>"><br><br>

        <button type="submit">Salvar</button>
        <a href="clientes.php">Cancelar</a>

    </form>

    </body>
</html>
