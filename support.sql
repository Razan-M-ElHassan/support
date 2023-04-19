-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2023 at 03:02 PM
-- Server version: 5.7.11
-- PHP Version: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `support`
--

-- --------------------------------------------------------

--
-- Table structure for table `supp_area`
--

CREATE TABLE `supp_area` (
  `area_id` int(5) NOT NULL,
  `area_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `area_city` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL,
  `create_by` int(5) NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `supp_area`
--

INSERT INTO `supp_area` (`area_id`, `area_name`, `area_city`, `create_at`, `create_by`, `update_at`, `update_by`) VALUES
(1, 'المزاد', 'بحري', '2023-04-19 00:00:00', 1, '2023-04-19 15:56:46', 1),
(2, 'جبرة', 'الخرطوم', '2023-04-19 15:55:16', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supp_config`
--

CREATE TABLE `supp_config` (
  `conf_user` int(5) NOT NULL DEFAULT '0',
  `conf_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `conf_val` text COLLATE utf8_unicode_ci NOT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `supp_config`
--

INSERT INTO `supp_config` (`conf_user`, `conf_name`, `conf_val`, `update_at`) VALUES
(0, 'ADDRESS', 'السعودية - الرياض - السليمانية', NULL),
(0, 'DESC_INFO', 'نظام عرض طلبات المساعدات', '2023-04-19 13:12:15'),
(0, 'EMAIL_ADD', 'test@maknorsoft.com', '2023-04-19 13:12:15'),
(0, 'FACEBOOK', 'https://facebook.com', '2023-04-19 13:12:15'),
(0, 'INSTAGRAM', 'https://instagram.com', '2023-04-19 13:12:15'),
(0, 'INVESTMENT', '900', NULL),
(0, 'LOGIN_FOOTER', 'جميع الحقوق محفوظة', '2023-04-19 13:12:15'),
(0, 'LOGO', 'logo.png', NULL),
(0, 'PAGING', '10', '2023-04-19 13:12:15'),
(0, 'PHONE', '+249900987961', '2023-04-19 13:12:15'),
(0, 'TITLE', 'المساعدات', '2023-04-19 13:12:15'),
(0, 'TWITTER', 'https://twitter.com', '2023-04-19 13:12:15'),
(1, 'ABOUT', 'عبارة عن منصة لعرض طلبات المساعدات', '2023-04-19 13:12:15'),
(1, 'EMAIL_HOST', 'mail.maknorsoft.com', '2023-04-19 13:12:15'),
(1, 'EMAIL_PORT', '587', '2023-04-19 13:12:15'),
(1, 'EMAIL_SEND_ADD', 'test@maknorsoft.com', '2023-04-19 13:12:15'),
(1, 'EMAIL_SEND_PASS', 'passme@TEST123456', '2023-04-19 13:12:15'),
(1, 'EMAIL_SMTP_AUTH', '1', NULL),
(1, 'TERMS', 'لا بد من ادخال بيانات صحيحة لكي يتم الوصول لك\r\nوبادخالك هذه البينات تعني انك تقبل عرضها للعامة', '2023-04-19 13:12:15');

-- --------------------------------------------------------

--
-- Table structure for table `supp_forget`
--

CREATE TABLE `supp_forget` (
  `for_id` int(10) NOT NULL,
  `for_user` int(55) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supp_notification`
--

CREATE TABLE `supp_notification` (
  `noti_id` int(11) NOT NULL,
  `noti_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `noti_user` int(5) NOT NULL,
  `noti_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `noti_link` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `noti_status` int(2) DEFAULT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supp_pages`
--

CREATE TABLE `supp_pages` (
  `page_id` int(10) NOT NULL,
  `page_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `page_class` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `page` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `page_description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `page_per_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'read'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `supp_pages`
--

INSERT INTO `supp_pages` (`page_id`, `page_name`, `page_class`, `page`, `page_description`, `page_per_type`) VALUES
(1, 'الضبط', 'configuration', 'index', 'تحديث الاعدادات', 'تحديث'),
(2, 'الصلاحيات', 'permission', 'index', 'الدخول لصفحة الصلاحيات', 'عرض'),
(3, 'الصلاحيات', 'permission', 'new_group', 'إضافة مجموعة جديدة', 'إضافة'),
(4, 'الصلاحيات', 'permission', 'upd_group', 'تحديث الصلاحيات', 'تحديث'),
(5, 'الصلاحيات', 'permission', 'del_group', 'حذف صلاحية', 'حذف'),
(6, 'النسخ الاحتياطي', 'backup', 'index', 'الدخول لصفحة النسخ الاحتياطي', 'عرض'),
(7, 'النسخ الاحتياطي', 'backup', 'new_backup', 'إضافة نسخة احتياطية', 'إضافة'),
(8, 'النسخ الاحتياطي', 'backup', 'get_file', 'تنزيل ملف نسخة احتياطية', 'عرض'),
(9, 'النسخ الاحتياطي', 'backup', 'get_backup', 'استرجاع نسخة احتياطية', 'تحديث'),
(10, 'النسخ الاحتياطي', 'backup', 'upload_backup', 'اضافة ملف نسخة احتياطية', 'إضافة'),
(11, 'النسخ الاحتياطي', 'backup', 'del_backup', 'حذف ملف نسخة احتياطية', 'حذف'),
(12, 'الطلاب', 'staff', 'index', 'الدخول لصفحة الطلاب', 'عرض'),
(13, 'الطلاب', 'staff', 'new_staff', 'إضافة طالب جديد', 'إضافة'),
(14, 'الطلاب', 'staff', 'upd_staff', 'تحديث بيانات الطالب', 'تحديث'),
(15, 'الطلاب', 'staff', 'active', 'إيقاف وفك إيقاف الطلاب', 'تحديث'),
(16, 'الطلاب', 'staff', 'msg_staff', 'ارسال رسالة للطلاب', 'إضافة'),
(17, 'الطلاب', 'staff', 'del_file', 'مسح ملف مستخدم', 'حذف'),
(18, 'الطلبات', 'requests', 'index', 'عرض انواع البيانات الاضافية للطلاب', 'عرض'),
(19, 'الطلبات', 'requests', 'active', 'قبول الطلب', 'تحديث'),
(20, 'الطلبات', 'requests', 'done', 'اكمال الطلب', 'تحديث'),
(21, 'الطلبات', 'requests', 'سسس', 'سسسس', 'تحديث'),
(22, 'التخصصات', 'specialist', 'index', 'عرض التخصصات', 'عرض'),
(23, 'التخصصات', 'specialist', 'new_spec', 'إضافة تخصص', 'إضافة'),
(24, 'التخصصات', 'specialist', 'upd_spec', 'تعديل تخصص', 'تحديث'),
(25, 'التخصصات', 'specialist', 'del_spec', 'حذف تخصص', 'حذف'),
(26, 'المناطق', 'area', 'index', 'عرض التخصصات', 'عرض'),
(27, 'المناطق', 'area', 'new_spec', 'إضافة تخصص', 'إضافة'),
(28, 'المناطق', 'area', 'upd_spec', 'تعديل تخصص', 'تحديث'),
(29, 'المناطق', 'area', 'del_spec', 'حذف تخصص', 'حذف');

-- --------------------------------------------------------

--
-- Table structure for table `supp_permission_groups`
--

CREATE TABLE `supp_permission_groups` (
  `per_id` int(5) NOT NULL,
  `per_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `per_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `per_default_page` int(5) NOT NULL,
  `per_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL,
  `create_by` int(5) NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `supp_permission_groups`
--

INSERT INTO `supp_permission_groups` (`per_id`, `per_name`, `per_type`, `per_default_page`, `per_desc`, `create_at`, `create_by`, `update_at`, `update_by`) VALUES
(1, 'System Admin', 'ADMIN', 1, 'Main Permission For System Admin - No Update', '2023-01-01 00:00:00', 1, NULL, NULL),
(2, 'طلاب', 'STUDENT', 1, 'الطلاب الذين لا يستخدمون النظام', '2023-01-14 08:19:20', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supp_per_group_pages`
--

CREATE TABLE `supp_per_group_pages` (
  `per_group_permission` int(5) NOT NULL,
  `per_group_page` int(10) NOT NULL,
  `create_at` datetime NOT NULL,
  `create_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `supp_per_group_pages`
--

INSERT INTO `supp_per_group_pages` (`per_group_permission`, `per_group_page`, `create_at`, `create_by`) VALUES
(1, 1, '2023-01-01 00:00:00', 1),
(1, 2, '2023-01-01 00:00:00', 1),
(1, 3, '2023-01-01 00:00:00', 1),
(1, 4, '2023-01-01 00:00:00', 1),
(1, 5, '2023-01-01 00:00:00', 1),
(1, 6, '2023-01-01 00:00:00', 1),
(1, 7, '2023-01-01 00:00:00', 1),
(1, 8, '2023-01-01 00:00:00', 1),
(1, 9, '2023-01-01 00:00:00', 1),
(1, 10, '2023-01-01 00:00:00', 1),
(1, 11, '2023-01-01 00:00:00', 1),
(1, 12, '2023-01-01 00:00:00', 1),
(1, 13, '2023-01-01 00:00:00', 1),
(1, 14, '2023-01-01 00:00:00', 1),
(1, 15, '2023-01-01 00:00:00', 1),
(1, 16, '2023-01-01 00:00:00', 1),
(1, 17, '2023-01-01 00:00:00', 1),
(1, 18, '2023-01-01 00:00:00', 1),
(1, 19, '2023-01-01 00:00:00', 1),
(1, 20, '2023-01-01 00:00:00', 1),
(1, 21, '2023-01-01 00:00:00', 1),
(1, 22, '2023-01-01 00:00:00', 1),
(1, 23, '2023-01-01 00:00:00', 1),
(1, 24, '2023-01-01 00:00:00', 1),
(1, 25, '2023-01-01 00:00:00', 1),
(1, 26, '2023-04-19 00:00:00', 1),
(1, 27, '2023-04-19 00:00:00', 1),
(1, 28, '2023-04-19 00:00:00', 1),
(1, 29, '2023-04-19 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supp_specialist`
--

CREATE TABLE `supp_specialist` (
  `spe_id` int(5) NOT NULL,
  `spe_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL,
  `create_by` int(5) NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `supp_specialist`
--

INSERT INTO `supp_specialist` (`spe_id`, `spe_name`, `create_at`, `create_by`, `update_at`, `update_by`) VALUES
(1, 'طب', '2023-03-28 12:58:07', 1, NULL, NULL),
(2, 'ماء', '2023-03-28 12:58:07', 1, '2023-03-28 13:05:42', 1),
(3, 'جاز', '2023-04-19 15:45:23', 1, NULL, NULL),
(4, 'جبرة', '2023-04-19 15:53:10', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supp_staff`
--

CREATE TABLE `supp_staff` (
  `staff_id` int(5) NOT NULL,
  `staff_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `staff_permission` tinyint(4) NOT NULL DEFAULT '2',
  `staff_img` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'usr.png',
  `staff_spe` int(5) DEFAULT NULL,
  `staff_city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `staff_phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `staff_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `staff_pass` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `staff_accept_cons` tinyint(1) DEFAULT '0',
  `staff_active` tinyint(1) NOT NULL DEFAULT '1',
  `create_at` datetime NOT NULL,
  `create_by` int(5) NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `supp_staff`
--

INSERT INTO `supp_staff` (`staff_id`, `staff_name`, `staff_permission`, `staff_img`, `staff_spe`, `staff_city`, `staff_phone`, `staff_email`, `staff_pass`, `staff_accept_cons`, `staff_active`, `create_at`, `create_by`, `update_at`, `update_by`) VALUES
(1, 'المدير', 1, 'usr.png', NULL, NULL, '0900987961', 'admin@admin.com', '5db074ea7a3d9c0cc12409c2c92cc3625c183f6f88fbc9f0c84bbd439acb4ed1', NULL, 1, '2023-03-24 00:00:00', 1, NULL, NULL),
(2, 'إختبار', 2, 'usr.png', 2, 'الخرطوم', '0987654333', 'test@org.com', '5db074ea7a3d9c0cc12409c2c92cc3625c183f6f88fbc9f0c84bbd439acb4ed1', 0, 1, '2023-03-26 00:00:00', 1, '2023-03-28 15:26:54', 1),
(3, 'الطالب 1', 2, 'usr.png', 2, 'الخرطوم بحري', '0900987969', 'khalil22@windowslive.com', '5db074ea7a3d9c0cc12409c2c92cc3625c183f6f88fbc9f0c84bbd439acb4ed1', 1, 1, '2023-03-28 14:27:31', 1, '2023-03-31 10:44:52', 3);

-- --------------------------------------------------------

--
-- Table structure for table `supp_support`
--

CREATE TABLE `supp_support` (
  `supp_id` int(11) NOT NULL,
  `supp_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `supp_email` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_type` int(5) NOT NULL,
  `supp_area` int(5) NOT NULL,
  `supp_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL,
  `supp_accept` tinyint(1) NOT NULL DEFAULT '0',
  `supp_accept_by` int(5) DEFAULT NULL,
  `supp_accept_time` datetime DEFAULT NULL,
  `supp_don` tinyint(1) NOT NULL DEFAULT '0',
  `supp_done_by` int(5) DEFAULT NULL,
  `supp_done_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `supp_support`
--

INSERT INTO `supp_support` (`supp_id`, `supp_name`, `supp_phone`, `supp_email`, `supp_type`, `supp_area`, `supp_desc`, `create_at`, `supp_accept`, `supp_accept_by`, `supp_accept_time`, `supp_don`, `supp_done_by`, `supp_done_time`) VALUES
(1, 'Test Support', '0987654321', NULL, 1, 1, 'Description', '2023-04-19 12:00:00', 1, 1, '2023-04-19 12:06:00', 1, 1, '2023-04-19 15:35:00'),
(2, 'عباس', '0121212121', NULL, 2, 1, 'asssssss', '2023-04-19 12:32:28', 1, 1, '2023-04-19 15:30:01', 0, NULL, NULL),
(3, 'عباس', '0121212121', NULL, 2, 1, 'asssssss', '2023-04-19 12:32:28', 1, 1, '2023-04-19 15:30:45', 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `supp_area`
--
ALTER TABLE `supp_area`
  ADD PRIMARY KEY (`area_id`),
  ADD KEY `update_by` (`update_by`),
  ADD KEY `create_by` (`create_by`);

--
-- Indexes for table `supp_config`
--
ALTER TABLE `supp_config`
  ADD PRIMARY KEY (`conf_user`,`conf_name`),
  ADD KEY `conf_user` (`conf_user`);

--
-- Indexes for table `supp_forget`
--
ALTER TABLE `supp_forget`
  ADD PRIMARY KEY (`for_id`),
  ADD KEY `for_user` (`for_user`);

--
-- Indexes for table `supp_notification`
--
ALTER TABLE `supp_notification`
  ADD PRIMARY KEY (`noti_id`),
  ADD KEY `noti_user` (`noti_user`);

--
-- Indexes for table `supp_pages`
--
ALTER TABLE `supp_pages`
  ADD PRIMARY KEY (`page_id`),
  ADD UNIQUE KEY `page` (`page_class`,`page`);

--
-- Indexes for table `supp_permission_groups`
--
ALTER TABLE `supp_permission_groups`
  ADD PRIMARY KEY (`per_id`),
  ADD KEY `fkey_create` (`create_by`),
  ADD KEY `fkey_update` (`update_by`),
  ADD KEY `per_default_page` (`per_default_page`);

--
-- Indexes for table `supp_per_group_pages`
--
ALTER TABLE `supp_per_group_pages`
  ADD PRIMARY KEY (`per_group_permission`,`per_group_page`),
  ADD KEY `fkey_create` (`create_by`),
  ADD KEY `per_gr_page_pages` (`per_group_page`);

--
-- Indexes for table `supp_specialist`
--
ALTER TABLE `supp_specialist`
  ADD PRIMARY KEY (`spe_id`),
  ADD KEY `update_by` (`update_by`),
  ADD KEY `create_by` (`create_by`);

--
-- Indexes for table `supp_staff`
--
ALTER TABLE `supp_staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `staff_permission` (`staff_permission`),
  ADD KEY `staff_spe` (`staff_spe`);

--
-- Indexes for table `supp_support`
--
ALTER TABLE `supp_support`
  ADD PRIMARY KEY (`supp_id`),
  ADD KEY `supp_type` (`supp_type`),
  ADD KEY `supp_accept_by` (`supp_accept_by`),
  ADD KEY `supp_area` (`supp_area`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `supp_area`
--
ALTER TABLE `supp_area`
  MODIFY `area_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `supp_forget`
--
ALTER TABLE `supp_forget`
  MODIFY `for_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supp_notification`
--
ALTER TABLE `supp_notification`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supp_pages`
--
ALTER TABLE `supp_pages`
  MODIFY `page_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `supp_permission_groups`
--
ALTER TABLE `supp_permission_groups`
  MODIFY `per_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `supp_specialist`
--
ALTER TABLE `supp_specialist`
  MODIFY `spe_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `supp_staff`
--
ALTER TABLE `supp_staff`
  MODIFY `staff_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `supp_support`
--
ALTER TABLE `supp_support`
  MODIFY `supp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `supp_per_group_pages`
--
ALTER TABLE `supp_per_group_pages`
  ADD CONSTRAINT `staff_page` FOREIGN KEY (`per_group_page`) REFERENCES `supp_pages` (`page_id`),
  ADD CONSTRAINT `staff_permission` FOREIGN KEY (`per_group_permission`) REFERENCES `supp_permission_groups` (`per_id`);

--
-- Constraints for table `supp_specialist`
--
ALTER TABLE `supp_specialist`
  ADD CONSTRAINT `spe_create` FOREIGN KEY (`create_by`) REFERENCES `supp_staff` (`staff_id`),
  ADD CONSTRAINT `spe_update` FOREIGN KEY (`update_by`) REFERENCES `supp_staff` (`staff_id`);

--
-- Constraints for table `supp_staff`
--
ALTER TABLE `supp_staff`
  ADD CONSTRAINT `staff_spe` FOREIGN KEY (`staff_spe`) REFERENCES `supp_specialist` (`spe_id`);

--
-- Constraints for table `supp_support`
--
ALTER TABLE `supp_support`
  ADD CONSTRAINT `supp_accept` FOREIGN KEY (`supp_accept_by`) REFERENCES `supp_staff` (`staff_id`),
  ADD CONSTRAINT `supp_type` FOREIGN KEY (`supp_type`) REFERENCES `supp_specialist` (`spe_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
