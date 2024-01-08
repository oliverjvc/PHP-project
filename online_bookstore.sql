-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 08, 2024 at 09:48 AM
-- Server version: 8.0.35
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `genre`, `price`, `image_url`) VALUES
(4, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', '1200.00', 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/The_Great_Gatsby_Cover_1925_Retouched.jpg/634px-The_Great_Gatsby_Cover_1925_Retouched.jpg'),
(5, 'To Kill a Mockingbird', 'Harper Lee', 'Classics', '1050.00', 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/To_Kill_a_Mockingbird_%28first_edition_cover%29.jpg/728px-To_Kill_a_Mockingbird_%28first_edition_cover%29.jpg'),
(6, '1984', 'George Orwell', 'Dystopian', '1500.00', 'https://upload.wikimedia.org/wikipedia/en/5/51/1984_first_edition_cover.jpg'),
(32, 'Brave New World', 'Aldous Huxley', 'Dystopian', '1250.00', 'https://upload.wikimedia.org/wikipedia/en/6/62/BraveNewWorld_FirstEdition.jpg'),
(33, 'Fahrenheit 451', 'Ray Bradbury', 'Dystopian', '1300.00', 'https://upload.wikimedia.org/wikipedia/en/d/db/Fahrenheit_451_1st_ed_cover.jpg'),
(34, 'Wuthering Heights', 'Emily Brontë', 'Classics', '1200.00', 'https://m.media-amazon.com/images/I/81unikMK30L._AC_UF894,1000_QL80_.jpg'),
(35, 'The Count of Monte Cristo', 'Alexandre Dumas', 'Classics', '1300.00', 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/Louis_Fran%C3%A7ais-Dant%C3%A8s_sur_son_rocher.jpg/330px-Louis_Fran%C3%A7ais-Dant%C3%A8s_sur_son_rocher.jpg'),
(36, 'Anna Karenina', 'Leo Tolstoy', 'Classics', '1400.00', 'https://images.booksense.com/images/881/618/9788415618881.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `book_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `book_id` int DEFAULT NULL,
  `review_text` text,
  `rating` int DEFAULT NULL,
  `review_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `book_id`, `review_text`, `rating`, `review_date`) VALUES
(1, 10, 6, 'da', 5, '2024-01-07 18:34:33'),
(2, 10, 5, 'da', 5, '2024-01-07 21:10:42'),
(3, 14, 6, 'Dobra knjiga, govori o manipulaciji društva', 5, '2024-01-08 09:02:06'),
(4, 14, 6, 'Dobra knjiga, govori o manipulaciji društva', 5, '2024-01-08 09:04:17'),
(5, 14, 6, 'Dobra knjiga', 5, '2024-01-08 09:04:42'),
(6, 14, 36, 'Ruski klasik', 5, '2024-01-08 09:05:10'),
(7, 15, 6, 'da', 5, '2024-01-08 09:39:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(3, 'Oliver1', 'srihith.rishi@falkcia.com', '$2y$10$E7tMJZSDPf2b5jz3Vhpq4OGH/eC7OlZAYpPxS4iX.z/emTuHtpOlO'),
(5, '\'OR \'1\'=\'1', 'srihith.rishi@falkcia.com', 'dada'),
(6, 'Primer', 'primer@gmail.com', '$2y$10$OqxEbFR0gfYfQBTzBqzZcOz6jTSACmTwYa4XfO6oe1LuhwzAGS/eS'),
(7, 'Oliver', 'fakemail@gmail.com', '$2y$10$zNa9F/aBfcIiB4q5SDLvf.PJ.kdEX2zynaJio0iLonhVsRKXWfe1y'),
(8, 'Oliver1', 'oliver1@mail.com', '$2y$10$4En1YWQrRIfv86dOMIZIjuL8byDrv1K1BcTtKWXBGCBGpqDzWoDV.'),
(9, 'Oliver', 'oliver@gmail.com', '$2y$10$J2VmcqQiMKh.2E.Pms3Mp.aWVJxw6Pn.aV4cxIY1/U1az/x18ECkS'),
(10, 'Oliver11', 'oliver11@gmail.com', '$2y$10$QgXZqXsIC2KCeENxfZvFbOGNQYlR.b1s4L0A04LKwLkMuujtvMDAW'),
(11, 'Oliver2', 'oliver2@gmail.com', '$2y$10$c2DsrylVVY44KgTP1dO0xeLjg3UTHNWDfJaSoZcX7VJmEIDrpI6Ue'),
(12, 'Oliver2', 'oliver2@gmail.com', '$2y$10$MsKUqka96SD/HJoZSdNs3ermSi1g4GbEy8FsiLBB/nQCx.3LLrxHa'),
(13, 'Oliver2', 'oliver2@gmail.com', '$2y$10$LaFMwwd1Z/s.MNKdt9zu7ORN8bBOn1pJbHX3by71MrOZ9d3ScwLu6'),
(14, 'Oliver3', 'oliver3@mail.com', '$2y$10$hLl46lZnq.ACc2Rvm7buO.88yh2N5ivU5hCagcZzgKtklS3m.MaUy'),
(15, 'Primer22', 'primer22@gmail.com', '$2y$10$KdKI5ThKzWWfLGlNsZoHqu1b6uS5VUviPXeJd/wqkJuVJMPYp5dAy');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
