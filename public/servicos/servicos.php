<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    // Busca todos os serviços
    $servicos = $pdo->query("SELECT * FROM servicos ORDER BY descricao")->fetchAll(PDO::FETCH_ASSOC);

?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="../../style/servicos.css">
        <link rel="shortcut icon" href="../../imagens/favicon.png" type="image/x-icon">
        <title>Serviços</title>
    </head>
    <body>

    <div class="container">
        <h2>Serviços</h2>

        <?php if (!empty($_SESSION['msg_sucesso'])): ?>
            <p style="color:green">
                <?= $_SESSION['msg_sucesso']; unset($_SESSION['msg_sucesso']); ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($_SESSION['msg_erro'])): ?>
            <p style="color:red">
                <?= $_SESSION['msg_erro']; unset($_SESSION['msg_erro']); ?>
            </p>
        <?php endif; ?>

        <a href="servico_criar.php" class="btn"> <i class="fa-solid fa-plus"></i>Novo Serviço</a>
            
        <table border="1" cellpadding="8">
            <tr>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>

            <?php if (count($servicos) === 0): ?>
                <tr>
                    <td colspan="2">Nenhum serviço cadastrado</td>
                </tr>
            <?php else: ?>
                <?php foreach ($servicos as $s): ?>
                    <tr>
                        <td><?= htmlspecialchars($s['descricao']) ?></td>
                        <td>
                            <a href="servico_editar.php?id=<?= $s['id'] ?>" class="btn">Editar</a>
                            <a href="servico_excluir.php?id=<?= $s['id'] ?>" class="btn"
                            onclick="return confirm('Deseja excluir este serviço?')">
                            Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
        <br>
        <a href="../agendamentos/agendamento_criar.php" class="btn">Voltar</a>
    </div>
    </body>
</html>
