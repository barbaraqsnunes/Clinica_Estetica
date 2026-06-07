CREATE VIEW vw_profissionais_procedimentos AS

SELECT
    profissional.nome AS profissional,
    profissional.especialidade,
    procedimento.nome AS procedimento,
    procedimento.valor

FROM profissional_procedimento

JOIN profissional
    ON profissional_procedimento.id_profissional = profissional.id_profissional

JOIN procedimento
    ON profissional_procedimento.id_procedimento = procedimento.id_procedimento;

SELECT * FROM vw_profissionais_procedimentos;