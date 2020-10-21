CREATE SCHEMA `sistema_tarefas`;
USE `sistema_tarefas`;


CREATE TABLE `usuario` (
    `cod` VARCHAR(15) PRIMARY KEY,
    `email` VARCHAR(150) UNIQUE NOT NULL,
    `senha` VARCHAR(256) NOT NULL
);

CREATE TABLE `tarefa` (
    `cod` VARCHAR(15) PRIMARY KEY,
    `titulo` TINYTEXT NOT NULL,
    `descricao` TEXT NOT NULL,
    `dataInicio` DATETIME NOT NULL,
    `dataFim` DATETIME NOT NULL,
    `status` TINYINT(1) COMMENT '0 TAREFA INATIVA / 1 TAREFA ATIVA' DEFAULT 1 NOT NULL,
    `codUsuario` VARCHAR(15) NOT NULL,
    FOREIGN KEY (codUsuario) REFERENCES usuario(cod) ON DELETE CASCADE
);

-- view para listagem das tarefas de forma ordenada e com dados formatado
CREATE VIEW `listarTarefas` AS
SELECT      `cod`,
            `titulo`,
            `descricao`,
            DATE_FORMAT(`dataInicio`, '%H:%i %d/%m/%Y') AS `dataInicio`,
            DATE_FORMAT(`dataFim`, '%H:%i %d/%m/%Y') AS `dataFim`,
            `status`,
            `codUsuario`
FROM        `tarefa`
ORDER BY    `codUsuario` ASC,
            `status` DESC,
            `dataInicio`,
            `dataFim` DESC;