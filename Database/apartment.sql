-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2024 at 07:07 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apartment`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `flat_id` int(11) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `booking_date` datetime NOT NULL DEFAULT current_timestamp(),
  `booking_type` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `user_id`, `building_id`, `flat_id`, `hall_id`, `from_date`, `to_date`, `booking_date`, `booking_type`) VALUES
(1, 2, 1, 1, 0, '2024-06-08', '2024-06-10', '2024-05-30 22:26:13', 'Flat'),
(2, 2, 1, 0, 1, '2024-06-01', '2024-06-02', '2024-05-30 22:26:32', 'Hall');

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(45) NOT NULL,
  `builder_name` varchar(50) NOT NULL,
  `contact` varchar(25) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`id`, `name`, `date`, `status`, `builder_name`, `contact`, `address`) VALUES
(1, 'Lakeside Manor', '2024-05-30 19:36:06', 'Active', 'Johnson And Sons Builders', '8527419634', '456 Lakeview Drive, Smalltown, USA'),
(2, 'Green Valley', '2024-05-30 19:36:51', 'Active', 'Smith Construction Company', '7418529635', '23 Main Street, Anytown, USA');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(45) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `createddate` datetime NOT NULL DEFAULT current_timestamp(),
  `image` varchar(100) NOT NULL,
  `status` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `createddate`, `image`, `status`) VALUES
(1, 'Weddings', 'A wedding is a ceremony where two people are united in marriage', '2024-05-30 22:10:22', 'events/pexels-jdgromov-4717526.jpg', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `facility` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`id`, `building_id`, `facility`, `description`, `date`, `status`) VALUES
(1, 2, 'excellent cross ventilation', 'an opening on the opposite side of the building', '2024-05-30 19:42:58', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `flat`
--

CREATE TABLE `flat` (
  `id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `flat_number` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(25) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flat`
--

INSERT INTO `flat` (`id`, `building_id`, `flat_number`, `description`, `status`, `date`, `image`) VALUES
(1, 1, 'FLAT101', 'he countryside in that region is very flat', 'Owned', '2024-05-30 18:47:42', '1717087662.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `hall`
--

CREATE TABLE `hall` (
  `id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `hall_name` varchar(50) NOT NULL,
  `capacity` varchar(25) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `image` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hall`
--

INSERT INTO `hall` (`id`, `building_id`, `hall_name`, `capacity`, `description`, `status`, `image`, `date`) VALUES
(1, 1, 'Middle Ages', '250', 'A large Outdoor  Room for public gatherings', 'Owned', '1717087820.jpg', '2024-05-30 18:50:20');

-- --------------------------------------------------------

--
-- Table structure for table `rent`
--

CREATE TABLE `rent` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `month` varchar(10) NOT NULL,
  `year` int(10) NOT NULL,
  `amount` int(25) NOT NULL,
  `status` varchar(45) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_number` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rent`
--

INSERT INTO `rent` (`id`, `user_id`, `month`, `year`, `amount`, `status`, `date`, `payment_number`) VALUES
(1, 2, 'June', 2024, 5000, 'Active', '2024-05-30 22:29:40', 'PAY81367');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(45) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `contact`, `password`, `created_date`, `status`, `type`) VALUES
(1, 'Rachitha', 'rachitha@gmail.com', '8527419634', '123', '2024-05-30 22:05:05', 'Active', 'Manager'),
(2, 'kushi', 'kushi@gmail.com', '8529637415', '123', '2024-05-30 22:12:29', 'Active', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `bulding_id` int(11) NOT NULL,
  `visitor_name` varchar(50) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `purpose` text NOT NULL,
  `vehicle_number` varchar(50) NOT NULL,
  `time_in` varchar(100) NOT NULL DEFAULT current_timestamp(),
  `image` varchar(150) NOT NULL,
  `status` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `bulding_id`, `visitor_name`, `phone`, `purpose`, `vehicle_number`, `time_in`, `image`, `status`) VALUES
(1, 1, 'Spandana', '8529637415', 'Meeting', 'KA 19 7777', '10:14', '1717087481.jpg', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flat`
--
ALTER TABLE `flat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hall`
--
ALTER TABLE `hall`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rent`
--
ALTER TABLE `rent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facility`
--
ALTER TABLE `facility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `flat`
--
ALTER TABLE `flat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hall`
--
ALTER TABLE `hall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rent`
--
ALTER TABLE `rent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
