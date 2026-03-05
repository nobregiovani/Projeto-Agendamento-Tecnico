<?php
    require "../conexao/autorizacao.php";
    
?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style/tela_inicial.css">
        <link rel="shortcut icon" href="../imagens/favicon.png" type="image/x-icon">
        <title>Sistema de Agendamento de Serviço Técnico</title>
    </head>

    <body>
        <div class="container">
            <h2>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']['nome'], ENT_QUOTES, 'UTF-8'); ?>!</h2>
            <ul>
                <?php if ($_SESSION['usuario']['perfil'] === 'admin'): ?>
                    <li><a href="usuarios/usuarios.php">Técnicos</a></li>
                <?php endif; ?>

                <li><a href="agendamentos/agendamentos.php">Agendamentos</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </div>  
    </body>    
</html>