delimiter $$

create procedure sp_vincular_profissional(

    in p_nome_profissional varchar(100),
    in p_nome_procedimento varchar(100)

)

begin

declare v_id_profissional int;
declare v_id_procedimento int;

select id_profissional
into v_id_profissional
from profissional
where nome = p_nome_profissional;

select id_procedimento
into v_id_procedimento
from procedimento
where nome = p_nome_procedimento;

insert into profissional_procedimento(

    id_profissional,
    id_procedimento

)

values(

    v_id_profissional,
    v_id_procedimento

);

end $$

delimiter ;

call sp_vincular_profissional('Beatriz Santos','Botox Facial');

select * from profissional_procedimento;