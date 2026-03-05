<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    $nome = trim($_POST['nome']);

    $telefone = trim($_POST['telefone']);

    $email = trim($_POST['email']) ?? '';

    $id = $_POST['id'];

    if ($email !== '') {

        if ($id) {
            // Edição: ignora o próprio registro
            $stmt = $pdo->prepare(
                "SELECT COUNT(*) FROM clientes WHERE email = ? AND id != ?");
            $stmt->execute([$email, $id]);
        } else {
            // Cadastro
            $stmt = $pdo->prepare(
                "SELECT COUNT(*) FROM clientes WHERE email = ?"
            );
            $stmt->execute([$email]);
        }

        if ($stmt->fetchColumn() > 0) {
            $_SESSION['msg_erro'] = "Este e-mail já está cadastrado.";
            header("Location: " . ($id ? "cliente_editar.php?id=$id" : "cliente_criar.php"));
            exit;
        }
    }

    // EDITAR
    if (!empty($_POST['id'])) {

        $stmt = $pdo->prepare(
            "UPDATE clientes
            SET nome = ?, telefone = ?, email = ?
            WHERE id = ?"
        );

        $stmt->execute([$nome, $telefone, $email, $_POST['id']]);

        $_SESSION['msg_sucesso'] = "Cliente atualizado com sucesso!";

    // CRIAR
    } else {

        $stmt = $pdo->prepare(
            "INSERT INTO clientes (nome, telefone, email)
            VALUES (?, ?, ?)"
        );

        $stmt->execute([$nome, $telefone, $email]);

        $_SESSION['msg_sucesso'] = "Cliente cadastrado com sucesso!";
    }

    header("Location: clientes.php");
    exit;
