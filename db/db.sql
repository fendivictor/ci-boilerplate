/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.12-MariaDB : Database - manpro
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `tb_menu` */

DROP TABLE IF EXISTS `tb_menu`;

CREATE TABLE `tb_menu` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `label` varchar(120) DEFAULT '',
  `icon` varchar(60) DEFAULT '',
  `url` varchar(120) DEFAULT '',
  `fungsi` varchar(30) DEFAULT '',
  `method` varchar(30) DEFAULT '',
  `parent` int(20) DEFAULT 0,
  `urutan` double DEFAULT 0,
  `status` int(1) DEFAULT 1,
  `insert_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_insert` varchar(60) DEFAULT '',
  `update_at` datetime DEFAULT NULL,
  `user_update` varchar(60) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `tb_menu` */

insert  into `tb_menu`(`id`,`label`,`icon`,`url`,`fungsi`,`method`,`parent`,`urutan`,`status`,`insert_at`,`user_insert`,`update_at`,`user_update`) values 
(1,'menu_dashboard','nav-icon fas fa-tachometer-alt','Main/index','Main','index',0,1,1,'2020-07-09 09:01:15','',NULL,''),
(4,'menu_logout','nav-icon fas fa-lock','','','',0,9999,1,'2020-07-09 11:08:32','',NULL,''),
(5,'menu_manajemen_menu','nav-icon fas fa-user','Menu/user','Menu','user',0,9998,1,'2020-07-24 13:19:07','',NULL,''),
(6,'menu_change_password','nav-icon fas fa-exchange-alt','User/change_password','User','change_password',0,9997,1,'2020-07-24 13:29:43','',NULL,''),
(7,'menu_management_user','nav-icon fas fa-user','User/index','User','index',0,9996,1,'2020-07-24 14:00:41','',NULL,'');

/*Table structure for table `tb_menu_setting` */

DROP TABLE IF EXISTS `tb_menu_setting`;

CREATE TABLE `tb_menu_setting` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `id_menu` int(20) DEFAULT 0,
  `tools` varchar(60) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT '',
  `status` int(1) DEFAULT 1,
  `insert_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_insert` varchar(60) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `tb_menu_setting` */

insert  into `tb_menu_setting`(`id`,`id_menu`,`tools`,`status`,`insert_at`,`user_insert`) values 
(1,3,'tec-sheet-plan-kirim',1,'2020-07-24 10:33:52',''),
(2,3,'tec-sheet-actual-kirim',1,'2020-07-24 10:34:22',''),
(3,3,'pattern-plan-kirim',1,'2020-07-24 10:34:51',''),
(4,3,'pattern-actual-kirim',1,'2020-07-24 10:34:57',''),
(5,3,'fabric-kirim',1,'2020-07-24 10:35:10',''),
(6,3,'fabric-kedatangan',1,'2020-07-24 10:35:16',''),
(7,3,'aksesories-kirim',1,'2020-07-24 10:35:32',''),
(8,3,'aksesories-kedatangan',1,'2020-07-24 10:35:46',''),
(9,3,'master-code',1,'2020-07-24 10:36:02',''),
(10,3,'line',1,'2020-07-24 10:36:09',''),
(11,3,'persiapan-finish-plan',1,'2020-07-24 10:36:21',''),
(12,3,'persiapan-finish-actual',1,'2020-07-24 10:36:31',''),
(13,3,'cutting-finish-plan',1,'2020-07-24 10:37:04',''),
(14,3,'cutting-finish-actual',1,'2020-07-24 10:48:31',''),
(15,3,'cad-finish-plan',1,'2020-07-24 10:48:44',''),
(16,3,'cad-finish-actual',1,'2020-07-24 10:48:54',''),
(17,3,'sewing-finish-plan',1,'2020-07-24 10:49:04',''),
(18,3,'sewing-finish-actual',1,'2020-07-24 10:49:10',''),
(19,3,'finish-goods-plan',1,'2020-07-24 10:49:24',''),
(20,3,'finish-goods-actual',1,'2020-07-24 10:49:32',''),
(21,3,'kirim-plan',1,'2020-07-24 10:49:43',''),
(22,3,'kirim-actual',1,'2020-07-24 10:49:47',''),
(23,3,'keterangan',1,'2020-07-24 10:49:56',''),
(24,3,'finish-btn',1,'2020-08-18 08:53:24',''),
(25,3,'edit-btn',1,'2020-09-10 14:32:23',''),
(26,3,'duplicate-btn',1,'2020-09-10 14:32:29','');

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT '',
  `password` varchar(120) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT '',
  `profile_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT '',
  `image` varchar(250) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT '',
  `phone` varchar(60) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT '',
  `email` varchar(120) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT '',
  `session` varchar(120) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT '',
  `last_login` datetime DEFAULT NULL,
  `language` varchar(30) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT 'english',
  `insert_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_insert` varchar(60) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT '',
  `update_at` datetime DEFAULT NULL,
  `user_update` varchar(60) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT '',
  `status` int(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tb_user` */

insert  into `tb_user`(`id`,`username`,`password`,`profile_name`,`image`,`phone`,`email`,`session`,`last_login`,`language`,`insert_at`,`user_insert`,`update_at`,`user_update`,`status`) values 
(1,'admin','7cfa28cde915ea86f0906b343435ce28','Super Admin','','','admin@localhost','99409a7b0bdca4ab6a248349331d249b','2021-08-10 11:17:02','english','2020-07-09 08:59:23','-','2020-07-27 10:51:09','admin',1),
(2,'jpg','dface3503e6a0753c0584d2cab38baf6','Fukuryo Japan','','','','a098098e371f35932923da5073b9836e','2020-10-20 15:44:31','japan','2020-07-23 15:03:32','-','2020-07-27 13:14:51','jpg',1),
(3,'indo','dface3503e6a0753c0584d2cab38baf6','Fukuryo Indo','','','','db2a4306a28881837724a43ad67e15b6','2020-09-21 09:44:10','english','2020-07-23 15:04:06','-','2020-07-27 13:15:21','indo',1),
(4,'budi','410d12f121d35849f16ace2235decf77','budi','','','','06e7cf73dc5a18480c10a785d68be4f1','2020-08-04 11:27:48','japan','2020-08-04 11:25:54','admin','2020-08-04 11:27:08','budi',1);

/*Table structure for table `tb_user_menu` */

DROP TABLE IF EXISTS `tb_user_menu`;

CREATE TABLE `tb_user_menu` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `id_menu` int(20) DEFAULT 0,
  `username` varchar(60) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT '',
  `insert_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_insert` varchar(60) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=latin1;

/*Data for the table `tb_user_menu` */

insert  into `tb_user_menu`(`id`,`id_menu`,`username`,`insert_at`,`user_insert`) values 
(64,1,'admin','2020-08-18 09:39:20','admin'),
(65,2,'admin','2020-08-18 09:39:20','admin'),
(66,3,'admin','2020-08-18 09:39:20','admin'),
(67,4,'admin','2020-08-18 09:39:20','admin'),
(68,5,'admin','2020-08-18 09:39:20','admin'),
(69,6,'admin','2020-08-18 09:39:20','admin'),
(70,7,'admin','2020-08-18 09:39:20','admin'),
(71,8,'admin','2020-08-18 09:39:20','admin'),
(72,9,'admin','2020-08-18 09:39:20','admin'),
(73,1,'jpg','2020-08-18 15:01:35','admin'),
(74,2,'jpg','2020-08-18 15:01:35','admin'),
(75,3,'jpg','2020-08-18 15:01:35','admin'),
(76,4,'jpg','2020-08-18 15:01:35','admin'),
(77,6,'jpg','2020-08-18 15:01:35','admin'),
(78,9,'jpg','2020-08-18 15:01:35','admin'),
(79,1,'indo','2020-08-19 13:47:23','admin'),
(80,3,'indo','2020-08-19 13:47:23','admin'),
(81,4,'indo','2020-08-19 13:47:23','admin'),
(82,6,'indo','2020-08-19 13:47:23','admin'),
(83,9,'indo','2020-08-19 13:47:23','admin'),
(109,1,'budi','2020-08-19 15:29:09','admin'),
(110,2,'budi','2020-08-19 15:29:09','admin'),
(111,3,'budi','2020-08-19 15:29:09','admin'),
(112,4,'budi','2020-08-19 15:29:09','admin'),
(113,9,'budi','2020-08-19 15:29:09','admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
