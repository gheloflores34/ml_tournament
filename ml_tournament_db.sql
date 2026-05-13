-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2026 at 08:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ml_tournament`
--

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `id` int(11) NOT NULL,
  `team_a` varchar(100) NOT NULL,
  `team_b` varchar(100) NOT NULL,
  `team_a_img` varchar(255) DEFAULT NULL,
  `team_b_img` varchar(255) DEFAULT NULL,
  `score_a` int(11) NOT NULL DEFAULT 0,
  `score_b` int(11) NOT NULL DEFAULT 0,
  `winner` varchar(100) NOT NULL,
  `round` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`id`, `team_a`, `team_b`, `team_a_img`, `team_b_img`, `score_a`, `score_b`, `winner`, `round`, `created_at`, `updated_at`) VALUES
(1, 'Onic PH', 'RORA PH', 'team_a_69e5b6129c8fe.png', 'team_b_69e5b6129cf2b.jpg', 2, 0, 'Onic PH', 'Quarter Finals', '2026-04-20 05:07:40', '2026-04-20 05:13:54'),
(2, 'Falcon', 'BlackList International', 'team_a_69e86ad460f21.jpg', 'team_b_6a040b1ecbc81.jpg', 0, 2, 'BlackList International', 'Quarter Finals', '2026-04-20 05:07:40', '2026-05-13 05:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `match_players`
--

CREATE TABLE `match_players` (
  `id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `team_side` enum('A','B') NOT NULL,
  `slot` tinyint(4) NOT NULL DEFAULT 1,
  `ign` varchar(100) NOT NULL DEFAULT '',
  `hero_img` varchar(255) DEFAULT NULL,
  `kills` tinyint(4) NOT NULL DEFAULT 0,
  `deaths` tinyint(4) NOT NULL DEFAULT 0,
  `assists` tinyint(4) NOT NULL DEFAULT 0,
  `badge` enum('none','bronze','silver','gold','mvp') NOT NULL DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `match_players`
--

INSERT INTO `match_players` (`id`, `match_id`, `team_side`, `slot`, `ign`, `hero_img`, `kills`, `deaths`, `assists`, `badge`) VALUES
(1, 1, 'A', 1, 'KingKong', 'hero_a_1_69e86a8e3c588.jpg', 15, 4, 7, 'none'),
(2, 1, 'A', 2, 'SuperPrince', 'hero_a_2_69e825306f84d.webp', 5, 1, 6, 'none'),
(3, 1, 'A', 3, 'Savero', 'hero_a_3_69e825307169c.jpg', 4, 6, 2, 'none'),
(4, 1, 'A', 4, 'Kirk!', 'hero_a_4_69e82530730b6.jpg', 3, 2, 5, 'none'),
(5, 1, 'A', 5, 'Brusko', 'hero_a_5_69e86a8e48060.jpg', 3, 3, 7, 'none'),
(6, 1, 'B', 1, 'Demonkite', 'hero_b_1_69e86a8e48daf.jpg', 6, 7, 2, 'none'),
(7, 1, 'B', 2, 'Edward', 'hero_b_2_69e86a8e4998b.jpg', 3, 4, 5, 'none'),
(8, 1, 'B', 3, 'Light', 'hero_b_3_69e86a8e4a598.jpg', 2, 2, 3, 'none'),
(9, 1, 'B', 4, 'DominKite', 'hero_b_4_69e86a8e4b5e7.jpg', 2, 4, 1, 'none'),
(10, 1, 'B', 5, 'Haji', 'hero_b_5_69e86a8e4c21d.jpg', 3, 3, 4, 'none');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `match_players`
--
ALTER TABLE `match_players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `match_id` (`match_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `match_players`
--
ALTER TABLE `match_players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `match_players`
--
ALTER TABLE `match_players`
  ADD CONSTRAINT `match_players_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
