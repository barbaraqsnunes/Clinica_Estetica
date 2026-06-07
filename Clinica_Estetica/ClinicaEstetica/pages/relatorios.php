<?php require_once '../conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relatórios - Clínica Estética</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/style.css"> rel="stylesheet">
</head>
<body>
<div class="sidebar">
    <div class="logo"><i class="bi bi-flower1"></i> Clínica Estética</div>
    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="clientes.php"><i class="bi bi-people"></i> Clientes</a>
    <a href="profissionais.php"><i class="bi bi-person-badge"></i> Profissionais</a>
    <a href="procedimentos.php"><i class="bi bi-clipboard-heart"></i> Procedimentos</a>
    <a href="agendamentos.php"><i class="bi bi-calendar-check"></i> Agendamentos</a>
    <a href="relatorios.php" class="active"><i class="bi bi-bar-chart"></i> Relatórios</a>
</div>
<div class="topbar"><h5 class="mb-0 text-muted">Relatórios</h5></div>
<div class="conteudo">
    <h4 class="mb-4">Relatórios</h4>

    <div class="row g-4">

        <!-- Atendimentos por profissional (vw_atendimentos_profissional) -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h6><i class="bi bi-person-lines-fill text-danger me-2"></i>Atendimentos por Profissional</h6>
                    <small class="text-muted">View: vw_atendimentos_profissional</small>
                </div>
                <div class="card-body px-4">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr><th>Profissional</th><th>Qtd. Atendimentos</th></tr>
                        </thead>
                        <tbody>
                        <?php
                        $atendimentos = $pdo->query("SELECT * FROM vw_atendimentos_profissional ORDER BY quantidade_atendimentos DESC")->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($atendimentos as $a):
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($a['profissional']) ?></td>
                                <td>
                                    <span class="badge rounded-pill" style="background:var(--rosa)">
                                        <?= $a['quantidade_atendimentos'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Profissionais e procedimentos (vw_profissionais_procedimentos) -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h6><i class="bi bi-clipboard2-data text-primary me-2"></i>Profissionais por Procedimento</h6>
                    <small class="text-muted">View: vw_profissionais_procedimentos</small>
                </div>
                <div class="card-body px-4">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr><th>Profissional</th><th>Especialidade</th><th>Procedimento</th><th>Valor</th></tr>
                        </thead>
                        <tbody>
                        <?php
                        $vinculos = $pdo->query("SELECT * FROM vw_profissionais_procedimentos ORDER BY profissional")->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($vinculos as $v):
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($v['profissional']) ?></td>
                                <td><small class="text-muted"><?= htmlspecialchars($v['especialidade']) ?></small></td>
                                <td><?= htmlspecialchars($v['procedimento']) ?></td>
                                <td>R$ <?= number_format($v['valor'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Total por agendamento (fn_total_agendamento) -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h6><i class="bi bi-cash-stack text-success me-2"></i>Total por Agendamento</h6>
                    <small class="text-muted">Function: fn_total_agendamento()</small>
                </div>
                <div class="card-body px-4">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr><th>#</th><th>Cliente</th><th>Profissional</th><th>Data</th><th>Total</th></tr>
                        </thead>
                        <tbody>
                        <?php
                        $ags = $pdo->query("SELECT DISTINCT id_agendamento, cliente, profissional, data_agendamento FROM vw_agendamentos ORDER BY data_agendamento DESC")->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($ags as $ag):
                            $stmtFn = $pdo->prepare("SELECT fn_total_agendamento(?)");
                            $stmtFn->execute([$ag['id_agendamento']]);
                            $total = $stmtFn->fetchColumn();
                        ?>
                            <tr>
                                <td><?= $ag['id_agendamento'] ?></td>
                                <td><?= htmlspecialchars($ag['cliente']) ?></td>
                                <td><?= htmlspecialchars($ag['profissional']) ?></td>
                                <td><?= date('d/m/Y', strtotime($ag['data_agendamento'])) ?></td>
                                <td><strong class="text-success">R$ <?= number_format($total, 2, ',', '.') ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/script.js"></script>
</body>
</html>
