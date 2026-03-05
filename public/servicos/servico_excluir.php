<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    $id = $_GET['id'] ?? null;

    if (!$id) {
        $_SESSION['msg_erro'] = "Serviço inválido.";
        header("Location: servicos.php");
        exit;
    }

    // Impede exclusão se houver agendamentos
    $stmt = $pdo->prepare(
        "SELECT COUNT(*) FROM agendamentos WHERE servico_id = ?"
    );
    $stmt->execute([$id]);

    if ($stmt->fetchColumn() > 0) {
        $_SESSION['msg_erro'] = "Este serviço possui agendamentos vinculados.";
        header("Location: servicos.php");
        exit;
    }

    // Exclui
    $stmt = $pdo->prepare("DELETE FROM servicos WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['msg_sucesso'] = "Serviço excluído com sucesso!";
    header("Location: servicos.php");
    exit;
