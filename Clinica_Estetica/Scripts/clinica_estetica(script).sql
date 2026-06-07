create database clinica_estetica;
use clinica_estetica;

create table cliente (
    id_cliente int primary key auto_increment,
    nome varchar(100),
    telefone varchar(20)
);

create table profissional (
    id_profissional int primary key auto_increment,
    nome varchar(100),
    especialidade varchar(100),
    crm varchar(20)
);

create table procedimento (
    id_procedimento int primary key auto_increment,
    nome varchar(100),
    valor decimal(10,2)
);

create table agendamento (
    id_agendamento int primary key auto_increment,
    data_agendamento date,
    id_cliente int,
    id_profissional int,
    foreign key (id_cliente) references cliente(id_cliente),
    foreign key (id_profissional) references profissional(id_profissional)
);

create table profissional_procedimento (
    id_profissional int,
    id_procedimento int,
    primary key (id_profissional, id_procedimento),
    foreign key (id_profissional) references profissional(id_profissional),
    foreign key (id_procedimento) references procedimento(id_procedimento)
);

create table agendamento_procedimento (
    id_agendamento int,
    id_procedimento int,
    primary key (id_agendamento, id_procedimento),
    foreign key (id_agendamento) references agendamento(id_agendamento),
    foreign key (id_procedimento) references procedimento(id_procedimento)
);

INSERT INTO cliente (nome, telefone) VALUES
('Ana Clara', '8199999-1111'),
('Marcos Silva', '8198888-2222'),
('Juliana Souza', '8197777-3333'),
('Carlos Henrique', '8196666-4444'),
('Fernanda Lima', '8195555-5555');


INSERT INTO profissional (nome, especialidade, crm) VALUES
('Patricia Alves', 'Esteticista', 'CRM1001'),
('Ricardo Mendes', 'Dermatologista', 'CRM1002'),
('Camila Rocha', 'Terapeuta Capilar', 'CRM1003'),
('Eduardo Lima', 'Cirurgião Plástico', 'CRM1004'),
('Beatriz Santos', 'Masoterapeuta', 'CRM1005');


INSERT INTO procedimento (nome, valor) VALUES
('Limpeza de Pele', 120.00),
('Peeling Facial', 180.00),
('Hidratação Capilar', 150.00),
('Botox Facial', 900.00),
('Massagem Relaxante', 100.00);


INSERT INTO agendamento (
    data_agendamento,
    id_cliente,
    id_profissional
) VALUES
('2026-05-10', 1, 1),('2026-05-11', 2, 2),('2026-05-12', 3, 3),('2026-05-13', 4, 4),('2026-05-14', 5, 5);

INSERT INTO profissional_procedimento VALUES
(1,1),(2,2),(3,3),(4,4),(5,5);

INSERT INTO agendamento_procedimento (
    id_agendamento,
    id_procedimento
) VALUES
(1,1),(2,2),(3,3),(4,4),(5,5);

select * from agendamento_procedimento;
SELECT
    a.id_agendamento,c.nome AS cliente,p.nome AS profissional,pr.nome AS procedimento,a.data_agendamento 
    FROM agendamento a

JOIN cliente c
    ON a.id_cliente = c.id_cliente

JOIN profissional p
    ON a.id_profissional = p.id_profissional

JOIN agendamento_procedimento ap
    ON a.id_agendamento = ap.id_agendamento

JOIN procedimento pr
    ON ap.id_procedimento = pr.id_procedimento;