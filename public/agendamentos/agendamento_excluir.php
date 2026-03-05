<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    $id = $_GET['id'];
    $user = $_SESSION['usuario'];

    $stmt = $pdo->prepare("SELECT tecnico_id FROM agendamentos WHERE id=:id");
    $stmt->execute([':id'=>$id]);
    $a = $stmt->fetch();

    if (
        $user['perfil'] ==='admin' ||
        ($user['perfil'] ==='tecnico' && $a['tecnico_id']==$user['id'])
    ) {
        $stmt = $pdo->prepare("DELETE FROM agendamentos WHERE id=:id");
        $stmt->execute([':id'=>$id]);
        $_SESSION['mensagem'] = "Agendamento apagado com sucesso!";
    }

    header("Location: agendamentos.php");
    exit;
