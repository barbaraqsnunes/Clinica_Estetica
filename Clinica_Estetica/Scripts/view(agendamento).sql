DROP VIEW IF EXISTS vw_agendamentos;

CREATE VIEW vw_agendamentos AS
SELECT
    a.id_agendamento,
    c.nome AS cliente,
    p.nome AS profissional,
    pr.nome AS procedimento,
    pr.valor,
    a.data_agendamento
FROM agendamento a
JOIN cliente c ON a.id_cliente = c.id_cliente
JOIN profissional p ON a.id_profissional = p.id_profissional
LEFT JOIN agendamento_procedimento ap ON a.id_agendamento = ap.id_agendamento  
LEFT JOIN procedimento pr ON ap.id_procedimento = pr.id_procedimento;