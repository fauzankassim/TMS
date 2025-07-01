-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2025 at 07:47 PM
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
-- Database: `testtms`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodation`
--

CREATE TABLE `accommodation` (
  `accommodationID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodation`
--

INSERT INTO `accommodation` (`accommodationID`, `name`, `price`) VALUES
(1, 'Shangri-La’s Rasa Ria Resort & Spa', 250),
(2, 'The Pacific Sutera Hotel', 180),
(3, 'Grandis Hotels and Resorts', 130),
(4, 'Le Meridien Kota Kinabalu', 220),
(5, 'Bunga Raya Island Resort & Spa', 300),
(6, 'Gaya Island Resort', 270);

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activityID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activityID`, `name`, `description`, `price`) VALUES
(1, 'Snorkeling Adventure', 'Explore vibrant coral reefs in Semporna.', 150),
(2, 'Mount Kinabalu Hiking', 'A guided climb up Mount Kinabalu.', 250),
(3, 'Island Hopping Tour', 'Visit beautiful islands near Semporna.', 200),
(4, 'Kundasang Dairy Farm Visit', 'Tour the famous farm with stunning views.', 50),
(5, 'Scuba Diving Experience', 'Dive into the waters of Semporna.', 400),
(6, 'Desa Cattle Farm Tour', 'Experience the \"New Zealand\" of Kundasang.', 80),
(7, 'Sunset Cruise', 'Relax on a sunset cruise in Semporna.', 180),
(8, 'Kundasang Nature Walk', 'Discover Kundasang\'s serene trails and flora.', 70),
(9, 'Traditional Bajau Laut Tour', 'Learn about the culture of Bajau Laut people.', 120),
(10, 'Hot Springs & Rafflesia', 'Explore Poring Hot Springs and rare flowers.', 100);

-- --------------------------------------------------------

--
-- Table structure for table `activity_list`
--

CREATE TABLE `activity_list` (
  `activityListID` int(11) NOT NULL,
  `packageID` int(11) NOT NULL,
  `activityID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_list`
--

INSERT INTO `activity_list` (`activityListID`, `packageID`, `activityID`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 1, 7),
(4, 2, 2),
(5, 2, 4),
(6, 2, 8),
(7, 3, 5),
(8, 3, 9),
(9, 3, 7),
(10, 4, 6),
(11, 4, 10),
(12, 4, 8),
(13, 5, 1),
(14, 5, 3),
(15, 5, 2),
(16, 5, 4),
(17, 5, 5),
(18, 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blogID` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blogID`, `image`, `title`, `description`) VALUES
(1, 'uploads/Monkey.webp', 'Best of Borneo: Sabah, Malaysia', 'Malaysia is one of the world’s 17 “megadiverse” countries, with Borneo being their crown jewel of biodiversity! The world’s third largest island, fringed by a coral reef, covered with a 130-million-year-old rainforest, and teeming with endemic species, th'),
(2, 'uploads/Orang.jpg', 'Sepilok, Northeast Sabah', 'Just outside of the big city of Sandakan, the Sepilok area is worth staying the night for this educational trifecta');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingID` int(11) NOT NULL,
  `packageID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `pax` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `bookedDate` date NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingID`, `packageID`, `userID`, `pax`, `cost`, `bookedDate`, `createdDate`) VALUES
(3, 1, 1, 2, 2476, '2025-01-25', '2025-01-23 09:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `guide`
--

CREATE TABLE `guide` (
  `guideID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guide`
--

INSERT INTO `guide` (`guideID`, `name`, `price`) VALUES
(1, 'John Lim', 150),
(2, 'Aisha Malik', 200),
(3, 'Farid Jamil', 180),
(4, 'Nina Wong', 120),
(5, 'Michael Tan', 250),
(6, 'Roslina Ahmad', 100),
(7, 'Henry Chong', 220),
(8, 'Sophia Lee', 130);

-- --------------------------------------------------------

--
-- Table structure for table `inquiry`
--

CREATE TABLE `inquiry` (
  `inquiryID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `hasAnswer` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiry`
--

INSERT INTO `inquiry` (`inquiryID`, `userID`, `question`, `answer`, `hasAnswer`) VALUES
(1, 1, 'sup', 'haha', 2),
(2, 1, 'What is the best travel package for someone who likes to go diving?', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `meal`
--

CREATE TABLE `meal` (
  `mealID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meal`
--

INSERT INTO `meal` (`mealID`, `name`, `price`) VALUES
(1, 'Breakfast Set', 8),
(2, 'Lunch Set', 12),
(3, 'Dinner Set', 15);

-- --------------------------------------------------------

--
-- Table structure for table `meal_list`
--

CREATE TABLE `meal_list` (
  `meal_listID` int(11) NOT NULL,
  `mealID` int(11) NOT NULL,
  `packageID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meal_list`
--

INSERT INTO `meal_list` (`meal_listID`, `mealID`, `packageID`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `packageID` int(11) NOT NULL,
  `guideID` int(11) NOT NULL,
  `transportationID` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `minPax` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `accommodationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`packageID`, `guideID`, `transportationID`, `duration`, `image`, `description`, `minPax`, `title`, `accommodationID`) VALUES
(1, 1, 1, 1, 'uploads/sempona_package1.jpg', 'Explore the best of Semporna with snorkeling and island hopping.', 2, 'Semporna Water Adventure', 5),
(2, 2, 2, 2, 'uploads/kundasang_package1.jpg', 'Experience Kundasang with hiking, nature walks, and farm tours.', 3, 'Kundasang Nature Escape', 6),
(3, 3, 3, 1, 'uploads/sempona_package2.jpg', 'A deep dive into Semporna with scuba diving and cultural tours.', 4, 'Semporna Diving and Culture', 4),
(4, 4, 4, 1, 'uploads/kundasang_package2.jpg', 'Relax and enjoy family-friendly activities in Kundasang.', 2, 'Kundasang Family Retreat', 3),
(5, 5, 5, 3, 'uploads/combo_package.jpg', 'A combined adventure package for both Semporna and Kundasang.', 4, 'Sabah Ultimate Adventure', 5);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `bookingID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`reviewID`, `title`, `description`, `rating`, `bookingID`) VALUES
(2, 'Test Review', 'Very Good', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `transportation`
--

CREATE TABLE `transportation` (
  `transportationID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transportation`
--

INSERT INTO `transportation` (`transportationID`, `name`, `price`) VALUES
(1, 'Van (10-seater)', 300),
(2, 'Bus (30-seater)', 800),
(3, '4WD Vehicle', 500),
(4, 'Boat Charter', 600),
(5, 'Private Sedan', 200),
(6, 'Motorbike Rental', 100),
(7, 'Helicopter Ride', 3000),
(8, 'Bicycle Rental', 50);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` tinyint(4) DEFAULT 0,
  `createdOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `name`, `email`, `password`, `role`, `createdOn`, `updatedOn`) VALUES
(1, 'John Doe', 'john.doe@example.com', 'test', 0, '2025-01-21 16:04:53', '2025-01-21 16:04:53'),
(2, 'Alice Smith', 'alice.smith@example.com', 'test', 0, '2025-01-21 16:04:53', '2025-01-21 16:04:53'),
(3, 'Bob Johnson', 'bob.johnson@example.com', 'test', 0, '2025-01-21 16:04:53', '2025-01-21 16:04:53'),
(4, '', '', '$2y$10$vStLywYNljFvaZ1OVFnqj.zlkcYrk9IuKc4QValQjXdfdolAiESLy', NULL, '2025-01-23 17:14:25', '2025-01-23 17:14:25'),
(5, 'test', 'test@gmail.com', '$2y$10$4vjGzgNoly.lTvQrbCR6SuD3Fwj0pCXkbhcY8B.OLdgH/ak1Iz7Gi', 1, '2025-01-23 17:22:17', '2025-01-23 17:23:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodation`
--
ALTER TABLE `accommodation`
  ADD PRIMARY KEY (`accommodationID`);

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activityID`);

--
-- Indexes for table `activity_list`
--
ALTER TABLE `activity_list`
  ADD PRIMARY KEY (`activityListID`),
  ADD KEY `packageID` (`packageID`),
  ADD KEY `activityID` (`activityID`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blogID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `packageID` (`packageID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `guide`
--
ALTER TABLE `guide`
  ADD PRIMARY KEY (`guideID`);

--
-- Indexes for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`inquiryID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `meal`
--
ALTER TABLE `meal`
  ADD PRIMARY KEY (`mealID`);

--
-- Indexes for table `meal_list`
--
ALTER TABLE `meal_list`
  ADD PRIMARY KEY (`meal_listID`),
  ADD KEY `mealID` (`mealID`),
  ADD KEY `packageID` (`packageID`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`packageID`),
  ADD KEY `guideID` (`guideID`),
  ADD KEY `transportationID` (`transportationID`),
  ADD KEY `accommodationID` (`accommodationID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reviewID`),
  ADD KEY `review_ibfk_1` (`bookingID`);

--
-- Indexes for table `transportation`
--
ALTER TABLE `transportation`
  ADD PRIMARY KEY (`transportationID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accommodation`
--
ALTER TABLE `accommodation`
  MODIFY `accommodationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `activity_list`
--
ALTER TABLE `activity_list`
  MODIFY `activityListID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `guide`
--
ALTER TABLE `guide`
  MODIFY `guideID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `inquiryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `meal`
--
ALTER TABLE `meal`
  MODIFY `mealID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `meal_list`
--
ALTER TABLE `meal_list`
  MODIFY `meal_listID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `packageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transportation`
--
ALTER TABLE `transportation`
  MODIFY `transportationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_list`
--
ALTER TABLE `activity_list`
  ADD CONSTRAINT `activity_list_ibfk_1` FOREIGN KEY (`packageID`) REFERENCES `package` (`packageID`),
  ADD CONSTRAINT `activity_list_ibfk_2` FOREIGN KEY (`activityID`) REFERENCES `activity` (`activityID`);

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`packageID`) REFERENCES `package` (`packageID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD CONSTRAINT `inquiry_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `meal_list`
--
ALTER TABLE `meal_list`
  ADD CONSTRAINT `meal_list_ibfk_1` FOREIGN KEY (`mealID`) REFERENCES `meal` (`mealID`),
  ADD CONSTRAINT `meal_list_ibfk_2` FOREIGN KEY (`packageID`) REFERENCES `package` (`packageID`);

--
-- Constraints for table `package`
--
ALTER TABLE `package`
  ADD CONSTRAINT `package_ibfk_2` FOREIGN KEY (`guideID`) REFERENCES `guide` (`guideID`),
  ADD CONSTRAINT `package_ibfk_4` FOREIGN KEY (`transportationID`) REFERENCES `transportation` (`transportationID`),
  ADD CONSTRAINT `package_ibfk_5` FOREIGN KEY (`accommodationID`) REFERENCES `accommodation` (`accommodationID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
