-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 23, 2024 at 09:27 AM
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
-- Database: `project1_main`
CREATE DATABASE project1_main;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `profile` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `profile`) VALUES
(1, 'august', '$2y$10$dCkaRy2iVcIxWnqVUyDEQ.E5.Bdf9pSCYUjp3sthMuu79KprBTR8S', 'admin.jpg'),
(25, 'admin', '$2y$10$YjXfwDB7OhvkHMvrLLqOVur4gBnug3B23yJCx8CZH66oP/tFO5Szy', '67668a391be7a.png'),
(26, 'admin', '$2y$10$wK3TvaoWlZ7oyHOvKya69uVdVXkKk/k4gRXdGXwNDVBYSwS49o.qq', '67691a5ddc7dd.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `appointment_date` varchar(100) NOT NULL,
  `symptoms` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `date_booked` varchar(100) NOT NULL,
  `doctor_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `firstname`, `surname`, `gender`, `phone`, `appointment_date`, `symptoms`, `status`, `date_booked`, `doctor_id`) VALUES
(1, 'Ali', 'Khan', 'Male', '1234567891', '2024-12-31', 'Tai nạn xe', 'Approved', '2024-12-23 15:02:25', 'dr.tn'),
(2, 'Bảo Nam', 'Trần', 'Male', '0379899223', '2024-12-31', 'Đau đầu, chóng mặt', 'Pending', '2024-12-23 15:08:48', '');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_limits`
--

CREATE TABLE `appointment_limits` (
  `id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `limit_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_limits`
--

INSERT INTO `appointment_limits` (`id`, `appointment_date`, `limit_count`) VALUES
(1, '2025-01-01', 30),
(2, '2025-01-02', 30),
(3, '2025-01-03', 30),
(4, '2025-01-04', 30),
(5, '2025-01-05', 30),
(6, '2025-01-06', 30),
(7, '2025-01-07', 30),
(8, '2025-01-08', 30),
(9, '2025-01-09', 30),
(10, '2025-01-10', 30),
(11, '2025-01-11', 30),
(12, '2025-01-12', 30),
(13, '2025-01-13', 30),
(14, '2025-01-14', 30),
(15, '2025-01-15', 30),
(16, '2025-01-16', 30),
(17, '2025-01-17', 30),
(18, '2025-01-18', 30),
(19, '2025-01-19', 30),
(20, '2025-01-20', 30),
(21, '2025-01-21', 30),
(22, '2025-01-22', 30),
(23, '2025-01-23', 30),
(24, '2025-01-24', 30),
(25, '2025-01-25', 30),
(26, '2025-01-26', 30),
(27, '2025-01-27', 30),
(28, '2025-01-28', 30),
(29, '2025-01-29', 30),
(30, '2025-01-30', 30),
(31, '2025-01-31', 30),
(32, '2025-02-01', 40),
(33, '2025-02-02', 40),
(34, '2025-02-03', 40),
(35, '2025-02-04', 40),
(36, '2025-02-05', 40),
(37, '2025-02-06', 40),
(38, '2025-02-07', 40),
(39, '2025-02-08', 40),
(40, '2025-02-09', 40),
(41, '2025-02-10', 40),
(42, '2025-02-11', 40),
(43, '2025-02-12', 40),
(44, '2025-02-13', 40),
(45, '2025-02-14', 40),
(46, '2025-02-15', 40),
(47, '2025-02-16', 40),
(48, '2025-02-17', 40),
(49, '2025-02-18', 40),
(50, '2025-02-19', 40),
(51, '2025-02-20', 40),
(52, '2025-02-21', 40),
(53, '2025-02-22', 40),
(54, '2025-02-23', 40),
(55, '2025-02-24', 40),
(56, '2025-02-25', 40),
(57, '2025-02-26', 40),
(58, '2025-02-27', 40),
(59, '2025-02-28', 40),
(60, '2024-12-01', 40),
(61, '2024-12-02', 40),
(62, '2024-12-03', 40),
(63, '2024-12-04', 40),
(64, '2024-12-05', 40),
(65, '2024-12-06', 40),
(66, '2024-12-07', 40),
(67, '2024-12-08', 40),
(68, '2024-12-09', 40),
(69, '2024-12-10', 40),
(70, '2024-12-11', 40),
(71, '2024-12-12', 40),
(72, '2024-12-13', 40),
(73, '2024-12-14', 40),
(74, '2024-12-15', 40),
(75, '2024-12-16', 40),
(76, '2024-12-17', 40),
(77, '2024-12-18', 40),
(78, '2024-12-19', 40),
(79, '2024-12-20', 40),
(80, '2024-12-21', 40),
(81, '2024-12-22', 40),
(82, '2024-12-23', 40),
(83, '2024-12-24', 40),
(84, '2024-12-25', 40),
(85, '2024-12-26', 40),
(86, '2024-12-27', 40),
(87, '2024-12-28', 40),
(88, '2024-12-29', 40),
(89, '2024-12-30', 40),
(90, '2024-12-31', 40);

-- --------------------------------------------------------

--
-- Table structure for table `benh`
--

CREATE TABLE `benh` (
  `id` int(11) NOT NULL,
  `loai_benh` varchar(255) NOT NULL,
  `trieu_chung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `benh`
--

INSERT INTO `benh` (`id`, `loai_benh`, `trieu_chung`) VALUES
(1, 'Cam cum', 'Hat hoi, so mui'),
(2, 'Cảm cúm', 'Sốt, đau họng, chảy nước mũi'),
(3, 'Đau dạ dày', 'Đau bụng, buồn nôn, khó tiêu'),
(4, 'Viêm phổi', 'Ho, sốt cao, khó thở'),
(5, 'Tiêu chảy', 'Đau bụng, phân lỏng, mất nước'),
(6, 'Dị ứng', 'Ngứa, phát ban, sưng phù'),
(7, 'Cảm cúm', 'Sốt, đau họng, chảy nước mũi'),
(8, 'Đau dạ dày', 'Đau bụng, buồn nôn, khó tiêu'),
(9, 'Viêm phổi', 'Ho, sốt cao, khó thở'),
(10, 'Tiêu chảy', 'Đau bụng, phân lỏng, mất nước'),
(11, 'Dị ứng', 'Ngứa, phát ban, sưng phù'),
(12, 'Tăng huyết áp', 'Đau đầu, chóng mặt, mệt mỏi'),
(13, 'Đái tháo đường', 'Khát nước, tiểu nhiều, mệt mỏi'),
(14, 'Viêm xoang', 'Đau đầu, nghẹt mũi, mất khứu giác'),
(15, 'Loãng xương', 'Đau lưng, gãy xương dễ dàng, giảm chiều cao'),
(16, 'Nhiễm trùng đường tiết niệu', 'Tiểu buốt, tiểu rắt, đau bụng dưới'),
(17, 'Chấn thương vùng đầu', 'Chảy máu vùng đầu do va đập');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `salary` varchar(100) NOT NULL,
  `data_reg` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `profile` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `firstname`, `surname`, `username`, `email`, `gender`, `phone`, `country`, `password`, `salary`, `data_reg`, `status`, `profile`) VALUES
(1, 'Văn Trọng', 'Trần', 'fff', '567@gmail.com', 'Nam', '0547238546', 'America', '$2y$10$SK5Zu4uY5o2nXTFa7czl2O71JxzR0FfvJf4LVlJm9EzlsvtI2bQ9y', '10000000', '2024-12-23 10:17:44', 'Approved', 'doctor.jpg'),
(2, 'Thị Mầu', 'Nguyễn', 'ddd', '234@gmail.com', 'Nữ', '0547238546', 'Viet nam', '$2y$10$pCUlAAmFPn5X5aXxTM1pNuNmSfE8Q4gXCn2ndrJkLbUHEeXaVIm9m', '2500000', '2024-12-23 10:21:21', 'Approved', 'doctor.jpg'),
(7, 'Trần', 'Nghĩa', 'dr.tn', 'ttnghia8a2308@gmail.com', 'Male', '0379099552', 'Viet nam', '$2y$10$j0so8MvL0QNRbjQI3SX.OezSnsOye5wrMJNuzqXRfnv7/Zmc5Gldq', '30000000', '2024-12-21 06:27:37', 'Approved', 'profile1.jpg'),
(8, 'Bảo Nam', 'Trần', 'drtbn', 'drtbn@gmail.com', 'Male', '0389199510', 'America', '$2y$10$2H.3b/LWdd7F.l0Wrwm27OCJUQ1jQgcwTvGmTHfHv3UpnO8ACNvZu', '1500000', '2024-12-23 09:53:14', 'Approved', 'doctor.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `id` int(100) NOT NULL,
  `doctor` varchar(100) NOT NULL,
  `patient` varchar(100) NOT NULL,
  `date_discharge` varchar(100) NOT NULL,
  `amount_paid` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_form`
--

CREATE TABLE `medical_form` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `exam_date` date NOT NULL,
  `symptoms` varchar(255) NOT NULL,
  `disease_id` int(11) NOT NULL,
  `total_price` decimal(11,0) DEFAULT 0,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_form`
--

INSERT INTO `medical_form` (`id`, `patient_id`, `exam_date`, `symptoms`, `disease_id`, `total_price`, `doctor_id`) VALUES
(1, 3, '2024-12-31', 'Chảy máu vùng đầu do va đập', 17, 435000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `id` int(11) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `exam_date` date NOT NULL,
  `symptoms` text NOT NULL,
  `disease` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_reg` varchar(100) NOT NULL,
  `profile` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `firstname`, `surname`, `username`, `email`, `phone`, `gender`, `country`, `password`, `date_reg`, `profile`) VALUES
(1, 'Bảo Nam', 'Trần', 'tbn', 'tbn@gmail.com', '0379899223', 'Male', 'America', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 14:56:11', 'patient.jpg'),
(2, 'John', 'Smith', 'johnsmith', 'john.smith@gmail.com', '1234567890', 'Male', 'America', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:00:00', 'patient.jpg'),
(3, 'Ali', 'Khan', 'alikhan', 'ali.khan@gmail.com', '1234567891', 'Male', 'Pakistan', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:01:00', 'patient.jpg'),
(4, '王', '伟', 'wangwei', 'wang.wei@gmail.com', '1234567892', 'Male', 'China', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:02:00', 'patient.jpg'),
(5, 'Nguyễn', 'Văn A', 'nguyenvana', 'nguyen.a@gmail.com', '1234567893', 'Male', 'Vietnam', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:03:00', 'patient.jpg'),
(6, 'Sakura', 'Tanaka', 'sakura.tanaka', 'sakura.tanaka@gmail.com', '1234567894', 'Female', 'Japan', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:04:00', 'patient.jpg'),
(7, 'Somchai', 'Wong', 'somchai.wong', 'somchai.wong@gmail.com', '1234567895', 'Male', 'Thailand', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:05:00', 'patient.jpg'),
(8, 'Oliver', 'Brown', 'oliver.brown', 'oliver.brown@gmail.com', '1234567896', 'Male', 'Australia', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:06:00', 'patient.jpg'),
(9, 'Marie', 'Dubois', 'marie.dubois', 'marie.dubois@gmail.com', '1234567897', 'Female', 'France', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:07:00', 'patient.jpg'),
(10, 'Hans', 'Müller', 'hans.muller', 'hans.muller@gmail.com', '1234567898', 'Male', 'Germany', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:08:00', 'patient.jpg'),
(11, 'Amit', 'Sharma', 'amit.sharma', 'amit.sharma@gmail.com', '1234567899', 'Male', 'India', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:09:00', 'patient.jpg'),
(12, 'Emma', 'Wilson', 'emma.wilson', 'emma.wilson@gmail.com', '1234567800', 'Female', 'Canada', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:10:00', 'patient.jpg'),
(13, 'Ji-hoon', 'Kim', 'jihoon.kim', 'jihoon.kim@gmail.com', '1234567801', 'Male', 'South Korea', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:11:00', 'patient.jpg'),
(14, 'William', 'Taylor', 'william.taylor', 'william.taylor@gmail.com', '1234567802', 'Male', 'United Kingdom', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:12:00', 'patient.jpg'),
(15, 'Giulia', 'Rossi', 'giulia.rossi', 'giulia.rossi@gmail.com', '1234567803', 'Female', 'Italy', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:13:00', 'patient.jpg'),
(16, 'Sofia', 'Martínez', 'sofia.martinez', 'sofia.martinez@gmail.com', '1234567804', 'Female', 'Spain', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:14:00', 'patient.jpg'),
(17, 'Ivan', 'Petrov', 'ivan.petrov', 'ivan.petrov@gmail.com', '1234567805', 'Male', 'Russia', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:15:00', 'patient.jpg'),
(18, 'Lucas', 'Silva', 'lucas.silva', 'lucas.silva@gmail.com', '1234567806', 'Male', 'Brazil', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:16:00', 'patient.jpg'),
(19, 'Valeria', 'Ramírez', 'valeria.ramirez', 'valeria.ramirez@gmail.com', '1234567807', 'Female', 'Mexico', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:17:00', 'patient.jpg'),
(20, 'Lerato', 'Mabuse', 'lerato.mabuse', 'lerato.mabuse@gmail.com', '1234567808', 'Female', 'South Africa', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:18:00', 'patient.jpg'),
(21, 'Mateo', 'Gómez', 'mateo.gomez', 'mateo.gomez@gmail.com', '1234567809', 'Male', 'Argentina', '$2y$10$HuArHPUbIKzRUF/z4VDBcu1lScYmKDSgR6EbK9u0z850OlBd2kjre', '2024-12-23 15:19:00', 'patient.jpg'),
(22, 'Vĩnh Hưng', 'Trần', 'tvh', 'tvh@gmail.com', '0389918391', 'Male', 'Vietnam', '$2y$10$gI9jMlCTwRrz0hxFeg.pbe8leL8C5Y0GL1qRVbWi52fpRbXO1Jj3G', '2024-12-23 15:19:21', 'patient.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `phieu_kham`
--

CREATE TABLE `phieu_kham` (
  `id` int(11) NOT NULL,
  `benh_id` int(11) NOT NULL,
  `ghi_chu` text DEFAULT NULL,
  `ngay_kham` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phieu_kham_thuoc`
--

CREATE TABLE `phieu_kham_thuoc` (
  `id` int(11) NOT NULL,
  `phieu_kham_id` int(11) NOT NULL,
  `thuoc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `medical_form_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `usage` varchar(255) NOT NULL,
  `unit` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `medical_form_id`, `medicine_id`, `quantity`, `usage`, `unit`) VALUES
(1, 1, 5, 3, 'Tiêm', 'Chai'),
(2, 1, 73, 3, 'Uống trước khi ăn', 'Viên'),
(3, 1, 19, 3, 'Uống sau khi ăn', 'Viên'),
(4, 1, 8, 3, 'Uống sau khi ăn', 'Chai');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `date_send` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `title`, `message`, `username`, `date_send`) VALUES
(1, 'Đặt lịch quá lâu', 'Tôi đặt lịch từ 31/10 đến giờ vẫn chưa được gửi thông báo đến khám.', 'tbn', '2024-12-23 15:09:28');

-- --------------------------------------------------------

--
-- Table structure for table `thuoc`
--

CREATE TABLE `thuoc` (
  `id` int(11) NOT NULL,
  `ten_thuoc` varchar(255) NOT NULL,
  `cach_su_dung` enum('Uống trước khi ăn','Uống sau khi ăn','Tiêm','Thoa') NOT NULL,
  `don_vi` enum('Viên','Chai') NOT NULL,
  `gia` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thuoc`
--

INSERT INTO `thuoc` (`id`, `ten_thuoc`, `cach_su_dung`, `don_vi`, `gia`) VALUES
(3, 'Vitamin C', 'Uống sau khi ăn', 'Viên', 15000.00),
(4, 'Cồn y tế', 'Thoa', 'Chai', 30000.00),
(5, 'Kháng sinh tiêm', 'Tiêm', 'Chai', 50000.00),
(6, 'Paracetamol', 'Uống sau khi ăn', 'Viên', 10000.00),
(7, 'Amoxicillin', 'Uống trước khi ăn', 'Viên', 20000.00),
(8, 'Vitamin C', 'Uống sau khi ăn', 'Chai', 15000.00),
(9, 'Cồn y tế', 'Thoa', 'Chai', 30000.00),
(10, 'Kháng sinh tiêm', 'Tiêm', 'Chai', 50000.00),
(11, 'Ibuprofen', 'Uống sau khi ăn', 'Viên', 12000.00),
(12, 'Metronidazole', 'Uống sau khi ăn', 'Viên', 18000.00),
(13, 'Cetirizine', 'Uống trước khi ăn', 'Viên', 25000.00),
(14, 'Loratadine', 'Uống trước khi ăn', 'Viên', 23000.00),
(15, 'Azithromycin', 'Uống sau khi ăn', 'Viên', 40000.00),
(16, 'Hydrocortisone', 'Thoa', 'Chai', 35000.00),
(17, 'Dexamethasone', 'Uống sau khi ăn', 'Viên', 28000.00),
(18, 'Chlorpheniramine', 'Uống trước khi ăn', 'Viên', 10000.00),
(19, 'Ciprofloxacin', 'Uống sau khi ăn', 'Viên', 45000.00),
(20, 'Clarithromycin', 'Uống sau khi ăn', 'Viên', 32000.00),
(21, 'Tetracycline', 'Uống sau khi ăn', 'Viên', 20000.00),
(22, 'Erythromycin', 'Uống trước khi ăn', 'Viên', 19000.00),
(23, 'Prednisone', 'Uống sau khi ăn', 'Viên', 25000.00),
(24, 'Omeprazole', 'Uống trước khi ăn', 'Viên', 21000.00),
(25, 'Esomeprazole', 'Uống trước khi ăn', 'Viên', 27000.00),
(26, 'Pantoprazole', 'Uống trước khi ăn', 'Viên', 29000.00),
(27, 'Ranitidine', 'Uống sau khi ăn', 'Viên', 15000.00),
(28, 'Famotidine', 'Uống trước khi ăn', 'Viên', 16000.00),
(29, 'Aspirin', 'Uống sau khi ăn', 'Viên', 11000.00),
(30, 'Clopidogrel', 'Uống sau khi ăn', 'Viên', 50000.00),
(31, 'Warfarin', 'Uống sau khi ăn', 'Viên', 45000.00),
(32, 'Metformin', 'Uống sau khi ăn', 'Viên', 30000.00),
(33, 'Glibenclamide', 'Uống sau khi ăn', 'Viên', 32000.00),
(34, 'Insulin', 'Tiêm', 'Chai', 80000.00),
(35, 'Amlodipine', 'Uống sau khi ăn', 'Viên', 18000.00),
(36, 'Lisinopril', 'Uống sau khi ăn', 'Viên', 20000.00),
(37, 'Losartan', 'Uống sau khi ăn', 'Viên', 23000.00),
(38, 'Hydrochlorothiazide', 'Uống sau khi ăn', 'Viên', 19000.00),
(39, 'Furosemide', 'Uống sau khi ăn', 'Viên', 15000.00),
(40, 'Atorvastatin', 'Uống sau khi ăn', 'Viên', 50000.00),
(41, 'Simvastatin', 'Uống sau khi ăn', 'Viên', 45000.00),
(42, 'Rosuvastatin', 'Uống sau khi ăn', 'Viên', 60000.00),
(43, 'Ezetimibe', 'Uống sau khi ăn', 'Viên', 30000.00),
(44, 'Alendronate', 'Uống trước khi ăn', 'Viên', 35000.00),
(45, 'Ibandronate', 'Uống trước khi ăn', 'Viên', 40000.00),
(46, 'Digoxin', 'Uống sau khi ăn', 'Viên', 24000.00),
(47, 'Nitroglycerin', 'Uống trước khi ăn', 'Viên', 32000.00),
(48, 'Amiodarone', 'Uống sau khi ăn', 'Viên', 45000.00),
(49, 'Verapamil', 'Uống sau khi ăn', 'Viên', 28000.00),
(50, 'Diltiazem', 'Uống sau khi ăn', 'Viên', 30000.00),
(51, 'Spironolactone', 'Uống sau khi ăn', 'Viên', 35000.00),
(52, 'Eplerenone', 'Uống sau khi ăn', 'Viên', 40000.00),
(53, 'Chlorthalidone', 'Uống sau khi ăn', 'Viên', 18000.00),
(54, 'Indapamide', 'Uống sau khi ăn', 'Viên', 20000.00),
(55, 'Ketoconazole', 'Uống sau khi ăn', 'Viên', 25000.00),
(56, 'Fluconazole', 'Uống sau khi ăn', 'Viên', 30000.00),
(57, 'Itraconazole', 'Uống sau khi ăn', 'Viên', 40000.00),
(58, 'Voriconazole', 'Uống sau khi ăn', 'Viên', 50000.00),
(59, 'Terbinafine', 'Uống sau khi ăn', 'Viên', 35000.00),
(60, 'Clotrimazole', 'Thoa', 'Chai', 15000.00),
(61, 'Miconazole', 'Thoa', 'Chai', 20000.00),
(62, 'Nystatin', 'Thoa', 'Chai', 18000.00),
(63, 'Griseofulvin', 'Uống sau khi ăn', 'Viên', 22000.00),
(64, 'Levofloxacin', 'Uống sau khi ăn', 'Viên', 45000.00),
(65, 'Moxifloxacin', 'Uống sau khi ăn', 'Viên', 50000.00),
(66, 'Ofloxacin', 'Uống sau khi ăn', 'Viên', 35000.00),
(67, 'Linezolid', 'Uống sau khi ăn', 'Viên', 55000.00),
(68, 'Daptomycin', 'Tiêm', 'Chai', 90000.00),
(69, 'Vancomycin', 'Tiêm', 'Chai', 100000.00),
(70, 'Rifampin', 'Uống sau khi ăn', 'Viên', 45000.00),
(71, 'Pyrazinamide', 'Uống sau khi ăn', 'Viên', 30000.00),
(72, 'Ethambutol', 'Uống sau khi ăn', 'Viên', 35000.00),
(73, 'Isoniazid', 'Uống trước khi ăn', 'Viên', 25000.00),
(74, 'Bedaquiline', 'Uống sau khi ăn', 'Viên', 120000.00),
(78, 'Delamanid', 'Uống sau khi ăn', 'Viên', 100000.00),
(80, 'Delamanid', 'Uống trước khi ăn', 'Viên', 30000.00),
(81, 'Miconazole', 'Thoa', 'Viên', 300000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_limits`
--
ALTER TABLE `appointment_limits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `benh`
--
ALTER TABLE `benh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_form`
--
ALTER TABLE `medical_form`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `disease_id` (`disease_id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phieu_kham`
--
ALTER TABLE `phieu_kham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `benh_id` (`benh_id`);

--
-- Indexes for table `phieu_kham_thuoc`
--
ALTER TABLE `phieu_kham_thuoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phieu_kham_id` (`phieu_kham_id`),
  ADD KEY `thuoc_id` (`thuoc_id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_form_id` (`medical_form_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thuoc`
--
ALTER TABLE `thuoc`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointment_limits`
--
ALTER TABLE `appointment_limits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=324;

--
-- AUTO_INCREMENT for table `benh`
--
ALTER TABLE `benh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_form`
--
ALTER TABLE `medical_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `phieu_kham`
--
ALTER TABLE `phieu_kham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phieu_kham_thuoc`
--
ALTER TABLE `phieu_kham_thuoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `thuoc`
--
ALTER TABLE `thuoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `medical_form`
--
ALTER TABLE `medical_form`
  ADD CONSTRAINT `medical_form_ibfk_2` FOREIGN KEY (`disease_id`) REFERENCES `benh` (`id`);

--
-- Constraints for table `phieu_kham`
--
ALTER TABLE `phieu_kham`
  ADD CONSTRAINT `phieu_kham_ibfk_1` FOREIGN KEY (`benh_id`) REFERENCES `benh` (`id`);

--
-- Constraints for table `phieu_kham_thuoc`
--
ALTER TABLE `phieu_kham_thuoc`
  ADD CONSTRAINT `phieu_kham_thuoc_ibfk_1` FOREIGN KEY (`phieu_kham_id`) REFERENCES `phieu_kham` (`id`),
  ADD CONSTRAINT `phieu_kham_thuoc_ibfk_2` FOREIGN KEY (`thuoc_id`) REFERENCES `thuoc` (`id`);

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`medical_form_id`) REFERENCES `medical_form` (`id`),
  ADD CONSTRAINT `prescriptions_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `thuoc` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
