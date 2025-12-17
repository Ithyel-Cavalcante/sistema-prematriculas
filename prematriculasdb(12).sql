-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Tempo de geração: 17/12/2025 às 11:59
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
-- Banco de dados: `prematriculasdb`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE `alunos` (
  `id_aluno` int(255) NOT NULL,
  `id_escola` varchar(255) NOT NULL,
  `id_usuario` varchar(255) NOT NULL,
  `nome_aluno` varchar(255) NOT NULL,
  `cpf_aluno` varchar(255) NOT NULL,
  `bairro_aluno` varchar(255) NOT NULL,
  `nome_escola_aluno` varchar(255) NOT NULL,
  `turma_alocada` varchar(255) DEFAULT NULL,
  `data_nascimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `bairro`
--

CREATE TABLE `bairro` (
  `id_bairro` int(11) NOT NULL,
  `nome_bairro` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `bairro`
--

INSERT INTO `bairro` (`id_bairro`, `nome_bairro`) VALUES
(1, 'Altamira'),
(2, 'Assis'),
(3, 'Cabeca da Onca\r\n'),
(4, 'Cajas'),
(5, 'Campo Velho'),
(6, 'Canto dos Pintos'),
(7, 'Centro'),
(8, 'Cidade 2000'),
(9, 'Cidade Nova'),
(10, 'Corredores'),
(11, 'Curral do Meio'),
(12, 'Curral Velho'),
(13, 'Dom Fragoso'),
(14, 'Estacao'),
(15, 'Fatima I'),
(16, 'Fatima II'),
(17, 'Ibiapaba'),
(18, 'Inga'),
(19, 'Ipase'),
(20, 'Jardim'),
(21, 'Lagoa das Pedras'),
(22, 'Monte Nebo'),
(23, 'Patos'),
(24, 'Pocinhos'),
(25, 'Poti'),
(26, 'Queimadas'),
(27, 'Realejo'),
(28, 'Rosario'),
(29, 'Santana'),
(30, 'Santo Andre'),
(31, 'Santo Antonio'),
(32, 'Sao Jose'),
(33, 'Venancio');

-- --------------------------------------------------------

--
-- Estrutura para tabela `escolas`
--

CREATE TABLE `escolas` (
  `id_escola` int(11) NOT NULL,
  `nome_escola` varchar(255) NOT NULL,
  `bairro_escola` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `escolas`
--

INSERT INTO `escolas` (`id_escola`, `nome_escola`, `bairro_escola`) VALUES
(1013, 'Jose Bezerra Lima', 'Altamira'),
(1014, 'Esc. De Cid. Joao Luciano', 'Assis'),
(1015, 'Esc. De Cid. Maria Bezerra De Sousa', 'Cabeca da Onca'),
(1016, 'Creche Arlindo Vieira', 'Cajás'),
(1017, 'Esc. De Cid. Furtado Leite', 'Campo Velho'),
(1018, 'Esc. De Cid. Maria Jose Bezerra De Melo', 'Campo Velho'),
(1019, 'Cei Universo Da Descoberta', 'Campo Velho'),
(1020, 'Esc. De Cid. Belarmino Lopes Pinto', 'Canto dos Pintos'),
(1021, 'Centro Int. De Educação De Crateús (Ciec)', 'Centro'),
(1022, 'Esc. De Cid. Externato Nossa Sra. De Fatima', 'Centro'),
(1023, 'Esc. De Cid. General Souto Maior', 'Centro'),
(1024, 'Esc. De Cid. Vilebaldo Barbosa Martins', 'Centro'),
(1025, 'Benone Machado', 'Centro'),
(1026, 'Castelinho Do Saber', 'Centro'),
(1027, 'Sao Vicente De Paulo', 'Centro'),
(1028, 'Esc. De Cid. Jose Freire Filho', 'Cidade 2000'),
(1029, 'Raimunda Gomes De Azevedo', 'Cidade 2000'),
(1030, 'Esc. De Cid. Antonio Anisio Da Frota (Caic)', 'Cidade Nova'),
(1031, 'Esc. De Cid. Imaculada Conceicao', 'Corredores'),
(1032, 'Esc. De Cid. Umbelino Alves Da Silva', 'Curral do Meio'),
(1033, 'Esc. De Cid. Joaquim Ferreira Do Bonfim', 'Curral Velho'),
(1034, 'Cei Maria Da Conceicao Machado Lima', 'Dom Fragoso'),
(1035, 'Esc. De Cid. Jose Soares Godinho', 'Estação'),
(1036, 'Esc. De Cid. Padre Bonfim', 'Fatima I'),
(1038, 'Menino Jesus De Praga', 'Fatima I'),
(1039, 'Proinf. Maria Delite Menezes Teixeira Ii', 'Fatima I'),
(1040, 'Esc. De Cid. Francisca Machado', 'Fatima II'),
(1041, 'José Maria De Oliveira Camerino', 'Fatima II'),
(1042, 'Esc. De Cid. Ibiapaba', 'Ibiapaba'),
(1043, 'Esc. De Cid. Antonio Cipriano De Miranda', 'Inga'),
(1044, 'Creche Mariano Vieira', 'Inga'),
(1045, 'Esc. De Cid. Airam Veras', 'Ipase'),
(1046, 'Esc. De Cid. Santa Rosa', 'Jardim'),
(1047, 'Esc. De Cid. Joaquim Braz De Oliveira', 'Lagoa das Pedras'),
(1048, 'Esc. De Cid. Jose Braz De Pinho', 'Lagoa das Pedras'),
(1049, 'Esc. De Cid. Maria De Sousa Soares (Anexo Joaquim Braz)', 'Lagoa das Pedras'),
(1050, 'Esc. De Cid. Francisco De Alcântara Barros', 'Monte Nebo'),
(1051, 'Creche 1º De Maio', 'Monte Nebo'),
(1052, 'Esc. De Cid. José Martins De Lima', 'Patos'),
(1053, 'Esc. De Cid. Lutando Para Vencer', 'Pocinhos'),
(1054, 'Esc. De Cid. Sao Jose', 'Poti'),
(1055, 'Esc. De Cid. Jose De Araujo Veras', 'Queimadas'),
(1056, 'Esc. De Cid. Dr. Samuel Lins', 'Realejo'),
(1057, 'Esc. De Cid. Realejo', 'Realejo'),
(1058, 'Cei Realejo Centro De Educacao Infantil Realejo', 'Realejo'),
(1059, 'Esc. De Cid. Luiz Ximenes Aragao', 'Rosario'),
(1060, 'Creche Maria De Nazare Ximenes Aragão', 'Rosario'),
(1061, 'Esc. De Cid. Manoel Divino De Araujo', 'Santana'),
(1062, 'Esc. De Cid. Adriana Gomes Da Silva Fernandes', 'Santana'),
(1063, 'Esc. De Cid. Coracao De Jesus', 'Santo Andre'),
(1064, 'Esc. De Cid. Santo Antonio', 'Santo Antonio'),
(1065, 'Creche Aurelio Da Costa Azevedo', 'Santo Antonio'),
(1066, 'Esc. De Cid. Amadeu Catunda', 'São Jose'),
(1067, 'Esc. De Cid. Prof. Carlota C.. Da Penha Oliveira', 'São Jose'),
(1068, 'Esc. De Cid. Francisco Carlos De Pinho', 'São Jose'),
(1069, 'Esc. De Cid. Olavo Bilac', 'Venancio'),
(1070, 'Proinf. Maria Delite Menezes Teixeira I', 'Venancio'),
(1071, 'Cei Luz Do Saber', 'Venancio');

-- --------------------------------------------------------

--
-- Estrutura para tabela `escola_faixa_etaria`
--

CREATE TABLE `escola_faixa_etaria` (
  `id_faixa` int(11) NOT NULL,
  `id_escola` int(11) NOT NULL,
  `nome_turma` varchar(100) DEFAULT NULL,
  `idade_minima_anos` int(2) NOT NULL,
  `idade_maxima_anos` int(2) NOT NULL,
  `capacidade_turma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `escola_faixa_etaria`
--

INSERT INTO `escola_faixa_etaria` (`id_faixa`, `id_escola`, `nome_turma`, `idade_minima_anos`, `idade_maxima_anos`, `capacidade_turma`) VALUES
(214, 1025, 'INFANTIL IV U INTEGRAL', 4, 4, 25),
(215, 1025, 'INFANTIL V U INTEGRAL', 5, 5, 25),
(216, 1026, 'INFANTIL II - AI CASTELINHO', 2, 2, 20),
(217, 1026, 'INFANTIL II - BI CASTELINHO', 2, 2, 20),
(218, 1026, 'INFANTIL III - AI CASTELINHO', 3, 3, 25),
(219, 1071, 'INFANTIL II - AA - INTEGRAL - LUZ DO SABER', 2, 2, 20),
(220, 1071, 'INFANTIL II - AB - INTEGRAL - LUZ DO SABER', 2, 2, 20),
(221, 1071, 'INFANTIL II - AC - INTEGRAL - LUZ DO SABER', 2, 2, 20),
(222, 1071, 'INFANTIL III - AD - INTEGRAL - LUZ DO SABER', 3, 3, 25),
(223, 1071, 'INFANTIL IV - AE - INTEGRAL - LUZ DO SABER', 4, 4, 25),
(224, 1071, 'INFANTIL V - AF - INTEGRAL - LUZ DO SABER', 5, 5, 25),
(225, 1034, 'BERCARIO - INTEGRAL', 0, 1, 18),
(226, 1034, 'INFANTIL II A - INTEGRAL', 2, 2, 20),
(227, 1034, 'INFANTIL II B - INTEGRAL', 2, 2, 20),
(228, 1034, 'INFANTIL III A - INTEGRAL', 3, 3, 25),
(229, 1034, 'INFANTIL III B - INTEGRAL', 3, 3, 25),
(230, 1058, 'INFANTIL II A', 2, 2, 20),
(231, 1058, 'INFANTIL III A', 3, 3, 25),
(232, 1058, 'INFANTIL III B', 3, 3, 25),
(233, 1058, 'INFANTIL IV A', 4, 4, 25),
(234, 1058, 'INFANTIL IV B', 4, 4, 25),
(235, 1058, 'INFANTIL V A  T', 5, 5, 25),
(236, 1058, 'INFANTIL V B', 5, 5, 25),
(237, 1058, 'INFANTIL V C', 5, 5, 25),
(238, 1019, 'INFANTIL - II AI UNIVERSO', 2, 2, 20),
(239, 1019, 'INFANTIL - II BI UNIVERSO', 2, 2, 20),
(240, 1019, 'INFANTIL - II CI UNIVERSO', 2, 2, 20),
(241, 1019, 'INFANTIL - III CI UNIVESRO', 3, 3, 25),
(242, 1019, 'INFANTIL- III AI UNIVERSO', 3, 3, 25),
(243, 1019, 'INFANTIL- III BI UNIVERSO', 3, 3, 25),
(244, 1021, '1º ANO A - ENSINO FUNDAMENTAL', 6, 6, 30),
(245, 1021, '1º ANO B - ENSINO FUNDAMENTAL', 6, 6, 30),
(246, 1021, '1º ANO C - ENSINO FUNDAMENTAL', 6, 6, 30),
(247, 1021, '1º ANO D - ENSINO FUNDAMENTAL', 6, 6, 30),
(248, 1021, '2º ANO - A - EF - INTEGRAL', 7, 7, 30),
(249, 1021, '2º ANO - B - EF - INTEGRAL', 7, 7, 30),
(250, 1021, '2º ANO - C - EF - INTEGRAL', 7, 7, 30),
(251, 1021, '4º ANO UNICO -  ENSINO FUNDAMENTAL', 9, 9, 35),
(252, 1021, '5º ANO - ENSINO FUNDAMENTAL', 10, 10, 35),
(253, 1021, '6º ANO - ENSINO FUNDAMENTAL', 11, 11, 35),
(254, 1021, 'CRECHE 2 ANOS A - MANHA', 2, 2, 20),
(255, 1021, 'CRECHE 2 ANOS B - TARDE', 2, 2, 20),
(256, 1021, 'CRECHE 3 ANOS A - MANHA', 3, 3, 25),
(257, 1021, 'CRECHE 3 ANOS B - TARDE', 3, 3, 25),
(258, 1021, 'EJA 2º/3º  I SEGMENTO - NOITE', 15, 100, 40),
(259, 1021, 'EJA 4º/5º I SEGMENTO - NOITE', 15, 100, 40),
(260, 1021, 'EJA 6º/7º II SEGMENTO - NOITE', 15, 100, 40),
(261, 1021, 'EJA 8º/9º II SEGMENTO - NOITE', 15, 100, 40),
(262, 1021, 'INFANTIL 4 ANOS A  - MANHA', 4, 4, 25),
(263, 1021, 'INFANTIL 4 ANOS B - MANHA', 4, 4, 25),
(264, 1021, 'INFANTIL 4 ANOS C- TARDE', 4, 4, 25),
(265, 1021, 'INFANTIL 5 ANOS A - MANHA', 5, 5, 25),
(266, 1021, 'INFANTIL 5 ANOS B  - MANHA', 5, 5, 25),
(267, 1021, 'INFANTIL 5 ANOS C - TARDE', 5, 5, 25),
(268, 1051, 'INFANTIL II - UM', 2, 2, 20),
(269, 1051, 'INFANTIL III - UM', 3, 3, 25),
(270, 1051, 'INFANTIL IV - UT', 4, 4, 25),
(271, 1051, 'INFANTIL V - UT', 5, 5, 25),
(272, 1016, 'INFANTIL II- MANHA', 2, 2, 20),
(273, 1016, 'INFANTIL III - MANHA', 3, 3, 25),
(274, 1016, 'INFANTIL IV TARDE', 4, 4, 25),
(275, 1016, 'INFANTIL V TARDE', 5, 5, 25),
(276, 1065, 'MULTI INFANTIL  IV E V INTEGRAL', 4, 5, 20),
(277, 1065, 'MULTI INFANTIL II E III INTEGRAL', 2, 3, 20),
(278, 1060, 'INFANTIL II E III T M', 2, 3, 25),
(279, 1060, 'INFANTIL IV T T', 4, 4, 25),
(280, 1060, 'INFANTIL V TT', 5, 5, 25),
(281, 1044, 'INFANTIL II E III - UM', 2, 3, 25),
(282, 1044, 'INFANTIL IV - UT', 4, 4, 25),
(283, 1044, 'INFANTIL V - UT', 5, 5, 25),
(284, 1062, '5º Ano - U', 10, 10, 35),
(285, 1062, 'Multi 1º e 2º Ano - U', 6, 7, 30),
(286, 1062, 'Multi 3º e 4º Ano - U', 9, 10, 35),
(287, 1062, 'Multi 6º e 7º Ano - U', 11, 12, 35),
(288, 1062, 'Multi 8º e 9º Ano - U', 13, 14, 40),
(289, 1045, '1º Ano - U', 6, 6, 30),
(290, 1045, '2º Ano - U', 7, 7, 30),
(291, 1045, '3º ano - A', 8, 8, 35),
(292, 1045, '3º Ano - B', 8, 8, 35),
(293, 1045, '4º ano - A', 9, 9, 35),
(294, 1045, '4º Ano - B', 9, 9, 35),
(295, 1045, '5º Ano - U', 10, 10, 35),
(296, 1066, '1º ano - A', 6, 6, 30),
(297, 1066, '1º Ano - B', 6, 6, 30),
(298, 1066, '2º Ano - A', 7, 7, 30),
(299, 1066, '2º Ano - B', 7, 7, 30),
(300, 1066, '3º Ano - U', 8, 8, 35),
(301, 1066, '4º Ano - U', 9, 9, 35),
(302, 1066, '5º Ano - U', 10, 10, 35),
(303, 1030, '1º ANO TURMA A INTEGRAL', 6, 6, 30),
(304, 1030, '1º ANO TURMA B INTEGRAL', 6, 6, 30),
(305, 1030, '2º ANO  TURMA A INTEGRAL', 7, 7, 30),
(306, 1030, '2º ANO TURMA B INTEGRAL', 7, 7, 30),
(307, 1030, '3º ANO TURMA A INTEGRAL', 8, 8, 35),
(308, 1030, '3º ANO TURMA B INTEGRAL', 8, 8, 35),
(309, 1030, '4º ANO TURMA A INTEGRAL', 9, 9, 35),
(310, 1030, '4º ANO TURMA B INTEGRAL', 9, 9, 35),
(311, 1030, '5º ANO TURMA A INTEGRAL', 10, 10, 35),
(312, 1030, '5º ANO TURMA B INTEGRAL', 10, 10, 35),
(313, 1030, '6º ANO TURMA A INTEGRAL', 11, 11, 35),
(314, 1030, '6º ANO TURMA B INTEGRAL', 11, 11, 35),
(315, 1030, '7º ANO TURMA A INTEGRAL', 12, 12, 35),
(316, 1030, '7º ANO TURMA B INTEGRAL', 12, 12, 35),
(317, 1030, '8º ANO TURMA A INTEGRAL', 13, 13, 40),
(318, 1030, '8º ANO TURMA B INTEGRAL', 13, 13, 40),
(319, 1030, '9º ANO TURMA A INTEGRAL', 14, 14, 40),
(320, 1030, '9º ANO TURMA B INTEGRAL', 14, 14, 40),
(321, 1030, 'EJA ANOS INICIAIS E ANOS FINAIS - A', 15, 100, 40),
(322, 1030, 'EJA ANOS INICIAIS E ANOS FINAIS - B', 15, 100, 40),
(323, 1030, 'INFANTIL II TURMA AM', 2, 2, 20),
(324, 1030, 'INFANTIL III TURMA AM', 3, 3, 25),
(325, 1030, 'INFANTIL III TURMA BT', 3, 3, 25),
(326, 1030, 'INFANTIL IV TURMA AM', 4, 4, 25),
(327, 1030, 'INFANTIL IV TURMA BT', 4, 4, 25),
(328, 1030, 'INFANTIL V TURMA AM', 5, 5, 25),
(329, 1030, 'INFANTIL V TURMA BT', 5, 5, 25),
(330, 1043, '5º Ano - U', 10, 10, 35),
(331, 1043, '1º e 2º Ano - U', 6, 7, 30),
(332, 1043, '3º Ano - U', 8, 8, 35),
(333, 1043, '4º Ano - U', 9, 9, 35),
(334, 1043, '6º e 7º Ano - U', 11, 12, 35),
(335, 1043, '8º Ano - U', 13, 13, 40),
(336, 1043, '9º Ano -U', 14, 14, 40),
(337, 1020, 'EJA ANOS INICIAIS E FINAIS - U', 15, 100, 40),
(338, 1020, 'INFANTIL II E III - U MANHA', 2, 3, 25),
(339, 1020, 'INFANTIL IV E V - U MANHA', 4, 5, 25),
(340, 1020, 'MULTI - 1º ANO - U', 6, 6, 30),
(341, 1020, 'MULTI - 3º - 4º E 5º ANO - U', 8, 10, 35),
(342, 1063, 'EJA ANOS FINAIS - 6º E 7º ANO - A', 15, 100, 40),
(343, 1063, 'EJA ANOS FINAIS - 8º E 9º ANO - B', 15, 100, 40),
(344, 1063, 'INFANTIL II E III - UM', 2, 3, 25),
(345, 1063, 'INFANTIL IV E V - U', 4, 5, 25),
(346, 1063, 'MULTI 1º E 3º ANO', 6, 8, 30),
(347, 1056, '6ºANO UI', 11, 11, 35),
(348, 1056, '7ºANO UI', 12, 12, 35),
(349, 1056, '8ºANO AI', 13, 13, 40),
(350, 1056, '8ºANO BI', 13, 13, 40),
(351, 1056, '9ºANO AI', 14, 14, 40),
(352, 1056, '9ºANO BI', 14, 14, 40),
(353, 1056, 'EJA  ANOS INICIAIS E FINAIS - SAMUEL LINS RAIM', 15, 100, 40),
(354, 1056, 'EJA AN  ANOS INICIAIS  CAJUEIRO ALINE', 15, 100, 40),
(355, 1056, 'EJA AN ANOS FINAIS - BARRA DO SIMIAO', 15, 100, 40),
(356, 1056, 'EJA AN ANOS INICIAIS E FINAIS - CAJUEIRO IZAQUE', 15, 100, 40),
(357, 1056, 'EJA AN ANOS INICIAIS E FINAIS - SAMUEL VAL', 15, 100, 40),
(358, 1056, 'EJA CN ANOS INICIAIS E FINAIS - SAMUEL DEB', 15, 100, 40),
(359, 1056, 'EJA DN ANOS INICIAIS - SAMUEL  GABR', 15, 100, 40),
(360, 1056, 'EJA EN ANOS INICIAIS E FINAIS - CRIANCA FELIZ DANY', 15, 100, 40),
(361, 1056, 'EJA FN ANOS INICIAIS E FINAIS - CRIANCA FELIZ DAR', 15, 100, 40),
(362, 1022, '1º Ano - A', 6, 6, 30),
(363, 1022, '1º Ano - B', 6, 6, 30),
(364, 1022, '1º Ano - C', 6, 6, 30),
(365, 1022, '1º Ano - D', 6, 6, 30),
(366, 1022, '2º Ano - A', 7, 7, 30),
(367, 1022, '2º Ano - B', 7, 7, 30),
(368, 1022, '2º Ano - C', 7, 7, 30),
(369, 1022, '2º Ano - D', 7, 7, 30),
(370, 1022, '3º Ano - A', 8, 8, 35),
(371, 1022, '3º Ano - B', 8, 8, 35),
(372, 1022, '3º Ano - C', 8, 8, 35),
(373, 1022, '3º Ano - D', 8, 8, 35),
(374, 1022, '4º Ano - A', 9, 9, 35),
(375, 1022, '4º Ano - B', 9, 9, 35),
(376, 1022, '4º Ano - C', 9, 9, 35),
(377, 1022, '4º Ano - D', 9, 9, 35),
(378, 1022, '4º Ano - E', 9, 9, 35),
(379, 1022, '5º Ano - A', 10, 10, 35),
(380, 1022, '5º Ano - B', 10, 10, 35),
(381, 1022, '5º Ano - C', 10, 10, 35),
(382, 1022, '5º Ano - D', 10, 10, 35),
(383, 1040, '1º Ano  - A', 6, 6, 30),
(384, 1040, '1º Ano  - B', 6, 6, 30),
(385, 1040, '2º Ano - A EF INTEGRAL', 7, 7, 30),
(386, 1040, '2º Ano - B EF INTEGRAL', 7, 7, 30),
(387, 1040, '2º Ano - C', 7, 7, 30),
(388, 1040, '3º Ano - A', 8, 8, 35),
(389, 1040, '3º Ano - B', 8, 8, 35),
(390, 1040, '4º Ano - A', 9, 9, 35),
(391, 1040, '4º Ano - B', 9, 9, 35),
(392, 1040, '4º Ano - C', 9, 9, 35),
(393, 1040, '5º Ano - A EF INTEGRAL', 10, 10, 35),
(394, 1040, '5º Ano - B EF INTEGRAL', 10, 10, 35),
(395, 1068, '1º ANO - U', 6, 6, 30),
(396, 1068, '2º ANO - U', 7, 7, 30),
(397, 1068, '3º ANO - U', 8, 8, 35),
(398, 1068, '4º ANO - U', 9, 9, 35),
(399, 1068, '5º ANO - U', 10, 10, 35),
(400, 1068, '6º ANO - U', 11, 11, 35),
(401, 1068, '7º ANO - U', 12, 12, 35),
(402, 1068, '8º ANO - U', 13, 13, 40),
(403, 1068, '9º ANO - U', 14, 14, 40),
(404, 1068, 'EJA - 8º E 9º ANO', 15, 100, 40),
(405, 1068, 'EJA III - 6º E 7º ANO', 15, 100, 40),
(406, 1068, 'INFANTIL II - UM', 2, 2, 20),
(407, 1068, 'INFANTIL III - UM', 3, 3, 25),
(408, 1068, 'INFANTIL IV - UT', 4, 4, 25),
(409, 1068, 'INFANTIL V - UM', 5, 5, 25),
(410, 1050, '1º E 2°Ano - MULTI', 6, 7, 30),
(411, 1050, '3º Ano -U', 8, 8, 35),
(412, 1050, '4º Ano - U', 9, 9, 35),
(413, 1050, '5º Ano - U', 10, 10, 35),
(414, 1050, '6º Ano - U', 11, 11, 35),
(415, 1050, '7º Ano - U', 12, 12, 35),
(416, 1050, '8º Ano - U', 13, 13, 40),
(417, 1050, '9º Ano - U', 14, 14, 40),
(418, 1050, 'EJA ANOS FINAIS - 6º E 7º - ALCANTARA', 15, 100, 40),
(419, 1050, 'EJA ANOS INICIAIS -1º AO 3º ANO - ALCANTARA', 15, 100, 40),
(420, 1050, 'EJA ANOS INICIAIS E FINAIS - 1º DE MAIO - AN', 15, 100, 40),
(421, 1050, 'EJA ANOS INICIAIS E FINAIS - 1º DE MAIO - BN', 15, 100, 40),
(422, 1050, 'EJA ANOS INICIAIS E FINAIS - CACIMBINHAS - CN', 15, 100, 40),
(423, 1017, '1º Ano - U', 6, 6, 30),
(424, 1017, '2º Ano - U', 7, 7, 30),
(425, 1017, '3º Ano - U', 8, 8, 35),
(426, 1017, '4º Ano - U', 9, 9, 35),
(427, 1017, '5º Ano - U', 10, 10, 35),
(428, 1023, '1º Ano - A', 6, 6, 30),
(429, 1023, '1º Ano - B', 6, 6, 30),
(430, 1023, '2º Ano - A', 7, 7, 30),
(431, 1023, '2º Ano - B', 7, 7, 30),
(432, 1023, '3º Ano - A', 8, 8, 35),
(433, 1023, '3º Ano - B', 8, 8, 35),
(434, 1023, '4º Ano - A', 9, 9, 35),
(435, 1023, '4º Ano - B', 9, 9, 35),
(436, 1023, '5º Ano - A', 10, 10, 35),
(437, 1023, '5º Ano - B', 10, 10, 35),
(438, 1042, '1 ANO FUNDAMENTAL', 6, 6, 30),
(439, 1042, '2 ANO FUNDAMENTAL', 7, 7, 30),
(440, 1042, '3 ANO FUNDAMENTAL', 8, 8, 35),
(441, 1042, '4 ANO FUNDAMENTAL', 9, 9, 35),
(442, 1042, '5 ANO FUNDAMENTAL', 10, 10, 35),
(443, 1042, '6 ANO FUNDAMENTAL II', 11, 11, 35),
(444, 1042, '7 ANO FUNDAMENTAL II', 12, 12, 35),
(445, 1042, '8 ANO FUNDAMENTAL II', 13, 13, 40),
(446, 1042, '9 ANO FUNDAMENTAL II', 14, 14, 40),
(447, 1042, 'EDUCAO INFANTIL II E III', 2, 3, 25),
(448, 1042, 'EJA ANOS INICIAIS E FINAIS PRESENCIAL - UN', 15, 100, 40),
(449, 1042, 'INFANTIL IV', 4, 4, 25),
(450, 1042, 'INFANTIL V  - A', 5, 5, 25),
(451, 1042, 'INFANTIL V - B', 5, 5, 25),
(452, 1031, 'EJA ANOS INICIAIS - BARRA DAGUA - C', 15, 100, 40),
(453, 1031, 'EJA ANOS INICIAIS - CORREDORES - A', 15, 100, 40),
(454, 1031, 'EJA ANOS INICIAIS - CORREDORES - B', 15, 100, 40),
(455, 1031, 'EJA ANOS INICIAIS E FINAIS -  CARRAPATEIRA - D', 15, 100, 40),
(456, 1031, 'INFANTIL II E III - CRECHE', 2, 3, 25),
(457, 1031, 'INFANTIL IV E V - CRECHE', 4, 5, 25),
(458, 1031, 'MULTI -  3º - 4º E 5º ANO - U', 3, 4, 25),
(459, 1031, 'MULTI - 1º E 2º ANO - U', 6, 7, 30),
(460, 1031, 'MULTI - 6º E 7º ANO - U', 11, 12, 35),
(461, 1031, 'MULTI-  8º E 9º ANO - U', 13, 14, 40),
(462, 1014, '1º 2º 3º ANO MULT UI', 6, 8, 30),
(463, 1014, '4º 5º ANO MULT UI', 9, 10, 35),
(464, 1014, '6º 7º ANO MULT UI', 11, 12, 35),
(465, 1014, '8º 9º ANO MULT UI', 13, 14, 40),
(466, 1014, 'EJA ANOS INICIAIS E FINAIS UN ASSIS', 15, 100, 40),
(467, 1014, 'EJA ANOS INICIAIS E FINAIS UN RIACHO SECO', 15, 100, 40),
(468, 1014, 'INFANTIL II E III UM', 2, 3, 25),
(469, 1014, 'INFANTIL IV E V UM', 4, 5, 25),
(470, 1047, '1º Ano - U', 6, 6, 30),
(471, 1047, '2º Ano - U', 7, 7, 30),
(472, 1047, '3º Ano - U', 8, 8, 35),
(473, 1047, '4º Ano - U', 9, 9, 35),
(474, 1033, '1º ANO - UM', 6, 6, 30),
(475, 1033, '2º ANO - UM', 7, 7, 30),
(476, 1033, '3º ANO - UM', 8, 8, 35),
(477, 1033, '4º ANO - UT', 9, 9, 35),
(478, 1033, '5º ANO - UT', 10, 10, 35),
(479, 1033, '6º ANO - UT', 11, 11, 35),
(480, 1033, '7º ANO - UT', 12, 12, 35),
(481, 1033, '8º ANO - UT', 13, 13, 40),
(482, 1033, '9º ANO - UI', 14, 14, 40),
(483, 1033, 'INFANTIL II E III - UM', 2, 3, 25),
(484, 1033, 'INFANTIL IV - UM', 4, 4, 25),
(485, 1033, 'INFANTIL V - UM', 5, 5, 25),
(486, 1048, 'INFANTIL II REGULAR U - MANHA', 2, 2, 20),
(487, 1048, 'INFANTIL III REGULAR U - MANHA', 3, 3, 25),
(488, 1048, 'INFANTIL IV REGULAR U - TARDE', 4, 4, 25),
(489, 1048, 'INFANTIL V REGULAR U - TARDE', 5, 5, 25),
(490, 1055, '1º ANO UI', 6, 6, 30),
(491, 1055, '2º ANO UI', 7, 7, 30),
(492, 1055, '3º ANO U', 8, 8, 35),
(493, 1055, '4º ANO UI', 9, 9, 35),
(494, 1055, '5º ANO UI', 10, 10, 35),
(495, 1055, '6º ANO U', 11, 11, 35),
(496, 1055, '7º ANO U', 12, 12, 35),
(497, 1055, '8º ANO U', 13, 13, 40),
(498, 1055, '9º ANO UI', 14, 14, 40),
(499, 1055, 'EJA 1º 2º 3º UN', 15, 100, 40),
(500, 1055, 'EJA 4º 5º AN', 15, 100, 40),
(501, 1055, 'EJA 4º 5º BN', 15, 100, 40),
(502, 1055, 'EJA 4º 5º CN', 15, 100, 40),
(503, 1055, 'EJA 6º 7º UN', 15, 100, 40),
(504, 1055, 'EJA 8º 9º UN', 15, 100, 40),
(505, 1055, 'INFANTIL II UM', 2, 2, 20),
(506, 1055, 'INFANTIL III UM', 3, 3, 25),
(507, 1055, 'INFANTIL IV UT', 4, 4, 25),
(508, 1055, 'INFANTIL V AM', 5, 5, 25),
(509, 1055, 'INFANTIL V BT', 5, 5, 25),
(510, 1028, '1º Ano - U', 6, 6, 30),
(511, 1028, '2º Ano - U', 7, 7, 30),
(512, 1028, '3º Ano - U', 8, 8, 35),
(513, 1028, '4º Ano - A', 9, 9, 35),
(514, 1028, '5º Ano - A', 10, 10, 35),
(515, 1028, '5º Ano - B', 10, 10, 35),
(516, 1028, '6º Ano - A', 11, 11, 35),
(517, 1028, '6º Ano - B', 11, 11, 35),
(518, 1028, '7º Ano - U', 12, 12, 35),
(519, 1028, '8º Ano - U', 13, 13, 40),
(520, 1028, '9º Ano - A', 14, 14, 40),
(521, 1028, '9º Ano - B', 14, 14, 40),
(522, 1028, 'EJA ANOS FINAIS - FREIRE', 15, 100, 40),
(523, 1028, 'EJA ANOS INICIAIS - CEI', 15, 100, 40),
(524, 1028, 'EJA ANOS INICIAIS - FREIRE', 15, 100, 40),
(525, 1028, 'EJA ANOS INICIAIS E FINAIS - ARLINDO', 15, 100, 40),
(526, 1052, '1º ANO - U - EF - INTEGRAL', 6, 6, 30),
(527, 1052, '2º ANO - U - EF - INTEGRAL', 7, 7, 30),
(528, 1052, '3º ANO - U - EF - INTEGRAL', 8, 8, 35),
(529, 1052, '4º ANO - U - EF - INTEGRAL', 9, 9, 35),
(530, 1052, '5º ANO - U - EF - INTEGRAL', 10, 10, 35),
(531, 1052, '6º ANO - U - EF - INTEGRAL', 11, 11, 35),
(532, 1052, '7º ANO - U - EF - INTEGRAL', 12, 12, 35),
(533, 1052, '8º ANO - U - EF - INTEGRAL', 13, 13, 40),
(534, 1052, '9º ANO - U - EF - INTEGRAL', 14, 14, 40),
(535, 1052, 'EJA ANOS FINAIS  - 6º E 7º - PE DO MORRO', 15, 100, 40),
(536, 1052, 'EJA ANOS FINAIS - 6º E 7º ANO - LAGOA DO TORTO', 15, 100, 40),
(537, 1052, 'EJA ANOS FINAIS - 8º E 9º ANO - VILA GRACA', 15, 100, 40),
(538, 1052, 'EJA ANOS INICIAIS - 1º AO 5º - INCHUI', 15, 100, 40),
(539, 1052, 'INFANTIL II - UM', 2, 2, 20),
(540, 1052, 'INFANTIL III - UM', 3, 3, 25),
(541, 1052, 'INFANTIL IV - UT', 4, 4, 25),
(542, 1052, 'INFANTIL V - UT', 5, 5, 25),
(543, 1035, 'INFANTIL II - III - IV - V - U INTEGRAL', 2, 2, 20),
(544, 1035, 'MULTI 1 AO 4 U - INTEGRAL', 6, 9, 35),
(545, 1059, '1º ANO - U - EF - INTEGRAL', 6, 6, 30),
(546, 1059, '2º ANO - U - EF - INTEGRAL', 7, 7, 30),
(547, 1059, '3º E 4º ANO - U - EF - INTEGRAL', 8, 9, 35),
(548, 1059, '5ºANO - U - EF - INTEGRAL', 10, 10, 35),
(549, 1059, 'EJA ANOS INICIAIS  T A T N', 15, 100, 40),
(550, 1059, 'EJA ANOS INICIAIS T B T N', 15, 100, 40),
(551, 1059, 'EJA ANOS INICIAIS T C T N', 15, 100, 40),
(552, 1059, 'EJA ANOS INICIAIS T D T N', 15, 100, 40),
(553, 1053, 'CRECHE 2 E 3 ANOS AMANHA', 2, 3, 25),
(554, 1053, 'EJA ANOS INICIAS - UN', 15, 100, 40),
(555, 1053, 'MULTI  8º E 9º ANO - U INTREGRAL', 13, 14, 40),
(556, 1053, 'MULTI 1º E 2º ANO - U INTEGRAL', 6, 8, 30),
(557, 1053, 'MULTI 3º 4º E 5º ANO - U INTREGRAL', 8, 10, 35),
(558, 1053, 'MULTI 6º E 7º ANO - U INTREGRAL', 11, 12, 35),
(559, 1053, 'PRE ESCOLA 4  A 5 ANOS TARDE', 4, 5, 20),
(560, 1061, 'INFANTIL II UNICA', 2, 2, 20),
(561, 1061, 'INFANTIL III UNICA', 3, 3, 25),
(562, 1061, 'INFANTIL IV UNICA', 4, 4, 25),
(563, 1061, 'INFANTIL V UNICA', 5, 5, 25),
(564, 1015, '1º ANO UT / EF', 6, 6, 30),
(565, 1015, '2º ANO A / EF / INTEGRAL', 7, 7, 30),
(566, 1015, '3º ANO UT/ EF', 8, 8, 35),
(567, 1015, '4º E 5º ANO / MULTI / EF / INTEGRAL', 9, 10, 35),
(568, 1015, '6º E 7º ANO / MULTI / EF / INTEGRAL', 11, 12, 35),
(569, 1015, '8º E 9º ANO / EJA 2º SEG/ EF / REGULAR / NOTURNO', 13, 100, 40),
(570, 1015, '8º E 9º ANO / MULTI / EF / INTEGRAL', 13, 100, 40),
(571, 1015, 'INFANTIL II E III / MULTI / MANHA', 2, 3, 25),
(572, 1015, 'INFANTIL IV E V / MULTI / MANHA', 4, 5, 25),
(573, 1049, '5º Ano - U', 10, 10, 35),
(574, 1049, '6º Ano - U', 11, 11, 35),
(575, 1049, '7º Ano - U', 12, 12, 35),
(576, 1049, '8º Ano - U', 13, 13, 40),
(577, 1049, '9º Ano - U', 14, 14, 40),
(578, 1049, 'EJA ANOS INICIAIS E FINAIS', 15, 100, 40),
(579, 1018, '1° Ano - U', 6, 6, 30),
(580, 1018, '2º ANO-U-EF-INTEGRAL', 7, 7, 30),
(581, 1018, '3º Ano - U', 8, 8, 35),
(582, 1018, '4º Ano - U', 9, 9, 35),
(583, 1018, '5º Ano - U', 10, 10, 35),
(584, 1018, '6º Ano - A', 11, 11, 35),
(585, 1018, '6º Ano - B', 11, 11, 35),
(586, 1018, '7º Ano - A', 12, 12, 35),
(587, 1018, '7º Ano - B', 12, 12, 35),
(588, 1018, '8º Ano - A', 13, 13, 40),
(589, 1018, '8º Ano - B', 13, 13, 40),
(590, 1018, '9º Ano - A', 14, 14, 40),
(591, 1018, '9º Ano - B', 14, 14, 40),
(592, 1018, 'EJA ANOS INICIAIS E FINAIS - 1º AO 9º ANO - ANA PAULA', 15, 100, 40),
(593, 1018, 'EJA ANOS INICIAIS E FINAIS - 1º AO 9º ANO - BRUNA', 15, 100, 40),
(594, 1018, 'EJA ANOS INICIAIS E FINAIS - 1º AO 9º ANO - FABIOLA', 15, 100, 40),
(595, 1018, 'EJA ANOS INICIAIS E FINAIS - 1º AO 9º ANO - KATIA', 15, 100, 40),
(596, 1018, 'EJA ANOS INICIAIS E FINAIS - 1º AO 9º ANO - MARTA', 15, 100, 40),
(597, 1069, '1º Ano - U', 6, 6, 30),
(598, 1069, '2º Ano - U', 7, 7, 30),
(599, 1069, '3º Ano -U', 8, 8, 35),
(600, 1069, '4º Ano - U', 9, 9, 35),
(601, 1069, '5º Ano - U', 10, 10, 35),
(602, 1069, '6º Ano -U', 11, 11, 35),
(603, 1069, '7º Ano - U', 12, 12, 35),
(604, 1069, '8º Ano -U', 13, 13, 40),
(605, 1069, '9º Ano -U', 14, 14, 40),
(606, 1069, 'EJA  ANOS INICIAS E ANOS FINAIS -  CN - GASPAR DUTRA', 15, 100, 40),
(607, 1069, 'EJA  ANOS INICIAS E ANOS FINAIS - BN - GASPAR DUTRA', 15, 100, 40),
(608, 1069, 'EJA ANOS INICIAIS - HN - JOSE BEZERRA', 15, 100, 40),
(609, 1069, 'EJA ANOS INICIAIS -1º AO 3º ANO  - AN - LUZ DO SABER', 15, 100, 40),
(610, 1069, 'EJA ANOS INICIAIS E ANOS FINAIS - GN', 15, 100, 40),
(611, 1069, 'EJA ANOS INICIAIS E FINAIS - IN - JOSE BEZERRA', 15, 100, 40),
(612, 1069, 'EJA ANOS INICIAS -  EN', 15, 100, 40),
(613, 1069, 'EJA ANOS INICIAS - DN - LUZ DO SABER', 15, 100, 40),
(614, 1069, 'EJA ANOS INICIAS - FN', 15, 100, 40),
(615, 1036, '1° ANO - U', 6, 6, 30),
(616, 1036, '2º Ano - U', 7, 7, 30),
(617, 1036, '3 º Ano -U', 8, 8, 35),
(618, 1036, '4º Ano - U', 9, 9, 35),
(619, 1036, '5º Ano - U', 10, 10, 35),
(620, 1036, '6º Ano - U', 11, 11, 35),
(621, 1036, '7º Ano - A', 12, 12, 35),
(622, 1036, '7º Ano - B', 12, 12, 35),
(623, 1036, '8º Ano - U', 13, 13, 40),
(624, 1036, '9º Ano - U', 14, 14, 40),
(625, 1036, 'EJA ANOS INICIAIS E FINAIS', 15, 100, 40),
(626, 1036, 'EJA ANOS INICIAIS E FINAIS', 15, 100, 40),
(627, 1067, '6º Ano - A', 11, 11, 35),
(628, 1067, '6º Ano - B', 11, 11, 35),
(629, 1067, '6º Ano - C', 11, 11, 35),
(630, 1067, '7º Ano - A', 12, 12, 35),
(631, 1067, '7º Ano - B', 12, 12, 35),
(632, 1067, '7º Ano - C', 12, 12, 35),
(633, 1067, '8º Ano - A', 13, 13, 40),
(634, 1067, '8º Ano - B', 13, 13, 40),
(635, 1067, '9º Ano - A', 14, 14, 40),
(636, 1067, '9º Ano - B', 14, 14, 40),
(637, 1067, '9º Ano - C', 14, 14, 40),
(638, 1057, '1º Ano - A', 6, 6, 30),
(639, 1057, '1º Ano - B', 6, 6, 30),
(640, 1057, '2º Ano - A', 7, 7, 30),
(641, 1057, '2º Ano - B', 7, 7, 30),
(642, 1057, '3º Ano - A', 8, 8, 35),
(643, 1057, '3º Ano - B', 8, 8, 35),
(644, 1057, '4º Ano - A', 9, 9, 35),
(645, 1057, '4º Ano - B', 9, 9, 35),
(646, 1057, '5º Ano - A', 10, 10, 35),
(647, 1057, '5º Ano - B', 10, 10, 35),
(648, 1057, 'EJA - AN -ANOS INICIAIS E FINAIS - BARRA DOS SIMIOES', 15, 100, 40),
(649, 1057, 'EJA- BN- ANOS INICIAIS E FINAIS- BAIXA DO JUAZEIRO', 15, 100, 40),
(650, 1057, 'EJA II - AN - ANOS INICIAIS - SAO ROMAO', 15, 100, 40),
(651, 1057, 'EJA II -BN-  ANOS INICIAIS MUCAMBO', 15, 100, 40),
(652, 1057, 'EJA II -CN - ANOS INICIAIS - UMBURANA', 15, 100, 40),
(653, 1057, 'EJA II- DN- ANOS INICIAIS- CARRAPATEIRA', 15, 100, 40),
(654, 1057, 'EJA III- BN- ANOS FINAIS-  BAIXA DO JUAZEIRO', 15, 100, 40),
(655, 1057, 'EJA IV - AN - ANOS FINAIS - CURRALINHO', 15, 100, 40),
(656, 1046, '1º ANO - U INTEGRAL', 6, 6, 30),
(657, 1046, '2 º ANO - U INTEGRAL', 7, 7, 30),
(658, 1046, '3º ANO - U INTEGRAL', 8, 8, 35),
(659, 1046, '6º ANO - U INTEGRAL', 11, 11, 35),
(660, 1046, '7º ANO - U INTEGRAL', 12, 12, 35),
(661, 1046, '8º ANO - U INTEGRAL', 13, 13, 40),
(662, 1046, '9º ANO - U INTEGRAL', 14, 14, 40),
(663, 1046, 'EJA ANOS INICIAIS - UN - BOA VISTA', 15, 100, 40),
(664, 1046, 'EJA ANOS INICIAIS E FINAIS - UN - SANATA ROSA', 15, 100, 40),
(665, 1046, 'INFANTIL II - U MANHA', 2, 2, 20),
(666, 1046, 'INFANTIL III - U MANHA', 3, 3, 25),
(667, 1046, 'INFANTIL IV - U TARDE', 4, 4, 25),
(668, 1046, 'INFANTIL V - U TARDE', 5, 5, 25),
(669, 1046, 'MULTI - 4º E 5º ANO - U INTEGRAL', 9, 10, 35),
(670, 1064, '3º Ano - U', 8, 8, 35),
(671, 1064, '6º Ano - U', 11, 11, 35),
(672, 1064, '7º Ano - U', 12, 12, 35),
(673, 1064, '8º Ano - U', 13, 13, 40),
(674, 1064, '9º Ano - U', 14, 14, 40),
(675, 1064, 'EJA ANOS FINAIS - 6º AO 9º ANO - SANTO ANTONIO', 15, 100, 40),
(676, 1064, 'EJA ANOS INICIAIS - 1º AO 5º ANO - SANTO ANTONIO', 15, 100, 40),
(677, 1064, 'EJA ANOS INICIAIS - 1º AO 5º ANO - TOMBADOR', 15, 100, 40),
(678, 1064, 'Multi 1º e 2º Ano - U', 6, 7, 30),
(679, 1064, 'Multi 4º e 5º Ano - U', 9, 10, 35),
(680, 1054, '1º ANO - U - EF - INTEGRAL', 6, 6, 30),
(681, 1054, '6º ANO - U - EF - INTEGRAL', 11, 11, 35),
(682, 1054, '7º ANO - U - EF - INTEGRAL', 12, 12, 35),
(683, 1054, '8º ANO - U - EF - INTEGRAL', 13, 13, 40),
(684, 1054, '9º ANO - U - EF - INTEGRAL', 14, 14, 40),
(685, 1054, 'EJA ANOS INICIAIS E FINAIS', 15, 100, 40),
(686, 1054, 'INFANTIL II E III - UM', 2, 3, 25),
(687, 1054, 'INFANTIL IV E V - UT', 4, 5, 25),
(688, 1054, 'MULTI - 2º E 3º ANO - U - EF - INTEGRAL', 7, 8, 35),
(689, 1054, 'MULTI - 4º E 5º ANO - U - EF - INTEGRAL', 9, 10, 35),
(690, 1032, '3º ANO - U - EF - INTEGRAL', 8, 8, 35),
(691, 1032, '4º ANO - U - EF - INTEGRAL', 9, 9, 35),
(692, 1032, '5º ANO - U - EF - INTEGRAL', 10, 10, 35),
(693, 1032, '8º ANO - U - EF - INTEGRAL', 13, 13, 40),
(694, 1032, '9º ANO - U - EF - INTEGRAL', 14, 14, 40),
(695, 1032, 'EJA ANOS INICIAIS E FINAIS - UN - VARZEA DA PALHA', 15, 100, 40),
(696, 1032, 'INFANTIL II E III - U INTEGRAL', 2, 3, 25),
(697, 1032, 'INFANTIL III E V - U INTEGRAL - PALMARES', 3, 3, 25),
(698, 1032, 'INFANTIL IV E V - U INTEGRAL', 4, 5, 25),
(699, 1032, 'MULTI - 1º E 2º ANO - U - EF - INTEGRAL', 6, 7, 30),
(700, 1032, 'MULTI 6º E 7º ANO - U - EF - INTEGRAL', 11, 12, 35),
(701, 1024, '3º ANO A', 8, 8, 35),
(702, 1024, '3º ANO B', 8, 8, 35),
(703, 1024, '4º ANO A', 9, 9, 35),
(704, 1024, '4º ANO B', 9, 9, 35),
(705, 1024, '4º ANO C', 9, 9, 35),
(706, 1024, '5º ANO A', 10, 10, 35),
(707, 1024, '5º ANO B', 10, 10, 35),
(708, 1024, '6º ANO A', 11, 11, 35),
(709, 1024, '6º ANO B', 11, 11, 35),
(710, 1024, '6º ANO C', 11, 11, 35),
(711, 1024, '6º ANO D', 11, 11, 35),
(712, 1024, '6º ANO E', 11, 11, 35),
(713, 1024, '6º ANO F', 11, 11, 35),
(714, 1024, '7º ANO A', 12, 12, 35),
(715, 1024, '7º ANO B', 12, 12, 35),
(716, 1024, '7º ANO C', 12, 12, 35),
(717, 1024, '7º ANO D', 12, 12, 35),
(718, 1024, '7º ANO E', 12, 12, 35),
(719, 1024, '7º ANO F', 12, 12, 35),
(720, 1024, '7º ANO G', 12, 12, 35),
(721, 1024, '8º ANO A', 13, 13, 40),
(722, 1024, '8º ANO B', 13, 13, 40),
(723, 1024, '8º ANO C', 13, 13, 40),
(724, 1024, '8º ANO D', 13, 13, 40),
(725, 1024, '8º ANO E', 13, 13, 40),
(726, 1024, '8º ANO F', 13, 13, 40),
(727, 1024, '8º ANO G', 13, 13, 40),
(728, 1024, '9º ANO A', 14, 14, 40),
(729, 1024, '9º ANO B', 14, 14, 40),
(730, 1024, '9º ANO C', 14, 14, 40),
(731, 1024, '9º ANO D', 14, 14, 40),
(732, 1024, '9º ANO E', 14, 14, 40),
(733, 1024, '9º ANO F', 14, 14, 40),
(734, 1024, 'EJA ANOS FINAIS - B GOMES COUTINHO', 15, 100, 40),
(735, 1024, 'EJA ANOS INICIAIS E FINAIS -  VBM', 15, 100, 40),
(736, 1024, 'EJA ANOS INICIAIS E FINAIS - A JM. CAMERINO', 15, 100, 40),
(737, 1013, 'INFANTIL II - AI', 2, 2, 20),
(738, 1013, 'INFANTIL II - BM', 2, 2, 20),
(739, 1013, 'INFANTIL II - CT', 2, 2, 20),
(740, 1013, 'INFANTIL III - AI', 3, 3, 25),
(741, 1013, 'INFANTIL III - BM', 3, 3, 25),
(742, 1013, 'INFANTIL III - CT', 3, 3, 25),
(743, 1013, 'INFANTIL IV - AM', 4, 4, 25),
(744, 1013, 'INFANTIL IV - BT', 4, 4, 25),
(745, 1013, 'INFANTIL V - AM', 5, 5, 25),
(746, 1013, 'INFANTIL V - BT', 5, 5, 25),
(747, 1041, 'INFANTIL 2 A', 2, 2, 20),
(748, 1041, 'INFANTIL 2 B', 2, 2, 20),
(749, 1041, 'INFANTIL 2 C', 2, 2, 20),
(750, 1041, 'INFANTIL 3 A', 3, 3, 25),
(751, 1041, 'INFANTIL 3 B', 3, 3, 25),
(752, 1041, 'INFANTIL 3 C', 3, 3, 25),
(753, 1041, 'INFANTIL 3 D', 3, 3, 25),
(754, 1041, 'INFANTIL 4 A', 4, 4, 25),
(755, 1041, 'INFANTIL 4 B', 4, 4, 25),
(756, 1041, 'INFANTIL 4 C', 4, 4, 25),
(757, 1041, 'INFANTIL 4 D', 4, 4, 25),
(758, 1041, 'INFANTIL 5 A', 5, 5, 25),
(759, 1041, 'INFANTIL 5 B', 5, 5, 25),
(760, 1041, 'INFANTIL 5 C', 5, 5, 25),
(761, 1041, 'INFANTIL 5 D', 5, 5, 25),
(762, 1041, 'INFANTIL 5 E', 5, 5, 25),
(763, 1038, 'INFANTIL III AM - MENINO JESUS', 3, 3, 25),
(764, 1038, 'INFANTIL III BT - MENINO JESUS', 3, 3, 25),
(765, 1038, 'INFANTIL IV AM - MENINO JESUS', 4, 4, 25),
(766, 1038, 'INFANTIL IV BT - MENINO JESUS', 4, 4, 25),
(767, 1038, 'INFANTIL V AM - MENINO JESUS', 5, 5, 25),
(768, 1038, 'INFANTIL V BT - MENINO JESUS', 5, 5, 25),
(769, 1070, 'INF - II A', 2, 2, 20),
(770, 1070, 'INF - IV A', 4, 4, 25),
(771, 1070, 'INF - IV B', 4, 4, 25),
(772, 1070, 'INF - IV C', 4, 4, 25),
(773, 1070, 'INF - V B', 5, 5, 25),
(774, 1070, 'INF - V C', 5, 5, 25),
(775, 1070, 'INF - V D', 5, 5, 25),
(776, 1070, 'INF- II B', 2, 2, 20),
(777, 1070, 'INF- IV D', 4, 4, 25),
(778, 1070, 'INF- V A', 5, 5, 25),
(779, 1070, 'INF-II C', 2, 2, 20),
(780, 1070, 'INF-II D', 2, 2, 20),
(781, 1070, 'INF-III A', 3, 3, 25),
(782, 1070, 'INF-III B', 3, 3, 25),
(783, 1070, 'INF-III C', 3, 3, 25),
(784, 1070, 'INF-III D', 3, 3, 25),
(785, 1039, 'INFANTIL IV A M', 4, 4, 25),
(786, 1039, 'INFANTIL V D T', 5, 5, 25),
(787, 1039, 'INFANTIL II A M', 2, 2, 20),
(788, 1039, 'INFANTIL II B M', 2, 2, 20),
(789, 1039, 'INFANTIL II C T', 2, 2, 20),
(790, 1039, 'INFANTIL II D T', 2, 2, 20),
(791, 1039, 'INFANTIL II E T', 2, 2, 20),
(792, 1039, 'INFANTIL III A M', 3, 3, 25),
(793, 1039, 'INFANTIL III B M', 3, 3, 25),
(794, 1039, 'INFANTIL III DT', 3, 3, 25),
(795, 1039, 'INFANTIL III E T', 3, 3, 25),
(796, 1039, 'INFANTIL IV B M', 4, 4, 25),
(797, 1039, 'INFANTIL IV C T', 4, 4, 25),
(798, 1039, 'INFANTIL IV D T', 4, 4, 25),
(799, 1039, 'INFANTIL V A M', 5, 5, 25),
(800, 1039, 'INFANTIL V B M', 5, 5, 25),
(801, 1039, 'INFANTIL V C T', 5, 5, 25),
(802, 1039, 'INFANTIL III C M', 3, 3, 25),
(803, 1029, 'INFANTIL II - AM', 2, 2, 20),
(804, 1029, 'INFANTIL II - BT', 2, 2, 20),
(805, 1029, 'INFANTIL III - AM', 3, 3, 25),
(806, 1029, 'INFANTIL III - BT', 3, 3, 25),
(807, 1029, 'INFANTIL IV - AM', 4, 4, 25),
(808, 1029, 'INFANTIL IV - BM', 4, 4, 25),
(809, 1029, 'INFANTIL IV - CT', 4, 4, 25),
(810, 1029, 'INFANTIL IV - DT', 4, 4, 25),
(811, 1029, 'INFANTIL V - AM', 5, 5, 25),
(812, 1029, 'INFANTIL V - BM', 5, 5, 25),
(813, 1029, 'INFANTIL V - CT', 5, 5, 25),
(814, 1029, 'INFANTIL V - DT', 5, 5, 25),
(815, 1027, 'CRECHE 2 ANOS A', 2, 2, 20),
(816, 1027, 'CRECHE 2 ANOS B', 2, 2, 20),
(817, 1027, 'CRECHE 3 ANOS A', 3, 3, 25),
(818, 1027, 'CRECHE 3 ANOS B', 3, 3, 25);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `cpf_usuario` varchar(11) NOT NULL,
  `nome_usuario` varchar(255) NOT NULL,
  `qtd_alunos` int(10) NOT NULL,
  `bairro_usuario` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `email_usuario` varchar(255) NOT NULL,
  `senha_usuario` varchar(255) NOT NULL,
  `telefone_usuario` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`cpf_usuario`, `nome_usuario`, `qtd_alunos`, `bairro_usuario`, `id_usuario`, `email_usuario`, `senha_usuario`, `telefone_usuario`) VALUES
('12312312312', 'admin', 1, 'Maratoan', 11, 'admin@email.com', '$2y$10$Dn2pfy3alnwOb4wMyF14ruRjbiB6GBbIHg4i3KEykDprKiqx0Soiq', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id_aluno`);

--
-- Índices de tabela `bairro`
--
ALTER TABLE `bairro`
  ADD PRIMARY KEY (`id_bairro`),
  ADD UNIQUE KEY `nome_bairro` (`nome_bairro`);

--
-- Índices de tabela `escolas`
--
ALTER TABLE `escolas`
  ADD PRIMARY KEY (`id_escola`);

--
-- Índices de tabela `escola_faixa_etaria`
--
ALTER TABLE `escola_faixa_etaria`
  ADD PRIMARY KEY (`id_faixa`),
  ADD KEY `id_escola` (`id_escola`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id_aluno` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `bairro`
--
ALTER TABLE `bairro`
  MODIFY `id_bairro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `escolas`
--
ALTER TABLE `escolas`
  MODIFY `id_escola` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1072;

--
-- AUTO_INCREMENT de tabela `escola_faixa_etaria`
--
ALTER TABLE `escola_faixa_etaria`
  MODIFY `id_faixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=819;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `escola_faixa_etaria`
--
ALTER TABLE `escola_faixa_etaria`
  ADD CONSTRAINT `escola_faixa_etaria_ibfk_1` FOREIGN KEY (`id_escola`) REFERENCES `escolas` (`id_escola`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
