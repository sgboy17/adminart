/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.6.23-log : Database - xuatnhapkho_mk
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


/*Table structure for table `mk_bank` */

DROP TABLE IF EXISTS `mk_bank`;

CREATE TABLE `mk_bank` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã ngân hàng',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên ngân hàng',
  `currency_id` int(11) NOT NULL COMMENT 'tiền tệ',
  `address` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'địa chỉ',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`bank_id`),
  KEY `fk_kk_bank_kk_currency1_idx` (`currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Ngân hàng';

/*Data for the table `mk_bank` */

insert  into `mk_bank`(`bank_id`,`code`,`name`,`currency_id`,`address`,`note`,`status`,`deleted`) values (1,'DAB','Đông Á Bank',1,'411/58/48 Lê Đức Thọ, Phường 17, Quận Gò Vấp, TP Hồ Chí Minh','Ngân hàng uy tín',1,0),(2,'ACB','Á Châu Bank',1,'Xô Viết Nghệ Tĩnh','',1,0);

/*Table structure for table `mk_barcode` */

DROP TABLE IF EXISTS `mk_barcode`;

CREATE TABLE `mk_barcode` (
  `barcode_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL COMMENT 'hàng hoá',
  `template` int(11) NOT NULL COMMENT 'mẫu barcode| 1/Mẫu 1 - 2/Mẫu 2 - 3/Mẫu 3',
  `quantity` int(11) NOT NULL COMMENT 'số lượng tem',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`barcode_id`),
  KEY `fk_kk_barcode_kk_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Barcode';

/*Data for the table `mk_barcode` */

/*Table structure for table `mk_bill_bank` */

DROP TABLE IF EXISTS `mk_bill_bank`;

CREATE TABLE `mk_bill_bank` (
  `bill_bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL COMMENT 'chi nhánh',
  `bank_id` int(11) NOT NULL COMMENT 'ngân hàng',
  `price` decimal(20,2) DEFAULT NULL,
  `bill_income_id` int(11) NOT NULL COMMENT 'số tiền thay đổi do phiếu thu',
  `bill_outcome_id` int(11) NOT NULL COMMENT 'số tiền thay đổi do phiếu chi',
  `created_date` datetime DEFAULT NULL COMMENT 'ngày tạo',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`bill_bank_id`),
  KEY `fk_kk_bill_bank_kk_branch1_idx` (`branch_id`),
  KEY `fk_kk_bill_bank_kk_bank1_idx` (`bank_id`),
  KEY `fk_kk_bill_bank_kk_bill_income1_idx` (`bill_income_id`),
  KEY `fk_kk_bill_bank_kk_bill_outcome1_idx` (`bill_outcome_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Quỹ tiền ngân hàng đầu kỳ';

/*Data for the table `mk_bill_bank` */

/*Table structure for table `mk_bill_branch` */

DROP TABLE IF EXISTS `mk_bill_branch`;

CREATE TABLE `mk_bill_branch` (
  `bill_branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL COMMENT 'chi nhánh',
  `price` decimal(20,2) DEFAULT NULL,
  `bill_income_id` int(11) NOT NULL COMMENT 'số tiền thay đổi do phiếu thu',
  `bill_outcome_id` int(11) NOT NULL COMMENT 'số tiền thay đổi do phiếu chi',
  `created_date` datetime DEFAULT NULL COMMENT 'ngày tạo',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`bill_branch_id`),
  KEY `fk_kk_bill_branch_kk_bill_income1_idx` (`bill_income_id`),
  KEY `fk_kk_bill_branch_kk_bill_outcome1_idx` (`bill_outcome_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Quỹ tiền đầu kỳ';

/*Data for the table `mk_bill_branch` */

/*Table structure for table `mk_bill_income` */

DROP TABLE IF EXISTS `mk_bill_income`;

CREATE TABLE `mk_bill_income` (
  `bill_income_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL COMMENT 'chi nhánh',
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã phiếu thu',
  `created_date` datetime DEFAULT NULL COMMENT 'ngày thu',
  `employee_id` int(11) NOT NULL COMMENT 'nhân viên',
  `type` int(11) NOT NULL COMMENT 'phương thức| 1/Thu công nợ - 2/Thu khác - 3/Thu tiền xuất trả hàng cho NCC - 4/Thu tiền đặt cọc - 5/Thu lại tiền đặt cọc - 6/Thu chuyển tiền nội bộ',
  `method` int(11) NOT NULL COMMENT 'hình thức thanh toán| 1/ Tiền mặt - 2/Thẻ',
  `price` decimal(20,2) DEFAULT NULL,
  `commission_price` decimal(20,2) DEFAULT NULL,
  `commission_percent` float NOT NULL COMMENT 'chiết khấu phần trăm',
  `customer_id` int(11) NOT NULL COMMENT 'khách hàng',
  `order_id` int(11) NOT NULL COMMENT 'mã đơn hàng',
  `return_id` int(11) NOT NULL COMMENT 'trả hàng',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`bill_income_id`),
  KEY `fk_kk_bill_income_kk_branch1_idx` (`branch_id`),
  KEY `fk_kk_bill_income_kk_employee1_idx` (`employee_id`),
  KEY `fk_kk_bill_income_kk_customer1_idx` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Phiếu thu';

/*Data for the table `mk_bill_income` */

/*Table structure for table `mk_bill_outcome` */

DROP TABLE IF EXISTS `mk_bill_outcome`;

CREATE TABLE `mk_bill_outcome` (
  `bill_outcome_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL COMMENT 'chi nhánh',
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã phiếu chi',
  `created_date` datetime DEFAULT NULL COMMENT 'ngày chi',
  `employee_id` int(11) NOT NULL COMMENT 'nhân viên',
  `type` int(11) NOT NULL COMMENT 'phương thức| 1/Chi công nợ - 2/Chi khác - 3/Chi tiền xuất trả hàng cho KH - 4/Chi tiền đặt cọc - 5/Chi lại tiền đặt cọc - 6/Chi chuyển tiền nội bộ',
  `method` int(11) NOT NULL COMMENT 'hình thức thanh toán| 1/ Tiền mặt - 2/Thẻ',
  `price` decimal(20,2) DEFAULT NULL,
  `commission_price` decimal(20,2) DEFAULT NULL,
  `commission_percent` float NOT NULL COMMENT 'chiết khấu phần trăm',
  `supplier_id` int(11) NOT NULL COMMENT 'nhà cung cấp',
  `customer_id` int(11) NOT NULL COMMENT 'khách hàng',
  `order_id` int(11) NOT NULL COMMENT 'mã đơn hàng',
  `return_id` int(11) NOT NULL COMMENT 'trả hàng',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`bill_outcome_id`),
  KEY `fk_kk_bill_outcome_kk_branch1_idx` (`branch_id`),
  KEY `fk_kk_bill_outcome_kk_employee1_idx` (`employee_id`),
  KEY `fk_kk_bill_outcome_kk_supplier1_idx` (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Phiếu chi';

/*Data for the table `mk_bill_outcome` */

/*Table structure for table `mk_bill_transfer` */

DROP TABLE IF EXISTS `mk_bill_transfer`;

CREATE TABLE `mk_bill_transfer` (
  `bill_transfer_id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_income_id` int(11) NOT NULL COMMENT 'phiếu thu',
  `bill_outcome_id` int(11) NOT NULL COMMENT 'phiếu chi',
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã phiếu',
  `branch_id_income` int(11) NOT NULL COMMENT 'chi nhánh thu',
  `branch_id_outcome` int(11) NOT NULL COMMENT 'chi nhánh chi',
  `created_date` datetime DEFAULT NULL COMMENT 'ngày chuyển',
  `price` decimal(10,2) DEFAULT NULL COMMENT 'số tiền chuyển',
  `employee_id` int(11) NOT NULL COMMENT 'nhân viên',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `status` int(11) NOT NULL COMMENT 'trạng thái| -1/Không duyệt - 0/Chờ duyệt - 1/Đã duyệt',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`bill_transfer_id`),
  KEY `fk_kk_bill_transfer_kk_branch1_idx` (`branch_id_income`),
  KEY `fk_kk_bill_transfer_kk_branch2_idx` (`branch_id_outcome`),
  KEY `fk_kk_bill_transfer_kk_employee1_idx` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Phiếu chuyển tiền';

/*Data for the table `mk_bill_transfer` */

/*Table structure for table `mk_branch` */

DROP TABLE IF EXISTS `mk_branch`;

CREATE TABLE `mk_branch` (
  `branch_id` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Chi nhánh';

/*Data for the table `mk_branch` */

insert  into `mk_branch`(`branch_id`,`store_id`,`code`,`name`,`branch_type_id`,`employee_id`,`note`,`country_id`,`city_id`,`district_id`,`address`,`email`,`phone`,`fax`,`website`,`status`,`deleted`) values (1,1,'HVB','Huỳnh Văn Bánh',2,1,'',1,52,456,'','','','','',1,0);

/*Table structure for table `mk_branch_type` */

DROP TABLE IF EXISTS `mk_branch_type`;

CREATE TABLE `mk_branch_type` (
  `branch_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã loại',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên loại',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`branch_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Loại chi nhánh';

/*Data for the table `mk_branch_type` */

insert  into `mk_branch_type`(`branch_type_id`,`code`,`name`,`note`,`status`,`deleted`) values (1,'CH','Cửa hàng chính','',1,0),(2,'CHP','Cửa hàng phụ','',1,0);

/*Table structure for table `mk_city` */

DROP TABLE IF EXISTS `mk_city`;

CREATE TABLE `mk_city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL COMMENT 'quốc gia',
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã',
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`city_id`),
  KEY `fk_kk_city_kk_country1_idx` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Thành phố\n';

/*Data for the table `mk_city` */

insert  into `mk_city`(`city_id`,`country_id`,`code`,`name`,`deleted`) values (3,1,'1','Thành phố Hà Nội',0),(4,1,'2','Tỉnh Hà Giang',0),(5,1,'4','Tỉnh Cao Bằng',0),(6,1,'6','Tỉnh Bắc Kạn',0),(7,1,'8','Tỉnh Tuyên Quang',0),(8,1,'10','Tỉnh Lào Cai',0),(9,1,'11','Tỉnh Điện Biên',0),(10,1,'12','Tỉnh Lai Châu',0),(11,1,'14','Tỉnh Sơn La',0),(12,1,'15','Tỉnh Yên Bái',0),(13,1,'17','Tỉnh Hoà Bình',0),(14,1,'19','Tỉnh Thái Nguyên',0),(15,1,'20','Tỉnh Lạng Sơn',0),(16,1,'22','Tỉnh Quảng Ninh',0),(17,1,'24','Tỉnh Bắc Giang',0),(18,1,'25','Tỉnh Phú Thọ',0),(19,1,'26','Tỉnh Vĩnh Phúc',0),(20,1,'27','Tỉnh Bắc Ninh',0),(21,1,'30','Tỉnh Hải Dương',0),(22,1,'31','Thành phố Hải Phòng',0),(23,1,'33','Tỉnh Hưng Yên',0),(24,1,'34','Tỉnh Thái Bình',0),(25,1,'35','Tỉnh Hà Nam',0),(26,1,'36','Tỉnh Nam Định',0),(27,1,'37','Tỉnh Ninh Bình',0),(28,1,'38','Tỉnh Thanh Hóa',0),(29,1,'40','Tỉnh Nghệ An',0),(30,1,'42','Tỉnh Hà Tĩnh',0),(31,1,'44','Tỉnh Quảng Bình',0),(32,1,'45','Tỉnh Quảng Trị',0),(33,1,'46','Tỉnh Thừa Thiên Huế',0),(34,1,'48','Thành phố Đà Nẵng',0),(35,1,'49','Tỉnh Quảng Nam',0),(36,1,'51','Tỉnh Quảng Ngãi',0),(37,1,'52','Tỉnh Bình Định',0),(38,1,'54','Tỉnh Phú Yên',0),(39,1,'56','Tỉnh Khánh Hòa',0),(40,1,'58','Tỉnh Ninh Thuận',0),(41,1,'60','Tỉnh Bình Thuận',0),(42,1,'62','Tỉnh Kon Tum',0),(43,1,'64','Tỉnh Gia Lai',0),(44,1,'66','Tỉnh Đắk Lắk',0),(45,1,'67','Tỉnh Đắk Nông',0),(46,1,'68','Tỉnh Lâm Đồng',0),(47,1,'70','Tỉnh Bình Phước',0),(48,1,'72','Tỉnh Tây Ninh',0),(49,1,'74','Tỉnh Bình Dương',0),(50,1,'75','Tỉnh Đồng Nai',0),(51,1,'77','Tỉnh Bà Rịa - Vũng Tàu',0),(52,1,'79','Thành phố Hồ Chí Minh',0),(53,1,'80','Tỉnh Long An',0),(54,1,'82','Tỉnh Tiền Giang',0),(55,1,'83','Tỉnh Bến Tre',0),(56,1,'84','Tỉnh Trà Vinh',0),(57,1,'86','Tỉnh Vĩnh Long',0),(58,1,'87','Tỉnh Đồng Tháp',0),(59,1,'89','Tỉnh An Giang',0),(60,1,'91','Tỉnh Kiên Giang',0),(61,1,'92','Thành phố Cần Thơ',0),(62,1,'93','Tỉnh Hậu Giang',0),(63,1,'94','Tỉnh Sóc Trăng',0),(64,1,'95','Tỉnh Bạc Liêu',0),(65,1,'96','Tỉnh Cà Mau',0);

/*Table structure for table `mk_contact` */

DROP TABLE IF EXISTS `mk_contact`;

CREATE TABLE `mk_contact` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT 'khách hàng',
  `supplier_id` int(11) NOT NULL COMMENT 'nhà cung cấp',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên liên hệ',
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'email',
  `phone_1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'điện thoại 1',
  `phone_2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'điện thoại 2',
  `fax` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'fax',
  `country_id` int(11) NOT NULL COMMENT 'quốc gia',
  `city_id` int(11) NOT NULL COMMENT 'thành phố',
  `district_id` int(11) NOT NULL COMMENT 'quận huyện',
  `address` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'địa chỉ',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`contact_id`),
  KEY `fk_kk_customer_contact_kk_customer1_idx` (`customer_id`),
  KEY `fk_kk_contact_kk_supplier1_idx` (`supplier_id`),
  KEY `fk_kk_contact_kk_country1_idx` (`country_id`),
  KEY `fk_kk_contact_kk_city1_idx` (`city_id`),
  KEY `fk_kk_contact_kk_district1_idx` (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liên hệ của KH/NCC';

/*Data for the table `mk_contact` */

insert  into `mk_contact`(`contact_id`,`customer_id`,`supplier_id`,`name`,`email`,`phone_1`,`phone_2`,`fax`,`country_id`,`city_id`,`district_id`,`address`,`note`,`deleted`) values (1,1,0,'Khách hàng 1A','kh1a@innotech-vn.com','0123456789','','0123456789',1,52,461,'Hồ Bá Kiện','Chị của khách hàng',0),(2,1,0,'Khách hàng 1B','kh1b@innotech-vn.com','0123456789','','0123456789',1,52,461,'Hồ Bá Kiện','Anh của khách hàng',0),(6,0,2,'Nhà cung cấp 1A','ncc1a@innotech-vn.com','0123456789','','0123456789',1,52,456,'Tô Hiến Thành','nhà cung cấp phụ A',0),(7,0,2,'Nhà cung cấp 1B','nccb@innotech-vn.com','0123456789','','0123456789',1,52,456,'Tô Hiến Thành','nhà cung cấp phụ B',0);

/*Table structure for table `mk_country` */

DROP TABLE IF EXISTS `mk_country`;

CREATE TABLE `mk_country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã',
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Quốc gia';

/*Data for the table `mk_country` */

insert  into `mk_country`(`country_id`,`code`,`name`,`deleted`) values (1,'vn','Việt Nam',0);

/*Table structure for table `mk_currency` */

DROP TABLE IF EXISTS `mk_currency`;

CREATE TABLE `mk_currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã tiền tệ',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên tiền tệ',
  `value` decimal(10,2) NOT NULL COMMENT 'giá trị tiền tệ',
  `position` int(11) NOT NULL COMMENT 'vị trí biểu tượng| 1/biểu tượng bên trái - 2/biểu tượng bên phải',
  `is_base` int(11) NOT NULL COMMENT 'tiền tệ mặc định| 0/không là chuẩn - 1/lấy làm chuẩn',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tiền tệ';

/*Data for the table `mk_currency` */

insert  into `mk_currency`(`currency_id`,`code`,`name`,`value`,`position`,`is_base`,`deleted`) values (1,'đ','Việt Nam Đồng','1.00',2,1,0);

/*Table structure for table `mk_customer` */

DROP TABLE IF EXISTS `mk_customer`;

CREATE TABLE `mk_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên',
  `score` int(11) NOT NULL COMMENT 'điểm tích luỹ',
  `object_id` int(11) NOT NULL COMMENT 'nhóm',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `country_id` int(11) NOT NULL COMMENT 'quốc gia',
  `city_id` int(11) NOT NULL COMMENT 'thành phố',
  `district_id` int(11) NOT NULL COMMENT 'quận huyện',
  `tax_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã số thuế',
  `avatar` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'hình đại diện',
  `fax` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'fax',
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'email',
  `website` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'website',
  `address_1` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'địa chỉ 1',
  `address_2` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'địa chỉ 2',
  `phone_1` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'điện thoại 1',
  `phone_2` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'điện thoại 2',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`customer_id`),
  KEY `fk_kk_customer_kk_object1_idx` (`object_id`),
  KEY `fk_kk_customer_kk_country1_idx` (`country_id`),
  KEY `fk_kk_customer_kk_city1_idx` (`city_id`),
  KEY `fk_kk_customer_kk_district1_idx` (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Khách hàng';

/*Data for the table `mk_customer` */

insert  into `mk_customer`(`customer_id`,`code`,`name`,`score`,`object_id`,`note`,`country_id`,`city_id`,`district_id`,`tax_code`,`avatar`,`fax`,`email`,`website`,`address_1`,`address_2`,`phone_1`,`phone_2`,`status`,`deleted`) values (1,'KH01','Khách hàng Innotech',0,1,'Khách hàng thường xuyên',1,52,461,'1122334455','','0123456789','sale@innotech-vn.com','http://innotech-vn.com','Hồ Bá Kiện','','+84 (8) 3970 7516','',1,0);

/*Table structure for table `mk_district` */

DROP TABLE IF EXISTS `mk_district`;

CREATE TABLE `mk_district` (
  `district_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL COMMENT 'thành phố',
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã',
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`district_id`),
  KEY `fk_kk_district_kk_city1_idx` (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=585 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Quận huyện\n';

/*Data for the table `mk_district` */

insert  into `mk_district`(`district_id`,`city_id`,`code`,`name`,`deleted`) values (3,3,'1','Quận Ba Đình',0),(4,3,'2','Quận Hoàn Kiếm',0),(5,3,'4','Quận Long Biên',0),(6,3,'5','Quận Cầu Giấy',0),(7,3,'6','Quận Đống Đa',0),(8,3,'7','Quận Hai Bà Trưng',0),(9,3,'8','Quận Hoàng Mai',0),(10,3,'9','Quận Thanh Xuân',0),(11,3,'16','Huyện Sóc Sơn',0),(12,3,'17','Huyện Đông Anh',0),(13,3,'18','Huyện Gia Lâm',0),(14,3,'19','Huyện Từ Liêm',0),(15,3,'20','Huyện Thanh Trì',0),(16,3,'268','Quận Hà Đông',0),(17,3,'269','Thị xã Sơn Tây',0),(18,3,'271','Huyện Ba Vì',0),(19,3,'272','Huyện Phúc Thọ',0),(20,3,'273','Huyện Đan Phượng',0),(21,3,'274','Huyện Hoài Đức',0),(22,3,'275','Huyện Quốc Oai',0),(23,3,'276','Huyện Thạch Thất',0),(24,3,'277','Huyện Chương Mỹ',0),(25,3,'278','Huyện Thanh Oai',0),(26,3,'279','Huyện Thường Tín',0),(27,3,'280','Huyện Phú Xuyên',0),(28,3,'281','Huyện ứng Hòa',0),(29,4,'24','Thị xã Hà Giang',0),(30,4,'26','Huyện Đồng Văn',0),(31,4,'27','Huyện Mèo Vạc',0),(32,4,'28','Huyện Yên Minh',0),(33,4,'29','Huyện Quản Bạ',0),(34,4,'30','Huyện Vị Xuyên',0),(35,4,'31','Huyện Bắc Mê',0),(36,4,'32','Huyện Hoàng Su Phì',0),(37,4,'33','Huyện Xín Mần',0),(38,4,'34','Huyện Bắc Quang',0),(39,5,'40','Thị xã Cao Bằng',0),(40,5,'43','Huyện Bảo Lạc',0),(41,5,'44','Huyện Thông Nông',0),(42,5,'45','Huyện Hà Quảng',0),(43,5,'46','Huyện Trà Lĩnh',0),(44,5,'47','Huyện Trùng Khánh',0),(45,5,'48','Huyện Hạ Lang',0),(46,5,'49','Huyện Quảng Uyên',0),(47,5,'51','Huyện Hoà An',0),(48,5,'52','Huyện Nguyên Bình',0),(49,6,'58','Thị xã Bắc Kạn',0),(50,6,'61','Huyện Ba Bể',0),(51,6,'63','Huyện Bạch Thông',0),(52,6,'64','Huyện Chợ Đồn',0),(53,6,'65','Huyện Chợ Mới',0),(54,6,'66','Huyện Na Rì',0),(55,7,'70','Thị xã Tuyên Quang',0),(56,7,'72','Huyện Nà Hang',0),(57,7,'73','Huyện Chiêm Hóa',0),(58,7,'74','Huyện Hàm Yên',0),(59,7,'75','Huyện Yên Sơn',0),(60,7,'76','Huyện Sơn Dương',0),(61,8,'80','Thành phố Lào Cai',0),(62,8,'82','Huyện Bát Xát',0),(63,8,'83','Huyện Mường Khương',0),(64,8,'84','Huyện Si Ma Cai',0),(65,8,'85','Huyện Bắc Hà',0),(66,8,'86','Huyện Bảo Thắng',0),(67,8,'87','Huyện Bảo Yên',0),(68,8,'88','Huyện Sa Pa',0),(69,8,'89','Huyện Văn Bàn',0),(70,9,'94','Thành phố Điện Biên Phủ',0),(71,9,'95','Thị Xã Mường Lay',0),(72,9,'96','Huyện Mường Nhé',0),(73,9,'98','Huyện Tủa Chùa',0),(74,9,'99','Huyện Tuần Giáo',0),(75,9,'100','Huyện Điện Biên',0),(76,9,'102','Huyện Mường ảng',0),(77,10,'105','Thị xã Lai Châu',0),(78,10,'106','Huyện Tam Đường',0),(79,10,'108','Huyện Sìn Hồ',0),(80,10,'109','Huyện Phong Thổ',0),(81,10,'111','Huyện Tân Uyên',0),(82,11,'116','Thành phố Sơn La',0),(83,11,'118','Huyện Quỳnh Nhai',0),(84,11,'119','Huyện Thuận Châu',0),(85,11,'120','Huyện Mường La',0),(86,11,'121','Huyện Bắc Yên',0),(87,11,'122','Huyện Phù Yên',0),(88,11,'123','Huyện Mộc Châu',0),(89,11,'124','Huyện Yên Châu',0),(90,11,'125','Huyện Mai Sơn',0),(91,12,'132','Thành phố Yên Bái',0),(92,12,'135','Huyện Lục Yên',0),(93,12,'136','Huyện Văn Yên',0),(94,12,'137','Huyện Mù Căng Chải',0),(95,12,'138','Huyện Trấn Yên',0),(96,12,'139','Huyện Trạm Tấu',0),(97,12,'140','Huyện Văn Chấn',0),(98,12,'141','Huyện Yên Bình',0),(99,13,'148','Thành phố Hòa Bình',0),(100,13,'150','Huyện Đà Bắc',0),(101,13,'151','Huyện Kỳ Sơn',0),(102,13,'152','Huyện Lương Sơn',0),(103,13,'153','Huyện Kim Bôi',0),(104,13,'154','Huyện Cao Phong',0),(105,13,'155','Huyện Tân Lạc',0),(106,13,'156','Huyện Mai Châu',0),(107,13,'157','Huyện Lạc Sơn',0),(108,13,'158','Huyện Yên Thủy',0),(109,14,'164','Thành phố Thái Nguyên',0),(110,14,'165','Thị xã Sông Công',0),(111,14,'167','Huyện Định Hóa',0),(112,14,'168','Huyện Phú Lương',0),(113,14,'169','Huyện Đồng Hỷ',0),(114,14,'170','Huyện Võ Nhai',0),(115,14,'171','Huyện Đại Từ',0),(116,14,'172','Huyện Phổ Yên',0),(117,14,'173','Huyện Phú Bình',0),(118,15,'178','Thành phố Lạng Sơn',0),(119,15,'180','Huyện Tràng Định',0),(120,15,'181','Huyện Bình Gia',0),(121,15,'182','Huyện Văn Lãng',0),(122,15,'183','Huyện Cao Lộc',0),(123,15,'184','Huyện Văn Quan',0),(124,15,'185','Huyện Bắc Sơn',0),(125,15,'186','Huyện Hữu Lũng',0),(126,15,'187','Huyện Chi Lăng',0),(127,15,'188','Huyện Lộc Bình',0),(128,16,'193','Thành phố Hạ Long',0),(129,16,'194','Thành phố Móng Cái',0),(130,16,'195','Thị xã Cẩm Phả',0),(131,16,'196','Thị xã Uông Bí',0),(132,16,'200','Huyện Đầm Hà',0),(133,16,'201','Huyện Hải Hà',0),(134,16,'204','Huyện Hoành Bồ',0),(135,16,'205','Huyện Đông Triều',0),(136,16,'206','Huyện Yên Hưng',0),(137,17,'213','Thành phố Bắc Giang',0),(138,17,'215','Huyện Yên Thế',0),(139,17,'216','Huyện Tân Yên',0),(140,17,'217','Huyện Lạng Giang',0),(141,17,'218','Huyện Lục Nam',0),(142,17,'219','Huyện Lục Ngạn',0),(143,17,'220','Huyện Sơn Động',0),(144,17,'221','Huyện Yên Dũng',0),(145,17,'222','Huyện Việt Yên',0),(146,18,'227','Thành phố Việt Trì',0),(147,18,'228','Thị xã Phú Thọ',0),(148,18,'230','Huyện Đoan Hùng',0),(149,18,'231','Huyện Hạ Hoà',0),(150,18,'232','Huyện Thanh Ba',0),(151,18,'233','Huyện Phù Ninh',0),(152,18,'234','Huyện Yên Lập',0),(153,18,'235','Huyện Cẩm Khê',0),(154,18,'236','Huyện Tam Nông',0),(155,18,'237','Huyện Lâm Thao',0),(156,18,'238','Huyện Thanh Sơn',0),(157,18,'240','Huyện Tân Sơn',0),(158,19,'243','Thành phố Vĩnh Yên',0),(159,19,'244','Thị xã Phúc Yên',0),(160,19,'246','Huyện Lập Thạch',0),(161,19,'247','Huyện Tam Dương',0),(162,19,'248','Huyện Tam Đảo',0),(163,19,'249','Huyện Bình Xuyên',0),(164,19,'251','Huyện Yên Lạc',0),(165,19,'252','Huyện Vĩnh Tường',0),(166,19,'253','Huyện Sông Lô',0),(167,20,'256','Thành phố Bắc Ninh',0),(168,20,'258','Huyện Yên Phong',0),(169,20,'259','Huyện Quế Võ',0),(170,20,'260','Huyện Tiên Du',0),(171,20,'261','Thị xã Từ Sơn',0),(172,20,'262','Huyện Thuận Thành',0),(173,20,'263','Huyện Gia Bình',0),(174,20,'264','Huyện Lương Tài',0),(175,21,'288','Thành phố Hải Dương',0),(176,21,'290','Huyện Chí Linh',0),(177,21,'291','Huyện Nam Sách',0),(178,21,'292','Huyện Kinh Môn',0),(179,21,'293','Huyện Kim Thành',0),(180,21,'294','Huyện Thanh Hà',0),(181,21,'295','Huyện Cẩm Giàng',0),(182,21,'296','Huyện Bình Giang',0),(183,21,'297','Huyện Gia Lộc',0),(184,21,'298','Huyện Tứ Kỳ',0),(185,21,'299','Huyện Ninh Giang',0),(186,21,'300','Huyện Thanh Miện',0),(187,22,'303','Quận Hồng Bàng',0),(188,22,'304','Quận Ngô Quyền',0),(189,22,'305','Quận Lê Chân',0),(190,22,'306','Quận Hải An',0),(191,22,'307','Quận Kiến An',0),(192,22,'308','Quận Đồ Sơn',0),(193,22,'309','Quận Dương Kinh',0),(194,22,'311','Huyện Thuỷ Nguyên',0),(195,22,'313','Huyện An Lão',0),(196,22,'314','Huyện Kiến Thuỵ',0),(197,22,'315','Huyện Tiên Lãng',0),(198,22,'316','Huyện Vĩnh Bảo',0),(199,23,'325','Huyện Văn Lâm',0),(200,23,'326','Huyện Văn Giang',0),(201,23,'327','Huyện Yên Mỹ',0),(202,23,'328','Huyện Mỹ Hào',0),(203,23,'329','Huyện Ân Thi',0),(204,23,'330','Huyện Khoái Châu',0),(205,23,'331','Huyện Kim Động',0),(206,23,'332','Huyện Tiên Lữ',0),(207,23,'333','Huyện Phù Cừ',0),(208,24,'336','Thành phố Thái Bình',0),(209,24,'338','Huyện Quỳnh Phụ',0),(210,24,'339','Huyện Hưng Hà',0),(211,24,'340','Huyện Đông Hưng',0),(212,24,'341','Huyện Thái Thụy',0),(213,24,'342','Huyện Tiền Hải',0),(214,24,'343','Huyện Kiến Xương',0),(215,24,'344','Huyện Vũ Thư',0),(216,25,'349','Huyện Duy Tiên',0),(217,25,'350','Huyện Kim Bảng',0),(218,25,'351','Huyện Thanh Liêm',0),(219,25,'352','Huyện Bình Lục',0),(220,25,'353','Huyện Lý Nhân',0),(221,26,'356','Thành phố Nam Định',0),(222,26,'358','Huyện Mỹ Lộc',0),(223,26,'359','Huyện Vụ Bản',0),(224,26,'360','Huyện ý Yên',0),(225,26,'361','Huyện Nghĩa Hưng',0),(226,26,'362','Huyện Nam Trực',0),(227,26,'363','Huyện Trực Ninh',0),(228,26,'364','Huyện Xuân Trường',0),(229,26,'365','Huyện Giao Thủy',0),(230,26,'366','Huyện Hải Hậu',0),(231,27,'369','Thành phố Ninh Bình',0),(232,27,'370','Thị xã Tam Điệp',0),(233,27,'372','Huyện Nho Quan',0),(234,27,'373','Huyện Gia Viễn',0),(235,27,'374','Huyện Hoa Lư',0),(236,27,'375','Huyện Yên Khánh',0),(237,27,'376','Huyện Kim Sơn',0),(238,27,'377','Huyện Yên Mô',0),(239,28,'380','Thành phố Thanh Hóa',0),(240,28,'384','Huyện Mường Lát',0),(241,28,'386','Huyện Bá Thước',0),(242,28,'389','Huyện Ngọc Lặc',0),(243,28,'391','Huyện Thạch Thành',0),(244,28,'392','Huyện Hà Trung',0),(245,28,'394','Huyện Yên Định',0),(246,28,'395','Huyện Thọ Xuân',0),(247,28,'397','Huyện Triệu Sơn',0),(248,28,'398','Huyện Thiệu Hóa',0),(249,28,'400','Huyện Hậu Lộc',0),(250,28,'401','Huyện Nga Sơn',0),(251,28,'403','Huyện Như Thanh',0),(252,28,'405','Huyện Đông Sơn',0),(253,28,'406','Huyện Quảng Xương',0),(254,29,'412','Thành phố Vinh',0),(255,29,'413','Thị xã Cửa Lò',0),(256,29,'414','Thị xã Thái Hoà',0),(257,29,'417','Huyện Kỳ Sơn',0),(258,29,'418','Huyện Tương Dương',0),(259,29,'419','Huyện Nghĩa Đàn',0),(260,29,'420','Huyện Quỳ Hợp',0),(261,29,'421','Huyện Quỳnh Lưu',0),(262,29,'422','Huyện Con Cuông',0),(263,29,'424','Huyện Anh Sơn',0),(264,29,'425','Huyện Diễn Châu',0),(265,29,'426','Huyện Yên Thành',0),(266,29,'427','Huyện Đô Lương',0),(267,29,'428','Huyện Thanh Chương',0),(268,29,'429','Huyện Nghi Lộc',0),(269,29,'431','Huyện Hưng Nguyên',0),(270,30,'436','Thành phố Hà Tĩnh',0),(271,30,'439','Huyện Hương Sơn',0),(272,30,'440','Huyện Đức Thọ',0),(273,30,'442','Huyện Nghi Xuân',0),(274,30,'443','Huyện Can Lộc',0),(275,30,'444','Huyện Hương Khê',0),(276,30,'445','Huyện Thạch Hà',0),(277,30,'446','Huyện Cẩm Xuyên',0),(278,30,'447','Huyện Kỳ Anh',0),(279,30,'448','Huyện Lộc Hà',0),(280,31,'450','Thành Phố Đồng Hới',0),(281,31,'452','Huyện Minh Hóa',0),(282,31,'453','Huyện Tuyên Hóa',0),(283,31,'454','Huyện Quảng Trạch',0),(284,31,'455','Huyện Bố Trạch',0),(285,31,'456','Huyện Quảng Ninh',0),(286,31,'457','Huyện Lệ Thủy',0),(287,32,'461','Thị xã Đông Hà',0),(288,32,'462','Thị xã Quảng Trị',0),(289,32,'464','Huyện Vĩnh Linh',0),(290,32,'465','Huyện Hướng Hóa',0),(291,32,'466','Huyện Gio Linh',0),(292,32,'467','Huyện Đa Krông',0),(293,32,'469','Huyện Triệu Phong',0),(294,32,'470','Huyện Hải Lăng',0),(295,33,'474','Thành phố Huế',0),(296,33,'476','Huyện Phong Điền',0),(297,33,'477','Huyện Quảng Điền',0),(298,33,'478','Huyện Phú Vang',0),(299,33,'479','Huyện Hương Thủy',0),(300,33,'480','Huyện Hương Trà',0),(301,33,'481','Huyện A Lưới',0),(302,33,'482','Huyện Phú Lộc',0),(303,33,'483','Huyện Nam Đông',0),(304,34,'490','Quận Liên Chiểu',0),(305,34,'491','Quận Thanh Khê',0),(306,34,'492','Quận Hải Châu',0),(307,34,'494','Quận Ngũ Hành Sơn',0),(308,34,'495','Quận Cẩm Lệ',0),(309,34,'497','Huyện Hòa Vang',0),(310,35,'502','Thành phố Tam Kỳ',0),(311,35,'503','Thành phố Hội An',0),(312,35,'504','Huyện Tây Giang',0),(313,35,'506','Huyện Đại Lộc',0),(314,35,'507','Huyện Điện Bàn',0),(315,35,'508','Huyện Duy Xuyên',0),(316,35,'509','Huyện Quế Sơn',0),(317,35,'511','Huyện Phước Sơn',0),(318,35,'512','Huyện Hiệp Đức',0),(319,35,'513','Huyện Thăng Bình',0),(320,35,'514','Huyện Tiên Phước',0),(321,35,'515','Huyện Bắc Trà My',0),(322,35,'516','Huyện Nam Trà My',0),(323,35,'517','Huyện Núi Thành',0),(324,35,'518','Huyện Phú Ninh',0),(325,36,'522','Thành phố Quảng Ngãi',0),(326,36,'524','Huyện Bình Sơn',0),(327,36,'525','Huyện Trà Bồng',0),(328,36,'526','Huyện Tây Trà',0),(329,36,'527','Huyện Sơn Tịnh',0),(330,36,'528','Huyện Tư Nghĩa',0),(331,36,'529','Huyện Sơn Hà',0),(332,36,'530','Huyện Sơn Tây',0),(333,36,'531','Huyện Minh Long',0),(334,36,'533','Huyện Mộ Đức',0),(335,36,'534','Huyện Đức Phổ',0),(336,36,'535','Huyện Ba Tơ',0),(337,37,'540','Thành phố Qui Nhơn',0),(338,37,'542','Huyện An Lão',0),(339,37,'543','Huyện Hoài Nhơn',0),(340,37,'544','Huyện Hoài Ân',0),(341,37,'545','Huyện Phù Mỹ',0),(342,37,'546','Huyện Vĩnh Thạnh',0),(343,37,'547','Huyện Tây Sơn',0),(344,37,'548','Huyện Phù Cát',0),(345,37,'549','Huyện An Nhơn',0),(346,38,'555','Thành phố Tuy Hoà',0),(347,38,'557','Huyện Sông Cầu',0),(348,38,'558','Huyện Đồng Xuân',0),(349,38,'559','Huyện Tuy An',0),(350,38,'560','Huyện Sơn Hòa',0),(351,38,'561','Huyện Sông Hinh',0),(352,38,'562','Huyện Tây Hoà',0),(353,39,'568','Thành phố Nha Trang',0),(354,39,'569','Thị xã Cam Ranh',0),(355,39,'570','Huyện Cam Lâm',0),(356,39,'571','Huyện Vạn Ninh',0),(357,39,'572','Huyện Ninh Hòa',0),(358,39,'573','Huyện Khánh Vĩnh',0),(359,39,'574','Huyện Diên Khánh',0),(360,39,'575','Huyện Khánh Sơn',0),(361,40,'582','Thành phố Phan Rang-Tháp Chàm',0),(362,40,'584','Huyện Bác ái',0),(363,40,'585','Huyện Ninh Sơn',0),(364,40,'586','Huyện Ninh Hải',0),(365,40,'587','Huyện Ninh Phước',0),(366,41,'593','Thành phố Phan Thiết',0),(367,41,'594','Thị xã La Gi',0),(368,41,'595','Huyện Tuy Phong',0),(369,41,'596','Huyện Bắc Bình',0),(370,41,'597','Huyện Hàm Thuận Bắc',0),(371,41,'598','Huyện Hàm Thuận Nam',0),(372,41,'599','Huyện Tánh Linh',0),(373,41,'600','Huyện Đức Linh',0),(374,42,'608','Thị xã Kon Tum',0),(375,42,'610','Huyện Đắk Glei',0),(376,42,'611','Huyện Ngọc Hồi',0),(377,42,'612','Huyện Đắk Tô',0),(378,42,'613','Huyện Kon Plông',0),(379,42,'614','Huyện Kon Rẫy',0),(380,42,'615','Huyện Đắk Hà',0),(381,42,'616','Huyện Sa Thầy',0),(382,43,'622','Thành phố Pleiku',0),(383,43,'623','Thị xã An Khê',0),(384,43,'624','Thị xã Ayun Pa',0),(385,43,'625','Huyện KBang',0),(386,43,'626','Huyện Đăk Đoa',0),(387,43,'627','Huyện Chư Păh',0),(388,43,'628','Huyện Ia Grai',0),(389,43,'629','Huyện Mang Yang',0),(390,43,'630','Huyện Kông Chro',0),(391,43,'632','Huyện Chư Prông',0),(392,43,'633','Huyện Chư Sê',0),(393,43,'635','Huyện Ia Pa',0),(394,43,'637','Huyện Krông Pa',0),(395,44,'643','Thành phố Buôn Ma Thuột',0),(396,44,'645','Huyện Ea H\'leo',0),(397,44,'649','Huyện Krông Búk',0),(398,44,'650','Huyện Krông Năng',0),(399,44,'653','Huyện Krông Bông',0),(400,45,'660','Thị xã Gia Nghĩa',0),(401,45,'661','Huyện Đăk Glong',0),(402,45,'662','Huyện Cư Jút',0),(403,45,'663','Huyện Đắk Mil',0),(404,45,'665','Huyện Đắk Song',0),(405,45,'666','Huyện Đắk R\'Lấp',0),(406,46,'672','Thành phố Đà Lạt',0),(407,46,'673','Thị xã Bảo Lộc',0),(408,46,'674','Huyện Đam Rông',0),(409,46,'675','Huyện Lạc Dương',0),(410,46,'676','Huyện Lâm Hà',0),(411,46,'677','Huyện Đơn Dương',0),(412,46,'678','Huyện Đức Trọng',0),(413,46,'679','Huyện Di Linh',0),(414,46,'680','Huyện Bảo Lâm',0),(415,46,'681','Huyện Đạ Huoai',0),(416,46,'682','Huyện Đạ Tẻh',0),(417,46,'683','Huyện Cát Tiên',0),(418,47,'689','Thị xã Đồng Xoài',0),(419,47,'691','Huyện Phước Long',0),(420,47,'692','Huyện Lộc Ninh',0),(421,47,'693','Huyện Bù Đốp',0),(422,47,'694','Huyện Bình Long',0),(423,47,'695','Huyện Đồng Phù',0),(424,47,'696','Huyện Bù Đăng',0),(425,48,'703','Thị xã Tây Ninh',0),(426,48,'705','Huyện Tân Biên',0),(427,48,'706','Huyện Tân Châu',0),(428,48,'707','Huyện Dương Minh Châu',0),(429,48,'708','Huyện Châu Thành',0),(430,48,'709','Huyện Hòa Thành',0),(431,48,'710','Huyện Gò Dầu',0),(432,48,'711','Huyện Bến Cầu',0),(433,48,'712','Huyện Trảng Bàng',0),(434,49,'718','Thị xã Thủ Dầu Một',0),(435,49,'720','Huyện Dầu Tiếng',0),(436,49,'721','Huyện Bến Cát',0),(437,49,'722','Huyện Phú Giáo',0),(438,49,'723','Huyện Tân Uyên',0),(439,49,'724','Huyện Dĩ An',0),(440,49,'725','Huyện Thuận An',0),(441,50,'731','Thành phố Biên Hòa',0),(442,50,'732','Thị xã Long Khánh',0),(443,50,'734','Huyện Tân Phú',0),(444,50,'735','Huyện Vĩnh Cửu',0),(445,50,'736','Huyện Định Quán',0),(446,50,'737','Huyện Trảng Bom',0),(447,50,'738','Huyện Thống Nhất',0),(448,50,'739','Huyện Cẩm Mỹ',0),(449,50,'740','Huyện Long Thành',0),(450,50,'741','Huyện Xuân Lộc',0),(451,51,'747','Thành phố Vũng Tàu',0),(452,51,'748','Thị xã Bà Rịa',0),(453,51,'750','Huyện Châu Đức',0),(454,51,'751','Huyện Xuyên Mộc',0),(455,51,'753','Huyện Đất Đỏ',0),(456,52,'760','Quận 1',0),(457,52,'761','Quận 12',0),(458,52,'762','Quận Thủ Đức',0),(459,52,'763','Quận 9',0),(460,52,'764','Quận Gò Vấp',0),(461,52,'765','Quận Bình Thạnh',0),(462,52,'766','Quận Tân Bình',0),(463,52,'767','Quận Tân Phú',0),(464,52,'768','Quận Phú Nhuận',0),(465,52,'769','Quận 2',0),(466,52,'770','Quận 3',0),(467,52,'771','Quận 10',0),(468,52,'772','Quận 11',0),(469,52,'773','Quận 4',0),(470,52,'774','Quận 5',0),(471,52,'775','Quận 6',0),(472,52,'776','Quận 8',0),(473,52,'783','Huyện Củ Chi',0),(474,52,'784','Huyện Hóc Môn',0),(475,52,'785','Huyện Bình Chánh',0),(476,52,'786','Huyện Nhà Bè',0),(477,53,'794','Thị xã Tân An',0),(478,53,'796','Huyện Tân Hưng',0),(479,53,'798','Huyện Mộc Hóa',0),(480,53,'799','Huyện Tân Thạnh',0),(481,53,'800','Huyện Thạnh Hóa',0),(482,53,'801','Huyện Đức Huệ',0),(483,53,'802','Huyện Đức Hòa',0),(484,53,'803','Huyện Bến Lức',0),(485,53,'804','Huyện Thủ Thừa',0),(486,53,'805','Huyện Tân Trụ',0),(487,53,'806','Huyện Cần Đước',0),(488,53,'807','Huyện Cần Giuộc',0),(489,53,'808','Huyện Châu Thành',0),(490,54,'815','Thành phố Mỹ Tho',0),(491,54,'816','Thị xã Gò Công',0),(492,54,'818','Huyện Tân Phước',0),(493,54,'819','Huyện Cái Bè',0),(494,54,'820','Huyện Cai Lậy',0),(495,54,'821','Huyện Châu Thành',0),(496,54,'822','Huyện Chợ Gạo',0),(497,54,'823','Huyện Gò Công Tây',0),(498,55,'829','Thị xã Bến Tre',0),(499,55,'831','Huyện Châu Thành',0),(500,55,'832','Huyện Chợ Lách',0),(501,55,'833','Huyện Mỏ Cày',0),(502,55,'834','Huyện Giồng Trôm',0),(503,55,'835','Huyện Bình Đại',0),(504,55,'836','Huyện Ba Tri',0),(505,55,'837','Huyện Thạnh Phú',0),(506,56,'842','Thị xã Trà Vinh',0),(507,56,'844','Huyện Càng Long',0),(508,56,'845','Huyện Cầu Kè',0),(509,56,'846','Huyện Tiểu Cần',0),(510,56,'847','Huyện Châu Thành',0),(511,56,'848','Huyện Cầu Ngang',0),(512,56,'849','Huyện Trà Cú',0),(513,57,'855','Thị xã Vĩnh Long',0),(514,57,'857','Huyện Long Hồ',0),(515,57,'858','Huyện Mang Thít',0),(516,57,'859','Huyện  Vũng Liêm',0),(517,57,'860','Huyện Tam Bình',0),(518,57,'861','Huyện Bình Minh',0),(519,57,'862','Huyện Trà Ôn',0),(520,58,'866','Thành phố Cao Lãnh',0),(521,58,'867','Thị xã Sa Đéc',0),(522,58,'869','Huyện Tân Hồng',0),(523,58,'870','Huyện Hồng Ngự',0),(524,58,'871','Huyện Tam Nông',0),(525,58,'872','Huyện Tháp Mười',0),(526,58,'873','Huyện Cao Lãnh',0),(527,58,'874','Huyện Thanh Bình',0),(528,58,'875','Huyện Lấp Vò',0),(529,59,'883','Thành phố Long Xuyên',0),(530,59,'884','Thị xã Châu Đốc',0),(531,59,'886','Huyện An Phú',0),(532,59,'887','Huyện Tân Châu',0),(533,59,'888','Huyện Phú Tân',0),(534,59,'889','Huyện Châu Phú',0),(535,59,'890','Huyện Tịnh Biên',0),(536,59,'891','Huyện Tri Tôn',0),(537,59,'892','Huyện Châu Thành',0),(538,59,'893','Huyện Chợ Mới',0),(539,59,'894','Huyện Thoại Sơn',0),(540,60,'899','Thành phố Rạch Giá',0),(541,60,'900','Thị xã Hà Tiên',0),(542,60,'902','Huyện Kiên Lương',0),(543,60,'903','Huyện Hòn Đất',0),(544,60,'904','Huyện Tân Hiệp',0),(545,60,'905','Huyện Châu Thành',0),(546,60,'906','Huyện Giồng Riềng',0),(547,60,'907','Huyện Gò Quao',0),(548,60,'908','Huyện An Biên',0),(549,60,'909','Huyện An Minh',0),(550,60,'910','Huyện Vĩnh Thuận',0),(551,61,'916','Quận Ninh Kiều',0),(552,61,'917','Quận Ô Môn',0),(553,61,'918','Quận Bình Thuỷ',0),(554,61,'919','Quận Cái Răng',0),(555,61,'924','Huyện Vĩnh Thạnh',0),(556,61,'925','Huyện Cờ Đỏ',0),(557,61,'927','Huyện Thới Lai',0),(558,62,'930','Thị xã Vị Thanh',0),(559,62,'931','Thị xã Ngã Bảy',0),(560,62,'932','Huyện Châu Thành A',0),(561,62,'934','Huyện Phụng Hiệp',0),(562,62,'936','Huyện Long Mỹ',0),(563,63,'941','Thành phố Sóc Trăng',0),(564,63,'942','Huyện Châu Thành',0),(565,63,'943','Huyện Kế Sách',0),(566,63,'944','Huyện Mỹ Tú',0),(567,63,'945','Huyện Cù Lao Dung',0),(568,63,'946','Huyện Long Phú',0),(569,63,'947','Huyện Mỹ Xuyên',0),(570,63,'948','Huyện Ngã Năm',0),(571,64,'954','Thị xã Bạc Liêu',0),(572,64,'956','Huyện Hồng Dân',0),(573,64,'957','Huyện Phước Long',0),(574,64,'958','Huyện Vĩnh Lợi',0),(575,64,'959','Huyện Giá Rai',0),(576,64,'960','Huyện Đông Hải',0),(577,64,'961','Huyện Hoà Bình',0),(578,65,'964','Thành phố Cà Mau',0),(579,65,'966','Huyện U Minh',0),(580,65,'967','Huyện Thới Bình',0),(581,65,'968','Huyện Trần Văn Thời',0),(582,65,'969','Huyện Cái Nước',0),(583,65,'970','Huyện Đầm Dơi',0),(584,65,'971','Huyện Năm Căn',0);

/*Table structure for table `mk_email` */

DROP TABLE IF EXISTS `mk_email`;

CREATE TABLE `mk_email` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên mẫu',
  `title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tiêu đề email',
  `content` text COLLATE utf8_unicode_ci COMMENT 'nội dung email',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Email mẫu';

/*Data for the table `mk_email` */

insert  into `mk_email`(`email_id`,`name`,`title`,`content`,`note`,`status`,`deleted`) values (1,'Tri ân khách hàng','Tri ân khách hàng nhân dịp 20/11','<p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif;\">Chương trình diễn ra tại các showroom của hệ thống với mức&nbsp;<span style=\"font-weight: 700;\">giảm giá ưu đãi lên đến 60%</span>&nbsp;trong vòng 1 tuần từ ngày&nbsp;<em>17/10/2014 cho đến hết ngày 26/10/2014</em>.</p><h2 style=\"font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 32px; color: rgb(38, 38, 38); text-align: center;\"><span style=\"color: rgb(0, 0, 255);\">K&amp;K Fashion big sale off nhân dịp 20/10</span></h2><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\"><a href=\"http://kkfashion.vn/wp-content/uploads/2014/10/kk-fashion-sale-off-nhan-dip-20-10.jpg\" style=\"color: rgb(137, 39, 112);\"></a></p><div class=\"img-shadow\" style=\"text-align: center; margin: 25px 0px;\"><a href=\"http://kkfashion.vn/wp-content/uploads/2014/10/kk-fashion-sale-off-nhan-dip-20-10.jpg\" style=\"color: rgb(137, 39, 112);\"><img class=\"aligncenter size-full wp-image-54878 img-thumbnail\" alt=\"K&amp;K Fashion Big Sale Off nhân dịp 20/10\" src=\"http://kkfashion.vn/wp-content/uploads/2014/10/kk-fashion-sale-off-nhan-dip-20-10.jpg\" width=\"560\" height=\"292\" style=\"border: none; padding: 5px; line-height: 1.428571429; border-radius: 0px; margin: 10px 0px 0px; background-image: none; background-attachment: scroll; background-size: initial; background-origin: initial; background-clip: initial; background-position: 0px 0px; background-repeat: repeat;\"></a></div><p></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif;\">Đến với chương trình đặc biệt này, khách hàng không chỉ tìm được cho mình những chiếc&nbsp;<a href=\"http://kkfashion.vn/san-pham/vay-dam-cong-so\" style=\"color: rgb(137, 39, 112);\">đầm công sở đẹp</a>nhất với giá cả ưu đãi nhất mà còn được hưởng những dịch vụ chăm sóc tốt nhất từ K&amp;K Fashion.Càng đến sớm càng có nhiều cơ hội lựa chọn cho mình những mẫu váy, đầm ưng ý nhất, tuyệt đẹp nhất nhé.</p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif;\">Riêng showroom: F21,Tầng 1 TTTM Aeon Mall, P.Sơn kỳ,Q.Tân Phú sẽ được giảm giá 10% trên đơn hàng.</p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif;\">Đối với những khách hàng Online, đơn hàng được đặt vào đúng ngày&nbsp;<em>20.10.2014 và 21.10.2014</em>&nbsp;sẽ được giảm 20%.</p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk42-45/\" style=\"color: rgb(137, 39, 112);\"></a></p><div class=\"img-shadow\" style=\"text-align: center; margin: 25px 0px;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk42-45/\" style=\"color: rgb(137, 39, 112);\"><img alt=\"K&amp;K Fashion Sale Off nhân dịp 20-10\" src=\"http://kkfashion.vn/wp-content/uploads/images/500_750/KK42/dam-cong-so-kk42-45.jpg\" class=\"img-thumbnail\" style=\"border: none; padding: 5px; line-height: 1.428571429; border-radius: 0px; margin: 10px 0px 0px; background-image: none; background-attachment: scroll; background-size: initial; background-origin: initial; background-clip: initial; background-position: 0px 0px; background-repeat: repeat;\"></a></div><p></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\">KK42-45</p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk41-40/\" style=\"color: rgb(137, 39, 112);\"></a></p><div class=\"img-shadow\" style=\"text-align: center; margin: 25px 0px;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk41-40/\" style=\"color: rgb(137, 39, 112);\"><img alt=\"\" src=\"http://kkfashion.vn/wp-content/uploads/images/500_750/KK41/dam-cong-so-kk41-40.jpg\" width=\"500\" height=\"750\" class=\"img-thumbnail\" style=\"border: none; padding: 5px; line-height: 1.428571429; border-radius: 0px; margin: 10px 0px 0px; background-image: none; background-attachment: scroll; background-size: initial; background-origin: initial; background-clip: initial; background-position: 0px 0px; background-repeat: repeat;\"></a></div><p></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\">KK41-40</p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk40-40/\" style=\"color: rgb(137, 39, 112);\"></a></p><div class=\"img-shadow\" style=\"text-align: center; margin: 25px 0px;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk40-40/\" style=\"color: rgb(137, 39, 112);\"><img alt=\"\" src=\"http://kkfashion.vn/wp-content/uploads/images/500_750/KK40/dam-cong-so-kk40-40.jpg\" width=\"500\" height=\"750\" class=\"img-thumbnail\" style=\"border: none; padding: 5px; line-height: 1.428571429; border-radius: 0px; margin: 10px 0px 0px; background-image: none; background-attachment: scroll; background-size: initial; background-origin: initial; background-clip: initial; background-position: 0px 0px; background-repeat: repeat;\"></a></div><p></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\">KK40-40</p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk41-19/\" style=\"color: rgb(137, 39, 112);\"></a></p><div class=\"img-shadow\" style=\"text-align: center; margin: 25px 0px;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk41-19/\" style=\"color: rgb(137, 39, 112);\"><img alt=\"\" src=\"http://kkfashion.vn/wp-content/uploads/images/500_750/KK41/dam-cong-so-kk41-19.jpg\" width=\"500\" height=\"750\" class=\"img-thumbnail\" style=\"border: none; padding: 5px; line-height: 1.428571429; border-radius: 0px; margin: 10px 0px 0px; background-image: none; background-attachment: scroll; background-size: initial; background-origin: initial; background-clip: initial; background-position: 0px 0px; background-repeat: repeat;\"></a></div><p></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\">KK41-19</p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk41-42/\" style=\"color: rgb(137, 39, 112);\"></a></p><div class=\"img-shadow\" style=\"text-align: center; margin: 25px 0px;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk41-42/\" style=\"color: rgb(137, 39, 112);\"><img alt=\"\" src=\"http://kkfashion.vn/wp-content/uploads/images/500_750/KK41/dam-cong-so-kk41-42.jpg\" width=\"500\" height=\"750\" class=\"img-thumbnail\" style=\"border: none; padding: 5px; line-height: 1.428571429; border-radius: 0px; margin: 10px 0px 0px; background-image: none; background-attachment: scroll; background-size: initial; background-origin: initial; background-clip: initial; background-position: 0px 0px; background-repeat: repeat;\"></a></div><p></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\">KK41-42</p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk42-58/\" style=\"color: rgb(137, 39, 112);\"></a></p><div class=\"img-shadow\" style=\"text-align: center; margin: 25px 0px;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk42-58/\" style=\"color: rgb(137, 39, 112);\"><img alt=\"\" src=\"http://kkfashion.vn/wp-content/uploads/images/500_750/KK42/dam-cong-so-kk42-58.jpg\" width=\"500\" height=\"750\" class=\"img-thumbnail\" style=\"border: none; padding: 5px; line-height: 1.428571429; border-radius: 0px; margin: 10px 0px 0px; background-image: none; background-attachment: scroll; background-size: initial; background-origin: initial; background-clip: initial; background-position: 0px 0px; background-repeat: repeat;\"></a></div><p></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\">KK42-58</p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk41-51/\" style=\"color: rgb(137, 39, 112);\"></a></p><div class=\"img-shadow\" style=\"text-align: center; margin: 25px 0px;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk41-51/\" style=\"color: rgb(137, 39, 112);\"><img alt=\"\" src=\"http://kkfashion.vn/wp-content/uploads/images/500_750/KK41/dam-cong-so-kk41-51.jpg\" width=\"500\" height=\"750\" class=\"img-thumbnail\" style=\"border: none; padding: 5px; line-height: 1.428571429; border-radius: 0px; margin: 10px 0px 0px; background-image: none; background-attachment: scroll; background-size: initial; background-origin: initial; background-clip: initial; background-position: 0px 0px; background-repeat: repeat;\"></a></div><p></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\">KK41-51</p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk42-53/\" style=\"color: rgb(218, 112, 214); outline: 0px;\"></a></p><div class=\"img-shadow\" style=\"text-align: center; margin: 25px 0px;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk42-53/\" style=\"color: rgb(218, 112, 214); outline: 0px;\"><img alt=\"\" src=\"http://kkfashion.vn/wp-content/uploads/images/500_750/KK42/dam-cong-so-kk42-53.jpg\" width=\"500\" height=\"750\" class=\"img-thumbnail\" style=\"border: none rgb(161, 81, 170); padding: 5px; line-height: 1.428571429; border-radius: 0px; margin: 10px 0px 0px; cursor: pointer; background-image: none; background-attachment: scroll; background-size: initial; background-origin: initial; background-clip: initial; background-position: 0px 0px; background-repeat: repeat;\"></a></div><p></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\">KK42-53</p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk40-51/\" style=\"color: rgb(137, 39, 112);\"></a></p><div class=\"img-shadow\" style=\"text-align: center; margin: 25px 0px;\"><a href=\"http://kkfashion.vn/shop/dam-cong-so-kk40-51/\" style=\"color: rgb(137, 39, 112);\"><img alt=\"\" src=\"http://kkfashion.vn/wp-content/uploads/images/500_750/KK40/dam-cong-so-kk40-51.jpg\" width=\"500\" height=\"750\" class=\"img-thumbnail\" style=\"border: none; padding: 5px; line-height: 1.428571429; border-radius: 0px; margin: 10px 0px 0px; background-image: none; background-attachment: scroll; background-size: initial; background-origin: initial; background-clip: initial; background-position: 0px 0px; background-repeat: repeat;\"></a></div><p></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif; text-align: center;\">KK40-51</p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif;\">Mọi người hãy nhanh chóng đến các Showroom của K&amp;K Fashion và lựa cho mình những bộ cánh ưng ý với mức giá rẻ nhất nhé !!!</p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif;\"><span style=\"font-weight: 700;\">Hệ thống showroom K&amp;K Fashion:</span></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif;\"><em>Showroom I:268 Tô Hiến Thành, P.15, Q.10, TP.HCM. ĐT: (08) 38 62 57 91</em></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif;\"><em>Showroom II: 132A Cách Mạng Tháng Tám, P.10, Q. 3, TP. HCM – Điện thoại: (08)62.66.77.33</em></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif;\"><em>Showroom III: 78 Trần Quang Diệu, P. 14, Q. 3, TP. HCM – Điện thoại: (08)35.087.080</em></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif;\"><em>Showroom IV: 248 Phan Đình Phùng, P. 1, Q. Phú Nhuận, TP. HCM – Điện thoại: (08)35.070.456</em></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif;\"><em>Showroom V: 664 Quang Trung, P.11, Q. Gò Vấp – Điện thoại: (08)62.99.22.33</em></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif;\"><em>Showroom VI: F21, Tầng 1 TTTM Aeon Mall, P. Sơn Kỳ, Q. Tân Phú – Điện thoại: (08)35.59.25.41</em></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif;\"><em>Showroom VII: 259 Nguyễn Trãi, P. Nguyễn Cư Trinh, Q. 1, TP. HCM – Điện thoại: (08)62.913.241</em></p><p style=\"color: rgb(38, 38, 38); line-height: 20px; font-family: arial, sans-serif;\"><em>Shop Online: 78 Trần Quang Diệu, P. 14, Q. 3, TP. HCM – Điện thoại: (08)62.66.22.33</em></p>','Tri ân khách hàng thân thiết',1,0);

/*Table structure for table `mk_employee` */

DROP TABLE IF EXISTS `mk_employee`;

CREATE TABLE `mk_employee` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nhân viên';

/*Data for the table `mk_employee` */

insert  into `mk_employee`(`employee_id`,`code`,`name`,`birthday`,`gender`,`note`,`avatar`,`address`,`country_id`,`city_id`,`district_id`,`phone_1`,`phone_2`,`email`,`status`,`deleted`) values (1,'001','Admin','1990-08-24 00:00:00',1,'','','17 H? Bá Ki?n, Ho Chi Minh City, Ho Chi Minh, Vietnam',1,52,461,'123456','','xsecretx2002@yahoo.com',1,0);

/*Table structure for table `mk_object` */

DROP TABLE IF EXISTS `mk_object`;

CREATE TABLE `mk_object` (
  `object_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã nhóm',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên nhóm',
  `type` int(11) NOT NULL COMMENT 'loại nhóm đối tượng| 1/Khách hàng - 2/NCC - 3/Khách hàng & NCC',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`object_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nhóm đối tượng';

/*Data for the table `mk_object` */

insert  into `mk_object`(`object_id`,`code`,`name`,`type`,`note`,`status`,`deleted`) values (1,'N1','Nhóm 1',1,'Nhóm khách hàng 1',1,0),(2,'N2','Nhóm 2',1,'Nhóm khách hàng 2',1,0),(3,'NC1','Nhóm NCC 1',2,'Nhóm nhà cung cấp 1',1,0),(4,'NC2','Nhóm NCC 2',2,'Nhóm nhà cung cấp 2',1,0),(5,'NT1','Nhóm tổng hợp 1',3,'Nhóm khách hàng kiêm NCC 1',1,0),(6,'NT2','Nhóm tổng hợp 2',3,'Nhóm khách hàng kiêm NCC 2',1,0);

/*Table structure for table `mk_order` */

DROP TABLE IF EXISTS `mk_order`;

CREATE TABLE `mk_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'số phiếu',
  `code_sale` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã phiếu bán',
  `code_fix` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã phiếu sửa',
  `created_date` datetime DEFAULT NULL COMMENT 'ngày bán',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `customer_id` int(11) NOT NULL COMMENT 'khách hàng',
  `employee_id` int(11) NOT NULL COMMENT 'nhân viên',
  `work_id` int(11) NOT NULL COMMENT 'ca',
  `branch_id` int(11) NOT NULL COMMENT 'chi nhánh',
  `sum_price` decimal(20,2) DEFAULT NULL,
  `commission_price` decimal(20,2) DEFAULT NULL,
  `commission_percent` float NOT NULL COMMENT 'chiết khấu phần trăm',
  `total_price` decimal(20,2) DEFAULT NULL,
  `total_paid` decimal(20,2) DEFAULT NULL,
  `remain_paid` decimal(20,2) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT 'trạng thái| 1/Đã giao - 2/Chưa giao',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_kk_order_kk_customer1_idx` (`customer_id`),
  KEY `fk_kk_order_kk_employee1_idx` (`employee_id`),
  KEY `fk_kk_order_kk_work1_idx` (`work_id`),
  KEY `fk_kk_order_kk_branch1_idx` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Phiếu bán hàng';

/*Data for the table `mk_order` */

/*Table structure for table `mk_order_detail` */

DROP TABLE IF EXISTS `mk_order_detail`;

CREATE TABLE `mk_order_detail` (
  `order_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT 'phiếu bán hàng',
  `product_id` int(11) NOT NULL COMMENT 'hàng hoá',
  `quantity` int(11) NOT NULL COMMENT 'số lượng',
  `unit_id` int(11) NOT NULL COMMENT 'đơn vị tính',
  `price_export` decimal(20,2) DEFAULT NULL,
  `price_import` decimal(20,2) DEFAULT NULL,
  `commission_price` decimal(20,2) DEFAULT NULL,
  `commission_percent` float NOT NULL COMMENT 'chiết khấu phần trăm',
  `tax_percent` float DEFAULT '0' COMMENT 'VAT',
  `paid` decimal(20,2) DEFAULT NULL,
  `unpaid` decimal(20,2) DEFAULT NULL,
  `type` int(11) NOT NULL COMMENT 'loại| 1/Mua mới - 2/Sửa đồ',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`order_detail_id`),
  KEY `fk_kk_order_detail_kk_order1_idx` (`order_id`),
  KEY `fk_kk_order_detail_kk_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Chi tiết phiếu bán hàng';

/*Data for the table `mk_order_detail` */

/*Table structure for table `mk_order_fix` */

DROP TABLE IF EXISTS `mk_order_fix`;

CREATE TABLE `mk_order_fix` (
  `order_fix_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT 'phiếu bán hàng',
  `order_detail_id` int(11) NOT NULL COMMENT 'chi tiết phiếu bán hàng',
  `store_id` int(11) NOT NULL COMMENT 'kho hàng',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên khách hàng',
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'số điện thoại',
  `return_date` datetime DEFAULT NULL COMMENT 'ngày lấy đồ',
  `content` text COLLATE utf8_unicode_ci COMMENT 'nội dung sửa',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`order_fix_id`),
  KEY `fk_kk_order_fix_kk_order1_idx` (`order_id`),
  KEY `fk_kk_order_fix_kk_order_detail1_idx` (`order_detail_id`),
  KEY `fk_kk_order_fix_kk_store1_idx` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Phiếu sửa đồ';

/*Data for the table `mk_order_fix` */

/*Table structure for table `mk_order_paid` */

DROP TABLE IF EXISTS `mk_order_paid`;

CREATE TABLE `mk_order_paid` (
  `order_paid_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT 'phiếu bán hàng',
  `bank_id` int(11) NOT NULL COMMENT 'ngân hàng thanh toán',
  `paid_card` decimal(20,2) DEFAULT NULL,
  `paid_cash` decimal(20,2) DEFAULT NULL,
  `paid_return` decimal(20,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`order_paid_id`),
  KEY `fk_kk_order_paid_kk_order1_idx` (`order_id`),
  KEY `fk_kk_order_paid_kk_bank1_idx` (`bank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Lịch sử thanh toán phiếu bán hàng';

/*Data for the table `mk_order_paid` */

/*Table structure for table `mk_order_voucher` */

DROP TABLE IF EXISTS `mk_order_voucher`;

CREATE TABLE `mk_order_voucher` (
  `order_voucher_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT 'phiếu bán hàng',
  `order_paid_id` int(11) NOT NULL COMMENT 'lịch sử thanh toán',
  `price` decimal(20,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL COMMENT 'số lượng phiếu',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`order_voucher_id`),
  KEY `fk_kk_order_voucher_kk_order1_idx` (`order_id`),
  KEY `fk_kk_order_voucher_kk_order_paid1_idx` (`order_paid_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Thanh toán qua phiếu quà tặng';

/*Data for the table `mk_order_voucher` */

/*Table structure for table `mk_permission` */

DROP TABLE IF EXISTS `mk_permission`;

CREATE TABLE `mk_permission` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL COMMENT 'nhóm người dùng',
  `user_id` int(11) NOT NULL COMMENT 'người dùng',
  `permission` text COLLATE utf8_unicode_ci COMMENT 'quyền với từng route (xem, thêm, sửa, xoá)',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`permission_id`),
  KEY `fk_kk_permission_kk_user_group1_idx` (`user_group_id`),
  KEY `fk_kk_permission_kk_user1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Phân quyền';

/*Data for the table `mk_permission` */

insert  into `mk_permission`(`permission_id`,`user_group_id`,`user_id`,`permission`,`deleted`) values (1,1,0,'a:83:{s:18:\"report/sale_profit\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"report/sale_return\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:23:\"report/sale_return_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"report/store_check\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:19:\"report/store_export\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:24:\"report/store_export_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:20:\"report/store_iestock\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:19:\"report/store_import\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:24:\"report/store_import_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"report/store_stock\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:21:\"report/store_transfer\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:26:\"report/store_transfer_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:25:\"report/summary_bestseller\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:23:\"report/summary_customer\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"report/summary_product\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:21:\"report/summary_result\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:21:\"report/summary_return\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:25:\"orderreturn/return_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:31:\"returndetail/return_detail_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:23:\"orderreturn/return_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"employee/employee_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"object/object_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"order/order_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:27:\"orderfix/order_deposit_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:29:\"orderdetail/order_detail_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:23:\"orderfix/order_fix_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:16:\"order/order_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:25:\"orderpaid/order_paid_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:31:\"ordervoucher/order_voucher_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:26:\"permission/permission_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:31:\"productgroup/product_group_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:20:\"product/product_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:29:\"productunit/product_unit_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:21:\"report/sale_commision\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"report/sale_income\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:25:\"report/sale_income_branch\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"report/sale_income_day\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:23:\"report/sale_income_user\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:16:\"report/sale_item\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:21:\"report/sale_item_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:13:\"index/account\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:14:\"bank/bank_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:20:\"barcode/barcode_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:23:\"billbank/bill_bank_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:27:\"billbranch/bill_branch_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:29:\"billincome/bill_income_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:27:\"billincome/bill_income_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:31:\"billoutcome/bill_outcome_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:29:\"billoutcome/bill_outcome_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:33:\"billtransfer/bill_transfer_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:31:\"billtransfer/bill_transfer_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"branch/branch_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:27:\"branchtype/branch_type_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:14:\"city/city_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:20:\"contact/contact_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:20:\"country/country_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"currency/currency_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"customer/customer_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"district/district_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:16:\"email/email_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:27:\"storecheck/store_check_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:42:\"storeexportgroup/store_export_group_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:40:\"storeexportgroup/store_export_group_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:29:\"storeexport/store_export_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:42:\"storeimportgroup/store_import_group_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:40:\"storeimportgroup/store_import_group_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:29:\"storeimport/store_import_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:16:\"store/store_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:31:\"storeproduct/store_product_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:33:\"storeproduct/store_product_report\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:46:\"storetransfergroup/store_transfer_group_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:44:\"storetransfergroup/store_transfer_group_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:33:\"storetransfer/store_transfer_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"supplier/supplier_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:14:\"unit/unit_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:25:\"usergroup/user_group_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:14:\"user/user_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:14:\"work/work_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:14:\"send/send_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:20:\"setting/setting_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:12:\"sms/sms_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:40:\"storecheckgroup/store_check_group_action\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:38:\"storecheckgroup/store_check_group_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}}',0),(2,0,1,'a:83:{s:13:\"index/account\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:14:\"bank/bank_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:20:\"barcode/barcode_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:23:\"billbank/bill_bank_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:27:\"billbranch/bill_branch_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:29:\"billincome/bill_income_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:27:\"billincome/bill_income_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:31:\"billoutcome/bill_outcome_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:29:\"billoutcome/bill_outcome_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:33:\"billtransfer/bill_transfer_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:31:\"billtransfer/bill_transfer_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"branch/branch_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:27:\"branchtype/branch_type_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:14:\"city/city_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:20:\"contact/contact_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:20:\"country/country_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"currency/currency_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"customer/customer_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"district/district_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:16:\"email/email_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"report/sale_profit\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"report/sale_return\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:23:\"report/sale_return_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"report/store_check\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:19:\"report/store_export\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:24:\"report/store_export_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:20:\"report/store_iestock\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:19:\"report/store_import\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:24:\"report/store_import_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"report/store_stock\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:21:\"report/store_transfer\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:26:\"report/store_transfer_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:25:\"report/summary_bestseller\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:23:\"report/summary_customer\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"report/summary_product\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:21:\"report/summary_result\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:21:\"report/summary_return\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:25:\"orderreturn/return_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:31:\"returndetail/return_detail_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:23:\"orderreturn/return_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"employee/employee_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"object/object_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"order/order_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:27:\"orderfix/order_deposit_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:29:\"orderdetail/order_detail_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:23:\"orderfix/order_fix_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:16:\"order/order_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:25:\"orderpaid/order_paid_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:31:\"ordervoucher/order_voucher_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:26:\"permission/permission_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:31:\"productgroup/product_group_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:20:\"product/product_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:29:\"productunit/product_unit_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:21:\"report/sale_commision\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"report/sale_income\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:25:\"report/sale_income_branch\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"report/sale_income_day\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:23:\"report/sale_income_user\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:16:\"report/sale_item\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:21:\"report/sale_item_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:14:\"send/send_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:20:\"setting/setting_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:12:\"sms/sms_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:40:\"storecheckgroup/store_check_group_action\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:38:\"storecheckgroup/store_check_group_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:27:\"storecheck/store_check_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:42:\"storeexportgroup/store_export_group_action\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:40:\"storeexportgroup/store_export_group_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:29:\"storeexport/store_export_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:42:\"storeimportgroup/store_import_group_action\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:40:\"storeimportgroup/store_import_group_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:29:\"storeimport/store_import_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:16:\"store/store_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:31:\"storeproduct/store_product_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:33:\"storeproduct/store_product_report\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:46:\"storetransfergroup/store_transfer_group_action\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:44:\"storetransfergroup/store_transfer_group_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:33:\"storetransfer/store_transfer_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:22:\"supplier/supplier_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:14:\"unit/unit_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:25:\"usergroup/user_group_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:14:\"user/user_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:14:\"work/work_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}}',0),(3,2,0,'a:83:{s:13:\"index/account\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:14:\"bank/bank_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:20:\"barcode/barcode_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:23:\"billbank/bill_bank_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:27:\"billbranch/bill_branch_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:29:\"billincome/bill_income_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:27:\"billincome/bill_income_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:31:\"billoutcome/bill_outcome_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:29:\"billoutcome/bill_outcome_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:33:\"billtransfer/bill_transfer_action\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:31:\"billtransfer/bill_transfer_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:18:\"branch/branch_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:27:\"branchtype/branch_type_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:14:\"city/city_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:20:\"contact/contact_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:20:\"country/country_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"currency/currency_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"customer/customer_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"district/district_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:16:\"email/email_list\";a:4:{s:4:\"view\";s:1:\"1\";s:3:\"add\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";}s:22:\"employee/employee_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:18:\"object/object_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:18:\"order/order_action\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:27:\"orderfix/order_deposit_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:29:\"orderdetail/order_detail_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:23:\"orderfix/order_fix_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:16:\"order/order_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:25:\"orderpaid/order_paid_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:31:\"ordervoucher/order_voucher_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:26:\"permission/permission_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:31:\"productgroup/product_group_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:20:\"product/product_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:29:\"productunit/product_unit_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:21:\"report/sale_commision\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:18:\"report/sale_income\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:25:\"report/sale_income_branch\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:22:\"report/sale_income_day\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:23:\"report/sale_income_user\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:16:\"report/sale_item\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:21:\"report/sale_item_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:18:\"report/sale_profit\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:18:\"report/sale_return\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:23:\"report/sale_return_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:18:\"report/store_check\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:19:\"report/store_export\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:24:\"report/store_export_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:20:\"report/store_iestock\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:19:\"report/store_import\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:24:\"report/store_import_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:18:\"report/store_stock\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:21:\"report/store_transfer\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:26:\"report/store_transfer_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:25:\"report/summary_bestseller\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:23:\"report/summary_customer\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:22:\"report/summary_product\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:21:\"report/summary_result\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:21:\"report/summary_return\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:25:\"orderreturn/return_action\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:31:\"returndetail/return_detail_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:23:\"orderreturn/return_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:14:\"send/send_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:20:\"setting/setting_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:12:\"sms/sms_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:40:\"storecheckgroup/store_check_group_action\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:38:\"storecheckgroup/store_check_group_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:27:\"storecheck/store_check_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:42:\"storeexportgroup/store_export_group_action\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:40:\"storeexportgroup/store_export_group_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:29:\"storeexport/store_export_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:42:\"storeimportgroup/store_import_group_action\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:40:\"storeimportgroup/store_import_group_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:29:\"storeimport/store_import_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:16:\"store/store_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:31:\"storeproduct/store_product_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:33:\"storeproduct/store_product_report\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:46:\"storetransfergroup/store_transfer_group_action\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:44:\"storetransfergroup/store_transfer_group_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:33:\"storetransfer/store_transfer_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:22:\"supplier/supplier_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:14:\"unit/unit_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:25:\"usergroup/user_group_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:14:\"user/user_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}s:14:\"work/work_list\";a:4:{s:4:\"view\";i:1;s:3:\"add\";i:1;s:4:\"edit\";i:1;s:6:\"delete\";i:1;}}',0);

/*Table structure for table `mk_product` */

DROP TABLE IF EXISTS `mk_product`;

CREATE TABLE `mk_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'kho',
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã hàng',
  `code_2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã hàng 2',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên hàng hoá',
  `product_group_id` int(11) NOT NULL COMMENT 'nhóm hàng',
  `product_type` int(11) NOT NULL COMMENT '0/bình thường - 1/ký gửi - 2/dịch vụ',
  `short_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'viết tắt',
  `unit_id` int(11) NOT NULL COMMENT 'đơn vị tính',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `avatar` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'hình đại diện',
  `price_import` decimal(20,2) DEFAULT NULL,
  `price_export` decimal(20,2) DEFAULT NULL,
  `store_min` int(11) NOT NULL COMMENT 'tồn tối thiểu',
  `store_max` int(11) NOT NULL COMMENT 'tồn tối đa',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_kk_product_kk_product_group_idx` (`product_group_id`),
  KEY `fk_kk_product_kk_unit1_idx` (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Hàng hoá';

/*Data for the table `mk_product` */

/*Table structure for table `mk_product_group` */

DROP TABLE IF EXISTS `mk_product_group`;

CREATE TABLE `mk_product_group` (
  `product_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã nhóm',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên nhóm',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`product_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nhóm hàng';

/*Data for the table `mk_product_group` */

/*Table structure for table `mk_product_unit` */

DROP TABLE IF EXISTS `mk_product_unit`;

CREATE TABLE `mk_product_unit` (
  `product_unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL COMMENT 'hàng hoá',
  `unit_id` int(11) NOT NULL COMMENT 'đơn vị tính',
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên ĐVT phụ',
  `ratio` float NOT NULL COMMENT 'quy đổi',
  `price_import` decimal(20,2) DEFAULT NULL,
  `price_export` decimal(20,2) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`product_unit_id`),
  KEY `fk_kk_product_unit_kk_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Đơn vị tính phụ';

/*Data for the table `mk_product_unit` */

/*Table structure for table `mk_return` */

DROP TABLE IF EXISTS `mk_return`;

CREATE TABLE `mk_return` (
  `return_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT 'chứng từ',
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'số phiếu',
  `code_sale` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã phiếu bán',
  `code_fix` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã phiếu sửa',
  `created_date` datetime DEFAULT NULL COMMENT 'ngày lập',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `customer_id` int(11) NOT NULL COMMENT 'khách hàng',
  `employee_id` int(11) NOT NULL COMMENT 'nhân viên',
  `work_id` int(11) NOT NULL COMMENT 'ca',
  `branch_id` int(11) NOT NULL COMMENT 'chi nhánh',
  `sum_price` decimal(20,2) DEFAULT NULL,
  `commission_price` decimal(20,2) DEFAULT NULL,
  `commission_percent` float NOT NULL COMMENT 'chiết khấu phần trăm',
  `total_price` decimal(20,2) DEFAULT NULL,
  `total_paid` decimal(20,2) DEFAULT NULL,
  `total_return` decimal(20,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`return_id`),
  KEY `fk_kk_return_kk_order1_idx` (`order_id`),
  KEY `fk_kk_return_kk_customer1_idx` (`customer_id`),
  KEY `fk_kk_return_kk_employee1_idx` (`employee_id`),
  KEY `fk_kk_return_kk_work1_idx` (`work_id`),
  KEY `fk_kk_return_kk_branch1_idx` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Phiếu trả hàng';

/*Data for the table `mk_return` */

/*Table structure for table `mk_return_detail` */

DROP TABLE IF EXISTS `mk_return_detail`;

CREATE TABLE `mk_return_detail` (
  `return_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_detail_id` int(11) NOT NULL COMMENT 'chi tiết phiếu bán hàng',
  `return_id` int(11) NOT NULL COMMENT 'phiếu trả hàng',
  `product_id` int(11) NOT NULL COMMENT 'hàng hoá',
  `quantity` int(11) NOT NULL COMMENT 'số lượng',
  `unit_id` int(11) NOT NULL COMMENT 'đơn vị tính',
  `price_export` decimal(20,2) DEFAULT NULL,
  `commission_price` decimal(20,2) DEFAULT NULL,
  `commission_percent` float NOT NULL COMMENT 'chiết khấu phần trăm',
  `tax_percent` float DEFAULT '0' COMMENT 'VAT',
  `paid` decimal(20,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`return_detail_id`),
  KEY `fk_kk_return_detail_kk_return1_idx` (`return_id`),
  KEY `fk_kk_return_detail_kk_order_detail1_idx` (`order_detail_id`),
  KEY `fk_kk_return_detail_kk_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Chi tiết phiếu trả hàng';

/*Data for the table `mk_return_detail` */

/*Table structure for table `mk_send` */

DROP TABLE IF EXISTS `mk_send`;

CREATE TABLE `mk_send` (
  `send_id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL COMMENT 'nhóm đối tượng',
  `customer_id` int(11) NOT NULL COMMENT 'khách hàng',
  `email_id` int(11) NOT NULL COMMENT 'mẫu email',
  `sms_id` int(11) NOT NULL COMMENT 'mẫu sms',
  `created_date` datetime DEFAULT NULL COMMENT 'thời gian tạo',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`send_id`),
  KEY `fk_kk_send_kk_object1_idx` (`object_id`),
  KEY `fk_kk_send_kk_customer1_idx` (`customer_id`),
  KEY `fk_kk_send_kk_email1_idx` (`email_id`),
  KEY `fk_kk_send_kk_sms1_idx` (`sms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Gửi email & SMS';

/*Data for the table `mk_send` */

/*Table structure for table `mk_setting` */

DROP TABLE IF EXISTS `mk_setting`;

CREATE TABLE `mk_setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_group` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'nhóm',
  `setting_key` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'khoá',
  `setting_value` text COLLATE utf8_unicode_ci COMMENT 'giá trị',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Cấu hình hệ thống';

/*Data for the table `mk_setting` */

insert  into `mk_setting`(`setting_id`,`setting_group`,`setting_key`,`setting_value`,`deleted`) values (1,'code','pck','a:4:{s:9:\"code_char\";s:3:\"PCK\";s:11:\"code_number\";s:1:\"3\";s:20:\"code_is_number_first\";s:1:\"0\";s:21:\"code_is_branch_follow\";s:1:\"1\";}',0),(2,'code','pnk','a:4:{s:9:\"code_char\";s:3:\"PNK\";s:11:\"code_number\";s:1:\"3\";s:20:\"code_is_number_first\";s:1:\"0\";s:21:\"code_is_branch_follow\";s:1:\"1\";}',0),(3,'code','pxk','a:4:{s:9:\"code_char\";s:3:\"PXK\";s:11:\"code_number\";s:1:\"3\";s:20:\"code_is_number_first\";s:1:\"0\";s:21:\"code_is_branch_follow\";s:1:\"1\";}',0),(4,'code','pbh','a:4:{s:9:\"code_char\";s:3:\"PBH\";s:11:\"code_number\";s:1:\"3\";s:20:\"code_is_number_first\";s:1:\"0\";s:21:\"code_is_branch_follow\";s:1:\"1\";}',0),(5,'code','mbpbh','a:4:{s:9:\"code_char\";s:5:\"MBPBH\";s:11:\"code_number\";s:1:\"3\";s:20:\"code_is_number_first\";s:1:\"0\";s:21:\"code_is_branch_follow\";s:1:\"1\";}',0),(6,'code','mspbh','a:4:{s:9:\"code_char\";s:5:\"MSPBH\";s:11:\"code_number\";s:1:\"3\";s:20:\"code_is_number_first\";s:1:\"0\";s:21:\"code_is_branch_follow\";s:1:\"1\";}',0),(7,'code','pnth','a:4:{s:9:\"code_char\";s:4:\"PNTH\";s:11:\"code_number\";s:1:\"3\";s:20:\"code_is_number_first\";s:1:\"0\";s:21:\"code_is_branch_follow\";s:1:\"1\";}',0),(8,'code','mbpnth','a:4:{s:9:\"code_char\";s:6:\"MBPNTH\";s:11:\"code_number\";s:1:\"3\";s:20:\"code_is_number_first\";s:1:\"0\";s:21:\"code_is_branch_follow\";s:1:\"1\";}',0),(9,'code','mspnth','a:4:{s:9:\"code_char\";s:6:\"MSPNTH\";s:11:\"code_number\";s:1:\"3\";s:20:\"code_is_number_first\";s:1:\"0\";s:21:\"code_is_branch_follow\";s:1:\"1\";}',0),(10,'code','mpb','a:4:{s:9:\"code_char\";s:3:\"MPB\";s:11:\"code_number\";s:1:\"3\";s:20:\"code_is_number_first\";s:1:\"0\";s:21:\"code_is_branch_follow\";s:1:\"1\";}',0),(11,'code','mps','a:4:{s:9:\"code_char\";s:3:\"MPS\";s:11:\"code_number\";s:1:\"3\";s:20:\"code_is_number_first\";s:1:\"0\";s:21:\"code_is_branch_follow\";s:1:\"1\";}',0),(12,'code','pct','a:4:{s:9:\"code_char\";s:3:\"PCT\";s:11:\"code_number\";s:1:\"3\";s:20:\"code_is_number_first\";s:1:\"0\";s:21:\"code_is_branch_follow\";s:1:\"1\";}',0),(13,'code','pt','a:4:{s:9:\"code_char\";s:2:\"PT\";s:11:\"code_number\";s:1:\"3\";s:20:\"code_is_number_first\";s:1:\"0\";s:21:\"code_is_branch_follow\";s:1:\"1\";}',0),(14,'code','pc','a:4:{s:9:\"code_char\";s:2:\"PC\";s:11:\"code_number\";s:1:\"3\";s:20:\"code_is_number_first\";s:1:\"0\";s:21:\"code_is_branch_follow\";s:1:\"1\";}',0);

/*Table structure for table `mk_sms` */

DROP TABLE IF EXISTS `mk_sms`;

CREATE TABLE `mk_sms` (
  `sms_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên mẫu',
  `content` text COLLATE utf8_unicode_ci COMMENT 'nội dung sms',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`sms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='SMS mẫu';

/*Data for the table `mk_sms` */

insert  into `mk_sms`(`sms_id`,`name`,`content`,`note`,`status`,`deleted`) values (1,'Tri ân khách hàng','Cảm ơn bạn đã mua hàng tại KKFashion. Với mã voucher KHV67G bạn sẽ được giảm giá 50% khi mua sắm tại KKFashion.','Tin nhắn tri ân khách hàng',1,0);

/*Table structure for table `mk_store` */

DROP TABLE IF EXISTS `mk_store`;

CREATE TABLE `mk_store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã kho',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên kho',
  `branch_id` int(11) NOT NULL COMMENT 'chi nhánh',
  `type` int(11) NOT NULL COMMENT 'loại kho| 1/Kho hàng mới - 2/Kho sửa đồ',
  `address` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'địa chỉ',
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'điện thoại',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`store_id`),
  KEY `fk_kk_store_kk_branch1_idx` (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Kho';

/*Data for the table `mk_store` */

insert  into `mk_store`(`store_id`,`code`,`name`,`branch_id`,`type`,`address`,`phone`,`note`,`status`,`deleted`) values (1,'K1','Kho 1',1,1,'411/58/48 Lê Đức Thọ, Phường 17, Quận Gò Vấp, TP Hồ Chí Minh','0822191308','Kho hàng mới',1,0),(2,'K2','Kho 2',1,2,'Xô Viết Nghệ Tĩnh','12345678','Kho sửa đồ',1,0);

/*Table structure for table `mk_store_check` */

DROP TABLE IF EXISTS `mk_store_check`;

CREATE TABLE `mk_store_check` (
  `store_check_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_check_group_id` int(11) NOT NULL COMMENT 'phiếu kiểm kho',
  `product_id` int(11) NOT NULL COMMENT 'hàng hoá',
  `quantity` int(11) NOT NULL COMMENT 'số lượng thực tế',
  `quantity_record` int(11) NOT NULL COMMENT 'số lượng sổ sách',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`store_check_id`),
  KEY `fk_kk_store_check_kk_store_check_group1_idx` (`store_check_group_id`),
  KEY `fk_kk_store_check_kk_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Chi tiết kiểm kho';

/*Data for the table `mk_store_check` */

/*Table structure for table `mk_store_check_group` */

DROP TABLE IF EXISTS `mk_store_check_group`;

CREATE TABLE `mk_store_check_group` (
  `store_check_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'kỳ kiểm',
  `created_date` datetime DEFAULT NULL COMMENT 'ngày kiểm',
  `employee_id` int(11) NOT NULL COMMENT 'nhân viên',
  `store_id` int(11) NOT NULL COMMENT 'kho',
  `product_group_id` int(11) NOT NULL COMMENT 'nhóm hàng hoá',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `status` int(11) NOT NULL COMMENT 'trạng thái| -1/Không duyệt - 0/Chờ duyệt - 1/Đã duyệt',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`store_check_group_id`),
  KEY `fk_kk_store_check_group_kk_store1_idx` (`store_id`),
  KEY `fk_kk_store_check_group_kk_employee1_idx` (`employee_id`),
  KEY `fk_kk_store_check_group_kk_product_group1_idx` (`product_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Kiểm kho';

/*Data for the table `mk_store_check_group` */

/*Table structure for table `mk_store_export` */

DROP TABLE IF EXISTS `mk_store_export`;

CREATE TABLE `mk_store_export` (
  `store_export_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_export_group_id` int(11) NOT NULL COMMENT 'phiếu xuất kho',
  `order_detail_id` int(11) NOT NULL COMMENT 'chi tiết phiếu bán hàng',
  `return_detail_id` int(11) NOT NULL COMMENT 'chi tiết trả hàng',
  `store_id` int(11) NOT NULL COMMENT 'kho',
  `product_id` int(11) NOT NULL COMMENT 'hàng hoá',
  `quantity` int(11) NOT NULL COMMENT 'số lượng',
  `price_export` decimal(20,2) DEFAULT NULL,
  `commission_price` decimal(20,2) DEFAULT NULL,
  `commission_percent` float NOT NULL COMMENT 'chiết khấu phần trăm',
  `tax_percent` float NOT NULL COMMENT 'VAT',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`store_export_id`),
  KEY `fk_kk_store_export_kk_store_export_group1_idx` (`store_export_group_id`),
  KEY `fk_kk_store_export_kk_store1_idx` (`store_id`),
  KEY `fk_kk_store_export_kk_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Chi tiết xuất kho';

/*Data for the table `mk_store_export` */

/*Table structure for table `mk_store_export_group` */

DROP TABLE IF EXISTS `mk_store_export_group`;

CREATE TABLE `mk_store_export_group` (
  `store_export_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã phiếu',
  `created_date` datetime DEFAULT NULL COMMENT 'ngày xuất',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `employee_id` int(11) NOT NULL COMMENT 'nhân viên',
  `customer_id` int(11) NOT NULL COMMENT 'khách hàng',
  `order_id` int(11) NOT NULL COMMENT 'phiếu bán hàng',
  `return_id` int(11) NOT NULL COMMENT 'trả hàng',
  `type` int(11) NOT NULL COMMENT 'loại| 1/Xuất kho - 2/Xuất bán - 3/Xuất chuyển kho - 4/Xuất khác - 5/Xuất điều chỉnh kho',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`store_export_group_id`),
  KEY `fk_kk_store_export_group_kk_customer1_idx` (`customer_id`),
  KEY `fk_kk_store_export_group_kk_employee1_idx` (`employee_id`),
  KEY `fk_kk_store_export_group_kk_order1_idx` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Xuất kho';

/*Data for the table `mk_store_export_group` */

/*Table structure for table `mk_store_import` */

DROP TABLE IF EXISTS `mk_store_import`;

CREATE TABLE `mk_store_import` (
  `store_import_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_import_group_id` int(11) NOT NULL COMMENT 'phiếu nhập kho',
  `order_detail_id` int(11) NOT NULL COMMENT 'chi tiết phiếu bán hàng',
  `return_detail_id` int(11) NOT NULL COMMENT 'chi tiết trả hàng',
  `store_id` int(11) NOT NULL COMMENT 'kho',
  `product_id` int(11) NOT NULL COMMENT 'hàng hoá',
  `quantity` int(11) NOT NULL COMMENT 'số lượng',
  `price_import` decimal(20,2) DEFAULT NULL,
  `commission_price` decimal(20,2) DEFAULT NULL,
  `commission_percent` float NOT NULL COMMENT 'chiết khấu phần trăm',
  `tax_percent` float NOT NULL COMMENT 'VAT',
  `date_expired` datetime DEFAULT NULL COMMENT 'ngày hết hạn',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`store_import_id`),
  KEY `fk_kk_store_import_kk_store_import_group1_idx` (`store_import_group_id`),
  KEY `fk_kk_store_import_kk_store1_idx` (`store_id`),
  KEY `fk_kk_store_import_kk_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Chi tiết nhập kho';

/*Data for the table `mk_store_import` */

/*Table structure for table `mk_store_import_group` */

DROP TABLE IF EXISTS `mk_store_import_group`;

CREATE TABLE `mk_store_import_group` (
  `store_import_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã phiếu',
  `created_date` datetime DEFAULT NULL COMMENT 'ngày nhập',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `employee_id` int(11) NOT NULL COMMENT 'nhân viên',
  `supplier_id` int(11) NOT NULL COMMENT 'nhà cung cấp',
  `customer_id` int(11) NOT NULL COMMENT 'khách hàng',
  `order_id` int(11) NOT NULL COMMENT 'phiếu bán hàng',
  `return_id` int(11) NOT NULL COMMENT 'trả hàng',
  `type` int(11) NOT NULL COMMENT 'loại| 1/Nhập kho - 2/Nhập trả - 3/Nhập chuyển kho - 4/Nhập khác - 5/Nhập điều chỉnh kho',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`store_import_group_id`),
  KEY `fk_kk_store_import_group_kk_supplier1_idx` (`supplier_id`),
  KEY `fk_kk_store_import_group_kk_employee1_idx` (`employee_id`),
  KEY `fk_kk_store_import_group_kk_order1_idx` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nhập kho';

/*Data for the table `mk_store_import_group` */

/*Table structure for table `mk_store_product` */

DROP TABLE IF EXISTS `mk_store_product`;

CREATE TABLE `mk_store_product` (
  `store_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL COMMENT 'hàng hoá',
  `store_id` int(11) NOT NULL COMMENT 'kho',
  `price` decimal(20,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL COMMENT 'số lượng',
  `ratio` float NOT NULL DEFAULT '1' COMMENT 'quy đổi',
  `unit_id` int(11) NOT NULL COMMENT 'đơn vị tính',
  `store_check_id` int(11) NOT NULL COMMENT 'số lượng thay đổi do kiểm kho',
  `store_import_id` int(11) NOT NULL COMMENT 'số lượng thay đổi do nhập kho',
  `store_export_id` int(11) NOT NULL COMMENT 'số lượng thay đổi do xuất kho',
  `created_date` datetime DEFAULT NULL COMMENT 'ngày tạo',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`store_product_id`),
  KEY `fk_kk_product_store_kk_product1_idx` (`product_id`),
  KEY `fk_kk_product_store_kk_store1_idx` (`store_id`),
  KEY `fk_kk_store_product_kk_store_check1_idx` (`store_check_id`),
  KEY `fk_kk_store_product_kk_store_import1_idx` (`store_import_id`),
  KEY `fk_kk_store_product_kk_store_export1_idx` (`store_export_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tồn kho đầu kỳ';

/*Data for the table `mk_store_product` */

/*Table structure for table `mk_store_transfer` */

DROP TABLE IF EXISTS `mk_store_transfer`;

CREATE TABLE `mk_store_transfer` (
  `store_transfer_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_transfer_group_id` int(11) NOT NULL COMMENT 'phiếu chuyển kho',
  `product_id` int(11) NOT NULL COMMENT 'hàng hoá',
  `quantity` int(11) NOT NULL COMMENT 'số lượng',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`store_transfer_id`),
  KEY `fk_kk_store_transfer_kk_store_transfer_group1_idx` (`store_transfer_group_id`),
  KEY `fk_kk_store_transfer_kk_product1_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Chi tiết chuyển kho';

/*Data for the table `mk_store_transfer` */

/*Table structure for table `mk_store_transfer_group` */

DROP TABLE IF EXISTS `mk_store_transfer_group`;

CREATE TABLE `mk_store_transfer_group` (
  `store_transfer_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_import_group_id` int(11) NOT NULL COMMENT 'phiếu nhập kho',
  `store_export_group_id` int(11) NOT NULL COMMENT 'phiếu xuất kho',
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã phiếu',
  `created_date` datetime DEFAULT NULL COMMENT 'ngày chuyển',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `employee_id` int(11) NOT NULL COMMENT 'nhân viên',
  `store_id_import` int(11) NOT NULL COMMENT 'kho nhập',
  `store_id_export` int(11) NOT NULL COMMENT 'kho xuất',
  `order_id` int(11) NOT NULL COMMENT 'phiếu bán hàng',
  `status` int(11) NOT NULL COMMENT 'trạng thái| -1/Không duyệt - 0/Chờ duyệt - 1/Đã duyệt',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`store_transfer_group_id`),
  KEY `fk_kk_store_transfer_group_kk_employee1_idx` (`employee_id`),
  KEY `fk_kk_store_transfer_group_kk_store1_idx` (`store_id_import`),
  KEY `fk_kk_store_transfer_group_kk_store2_idx` (`store_id_export`),
  KEY `fk_kk_store_transfer_group_kk_order1_idx` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Chuyển kho';

/*Data for the table `mk_store_transfer_group` */

/*Table structure for table `mk_supplier` */

DROP TABLE IF EXISTS `mk_supplier`;

CREATE TABLE `mk_supplier` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên',
  `object_id` int(11) NOT NULL COMMENT 'nhóm',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `country_id` int(11) NOT NULL COMMENT 'quốc gia',
  `city_id` int(11) NOT NULL COMMENT 'thành phố',
  `district_id` int(11) NOT NULL COMMENT 'quận huyện',
  `tax_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã số thuế',
  `avatar` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'hình đại diện',
  `fax` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'fax',
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'email',
  `website` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'website',
  `address_1` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'địa chỉ 1',
  `address_2` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'địa chỉ 2',
  `phone_1` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'điện thoại 1',
  `phone_2` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'điện thoại 2',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`supplier_id`),
  KEY `fk_kk_customer_kk_object1_idx` (`object_id`),
  KEY `fk_kk_customer_kk_country1_idx` (`country_id`),
  KEY `fk_kk_customer_kk_city1_idx` (`city_id`),
  KEY `fk_kk_customer_kk_district1_idx` (`district_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nhà cung cấp';

/*Data for the table `mk_supplier` */

/*Table structure for table `mk_unit` */

DROP TABLE IF EXISTS `mk_unit`;

CREATE TABLE `mk_unit` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên đơn vị',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Đơn vị tính';

/*Data for the table `mk_unit` */

insert  into `mk_unit`(`unit_id`,`name`,`note`,`status`,`deleted`) values (1,'Cái','Số lượng là cái',1,0),(2,'Bộ','Số lượng là bộ',1,0);

/*Table structure for table `mk_user` */

DROP TABLE IF EXISTS `mk_user`;

CREATE TABLE `mk_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Người dùng';

/*Data for the table `mk_user` */

insert  into `mk_user`(`user_id`,`username`,`password`,`user_group_id`,`employee_id`,`branch_id`,`note`,`status`,`deleted`) values (1,'mk','$2a$12$kIkn1RFpl5uGajc9sWs67.fbJA79h6kuS.3EUKxP3mC1XHrs0ky1C',1,1,1,'Admin',1,0);

/*Table structure for table `mk_user_group` */

DROP TABLE IF EXISTS `mk_user_group`;

CREATE TABLE `mk_user_group` (
  `user_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã nhóm',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên nhóm',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`user_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nhóm người dùng';

/*Data for the table `mk_user_group` */

insert  into `mk_user_group`(`user_group_id`,`code`,`name`,`note`,`status`,`deleted`) values (1,'AD','Administrator','',1,0),(2,'NV','Nhân viên','',1,0);

/*Table structure for table `mk_work` */

DROP TABLE IF EXISTS `mk_work`;

CREATE TABLE `mk_work` (
  `work_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tên ca',
  `work_start` datetime DEFAULT NULL COMMENT 'bắt đầu',
  `work_end` datetime DEFAULT NULL COMMENT 'kết thúc',
  `note` text COLLATE utf8_unicode_ci COMMENT 'ghi chú',
  `status` int(11) NOT NULL COMMENT 'tình trạng| 1/Active - 2/Inactive',
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`work_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Ca';

/*Data for the table `mk_work` */

insert  into `mk_work`(`work_id`,`name`,`work_start`,`work_end`,`note`,`status`,`deleted`) values (1,'Sáng','2015-01-01 08:30:00','2015-01-01 12:00:00','',1,0),(2,'Chiều','2015-01-01 13:30:00','2015-01-01 17:30:00','',1,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
