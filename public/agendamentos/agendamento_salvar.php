<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    $user = $_SESSION['usuario'];
    $horaAtual = $agora->format('H:i');

    // Define técnico
    $tecnico_id = ($user['perfil'] === 'admin')
        ? $_POST['tecnico_id']
        : $user['id'];

    $stmt = $pdo->prepare(
        "INSERT INTO agendamentos 
        (cliente_id, servico_id, tecnico_id, data, hora, status)
        VALUES (?, ?, ?, ?, ?, 'nao_feito')"
    );

    $stmt->execute([
        $_POST['cliente_id'],
        $_POST['servico_id'],
        $tecnico_id,
        $_POST['data'],
        $_POST['hora'] = $horaAtual
    ]);

    $_SESSION['mensagem'] = "Agendamento criado com sucesso!";
    header("Location: agendamentos.php");
    exit;
