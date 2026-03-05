<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    $id = $_GET['id'] ?? null;
    if (!$id) die("Serviço inválido");

    $stmt = $pdo->prepare("SELECT * FROM servicos WHERE id = ?");
    $stmt->execute([$id]);
    $servico = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$servico) die("Serviço não encontrado");

?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../style/servicos.css">
        <link rel="shortcut icon" href="imagens/favicon.png" type="image/x-icon">
        <title>Editar Serviço</title>
    </head>
    <body>

    <h2>Editar Serviço</h2>

    <div class="container">
        <?php if (!empty($_SESSION['msg_erro'])): ?>
            <p style="color:red">
                <?= $_SESSION['msg_erro']; unset($_SESSION['msg_erro']); ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="servico_salvar.php">

            <input type="hidden" name="id" value="<?= $servico['id'] ?>">

            <label>Descrição:</label><br>
            <input type="text" name="descricao"
                value="<?= htmlspecialchars($servico['descricao']) ?>"
                required><br><br>

            <button type="submit">Salvar</button>
            <a href="servicos.php" class="btn">Cancelar</a>

        </form>
    </div>
    </body>
</html>
