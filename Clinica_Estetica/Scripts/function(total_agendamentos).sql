DELIMITER $$

CREATE FUNCTION fn_total_agendamento(
    p_id_agendamento INT
)

RETURNS DECIMAL(10,2)
DETERMINISTIC

BEGIN

    DECLARE total DECIMAL(10,2);

    SELECT SUM(pr.valor)
    INTO total FROM agendamento_procedimento ap

    JOIN procedimento pr
        ON ap.id_procedimento = pr.id_procedimento

    WHERE ap.id_agendamento = p_id_agendamento;
    RETURN total;

END $$

DELIMITER ;

SELECT fn_total_agendamento(1);