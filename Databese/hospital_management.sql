-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 10:04 AM
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
-- Database: `hospital_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `symptoms` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `appointment_date`, `appointment_time`, `symptoms`, `status`, `notes`, `created_at`) VALUES
(1, 2, 5, '2025-05-28', '16:30:00', 'cough', 'pending', NULL, '2025-05-25 07:52:18');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `content`, `author`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Top 10 Health Tips for Better Living', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Dr. Admin', NULL, '2025-05-24 17:40:07', '2025-05-24 17:40:07'),
(2, 'Importance of Regular Health Checkups', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Dr. Smith', NULL, '2025-05-24 17:40:07', '2025-05-24 17:40:07'),
(3, 'Mental Health Awareness in Modern Times', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt.', 'Dr. Emily', NULL, '2025-05-24 17:40:07', '2025-05-24 17:40:07'),
(4, 'Nutrition and Healthy Lifestyle', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident.', 'Dr. Michael', NULL, '2025-05-24 17:40:07', '2025-05-24 17:40:07');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read','replied') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'prime', '22103372@iubat.edu', 'cough and fever', 'suffering from cough and fever', 'unread', '2025-05-24 17:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `head_doctor` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `head_doctor`, `created_at`) VALUES
(1, 'Cardiology', 'Heart and cardiovascular diseases treatment', 'Dr. Smith Johnson', '2025-05-24 17:40:07'),
(2, 'Neurology', 'Brain and nervous system disorders', 'Dr. Emily Brown', '2025-05-24 17:40:07'),
(3, 'Pediatrics', 'Child healthcare and treatment', 'Dr. Michael Davis', '2025-05-24 17:40:07'),
(4, 'Orthopedics', 'Bone and joint related treatments', 'Dr. Sarah Wilson', '2025-05-24 17:40:07'),
(5, 'Dermatology', 'Skin and hair related treatments', 'Dr. Jessica Alam', '2025-05-24 17:40:07'),
(6, 'Ophthalmology', 'Eye care and vision treatment', 'Dr. Prime Biswajit', '2025-05-24 17:40:07'),
(7, 'General Surgery', 'Surgical procedures and operations', 'Dr. Prity Ahosan', '2025-05-24 17:40:07'),
(8, 'Emergency Medicine', 'Emergency and critical care', 'Dr. Nabinur Islam', '2025-05-24 17:40:07');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `qualification` varchar(200) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `schedule` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialization`, `qualification`, `department_id`, `phone`, `email`, `schedule`, `image`, `created_at`) VALUES
(1, 'Dr. Md. Abu Zisan Provat', 'Child care', 'Consultant', 1, '+8801765489641', 'provat@unity.com', NULL, NULL, '2025-05-24 17:40:07'),
(2, 'Dr. Zehad Hasan', 'Neurology', 'MBBS', 2, '+8801765489642', 'zehad@unity.com', NULL, NULL, '2025-05-24 17:40:07'),
(3, 'Dr. Prity Ahosan', 'General Surgery', 'MBBS, MS, DNB', 7, '+8801765489643', 'prity@unity.com', NULL, NULL, '2025-05-24 17:40:07'),
(4, 'Dr. Nabinur Islam Rony', 'Health Checkup', 'MBBS', 8, '+8801765489644', 'rony@unity.com', NULL, NULL, '2025-05-24 17:40:07'),
(5, 'Dr. Jessica Alam Jui', 'Dermatology', 'MD', 5, '+8801765489645', 'jessica@unity.com', NULL, NULL, '2025-05-24 17:40:07'),
(6, 'Dr. Prime Biswajit Barua', 'Eye Specialist', 'MBBS, MS, MD', 6, '+8801765489646', 'prime@unity.com', NULL, NULL, '2025-05-24 17:40:07'),
(7, 'Dr. Samsun Nahar Borsha', 'CCU & ICU', 'MBBS', 8, '+8801765489647', 'borsha@unity.com', NULL, NULL, '2025-05-24 17:40:07'),
(8, 'Dr. Ashraful Islam Ropin', 'Health Checkup', 'MBBS', 8, '+8801765489648', 'ropin@unity.com', NULL, NULL, '2025-05-24 17:40:07');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `title`, `description`, `image_path`, `created_at`) VALUES
(1, 'Hospital Building', 'Main hospital building exterior view', 'assets/img/gallery/hospital.jpg', '2025-05-24 17:40:07'),
(2, 'OPD Area', 'Outpatient department waiting area', 'assets/img/gallery/opd.jpg', '2025-05-24 17:40:07'),
(3, 'Patient Rooms', 'Comfortable patient accommodation', 'assets/img/gallery/room1.jpg', '2025-05-24 17:40:07'),
(4, 'Reception Area', 'Hospital main reception desk', 'assets/img/gallery/reception.jpg', '2025-05-24 17:40:07'),
(5, 'Parking Facility', 'Hospital parking area', 'assets/img/gallery/parking.jpg', '2025-05-24 17:40:07'),
(6, 'Platinum Wing', 'Premium healthcare facilities', 'assets/img/gallery/platinum_wing.jpg', '2025-05-24 17:40:07'),
(7, 'Catheterization Lab', 'Advanced cardiac procedures lab', 'assets/img/gallery/cath_lab.jpg', '2025-05-24 17:40:07'),
(8, 'OPD Area 2', 'Additional outpatient facilities', 'assets/img/gallery/opd2.jpg', '2025-05-24 17:40:07');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('credit_card','debit_card','cash','insurance') NOT NULL,
  `card_number` varchar(20) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `user_type` enum('patient','admin') DEFAULT 'patient',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `address`, `date_of_birth`, `gender`, `user_type`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'User', 'admin@unityhospital.com', '$2y$10$3W8.TVb5yrKShqh3bSssbud2m5zxtXgcgfORmScZv37ctmCQiFQYy', NULL, NULL, NULL, NULL, 'admin', '2025-05-24 17:40:07', '2025-05-24 17:40:07'),
(2, 'prime', 'barua', '22103372@iubat.edu', '$2y$10$FBrKX49dSyDEHgf7PMr56uQnTuYhadhw/27s4N/8AF4Mx7k9A8GQC', '01754296870', 'dhaka', '2022-05-24', 'Male', 'patient', '2025-05-24 17:45:30', '2025-05-24 17:45:30'),
(3, 'Zisan', 'Provat', 'provat@gmail.com', '$2y$10$qPyZfFwSG5.lkmPfaoc6Pu8X6gNCZntFZJuNwQ9SX047.M8B7jRz2', '01729446041', 'Dhaka', '2001-12-14', 'Male', 'patient', '2025-05-25 07:26:02', '2025-05-25 07:26:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
