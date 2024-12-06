-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 05/12/2024 às 13:31
-- Versão do servidor: 8.0.34
-- Versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `scrap`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `descricao`) VALUES


-- --------------------------------------------------------

--
-- Estrutura para tabela `falhas`
--

CREATE TABLE `falhas` (
  `id` int NOT NULL,
  `descricao` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `falhas`
--

INSERT INTO `falhas` (`id`, `descricao`) VALUES

-- --------------------------------------------------------

--
-- Estrutura para tabela `linha`
--

CREATE TABLE `linha` (
  `id` int NOT NULL,
  `descricao` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `linha`
--

INSERT INTO `linha` (`id`, `descricao`) VALUES

-- --------------------------------------------------------

--
-- Estrutura para tabela `modelo`
--

CREATE TABLE `modelo` (
  `id` int NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `cliente_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `modelo`
--

INSERT INTO `modelo` (`id`, `descricao`, `cliente_id`) VALUES


-- --------------------------------------------------------

--
-- Estrutura para tabela `partnumber`
--

CREATE TABLE `partnumber` (
  `id` int NOT NULL,
  `partnumber` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_unit` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `partnumber`
--

INSERT INTO `partnumber` (`id`, `partnumber`, `valor_unit`, `descricao`) VALUES

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id` int NOT NULL,
  `cimcode` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cliente_id` int DEFAULT NULL,
  `linha_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `usuario_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id`, `cimcode`, `cliente_id`, `linha_id`, `created_at`, `updated_at`, `usuario_id`) VALUES


-- --------------------------------------------------------

--
-- Estrutura para tabela `scrap_pn`
--

CREATE TABLE `scrap_pn` (
  `id` int NOT NULL,
  `quantidade` int NOT NULL,
  `valor_t` double NOT NULL,
  `observacao` varchar(100) DEFAULT NULL,
  `scrap_id` int NOT NULL,
  `falhas_id` int NOT NULL,
  `partnumber_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `scrap_pn`
--

INSERT INTO `scrap_pn` (`id`, `quantidade`, `valor_t`, `observacao`, `scrap_id`, `falhas_id`, `partnumber_id`) VALUES

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `prontuario` int NOT NULL,
  `senha` varchar(45) NOT NULL,
  `tipo_usuario` int NOT NULL COMMENT '1 - ADMIN\r\n2 - COORD\r\n3 - ENG / TEC\r\n4 - OPER',
  `nome` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `prontuario`, `senha`, `tipo_usuario`, `nome`, `created_at`, `updated_at`) VALUES

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `falhas`
--
ALTER TABLE `falhas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `linha`
--
ALTER TABLE `linha`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cliente_id_idx` (`cliente_id`),
  ADD KEY `fk_cliente_id_idz` (`cliente_id`),
  ADD KEY `fk_cliente_id_id` (`cliente_id`),
  ADD KEY `fk_cliente_id_cliente` (`cliente_id`);

--
-- Índices de tabela `partnumber`
--
ALTER TABLE `partnumber`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_cliente_id_idx` (`cliente_id`),
  ADD KEY `fk_usuario_id_idx` (`usuario_id`),
  ADD KEY `fk_linha_id` (`linha_id`);

--
-- Índices de tabela `produtos_partnumber`
--
ALTER TABLE `produtos_partnumber`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produto_idx` (`produto_id`),
  ADD KEY `fk_partnumber_idx` (`partnumber_id`);

--
-- Índices de tabela `scrap`
--
ALTER TABLE `scrap`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `serial` (`serial`) USING BTREE,
  ADD KEY `fk_usuario_id_idx` (`usuario_id`),
  ADD KEY `fk_engenheiro_id_idx` (`engenheiro_id`),
  ADD KEY `fk_coordenador_id_idx` (`coordenador_id`),
  ADD KEY `fk_produto_id_pn` (`produto_id`),
  ADD KEY `fk_modelo_id_modelo_idx` (`modelo_id`);

--
-- Índices de tabela `scrap_pn`
--
ALTER TABLE `scrap_pn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_falhas_id_idx` (`falhas_id`),
  ADD KEY `fk_partnumber_id_idx` (`partnumber_id`),
  ADD KEY `fk_scrap_id_idx` (`scrap_id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prontuario_UNIQUE` (`prontuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `falhas`
--
ALTER TABLE `falhas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de tabela `linha`
--
ALTER TABLE `linha`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `modelo`
--
ALTER TABLE `modelo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `partnumber`
--
ALTER TABLE `partnumber`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24562;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=507;

--
-- AUTO_INCREMENT de tabela `produtos_partnumber`
--
ALTER TABLE `produtos_partnumber`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `scrap`
--
ALTER TABLE `scrap`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de tabela `scrap_pn`
--
ALTER TABLE `scrap_pn`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `modelo`
--
ALTER TABLE `modelo`
  ADD CONSTRAINT `fk_cliente_id_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `fk_cliente_id` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `fk_linha_id` FOREIGN KEY (`linha_id`) REFERENCES `linha` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Restrições para tabelas `produtos_partnumber`
--
ALTER TABLE `produtos_partnumber`
  ADD CONSTRAINT `fk_partnumber` FOREIGN KEY (`partnumber_id`) REFERENCES `partnumber` (`id`),
  ADD CONSTRAINT `fk_produto` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`);

--
-- Restrições para tabelas `scrap`
--
ALTER TABLE `scrap`
  ADD CONSTRAINT `fk_coordenador_id` FOREIGN KEY (`coordenador_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_engenheiro_id` FOREIGN KEY (`engenheiro_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_modelo_id_modelo` FOREIGN KEY (`modelo_id`) REFERENCES `modelo` (`id`),
  ADD CONSTRAINT `fk_produto_id_pn` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_usuario_autor_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Restrições para tabelas `scrap_pn`
--
ALTER TABLE `scrap_pn`
  ADD CONSTRAINT `fk_falhas_id` FOREIGN KEY (`falhas_id`) REFERENCES `falhas` (`id`),
  ADD CONSTRAINT `fk_partnumber_id` FOREIGN KEY (`partnumber_id`) REFERENCES `partnumber` (`id`),
  ADD CONSTRAINT `fk_scrap_id` FOREIGN KEY (`scrap_id`) REFERENCES `scrap` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
