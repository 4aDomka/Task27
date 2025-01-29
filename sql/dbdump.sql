CREATE SCHEMA sfimggallery AUTHORIZATION postgres;
CREATE TYPE sfimggallery."_roles" (
	INPUT = array_in,
	OUTPUT = array_out,
	RECEIVE = array_recv,
	SEND = array_send,
	ANALYZE = array_typanalyze,
	ALIGNMENT = 8,
	STORAGE = any,
	CATEGORY = A,
	ELEMENT = sfimggallery.roles,
	DELIMITER = ',');
CREATE TYPE sfimggallery."_rolesmap" (
	INPUT = array_in,
	OUTPUT = array_out,
	RECEIVE = array_recv,
	SEND = array_send,
	ANALYZE = array_typanalyze,
	ALIGNMENT = 8,
	STORAGE = any,
	CATEGORY = A,
	ELEMENT = sfimggallery.rolesmap,
	DELIMITER = ',');
CREATE TYPE sfimggallery."_users" (
	INPUT = array_in,
	OUTPUT = array_out,
	RECEIVE = array_recv,
	SEND = array_send,
	ANALYZE = array_typanalyze,
	ALIGNMENT = 8,
	STORAGE = any,
	CATEGORY = A,
	ELEMENT = sfimggallery.users,
	DELIMITER = ',');
CREATE SEQUENCE sfimggallery.roles_role_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 2147483647
	START 1
	CACHE 1
	NO CYCLE;
CREATE SEQUENCE sfimggallery.users_user_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 2147483647
	START 1
	CACHE 1
	NO CYCLE;
CREATE TABLE sfimggallery.roles (
	role_id serial NOT NULL,
	role_name varchar(30) NOT NULL,
	CONSTRAINT roles_pkey PRIMARY KEY (role_id)
);
CREATE TABLE sfimggallery.users (
	user_id serial NOT NULL,
	user_login varchar(30) NOT NULL,
	user_password varchar(32) NOT NULL,
	user_hash varchar(32) NOT NULL DEFAULT ''::character varying,
	CONSTRAINT unique_login UNIQUE (user_login),
	CONSTRAINT users_pkey PRIMARY KEY (user_id)
);
CREATE TABLE sfimggallery.rolesmap (
	role_id int4 NOT NULL,
	user_id int4 NOT NULL,
	CONSTRAINT rolesmap_pkey PRIMARY KEY (role_id, user_id),
	CONSTRAINT fk_roles FOREIGN KEY (role_id) REFERENCES sfimggallery.roles(role_id),
	CONSTRAINT fk_users FOREIGN KEY (user_id) REFERENCES sfimggallery.users(user_id)
);
