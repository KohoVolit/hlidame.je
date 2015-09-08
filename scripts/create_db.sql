-- Role: hlidame_api

-- DROP ROLE hlidame_api;

CREATE ROLE hlidame_api
  NOSUPERUSER INHERIT NOCREATEDB NOCREATEROLE NOREPLICATION;



-- Database: hlidame

-- DROP DATABASE hlidame;

CREATE DATABASE hlidame
  WITH OWNER = hlidame_api_user
       ENCODING = 'UTF8'
       TABLESPACE = pg_default
       LC_COLLATE = 'en_IE.UTF-8'
       LC_CTYPE = 'en_IE.UTF-8'
       CONNECTION LIMIT = -1;

-- Table: activities

-- DROP TABLE activities;

CREATE TABLE activities
(
  id serial NOT NULL,
  activity_code character varying NOT NULL,
  activity_title character varying NOT NULL,
  date date NOT NULL,
  person_id integer NOT NULL,
  person_group_code character varying NOT NULL,
  person_party_code character varying NOT NULL,
  person_country_code character varying NOT NULL,
  detail text,
  CONSTRAINT activities_pkey PRIMARY KEY (id),
  CONSTRAINT activities_date_activity_code_activity_title_person_id_key UNIQUE (date, activity_code, activity_title, person_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE activities
  OWNER TO hlidame_api_user;
  
-- Table: countries

-- DROP TABLE countries;

CREATE TABLE countries
(
  code character varying NOT NULL,
  name character varying NOT NULL,
  picture character varying NOT NULL,
  name_en character varying NOT NULL,
  CONSTRAINT countries_pkey PRIMARY KEY (code)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE countries
  OWNER TO hlidame_api_user;


-- Table: groups

-- DROP TABLE groups;

CREATE TABLE groups
(
  code character varying NOT NULL,
  name character varying NOT NULL,
  picture character varying,
  CONSTRAINT groups_pkey PRIMARY KEY (code)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE groups
  OWNER TO hlidame_api_user;

-- Table: parties

-- DROP TABLE parties;

CREATE TABLE parties
(
  code character varying NOT NULL,
  name character varying NOT NULL,
  CONSTRAINT parties_pkey PRIMARY KEY (code)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE parties
  OWNER TO hlidame_api_user;


-- Table: people

-- DROP TABLE people;

CREATE TABLE people
(
  id integer NOT NULL,
  name character varying NOT NULL,
  group_code character varying NOT NULL,
  party_code character varying NOT NULL,
  country_code character varying NOT NULL,
  weight real NOT NULL,
  CONSTRAINT people_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE people
  OWNER TO hlidame_api_user;

