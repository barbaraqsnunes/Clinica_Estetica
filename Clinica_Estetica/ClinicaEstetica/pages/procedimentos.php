<?php
require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'cadastrar') {
    $nome = trim($_POST['nome']);
    $valor = $_POST['valor'];
    if ($nome && $valor) {
        $pdo->prepare("INSERT INTO procedimento (nome, valor) VALUES (?, ?)")->execute([$nome, $valor]);
        $sucesso = "Procedimento cadastrado com sucesso!";
    } else {
        $erro = "Preencha todos os campos.";
    }
}

if (isset($_GET['excluir'])) {
    $pdo->prepare("DELETE FROM procedimento WHERE id_procedimento = ?")->execute([$_GET['excluir']]);
    header('Location: procedimentos.php'); exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Procedimentos - Clínica Estética</title>
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
    <a href="procedimentos.php" class="active"><i class="bi bi-clipboard-heart"></i> Procedimentos</a>
    <a href="agendamentos.php"><i class="bi bi-calendar-check"></i> Agendamentos</a>
    <a href="relatorios.php"><i class="bi bi-bar-chart"></i> Relatórios</a>
</div>
<div class="topbar"><h5 class="mb-0 text-muted">Gerenciar Procedimentos</h5></div>
<div class="conteudo">
    <h4 class="mb-4">Procedimentos</h4>

    <?php if (!empty($sucesso)): ?><div class="alert alert-success"><?= $sucesso ?></div><?php endif; ?>
    <?php if (!empty($erro)): ?><div class="alert alert-danger"><?= $erro ?></div><?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h6 class="mb-3"><i class="bi bi-plus-circle me-2 text-danger"></i>Novo Procedimento</h6>
            <form method="POST">
                <input type="hidden" name="acao" value="cadastrar">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="nome" class="form-control" placeholder="Nome do procedimento" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" name="valor" class="form-control" placeholder="Valor (R$)" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-rosa w-100">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>#</th><th>Nome</th><th>Valor</th><th>Ações</th></tr>
                </thead>
                <tbody>
                <?php foreach ($pdo->query("SELECT * FROM procedimento ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC) as $pr): ?>
                    <tr>
                        <td><?= $pr['id_procedimento'] ?></td>
                        <td><?= htmlspecialchars($pr['nome']) ?></td>
                        <td><span class="badge badge-rosa">R$ <?= number_format($pr['valor'], 2, ',', '.') ?></span></td>
                        <td>
                            <a href="?excluir=<?= $pr['id_procedimento'] ?>" class="btn btn-sm btn-outline-danger"
                               onclick="return confirmarExclusao('Excluir este procedimento?')">
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
