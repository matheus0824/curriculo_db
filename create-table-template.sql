create database curriculo_db;

use curriculo_db;

create table if not exists dados_pessoais(
	id int auto_increment primary key,
	nome VARCHAR(100) not null,
	cargo VARCHAR(100),
	resumo TEXT,
	info_pessoais TEXT
);

create table  if not exists contatos(
	id int auto_increment primary key,
	dados_pessoais_id int not null,
	email varchar(100) not null,
	telefone varchar(20),
	perfis_profissionais Text,
	foreign key (dados_pessoais_id) references dados_pessoais(id) 
	on delete cascade
);

create table if not exists experiencias(
	id int auto_increment primary key,
	dados_pessoais_id int not null,
	empresa varchar(100) not null,
	funcao varchar(100) not null,
	periodo varchar(50),
	descricao text,
	foreign key (dados_pessoais_id) references dados_pessoais(id) 
	on delete cascade 
	);

create table if not exists formacao(
	id int auto_increment primary key,
	dados_pessoais_id int not null,
	instituicao varchar(100) not null,
	curso varchar(100) not null,
	periodo varchar(50),
	foreign key (dados_pessoais_id) references dados_pessoais(id) 
	on delete cascade 
	
);

ALTER TABLE dados_pessoais 
ADD COLUMN foto_perfil VARCHAR(255) AFTER info_pessoais,
ADD COLUMN foto_capa VARCHAR(255) AFTER foto_perfil;