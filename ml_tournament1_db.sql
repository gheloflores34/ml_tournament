-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2026 at 07:38 AM
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
-- Database: `ml_tournament1`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `type` enum('hero','role','badge') NOT NULL DEFAULT 'hero',
  `name` varchar(100) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `type`, `name`, `filename`, `created_at`) VALUES
(1, 'badge', 'Gold', 'asset_badge_6a068fcde88aa.png', '2026-05-15 03:15:25'),
(3, 'badge', 'Bronze', 'asset_badge_6a068fe986bbf.png', '2026-05-15 03:15:53'),
(4, 'badge', 'Silver', 'asset_badge_6a068ff118271.png', '2026-05-15 03:16:01'),
(5, 'badge', 'MVP Lose', 'asset_badge_6a068ffb342b7.png', '2026-05-15 03:16:11'),
(6, 'badge', 'MVP', 'asset_badge_6a06900375024.png', '2026-05-15 03:16:19'),
(7, 'role', 'Gold Lane', 'asset_role_6a069023cdab4.png', '2026-05-15 03:16:51'),
(8, 'role', 'EXP Lane', 'asset_role_6a0690314b9ad.png', '2026-05-15 03:17:05'),
(9, 'role', 'Jungler', 'asset_role_6a06903b963e4.png', '2026-05-15 03:17:15'),
(10, 'role', 'Mid Lane', 'asset_role_6a06904634891.png', '2026-05-15 03:17:26'),
(11, 'role', 'Roam', 'asset_role_6a06904fee1f8.png', '2026-05-15 03:17:35'),
(12, 'hero', 'Suyou', 'asset_hero_6a0690f18868c.jpg', '2026-05-15 03:20:17'),
(13, 'hero', 'Selena', 'asset_hero_6a0690fe56876.webp', '2026-05-15 03:20:30'),
(14, 'hero', 'Khaleed', 'asset_hero_6a069108b4716.jpg', '2026-05-15 03:20:40'),
(15, 'hero', 'Yi Sun-Shin', 'asset_hero_6a06914ff1f2e.jpg', '2026-05-15 03:21:51'),
(16, 'hero', 'Edith', 'asset_hero_6a06915a5bb9d.jpg', '2026-05-15 03:22:02'),
(17, 'hero', 'Grock', 'asset_hero_6a069163800c4.jpg', '2026-05-15 03:22:11'),
(18, 'hero', 'Lapu-Lapu', 'asset_hero_6a069179633bd.jpg', '2026-05-15 03:22:33'),
(19, 'hero', 'Baxia', 'asset_hero_6a069188da428.jpg', '2026-05-15 03:22:48'),
(20, 'hero', 'Harith', 'asset_hero_6a0691941edf0.jpg', '2026-05-15 03:23:00'),
(21, 'hero', 'Yve', 'asset_hero_6a06919f22a58.jpg', '2026-05-15 03:23:11'),
(22, 'hero', 'Benedetta', 'asset_hero_6a06a9113661b.webp', '2026-05-15 05:03:13'),
(23, 'hero', 'Phovious', 'asset_hero_6a06a9238ba6b.webp', '2026-05-15 05:03:31'),
(24, 'hero', 'Lou Yi', 'asset_hero_6a06a92de7272.webp', '2026-05-15 05:03:41'),
(25, 'hero', 'Yu Zhong', 'asset_hero_6a06a93a51882.webp', '2026-05-15 05:03:54'),
(26, 'hero', 'Natan', 'asset_hero_6a06a94273f31.webp', '2026-05-15 05:04:02'),
(27, 'hero', 'Paquito', 'asset_hero_6a06a94b9654a.webp', '2026-05-15 05:04:11'),
(28, 'hero', 'Mathilda', 'asset_hero_6a06a95865005.webp', '2026-05-15 05:04:24'),
(29, 'hero', 'Aamon', 'asset_hero_6a06a9675a3d7.webp', '2026-05-15 05:04:39'),
(30, 'hero', 'Aulus', 'asset_hero_6a06a96d75cb6.webp', '2026-05-15 05:04:45'),
(31, 'hero', 'Barats', 'asset_hero_6a06a97697608.webp', '2026-05-15 05:04:54'),
(32, 'hero', 'Cyclops', 'asset_hero_6a06a97d0e6ae.webp', '2026-05-15 05:05:01'),
(33, 'hero', 'Estes', 'asset_hero_6a06a989b3864.webp', '2026-05-15 05:05:13'),
(34, 'hero', 'Brody', 'asset_hero_6a06a99d581cc.webp', '2026-05-15 05:05:33'),
(35, 'hero', 'Gloo', 'asset_hero_6a06a9a52de18.webp', '2026-05-15 05:05:41'),
(36, 'hero', 'Hirara', 'asset_hero_6a06ad49b564a.webp', '2026-05-15 05:21:13'),
(37, 'hero', 'Sora', 'asset_hero_6a06ad5c1013d.webp', '2026-05-15 05:21:32'),
(38, 'hero', 'Obsidia', 'asset_hero_6a06ad69bc586.webp', '2026-05-15 05:21:45'),
(39, 'hero', 'Chou', 'asset_hero_6a06ad751a6e2.webp', '2026-05-15 05:21:57'),
(40, 'hero', 'Kagura', 'asset_hero_6a06ad82392c9.webp', '2026-05-15 05:22:10'),
(41, 'hero', 'Jhonson', 'asset_hero_6a06ad8dd3a7e.webp', '2026-05-15 05:22:21'),
(42, 'hero', 'Ruby', 'asset_hero_6a06ad9d88116.webp', '2026-05-15 05:22:37'),
(43, 'hero', 'Sun', 'asset_hero_6a06ada9b7fce.webp', '2026-05-15 05:22:49'),
(44, 'hero', 'Moskov', 'asset_hero_6a06adb6325a6.webp', '2026-05-15 05:23:02'),
(45, 'hero', 'Lukas', 'asset_hero_6a06ae1b39662.webp', '2026-05-15 05:24:43'),
(46, 'hero', 'Zetian', 'asset_hero_6a06ae297afaf.webp', '2026-05-15 05:24:57'),
(47, 'hero', 'Kalea', 'asset_hero_6a06ae3d48d01.webp', '2026-05-15 05:25:17'),
(48, 'hero', 'Beatrix', 'asset_hero_6a06af99106ac.webp', '2026-05-15 05:31:05');

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
  `flag_a` varchar(5) NOT NULL DEFAULT '',
  `flag_b` varchar(5) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`id`, `team_a`, `team_b`, `team_a_img`, `team_b_img`, `score_a`, `score_b`, `winner`, `round`, `flag_a`, `flag_b`, `created_at`, `updated_at`) VALUES
(1, 'Onic PH', 'RORA PH', 'team_a_6a0692df09b06.png', 'team_b_6a0692df0afb7.jpg', 2, 0, 'Onic PH', 'Semi Finals', 'PH', 'PH', '2026-05-15 02:59:39', '2026-05-15 03:44:19'),
(2, 'Falcon', 'BlackList International', 'team_a_6a0695e03059a.jpg', 'team_b_6a0695e031555.jpg', 0, 2, 'BlackList International', 'Semi Finals', 'PH', 'PH', '2026-05-15 02:59:39', '2026-05-15 03:44:10'),
(3, 'Onic PH', 'BlackList International', 'team_a_6a06961611482.png', 'team_b_6a06961611f35.jpg', 3, 4, 'BlackList International', 'Finals', 'PH', 'PH', '2026-05-15 03:42:07', '2026-05-15 03:43:02');

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
  `hero_name` varchar(100) NOT NULL DEFAULT '',
  `role_img` varchar(255) DEFAULT NULL,
  `role_name` varchar(100) NOT NULL DEFAULT '',
  `kills` tinyint(4) NOT NULL DEFAULT 0,
  `deaths` tinyint(4) NOT NULL DEFAULT 0,
  `assists` tinyint(4) NOT NULL DEFAULT 0,
  `badge` enum('none','bronze','silver','gold','mvp','mvp_lose') NOT NULL DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `match_players`
--

INSERT INTO `match_players` (`id`, `match_id`, `team_side`, `slot`, `ign`, `hero_img`, `hero_name`, `role_img`, `role_name`, `kills`, `deaths`, `assists`, `badge`) VALUES
(1, 1, 'A', 1, 'KingKong', 'asset_hero_6a0690f18868c.jpg', 'Suyou', 'asset_role_6a06903b963e4.png', 'Jungler', 15, 6, 8, 'mvp'),
(2, 1, 'A', 2, 'SuperPrince', 'asset_hero_6a0690fe56876.webp', 'Selena', 'asset_role_6a06904634891.png', 'Mid Lane', 3, 3, 9, 'gold'),
(3, 1, 'A', 3, 'Kirk!', 'asset_hero_6a06915a5bb9d.jpg', 'Edith', 'asset_role_6a0690314b9ad.png', 'EXP Lane', 1, 5, 5, 'silver'),
(4, 1, 'A', 4, 'Savero', 'asset_hero_6a06914ff1f2e.jpg', 'Yi Sun-Shin', 'asset_role_6a069023cdab4.png', 'Gold Lane', 3, 0, 9, 'gold'),
(5, 1, 'A', 5, 'Brusko', 'asset_hero_6a069108b4716.jpg', 'Khaleed', 'asset_role_6a06904fee1f8.png', 'Roam', 1, 6, 13, 'gold'),
(6, 1, 'B', 1, 'Demonkite', 'asset_hero_6a069188da428.jpg', 'Baxia', 'asset_role_6a06903b963e4.png', 'Jungler', 7, 8, 10, 'gold'),
(7, 1, 'B', 2, 'Edward', 'asset_hero_6a069179633bd.jpg', 'Lapu-Lapu', 'asset_role_6a0690314b9ad.png', 'EXP Lane', 4, 5, 4, 'silver'),
(8, 1, 'B', 3, 'Light', 'asset_hero_6a069163800c4.jpg', 'Grock', 'asset_role_6a06904fee1f8.png', 'Roam', 1, 8, 8, 'silver'),
(9, 1, 'B', 4, 'DominKite', 'asset_hero_6a0691941edf0.jpg', 'Harith', 'asset_role_6a069023cdab4.png', 'Gold Lane', 7, 3, 2, 'mvp_lose'),
(10, 1, 'B', 5, 'Haji', 'asset_hero_6a06919f22a58.jpg', 'Yve', 'asset_role_6a06904634891.png', 'Mid Lane', 3, 2, 6, 'gold'),
(11, 2, 'A', 1, 'KyleTzy', 'asset_hero_6a06a9675a3d7.webp', 'Aamon', 'asset_role_6a06903b963e4.png', 'Jungler', 5, 4, 2, 'mvp_lose'),
(12, 2, 'A', 2, 'Owgwen', 'asset_hero_6a06ada9b7fce.webp', 'Sun', 'asset_role_6a06904fee1f8.png', 'Roam', 2, 6, 3, 'silver'),
(13, 2, 'A', 3, 'Ferdz', 'asset_hero_6a06ad82392c9.webp', 'Kagura', 'asset_role_6a06904634891.png', 'Mid Lane', 3, 3, 5, 'gold'),
(14, 2, 'A', 4, 'Super Marco', 'asset_hero_6a06a99d581cc.webp', 'Brody', 'asset_role_6a069023cdab4.png', 'Gold Lane', 1, 5, 2, 'bronze'),
(15, 2, 'A', 5, 'FlapTzy', 'asset_hero_6a06a96d75cb6.webp', 'Aulus', 'asset_role_6a0690314b9ad.png', 'EXP Lane', 3, 2, 3, 'gold'),
(16, 2, 'B', 1, 'Wise', 'asset_hero_6a06ad49b564a.webp', 'Hirara', 'asset_role_6a06903b963e4.png', 'Jungler', 8, 3, 3, 'mvp'),
(17, 2, 'B', 2, 'OhMyV33nus', 'asset_hero_6a06a989b3864.webp', 'Estes', 'asset_role_6a06904fee1f8.png', 'Roam', 0, 2, 10, 'gold'),
(18, 2, 'B', 3, 'Hadji', 'asset_hero_6a06a92de7272.webp', 'Lou Yi', 'asset_role_6a06904634891.png', 'Mid Lane', 2, 1, 8, 'gold'),
(19, 2, 'B', 4, 'OHEB', 'asset_hero_6a06af99106ac.webp', 'Beatrix', 'asset_role_6a069023cdab4.png', 'Gold Lane', 5, 0, 6, 'gold'),
(20, 2, 'B', 5, 'Renejay', 'asset_hero_6a06a9113661b.webp', 'Benedetta', 'asset_role_6a0690314b9ad.png', 'EXP Lane', 3, 2, 6, 'gold'),
(21, 3, 'A', 1, 'KingKong', 'asset_hero_6a06ae1b39662.webp', 'Lukas', 'asset_role_6a06903b963e4.png', 'Jungler', 6, 3, 7, 'mvp'),
(22, 3, 'A', 2, 'SuperPrince', 'asset_hero_6a06a97d0e6ae.webp', 'Cyclops', 'asset_role_6a06904634891.png', 'Mid Lane', 3, 6, 9, 'silver'),
(23, 3, 'A', 3, 'Kirk!', 'asset_hero_6a069108b4716.jpg', 'Khaleed', 'asset_role_6a0690314b9ad.png', 'EXP Lane', 4, 5, 8, 'gold'),
(24, 3, 'A', 4, 'Savero', 'asset_hero_6a06ad69bc586.webp', 'Obsidia', 'asset_role_6a069023cdab4.png', 'Gold Lane', 3, 2, 5, 'silver'),
(25, 3, 'A', 5, 'Brusko', 'asset_hero_6a06ad751a6e2.webp', 'Chou', 'asset_role_6a06904fee1f8.png', 'Roam', 3, 5, 10, 'gold'),
(26, 3, 'B', 1, 'Wise', 'asset_hero_6a06ad49b564a.webp', 'Hirara', 'asset_role_6a06903b963e4.png', 'Jungler', 12, 3, 6, 'mvp'),
(27, 3, 'B', 2, 'OhMyV33nus', 'asset_hero_6a06a989b3864.webp', 'Estes', 'asset_role_6a06904fee1f8.png', 'Roam', 0, 2, 12, 'gold'),
(28, 3, 'B', 3, 'Hadji', 'asset_hero_6a06a92de7272.webp', 'Lou Yi', 'asset_role_6a06904634891.png', 'Mid Lane', 4, 2, 7, 'gold'),
(29, 3, 'B', 4, 'OHEB', 'asset_hero_6a06af99106ac.webp', 'Beatrix', 'asset_role_6a069023cdab4.png', 'Gold Lane', 3, 2, 5, 'gold'),
(30, 3, 'B', 5, 'Renejay', 'asset_hero_6a06ad5c1013d.webp', 'Sora', 'asset_role_6a0690314b9ad.png', 'EXP Lane', 4, 5, 7, 'gold');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `match_players`
--
ALTER TABLE `match_players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
