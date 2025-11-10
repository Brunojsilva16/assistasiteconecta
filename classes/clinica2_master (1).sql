-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 15/02/2025 às 10:24
-- Versão do servidor: 8.0.40-cll-lve
-- Versão do PHP: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `clinica2_master`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios_a`
--

CREATE TABLE `usuarios_a` (
  `id_user` int UNSIGNED NOT NULL,
  `nome` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `senha` varchar(70) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_tipo` int NOT NULL DEFAULT '0',
  `user_status` int NOT NULL DEFAULT '0',
  `data_cad` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios_a`
--

INSERT INTO `usuarios_a` (`id_user`, `nome`, `email`, `senha`, `user_tipo`, `user_status`, `data_cad`) VALUES
(1, 'Bruno Silva', 'brunojsilvasuporte@gmail.com', '$2y$10$IFUjVv59x1RsvPoR8Hx/jOXG0fkPnUdogaulcyfEg5mch1sujNCTS', 2, 1, '2025-02-07 00:00:00');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `usuarios_a`
--
ALTER TABLE `usuarios_a`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuarios_a`
--
ALTER TABLE `usuarios_a`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
