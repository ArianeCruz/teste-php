-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.0.35 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para projeto_loja_carros
CREATE DATABASE IF NOT EXISTS `projeto_loja_carros` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `projeto_loja_carros`;

-- Copiando estrutura para tabela projeto_loja_carros.brand
CREATE TABLE IF NOT EXISTS `brand` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela projeto_loja_carros.brand: ~10 rows (aproximadamente)
INSERT INTO `brand` (`id`, `name`) VALUES
	(1, 'Volkswagen'),
	(2, 'Fiat'),
	(3, 'Chevrolet'),
	(4, 'Ford'),
	(5, 'Toyota'),
	(6, 'Honda'),
	(7, 'Hyundai'),
	(8, 'Renault'),
	(9, 'Nissan'),
	(10, 'Jeep');

-- Copiando estrutura para tabela projeto_loja_carros.clients
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `street` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `house_number` int DEFAULT NULL,
  `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `state` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `zip_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `create_users_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `create_users_id` (`create_users_id`) USING BTREE,
  CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`create_users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela projeto_loja_carros.clients: ~10 rows (aproximadamente)
INSERT INTO `clients` (`id`, `name`, `email`, `cpf`, `date_of_birth`, `street`, `house_number`, `city`, `state`, `zip_code`, `create_users_id`) VALUES
	(1, 'Cliente', 'cliente@gmail.com', '203.526.658-12', '2024-03-13', 'Rua das Flores', 150, 'Curitiba', 'PR', '86450000', 2),
	(2, 'Zenaide', 'zenaide@gmail', '654.684.554-65', '2024-02-29', 'Rua dos Patos', 45, '', 'none', '', 2),
	(3, 'Bruna', 'bruna@gmail.com', '546.546.545-64', NULL, '', 0, '', 'none', '', 2),
	(4, 'Fernando', 'fernando@gmail.com', '355.145.646-51', NULL, '', 0, '', 'none', '', 2),
	(5, 'Gabriel', 'gabriel@gmail.com', '544.542.444-21', NULL, '', 0, '', 'none', '', 2),
	(6, 'Rafael', 'rafael@gmail.com', '153.215.646-54', NULL, NULL, NULL, NULL, 'none', NULL, 2),
	(7, 'Gabriela', 'gabriela@gmail.com', '123.213.456-54', '2024-03-12', NULL, NULL, NULL, 'none', NULL, 2),
	(8, 'Alvaro', 'alvaro@gmail.com', '125.646.554-56', '2024-03-13', 'Rua Maria Valask', 544, 'Curitiba', 'PR', '51465-456', 2),
	(9, 'Emily', 'emily@gmail.com', '545.646.546-54', '2024-03-20', NULL, NULL, NULL, 'none', NULL, 2),
	(10, 'Rodrigo', 'rodrigo@gmail.com', '545.645.645-64', NULL, NULL, NULL, NULL, 'none', NULL, 5);

-- Copiando estrutura para tabela projeto_loja_carros.models
CREATE TABLE IF NOT EXISTS `models` (
  `id` int NOT NULL AUTO_INCREMENT,
  `model` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `year` int NOT NULL,
  `brand_id` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `brand_id` (`brand_id`) USING BTREE,
  CONSTRAINT `models_brand_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela projeto_loja_carros.models: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela projeto_loja_carros.seller
CREATE TABLE IF NOT EXISTS `seller` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `seller_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela projeto_loja_carros.seller: ~3 rows (aproximadamente)
INSERT INTO `seller` (`id`, `name`, `email`, `user_id`) VALUES
	(1, 'Vendedor', 'vendedor@gmail.com', 5),
	(2, 'Marcelo', 'marcelo@gmail.com', 6),
	(3, 'Carol', 'carol@gmail.com', 7);

-- Copiando estrutura para tabela projeto_loja_carros.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('adm','vendedor') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('ativo','inativo') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela projeto_loja_carros.users: ~9 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`) VALUES
	(2, 'Ariane da Cruz', 'ariane@gmail.com', '$2y$10$kOcOO8kjV/k6g2phrJ2WDOEon1DE0cjPl2NOioLBYR2PpjS3OWuqK', 'adm', 'ativo'),
	(5, 'Vendedor', 'vendedor@gmail.com', '$2y$10$5pJow84HwPrnUbV39Fzd1.65mM.hQdHn7hcaIkBMvFsbDMtKDF416', 'vendedor', 'ativo'),
	(6, 'Marcelo', 'marcelo@gmail.com', '$2y$10$HmmFt4LPCqAhZG7QF2jaSeELP2rCNRhdyfsXrh6YR/dzc5TSS3YrS', 'vendedor', 'ativo'),
	(7, 'Carol', 'carol@gmail.com', '$2y$10$jAg.CIC5yJ12Tl4VaJteyOKpt93RK44iRvdiaU0bloEqPuQ8SVMQC', 'vendedor', 'ativo'),
	(8, 'Carlos', 'carlos@gmail.com', '$2y$10$erEv8G4FJH2JlbaxYp3XAO1zZ3X03fci/rztFfSg6Nv0BuXDVh3q6', 'adm', 'ativo'),
	(9, 'Emily', 'emily@gmail.com', '$2y$10$vyXd9IlQHDjCRW0F7cvQDucNtHU9372P5KC9Gaou16OUhxxZb0iu2', 'adm', 'ativo'),
	(10, 'Renan', 'renan@gmail.com', '$2y$10$BF50q3JKnoXVHdy6vcmZO.uYZcdv/EMP7IZMPHMlHyszrsI76TVg2', 'adm', 'ativo'),
	(11, 'Silvio', 'silvio@gmail.com', '$2y$10$32ANTWLo/8PMfdlkYi6tduv4raY.i21MAebtiWvZ7OVw7DpF4Xydy', 'adm', 'ativo'),
	(12, 'Bruno', 'bruno@gmail.com', '$2y$10$aofNex3e5RBBVTDk.loS4OgkXIt465UvBP0pj.4EwWT0QuxIKhKii', 'adm', 'ativo');

-- Copiando estrutura para tabela projeto_loja_carros.vehicle_sale
CREATE TABLE IF NOT EXISTS `vehicle_sale` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sale_date` date DEFAULT NULL,
  `modelo_id` int DEFAULT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `model_id` (`modelo_id`) USING BTREE,
  CONSTRAINT `vehicle_sale_ibfk_1` FOREIGN KEY (`modelo_id`) REFERENCES `models` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela projeto_loja_carros.vehicle_sale: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
