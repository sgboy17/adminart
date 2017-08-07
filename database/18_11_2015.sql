-- --------------------------------------------------------
-- Host:                         192.168.1.113
-- Server version:               5.6.27 - Homebrew
-- Server OS:                    osx10.11
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for masterkid_local
CREATE DATABASE IF NOT EXISTS `masterkid_local` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `masterkid_local`;


-- Dumping structure for table masterkid_local.mk_action
CREATE TABLE IF NOT EXISTS `mk_action` (
  `action_id` char(36) NOT NULL,
  `branch_id` int(11) NOT NULL COMMENT 'Trung tâm',
  `object_id` char(36) NOT NULL COMMENT 'Object',
  `action` varchar(255) NOT NULL COMMENT 'Thao tác',
  `from` varchar(255) DEFAULT NULL COMMENT 'Từ',
  `to` varchar(255) DEFAULT NULL COMMENT 'Đến',
  `note` text COMMENT 'Ghi chú',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Tạo ngày',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`action_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `mk_action_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `mk_branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Thao tác';

-- Dumping data for table masterkid_local.mk_action: ~0 rows (approximately)
DELETE FROM `mk_action`;
/*!40000 ALTER TABLE `mk_action` DISABLE KEYS */;
/*!40000 ALTER TABLE `mk_action` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_branch
CREATE TABLE IF NOT EXISTS `mk_branch` (
  `branch_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL COMMENT 'kho mặc định',
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã chi nhánh',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên chi nhánh',
  `branch_type_id` int(11) NOT NULL COMMENT 'loại chi nhánh',
  `employee_id` int(11) NOT NULL COMMENT 'nhân viên',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `country_id` int(11) NOT NULL COMMENT 'quốc gia',
  `city_id` int(11) NOT NULL COMMENT 'thành phố',
  `district_id` int(11) NOT NULL COMMENT 'quận huyện',
  `address` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'địa chỉ',
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'email',
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'điện thoại',
  `fax` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'fax',
  `website` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'website',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`branch_id`),
  KEY `fk_kk_branch_kk_store1_idx` (`store_id`),
  KEY `fk_kk_branch_kk_branch_type1_idx` (`branch_type_id`),
  KEY `fk_kk_branch_kk_country1_idx` (`country_id`),
  KEY `fk_kk_branch_kk_city1_idx` (`city_id`),
  KEY `fk_kk_branch_kk_district1_idx` (`district_id`),
  KEY `fk_kk_branch_kk_employee1_idx` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Chi nhánh';

-- Dumping data for table masterkid_local.mk_branch: ~5 rows (approximately)
DELETE FROM `mk_branch`;
/*!40000 ALTER TABLE `mk_branch` DISABLE KEYS */;
INSERT INTO `mk_branch` (`branch_id`, `store_id`, `code`, `name`, `branch_type_id`, `employee_id`, `note`, `country_id`, `city_id`, `district_id`, `address`, `email`, `phone`, `fax`, `website`, `status`, `deleted`) VALUES
	(1, 1, 'MKC', 'Trụ sở Chính', 1, 0, '', 1, 52, 472, '584 Huỳnh Tấn Phát P.Tân Phú', 'topartvn@gmail.com', '0973 866 270 ', '', 'http://facebook.com/topartvn', 1, 0),
	(4, 2, 'MKQ5', 'MasterKid Q5', 2, 1, '', 1, 52, 470, 'Lầu 5 Hùng Vương Plaza - 126 Hùng Vương P.4', 'hungvuong@topartvn.com', '(08) 221.147.868', '', '', 1, 0),
	(5, 7, 'MKBHQ10', 'MasterKid Bắc Hải - Q10', 2, 0, '', 1, 52, 467, '139 Bắc Hải P.14', 'nhathieunhiq10@topartvn.com', '(08) 221.95.389', '', '', 1, 0),
	(6, 8, 'MK32Q10', 'MasterKid 3/2 Q10', 2, 0, '', 1, 52, 467, 'Lầu 7 Tòa nhà Aston, 614-616-618 Đường 3/2 P.14', '', '(08) 668.12.326', '', '', 1, 0),
	(7, 9, 'MKKH', 'MasterKid Khánh Hòa', 2, 0, '', 1, 39, 353, '62, Thái Nguyên', 'nhatrang@topartvn.com', '058.62 555 66', '', '', 1, 0);
/*!40000 ALTER TABLE `mk_branch` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_branch_fee
CREATE TABLE IF NOT EXISTS `mk_branch_fee` (
  `branch_fee_id` char(36) NOT NULL,
  `branch_id` int(11) NOT NULL COMMENT 'Trung tâm',
  `name` varchar(255) DEFAULT NULL COMMENT 'chi phí',
  `price` float DEFAULT NULL COMMENT 'Giá',
  `type` varchar(255) DEFAULT NULL COMMENT 'Loại',
  `unit` varchar(255) DEFAULT NULL COMMENT 'Đơn vị',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'trạng thái| 1/Active - 2/Inactive',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày tạo',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày sửa',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`branch_fee_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `mk_branch_fee_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `mk_branch` (`branch_id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Chi phí';

-- Dumping data for table masterkid_local.mk_branch_fee: ~0 rows (approximately)
DELETE FROM `mk_branch_fee`;
/*!40000 ALTER TABLE `mk_branch_fee` DISABLE KEYS */;
/*!40000 ALTER TABLE `mk_branch_fee` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_city
CREATE TABLE IF NOT EXISTS `mk_city` (
  `city_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL COMMENT 'quốc gia',
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã',
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`city_id`),
  KEY `fk_kk_city_kk_country1_idx` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Thành phố\n';

-- Dumping data for table masterkid_local.mk_city: ~63 rows (approximately)
DELETE FROM `mk_city`;
/*!40000 ALTER TABLE `mk_city` DISABLE KEYS */;
INSERT INTO `mk_city` (`city_id`, `country_id`, `code`, `name`, `deleted`) VALUES
	(3, 1, '1', 'Thành phố Hà Nội', 0),
	(4, 1, '2', 'Tỉnh Hà Giang', 0),
	(5, 1, '4', 'Tỉnh Cao Bằng', 0),
	(6, 1, '6', 'Tỉnh Bắc Kạn', 0),
	(7, 1, '8', 'Tỉnh Tuyên Quang', 0),
	(8, 1, '10', 'Tỉnh Lào Cai', 0),
	(9, 1, '11', 'Tỉnh Điện Biên', 0),
	(10, 1, '12', 'Tỉnh Lai Châu', 0),
	(11, 1, '14', 'Tỉnh Sơn La', 0),
	(12, 1, '15', 'Tỉnh Yên Bái', 0),
	(13, 1, '17', 'Tỉnh Hoà Bình', 0),
	(14, 1, '19', 'Tỉnh Thái Nguyên', 0),
	(15, 1, '20', 'Tỉnh Lạng Sơn', 0),
	(16, 1, '22', 'Tỉnh Quảng Ninh', 0),
	(17, 1, '24', 'Tỉnh Bắc Giang', 0),
	(18, 1, '25', 'Tỉnh Phú Thọ', 0),
	(19, 1, '26', 'Tỉnh Vĩnh Phúc', 0),
	(20, 1, '27', 'Tỉnh Bắc Ninh', 0),
	(21, 1, '30', 'Tỉnh Hải Dương', 0),
	(22, 1, '31', 'Thành phố Hải Phòng', 0),
	(23, 1, '33', 'Tỉnh Hưng Yên', 0),
	(24, 1, '34', 'Tỉnh Thái Bình', 0),
	(25, 1, '35', 'Tỉnh Hà Nam', 0),
	(26, 1, '36', 'Tỉnh Nam Định', 0),
	(27, 1, '37', 'Tỉnh Ninh Bình', 0),
	(28, 1, '38', 'Tỉnh Thanh Hóa', 0),
	(29, 1, '40', 'Tỉnh Nghệ An', 0),
	(30, 1, '42', 'Tỉnh Hà Tĩnh', 0),
	(31, 1, '44', 'Tỉnh Quảng Bình', 0),
	(32, 1, '45', 'Tỉnh Quảng Trị', 0),
	(33, 1, '46', 'Tỉnh Thừa Thiên Huế', 0),
	(34, 1, '48', 'Thành phố Đà Nẵng', 0),
	(35, 1, '49', 'Tỉnh Quảng Nam', 0),
	(36, 1, '51', 'Tỉnh Quảng Ngãi', 0),
	(37, 1, '52', 'Tỉnh Bình Định', 0),
	(38, 1, '54', 'Tỉnh Phú Yên', 0),
	(39, 1, '56', 'Tỉnh Khánh Hòa', 0),
	(40, 1, '58', 'Tỉnh Ninh Thuận', 0),
	(41, 1, '60', 'Tỉnh Bình Thuận', 0),
	(42, 1, '62', 'Tỉnh Kon Tum', 0),
	(43, 1, '64', 'Tỉnh Gia Lai', 0),
	(44, 1, '66', 'Tỉnh Đắk Lắk', 0),
	(45, 1, '67', 'Tỉnh Đắk Nông', 0),
	(46, 1, '68', 'Tỉnh Lâm Đồng', 0),
	(47, 1, '70', 'Tỉnh Bình Phước', 0),
	(48, 1, '72', 'Tỉnh Tây Ninh', 0),
	(49, 1, '74', 'Tỉnh Bình Dương', 0),
	(50, 1, '75', 'Tỉnh Đồng Nai', 0),
	(51, 1, '77', 'Tỉnh Bà Rịa - Vũng Tàu', 0),
	(52, 1, '79', 'Thành phố Hồ Chí Minh', 0),
	(53, 1, '80', 'Tỉnh Long An', 0),
	(54, 1, '82', 'Tỉnh Tiền Giang', 0),
	(55, 1, '83', 'Tỉnh Bến Tre', 0),
	(56, 1, '84', 'Tỉnh Trà Vinh', 0),
	(57, 1, '86', 'Tỉnh Vĩnh Long', 0),
	(58, 1, '87', 'Tỉnh Đồng Tháp', 0),
	(59, 1, '89', 'Tỉnh An Giang', 0),
	(60, 1, '91', 'Tỉnh Kiên Giang', 0),
	(61, 1, '92', 'Thành phố Cần Thơ', 0),
	(62, 1, '93', 'Tỉnh Hậu Giang', 0),
	(63, 1, '94', 'Tỉnh Sóc Trăng', 0),
	(64, 1, '95', 'Tỉnh Bạc Liêu', 0),
	(65, 1, '96', 'Tỉnh Cà Mau', 0);
/*!40000 ALTER TABLE `mk_city` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_class
CREATE TABLE IF NOT EXISTS `mk_class` (
  `class_id` char(36) NOT NULL,
  `branch_id` int(11) NOT NULL COMMENT 'Trung tâm',
  `program_id` char(36) NOT NULL COMMENT 'Chương trình học',
  `teacher_id` char(36) NOT NULL COMMENT 'Giáo viên',
  `name` varchar(255) DEFAULT NULL COMMENT 'Tên lớp',
  `class_code` varchar(255) DEFAULT NULL COMMENT 'Mã lớp',
  `type` varchar(255) DEFAULT NULL COMMENT 'Loại',
  `date_start` date DEFAULT NULL COMMENT 'Ngày bắt đầu',
  `date_end` date DEFAULT NULL COMMENT 'Ngày kết thúc',
  `day_in_week` varchar(255) DEFAULT NULL,
  `current_num_student` tinyint(5) DEFAULT NULL COMMENT 'Số học viên hiện tại',
  `note` varchar(255) DEFAULT NULL COMMENT 'Ghi chú',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'trạng thái| 1/Active - 2/Inactive',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày tạo',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày sửa',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`class_id`),
  KEY `branch_id` (`branch_id`),
  KEY `program_id` (`program_id`),
  KEY `teacher_id` (`teacher_id`),
  CONSTRAINT `mk_class_ibfk_2` FOREIGN KEY (`program_id`) REFERENCES `mk_program` (`program_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mk_class_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `mk_teacher` (`teacher_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Lớp (nhóm)';

-- Dumping data for table masterkid_local.mk_class: ~1 rows (approximately)
DELETE FROM `mk_class`;
/*!40000 ALTER TABLE `mk_class` DISABLE KEYS */;
INSERT INTO `mk_class` (`class_id`, `branch_id`, `program_id`, `teacher_id`, `name`, `class_code`, `type`, `date_start`, `date_end`, `day_in_week`, `current_num_student`, `note`, `status`, `created_at`, `updated_at`, `deleted`) VALUES
	('d4771ea8-e639-44dd-ad04-16cde635329c', 0, '26107501-b117-41c6-9867-1a1174970143', '239b8d4e-840c-4a6c-8445-015238abd1ce', '0', 'cs1', '1', '2015-11-01', NULL, NULL, 0, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);
/*!40000 ALTER TABLE `mk_class` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_class_hour
CREATE TABLE IF NOT EXISTS `mk_class_hour` (
  `class_hour_id` char(36) NOT NULL,
  `room_id` char(36) NOT NULL COMMENT 'Phòng học',
  `class_id` char(36) NOT NULL COMMENT 'Lớp học',
  `from_time` varchar(255) DEFAULT NULL COMMENT 'Thời gian từ',
  `to_time` varchar(255) DEFAULT NULL COMMENT 'Thời gian đến',
  `date_id` tinyint(1) DEFAULT NULL COMMENT 'Ngày',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'trạng thái| 1/Active - 2/Inactive',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày tạo',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày sửa',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`class_hour_id`),
  KEY `room_id` (`room_id`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `mk_class_hour_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `mk_room` (`room_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mk_class_hour_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `mk_class` (`class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Giờ học';

-- Dumping data for table masterkid_local.mk_class_hour: ~0 rows (approximately)
DELETE FROM `mk_class_hour`;
/*!40000 ALTER TABLE `mk_class_hour` DISABLE KEYS */;
/*!40000 ALTER TABLE `mk_class_hour` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_country
CREATE TABLE IF NOT EXISTS `mk_country` (
  `country_id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã',
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Quốc gia';

-- Dumping data for table masterkid_local.mk_country: ~1 rows (approximately)
DELETE FROM `mk_country`;
/*!40000 ALTER TABLE `mk_country` DISABLE KEYS */;
INSERT INTO `mk_country` (`country_id`, `code`, `name`, `deleted`) VALUES
	(1, 'vn', 'Việt Nam', 0);
/*!40000 ALTER TABLE `mk_country` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_date_off
CREATE TABLE IF NOT EXISTS `mk_date_off` (
  `date_off_id` char(36) NOT NULL,
  `branch_id` int(11) NOT NULL COMMENT 'Trung tâm',
  `date` date NOT NULL COMMENT 'Ngày nghỉ',
  `note` text COMMENT 'Ghi chú',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'trạng thái| 1/Active - 2/Inactive',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày tạo',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày sửa',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`date_off_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `mk_date_off_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `mk_branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Ngày nghỉ';

-- Dumping data for table masterkid_local.mk_date_off: ~0 rows (approximately)
DELETE FROM `mk_date_off`;
/*!40000 ALTER TABLE `mk_date_off` DISABLE KEYS */;
/*!40000 ALTER TABLE `mk_date_off` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_district
CREATE TABLE IF NOT EXISTS `mk_district` (
  `district_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL COMMENT 'thành phố',
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã',
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`district_id`),
  KEY `fk_kk_district_kk_city1_idx` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Quận huyện\n';

-- Dumping data for table masterkid_local.mk_district: ~582 rows (approximately)
DELETE FROM `mk_district`;
/*!40000 ALTER TABLE `mk_district` DISABLE KEYS */;
INSERT INTO `mk_district` (`district_id`, `city_id`, `code`, `name`, `deleted`) VALUES
	(3, 3, '1', 'Quận Ba Đình', 0),
	(4, 3, '2', 'Quận Hoàn Kiếm', 0),
	(5, 3, '4', 'Quận Long Biên', 0),
	(6, 3, '5', 'Quận Cầu Giấy', 0),
	(7, 3, '6', 'Quận Đống Đa', 0),
	(8, 3, '7', 'Quận Hai Bà Trưng', 0),
	(9, 3, '8', 'Quận Hoàng Mai', 0),
	(10, 3, '9', 'Quận Thanh Xuân', 0),
	(11, 3, '16', 'Huyện Sóc Sơn', 0),
	(12, 3, '17', 'Huyện Đông Anh', 0),
	(13, 3, '18', 'Huyện Gia Lâm', 0),
	(14, 3, '19', 'Huyện Từ Liêm', 0),
	(15, 3, '20', 'Huyện Thanh Trì', 0),
	(16, 3, '268', 'Quận Hà Đông', 0),
	(17, 3, '269', 'Thị xã Sơn Tây', 0),
	(18, 3, '271', 'Huyện Ba Vì', 0),
	(19, 3, '272', 'Huyện Phúc Thọ', 0),
	(20, 3, '273', 'Huyện Đan Phượng', 0),
	(21, 3, '274', 'Huyện Hoài Đức', 0),
	(22, 3, '275', 'Huyện Quốc Oai', 0),
	(23, 3, '276', 'Huyện Thạch Thất', 0),
	(24, 3, '277', 'Huyện Chương Mỹ', 0),
	(25, 3, '278', 'Huyện Thanh Oai', 0),
	(26, 3, '279', 'Huyện Thường Tín', 0),
	(27, 3, '280', 'Huyện Phú Xuyên', 0),
	(28, 3, '281', 'Huyện ứng Hòa', 0),
	(29, 4, '24', 'Thị xã Hà Giang', 0),
	(30, 4, '26', 'Huyện Đồng Văn', 0),
	(31, 4, '27', 'Huyện Mèo Vạc', 0),
	(32, 4, '28', 'Huyện Yên Minh', 0),
	(33, 4, '29', 'Huyện Quản Bạ', 0),
	(34, 4, '30', 'Huyện Vị Xuyên', 0),
	(35, 4, '31', 'Huyện Bắc Mê', 0),
	(36, 4, '32', 'Huyện Hoàng Su Phì', 0),
	(37, 4, '33', 'Huyện Xín Mần', 0),
	(38, 4, '34', 'Huyện Bắc Quang', 0),
	(39, 5, '40', 'Thị xã Cao Bằng', 0),
	(40, 5, '43', 'Huyện Bảo Lạc', 0),
	(41, 5, '44', 'Huyện Thông Nông', 0),
	(42, 5, '45', 'Huyện Hà Quảng', 0),
	(43, 5, '46', 'Huyện Trà Lĩnh', 0),
	(44, 5, '47', 'Huyện Trùng Khánh', 0),
	(45, 5, '48', 'Huyện Hạ Lang', 0),
	(46, 5, '49', 'Huyện Quảng Uyên', 0),
	(47, 5, '51', 'Huyện Hoà An', 0),
	(48, 5, '52', 'Huyện Nguyên Bình', 0),
	(49, 6, '58', 'Thị xã Bắc Kạn', 0),
	(50, 6, '61', 'Huyện Ba Bể', 0),
	(51, 6, '63', 'Huyện Bạch Thông', 0),
	(52, 6, '64', 'Huyện Chợ Đồn', 0),
	(53, 6, '65', 'Huyện Chợ Mới', 0),
	(54, 6, '66', 'Huyện Na Rì', 0),
	(55, 7, '70', 'Thị xã Tuyên Quang', 0),
	(56, 7, '72', 'Huyện Nà Hang', 0),
	(57, 7, '73', 'Huyện Chiêm Hóa', 0),
	(58, 7, '74', 'Huyện Hàm Yên', 0),
	(59, 7, '75', 'Huyện Yên Sơn', 0),
	(60, 7, '76', 'Huyện Sơn Dương', 0),
	(61, 8, '80', 'Thành phố Lào Cai', 0),
	(62, 8, '82', 'Huyện Bát Xát', 0),
	(63, 8, '83', 'Huyện Mường Khương', 0),
	(64, 8, '84', 'Huyện Si Ma Cai', 0),
	(65, 8, '85', 'Huyện Bắc Hà', 0),
	(66, 8, '86', 'Huyện Bảo Thắng', 0),
	(67, 8, '87', 'Huyện Bảo Yên', 0),
	(68, 8, '88', 'Huyện Sa Pa', 0),
	(69, 8, '89', 'Huyện Văn Bàn', 0),
	(70, 9, '94', 'Thành phố Điện Biên Phủ', 0),
	(71, 9, '95', 'Thị Xã Mường Lay', 0),
	(72, 9, '96', 'Huyện Mường Nhé', 0),
	(73, 9, '98', 'Huyện Tủa Chùa', 0),
	(74, 9, '99', 'Huyện Tuần Giáo', 0),
	(75, 9, '100', 'Huyện Điện Biên', 0),
	(76, 9, '102', 'Huyện Mường ảng', 0),
	(77, 10, '105', 'Thị xã Lai Châu', 0),
	(78, 10, '106', 'Huyện Tam Đường', 0),
	(79, 10, '108', 'Huyện Sìn Hồ', 0),
	(80, 10, '109', 'Huyện Phong Thổ', 0),
	(81, 10, '111', 'Huyện Tân Uyên', 0),
	(82, 11, '116', 'Thành phố Sơn La', 0),
	(83, 11, '118', 'Huyện Quỳnh Nhai', 0),
	(84, 11, '119', 'Huyện Thuận Châu', 0),
	(85, 11, '120', 'Huyện Mường La', 0),
	(86, 11, '121', 'Huyện Bắc Yên', 0),
	(87, 11, '122', 'Huyện Phù Yên', 0),
	(88, 11, '123', 'Huyện Mộc Châu', 0),
	(89, 11, '124', 'Huyện Yên Châu', 0),
	(90, 11, '125', 'Huyện Mai Sơn', 0),
	(91, 12, '132', 'Thành phố Yên Bái', 0),
	(92, 12, '135', 'Huyện Lục Yên', 0),
	(93, 12, '136', 'Huyện Văn Yên', 0),
	(94, 12, '137', 'Huyện Mù Căng Chải', 0),
	(95, 12, '138', 'Huyện Trấn Yên', 0),
	(96, 12, '139', 'Huyện Trạm Tấu', 0),
	(97, 12, '140', 'Huyện Văn Chấn', 0),
	(98, 12, '141', 'Huyện Yên Bình', 0),
	(99, 13, '148', 'Thành phố Hòa Bình', 0),
	(100, 13, '150', 'Huyện Đà Bắc', 0),
	(101, 13, '151', 'Huyện Kỳ Sơn', 0),
	(102, 13, '152', 'Huyện Lương Sơn', 0),
	(103, 13, '153', 'Huyện Kim Bôi', 0),
	(104, 13, '154', 'Huyện Cao Phong', 0),
	(105, 13, '155', 'Huyện Tân Lạc', 0),
	(106, 13, '156', 'Huyện Mai Châu', 0),
	(107, 13, '157', 'Huyện Lạc Sơn', 0),
	(108, 13, '158', 'Huyện Yên Thủy', 0),
	(109, 14, '164', 'Thành phố Thái Nguyên', 0),
	(110, 14, '165', 'Thị xã Sông Công', 0),
	(111, 14, '167', 'Huyện Định Hóa', 0),
	(112, 14, '168', 'Huyện Phú Lương', 0),
	(113, 14, '169', 'Huyện Đồng Hỷ', 0),
	(114, 14, '170', 'Huyện Võ Nhai', 0),
	(115, 14, '171', 'Huyện Đại Từ', 0),
	(116, 14, '172', 'Huyện Phổ Yên', 0),
	(117, 14, '173', 'Huyện Phú Bình', 0),
	(118, 15, '178', 'Thành phố Lạng Sơn', 0),
	(119, 15, '180', 'Huyện Tràng Định', 0),
	(120, 15, '181', 'Huyện Bình Gia', 0),
	(121, 15, '182', 'Huyện Văn Lãng', 0),
	(122, 15, '183', 'Huyện Cao Lộc', 0),
	(123, 15, '184', 'Huyện Văn Quan', 0),
	(124, 15, '185', 'Huyện Bắc Sơn', 0),
	(125, 15, '186', 'Huyện Hữu Lũng', 0),
	(126, 15, '187', 'Huyện Chi Lăng', 0),
	(127, 15, '188', 'Huyện Lộc Bình', 0),
	(128, 16, '193', 'Thành phố Hạ Long', 0),
	(129, 16, '194', 'Thành phố Móng Cái', 0),
	(130, 16, '195', 'Thị xã Cẩm Phả', 0),
	(131, 16, '196', 'Thị xã Uông Bí', 0),
	(132, 16, '200', 'Huyện Đầm Hà', 0),
	(133, 16, '201', 'Huyện Hải Hà', 0),
	(134, 16, '204', 'Huyện Hoành Bồ', 0),
	(135, 16, '205', 'Huyện Đông Triều', 0),
	(136, 16, '206', 'Huyện Yên Hưng', 0),
	(137, 17, '213', 'Thành phố Bắc Giang', 0),
	(138, 17, '215', 'Huyện Yên Thế', 0),
	(139, 17, '216', 'Huyện Tân Yên', 0),
	(140, 17, '217', 'Huyện Lạng Giang', 0),
	(141, 17, '218', 'Huyện Lục Nam', 0),
	(142, 17, '219', 'Huyện Lục Ngạn', 0),
	(143, 17, '220', 'Huyện Sơn Động', 0),
	(144, 17, '221', 'Huyện Yên Dũng', 0),
	(145, 17, '222', 'Huyện Việt Yên', 0),
	(146, 18, '227', 'Thành phố Việt Trì', 0),
	(147, 18, '228', 'Thị xã Phú Thọ', 0),
	(148, 18, '230', 'Huyện Đoan Hùng', 0),
	(149, 18, '231', 'Huyện Hạ Hoà', 0),
	(150, 18, '232', 'Huyện Thanh Ba', 0),
	(151, 18, '233', 'Huyện Phù Ninh', 0),
	(152, 18, '234', 'Huyện Yên Lập', 0),
	(153, 18, '235', 'Huyện Cẩm Khê', 0),
	(154, 18, '236', 'Huyện Tam Nông', 0),
	(155, 18, '237', 'Huyện Lâm Thao', 0),
	(156, 18, '238', 'Huyện Thanh Sơn', 0),
	(157, 18, '240', 'Huyện Tân Sơn', 0),
	(158, 19, '243', 'Thành phố Vĩnh Yên', 0),
	(159, 19, '244', 'Thị xã Phúc Yên', 0),
	(160, 19, '246', 'Huyện Lập Thạch', 0),
	(161, 19, '247', 'Huyện Tam Dương', 0),
	(162, 19, '248', 'Huyện Tam Đảo', 0),
	(163, 19, '249', 'Huyện Bình Xuyên', 0),
	(164, 19, '251', 'Huyện Yên Lạc', 0),
	(165, 19, '252', 'Huyện Vĩnh Tường', 0),
	(166, 19, '253', 'Huyện Sông Lô', 0),
	(167, 20, '256', 'Thành phố Bắc Ninh', 0),
	(168, 20, '258', 'Huyện Yên Phong', 0),
	(169, 20, '259', 'Huyện Quế Võ', 0),
	(170, 20, '260', 'Huyện Tiên Du', 0),
	(171, 20, '261', 'Thị xã Từ Sơn', 0),
	(172, 20, '262', 'Huyện Thuận Thành', 0),
	(173, 20, '263', 'Huyện Gia Bình', 0),
	(174, 20, '264', 'Huyện Lương Tài', 0),
	(175, 21, '288', 'Thành phố Hải Dương', 0),
	(176, 21, '290', 'Huyện Chí Linh', 0),
	(177, 21, '291', 'Huyện Nam Sách', 0),
	(178, 21, '292', 'Huyện Kinh Môn', 0),
	(179, 21, '293', 'Huyện Kim Thành', 0),
	(180, 21, '294', 'Huyện Thanh Hà', 0),
	(181, 21, '295', 'Huyện Cẩm Giàng', 0),
	(182, 21, '296', 'Huyện Bình Giang', 0),
	(183, 21, '297', 'Huyện Gia Lộc', 0),
	(184, 21, '298', 'Huyện Tứ Kỳ', 0),
	(185, 21, '299', 'Huyện Ninh Giang', 0),
	(186, 21, '300', 'Huyện Thanh Miện', 0),
	(187, 22, '303', 'Quận Hồng Bàng', 0),
	(188, 22, '304', 'Quận Ngô Quyền', 0),
	(189, 22, '305', 'Quận Lê Chân', 0),
	(190, 22, '306', 'Quận Hải An', 0),
	(191, 22, '307', 'Quận Kiến An', 0),
	(192, 22, '308', 'Quận Đồ Sơn', 0),
	(193, 22, '309', 'Quận Dương Kinh', 0),
	(194, 22, '311', 'Huyện Thuỷ Nguyên', 0),
	(195, 22, '313', 'Huyện An Lão', 0),
	(196, 22, '314', 'Huyện Kiến Thuỵ', 0),
	(197, 22, '315', 'Huyện Tiên Lãng', 0),
	(198, 22, '316', 'Huyện Vĩnh Bảo', 0),
	(199, 23, '325', 'Huyện Văn Lâm', 0),
	(200, 23, '326', 'Huyện Văn Giang', 0),
	(201, 23, '327', 'Huyện Yên Mỹ', 0),
	(202, 23, '328', 'Huyện Mỹ Hào', 0),
	(203, 23, '329', 'Huyện Ân Thi', 0),
	(204, 23, '330', 'Huyện Khoái Châu', 0),
	(205, 23, '331', 'Huyện Kim Động', 0),
	(206, 23, '332', 'Huyện Tiên Lữ', 0),
	(207, 23, '333', 'Huyện Phù Cừ', 0),
	(208, 24, '336', 'Thành phố Thái Bình', 0),
	(209, 24, '338', 'Huyện Quỳnh Phụ', 0),
	(210, 24, '339', 'Huyện Hưng Hà', 0),
	(211, 24, '340', 'Huyện Đông Hưng', 0),
	(212, 24, '341', 'Huyện Thái Thụy', 0),
	(213, 24, '342', 'Huyện Tiền Hải', 0),
	(214, 24, '343', 'Huyện Kiến Xương', 0),
	(215, 24, '344', 'Huyện Vũ Thư', 0),
	(216, 25, '349', 'Huyện Duy Tiên', 0),
	(217, 25, '350', 'Huyện Kim Bảng', 0),
	(218, 25, '351', 'Huyện Thanh Liêm', 0),
	(219, 25, '352', 'Huyện Bình Lục', 0),
	(220, 25, '353', 'Huyện Lý Nhân', 0),
	(221, 26, '356', 'Thành phố Nam Định', 0),
	(222, 26, '358', 'Huyện Mỹ Lộc', 0),
	(223, 26, '359', 'Huyện Vụ Bản', 0),
	(224, 26, '360', 'Huyện ý Yên', 0),
	(225, 26, '361', 'Huyện Nghĩa Hưng', 0),
	(226, 26, '362', 'Huyện Nam Trực', 0),
	(227, 26, '363', 'Huyện Trực Ninh', 0),
	(228, 26, '364', 'Huyện Xuân Trường', 0),
	(229, 26, '365', 'Huyện Giao Thủy', 0),
	(230, 26, '366', 'Huyện Hải Hậu', 0),
	(231, 27, '369', 'Thành phố Ninh Bình', 0),
	(232, 27, '370', 'Thị xã Tam Điệp', 0),
	(233, 27, '372', 'Huyện Nho Quan', 0),
	(234, 27, '373', 'Huyện Gia Viễn', 0),
	(235, 27, '374', 'Huyện Hoa Lư', 0),
	(236, 27, '375', 'Huyện Yên Khánh', 0),
	(237, 27, '376', 'Huyện Kim Sơn', 0),
	(238, 27, '377', 'Huyện Yên Mô', 0),
	(239, 28, '380', 'Thành phố Thanh Hóa', 0),
	(240, 28, '384', 'Huyện Mường Lát', 0),
	(241, 28, '386', 'Huyện Bá Thước', 0),
	(242, 28, '389', 'Huyện Ngọc Lặc', 0),
	(243, 28, '391', 'Huyện Thạch Thành', 0),
	(244, 28, '392', 'Huyện Hà Trung', 0),
	(245, 28, '394', 'Huyện Yên Định', 0),
	(246, 28, '395', 'Huyện Thọ Xuân', 0),
	(247, 28, '397', 'Huyện Triệu Sơn', 0),
	(248, 28, '398', 'Huyện Thiệu Hóa', 0),
	(249, 28, '400', 'Huyện Hậu Lộc', 0),
	(250, 28, '401', 'Huyện Nga Sơn', 0),
	(251, 28, '403', 'Huyện Như Thanh', 0),
	(252, 28, '405', 'Huyện Đông Sơn', 0),
	(253, 28, '406', 'Huyện Quảng Xương', 0),
	(254, 29, '412', 'Thành phố Vinh', 0),
	(255, 29, '413', 'Thị xã Cửa Lò', 0),
	(256, 29, '414', 'Thị xã Thái Hoà', 0),
	(257, 29, '417', 'Huyện Kỳ Sơn', 0),
	(258, 29, '418', 'Huyện Tương Dương', 0),
	(259, 29, '419', 'Huyện Nghĩa Đàn', 0),
	(260, 29, '420', 'Huyện Quỳ Hợp', 0),
	(261, 29, '421', 'Huyện Quỳnh Lưu', 0),
	(262, 29, '422', 'Huyện Con Cuông', 0),
	(263, 29, '424', 'Huyện Anh Sơn', 0),
	(264, 29, '425', 'Huyện Diễn Châu', 0),
	(265, 29, '426', 'Huyện Yên Thành', 0),
	(266, 29, '427', 'Huyện Đô Lương', 0),
	(267, 29, '428', 'Huyện Thanh Chương', 0),
	(268, 29, '429', 'Huyện Nghi Lộc', 0),
	(269, 29, '431', 'Huyện Hưng Nguyên', 0),
	(270, 30, '436', 'Thành phố Hà Tĩnh', 0),
	(271, 30, '439', 'Huyện Hương Sơn', 0),
	(272, 30, '440', 'Huyện Đức Thọ', 0),
	(273, 30, '442', 'Huyện Nghi Xuân', 0),
	(274, 30, '443', 'Huyện Can Lộc', 0),
	(275, 30, '444', 'Huyện Hương Khê', 0),
	(276, 30, '445', 'Huyện Thạch Hà', 0),
	(277, 30, '446', 'Huyện Cẩm Xuyên', 0),
	(278, 30, '447', 'Huyện Kỳ Anh', 0),
	(279, 30, '448', 'Huyện Lộc Hà', 0),
	(280, 31, '450', 'Thành Phố Đồng Hới', 0),
	(281, 31, '452', 'Huyện Minh Hóa', 0),
	(282, 31, '453', 'Huyện Tuyên Hóa', 0),
	(283, 31, '454', 'Huyện Quảng Trạch', 0),
	(284, 31, '455', 'Huyện Bố Trạch', 0),
	(285, 31, '456', 'Huyện Quảng Ninh', 0),
	(286, 31, '457', 'Huyện Lệ Thủy', 0),
	(287, 32, '461', 'Thị xã Đông Hà', 0),
	(288, 32, '462', 'Thị xã Quảng Trị', 0),
	(289, 32, '464', 'Huyện Vĩnh Linh', 0),
	(290, 32, '465', 'Huyện Hướng Hóa', 0),
	(291, 32, '466', 'Huyện Gio Linh', 0),
	(292, 32, '467', 'Huyện Đa Krông', 0),
	(293, 32, '469', 'Huyện Triệu Phong', 0),
	(294, 32, '470', 'Huyện Hải Lăng', 0),
	(295, 33, '474', 'Thành phố Huế', 0),
	(296, 33, '476', 'Huyện Phong Điền', 0),
	(297, 33, '477', 'Huyện Quảng Điền', 0),
	(298, 33, '478', 'Huyện Phú Vang', 0),
	(299, 33, '479', 'Huyện Hương Thủy', 0),
	(300, 33, '480', 'Huyện Hương Trà', 0),
	(301, 33, '481', 'Huyện A Lưới', 0),
	(302, 33, '482', 'Huyện Phú Lộc', 0),
	(303, 33, '483', 'Huyện Nam Đông', 0),
	(304, 34, '490', 'Quận Liên Chiểu', 0),
	(305, 34, '491', 'Quận Thanh Khê', 0),
	(306, 34, '492', 'Quận Hải Châu', 0),
	(307, 34, '494', 'Quận Ngũ Hành Sơn', 0),
	(308, 34, '495', 'Quận Cẩm Lệ', 0),
	(309, 34, '497', 'Huyện Hòa Vang', 0),
	(310, 35, '502', 'Thành phố Tam Kỳ', 0),
	(311, 35, '503', 'Thành phố Hội An', 0),
	(312, 35, '504', 'Huyện Tây Giang', 0),
	(313, 35, '506', 'Huyện Đại Lộc', 0),
	(314, 35, '507', 'Huyện Điện Bàn', 0),
	(315, 35, '508', 'Huyện Duy Xuyên', 0),
	(316, 35, '509', 'Huyện Quế Sơn', 0),
	(317, 35, '511', 'Huyện Phước Sơn', 0),
	(318, 35, '512', 'Huyện Hiệp Đức', 0),
	(319, 35, '513', 'Huyện Thăng Bình', 0),
	(320, 35, '514', 'Huyện Tiên Phước', 0),
	(321, 35, '515', 'Huyện Bắc Trà My', 0),
	(322, 35, '516', 'Huyện Nam Trà My', 0),
	(323, 35, '517', 'Huyện Núi Thành', 0),
	(324, 35, '518', 'Huyện Phú Ninh', 0),
	(325, 36, '522', 'Thành phố Quảng Ngãi', 0),
	(326, 36, '524', 'Huyện Bình Sơn', 0),
	(327, 36, '525', 'Huyện Trà Bồng', 0),
	(328, 36, '526', 'Huyện Tây Trà', 0),
	(329, 36, '527', 'Huyện Sơn Tịnh', 0),
	(330, 36, '528', 'Huyện Tư Nghĩa', 0),
	(331, 36, '529', 'Huyện Sơn Hà', 0),
	(332, 36, '530', 'Huyện Sơn Tây', 0),
	(333, 36, '531', 'Huyện Minh Long', 0),
	(334, 36, '533', 'Huyện Mộ Đức', 0),
	(335, 36, '534', 'Huyện Đức Phổ', 0),
	(336, 36, '535', 'Huyện Ba Tơ', 0),
	(337, 37, '540', 'Thành phố Qui Nhơn', 0),
	(338, 37, '542', 'Huyện An Lão', 0),
	(339, 37, '543', 'Huyện Hoài Nhơn', 0),
	(340, 37, '544', 'Huyện Hoài Ân', 0),
	(341, 37, '545', 'Huyện Phù Mỹ', 0),
	(342, 37, '546', 'Huyện Vĩnh Thạnh', 0),
	(343, 37, '547', 'Huyện Tây Sơn', 0),
	(344, 37, '548', 'Huyện Phù Cát', 0),
	(345, 37, '549', 'Huyện An Nhơn', 0),
	(346, 38, '555', 'Thành phố Tuy Hoà', 0),
	(347, 38, '557', 'Huyện Sông Cầu', 0),
	(348, 38, '558', 'Huyện Đồng Xuân', 0),
	(349, 38, '559', 'Huyện Tuy An', 0),
	(350, 38, '560', 'Huyện Sơn Hòa', 0),
	(351, 38, '561', 'Huyện Sông Hinh', 0),
	(352, 38, '562', 'Huyện Tây Hoà', 0),
	(353, 39, '568', 'Thành phố Nha Trang', 0),
	(354, 39, '569', 'Thị xã Cam Ranh', 0),
	(355, 39, '570', 'Huyện Cam Lâm', 0),
	(356, 39, '571', 'Huyện Vạn Ninh', 0),
	(357, 39, '572', 'Huyện Ninh Hòa', 0),
	(358, 39, '573', 'Huyện Khánh Vĩnh', 0),
	(359, 39, '574', 'Huyện Diên Khánh', 0),
	(360, 39, '575', 'Huyện Khánh Sơn', 0),
	(361, 40, '582', 'Thành phố Phan Rang-Tháp Chàm', 0),
	(362, 40, '584', 'Huyện Bác ái', 0),
	(363, 40, '585', 'Huyện Ninh Sơn', 0),
	(364, 40, '586', 'Huyện Ninh Hải', 0),
	(365, 40, '587', 'Huyện Ninh Phước', 0),
	(366, 41, '593', 'Thành phố Phan Thiết', 0),
	(367, 41, '594', 'Thị xã La Gi', 0),
	(368, 41, '595', 'Huyện Tuy Phong', 0),
	(369, 41, '596', 'Huyện Bắc Bình', 0),
	(370, 41, '597', 'Huyện Hàm Thuận Bắc', 0),
	(371, 41, '598', 'Huyện Hàm Thuận Nam', 0),
	(372, 41, '599', 'Huyện Tánh Linh', 0),
	(373, 41, '600', 'Huyện Đức Linh', 0),
	(374, 42, '608', 'Thị xã Kon Tum', 0),
	(375, 42, '610', 'Huyện Đắk Glei', 0),
	(376, 42, '611', 'Huyện Ngọc Hồi', 0),
	(377, 42, '612', 'Huyện Đắk Tô', 0),
	(378, 42, '613', 'Huyện Kon Plông', 0),
	(379, 42, '614', 'Huyện Kon Rẫy', 0),
	(380, 42, '615', 'Huyện Đắk Hà', 0),
	(381, 42, '616', 'Huyện Sa Thầy', 0),
	(382, 43, '622', 'Thành phố Pleiku', 0),
	(383, 43, '623', 'Thị xã An Khê', 0),
	(384, 43, '624', 'Thị xã Ayun Pa', 0),
	(385, 43, '625', 'Huyện KBang', 0),
	(386, 43, '626', 'Huyện Đăk Đoa', 0),
	(387, 43, '627', 'Huyện Chư Păh', 0),
	(388, 43, '628', 'Huyện Ia Grai', 0),
	(389, 43, '629', 'Huyện Mang Yang', 0),
	(390, 43, '630', 'Huyện Kông Chro', 0),
	(391, 43, '632', 'Huyện Chư Prông', 0),
	(392, 43, '633', 'Huyện Chư Sê', 0),
	(393, 43, '635', 'Huyện Ia Pa', 0),
	(394, 43, '637', 'Huyện Krông Pa', 0),
	(395, 44, '643', 'Thành phố Buôn Ma Thuột', 0),
	(396, 44, '645', 'Huyện Ea H\'leo', 0),
	(397, 44, '649', 'Huyện Krông Búk', 0),
	(398, 44, '650', 'Huyện Krông Năng', 0),
	(399, 44, '653', 'Huyện Krông Bông', 0),
	(400, 45, '660', 'Thị xã Gia Nghĩa', 0),
	(401, 45, '661', 'Huyện Đăk Glong', 0),
	(402, 45, '662', 'Huyện Cư Jút', 0),
	(403, 45, '663', 'Huyện Đắk Mil', 0),
	(404, 45, '665', 'Huyện Đắk Song', 0),
	(405, 45, '666', 'Huyện Đắk R\'Lấp', 0),
	(406, 46, '672', 'Thành phố Đà Lạt', 0),
	(407, 46, '673', 'Thị xã Bảo Lộc', 0),
	(408, 46, '674', 'Huyện Đam Rông', 0),
	(409, 46, '675', 'Huyện Lạc Dương', 0),
	(410, 46, '676', 'Huyện Lâm Hà', 0),
	(411, 46, '677', 'Huyện Đơn Dương', 0),
	(412, 46, '678', 'Huyện Đức Trọng', 0),
	(413, 46, '679', 'Huyện Di Linh', 0),
	(414, 46, '680', 'Huyện Bảo Lâm', 0),
	(415, 46, '681', 'Huyện Đạ Huoai', 0),
	(416, 46, '682', 'Huyện Đạ Tẻh', 0),
	(417, 46, '683', 'Huyện Cát Tiên', 0),
	(418, 47, '689', 'Thị xã Đồng Xoài', 0),
	(419, 47, '691', 'Huyện Phước Long', 0),
	(420, 47, '692', 'Huyện Lộc Ninh', 0),
	(421, 47, '693', 'Huyện Bù Đốp', 0),
	(422, 47, '694', 'Huyện Bình Long', 0),
	(423, 47, '695', 'Huyện Đồng Phù', 0),
	(424, 47, '696', 'Huyện Bù Đăng', 0),
	(425, 48, '703', 'Thị xã Tây Ninh', 0),
	(426, 48, '705', 'Huyện Tân Biên', 0),
	(427, 48, '706', 'Huyện Tân Châu', 0),
	(428, 48, '707', 'Huyện Dương Minh Châu', 0),
	(429, 48, '708', 'Huyện Châu Thành', 0),
	(430, 48, '709', 'Huyện Hòa Thành', 0),
	(431, 48, '710', 'Huyện Gò Dầu', 0),
	(432, 48, '711', 'Huyện Bến Cầu', 0),
	(433, 48, '712', 'Huyện Trảng Bàng', 0),
	(434, 49, '718', 'Thị xã Thủ Dầu Một', 0),
	(435, 49, '720', 'Huyện Dầu Tiếng', 0),
	(436, 49, '721', 'Huyện Bến Cát', 0),
	(437, 49, '722', 'Huyện Phú Giáo', 0),
	(438, 49, '723', 'Huyện Tân Uyên', 0),
	(439, 49, '724', 'Huyện Dĩ An', 0),
	(440, 49, '725', 'Huyện Thuận An', 0),
	(441, 50, '731', 'Thành phố Biên Hòa', 0),
	(442, 50, '732', 'Thị xã Long Khánh', 0),
	(443, 50, '734', 'Huyện Tân Phú', 0),
	(444, 50, '735', 'Huyện Vĩnh Cửu', 0),
	(445, 50, '736', 'Huyện Định Quán', 0),
	(446, 50, '737', 'Huyện Trảng Bom', 0),
	(447, 50, '738', 'Huyện Thống Nhất', 0),
	(448, 50, '739', 'Huyện Cẩm Mỹ', 0),
	(449, 50, '740', 'Huyện Long Thành', 0),
	(450, 50, '741', 'Huyện Xuân Lộc', 0),
	(451, 51, '747', 'Thành phố Vũng Tàu', 0),
	(452, 51, '748', 'Thị xã Bà Rịa', 0),
	(453, 51, '750', 'Huyện Châu Đức', 0),
	(454, 51, '751', 'Huyện Xuyên Mộc', 0),
	(455, 51, '753', 'Huyện Đất Đỏ', 0),
	(456, 52, '760', 'Quận 1', 0),
	(457, 52, '761', 'Quận 12', 0),
	(458, 52, '762', 'Quận Thủ Đức', 0),
	(459, 52, '763', 'Quận 9', 0),
	(460, 52, '764', 'Quận Gò Vấp', 0),
	(461, 52, '765', 'Quận Bình Thạnh', 0),
	(462, 52, '766', 'Quận Tân Bình', 0),
	(463, 52, '767', 'Quận Tân Phú', 0),
	(464, 52, '768', 'Quận Phú Nhuận', 0),
	(465, 52, '769', 'Quận 2', 0),
	(466, 52, '770', 'Quận 3', 0),
	(467, 52, '771', 'Quận 10', 0),
	(468, 52, '772', 'Quận 11', 0),
	(469, 52, '773', 'Quận 4', 0),
	(470, 52, '774', 'Quận 5', 0),
	(471, 52, '775', 'Quận 6', 0),
	(472, 52, '776', 'Quận 8', 0),
	(473, 52, '783', 'Huyện Củ Chi', 0),
	(474, 52, '784', 'Huyện Hóc Môn', 0),
	(475, 52, '785', 'Huyện Bình Chánh', 0),
	(476, 52, '786', 'Huyện Nhà Bè', 0),
	(477, 53, '794', 'Thị xã Tân An', 0),
	(478, 53, '796', 'Huyện Tân Hưng', 0),
	(479, 53, '798', 'Huyện Mộc Hóa', 0),
	(480, 53, '799', 'Huyện Tân Thạnh', 0),
	(481, 53, '800', 'Huyện Thạnh Hóa', 0),
	(482, 53, '801', 'Huyện Đức Huệ', 0),
	(483, 53, '802', 'Huyện Đức Hòa', 0),
	(484, 53, '803', 'Huyện Bến Lức', 0),
	(485, 53, '804', 'Huyện Thủ Thừa', 0),
	(486, 53, '805', 'Huyện Tân Trụ', 0),
	(487, 53, '806', 'Huyện Cần Đước', 0),
	(488, 53, '807', 'Huyện Cần Giuộc', 0),
	(489, 53, '808', 'Huyện Châu Thành', 0),
	(490, 54, '815', 'Thành phố Mỹ Tho', 0),
	(491, 54, '816', 'Thị xã Gò Công', 0),
	(492, 54, '818', 'Huyện Tân Phước', 0),
	(493, 54, '819', 'Huyện Cái Bè', 0),
	(494, 54, '820', 'Huyện Cai Lậy', 0),
	(495, 54, '821', 'Huyện Châu Thành', 0),
	(496, 54, '822', 'Huyện Chợ Gạo', 0),
	(497, 54, '823', 'Huyện Gò Công Tây', 0),
	(498, 55, '829', 'Thị xã Bến Tre', 0),
	(499, 55, '831', 'Huyện Châu Thành', 0),
	(500, 55, '832', 'Huyện Chợ Lách', 0),
	(501, 55, '833', 'Huyện Mỏ Cày', 0),
	(502, 55, '834', 'Huyện Giồng Trôm', 0),
	(503, 55, '835', 'Huyện Bình Đại', 0),
	(504, 55, '836', 'Huyện Ba Tri', 0),
	(505, 55, '837', 'Huyện Thạnh Phú', 0),
	(506, 56, '842', 'Thị xã Trà Vinh', 0),
	(507, 56, '844', 'Huyện Càng Long', 0),
	(508, 56, '845', 'Huyện Cầu Kè', 0),
	(509, 56, '846', 'Huyện Tiểu Cần', 0),
	(510, 56, '847', 'Huyện Châu Thành', 0),
	(511, 56, '848', 'Huyện Cầu Ngang', 0),
	(512, 56, '849', 'Huyện Trà Cú', 0),
	(513, 57, '855', 'Thị xã Vĩnh Long', 0),
	(514, 57, '857', 'Huyện Long Hồ', 0),
	(515, 57, '858', 'Huyện Mang Thít', 0),
	(516, 57, '859', 'Huyện  Vũng Liêm', 0),
	(517, 57, '860', 'Huyện Tam Bình', 0),
	(518, 57, '861', 'Huyện Bình Minh', 0),
	(519, 57, '862', 'Huyện Trà Ôn', 0),
	(520, 58, '866', 'Thành phố Cao Lãnh', 0),
	(521, 58, '867', 'Thị xã Sa Đéc', 0),
	(522, 58, '869', 'Huyện Tân Hồng', 0),
	(523, 58, '870', 'Huyện Hồng Ngự', 0),
	(524, 58, '871', 'Huyện Tam Nông', 0),
	(525, 58, '872', 'Huyện Tháp Mười', 0),
	(526, 58, '873', 'Huyện Cao Lãnh', 0),
	(527, 58, '874', 'Huyện Thanh Bình', 0),
	(528, 58, '875', 'Huyện Lấp Vò', 0),
	(529, 59, '883', 'Thành phố Long Xuyên', 0),
	(530, 59, '884', 'Thị xã Châu Đốc', 0),
	(531, 59, '886', 'Huyện An Phú', 0),
	(532, 59, '887', 'Huyện Tân Châu', 0),
	(533, 59, '888', 'Huyện Phú Tân', 0),
	(534, 59, '889', 'Huyện Châu Phú', 0),
	(535, 59, '890', 'Huyện Tịnh Biên', 0),
	(536, 59, '891', 'Huyện Tri Tôn', 0),
	(537, 59, '892', 'Huyện Châu Thành', 0),
	(538, 59, '893', 'Huyện Chợ Mới', 0),
	(539, 59, '894', 'Huyện Thoại Sơn', 0),
	(540, 60, '899', 'Thành phố Rạch Giá', 0),
	(541, 60, '900', 'Thị xã Hà Tiên', 0),
	(542, 60, '902', 'Huyện Kiên Lương', 0),
	(543, 60, '903', 'Huyện Hòn Đất', 0),
	(544, 60, '904', 'Huyện Tân Hiệp', 0),
	(545, 60, '905', 'Huyện Châu Thành', 0),
	(546, 60, '906', 'Huyện Giồng Riềng', 0),
	(547, 60, '907', 'Huyện Gò Quao', 0),
	(548, 60, '908', 'Huyện An Biên', 0),
	(549, 60, '909', 'Huyện An Minh', 0),
	(550, 60, '910', 'Huyện Vĩnh Thuận', 0),
	(551, 61, '916', 'Quận Ninh Kiều', 0),
	(552, 61, '917', 'Quận Ô Môn', 0),
	(553, 61, '918', 'Quận Bình Thuỷ', 0),
	(554, 61, '919', 'Quận Cái Răng', 0),
	(555, 61, '924', 'Huyện Vĩnh Thạnh', 0),
	(556, 61, '925', 'Huyện Cờ Đỏ', 0),
	(557, 61, '927', 'Huyện Thới Lai', 0),
	(558, 62, '930', 'Thị xã Vị Thanh', 0),
	(559, 62, '931', 'Thị xã Ngã Bảy', 0),
	(560, 62, '932', 'Huyện Châu Thành A', 0),
	(561, 62, '934', 'Huyện Phụng Hiệp', 0),
	(562, 62, '936', 'Huyện Long Mỹ', 0),
	(563, 63, '941', 'Thành phố Sóc Trăng', 0),
	(564, 63, '942', 'Huyện Châu Thành', 0),
	(565, 63, '943', 'Huyện Kế Sách', 0),
	(566, 63, '944', 'Huyện Mỹ Tú', 0),
	(567, 63, '945', 'Huyện Cù Lao Dung', 0),
	(568, 63, '946', 'Huyện Long Phú', 0),
	(569, 63, '947', 'Huyện Mỹ Xuyên', 0),
	(570, 63, '948', 'Huyện Ngã Năm', 0),
	(571, 64, '954', 'Thị xã Bạc Liêu', 0),
	(572, 64, '956', 'Huyện Hồng Dân', 0),
	(573, 64, '957', 'Huyện Phước Long', 0),
	(574, 64, '958', 'Huyện Vĩnh Lợi', 0),
	(575, 64, '959', 'Huyện Giá Rai', 0),
	(576, 64, '960', 'Huyện Đông Hải', 0),
	(577, 64, '961', 'Huyện Hoà Bình', 0),
	(578, 65, '964', 'Thành phố Cà Mau', 0),
	(579, 65, '966', 'Huyện U Minh', 0),
	(580, 65, '967', 'Huyện Thới Bình', 0),
	(581, 65, '968', 'Huyện Trần Văn Thời', 0),
	(582, 65, '969', 'Huyện Cái Nước', 0),
	(583, 65, '970', 'Huyện Đầm Dơi', 0),
	(584, 65, '971', 'Huyện Năm Căn', 0);
/*!40000 ALTER TABLE `mk_district` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_employee
CREATE TABLE IF NOT EXISTS `mk_employee` (
  `employee_id` int(11) NOT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã nhân viên',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên nhân viên',
  `birthday` datetime NOT NULL COMMENT 'ngày sinh',
  `gender` int(11) NOT NULL COMMENT 'giới tính| 1/Nam - 2/Nữ',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `avatar` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'hình đại diện',
  `address` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'địa chỉ',
  `country_id` int(11) NOT NULL COMMENT 'quốc gia',
  `city_id` int(11) NOT NULL COMMENT 'tỉnh/thành',
  `district_id` int(11) NOT NULL COMMENT 'quận/huyện',
  `phone_1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'điện thoại 1',
  `phone_2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'điện thoại 2',
  `email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'email',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`employee_id`),
  KEY `fk_kk_employee_kk_country1_idx` (`country_id`),
  KEY `fk_kk_employee_kk_city1_idx` (`city_id`),
  KEY `fk_kk_employee_kk_district1_idx` (`district_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nhân viên';

-- Dumping data for table masterkid_local.mk_employee: ~1 rows (approximately)
DELETE FROM `mk_employee`;
/*!40000 ALTER TABLE `mk_employee` DISABLE KEYS */;
INSERT INTO `mk_employee` (`employee_id`, `code`, `name`, `birthday`, `gender`, `note`, `avatar`, `address`, `country_id`, `city_id`, `district_id`, `phone_1`, `phone_2`, `email`, `status`, `deleted`) VALUES
	(1, '001', 'Admin1', '1990-08-24 00:00:00', 1, '', '/Image_11-11-2015-01-07-11.png', 'Riviera Point - 584 Huỳnh Tấn Phát P.Tân Phú, Q.7, Tp Hồ Chí Minh', 1, 52, 472, '(08) 224.20.888', '0973 866 270 ', 'topartvn@gmail.com', 1, 0);
/*!40000 ALTER TABLE `mk_employee` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_event
CREATE TABLE IF NOT EXISTS `mk_event` (
  `event_id` char(36) NOT NULL,
  `branch_id` int(11) NOT NULL COMMENT 'Trung tâm',
  `name` varchar(255) NOT NULL COMMENT 'Tên Sự kiện',
  `date_from` datetime NOT NULL COMMENT 'Ngày bắt đầu',
  `date_end` datetime NOT NULL COMMENT 'Ngày kết thúc',
  `discount` int(11) NOT NULL COMMENT 'Chiết khấu',
  `created_at` datetime NOT NULL COMMENT 'Ngày tạo',
  `updated_at` datetime NOT NULL COMMENT 'Ngày sửa',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `mk_event_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `mk_branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Sự kiện Marketing';

-- Dumping data for table masterkid_local.mk_event: ~0 rows (approximately)
DELETE FROM `mk_event`;
/*!40000 ALTER TABLE `mk_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `mk_event` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_invoice
CREATE TABLE IF NOT EXISTS `mk_invoice` (
  `invoice_id` char(36) NOT NULL,
  `branch_id` int(11) NOT NULL COMMENT 'Trung tâm',
  `student_id` char(36) NOT NULL COMMENT 'Học viên',
  `student_class_id` char(36) NOT NULL COMMENT 'Lớp học viên',
  `event_id` char(36) NOT NULL COMMENT 'sự kiện',
  `type` varchar(255) NOT NULL DEFAULT '0' COMMENT 'Loại',
  `sub_total` float DEFAULT NULL COMMENT 'Số tiền',
  `discount` float DEFAULT NULL COMMENT 'Chiết khấu',
  `friend_id` varchar(255) DEFAULT NULL COMMENT 'Bạn giới thiệu',
  `total` float(255,0) DEFAULT NULL COMMENT 'Tổng tiền',
  `note` varchar(255) DEFAULT NULL COMMENT 'Ghi chú',
  `user_id` int(11) DEFAULT NULL COMMENT 'Người tạo',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày tạo',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày sửa',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`invoice_id`),
  KEY `branch_id` (`branch_id`),
  KEY `student_id` (`student_id`),
  KEY `student_class_id` (`student_class_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `mk_invoice_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `mk_branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mk_invoice_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `mk_student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mk_invoice_ibfk_3` FOREIGN KEY (`student_class_id`) REFERENCES `mk_student_class` (`student_class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mk_invoice_ibfk_4` FOREIGN KEY (`event_id`) REFERENCES `mk_event` (`event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Phiếu đăng ký học';

-- Dumping data for table masterkid_local.mk_invoice: ~0 rows (approximately)
DELETE FROM `mk_invoice`;
/*!40000 ALTER TABLE `mk_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `mk_invoice` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_message
CREATE TABLE IF NOT EXISTS `mk_message` (
  `message_id` char(36) NOT NULL,
  `branch_id` int(11) NOT NULL COMMENT 'Trung tâm',
  `title` varchar(255) DEFAULT NULL COMMENT 'Tiêu đề',
  `content` text COMMENT 'Nội dung',
  `date_start` date DEFAULT NULL COMMENT 'Ngày bắt đầu',
  `date_end` date DEFAULT NULL COMMENT 'Ngày kết thúc',
  `user_id` int(11) NOT NULL COMMENT 'Người tạo',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'trạng thái| 1/Active - 2/Inactive',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày tạo',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày sửa',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `mk_message_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `mk_branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Thông báo';

-- Dumping data for table masterkid_local.mk_message: ~0 rows (approximately)
DELETE FROM `mk_message`;
/*!40000 ALTER TABLE `mk_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `mk_message` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_permission
CREATE TABLE IF NOT EXISTS `mk_permission` (
  `permission_id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL COMMENT 'nhóm người dùng',
  `user_id` int(11) NOT NULL COMMENT 'người dùng',
  `permission` text COLLATE utf8_unicode_ci COMMENT 'quyền với từng route (xem, thêm, sửa, xoá)',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`permission_id`),
  KEY `fk_kk_permission_kk_user_group1_idx` (`user_group_id`),
  KEY `fk_kk_permission_kk_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Phân quyền';

-- Dumping data for table masterkid_local.mk_permission: ~3 rows (approximately)
DELETE FROM `mk_permission`;
/*!40000 ALTER TABLE `mk_permission` DISABLE KEYS */;
INSERT INTO `mk_permission` (`permission_id`, `user_group_id`, `user_id`, `permission`, `deleted`) VALUES
	(1, 1, 0, 'a:83:{s:18:"report/sale_profit";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"report/sale_return";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:23:"report/sale_return_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"report/store_check";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:19:"report/store_export";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:24:"report/store_export_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"report/store_iestock";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:19:"report/store_import";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:24:"report/store_import_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"report/store_stock";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:21:"report/store_transfer";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:26:"report/store_transfer_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:25:"report/summary_bestseller";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:23:"report/summary_customer";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"report/summary_product";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:21:"report/summary_result";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:21:"report/summary_return";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:25:"orderreturn/return_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"returndetail/return_detail_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:23:"orderreturn/return_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"employee/employee_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"object/object_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"order/order_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:27:"orderfix/order_deposit_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:29:"orderdetail/order_detail_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:23:"orderfix/order_fix_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:16:"order/order_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:25:"orderpaid/order_paid_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"ordervoucher/order_voucher_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:26:"permission/permission_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"productgroup/product_group_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"product/product_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:29:"productunit/product_unit_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:21:"report/sale_commision";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"report/sale_income";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:25:"report/sale_income_branch";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"report/sale_income_day";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:23:"report/sale_income_user";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:16:"report/sale_item";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:21:"report/sale_item_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:13:"index/account";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"bank/bank_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"barcode/barcode_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:23:"billbank/bill_bank_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:27:"billbranch/bill_branch_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:29:"billincome/bill_income_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:27:"billincome/bill_income_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"billoutcome/bill_outcome_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:29:"billoutcome/bill_outcome_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:33:"billtransfer/bill_transfer_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"billtransfer/bill_transfer_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"branch/branch_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:27:"branchtype/branch_type_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"city/city_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"contact/contact_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"country/country_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"currency/currency_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"customer/customer_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"district/district_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:16:"email/email_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:27:"storecheck/store_check_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:42:"storeexportgroup/store_export_group_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:40:"storeexportgroup/store_export_group_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:29:"storeexport/store_export_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:42:"storeimportgroup/store_import_group_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:40:"storeimportgroup/store_import_group_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:29:"storeimport/store_import_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:16:"store/store_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"storeproduct/store_product_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:33:"storeproduct/store_product_report";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:46:"storetransfergroup/store_transfer_group_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:44:"storetransfergroup/store_transfer_group_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:33:"storetransfer/store_transfer_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"supplier/supplier_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"unit/unit_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:25:"usergroup/user_group_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"user/user_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"work/work_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"send/send_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:20:"setting/setting_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:12:"sms/sms_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:40:"storecheckgroup/store_check_group_action";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:38:"storecheckgroup/store_check_group_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}}', 0),
	(2, 0, 1, 'a:100:{s:42:"storeexportgroup/store_export_group_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:40:"storeexportgroup/store_export_group_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:29:"storeexport/store_export_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:42:"storeimportgroup/store_import_group_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:40:"storeimportgroup/store_import_group_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:29:"storeimport/store_import_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:16:"store/store_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"storeproduct/store_product_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:33:"storeproduct/store_product_report";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:46:"storetransfergroup/store_transfer_group_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:44:"storetransfergroup/store_transfer_group_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:33:"storetransfer/store_transfer_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"studentclass/student_class_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"student/student_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:37:"studentschedule/student_schedule_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"supplier/supplier_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"teacher/teacher_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"unit/unit_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:25:"usergroup/user_group_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"user/user_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:24:"report/store_import_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"report/store_stock";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:21:"report/store_transfer";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:26:"report/store_transfer_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:25:"report/summary_bestseller";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:23:"report/summary_customer";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"report/summary_product";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:21:"report/summary_result";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:21:"report/summary_return";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:25:"orderreturn/return_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"returndetail/return_detail_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:23:"orderreturn/return_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"room/room_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"send/send_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:35:"settinggeneral/setting_general_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"setting/setting_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:12:"sms/sms_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:40:"storecheckgroup/store_check_group_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:38:"storecheckgroup/store_check_group_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:27:"storecheck/store_check_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:35:"productexpired/product_expired_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"productgroup/product_group_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"product/product_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:29:"productunit/product_unit_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"program/program_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:21:"report/sale_commision";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"report/sale_income";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:25:"report/sale_income_branch";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"report/sale_income_day";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:23:"report/sale_income_user";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:16:"report/sale_item";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:21:"report/sale_item_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"report/sale_profit";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"report/sale_return";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:23:"report/sale_return_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"report/store_check";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:19:"report/store_export";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:24:"report/store_export_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"report/store_iestock";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:19:"report/store_import";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"contact/contact_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"country/country_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"currency/currency_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"customer/customer_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:21:"dateoff/date_off_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"district/district_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:16:"email/email_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"employee/employee_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:16:"event/event_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"invoice/invoice_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"message/message_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"object/object_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"order/order_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:27:"orderfix/order_deposit_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:29:"orderdetail/order_detail_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:23:"orderfix/order_fix_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:16:"order/order_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:25:"orderpaid/order_paid_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"ordervoucher/order_voucher_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:26:"permission/permission_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:13:"index/account";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"action/action_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"bank/bank_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"barcode/barcode_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:23:"billbank/bill_bank_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:27:"billbranch/bill_branch_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:29:"billincome/bill_income_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:27:"billincome/bill_income_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"billoutcome/bill_outcome_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:29:"billoutcome/bill_outcome_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:33:"billtransfer/bill_transfer_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"billtransfer/bill_transfer_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"branch/branch_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"0";s:4:"edit";s:1:"1";s:6:"delete";s:1:"0";}s:25:"centerfee/center_fee_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"center/center_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"city/city_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:25:"classhour/class_hour_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:17:"classc/class_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:27:"branchtype/branch_type_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"work/work_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}}', 0),
	(3, 2, 0, 'a:83:{s:13:"index/account";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"bank/bank_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"barcode/barcode_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:23:"billbank/bill_bank_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:27:"billbranch/bill_branch_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:29:"billincome/bill_income_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:27:"billincome/bill_income_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"billoutcome/bill_outcome_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:29:"billoutcome/bill_outcome_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:33:"billtransfer/bill_transfer_action";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:31:"billtransfer/bill_transfer_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:18:"branch/branch_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:27:"branchtype/branch_type_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:14:"city/city_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"contact/contact_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:20:"country/country_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"currency/currency_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"customer/customer_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"district/district_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:16:"email/email_list";a:4:{s:4:"view";s:1:"1";s:3:"add";s:1:"1";s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}s:22:"employee/employee_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:18:"object/object_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:18:"order/order_action";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:27:"orderfix/order_deposit_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:29:"orderdetail/order_detail_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:23:"orderfix/order_fix_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:16:"order/order_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:25:"orderpaid/order_paid_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:31:"ordervoucher/order_voucher_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:26:"permission/permission_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:31:"productgroup/product_group_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:20:"product/product_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:29:"productunit/product_unit_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:21:"report/sale_commision";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:18:"report/sale_income";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:25:"report/sale_income_branch";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:22:"report/sale_income_day";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:23:"report/sale_income_user";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:16:"report/sale_item";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:21:"report/sale_item_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:18:"report/sale_profit";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:18:"report/sale_return";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:23:"report/sale_return_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:18:"report/store_check";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:19:"report/store_export";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:24:"report/store_export_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:20:"report/store_iestock";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:19:"report/store_import";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:24:"report/store_import_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:18:"report/store_stock";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:21:"report/store_transfer";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:26:"report/store_transfer_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:25:"report/summary_bestseller";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:23:"report/summary_customer";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:22:"report/summary_product";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:21:"report/summary_result";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:21:"report/summary_return";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:25:"orderreturn/return_action";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:31:"returndetail/return_detail_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:23:"orderreturn/return_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:14:"send/send_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:20:"setting/setting_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:12:"sms/sms_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:40:"storecheckgroup/store_check_group_action";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:38:"storecheckgroup/store_check_group_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:27:"storecheck/store_check_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:42:"storeexportgroup/store_export_group_action";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:40:"storeexportgroup/store_export_group_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:29:"storeexport/store_export_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:42:"storeimportgroup/store_import_group_action";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:40:"storeimportgroup/store_import_group_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:29:"storeimport/store_import_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:16:"store/store_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:31:"storeproduct/store_product_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:33:"storeproduct/store_product_report";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:46:"storetransfergroup/store_transfer_group_action";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:44:"storetransfergroup/store_transfer_group_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:33:"storetransfer/store_transfer_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:22:"supplier/supplier_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:14:"unit/unit_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:25:"usergroup/user_group_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:14:"user/user_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}s:14:"work/work_list";a:4:{s:4:"view";i:1;s:3:"add";i:1;s:4:"edit";i:1;s:6:"delete";i:1;}}', 0);
/*!40000 ALTER TABLE `mk_permission` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_program
CREATE TABLE IF NOT EXISTS `mk_program` (
  `program_id` char(36) NOT NULL,
  `branch_id` int(11) DEFAULT NULL COMMENT 'Trung tâm',
  `parent_id` char(36) DEFAULT NULL COMMENT 'Cha',
  `next_program_id` char(36) DEFAULT NULL COMMENT 'Chương trình tiếp theo',
  `name` varchar(255) DEFAULT NULL COMMENT 'Tên chương trình',
  `program_code` varchar(255) DEFAULT NULL COMMENT 'Mã chương trình',
  `total_time` tinyint(5) DEFAULT NULL COMMENT 'Thời gian học',
  `order` tinyint(5) DEFAULT NULL COMMENT 'thứ tự',
  `score` float DEFAULT NULL COMMENT 'Điểm qua khoá',
  `certificate` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'giấy chứng nhận| 1/Có - 2/Không',
  `note` varchar(255) DEFAULT NULL COMMENT 'Ghi chú',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'trạng thái| 1/Active - 2/Inactive',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày tạo',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày sửa',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`program_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `mk_program_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `mk_branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Chương trình';

-- Dumping data for table masterkid_local.mk_program: ~1 rows (approximately)
DELETE FROM `mk_program`;
/*!40000 ALTER TABLE `mk_program` DISABLE KEYS */;
INSERT INTO `mk_program` (`program_id`, `branch_id`, `parent_id`, `next_program_id`, `name`, `program_code`, `total_time`, `order`, `score`, `certificate`, `note`, `status`, `created_at`, `updated_at`, `deleted`) VALUES
	('26107501-b117-41c6-9867-1a1174970143', 4, '', '', 'Test 1', 'test1', 36, 0, 7, 1, '', 1, '2015-11-18 17:11:35', '2015-11-18 17:11:35', 0);
/*!40000 ALTER TABLE `mk_program` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_room
CREATE TABLE IF NOT EXISTS `mk_room` (
  `room_id` char(36) NOT NULL,
  `branch_id` int(11) NOT NULL COMMENT 'Trung tâm',
  `name` varchar(255) DEFAULT NULL COMMENT 'Tên phòng',
  `note` text COMMENT 'Ghi chú',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'trạng thái| 1/Active - 2/Inactive',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày tạo',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày sửa',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`room_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `mk_room_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `mk_branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Phòng học';

-- Dumping data for table masterkid_local.mk_room: ~0 rows (approximately)
DELETE FROM `mk_room`;
/*!40000 ALTER TABLE `mk_room` DISABLE KEYS */;
/*!40000 ALTER TABLE `mk_room` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_setting_general
CREATE TABLE IF NOT EXISTS `mk_setting_general` (
  `setting_general_id` char(36) NOT NULL,
  `branch_id` int(11) NOT NULL COMMENT 'Trung tâm',
  `type` varchar(255) DEFAULT NULL COMMENT 'Loại',
  `value` varchar(255) DEFAULT NULL COMMENT 'giá trị',
  `text` varchar(255) DEFAULT NULL COMMENT 'text',
  `default` varchar(255) DEFAULT NULL COMMENT 'mặc định',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày tạo',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày sửa',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`setting_general_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `mk_setting_general_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `mk_branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cài đặt';

-- Dumping data for table masterkid_local.mk_setting_general: ~0 rows (approximately)
DELETE FROM `mk_setting_general`;
/*!40000 ALTER TABLE `mk_setting_general` DISABLE KEYS */;
/*!40000 ALTER TABLE `mk_setting_general` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_student
CREATE TABLE IF NOT EXISTS `mk_student` (
  `student_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT 'Tên học viên',
  `student_code` varchar(255) DEFAULT NULL COMMENT 'Mã học viên',
  `sex` tinyint(1) DEFAULT NULL COMMENT 'Giới tính',
  `birthday` date DEFAULT NULL COMMENT 'Ngày sinh nhật',
  `student_school` varchar(255) DEFAULT NULL COMMENT 'Trường',
  `student_class` varchar(255) DEFAULT NULL COMMENT 'Lớp',
  `parent_name` varchar(255) DEFAULT NULL COMMENT 'Tên phụ huynh',
  `parent_type` varchar(255) DEFAULT NULL COMMENT 'Mối quan hệ| 1/Cha - 2/Mẹ - 3/Anh - 4/Chị - 5/ông - 6/bà',
  `parent_birthday` date DEFAULT NULL COMMENT 'Sinh nhật phụ huynh',
  `parent_work` varchar(255) DEFAULT NULL COMMENT 'Nghề nghiệp',
  `address` varchar(255) DEFAULT NULL COMMENT 'Địa chỉ',
  `phone` varchar(255) DEFAULT NULL COMMENT 'Số điện thoại',
  `email` varchar(255) DEFAULT NULL COMMENT 'Email',
  `note` text COMMENT 'Ghi chú',
  `status` tinyint(1) DEFAULT '0' COMMENT 'trạng thái| 1/Active - 2/Inactive',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày tạo',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày sửa',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL COMMENT 'Trung tâm',
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Học viên';

-- Dumping data for table masterkid_local.mk_student: ~1 rows (approximately)
DELETE FROM `mk_student`;
/*!40000 ALTER TABLE `mk_student` DISABLE KEYS */;
INSERT INTO `mk_student` (`student_id`, `name`, `student_code`, `sex`, `birthday`, `student_school`, `student_class`, `parent_name`, `parent_type`, `parent_birthday`, `parent_work`, `address`, `phone`, `email`, `note`, `status`, `created_at`, `updated_at`, `deleted`, `branch_id`) VALUES
	('dd979b9a-e6be-4671-b6a3-9ca888f87ca8', 'x', 'x', 2, '2015-11-01', 'x', 'x', 'x', '1', '2015-11-01', 'x', 'x', 'x', 'x', 'x', 1, '2015-11-18 15:11:44', '2015-11-18 15:11:44', 0, 4);
/*!40000 ALTER TABLE `mk_student` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_student_class
CREATE TABLE IF NOT EXISTS `mk_student_class` (
  `student_class_id` char(36) NOT NULL,
  `branch_id` int(11) NOT NULL COMMENT 'Trung tâm',
  `class_id` char(36) NOT NULL COMMENT 'Lớp học',
  `student_id` char(36) NOT NULL COMMENT 'Học viên',
  `program_id` char(36) NOT NULL COMMENT 'Chương trình',
  `date_start` date DEFAULT NULL COMMENT 'Ngày bắt đầu',
  `date_end` date DEFAULT NULL COMMENT 'Ngày kết thúc',
  `hour` tinyint(5) DEFAULT NULL COMMENT 'Giờ đã học',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'trạng thái| 1/Active - 2/Inactive',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày tạo',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày sửa',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`student_class_id`),
  KEY `branch_id` (`branch_id`),
  KEY `class_id` (`class_id`),
  KEY `student_id` (`student_id`),
  KEY `program_id` (`program_id`),
  CONSTRAINT `mk_student_class_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `mk_branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mk_student_class_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `mk_class` (`class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mk_student_class_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `mk_student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mk_student_class_ibfk_4` FOREIGN KEY (`program_id`) REFERENCES `mk_program` (`program_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Học viên trong lớp';

-- Dumping data for table masterkid_local.mk_student_class: ~0 rows (approximately)
DELETE FROM `mk_student_class`;
/*!40000 ALTER TABLE `mk_student_class` DISABLE KEYS */;
/*!40000 ALTER TABLE `mk_student_class` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_student_schedule
CREATE TABLE IF NOT EXISTS `mk_student_schedule` (
  `student_schedule_id` char(36) NOT NULL,
  `branch_id` int(11) NOT NULL COMMENT 'Trung tâm',
  `student_id` char(36) NOT NULL COMMENT 'Học viên',
  `class_hour_id` char(36) NOT NULL COMMENT 'Giờ học',
  `date` date NOT NULL COMMENT 'Ngày học',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'trạng thái| 1/Active - 2/Inactive',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày tạo',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày sửa',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`student_schedule_id`),
  KEY `branch_id` (`branch_id`),
  KEY `student_id` (`student_id`),
  KEY `class_hour_id` (`class_hour_id`),
  CONSTRAINT `mk_student_schedule_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `mk_branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mk_student_schedule_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `mk_student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mk_student_schedule_ibfk_3` FOREIGN KEY (`class_hour_id`) REFERENCES `mk_class_hour` (`class_hour_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Thời khoá biểu';

-- Dumping data for table masterkid_local.mk_student_schedule: ~0 rows (approximately)
DELETE FROM `mk_student_schedule`;
/*!40000 ALTER TABLE `mk_student_schedule` DISABLE KEYS */;
/*!40000 ALTER TABLE `mk_student_schedule` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_teacher
CREATE TABLE IF NOT EXISTS `mk_teacher` (
  `teacher_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT 'Tên giáo viên',
  `surname` varchar(255) DEFAULT NULL COMMENT 'Tên hiển thị',
  `address` varchar(255) DEFAULT NULL COMMENT 'Địa chỉ',
  `email` varchar(255) DEFAULT NULL COMMENT 'Email',
  `phone` varchar(255) DEFAULT NULL COMMENT 'Số điện thoại',
  `sex` tinyint(1) DEFAULT NULL COMMENT 'Giới tính',
  `birthday` date DEFAULT NULL COMMENT 'Ngày sinh',
  `school` varchar(255) DEFAULT NULL COMMENT 'Trường',
  `note` varchar(255) DEFAULT NULL COMMENT 'Ghi chú',
  `status` tinyint(1) DEFAULT '0' COMMENT 'trạng thái| 1/Active - 2/Inactive',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày tạo',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ngày sửa',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL COMMENT 'Trung tâm',
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Giáo viên';

-- Dumping data for table masterkid_local.mk_teacher: ~1 rows (approximately)
DELETE FROM `mk_teacher`;
/*!40000 ALTER TABLE `mk_teacher` DISABLE KEYS */;
INSERT INTO `mk_teacher` (`teacher_id`, `name`, `surname`, `address`, `email`, `phone`, `sex`, `birthday`, `school`, `note`, `status`, `created_at`, `updated_at`, `deleted`, `branch_id`) VALUES
	('1', '', '', '', '', '', 0, '0000-00-00', '', '', 0, '2011-11-01 00:00:00', '0000-00-00 00:00:00', 1, 111),
	('239b8d4e-840c-4a6c-8445-015238abd1ce', 'GV A', 'GV A', '', '', '', 2, '2015-11-01', '', '', 1, '2015-11-18 05:28:01', '2015-11-18 05:28:01', 0, 4);
/*!40000 ALTER TABLE `mk_teacher` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_user
CREATE TABLE IF NOT EXISTS `mk_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên đăng nhập',
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mật khẩu',
  `user_group_id` int(11) NOT NULL COMMENT 'nhóm người dùng',
  `employee_id` int(11) NOT NULL COMMENT 'nhân viên',
  `branch_id` int(11) NOT NULL COMMENT 'chi nhánh mặc định',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `fk_kk_user_kk_user_group1_idx` (`user_group_id`),
  KEY `fk_kk_user_kk_employee1_idx` (`employee_id`),
  KEY `fk_kk_user_kk_branch1_idx` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Người dùng';

-- Dumping data for table masterkid_local.mk_user: ~1 rows (approximately)
DELETE FROM `mk_user`;
/*!40000 ALTER TABLE `mk_user` DISABLE KEYS */;
INSERT INTO `mk_user` (`user_id`, `username`, `password`, `user_group_id`, `employee_id`, `branch_id`, `note`, `status`, `deleted`) VALUES
	(1, 'mk', '$2a$12$kIkn1RFpl5uGajc9sWs67.fbJA79h6kuS.3EUKxP3mC1XHrs0ky1C', 1, 1, 4, 'Admin', 1, 0);
/*!40000 ALTER TABLE `mk_user` ENABLE KEYS */;


-- Dumping structure for table masterkid_local.mk_user_group
CREATE TABLE IF NOT EXISTS `mk_user_group` (
  `user_group_id` int(11) NOT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã nhóm',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên nhóm',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`user_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nhóm người dùng';

-- Dumping data for table masterkid_local.mk_user_group: ~2 rows (approximately)
DELETE FROM `mk_user_group`;
/*!40000 ALTER TABLE `mk_user_group` DISABLE KEYS */;
INSERT INTO `mk_user_group` (`user_group_id`, `code`, `name`, `note`, `status`, `deleted`) VALUES
	(1, 'AD', 'Administrator', '', 1, 0),
	(2, 'NV', 'Nhân viên', '', 1, 0);
/*!40000 ALTER TABLE `mk_user_group` ENABLE KEYS */;


-- Dumping structure for procedure masterkid_local.test_multi_sets
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `test_multi_sets`()
    DETERMINISTIC
begin
        select user() as first_col;
        select user() as first_col, now() as second_col;
        select user() as first_col, now() as second_col, now() as third_col;
        end//
DELIMITER ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
