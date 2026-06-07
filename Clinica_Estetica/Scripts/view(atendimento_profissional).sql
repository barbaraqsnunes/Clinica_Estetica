CREATE VIEW vw_atendimentos_profissional AS

SELECT
    p.nome AS profissional,
    COUNT(a.id_agendamento) AS quantidade_atendimentos

FROM profissional p

JOIN agendamento a
    ON p.id_profissional = a.id_profissional
GROUP BY p.nome;

SELECT * FROM vw_atendimentos_profissional;
