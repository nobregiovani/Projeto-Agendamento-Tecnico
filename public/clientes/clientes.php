<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    $clientes = $pdo->query("SELECT * FROM clientes ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);

?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../style/clientes.css">
        <link rel="shortcut icon" href="../../imagens/favicon.png" type="image/x-icon">
        <title>Clientes</title>
    </head>
    <body>

    <h2>Clientes Cadastrados</h2>

    <?php if (!empty($_SESSION['msg_sucesso'])): ?>
        <p style="color:green"><?= $_SESSION['msg_sucesso']; unset($_SESSION['msg_sucesso']); ?></p>
    <?php endif; ?>

    <?php if (!empty($_SESSION['msg_erro'])): ?>
        <p style="color:red"><?= $_SESSION['msg_erro']; unset($_SESSION['msg_erro']); ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="8">
        <tr>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>

        <?php foreach ($clientes as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['nome']) ?></td>
                <td><?= htmlspecialchars($c['telefone']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td>
                    <a href="cliente_editar.php?id=<?= $c['id'] ?>" class="btn">Editar</a>
                    <a href="cliente_excluir.php?id=<?= $c['id'] ?>" class="btn"
                        onclick="return confirm('Deseja excluir este cliente?')">
                        Excluir
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    
    <br><br>
    <a href="../agendamentos/agendamento_criar.php" class="btn">Voltar</a>
    
    </body>
</html>
