-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/12/2025 às 14:32
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administração`
--

CREATE TABLE `administração` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `nomematerno` varchar(100) DEFAULT NULL,
  `datanascimento` date DEFAULT NULL,
  `cep` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `administração`
--

INSERT INTO `administração` (`id_usuario`, `nome`, `senha`, `nomematerno`, `datanascimento`, `cep`) VALUES
(1, 'geovanna', 'academiagym', 'fabia', '0000-00-00', '23057-650');

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamento`
--

CREATE TABLE `agendamento` (
  `data_aula` date DEFAULT NULL,
  `hora_aula` time DEFAULT NULL,
  `tipo_aula` varchar(100) DEFAULT NULL,
  `matricula` int(11) NOT NULL,
  `id_professor` int(11) NOT NULL,
  `id_agendamento` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agendamento`
--

INSERT INTO `agendamento` (`data_aula`, `hora_aula`, `tipo_aula`, `matricula`, `id_professor`, `id_agendamento`) VALUES
('2025-11-21', '23:13:00', 'natação', 9, 1, 1),
('2025-11-22', '00:16:00', 'natação', 9, 2, 2),
('2025-11-21', '22:25:00', 'natação', 9, 3, 3),
('2025-11-21', '22:13:00', 'natação', 9, 4, 4),
('2025-11-22', '20:00:00', 'musculação', 7, 6, 5),
('2025-11-22', '14:42:00', 'natação', 9, 1, 6),
('2025-11-22', '14:45:00', 'natação', 9, 3, 7),
('2025-11-22', '14:58:00', 'natação', 9, 1, 8),
('2025-11-22', '15:00:00', 'natação', 9, 1, 9),
('2025-11-22', '16:24:00', 'natação', 9, 1, 10),
('2025-11-24', '17:00:00', 'Musculação', 10, 5, 11),
('2025-11-24', '18:00:00', 'Musculação', 10, 6, 12),
('2025-11-28', '08:00:00', 'natação', 11, 2, 13),
('2025-12-10', '19:45:00', 'Musculação', 10, 6, 14),
('2025-11-27', '18:00:00', 'Musculação', 10, 3, 15),
('2025-12-10', '17:00:00', 'Musculação', 10, 3, 16),
('2025-12-13', '13:00:00', 'natação', 10, 4, 17),
('2025-11-27', '10:00:00', 'Musculação ', 10, 5, 18);

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

CREATE TABLE `aluno` (
  `matricula` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `cep` varchar(15) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `plano` varchar(20) NOT NULL,
  `login` varchar(100) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `nomematerno` varchar(100) DEFAULT NULL,
  `datanascimento` date DEFAULT NULL,
  `sexo` varchar(25) DEFAULT NULL,
  `token_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`matricula`, `nome`, `cpf`, `email`, `telefone`, `cep`, `endereco`, `plano`, `login`, `senha_hash`, `reset_token`, `reset_expires`, `nomematerno`, `datanascimento`, `sexo`, `token_expiration`) VALUES
(6, 'FABIA DULCE AZEVEDO LEITE DA SILVA', '160.745.677', 'geovannadasilva2309@gmail.com', '21969589465', '23057650', 'Rua Santo Antônio', 'mensal', 'FFFFFFF', '$2y$10$rKWqBGjmKLEs4DVt.rfy0OpIZAE6/31Q8RzebZ4qP.h9SYS9iqEUu', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'geovanna chata ', '16074567700', 'geovannadasilva700@gmail.com', '21969589465', '23058230', 'RUA PAÇUARE 1061', 'anual', 'geovanna', '$2y$10$P1xFK9oQQInDW/AGRtkdiOmA52B1krSjEDKV732AhNW4g36O0fANu', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'VIRNA SAVILA PINTO FERREIRA RODRIGUES', '179.476.977', 'virnasavila@gmail.com', '(21) 97523-3454', '23575-401', 'avenida jaime petit, Avenida Jaime Petit, 50, Santa Cruz, Rio de Janeiro - RJ', 'mensal', 'VIRNA', '$2y$10$KktxSe0EijjiedMi9V6VGuPM8lMiwP1lg4k4Y.mkkY9bSpeIOb7aO', NULL, NULL, 'VIRNA SAVILA PINTO FERREIRA RODRIGUES', '2001-01-10', 'feminino', NULL),
(10, 'Daniel Rosa Alvarenga', '181.768.227', 'danielalvarenga1301@gmail.com', '(21) 99744-2808', '23580-010', 'Rua Coronel Tito Porto Cerrero, Rua Coronel Porto Carrero, 19, Paciência, Rio de Janeiro - RJ', 'mensal', 'dani', '$2y$10$Q.Xwfiry6AJCiKcBX2AxmObaekyHZqVMAzgo7AoWfGt1OBVCLWwp.', NULL, NULL, 'Rosilane Oliveira Rosa', '2001-01-13', 'masculino', NULL),
(11, 'Rosilane Oliveira Rosa', '108.262.247', 'rosilanerosa@gmail.com', '(21) 99544-6751', '23580-010', 'Rua Coronel Tito Porto Cerrero, Rua Coronel Porto Carrero, 19, Paciência, Rio de Janeiro - RJ', 'trimestral', 'rosi', '$2y$10$b.cfAOQ7O/ARy9J3D/vAy.HROPg2o9ew79opjAmnG7W1DRObGoFMe', NULL, NULL, 'Marinete da Guia Oliveira Rosa', '1975-06-23', 'feminino', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `logs_autenticacao`
--

CREATE TABLE `logs_autenticacao` (
  `id` int(11) NOT NULL,
  `matricula` int(11) DEFAULT NULL,
  `usuario_nome` varchar(100) DEFAULT NULL,
  `usuario_cpf` varchar(20) DEFAULT NULL,
  `data_hora` datetime DEFAULT NULL,
  `segundo_fator` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `logs_autenticacao`
--

INSERT INTO `logs_autenticacao` (`id`, `matricula`, `usuario_nome`, `usuario_cpf`, `data_hora`, `segundo_fator`) VALUES
(1, 10, 'Daniel Rosa Alvarenga', '181.768.227', '2025-11-22 23:18:38', 'pendente'),
(2, 1, 'geovanna', '---', '2025-11-22 23:19:27', 'pendente'),
(3, 1, 'geovanna', '---', '2025-11-22 23:22:39', 'pendente'),
(4, 10, 'Daniel Rosa Alvarenga', '181.768.227', '2025-11-23 00:20:43', 'pendente'),
(5, 1, 'geovanna', '---', '2025-11-23 00:22:16', 'pendente'),
(6, 10, 'Daniel Rosa Alvarenga', '181.768.227', '2025-11-26 15:45:27', 'pendente'),
(7, 1, 'geovanna', '---', '2025-11-26 15:46:30', 'pendente'),
(8, 10, 'Daniel Rosa Alvarenga', '181.768.227', '2025-11-26 18:29:30', 'pendente'),
(9, 1, 'geovanna', '---', '2025-11-26 18:30:47', 'pendente'),
(10, 1, 'geovanna', '---', '2025-11-26 18:51:56', 'pendente'),
(11, 1, 'geovanna', '---', '2025-11-26 19:06:04', 'pendente'),
(12, 10, 'Daniel Rosa Alvarenga', '181.768.227', '2025-11-26 19:07:21', 'pendente'),
(13, 10, 'Daniel Rosa Alvarenga', '181.768.227', '2025-11-26 19:08:16', 'pendente'),
(14, 10, 'Daniel Rosa Alvarenga', '181.768.227', '2025-12-02 23:30:59', 'pendente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor`
--

CREATE TABLE `professor` (
  `id_professor` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `modalidade` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professor`
--

INSERT INTO `professor` (`id_professor`, `nome`, `modalidade`) VALUES
(1, 'joao silva', ''),
(2, 'maria clara', ''),
(5, 'felipe', 'musculação'),
(7, 'Daniel', 'Natação');

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor_horario`
--

CREATE TABLE `professor_horario` (
  `id_horario` int(11) NOT NULL,
  `id_professor` int(11) NOT NULL,
  `dia_semana` enum('Seg','Ter','Qua','Qui','Sex','Sab','Dom') NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professor_horario`
--

INSERT INTO `professor_horario` (`id_horario`, `id_professor`, `dia_semana`, `hora_inicio`, `hora_fim`) VALUES
(8, 10, 'Seg', '12:00:00', '18:00:00'),
(9, 10, 'Ter', '10:00:00', '16:00:00'),
(10, 10, 'Qua', '09:00:00', '15:00:00');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administração`
--
ALTER TABLE `administração`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices de tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD PRIMARY KEY (`id_agendamento`),
  ADD KEY `id_professor` (`id_professor`);

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`matricula`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Índices de tabela `logs_autenticacao`
--
ALTER TABLE `logs_autenticacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`id_professor`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administração`
--
ALTER TABLE `administração`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `agendamento`
--
ALTER TABLE `agendamento`
  MODIFY `id_agendamento` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `matricula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `logs_autenticacao`
--
ALTER TABLE `logs_autenticacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `id_professor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
