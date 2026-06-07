<?php
require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'cadastrar') {
    $data              = $_POST['data'];
    $nome_cliente      = $_POST['nome_cliente'];
    $nome_profissional = $_POST['nome_profissional'];
    $nome_procedimento = $_POST['nome_procedimento'];

    if ($data && $nome_cliente && $nome_profissional && $nome_procedimento) {
        try {
            $pdo->prepare("CALL sp_cadastrar_agendamento(?, ?, ?)")->execute([$data, $nome_cliente, $nome_profissional]);
            $id = $pdo->lastInsertId();
            $pdo->prepare("CALL sp_adicionar_procedimento(?, ?)")->execute([$id, $nome_procedimento]);
            $sucesso = "Agendamento cadastrado com sucesso!";
        } catch (PDOException $e) {
            $erro = "Erro: " . $e->getMessage();
        }
    } else {
        $erro = "Preencha todos os campos.";
    }
}

if (isset($_GET['excluir'])) {
    $pdo->prepare("DELETE FROM agendamento_procedimento WHERE id_agendamento = ?")->execute([$_GET['excluir']]);
    $pdo->prepare("DELETE FROM agendamento WHERE id_agendamento = ?")->execute([$_GET['excluir']]);
    header('Location: agendamentos.php'); exit;
}

$clientes      = $pdo->query("SELECT nome FROM cliente ORDER BY nome")->fetchAll(PDO::FETCH_COLUMN);
$profissionais = $pdo->query("SELECT nome FROM profissional ORDER BY nome")->fetchAll(PDO::FETCH_COLUMN);
$procedimentos = $pdo->query("SELECT nome FROM procedimento ORDER BY nome")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agendamentos - Clínica Estética</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="sidebar">
    <div class="logo"><i class="bi bi-flower1"></i> Clínica Estética</div>
    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="clientes.php"><i class="bi bi-people"></i> Clientes</a>
    <a href="profissionais.php"><i class="bi bi-person-badge"></i> Profissionais</a>
    <a href="procedimentos.php"><i class="bi bi-clipboard-heart"></i> Procedimentos</a>
    <a href="agendamentos.php" class="active"><i class="bi bi-calendar-check"></i> Agendamentos</a>
    <a href="relatorios.php"><i class="bi bi-bar-chart"></i> Relatórios</a>
</div>
<div class="topbar"><h5 class="mb-0 text-muted">Gerenciar Agendamentos</h5></div>
<div class="conteudo">
    <h4 class="mb-4">Agendamentos</h4>

    <?php if (!empty($sucesso)): ?><div class="alert alert-success"><?= $sucesso ?></div><?php endif; ?>
    <?php if (!empty($erro)): ?><div class="alert alert-danger"><?= $erro ?></div><?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h6 class="mb-3"><i class="bi bi-calendar-plus me-2 text-danger"></i>Novo Agendamento</h6>
            <form method="POST">
                <input type="hidden" name="acao" value="cadastrar">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Data</label>
                        <input type="date" name="data" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Cliente</label>
                        <select name="nome_cliente" class="form-select" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($clientes as $c): ?>
                                <option><?= htmlspecialchars($c) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Profissional</label>
                        <select name="nome_profissional" class="form-select" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($profissionais as $p): ?>
                                <option><?= htmlspecialchars($p) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Procedimento</label>
                        <select name="nome_procedimento" class="form-select" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($procedimentos as $pr): ?>
                                <option><?= htmlspecialchars($pr) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-rosa px-4">Agendar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>#</th><th>Cliente</th><th>Profissional</th><th>Procedimento</th><th>Valor</th><th>Data</th><th>Total</th><th>Ações</th></tr>
                </thead>
                <tbody>
                <?php
                foreach ($pdo->query("SELECT * FROM vw_agendamentos ORDER BY data_agendamento DESC")->fetchAll(PDO::FETCH_ASSOC) as $ag):
                    $stmtFn = $pdo->prepare("SELECT fn_total_agendamento(?)");
                    $stmtFn->execute([$ag['id_agendamento']]);
                    $total = $stmtFn->fetchColumn();
                ?>
                    <tr>
                        <td><?= $ag['id_agendamento'] ?></td>
                        <td><?= htmlspecialchars($ag['cliente']) ?></td>
                        <td><?= htmlspecialchars($ag['profissional']) ?></td>
                        <td><?= htmlspecialchars($ag['procedimento']) ?></td>
                        <td>R$ <?= number_format($ag['valor'], 2, ',', '.') ?></td>
                        <td><?= date('d/m/Y', strtotime($ag['data_agendamento'])) ?></td>
                        <td><strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></td>
                        <td>
                            <a href="?excluir=<?= $ag['id_agendamento'] ?>" class="btn btn-sm btn-outline-danger"
                               onclick="return confirmarExclusao('Excluir este agendamento?')">
                               <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/script.js"></script>
</body>
</html>
