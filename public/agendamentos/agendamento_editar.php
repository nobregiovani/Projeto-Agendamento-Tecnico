<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    $user = $_SESSION['usuario'];
    $id = $_GET['id'] ?? null;
    $horaAtual = $agora->format('H:i');

    if (!$id) {
        die("ID inválido");
    }

    /* Busca o agendamento */
    $stmt = $pdo->prepare("SELECT * FROM agendamentos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $agendamento = $stmt->fetch();

    /* Busca clientes */
    $stmt = $pdo->query("SELECT id, nome FROM clientes ORDER BY nome");
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* Busca serviços */
    $stmt = $pdo->query("SELECT id, descricao FROM servicos ORDER BY descricao");
    $servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$agendamento) {
        die("Agendamento não encontrado");
    }

    /* Regra de permissão */
    if (
        $user['perfil'] === 'tecnico' &&
        $agendamento['tecnico_id'] != $user['id']
    ) {
        die("Você não tem permissão para editar este agendamento");
    }

    /* Atualização */
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $stmt = $pdo->prepare(
            "UPDATE agendamentos 
            SET cliente_id = :cliente,
                servico_id = :servico,
                data = :data,
                hora = :hora,
                status = :status
            WHERE id = :id"
        );

        $stmt->execute([
            ':cliente' => $_POST['cliente'],
            ':servico' => $_POST['servico'],
            ':data'    => $_POST['data'],
            ':hora'    => $horaAtual,
            ':status'  => $_POST['status'],
            ':id'      => $id
        ]);
        $_SESSION['mensagem'] = 'Agendamento atualizado com sucesso!';
        header("Location: agendamentos.php");
        exit;
    }
?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../style/agendamentos.css">
        <link rel="shortcut icon" href="imagens/favicon.png" type="image/x-icon">
        <title>Editar Agendamento</title>
    </head>
    <body>

        <h2>Editar Agendamento</h2>

        <form method="POST">

            <label>Cliente:</label><br>
            <select name="cliente" required>
                <option value="">Selecione o cliente</option>

                <?php foreach ($clientes as $c): ?>
                    <option 
                        value="<?= $c['id'] ?>"
                        <?= $c['id'] == $agendamento['cliente_id'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($c['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br><br>

            <label>Serviço:</label><br>
            <select name="servico" required>
                <option value="">Selecione o serviço</option>

                <?php foreach ($servicos as $s): ?>
                    <option 
                        value="<?= $s['id'] ?>"
                        <?= $s['id'] == $agendamento['servico_id'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($s['descricao']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br><br>

            <label>Data:</label><br>
            <input 
                type="date" 
                name="data" 
                value="<?= htmlspecialchars($agendamento['data']) ?>" 
                required
            ><br><br>

            <label>Status:</label><br>
            <select name="status" required>
                <option value="nao_feito" 
                    <?= $agendamento['status'] === 'nao_feito' ? 'selected' : '' ?>>
                    Não feito
                </option>

                <option value="em_andamento" 
                    <?= $agendamento['status'] === 'em_andamento' ? 'selected' : '' ?>>
                    Em andamento
                </option>

                <option value="feito" 
                    <?= $agendamento['status'] === 'feito' ? 'selected' : '' ?>>
                    Feito
                </option>
            </select><br><br>

            <button type="submit">Salvar alterações</button>
            <a href="agendamentos.php">Cancelar</a>

        </form>

    </body>
</html>
