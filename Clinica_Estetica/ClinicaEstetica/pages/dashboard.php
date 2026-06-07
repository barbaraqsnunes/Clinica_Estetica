<?php require_once '../conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Clínica Estética</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

<div class="sidebar">
    <div class="logo"><i class="bi bi-flower1"></i> Clínica Estética</div>
    <a href="dashboard.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="clientes.php"><i class="bi bi-people"></i> Clientes</a>
    <a href="profissionais.php"><i class="bi bi-person-badge"></i> Profissionais</a>
    <a href="procedimentos.php"><i class="bi bi-clipboard-heart"></i> Procedimentos</a>
    <a href="agendamentos.php"><i class="bi bi-calendar-check"></i> Agendamentos</a>
    <a href="relatorios.php"><i class="bi bi-bar-chart"></i> Relatórios</a>
</div>

<div class="topbar">
    <h5 class="mb-0 text-muted">Bem-vinda ao Sistema <span style="color:var(--rosa)">✦</span></h5>
</div>

<div class="conteudo">
    <h4 class="mb-4">Dashboard</h4>

    <?php
    $totalClientes      = $pdo->query("SELECT COUNT(*) FROM cliente")->fetchColumn();
    $totalProfissionais = $pdo->query("SELECT COUNT(*) FROM profissional")->fetchColumn();
    $totalProcedimentos = $pdo->query("SELECT COUNT(*) FROM procedimento")->fetchColumn();
    $totalAgendamentos  = $pdo->query("SELECT COUNT(*) FROM agendamento")->fetchColumn();
    ?>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card card-stat p-4 text-center">
                <div class="numero"><?= $totalClientes ?></div>
                <div class="text-muted"><i class="bi bi-people text-danger"></i> Clientes</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat p-4 text-center">
                <div class="numero"><?= $totalProfissionais ?></div>
                <div class="text-muted"><i class="bi bi-person-badge text-primary"></i> Profissionais</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat p-4 text-center">
                <div class="numero"><?= $totalProcedimentos ?></div>
                <div class="text-muted"><i class="bi bi-clipboard-heart text-success"></i> Procedimentos</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat p-4 text-center">
                <div class="numero"><?= $totalAgendamentos ?></div>
                <div class="text-muted"><i class="bi bi-calendar-check" style="color:var(--rosa)"></i> Agendamentos</div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h6 class="mb-0"><i class="bi bi-calendar3 text-danger me-2"></i>Próximos Agendamentos</h6>
        </div>
        <div class="card-body px-4">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>#</th><th>Cliente</th><th>Profissional</th><th>Procedimento</th><th>Valor</th><th>Data</th></tr>
                </thead>
                <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM vw_agendamentos ORDER BY data_agendamento ASC LIMIT 10");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                    <tr>
                        <td><?= $row['id_agendamento'] ?></td>
                        <td><?= htmlspecialchars($row['cliente']) ?></td>
                        <td><?= htmlspecialchars($row['profissional']) ?></td>
                        <td><?= htmlspecialchars($row['procedimento']) ?></td>
                        <td>R$ <?= number_format($row['valor'], 2, ',', '.') ?></td>
                        <td><?= date('d/m/Y', strtotime($row['data_agendamento'])) ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/script.js"></script>
</body>
</html>
