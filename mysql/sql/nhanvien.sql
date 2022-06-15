-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-server
-- Generation Time: Jan 14, 2022 at 11:25 AM
-- Server version: 8.0.1-dmr
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nhanvien`
--
CREATE DATABASE IF NOT EXISTS `nhanvien` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `nhanvien`;

-- --------------------------------------------------------

--
-- Table structure for table `donxinnghi`
--

CREATE TABLE `donxinnghi` (
  `id_donxinnghi` int(11) NOT NULL,
  `nhanvien_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `loainv` varchar(100) CHARACTER SET utf8 NOT NULL,
  `tenphongban` varchar(128) CHARACTER SET utf8 NOT NULL,
  `noidung` varchar(500) NOT NULL,
  `trangthai` varchar(50) NOT NULL,
  `ngaytaodon` date DEFAULT NULL,
  `ngayduyetdon` date DEFAULT NULL,
  `file_dinhkem` varchar(500) DEFAULT NULL,
  `songaynghi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donxinnghi`
--

INSERT INTO `donxinnghi` (`id_donxinnghi`, `nhanvien_id`, `loainv`, `tenphongban`, `noidung`, `trangthai`, `ngaytaodon`, `ngayduyetdon`, `file_dinhkem`, `songaynghi`) VALUES
(1, 'NV00001', 'Trưởng Phòng', 'IT', 'tôi có việc bận', 'Approved', '2022-01-14', '2022-01-14', '/donxinnghi/1.txt', 1),
(2, 'NV00002', 'Nhân Viên', 'IT', 'bệnh', 'Refused', '2022-01-14', '2022-01-14', '/donxinnghi/2.txt', 1),
(3, 'NV00005', 'Nhân Viên', 'Kế Hoạch', 'bệnh', 'Refused', '2022-01-14', '2022-01-14', '/donxinnghi/3.txt', 1),
(4, 'NV00004', 'Trưởng Phòng', 'Kế Hoạch', 'em nhập viện', 'Waiting', '2022-01-14', NULL, '/donxinnghi/4.txt', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ds_phongban`
--

CREATE TABLE `ds_phongban` (
  `tenphongban` varchar(50) CHARACTER SET utf8 NOT NULL,
  `mota` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `sophong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ds_phongban`
--

INSERT INTO `ds_phongban` (`tenphongban`, `mota`, `sophong`) VALUES
('IT', 'Xử lí các tác vụ về thông tin', 2),
('Kế hoạch', 'Lên kế hoạch chiến lược', 2),
('Kĩ Thuật', 'Sửa chữa, bảo trì thiết bị hạ tầng', 1),
('Marketing', 'Thực hiện công việc quản bá', 2),
('Tài Chính', 'Xử lí các tác vụ liên qua đến tài chính', 3);

-- --------------------------------------------------------

--
-- Table structure for table `history_submit`
--

CREATE TABLE `history_submit` (
  `history_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `comment` varchar(5000) DEFAULT NULL,
  `trangthai` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'New',
  `file_submit` varchar(500) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history_submit`
--

INSERT INTO `history_submit` (`history_id`, `task_id`, `comment`, `trangthai`, `file_submit`, `date`) VALUES
(1, 1, 'em nộp file', 'Waiting', '', '2022-01-08'),
(2, 7, 'em nộp file', 'Waiting', '1.txt', '2022-01-08'),
(3, 8, 'em nộp file', 'Waiting', '1.txt', '2022-01-08'),
(4, 8, 'em nộp file', 'Waiting', '3.txt', '2022-01-08'),
(5, 1, 'chưa đạt', 'Rejected', 'Array', '2022-01-08'),
(6, 1, 'chưa đạt', 'Rejected', 'Array', '2022-01-08'),
(7, 1, 'chưa đạt', 'Rejected', 'Array', '2022-01-08'),
(8, 6, 'em nộp file', 'Waiting', 'Array', '2022-01-08'),
(9, 6, 'em nộp file', 'Waiting', 'Array', '2022-01-08'),
(10, 9, 'em nộp file', 'Waiting', 'Array', '2022-01-08'),
(11, 9, 'em nộp file', 'Waiting', 'Array', '2022-01-08'),
(12, 9, 'em nộp file', 'Waiting', 'Array', '2022-01-08'),
(13, 9, 'em nộp file', 'Waiting', 'Array', '2022-01-08'),
(14, 9, 'em nộp file', 'Waiting', 'Array', '2022-01-08'),
(15, 6, 'chưa đạt, hãy xem lại task', 'Rejected', 'Array', '2022-01-09'),
(16, 6, 'chưa đạt đâu em', 'Rejected', 'Array', '2022-01-09'),
(17, 7, 'tôi cảm thấy chưa đạt', 'Rejected', 'Array', '2022-01-09'),
(18, 9, 'tôi từ chối', 'Rejected', 'Array', '2022-01-09'),
(19, 9, 'tôi từ chối', 'Rejected', 'Array', '2022-01-09'),
(20, 6, 'chưa đạt', 'Rejected', '/task_bosung_files/bosung_task6.txt', '2022-01-09'),
(21, 6, 'chưa đạt', 'Rejected', '/task_bosung_files/bosung_task6.txt', '2022-01-09'),
(22, 8, 'tôi nộp file', 'Waiting', '/task_bosung_files/bosung_task8.txt', '2022-01-09'),
(23, 10, 'em nộp', 'Waiting', '/task_submit_files/10/23.txt', '2022-01-09'),
(24, 10, 'tôi không đồng ý', 'Rejected', '/task_bosung_files/bosung_task10.txt', '2022-01-09'),
(25, 11, 'em nộp file', 'Waiting', '/history_task/11/25.txt', '2022-01-10'),
(26, 11, 'em nộp file', 'Waiting', '/history_task/11/26.txt', '2022-01-10'),
(27, 12, 'fewf', 'Waiting', '/history_task/12/27.txt', '2022-01-10'),
(28, 12, 'fewf', 'Waiting', '/history_task/12/28.txt', '2022-01-10'),
(29, 13, 'grgre', 'Waiting', '/history_task/13/.txt', '2022-01-11'),
(30, 13, 'grgre', 'Waiting', '/history_task/13/.txt', '2022-01-11'),
(31, 12, 'fewf', 'Rejected', '/task_bosung_files/bosung_task12.txt', '2022-01-11'),
(32, 13, 'grgre', 'Rejected', '/task_bosung_files/bosung_task13.txt', '2022-01-11'),
(33, 13, 'grgre', 'Waiting', '/history_task/13/.txt', '2022-01-11'),
(34, 13, 'grgre', 'Rejected', '/task_bosung_files/bosung_task13.txt', '2022-01-11'),
(35, 13, 'grgre', 'Waiting', '/history_task/13/35.txt', '2022-01-11'),
(36, 13, 'grgre', 'Rejected', '/task_bosung_files/bosung_task13.txt', '2022-01-11'),
(37, 9, 'tôi từ chối', 'Waiting', '/history_task/9/37.txt', '2022-01-11'),
(38, 14, 'few', 'Waiting', '/history_task/14/38.txt', '2022-01-11'),
(39, 15, 'em nộp file', 'Waiting', '/history_task/15/39.txt', '2022-01-13');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `manv` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tennv` varchar(128) CHARACTER SET utf8 NOT NULL,
  `loainv` varchar(100) CHARACTER SET utf8 NOT NULL,
  `tenphongban` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `avt` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `songaynghi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`manv`, `username`, `password`, `tennv`, `loainv`, `tenphongban`, `avt`, `songaynghi`) VALUES
('GD00001', 'admin', '$2y$10$wZE/mdoPagyFFuE5.xnYjeq8zU280IdRGjhxnXRgIFpbG8dZgv862', 'Nguyễn Thanh Thúy', 'Giám Đốc', NULL, 'admin.png', 0),
('NV00001', 'NV00001', '$2y$10$cGcZLYMJCdQCixDSv5eSL.SOyyyihF5zZser9YsLq4utOwpYjBj8i', 'Nguyễn Văn Hùng', 'Trưởng Phòng', 'IT', 'avatar.png', 0),
('NV00002', 'NV00002', '$2a$12$caHH89quduJX0rxsDX56JO7WLeaEqO2Shg73x01S1IP/qoqdo757K', 'Nguyễn Văn Tuấn', 'Nhân Viên', 'IT', 'avatar.png', 4),
('NV00003', 'NV00003', '$2a$12$caHH89quduJX0rxsDX56JO7WLeaEqO2Shg73x01S1IP/qoqdo757K', 'Nguyễn Thành Danh', 'Nhân Viên', 'Tài Chính', 'avatar.png', 0),
('NV00004', 'NV00004', '$2a$12$caHH89quduJX0rxsDX56JO7WLeaEqO2Shg73x01S1IP/qoqdo757K', 'Trần Trung Thắng', 'Trưởng Phòng', 'Kế Hoạch', 'avatar.png', 2),
('NV00005', 'NV00005', '$2y$10$XRdoNhuPyK6d/XUOcfKXHuqVYtJtX82s1uOec6v96BFcKjPGs5bqC', 'Nguyễn Thanh Trung', 'Nhân Viên', 'Kế Hoạch', 'avatar.png', 0),
('NV00006', 'NV00006', '$2y$10$dDHKYRMQw5GAvVfRewU4..5fwB89qHwUdG8r2/5aB77tayCFqqaLq', 'Nguyễn Văn Thắng', 'Nhân Viên', 'Tài Chính', 'avatar.png', 0),
('NV00007', 'NV00007', '$2y$10$cWLkvaFIJW6BTD2ueFddO.OBvvQSPoEOpIxssyFVISg0jIfbWppvy', 'Trần Văn Mạnh', 'Nhân Viên', 'Marketing ', 'avatar.png', 0),
('NV00008', 'NV00008', '$2a$10$U6AGWtdFWh61tBGqHPSZle1SqS07bC6mlio1HwwLGhAI9ShgSUJYK', 'Nguyễn Thái Hà', 'Nhân Viên', 'Kế Hoạch', 'avatar.png', 0),
('NV00009', 'NV00009', '$2a$10$JMGAxtnYFpemuDAmAHOVBebdAf3gO.9dKde4nAb/u/Bxu1spfAHmK', 'Nguyễn Thu Thảo', 'Nhân Viên', 'Marketing', 'avatar.png', 0),
('NV00010', 'NV00010', '$2a$10$yxygSb3uFfd9N9UX7hMvfuyqmRFiZ.qtENU1j0ZAI85gZJljtHe/S', 'Trần Thanh Tâm', 'Nhân Viên', 'Kĩ Thuật', 'avatar.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `tentask` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nhanvien_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tenphongban` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deadline` date DEFAULT NULL,
  `file_mota` varchar(500) DEFAULT NULL,
  `file_nop` varchar(500) DEFAULT NULL,
  `file_bosung` varchar(500) DEFAULT NULL,
  `trangthai` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'New',
  `uutien` int(11) NOT NULL DEFAULT '1',
  `late` int(11) NOT NULL DEFAULT '0',
  `completion_level` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `tentask`, `nhanvien_id`, `tenphongban`, `deadline`, `file_mota`, `file_nop`, `file_bosung`, `trangthai`, `uutien`, `late`, `completion_level`) VALUES
(1, 'Lập trình dự án T01', 'NV00002', 'IT', '2022-01-03', '', '', NULL, 'Completed', 6, 1, 'OK'),
(3, 'Kế hoạch phát triển vốn', 'NV00005', 'Kế Hoạch', '2022-01-04', '/tasks_attached_files/task3.txt', '', NULL, 'New', 1, 0, NULL),
(4, 'Gia tăng vốn', 'NV00008', 'Kế Hoạch', '2022-01-06', '', '', NULL, 'New', 1, 0, NULL),
(5, 'Lập trình dự án T05', 'NV00002', 'IT', '2022-01-07', '/tasks_attached_files/task5.txt', '', NULL, 'Canceled', 3, 0, NULL),
(7, 'Lập trình dự án T07', 'NV00002', 'IT', '2022-01-21', '/tasks_attached_files/task7.txt', '/task_submit_files/7/2.txt', '/task_bosung_files/7.txt', 'Waiting', 4, 0, NULL),
(9, 'Lập trình dự án T09', 'NV00002', 'IT', '2022-01-13', '/tasks_attached_files/task9.txt', '/task_submit_files/9/9.txt', '/task_bosung_files/bosung_task9.txt', 'Waiting', 4, 0, NULL),
(10, 'Lập trình dự án T10', 'NV00002', 'IT', '2022-01-14', '/tasks_attached_files/task10.txt', '/task_submit_files/10/23.txt', '/task_bosung_files/bosung_task10.txt', 'Rejected', 5, 0, NULL),
(11, 'Lập trình dự án T11', 'NV00002', 'IT', '2022-01-12', '/tasks_attached_files/task11.txt', '/task_submit_files/11/26.txt', NULL, 'Completed', 6, 0, 'Good'),
(12, 'Lập trình dự án T012', 'NV00002', 'IT', '2022-01-12', '/tasks_attached_files/task12.txt', '/task_submit_files/12/28.txt', '/task_bosung_files/bosung_task12.txt', 'Rejected', 5, 0, NULL),
(13, 'Lập trình dự án T013', 'NV00002', 'IT', '2022-01-13', '', '/task_submit_files/13/35.txt', '/task_bosung_files/bosung_task13.txt', 'Rejected', 5, 0, NULL),
(14, 'Lập trình dự án T014', 'NV00002', 'IT', '2022-01-11', '', '/task_submit_files/14/14.txt', NULL, 'Waiting', 4, 0, NULL),
(15, 'Lập trình dự án T015', 'NV00002', 'IT', '2021-12-30', '', '/task_submit_files/15/15.txt', NULL, 'Waiting', 4, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donxinnghi`
--
ALTER TABLE `donxinnghi`
  ADD PRIMARY KEY (`id_donxinnghi`),
  ADD KEY `nhanvien_id` (`nhanvien_id`),
  ADD KEY `tenphongban` (`tenphongban`);

--
-- Indexes for table `ds_phongban`
--
ALTER TABLE `ds_phongban`
  ADD PRIMARY KEY (`tenphongban`);

--
-- Indexes for table `history_submit`
--
ALTER TABLE `history_submit`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`manv`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `tenphongban` (`tenphongban`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `task_ibfk_1` (`nhanvien_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
