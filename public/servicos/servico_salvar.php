<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    $descricao = trim($_POST['descricao'] ?? '');
    $id = $_POST['id'] ?? null;

    // Validação
    if ($descricao === '') {
        $_SESSION['msg_erro'] = "A descrição do serviço é obrigatória.";
        header("Location: " . ($id ? "servico_editar.php?id=$id" : "servico_criar.php"));
        exit;
    }

    // UPDATE
    if ($id) {

        $stmt = $pdo->prepare(
            "UPDATE servicos SET descricao = ? WHERE id = ?"
        );
        $stmt->execute([$descricao, $id]);

        $_SESSION['msg_sucesso'] = "Serviço atualizado com sucesso!";

    // INSERT
    } else {

        $stmt = $pdo->prepare(
            "INSERT INTO servicos (descricao) VALUES (?)"
        );
        $stmt->execute([$descricao]);

        $_SESSION['msg_sucesso'] = "Serviço cadastrado com sucesso!";
    }

    header("Location: servicos.php");
    exit;
