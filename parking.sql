-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2023 at 03:04 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parking`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_verifications`
--

CREATE TABLE `email_verifications` (
  `id` bigint(20) NOT NULL,
  `token` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` enum('guard','student') NOT NULL,
  `expired_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_verifications`
--

INSERT INTO `email_verifications` (`id`, `token`, `email`, `role`, `expired_at`) VALUES
(4, 'a9c61c48-643e-468a-b43e-e994e582806c', 'irvanhakim@students.amikom.ac.id', 'student', '2023-05-01 13:16:49'),
(5, '9f3adade-a968-4d0b-8883-abc9ddb7d6bc', 'irvanhakim.dev@gmail.com', '', '0000-00-00 00:00:00'),
(6, 'b8dc15c5-78e2-4c45-8249-16238ae42a27', 'irvanhakim@students.amikom.ac.id', '', '0000-00-00 00:00:00'),
(7, '585bbcc7-a268-45a6-8559-78c7a81a10c3', 'irvanhakim@students.amikom.ac.id', 'student', '2023-05-01 13:56:23'),
(8, '0ad98e88-8a78-4af1-91a5-1fc6dee0777c', 'irvanhakim@students.amikom.ac.id', 'student', '2023-05-01 14:00:00'),
(9, '9e0e33a5-7063-4e70-ad65-a8ba9a95c1fa', 'irvanhakim@students.amikom.ac.id', 'student', '2023-05-01 14:01:54'),
(10, '2b92277b-9077-492a-8bf8-c0ef0cab33cf', 'irvanhakim@students.amikom.ac.id', 'student', '2023-05-01 14:05:56');

-- --------------------------------------------------------

--
-- Table structure for table `exits_aproved`
--

CREATE TABLE `exits_aproved` (
  `id` bigint(20) NOT NULL,
  `id_guard` bigint(20) NOT NULL,
  `id_out_of_parking` bigint(20) NOT NULL,
  `aproved_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exits_aproved`
--

INSERT INTO `exits_aproved` (`id`, `id_guard`, `id_out_of_parking`, `aproved_at`) VALUES
(8, 1, 15, '2023-04-29 07:10:13'),
(9, 2, 8, '2023-04-29 07:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `guards`
--

CREATE TABLE `guards` (
  `id` bigint(20) NOT NULL,
  `email` varchar(70) NOT NULL,
  `verified_at` datetime DEFAULT NULL,
  `password` text NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `image_url` text NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guards`
--

INSERT INTO `guards` (`id`, `email`, `verified_at`, `password`, `nama`, `nip`, `image_url`, `is_admin`, `is_active`) VALUES
(1, 'mail@mail.com', NULL, '$2y$10$Oq4hQAdxxoVLt4FdUce0TeVmr5sypYB8dHKpWdrWh1bFvZYkynpiW', 'Kirisaki Rem', '0000000', '1682785026_8918e51e3de5040da514.jpg', 1, 0),
(2, 'your@mail.com', '2023-05-01 19:06:15', '$2y$10$15bPQXGBwnaoeW4tRIIhX.h1gnWF3HalzUJyD72hiHe7bcmFV7gCS', 'Bakunya', '12983721839', '1682942675_d514aa6add45e91a4f76.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `out_of_parkings`
--

CREATE TABLE `out_of_parkings` (
  `id` bigint(20) NOT NULL,
  `id_vehicle` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `out_of_parkings`
--

INSERT INTO `out_of_parkings` (`id`, `id_vehicle`, `created_at`) VALUES
(8, 6, '2023-04-27 15:15:54'),
(15, 6, '2023-04-29 06:16:52');

-- --------------------------------------------------------

--
-- Table structure for table `reset_passwords`
--

CREATE TABLE `reset_passwords` (
  `id` bigint(20) NOT NULL,
  `token` varchar(40) NOT NULL,
  `role` enum('student','guard','student-guard') NOT NULL,
  `expired_at` datetime NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reset_passwords`
--

INSERT INTO `reset_passwords` (`id`, `token`, `role`, `expired_at`, `email`) VALUES
(1, 'f44ac88f-ecb8-4ba8-9e50-ed17acaf3a7e', 'student', '2023-04-30 15:38:32', 'irvanhakim@students.amikom.ac.id'),
(2, 'bb5a8ad2-bb39-41cf-a662-56aa57e037d0', 'student', '2023-04-30 15:41:30', 'irvanhakim@students.amikom.ac.id'),
(4, '532b523d-223c-410d-8405-6776b60512f6', 'student', '2023-04-30 15:48:18', 'irvanhakim@students.amikom.ac.id');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) NOT NULL,
  `nim` varchar(10) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` text NOT NULL,
  `verified_at` datetime DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `image_url` text DEFAULT NULL,
  `prodi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `nim`, `email`, `password`, `verified_at`, `nama`, `image_url`, `prodi`) VALUES
(3, '21.01.4703', 'irvanhakim@students.amikom.ac.id', '$2y$10$zQBUjpmcKRIAc0remXhp2OIOJ/y7tJLvPSn4DaNYgqCkqcjqbLYoe', '2023-04-30 13:56:47', 'Irvan Hakim', '1682783472_0a4c341d2b921f7d357d.jpg', 'D3 TI'),
(6, '21.01.4709', 'kirisaki@mail.com', '$2y$10$bqxXmWejpGxav4o.xy71vOLiFoygNgbdLPdaVQDr0uxAqpAWsRrDW', NULL, 'Kirisaki Rem', '1682784934_b05f42c39db065ba92b2.jpg', 'Teknologi Roket');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) NOT NULL,
  `plat` varchar(13) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nim` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `plat`, `nama`, `nim`) VALUES
(6, 'AB 1988 CC', 'Honda Astrea Star 1999', '21.01.4703');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `exits_aproved`
--
ALTER TABLE `exits_aproved`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exit_aproved_on_out_of_parking` (`id_out_of_parking`),
  ADD KEY `exit_aproved_on_guard` (`id_guard`);

--
-- Indexes for table `guards`
--
ALTER TABLE `guards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nip`),
  ADD UNIQUE KEY `email` (`email`) USING BTREE;

--
-- Indexes for table `out_of_parkings`
--
ALTER TABLE `out_of_parkings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `out_of_parkings_on_vehicles` (`id_vehicle`);

--
-- Indexes for table `reset_passwords`
--
ALTER TABLE `reset_passwords`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicles_on_student` (`nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `exits_aproved`
--
ALTER TABLE `exits_aproved`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `guards`
--
ALTER TABLE `guards`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `out_of_parkings`
--
ALTER TABLE `out_of_parkings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reset_passwords`
--
ALTER TABLE `reset_passwords`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exits_aproved`
--
ALTER TABLE `exits_aproved`
  ADD CONSTRAINT `exit_aproved_on_guard` FOREIGN KEY (`id_guard`) REFERENCES `guards` (`id`),
  ADD CONSTRAINT `exit_aproved_on_out_of_parking` FOREIGN KEY (`id_out_of_parking`) REFERENCES `out_of_parkings` (`id`);

--
-- Constraints for table `out_of_parkings`
--
ALTER TABLE `out_of_parkings`
  ADD CONSTRAINT `out_of_parkings_on_vehicles` FOREIGN KEY (`id_vehicle`) REFERENCES `vehicles` (`id`);

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_on_student` FOREIGN KEY (`nim`) REFERENCES `students` (`nim`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
