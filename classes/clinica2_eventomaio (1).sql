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
-- Banco de dados: `clinica2_eventomaio`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `codigo`
--

CREATE TABLE `codigo` (
  `id_cod` int UNSIGNED NOT NULL,
  `nome_cod` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `codigo_cod` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `porcent_cod` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `datacad` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `codigo`
--

INSERT INTO `codigo` (`id_cod`, `nome_cod`, `codigo_cod`, `porcent_cod`, `datacad`) VALUES
(1, 'Adriana', 'ADRI01', '0.05', '2024-11-20 15:06:03'),
(2, 'Alexciane', 'ALEXCI02', '0.05', '2024-11-20 15:06:03'),
(3, 'Ana Cristina', 'CRIS03', '0.05', '2024-11-20 15:15:18'),
(4, 'Andreza', 'DEZA04', '0.05', '2024-11-20 15:15:18'),
(5, 'Beatriz', 'BIA05', '0.05', '2024-11-20 15:15:18'),
(6, 'Dalila', 'DALILA06', '0.05', '2024-11-20 15:15:18'),
(7, 'Daniella', 'DANI07', '0.05', '2024-11-20 15:15:18'),
(8, 'Dayane', 'DAY13', '0.05', '2024-11-20 15:15:18'),
(9, 'Fernanda', 'NANDA09', '0.05', '2024-11-20 15:15:18'),
(10, 'Gabriela Agra', 'GABIA10', '0.05', '2024-11-20 15:15:18'),
(11, 'Gabriela Grangeiro', 'GABIG11', '0.05', '2024-11-20 15:15:18'),
(12, 'Giselle', 'GI12', '0.05', '2024-11-20 15:18:24'),
(13, 'Iara', 'IARA08', '0.05', '2024-11-20 15:18:24'),
(14, 'Jocelma', 'JO14', '0.05', '2024-11-20 15:18:24'),
(15, 'Karla', 'KARLA14', '0.05', '2024-11-20 15:18:24'),
(16, 'Luan', 'LUAN15', '0.05', '2024-11-20 15:18:24'),
(17, 'Monique', 'MONI16', '0.05', '2024-11-20 15:18:24'),
(18, 'Rochanne', 'ROCHA17', '0.05', '2024-11-20 15:18:24'),
(19, 'Stephanny', 'STEP18', '0.05', '2024-11-20 15:18:24'),
(20, 'Talita', 'TALI19', '0.05', '2024-11-20 15:18:24'),
(21, 'Tatiane', 'TATI20', '0.05', '2024-11-20 15:18:24'),
(22, 'Thais', 'THA21', '0.05', '2024-11-20 15:18:24'),
(23, 'Vanessa', 'VAN22', '0.05', '2024-11-20 15:18:24'),
(24, 'Rodolfo (Monitores)', 'ROD23', '0.05', '2024-11-20 15:22:02'),
(25, 'Beatriz (Monitores)', 'BEA24', '0.05', '2024-11-20 15:22:02'),
(26, 'Jessica (Monitores)', 'JESS25', '0.05', '2024-11-20 15:22:02'),
(27, 'Matheus', 'MAT26', '0.05', '2024-11-20 15:22:02'),
(28, 'Renan', 'RENAN27', '0.05', '2024-11-20 17:24:29'),
(29, 'Grupo 01', 'XEST2L', NULL, '2025-01-05 19:04:49'),
(30, 'Conecta', 'CONECTA', '40', '2025-01-29 17:03:28'),
(31, 'Processo', 'processo', '15', '2025-02-12 17:09:43');

-- --------------------------------------------------------

--
-- Estrutura para tabela `credenciador`
--

CREATE TABLE `credenciador` (
  `id_user` int UNSIGNED NOT NULL,
  `senha` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `credenciador`
--

INSERT INTO `credenciador` (`id_user`, `senha`) VALUES
(8, '$2y$10$UUS93Lw9tgYtsaxNfmXqsOT3qzLEiNaBDffOua4.aG1CxT..AG.nu');

-- --------------------------------------------------------

--
-- Estrutura para tabela `evento`
--

CREATE TABLE `evento` (
  `id_ev` int UNSIGNED NOT NULL,
  `nome_ev` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cpf_ev` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_ev` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefone_ev` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `datacad` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `evento`
--

INSERT INTO `evento` (`id_ev`, `nome_ev`, `cpf_ev`, `email_ev`, `telefone_ev`, `datacad`) VALUES
(1, 'Paulo', NULL, 'paulodetarso_pt@hotmail.com', '(81) 917900-250', '2025-01-28 18:07:06'),
(3, 'Gabriela Grangeiro ', NULL, 'psi.gabrielagrangeiro@gmail.com', '(81) 98712-1589', '2025-01-28 18:09:06'),
(4, 'Juliana Ogawa Garcia Costa ', NULL, 'psi.julianagarcia@gmail.com', '17997152455', '2025-01-28 18:57:06'),
(5, 'Isadora Ferreira ', NULL, 'isadoramariaamorim2015@hotmail.com', '81983162636', '2025-01-28 18:59:06'),
(6, 'Mariana ', NULL, 'maarianacamerao@gmail.com', '+55 17 99216-22', '2025-01-28 21:34:09'),
(7, 'Jullyane Kassia Melo de Oliveira ', NULL, 'jullyanekassia227@gmail.com', '(81) 98835-5680', '2025-01-29 09:15:09'),
(8, 'Michele Silva', NULL, 'michelesilva_33@hotmail.com', '(81) 99208-2274', '2025-01-29 09:41:09'),
(9, 'Paulo teste ', NULL, 'paulopsimelo@gmail.com', '(81) 97900-2850', '2025-01-29 20:31:08'),
(10, 'Dayane', NULL, 'dayane.souzapsi@gmail.com', '(81) 99405-4570', '2025-01-30 14:29:02'),
(11, 'Edivania Martins de Melo Silva ', NULL, 'vaniameloeduc@hotmail.com', '(81) 98584-1705', '2025-01-30 14:43:02'),
(12, 'Jocelma Maria Andrade Marins ', NULL, 'psicojocelmamarins@gmail.com', '81988519911', '2025-01-30 15:47:03'),
(13, 'Paulo teste ', NULL, 'paulopsimelo@gmail.com', '(81) 97900-2950', '2025-01-30 18:10:06'),
(14, 'Alexciane ', NULL, 'alexcianebeatriz@hotmail.com', '(81) 99874-5938', '2025-01-30 19:57:07'),
(15, 'Alexciane', NULL, 'alexcianebeatriz@hotmail.com', '(81) 99874-5938', '2025-01-30 19:58:07'),
(16, 'Monike', NULL, 'monikemacielbp@gmail.com', '(81) 99706-5151', '2025-01-30 21:01:09'),
(17, 'Joana Pimentel', NULL, 'joanapmoreira@hotmail.com', '5581999149658', '2025-01-30 21:19:09'),
(18, 'Dalila', NULL, 'dalilareis.pscologia@gmail.com', '(81) 99504-5078', '2025-01-30 21:38:09'),
(19, 'Maria da Conceição Gomes Freire', NULL, 'ceicapsicologia@outlook.com', '(87) 98841-4297', '2025-01-31 05:31:05'),
(20, 'Analúcia trindade de Sá Barreto', NULL, 'analucia.trindade@hotmail.com', '(81) 99959-5426', '2025-01-31 06:59:06'),
(21, 'Maria do perpétuo socorro branco Gomes Tabosa ', NULL, 'sobranco@hotmail.com', '(81) 99921-2003', '2025-01-31 08:09:08'),
(22, 'Ana', NULL, 'analalves@yahoo.com.br', '(81) 8198717-63', '2025-01-31 08:50:08'),
(23, 'Suzana', NULL, 'su_carneiro@hotmail.com', '5581999977464', '2025-01-31 09:00:09'),
(24, 'Angela', NULL, 'angela@macaubas.com', '(81) 99963-0342', '2025-01-31 10:10:10'),
(25, 'Natalhya Quidute ', NULL, 'natalhyaquidute@gmail.com', '(81) 99644-4331', '2025-01-31 12:56:12'),
(26, 'Nataly', NULL, 'nathypatricia@hotmail.com', '+55 (81) 99855-', '2025-01-31 19:50:07'),
(27, 'Ângela Albuquerque ', NULL, 'angela.mmtf@hotmail.com', '81986517736', '2025-01-31 22:14:10'),
(28, 'Tereza Cristina Guimarães ', NULL, 'psitetezacris@uahoo.com.br', '(81) 99952-0446', '2025-02-01 08:38:08'),
(29, 'Edja ', NULL, 'edja_moreno@hotmail.com', '+55 (81) 992863', '2025-02-01 14:05:02'),
(30, 'Rosineide ', NULL, 'santanarosi78@gmail.com', '81999773230', '2025-02-01 17:19:05'),
(31, 'Daniela Ribeiro', NULL, 'daniela.maria.ribeiro@gmail.com', '(81) 98969-4848', '2025-02-01 21:52:09'),
(32, 'Andrea', NULL, 'andreabbarauna@gmail.com', '5581 982106271', '2025-02-02 02:21:02'),
(33, 'Elza Baccas', NULL, 'psicanalistaelzabaccas@gmail.com', '(81) 98592-1432', '2025-02-02 09:13:09'),
(34, 'Elza Baccas', NULL, 'psicanalistaelzabaccas@gmail.com', '81985921432', '2025-02-02 09:22:09'),
(35, 'Ana Carolina Souza ', NULL, 'casouzapsi@gmail.com', '(81) 99892-7425', '2025-02-02 10:38:10'),
(36, 'Paula Tarsiane Pessoa de Melo ', NULL, 'paulatarsiane@hotmail.com', '(81) 99601-0061', '2025-02-02 11:16:11'),
(37, 'Teresa Veras ', NULL, 'teresa.veras@hotmail.com', '(55) 99652-0378', '2025-02-03 16:24:04'),
(38, 'Juliana ', NULL, 'julianaabarros.psi@gmail.com', '81 9.8838-7737', '2025-02-03 16:30:04'),
(39, 'Andreza Amanda Nepomuceno da silva', NULL, 'dezapsi@gmail.com', '(81) 99103-8170', '2025-02-03 17:03:05'),
(40, 'Elizabete Ventura', NULL, 'elizabeteventura2020@gmail.com', '+55 (81) 98159–', '2025-02-03 17:51:05'),
(41, 'Maíza Oliveira de Lima ', NULL, 'maizapsic@hotmail.com', '(81) 992837989', '2025-02-04 14:49:02'),
(42, 'dayane souza ', NULL, 'dayanepsouza@hotmail.com', '(81) 99405-4570', '2025-02-06 13:32:01'),
(43, 'Elba Virgínia ', NULL, 'elbavirginia.psicologia1@gmail.com', '5581996980299', '2025-02-09 01:13:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `grupo`
--

CREATE TABLE `grupo` (
  `id_in` int UNSIGNED NOT NULL,
  `nome_in` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cpf_in` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_in` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefone_in` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `codigo_in` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `valor_in` double DEFAULT NULL,
  `datacad` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `grupo`
--

INSERT INTO `grupo` (`id_in`, `nome_in`, `cpf_in`, `email_in`, `telefone_in`, `codigo_in`, `valor_in`, `datacad`) VALUES
(1, 'ASSISTENCIA T IN', '123.456.789-46', 'brunojsilva16@gmail.com', '(81) 99639-0690', 'YXGV9Q', 348, '2025-01-28 20:37:08'),
(2, 'Paulo teste ', '045.501.154-60', 'paulopsimelo@gmail.com', '(81) 97900-2850', 'QSL1RK', 348, '2025-01-28 21:09:09');

-- --------------------------------------------------------

--
-- Estrutura para tabela `inscricao`
--

CREATE TABLE `inscricao` (
  `id_insc` int UNSIGNED NOT NULL,
  `nome_insc` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cpf_insc` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_insc` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefone_insc` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `transacao_insc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `valor_insc` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cupom_insc` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `categoria_insc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `doc_insc` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_insc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lote_insc` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomecracha_insc` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `check_in` int NOT NULL DEFAULT '0',
  `datacad` datetime DEFAULT CURRENT_TIMESTAMP,
  `equipe` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `inscricao`
--

INSERT INTO `inscricao` (`id_insc`, `nome_insc`, `cpf_insc`, `email_insc`, `telefone_insc`, `transacao_insc`, `valor_insc`, `cupom_insc`, `categoria_insc`, `doc_insc`, `status_insc`, `lote_insc`, `nomecracha_insc`, `check_in`, `datacad`, `equipe`) VALUES
(4, 'Giseli Ramos de Andrade', '029.257.034-10', 'giseliandrade.psi@gmail.com', '(81) 99758-0889', NULL, '297,00', NULL, 'Profissional', NULL, 'Confirmado', NULL, NULL, 0, '2025-01-25 13:56:01', 0),
(5, 'Silvia Fernanda Silveira Vasconcelos	', '039.824.134-19', 'silviafsv@gmail.com', '(81) 99635-0105', NULL, '297,00', NULL, 'Profissional', NULL, 'Confirmado', NULL, NULL, 0, '2025-01-25 13:58:01', 0),
(6, 'Rodrigo Souza da Silva	', '029.747.644-01', 'r.souza21@hotmail.com', '(81) 97677-0270', NULL, '297,00', NULL, 'Profissional', NULL, 'Confirmado', NULL, NULL, 0, '2025-01-25 14:00:02', 0),
(8, 'Raissa Guerra', '086.782.701-1', 'rahguerra@hotmail.com', '(81) 98811-7108', NULL, '222,75', NULL, 'Estudante', NULL, 'Confirmado', NULL, NULL, 0, '2025-01-25 16:56:04', 0),
(9, 'LILIANE SEVERINA DA SILVA ARRUDA', '000.000.000-00', 'lilianearrudape@gmail.com', '(81) 99999-4170', NULL, '297,00', NULL, 'Profissional', NULL, 'Confirmado', NULL, NULL, 0, '2025-01-25 17:02:05', 0),
(10, 'MARCIA GIOVANA NUNES DE JESUS	', '889.160.305-87', 'marciagiovana@hotmail.com', '(81) 97906-5892', NULL, '297,00', NULL, 'Profissional', NULL, 'Confirmado', NULL, NULL, 0, '2025-01-25 17:09:05', 0),
(11, 'Flavia Barroso Esteves	', '734.211.624-68', 'flaviabesteves@hotmail.com', '(81) 99975-0454', NULL, '222,75', NULL, 'Estudante', NULL, 'Confirmado', NULL, NULL, 0, '2025-01-25 18:11:06', 0),
(12, 'Samir Alves da Silva', '110.399.634-71', 'samir_alvees@hotmail.com', '(81) 99706-3620', NULL, '222,75', NULL, 'Estudante', 'U17IL1737852389.pdf', 'Confirmado', NULL, NULL, 0, '2025-01-25 21:46:09', 0),
(33, 'Ana Lúcia Gonçalves Bezerra Alves ', '020.886.394-03', 'analalves@yahoo.com.br', '(81) 98717-6304', NULL, '347,00', NULL, 'Profissional', NULL, 'Confirmado', NULL, 'Ana Lúcia Alves ', 0, '2025-01-31 14:44:02', 0),
(34, 'Dayane Timóteo dos Santos', '46956981000146', 'dayanetimoteopsi@gmail.com', '(81) 987882335', NULL, NULL, NULL, 'Profissional', NULL, 'Confirmado', NULL, 'Dayane Timóteo', 0, '2025-01-31 16:10:16', 0),
(39, 'Elza Baccas', '038.053.688-95', 'psicalistaelzabaccas@gmail.com', '(81) 99772-9833', NULL, '260,25', NULL, 'Estudante', NULL, NULL, NULL, 'Elza Baccas', 0, '2025-02-06 20:16:08', 0),
(40, 'Adriana almeida bezerra ', '415.396.644-49', 'adriana.almeida.bezerra@gmail.com', '(81) 98858-2001', NULL, '277,60', NULL, 'Parceiro', NULL, NULL, NULL, 'Adriana Bezerra ', 0, '2025-02-14 11:53:11', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `workshop`
--

CREATE TABLE `workshop` (
  `id_insc` int UNSIGNED NOT NULL,
  `nome_insc` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cpf_insc` varchar(16) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_insc` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefone_insc` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `transacao_insc` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `valor_insc` varchar(16) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cupom_insc` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `categoria_insc` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `doc_insc` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_insc` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lote_insc` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `check_in` int NOT NULL DEFAULT '0',
  `datacad` datetime DEFAULT NULL,
  `equipe` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `workshop`
--

INSERT INTO `workshop` (`id_insc`, `nome_insc`, `cpf_insc`, `email_insc`, `telefone_insc`, `transacao_insc`, `valor_insc`, `cupom_insc`, `categoria_insc`, `doc_insc`, `status_insc`, `lote_insc`, `check_in`, `datacad`, `equipe`) VALUES
(12, 'Suellem Dayanne Barros da Silva ', '703.297.764-28', 'suellemdayanne24@gmail.com', '(81) 98313-7043', NULL, '27,00', 'Conecta', 'Workshop', NULL, NULL, NULL, 0, '2025-01-31 16:51:04', 0),
(13, 'Lara', '152.962.114-30', 'laraholanda8482@gmail.com', '(81) 99188-5976', NULL, '27,00', 'CONECTA', 'Workshop', NULL, NULL, NULL, 0, '2025-02-01 00:11:12', 0),
(14, 'Silvana Melo', '531.818.164-34', 'silvanamelo@uol.com.br', '(81) 99424-3642', NULL, '27,00', 'CONECTA', 'Workshop', NULL, 'Confirmado', NULL, 0, '2025-02-01 12:03:12', 0),
(15, 'Samir Alves da Silva', '110.399.634-71', 'samir_alvees@hotmail.com', '(81) 99706-3620', NULL, '27,00', 'Conecta', 'Workshop', NULL, 'Confirmado', NULL, 0, '2025-02-02 00:35:12', 0),
(16, 'MARCIA GIOVANA NUNES DE JESUS', '889.160.305-87', 'marciagiovana@hotmail.com', '(81) 97906-5892', NULL, '27,00', 'CONECTA', 'Workshop', NULL, NULL, NULL, 0, '2025-02-02 20:10:08', 0),
(17, 'Thaíssy dos Santos Nascimento', '019.762.072-82', 'thaissynascimento@hotmail.com', '(81) 98110-5814', NULL, '27,00', 'conecta', 'Workshop', NULL, 'Confirmado', NULL, 0, '2025-02-04 09:12:09', 0),
(19, 'Elba Virgínia de Carvalho Rodrigues ', '709.316.384-02', 'elbavirginia.psicologia1@gmail.com', '(81) 99698-0299', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-09 01:16:01', 0),
(21, 'Manuella Araújo Saraiva Farias ', '039.349.094-77', 'mgg.farias@gmail.com', '(81) 99961-9481', NULL, '27,00', 'CONECTA', 'Workshop', NULL, 'Confirmado', NULL, 0, '2025-02-12 14:27:02', 0),
(22, 'Heloysa Danyara Fonseca de Azevedo Matos ', '030.041.145-69', 'danyara.f@hotmail.com', '(84) 98877-6402', NULL, '47,00', NULL, 'Workshop', NULL, 'Confirmado', NULL, 0, '2025-02-12 15:42:03', 0),
(23, 'Luciana Sette Cardoso da Silva', '765.198.724-15', 'settelu7@gmail.com', '(81) 99560-8206', NULL, '27,00', 'CONECTA', 'Workshop', NULL, 'Confirmado', NULL, 0, '2025-02-12 15:42:03', 0),
(25, 'Monike Maciel Barros Pontes', '086.204.064-77', 'monikemacielbp@gmail.com', '(81) 99706-5151', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-13 10:07:10', 0),
(26, 'Thaís Leão ', '096.350.954-30', 'thaispatricia_2008@hotmail.com', '(81) 99293-6200', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-13 11:01:11', 0),
(27, 'Daniella Paes Barreto Bezerra ', '273.700.538-81', 'bezerra.daniella@hotmail.com', '(81) 98811-1601', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-13 12:58:12', 0),
(28, 'Flavia Barroso Esteves ', '734.211.624-68', 'flaviabesteves@hotmail.com', '(81) 99975-0454', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-13 13:04:01', 0),
(29, 'Raquel Batista Vieira ', '038.971.384-84', 'pesa_raquel@hotmail', '(81) 93561-829', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-13 13:09:01', 0),
(30, 'Giselle Mendonça ', '040.220.744-00', 'gisellemdias.psi@gmail.com', '(81) 98339-9459', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-13 13:16:01', 0),
(31, 'Jocelma Maria Andrade Marins', '024.803.484-74', 'psicojocelmamarins@gmail.com', '(81) 98851-9911', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-13 13:23:01', 0),
(32, 'Raquel Batista Vieira', '038.971.384-84', 'pesa_raquel@hotmail.com', '(81) 99429-4543', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-13 13:24:01', 0),
(33, 'SAMUEL CONSTANTINO CAVALCANTI MONTEIRO DOS SA', '704.402.704-05', 'samuel.2019203330@unicap.br', '(81) 99534-3691', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-13 13:32:01', 0),
(34, 'Tarcísio Ferreira do Nascimento', '055.721.164-67', 'tarcisinhz@gmail.com', '(81) 99422-3576', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-13 13:33:01', 0),
(35, 'Rodolfo Nascimento da Cunha ', '098.540.333-90', 'psirodolfocunha@gmail.com', '(81) 98720-3309', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-13 13:41:01', 0),
(36, 'Andrielly Silva Oliveira Filha', '091.962.124-46', 'andriellyoliveira002@gmail.com', '(81) 98424-2584', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-13 14:34:02', 0),
(37, 'Roberta Tavares', '116.647.264-70', 'roberta__tavares@hotmail.com', '(81) 99986-6298', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-13 15:22:03', 0),
(38, 'Gabriela Agra', '101.395.654-00', 'gabrielaagra@gmail.com', '(81) 98334-4441', NULL, '47,00', NULL, 'Workshop', NULL, NULL, NULL, 0, '2025-02-13 19:52:07', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `codigo`
--
ALTER TABLE `codigo`
  ADD PRIMARY KEY (`id_cod`);

--
-- Índices de tabela `credenciador`
--
ALTER TABLE `credenciador`
  ADD PRIMARY KEY (`id_user`);

--
-- Índices de tabela `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id_ev`);

--
-- Índices de tabela `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id_in`);

--
-- Índices de tabela `inscricao`
--
ALTER TABLE `inscricao`
  ADD PRIMARY KEY (`id_insc`);

--
-- Índices de tabela `workshop`
--
ALTER TABLE `workshop`
  ADD PRIMARY KEY (`id_insc`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `codigo`
--
ALTER TABLE `codigo`
  MODIFY `id_cod` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `credenciador`
--
ALTER TABLE `credenciador`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `evento`
--
ALTER TABLE `evento`
  MODIFY `id_ev` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id_in` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `inscricao`
--
ALTER TABLE `inscricao`
  MODIFY `id_insc` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `workshop`
--
ALTER TABLE `workshop`
  MODIFY `id_insc` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
