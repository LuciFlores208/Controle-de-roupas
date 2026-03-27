-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/03/2026 às 14:00
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ativisandro`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `marca`
--

CREATE TABLE `marca` (
  `idMarca` int(11) NOT NULL,
  `Nome` varchar(25) DEFAULT NULL,
  `Tipo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `marca`
--

INSERT INTO `marca` (`idMarca`, `Nome`, `Tipo`) VALUES
(1, ' Chanel', 'Luxo'),
(2, 'Gucci', 'Luxo'),
(3, 'Prada', 'Luxo'),
(4, 'Hermes', 'Luxo'),
(5, 'LouisVuitton', 'Luxo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `modelo`
--

CREATE TABLE `modelo` (
  `idModelo` int(11) NOT NULL,
  `Tipo` varchar(25) DEFAULT NULL,
  `Nome` varchar(25) DEFAULT NULL,
  `idMarca` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `modelo`
--

INSERT INTO `modelo` (`idModelo`, `Tipo`, `Nome`, `idMarca`) VALUES
(1, 'Inverno', 'Casaco', 2),
(2, 'Verao', 'Vestido', 3),
(3, 'Outono', 'Bota', 4),
(4, 'Primavera', 'Salto', 1),
(5, 'Inverno', 'Bolsa', 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `roupas`
--

CREATE TABLE `roupas` (
  `idRoupas` int(11) NOT NULL,
  `idModelo` int(11) DEFAULT NULL,
  `idMarca` int(11) DEFAULT NULL,
  `Cor` char(10) DEFAULT NULL,
  `idTamanhos` int(11) DEFAULT NULL,
  `Sex` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `roupas`
--

INSERT INTO `roupas` (`idRoupas`, `idModelo`, `idMarca`, `Cor`, `idTamanhos`, `Sex`) VALUES
(1, 4, 4, 'Marrom', 36, 'Fem'),
(2, 5, 5, 'Branca', NULL, 'Fem'),
(3, 1, 1, 'Preta', 0, 'Man'),
(4, 3, 3, 'Dourado', 36, 'Fem'),
(5, 2, 2, 'Perola', 0, 'Fem');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tamanhos`
--

CREATE TABLE `tamanhos` (
  `idTamanhos` int(11) NOT NULL,
  `idRoupas` int(11) NOT NULL,
  `Tipo` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tamanhos`
--

INSERT INTO `tamanhos` (`idTamanhos`, `idRoupas`, `Tipo`) VALUES
(1, 1, '36'),
(2, 2, 'M'),
(3, 3, 'P'),
(4, 4, '37'),
(5, 5, 'P');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`idMarca`);

--
-- Índices de tabela `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`idModelo`),
  ADD KEY `FK_Modelo_Marca_idx` (`idMarca`);

--
-- Índices de tabela `roupas`
--
ALTER TABLE `roupas`
  ADD PRIMARY KEY (`idRoupas`),
  ADD KEY `FK_Roupas_Marca_idx` (`idMarca`),
  ADD KEY `FK_Roupas_Modelo_idx` (`idModelo`);

--
-- Índices de tabela `tamanhos`
--
ALTER TABLE `tamanhos`
  ADD PRIMARY KEY (`idTamanhos`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `modelo`
--
ALTER TABLE `modelo`
  MODIFY `idModelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `roupas`
--
ALTER TABLE `roupas`
  MODIFY `idRoupas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tamanhos`
--
ALTER TABLE `tamanhos`
  MODIFY `idTamanhos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `modelo`
--
ALTER TABLE `modelo`
  ADD CONSTRAINT `FK_Modelo_Marca` FOREIGN KEY (`idMarca`) REFERENCES `marca` (`idMarca`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `roupas`
--
ALTER TABLE `roupas`
  ADD CONSTRAINT `FK_Roupas_Marca` FOREIGN KEY (`idMarca`) REFERENCES `marca` (`idMarca`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Roupas_Modelo` FOREIGN KEY (`idModelo`) REFERENCES `modelo` (`idModelo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
