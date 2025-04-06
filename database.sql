-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Tempo de geração: 06/04/2025 às 04:26
-- Versão do servidor: 8.0.40
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `games_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `games`
--

CREATE TABLE `games` (
  `image_link` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `assessment` int NOT NULL,
  `game_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `games`
--

INSERT INTO `games` (`image_link`, `title`, `description`, `assessment`, `game_id`) VALUES
('https://m.media-amazon.com/images/I/81IhJqjuT8L._AC_UF1000,1000_QL80_.jpg', 'Horizon Zero Dawn 2', 'Horizon Forbidden West é um jogo eletrônico de RPG de ação desenvolvido pela Guerrilla Games e publicado pela Sony Interactive Entertainment. Foi lançado em 18 de fevereiro de 2022 para PlayStation 4 e PlayStation 5.', 3, 1),
('https://image.api.playstation.com/vulcan/ap/rnd/202502/2711/cbc6c3135660ec68eacc766959a766b36d7ce3fa6010ca88.png', 'Death Stranding 2: On The Beach', 'Death Stranding 2: On The Beach é um futuro jogo de ação desenvolvido pela Kojima Productions e publicado pela Sony Interactive Entertainment. É a sequência de Death Stranding e foi escrito, produzido e dirigido por Hideo Kojima.', 5, 4),
('https://upload.wikimedia.org/wikipedia/pt/9/9c/Minecraft_capa.png', 'Minecraft', 'jogo foda kkk lol', 5, 5);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
