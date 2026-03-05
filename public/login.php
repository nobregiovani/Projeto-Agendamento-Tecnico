<?php
    // Início da sessão
    session_start();
    require "../conexao/conexao.php";

    $usuario = '';
    $email = '';
    $mensagem = '';

    try {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $senha_digitada = $_POST['senha'];
        
            // Busca o usuário pelo e-mail
            $sql = "SELECT * FROM usuarios WHERE email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

             // Verifica a senha
            if ($usuario) {

                /* 1 — Verifica se usuário está desativado */
                if ((int)$usuario['ativo'] === 0) {
                    $mensagem = "Usuário desativado.\nFavor contactar o suporte.";
                }

                /* 2 — Verifica senha somente se estiver ativo */
                elseif (password_verify($senha_digitada, $usuario['senha'])) {

                    $_SESSION['usuario'] = [
                        'id'    => $usuario['id'],
                        'nome'  => $usuario['nome'],
                        'email' => $usuario['email'],
                        'perfil'=> $usuario['perfil'] ?? 'tecnico'
                    ];

                    header("Location: tela_inicial.php");
                    exit;
                }

                else {
                    $mensagem = "E-mail ou senha incorretos.";
                }

            } else {
                $mensagem = "E-mail ou senha incorretos.";
            }
        }
    } catch (Exception $e) {
        echo "<p>Erro na conexão: ".$e->getMessage(). "</p>";
    }

?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/login.css">
    <link rel="shortcut icon" href="../imagens/favicon.png" type="image/svg">
    <title>Login</title>
</head>
<body>
    
    <div>
        <h1>Login</h1>

        <div class="area-mensagem">
            <?php if (!empty($mensagem)): ?>
                <p class="mensagem"><?= (nl2br(htmlspecialchars($mensagem))) ?></p>
            <?php else: ?>
                <p class="mensagem mensagem-vazia"></p>
            <?php endif; ?>
        </div>
        <br>
        
        <form id="login" method="POST">
            <label>Email: </label>
            <input type="email" name="email" class="control_form" id="inputEmail" placeholder="Digite o seu email" required><br>
            <label>Senha: </label>
            <input type="password" name="senha" class="control_form" placeholder="Digite a sua senha" id="inputSenha" required><br>
            
            <button id="buttonEntrar" type="submit">Entrar</button>
        </form>
        <br>
    </div>

    <button id="buttonRegistrar">
        <a href="registro.php">Registre-se</a>
    </button><br>
    <a href="../index.html" class="button-voltar">Voltar para o site</a>
    <br>  
</body>
</html>