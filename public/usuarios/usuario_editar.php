<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    if ($_SESSION['usuario']['perfil'] !== 'admin') {
        die("Acesso negado");
    }

    $id = $_GET['id'] ?? null;
    if (!$id) die("ID inválido");

    /* Buscar técnico ativo */
    $stmt = $pdo->prepare(
        "SELECT id, nome, email
        FROM usuarios
        WHERE id = :id AND perfil='tecnico' AND ativo=1"
    );
    $stmt->execute(['id'=>$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        die("Usuário inválido ou inativo");
    }

    /* Atualizar */
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $stmt = $pdo->prepare(
            "UPDATE usuarios
            SET nome=:nome, email=:email
            WHERE id=:id AND ativo=1"
        );

        $stmt->execute([
            'nome'=>trim($_POST['nome']),
            'email'=>trim($_POST['email']),
            'id'=>$id
        ]);

        $_SESSION['mensagem']="Usuário atualizado!";
        $_SESSION['tipo']="sucesso";
        header("Location: usuarios.php");
        exit;
    }

?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Editar Técnico</title>
        <link rel="stylesheet" href="../../style/usuarios.css">
        <link rel="shortcut icon" href="imagens/favicon.png" type="image/x-icon">
    </head>
    <body>
        <div class="container">
            <h2>Editar Técnico</h2>

            <form method="POST">
                <label>Nome</label>
                <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

                <div class="form-botoes">
                    <button class="btn">Salvar</button>
                    <a class="btn btn-secundario" href="usuarios.php">Cancelar</a>
                </div>
            </form>
        </div>
    </body>
</html>