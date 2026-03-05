<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    // Busca clientes
    $clientes = $pdo->query("SELECT id, nome FROM clientes")->fetchAll();

    // Busca serviços
    $servicos = $pdo->query("SELECT id, descricao FROM servicos")->fetchAll();

    // Busca técnicos (admin pode escolher, técnico usa o próprio)
    $tecnicos = [];
    if ($_SESSION['usuario']['perfil'] === 'admin') {
        $tecnicos = $pdo->query(
            "SELECT id, nome FROM usuarios WHERE perfil='tecnico'"
        )->fetchAll();
    }
    
?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../style/agendamentos.css">
        <link rel="shortcut icon" href="../../imagens/favicon.png" type="image/x-icon">
        <title>Novo Agendamento</title>
    </head>
    <body>

        <h2>Criar Agendamento</h2>

        <form method="POST" action="agendamento_salvar.php">

            <label>Cliente:</label>
            <select name="cliente_id" required>
                <option value="">Selecione</option>
                <?php foreach ($clientes as $c): ?>
                    <option value="<?= $c['id'] ?>">
                        <?= htmlspecialchars($c['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <div class="form-botoes">
                <a href="../clientes/cliente_criar.php" class="btn">Novo Cliente</a>
                <a href="../clientes/clientes.php" class="btn">Listar Clientes</a>
                <br><br>
            </div>
            
            <label>Serviço:</label>
            <select name="servico_id" required>
                <option>Selecione</option>
                <?php foreach ($servicos as $s): ?>
                    <option value="<?= $s['id'] ?>">
                        <?= htmlspecialchars($s['descricao']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="form-botoes">
                <a href="../servicos/servico_criar.php" class="btn">Novo Serviço</a>
                <a href="../servicos/servicos.php" class="btn">Listar Serviços</a>
            </div>
            <br>

            <?php if ($_SESSION['usuario']['perfil'] === 'admin'): ?>
                <label>Técnico:</label><br>
                <select name="tecnico_id" required>
                    <option value="">Selecione</option>
                    <?php foreach ($tecnicos as $t): ?>
                        <option value="<?= $t['id'] ?>">
                            <?= htmlspecialchars($t['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>
            <?php endif; ?>

            <label>Data:</label>
            <input type="date" name="data" required><br>
            
            <div class="form-botoes">
                <button type="submit">Salvar</button>
                <a href="agendamentos.php" class="btn">Cancelar</a>
            </div>
            
        </form>
    </body>
</html>
