<?php
    require "../../conexao/autorizacao.php";
    require "../../conexao/conexao.php";

    $user = $_SESSION['usuario'];

    if ($user['perfil'] === 'admin') {

        // Admin vê todos os agendamentos
        $stmt = $pdo->query(
            "SELECT a.*, c.nome AS cliente, s.descricao AS servico, u.nome AS tecnico
            FROM agendamentos a
            JOIN clientes c ON c.id=a.cliente_id
            JOIN servicos s ON s.id=a.servico_id
            JOIN usuarios u ON u.id=a.tecnico_id"
        );
        $stmt->execute();

    } else {

        //Técnico vê apenas os próprios agendamentos 
        $stmt = $pdo->prepare(
            "SELECT a.*, c.nome AS cliente, s.descricao AS servico
            FROM agendamentos a
            JOIN clientes c ON c.id=a.cliente_id
            JOIN servicos s ON s.id=a.servico_id
            WHERE tecnico_id=?"
        );
        $stmt->execute([$user['id']]);
    }
    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Agendamentos</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="shortcut icon" href="../../imagens/favicon.png" type="image/x-icon">
        <link rel="stylesheet" href="../../style/agendamentos.css">
    </head>
    <body>

        <h2>Lista de Agendamentos</h2>

        <?php if (!empty($_SESSION['mensagem'])): ?>
            <div class="mensagem">
                <p><?= $_SESSION['mensagem']; unset($_SESSION['mensagem']); ?></p>
            </div>   
        <?php endif; ?>

        <br>
        <a class="btn" href="agendamento_criar.php"> <i class="fa-solid fa-plus"></i> Novo agendamento</a>

        <table border="1" cellpadding="8" cellspacing="0" class="tabela_agendamentos">

            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Serviço</th>

                    <?php if ($user['perfil'] === 'admin'): ?>
                        <th>Técnico</th>
                    <?php endif; ?>

                    <th>Data</th>
                    <th>Hora</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php if (count($agendamentos) === 0): ?>
                    <tr>
                        <td colspan="<?= $user['perfil'] === 'admin' ? 7 : 6 ?>">
                            Nenhum agendamento encontrado
                        </td>
                    </tr>

                <?php else: ?>
                    <?php foreach ($agendamentos as $a): ?>
                        <tr>
                            <td><?= htmlspecialchars($a['cliente']) ?></td>
                            <td><?= htmlspecialchars($a['servico']) ?></td>

                            <?php if ($user['perfil'] === 'admin'): ?>
                                <td><?= htmlspecialchars($a['tecnico']) ?></td>
                            <?php endif; ?>

                            <td><?= htmlspecialchars(date('d/m/Y', strtotime($a['data']))) ?></td>
                            <td><?= htmlspecialchars($a['hora']) ?></td>
                            <td class="status-<?= $a['status'] ?>">
                                <?= htmlspecialchars($a['status']) ?>
                            </td>


                            <td>
                                <a href="agendamento_editar.php?id=<?= (int)$a['id'] ?>" class="btn">
                                    Editar
                                </a>
                                <a href="agendamento_excluir.php?id=<?= (int)$a['id'] ?>" class="btn btn-excluir"
                                onclick="return confirm('Deseja excluir este agendamento?')">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>

        </table>

        <br>
        <button>
            <a href="../tela_inicial.php">Menu Iniciar</a>
        </button>
        

    </body>
</html>



