<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    if ($_SESSION['usuario']['perfil'] !== 'admin') {
        die("Acesso negado");
    }

    /*-------CRIAR NOVO TÉCNICO--------*/
    if (isset($_POST['criar'])) {

        $nome  = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];

        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);

        if ($stmt->fetch()) {
            $_SESSION['mensagem'] = "Email já cadastrado!";
            $_SESSION['tipo'] = "erro";
            header("Location: usuarios.php");
            exit;
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            "INSERT INTO usuarios (nome, email, senha, perfil, ativo)
            VALUES (:nome, :email, :senha, 'tecnico', 1)"
        );
        $stmt->execute([
            'nome'  => $nome,
            'email' => $email,
            'senha' => $senhaHash
        ]);

        $_SESSION['mensagem'] = "Técnico criado com sucesso!";
        $_SESSION['tipo'] = "sucesso";
        header("Location: usuarios.php");
        exit;
    }

    /* -----DESATIVAR TÉCNICO------ */
    if (isset($_GET['desativar'])) {

        $id = (int)$_GET['desativar'];

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM agendamentos WHERE tecnico_id = :id");
        $stmt->execute(['id' => $id]);

        if ($stmt->fetchColumn() > 0) {
            $_SESSION['mensagem'] = "Não é possível desativar: técnico possui agendamentos.";
            $_SESSION['tipo'] = "erro";
            header("Location: usuarios.php");
            exit;
        }

        $pdo->prepare("UPDATE usuarios SET ativo = 0 WHERE id = :id")
            ->execute(['id' => $id]);

        $_SESSION['mensagem'] = "Técnico desativado!";
        $_SESSION['tipo'] = "sucesso";
        header("Location: usuarios.php");
        exit;
    }

    /* -----REATIVAR TÉCNICO------ */
    if (isset($_GET['reativar'])) {

        $id = (int)$_GET['reativar'];

        $pdo->prepare("UPDATE usuarios SET ativo = 1 WHERE id = :id")
            ->execute(['id' => $id]);

        $_SESSION['mensagem'] = "Técnico reativado!";
        $_SESSION['tipo'] = "sucesso";
        header("Location: usuarios.php");
        exit;
    }

    /* -----LISTAGEM TÉCNICOS------ */
    $stmt = $pdo->query(
        "SELECT id, nome, email, ativo
        FROM usuarios
        WHERE perfil='tecnico'
        ORDER BY ativo DESC, nome"
    );
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $mensagem = $_SESSION['mensagem'] ?? null;
    $tipo = $_SESSION['tipo'] ?? null;
    unset($_SESSION['mensagem'], $_SESSION['tipo']);

?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Usuários Técnicos</title>
        <link rel="stylesheet" href="../../style/usuarios.css">
        <link rel="shortcut icon" href="../../imagens/favicon.png" type="image/x-icon">
    </head>
    <body>

        <div class="container">

            <h2>Gerenciar Técnicos</h2>

            <?php if ($mensagem): ?>
                <div class="mensagem <?= $tipo ?>">
                    <?= htmlspecialchars($mensagem) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <h3>Novo Técnico</h3>

                <label>Nome</label>
                <input type="text" name="nome" placeholder="Digite o nome do técnico" required>

                <label>Email</label>
                <input type="email" name="email" placeholder="Digite o email do técnico" required>

                <label>Senha</label>
                <input type="text" name="senha" placeholder="Digite a senha de acesso do técnico" required>

                <div class="form-botoes">
                    <button class="btn" name="criar">Criar Técnico</button>
                </div>
            </form>

            <br><br>

            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                        <tr class="<?= $u['ativo'] ? '' : 'usuario-inativo' ?>">

                            <td>
                                <span class="<?= $u['ativo'] ? '' : 'inativo' ?>">
                                    <?= htmlspecialchars($u['nome']) ?>
                                </span>

                                <?php if (!$u['ativo']): ?>
                                    <span class="tag-inativo">INATIVO</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= $u['ativo'] ? 'Ativo' : 'Inativo' ?></td>

                            <td class="acoes">
                                <?php if ($u['ativo']): ?>
                                    <a class="btn" href="usuario_editar.php?id=<?= $u['id'] ?>">Editar</a>

                                    <a class="btn btn-excluir"
                                        href="?desativar=<?= $u['id'] ?>"
                                        onclick="return confirm('Desativar técnico?')">
                                        Desativar
                                    </a>
                                <?php else: ?> 
                                    <a class="btn btn-reativar"
                                    href="?reativar=<?= $u['id'] ?>"
                                    onclick="return confirm('Reativar técnico?')">
                                    Reativar
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <br>
            <a class="btn btn-secundario" href="../tela_inicial.php">Menu Inicial</a>

        </div>
    </body>
</html>