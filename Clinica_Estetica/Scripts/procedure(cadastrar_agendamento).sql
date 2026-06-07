DELIMITER $$

create procedure sp_cadastrar_agendamento(
    in p_data date,
    in p_nome_cliente varchar(100),
    in p_nome_profissional varchar(100)
)

BEGIN

    declare v_cliente int;
    declare v_profissional int;

    select id_cliente into v_cliente from cliente
    WHERE nome = p_nome_cliente;

    SELECT id_profissional INTO v_profissional FROM profissional
    WHERE nome = p_nome_profissional;

    INSERT INTO agendamento(
        data_agendamento,id_cliente,id_profissional)
    VALUES(
        p_data,v_cliente,v_profissional);

END $$

DELIMITER ;

CALL sp_cadastrar_agendamento(
'2026-06-08','Ana Clara','Patricia Alves');
