<?php
   require "../../conexao/autorizacao.php";

?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../style/servicos.css">
        <link rel="shortcut icon" href="../../imagens/favicon.png" type="image/x-icon">
        <title>Novo Serviço</title>
    </head>
    <body>
        <div class="container">
            <h2>Cadastrar Serviço</h2>

            <?php if (!empty($_SESSION['msg_erro'])): ?>
                <p style="color:red"><?= $_SESSION['msg_erro']; unset($_SESSION['msg_erro']); ?></p>
            <?php endif; ?>

            <?php if (!empty($_SESSION['msg_sucesso'])): ?>
                <p style="color:red"><?= $_SESSION['msg_sucesso']; unset($_SESSION['msg_sucesso']); ?></p>
            <?php endif; ?>

            <form method="POST" action="servico_salvar.php">

                <label>Descrição:</label><br>
                <input type="text" name="descricao" required><br><br>
                
                <div class="form-botoes">
                    <button type="submit">Salvar</button>
                    <a href="../agendamentos/agendamento_criar.php" class="btn">Cancelar</a>
                </div>
            </form>
        </div>
    </body>
</html>
