<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";
?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../style/clientes.css">
        <link rel="shortcut icon" href="../../imagens/favicon.png" type="image/x-icon">
        <title>Novo Cliente</title>
    </head>

    <body>

    <h2>Cadastrar Cliente</h2>

    <?php if (!empty($_SESSION['msg_erro'])): ?>
        <p style="color:red"><?= $_SESSION['msg_erro']; unset($_SESSION['msg_erro']); ?></p>
    <?php endif; ?>

    <?php if (!empty($_SESSION['msg_sucesso'])): ?>
        <p style="color:red"><?= $_SESSION['msg_sucesso']; unset($_SESSION['msg_sucesso']); ?></p>
    <?php endif; ?>

    <form method="POST" action="cliente_salvar.php">

        <label>Nome do cliente:</label><br>
        <input type="text" name="nome"  placeholder="Digite o nome do cliente" required><br><br>

        <label>Telefone do cliente:</label><br>
        <input type="text" name="telefone" placeholder="Digite o telefone do cliente" required><br><br>

        <label>Email do cliente:</label><br>
        <input type="email" name="email" placeholder="Digite o email do cliente"><br><br>

        <div class="form-botoes">
            <button type="submit">Salvar</button>
            <a href="../agendamentos/agendamento_criar.php" class="btn">Cancelar</a>
        </div>

    </form>

    </body>
</html>
