-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 03, 2026 lúc 07:01 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `qlns`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attendance`
--

CREATE TABLE `attendance` (
  `employee_id` int(11) NOT NULL,
  `work_date` date NOT NULL,
  `work_value` float DEFAULT NULL COMMENT '0.5=1 ca, 1=2 ca, 1.5=OT 1 ca',
  `locked` tinyint(4) DEFAULT 0 COMMENT '1 = đã chốt công'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `attendance`
--

INSERT INTO `attendance` (`employee_id`, `work_date`, `work_value`, `locked`) VALUES
(1, '2026-01-04', 1, 0),
(1, '2026-01-08', 0.5, 0),
(1, '2026-01-13', 1, 0),
(1, '2026-01-29', 0.5, 0),
(1, '2026-02-01', NULL, 0),
(1, '2026-02-02', NULL, 0),
(1, '2026-02-03', 1.5, 0),
(1, '2026-02-04', NULL, 0),
(1, '2026-02-05', 1, 0),
(1, '2026-02-06', 1, 0),
(1, '2026-02-07', 1.5, 0),
(1, '2026-02-08', 1, 0),
(1, '2026-02-09', 1.5, 0),
(1, '2026-02-10', 1, 0),
(1, '2026-02-11', 1.5, 0),
(1, '2026-02-12', 1, 0),
(1, '2026-02-13', 1, 0),
(1, '2026-02-14', 1, 0),
(1, '2026-02-15', 1, 0),
(1, '2026-02-16', 1, 0),
(1, '2026-02-17', 1, 0),
(1, '2026-02-18', 1, 0),
(1, '2026-02-19', 1.5, 0),
(1, '2026-02-20', 1, 0),
(1, '2026-02-21', 1, 0),
(1, '2026-02-22', 1, 0),
(1, '2026-02-23', 1.5, 0),
(1, '2026-02-24', 1, 0),
(1, '2026-02-25', 1.5, 0),
(1, '2026-02-26', 1, 0),
(1, '2026-02-27', 1.5, 0),
(1, '2026-02-28', 1, 0),
(1, '2026-03-10', 0.5, 0),
(1, '2026-03-14', 0.5, 0),
(1, '2026-05-08', 0.5, 0),
(1, '2026-05-13', 0.5, 0),
(1, '2026-05-20', 0.5, 0),
(1, '2026-06-05', 1, 0),
(1, '2026-06-06', 1, 0),
(1, '2026-06-08', 0.5, 0),
(1, '2026-06-09', 0.5, 0),
(1, '2026-06-12', 1, 0),
(1, '2026-06-19', 0.5, 0),
(1, '2026-06-20', 0.5, 0),
(1, '2026-06-25', 0.5, 0),
(1, '2026-06-29', 0.5, 0),
(1, '2026-11-12', 0.5, 0),
(2, '2026-01-13', 0.5, 0),
(2, '2026-01-28', 0.5, 0),
(2, '2026-02-02', 1, 0),
(2, '2026-02-03', 0.5, 0),
(2, '2026-02-04', 0.5, 0),
(2, '2026-02-06', 0.5, 0),
(2, '2026-02-08', 1, 0),
(2, '2026-02-09', 0.5, 0),
(2, '2026-02-11', 1.5, 0),
(2, '2026-02-12', 0.5, 0),
(2, '2026-02-13', 0.5, 0),
(2, '2026-02-16', 0.5, 0),
(2, '2026-02-17', 0.5, 0),
(2, '2026-02-18', 1.5, 0),
(2, '2026-02-19', 1, 0),
(2, '2026-02-20', 1, 0),
(2, '2026-02-21', 1, 0),
(2, '2026-02-22', 0.5, 0),
(2, '2026-02-23', 1, 0),
(2, '2026-02-24', 1, 0),
(2, '2026-03-13', 1, 0),
(2, '2026-05-19', 0.5, 0),
(2, '2026-05-27', 0.5, 0),
(3, '2026-01-04', 0.5, 0),
(3, '2026-01-06', 0.5, 0),
(3, '2026-01-07', 0.5, 0),
(3, '2026-01-08', 0.5, 0),
(3, '2026-01-09', 1, 0),
(3, '2026-01-11', 0.5, 0),
(3, '2026-01-13', 0.5, 0),
(3, '2026-01-21', 0.5, 0),
(3, '2026-01-26', 0.5, 0),
(3, '2026-01-30', 0.5, 0),
(3, '2026-02-01', 0.5, 0),
(3, '2026-02-03', 0.5, 0),
(3, '2026-02-04', 0.5, 0),
(3, '2026-02-05', 0.5, 0),
(3, '2026-02-06', 0.5, 0),
(3, '2026-02-07', 0.5, 0),
(3, '2026-02-08', 1, 0),
(3, '2026-02-10', 1, 0),
(3, '2026-02-13', 0.5, 0),
(3, '2026-02-14', NULL, 0),
(3, '2026-02-15', 0.5, 0),
(3, '2026-02-16', 0.5, 0),
(3, '2026-02-17', 0.5, 0),
(3, '2026-02-18', 0.5, 0),
(3, '2026-02-19', 1.5, 0),
(3, '2026-02-21', 0.5, 0),
(3, '2026-02-22', 0.5, 0),
(3, '2026-02-25', 0.5, 0),
(3, '2026-03-12', 0.5, 0),
(3, '2026-03-14', 1, 0),
(3, '2026-03-15', 0.5, 0),
(3, '2026-03-16', 0.5, 0),
(3, '2026-03-20', 0.5, 0),
(3, '2026-03-24', 0.5, 0),
(3, '2026-05-06', 1, 0),
(3, '2026-05-10', 0.5, 0),
(3, '2026-05-15', 0.5, 0),
(3, '2026-05-24', 0.5, 0),
(3, '2026-06-08', 0.5, 0),
(3, '2026-06-10', 0.5, 0),
(3, '2026-06-17', 0.5, 0),
(3, '2026-06-18', 0.5, 0),
(3, '2026-11-08', 0.5, 0),
(3, '2026-11-12', 0.5, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attendance_logs`
--

CREATE TABLE `attendance_logs` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `work_date` date DEFAULT NULL,
  `old_value` float DEFAULT NULL,
  `new_value` float DEFAULT NULL,
  `changed_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `salary_per_day` int(11) DEFAULT NULL COMMENT 'Lương 1 ngày đủ 2 ca',
  `salary_month` int(11) DEFAULT NULL COMMENT 'Lương cố định theo tháng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `employees`
--

INSERT INTO `employees` (`id`, `name`, `salary_per_day`, `salary_month`) VALUES
(1, 'Nguyễn Văn A', 300003, 8000000),
(2, 'Trần Thị B', 280000, 6000000),
(3, 'Thanh', 8000000, 8000000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `holiday_bonus`
--

CREATE TABLE `holiday_bonus` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `bonus_amount` int(11) DEFAULT 0,
  `bonus_percent` decimal(5,2) DEFAULT 0.00,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payroll`
--

CREATE TABLE `payroll` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `total_work` float DEFAULT NULL,
  `leave_days` int(11) DEFAULT NULL,
  `salary_month` int(11) DEFAULT NULL,
  `final_salary` int(11) DEFAULT NULL,
  `salary_note` varchar(255) DEFAULT NULL,
  `locked` tinyint(4) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payroll_lock`
--

CREATE TABLE `payroll_lock` (
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `locked_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payroll_lock`
--

INSERT INTO `payroll_lock` (`year`, `month`, `locked_at`) VALUES
(2026, 1, '2026-02-04 00:50:19'),
(2026, 11, '2026-02-03 19:45:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `value` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'leave_days_per_month', 2.00);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`employee_id`,`work_date`);

--
-- Chỉ mục cho bảng `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `holiday_bonus`
--
ALTER TABLE `holiday_bonus`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payroll_lock`
--
ALTER TABLE `payroll_lock`
  ADD PRIMARY KEY (`year`,`month`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `attendance_logs`
--
ALTER TABLE `attendance_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `holiday_bonus`
--
ALTER TABLE `holiday_bonus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
