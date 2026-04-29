CREATE DATABASE IF NOT EXISTS aula10_crud
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE aula10_crud;

CREATE TABLE IF NOT EXISTS contato
(
    id        INT             NOT NULL AUTO_INCREMENT,
    nome      VARCHAR(350)    NOT NULL,
    email     VARCHAR(150)    NOT NULL,
    datahora  TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    mensagem  TEXT            NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB;
