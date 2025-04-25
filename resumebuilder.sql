-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2025 at 08:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resumebuilder`
--

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

CREATE TABLE `educations` (
  `id` int(11) NOT NULL,
  `resume_id` int(11) NOT NULL,
  `course` varchar(250) NOT NULL,
  `institute` varchar(250) NOT NULL,
  `started` varchar(100) NOT NULL,
  `ended` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`id`, `resume_id`, `course`, `institute`, `started`, `ended`) VALUES
(2, 1, 'completed my graduction in bsc cs', 'M.J Collage Jalgaon', 'June 2025', 'June 2025');

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` int(11) NOT NULL,
  `resume_id` int(11) NOT NULL,
  `position` varchar(250) NOT NULL,
  `company` varchar(250) NOT NULL,
  `job_desc` text NOT NULL,
  `started` varchar(250) NOT NULL,
  `ended` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resumes`
--

CREATE TABLE `resumes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `email_id` varchar(250) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `marital_status` varchar(50) NOT NULL,
  `hobbies` varchar(250) NOT NULL,
  `languages` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `objective` text NOT NULL,
  `slug` varchar(250) NOT NULL,
  `updated_at` int(20) NOT NULL,
  `resume_title` varchar(250) NOT NULL,
  `background` varchar(250) NOT NULL DEFAULT '''''',
  `font` varchar(250) NOT NULL DEFAULT '''Poppins'', sans-serif',
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resumes`
--

INSERT INTO `resumes` (`id`, `user_id`, `full_name`, `email_id`, `mobile_no`, `dob`, `gender`, `religion`, `nationality`, `marital_status`, `hobbies`, `languages`, `address`, `objective`, `slug`, `updated_at`, `resume_title`, `background`, `font`, `photo`) VALUES
(1, 1, 'Pranav Nandkishor Bhavsar', 'Pranavnbhavsar1920@gmail.com', '07666689644', '2003-06-14', 'Male', 'Hindu', 'Indian', 'Married', 'reading book', 'hindi', 'Plot No 36 Block No 3 Kanalada Road K.C Park Shivaji Nagar', 'sfsf', 'k1f4s3606bya57n_', 1739730638, 'PHP', '\'\'', '\'Poppins\', sans-serif', '../uploads/IMG-20240130-WA0007.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `resume_id` int(11) NOT NULL,
  `skill` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `resume_id`, `skill`) VALUES
(2, 1, 'i have great knowlage in cpp,java and python i have good knowlage aboud dbms and sql sever i can handel cloud computing as well ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `email_id` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email_id`, `password`) VALUES
(1, 'Pranav Nandkishor Bhavsar', 'Pranavnbhavsar1920@gmail.com', '202cb962ac59075b964b07152d234b70');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `educations`
--
ALTER TABLE `educations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resumes`
--
ALTER TABLE `resumes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_id` (`email_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `educations`
--
ALTER TABLE `educations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resumes`
--
ALTER TABLE `resumes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
