<?php 
    session_start();
    require_once "../conexao/conexao.php";

    $mensagem = "";
    $tipo = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Entrada de dados
        $nome = $_POST['criar_nome'] ?? '';
        $email = $_POST['criar_email'] ?? '';
        $senha = $_POST['criar_senha'] ?? '';

        // Hash da senha
        $hash_senha = password_hash($senha, PASSWORD_DEFAULT);

        try {
            // Verificar email duplicado
            $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
            $check->execute([$email]);

            if ($check->rowCount() > 0) {
                $mensagem = "Este email já está registrado.";
                $tipo = "erro";
            } else {
                
                // Cadastro
                $sql = "INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nome, $email, $hash_senha, 'tecnico']);
                
                $mensagem = "Usuário criado com sucesso!";
            }

        } catch (PDOException $e) {
            $mensagem = "Erro ao registrar: " . $e->getMessage();
            $tipo = "erro";
        }
    }
?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/registro.css">
    <link rel="shortcut icon" href="../imagens/favicon.png" type="image/svg">
    <title>Registro</title>
</head>
<body>

    <h1>Registro de Usuário</h1>

    <div class="area-mensagem">
        <?php if ((!empty($mensagem)) && $tipo != "erro"): ?>
            <p class="mensagem"><?= (htmlspecialchars($mensagem)) ?></p>
        <?php elseif (($mensagem) && $tipo == "erro"): ?>
            <p class="mensagem_erro"><?= (htmlspecialchars($mensagem)) ?></p>
        <?php else: ?>
            <p class="mensagem mensagem-vazia"></p>
        <?php endif; ?>
    </div>
    <br>

    <div id="registrador">
        <form action="" method="POST">

            <label>Nome:</label>
            <input type="text" name="criar_nome" placeholder="Digite seu nome" required>

            <label>Email:</label>
            <input type="email" name="criar_email" placeholder="Digite seu email" required>

            <label>Senha:</label>
            <input type="password" name="criar_senha" placeholder="Digite sua senha" required>

            <div id="registrar">
                <button type="submit" id="registrarButton">Registrar</button>
            </div>
        </form>
    </div>
    <br>
    <button id="voltarButton">
        <a href="login.php">Voltar</a>
    </button>
    

</body>
</html>
