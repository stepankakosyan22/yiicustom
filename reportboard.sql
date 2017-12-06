/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.50 : Database - yiicustom
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`yiicustom` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `yiicustom`;

/*Table structure for table `checkin` */

DROP TABLE IF EXISTS `checkin`;

CREATE TABLE `checkin` (
  `checkin_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `check_in` varchar(10) DEFAULT NULL,
  `lunch_check_out` varchar(10) DEFAULT NULL,
  `lunch_check_in` varchar(10) DEFAULT NULL,
  `check_out` varchar(10) DEFAULT NULL,
  `worked_hours` varchar(255) DEFAULT NULL,
  `work_hours_extra` varchar(255) DEFAULT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `week` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  PRIMARY KEY (`checkin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

/*Data for the table `checkin` */

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `migration` */

insert  into `migration`(`version`,`apply_time`) values ('',0),('m000000_000000_base',1508760420),('m130524_201442_init',1508760455);

/*Table structure for table `project_worker` */

DROP TABLE IF EXISTS `project_worker`;

CREATE TABLE `project_worker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_project` int(11) NOT NULL,
  `id_worker` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;

/*Data for the table `project_worker` */

/*Table structure for table `projects` */

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id_project` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) NOT NULL,
  `edf` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `customer` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_project`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `projects` */

/*Table structure for table `reports` */

DROP TABLE IF EXISTS `reports`;

CREATE TABLE `reports` (
  `id_report` int(11) NOT NULL AUTO_INCREMENT,
  `id_project` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `report_day` datetime NOT NULL,
  `description` text NOT NULL,
  `working_time` float NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_report`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `reports` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `prof_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `work_time` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `team` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_working_at` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`,`full_name`,`gender`,`dob`,`prof_image`,`work_time`,`team`,`start_working_at`,`position`) values (1,'admin','N-0fJsNT11mLDys31m383yVwQE46nYYB','$2y$13$dQGz8b6CX5q.mDx/K7kuaeGIB2Tr/Nfsfkatj98JvdMQ4NgdiFvRe','rQz4uHI8j3g3I_7Rw69eaHp0Co82rNVm_1510553255','stepankakosyan22@gmail.com',10,1508760482,1510553255,'Admin','','0000-00-00','','','','0000-00-00','Admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
