<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    $id = $_GET['id'] ?? null;
    if (!$id) {
        $_SESSION['msg_erro'] = "Cliente inválido.";
        header("Location: clientes.php");
        exit;
    }

    // (Opcional) impedir exclusão se tiver agendamentos
    $stmt = $pdo->prepare(
        "SELECT COUNT(*) FROM agendamentos WHERE cliente_id = ?"
    );
    $stmt->execute([$id]);

    if ($stmt->fetchColumn() > 0) {
        $_SESSION['msg_erro'] = "Cliente possui agendamentos vinculados. Favor, apagar antes os agendamentos vinculados.";
        header("Location: clientes.php");
        exit;
    }

    // Excluir
    $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['msg_sucesso'] = "Cliente excluído com sucesso!";
    header("Location: clientes.php");
    exit;
