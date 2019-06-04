-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 04-Jun-2019 às 16:04
-- Versão do servidor: 5.7.23
-- versão do PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dblanches`
--
CREATE DATABASE IF NOT EXISTS `dblanches` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `dblanches`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

DROP TABLE IF EXISTS `alunos`;
CREATE TABLE IF NOT EXISTS `alunos` (
  `matricula` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `turma` int(11) NOT NULL,
  PRIMARY KEY (`matricula`),
  UNIQUE KEY `UNIQUE` (`nome`,`codigo`) USING BTREE,
  KEY `FK_TURMAS_ALUNOS` (`turma`)
) ENGINE=InnoDB AUTO_INCREMENT=2017555556 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`matricula`, `nome`, `codigo`, `turma`) VALUES
(2017315143, 'Henrique Michels Voicolesco', '8a45as54sf8sdf1', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `registros`
--

DROP TABLE IF EXISTS `registros`;
CREATE TABLE IF NOT EXISTS `registros` (
  `id_registro` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_aluno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricula_aluno` int(11) NOT NULL,
  `turma_aluno` int(11) NOT NULL,
  `timestamp_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_registro`),
  KEY `FK_ALUNOS_REGISTROS` (`matricula_aluno`),
  KEY `FK_TURMAS_REGISTROS` (`turma_aluno`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `registros`
--

INSERT INTO `registros` (`id_registro`, `codigo_aluno`, `matricula_aluno`, `turma_aluno`, `timestamp_registro`) VALUES
(1, '8a45as54sf8sdf1', 2017315143, 2, '2019-06-02 01:23:59'),
(2, '8a45as54sf8sdf1', 2017315143, 2, '2019-06-02 01:24:12'),
(3, '8a45as54sf8sdf1', 2017315143, 2, '2019-06-02 01:24:12'),
(4, '8a45as54sf8sdf1', 2017315143, 2, '2019-06-02 01:24:12'),
(5, '8a45as54sf8sdf1', 2017315143, 2, '2019-06-02 01:24:12'),
(6, '8a45as54sf8sdf1', 2017315143, 2, '2019-06-02 01:24:12');

-- --------------------------------------------------------

--
-- Estrutura da tabela `servidores`
--

DROP TABLE IF EXISTS `servidores`;
CREATE TABLE IF NOT EXISTS `servidores` (
  `id_servidor` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_servidor`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `servidores`
--

INSERT INTO `servidores` (`id_servidor`, `email`, `nome`, `senha`) VALUES
(1, 'hm_voicolesco@hotmail.com', 'Henrique', '12345');

-- --------------------------------------------------------

--
-- Estrutura da tabela `turmas`
--

DROP TABLE IF EXISTS `turmas`;
CREATE TABLE IF NOT EXISTS `turmas` (
  `id_turma` int(11) NOT NULL AUTO_INCREMENT,
  `curso` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semestre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modalidade` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dias_lanche` set('Domingo','Segunda-Feira','Terça-Feira','Quarta-Feira','Quinta-Feira','Sexta-Feira','Sábado') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_turma`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `turmas`
--

INSERT INTO `turmas` (`id_turma`, `curso`, `semestre`, `modalidade`, `dias_lanche`) VALUES
(2, 'Técnico Informática para Internet', '5º Semestre', 'Concomitante', 'Terça-Feira,Quinta-Feira'),
(23, 'Administração', '5º Semestre', 'Concomitante', 'Segunda-Feira,Terça-Feira,Quinta-Feira');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `alunos`
--
ALTER TABLE `alunos`
  ADD CONSTRAINT `FK_TURMAS_ALUNOS` FOREIGN KEY (`turma`) REFERENCES `turmas` (`id_turma`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `FK_ALUNOS_REGISTROS` FOREIGN KEY (`matricula_aluno`) REFERENCES `alunos` (`matricula`),
  ADD CONSTRAINT `FK_TURMAS_REGISTROS` FOREIGN KEY (`turma_aluno`) REFERENCES `turmas` (`id_turma`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
