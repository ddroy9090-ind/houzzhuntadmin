-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2025 at 11:26 AM
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
-- Database: `channel_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sub_heading` varchar(255) DEFAULT NULL,
  `brochure` varchar(255) DEFAULT NULL,
  `project_heading` varchar(255) DEFAULT NULL,
  `project_details` text DEFAULT NULL,
  `starting_price` decimal(15,2) DEFAULT NULL,
  `payment_plan` varchar(255) DEFAULT NULL,
  `handover` date DEFAULT NULL,
  `main_picture` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `image4` varchar(255) DEFAULT NULL,
  `gallery_images` text DEFAULT NULL,
  `amenities` text DEFAULT NULL,
  `floor_plan` varchar(255) DEFAULT NULL,
  `aed_per_sqft` varchar(50) DEFAULT NULL,
  `starting_area` varchar(50) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `extra_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `burj_al_arab` varchar(255) DEFAULT NULL,
  `dubai_marina` varchar(255) DEFAULT NULL,
  `dubai_mall` varchar(255) DEFAULT NULL,
  `sheikh_zayed` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `project_name`, `description`, `sub_heading`, `brochure`, `project_heading`, `project_details`, `starting_price`, `payment_plan`, `handover`, `main_picture`, `image2`, `image3`, `image4`, `gallery_images`, `amenities`, `floor_plan`, `aed_per_sqft`, `starting_area`, `location`, `extra_text`, `created_at`, `burj_al_arab`, `dubai_marina`, `dubai_mall`, `sheikh_zayed`) VALUES
(4, 'BINGHATTI SKYHALL', 'Discover a vibrant community where nature, adventure, and wellness come together in perfect harmony. Thoughtfully designed clusters of contemporary apartments, townhouses, and villas invite you to embrace a lifestyle inspired by water, sports, and leisure. Whether you seek outdoor excitement or peaceful retreats, this family-friendly haven offers endless opportunities to live, laugh, and dream.Discover a vibrant community where nature, adventure, and wellness come together in perfect harmony. Thoughtfully designed clusters of contemporary apartments, townhouses, and villas invite you to embrace a lifestyle inspired by water, sports, and leisure. Whether you seek outdoor excitement or peaceful retreats, this family-friendly haven offers endless opportunities to live, laugh, and dream.', 'Studio & 1 Bedroom Apartments in Business Bay', '1755940756_Screenshot 2025-08-13 132544.png', 'Damac Hills 2: Three Towns. One Community. Infinite Possibilities.', 'Discover a vibrant community where nature, adventure, and wellness come together in perfect harmony. Thoughtfully designed clusters of contemporary apartments, townhouses, and villas invite you to embrace a lifestyle inspired by water, sports, and leisure. Whether you seek outdoor excitement or peaceful retreats, this family-friendly haven offers endless opportunities to live, laugh, and dream.Discover a vibrant community where nature, adventure, and wellness come together in perfect harmony. Thoughtfully designed clusters of contemporary apartments, townhouses, and villas invite you to embrace a lifestyle inspired by water, sports, and leisure. Whether you seek outdoor excitement or peaceful retreats, this family-friendly haven offers endless opportunities to live, laugh, and dream.', 9555.00, '60/40 – Pay 60% during construction, 40% on handover', '2025-08-23', '1755940756_main-image.webp', '1755940756_image3.webp', '1755940756_image2.webp', '1755940756_Screenshot 2025-08-13 130700.png', '1755940756_image3.webp,1755940756_image2.webp,1755940756_Screenshot 2025-08-13 130700.png', 'Central Clubhouses And Fitness Facilities, Lagoon And Natural Waterways, 33 Km Cycling Trail And 7.1 Km Promenade, Community Mall And Coastal Retail, Wellness Centre And Spa, Business Park And Sports Complex', '1755940756_Screenshot 2025-08-13 132544.png', '1221312', '720 sqft', 'Gurgaon', 'Rehman Shoaib', '2025-08-23 09:19:16', '30', '40', '50', '60'),
(5, 'Palm Vista Residences', 'Discover a vibrant community where nature, adventure, and wellness come together in perfect harmony. Thoughtfully designed clusters of contemporary apartments, townhouses, and villas invite you to embrace a lifestyle inspired by water, sports, and leisure. Whether you seek outdoor excitement or peaceful retreats, this family-friendly haven offers endless opportunities to live, laugh, and dream.', 'Studio & 1 Bedroom Apartments in Business Bay', '1755940925_Screenshot 2025-08-13 133514.png', 'Damac Hills 2: Three Towns. One Community. Infinite Possibilities.', 'Discover a vibrant community where nature, adventure, and wellness come together in perfect harmony. Thoughtfully designed clusters of contemporary apartments, townhouses, and villas invite you to embrace a lifestyle inspired by water, sports, and leisure. Whether you seek outdoor excitement or peaceful retreats, this family-friendly haven offers endless opportunities to live, laugh, and dream.Discover a vibrant community where nature, adventure, and wellness come together in perfect harmony. Thoughtfully designed clusters of contemporary apartments, townhouses, and villas invite you to embrace a lifestyle inspired by water, sports, and leisure. Whether you seek outdoor excitement or peaceful retreats, this family-friendly haven offers endless opportunities to live, laugh, and dream.', 55555.00, '55 MILLION SQ.FT', '2025-08-23', '1755940925_Screenshot 2025-08-13 130700.png', '1755940925_Screenshot 2025-08-13 130642.png', '1755940925_Screenshot 2025-08-13 130651.png', '1755940925_Screenshot 2025-08-13 130721.png', '1755940925_Screenshot 2025-08-13 130642.png,1755940925_Screenshot 2025-08-13 130651.png,1755940925_Screenshot 2025-08-13 130721.png', 'Central Clubhouses And Fitness Facilities, Lagoon And Natural Waterways, 33 Km Cycling Trail And 7.1 Km Promenade, Community Mall And Coastal Retail, Wellness Centre And Spa, Business Park And Sports Complex', '1755940925_Screenshot 2025-08-13 130805.png', '1221312', '720 sqft', 'Delhi', 'nthdg', '2025-08-23 09:22:05', '10', '20', '30', '40');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `message` text,
  `avatar` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leads`
--

-- No sample leads --

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Manager','Channel Partner') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_active` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `created_at`, `last_active`) VALUES
(1, 'Rehman Shaoib', 'rehmanshoaib', 'shoaib@reliantsurveyors.com', '$2y$10$0zpNlMd46dES26IFRynwXebMeIdUO3JXCy.R96yPIJ9yqGP16tbkq', 'Admin', '2025-08-18 06:44:43', NULL),
(2, 'Dev Aabhroy', 'dev', 'dev@gmail.com', '$2y$10$5/Qxeccnas51So70xhHhGOHq1e6CoBfhThb..kEI2W4c9B45Y9IOa', 'Admin', '2025-08-22 05:14:43', NULL),
(3, 'Shoaib Akhtar', 'shoaibakhtar', 'shoaib@gmail.com', '$2y$10$FKoW7BU6sBHsQ6I5B3MVtuCZKp4z/ODfgcsmnhfnbgroOqNGTmdgC', 'Admin', '2025-08-22 10:09:35', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
 
--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
