delimiter $$

create procedure sp_adicionar_procedimento(

    in p_id_agendamento int,
    in p_nome_procedimento varchar(100)

)

begin

declare v_id_procedimento int;

select id_procedimento
into v_id_procedimento
from procedimento
where nome = p_nome_procedimento;

insert into agendamento_procedimento(

    id_agendamento,
    id_procedimento

)

values(

    p_id_agendamento,
    v_id_procedimento

);

end $$

delimiter ;

call sp_adicionar_procedimento(1, 'Botox Facial');