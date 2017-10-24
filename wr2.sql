/*
SQLyog Ultimate v11.24 (32 bit)
MySQL - 5.6.29-log : Database - wr2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`wr2` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `wr2`;

/*Table structure for table `admins` */

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `admins` */

insert  into `admins`(`id`,`name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`) values (4,'微榕官方','1343948033@qq.com','$2y$10$qY9SL6dSNB6YPKKVE8O9Ge8Wh3aDdIBHyutF/9/XzSn2Y/m5PtI3K','bsQ0T05ZpIUMvlAGlkEtHOhK7bbXSuarj33zA261DBxdlrnQn8w8yEn7FqrE','2017-09-11 09:42:58','2017-09-25 10:11:14'),(5,'销售员专用','test@qq.com','$2y$10$uqKLw9TjDyvI2PgtHHRWW.ksfm.tMdn/wbnP.PhLlubzwLtIRckZe','BhG2mV5DHVOUYpcCJvbLvC8eDFhtebIPZTuzTV6945WHhisEMSq2lQ3yRUmA','2017-09-11 14:40:42','2017-09-19 09:27:18');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `connection` varchar(255) DEFAULT NULL,
  `queue` varchar(255) DEFAULT NULL,
  `payload` varchar(2000) DEFAULT NULL,
  `failed_at` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `failed_jobs` */

insert  into `failed_jobs`(`id`,`connection`,`queue`,`payload`,`failed_at`) values (2,'redis','default','{\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendCode\",\"command\":\"O:17:\\\"App\\\\Jobs\\\\SendCode\\\":8:{s:6:\\\"\\u0000*\\u0000sms\\\";O:38:\\\"App\\\\Api\\\\Controllers\\\\Tool\\\\SmsController\\\":6:{s:13:\\\"\\u0000*\\u0000middleware\\\";a:0:','2017-09-12 09:20:56'),(3,'redis','default','{\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendCode\",\"command\":\"O:17:\\\"App\\\\Jobs\\\\SendCode\\\":8:{s:6:\\\"\\u0000*\\u0000sms\\\";O:38:\\\"App\\\\Api\\\\Controllers\\\\Tool\\\\SmsController\\\":6:{s:13:\\\"\\u0000*\\u0000middleware\\\";a:0:','2017-09-12 09:21:08'),(4,'redis','default','{\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"commandName\":\"App\\\\Jobs\\\\AppointNotice\",\"command\":\"O:22:\\\"App\\\\Jobs\\\\AppointNotice\\\":9:{s:7:\\\"\\u0000*\\u0000send\\\";O:44:\\\"App\\\\Api\\\\Controllers\\\\Tool\\\\TemplatesController\\\":6:{s:13:\\\"\\u0000*\\u0000','2017-09-12 10:11:54'),(5,'redis','default','{\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"commandName\":\"App\\\\Jobs\\\\AppointNotice\",\"command\":\"O:22:\\\"App\\\\Jobs\\\\AppointNotice\\\":9:{s:7:\\\"\\u0000*\\u0000send\\\";O:44:\\\"App\\\\Api\\\\Controllers\\\\Tool\\\\TemplatesController\\\":6:{s:13:\\\"\\u0000*\\u0000','2017-09-12 10:17:49'),(6,'redis','default','{\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"commandName\":\"App\\\\Jobs\\\\AppointNotice\",\"command\":\"O:22:\\\"App\\\\Jobs\\\\AppointNotice\\\":10:{s:7:\\\"\\u0000*\\u0000send\\\";O:44:\\\"App\\\\Api\\\\Controllers\\\\Tool\\\\TemplatesController\\\":6:{s:13:\\\"\\u0000*\\u0000middleware\\\";a:0:{}s:27:\\\"\\u0000*\\u0000validatesRequestErrorBag\\\";N;s:9:\\\"\\u0000*\\u0000scopes\\\";a:0:{}s:26:\\\"\\u0000*\\u0000authenticationProviders\\\";a:0:{}s:12:\\\"\\u0000*\\u0000rateLimit\\\";a:0:{}s:12:\\\"\\u0000*\\u0000throttles\\\";a:0:{}}s:14:\\\"\\u0000*\\u0000merchant_id\\\";i:71;s:13:\\\"\\u0000*\\u0000wx_open_id\\\";s:28:\\\"oDrxZ0jO4nlfyNzbX7DTVAygl6wg\\\";s:16:\\\"\\u0000*\\u0000template_type\\\";s:14:\\\"NOTICE_HAIR_OK\\\";s:7:\\\"\\u0000*\\u0000data\\\";a:7:{s:5:\\\"first\\\";a:1:{s:5:\\\"value\\\";s:30:\\\"\\u60a8\\u6709\\u4e00\\u6761\\u65b0\\u7684\\u9884\\u7ea6\\u8ba2\\u5355\\\";}s:8:\\\"keyword1\\\";a:2:{s:5:\\\"value\\\";s:16:\\\"2017-09-19 23:30\\\";s:5:\\\"color\\\";s:7:\\\"#173177\\\";}s:8:\\\"keyword2\\\";a:1:{s:5:\\\"value\\\";s:12:\\\"\\u6df1\\u5c42\\u8865\\u6c34\\\";}s:8:\\\"keyword3\\\";a:1:{s:5:\\\"value\\\";s:8:\\\"88.00\\u5143\\\";}s:8:\\\"keyword4\\\";a:1:{s:5:\\\"value\\\";s:4:\\\"avel\\\";}s:8:\\\"keyword5\\\";a:1:{s:5:\\\"value\\\";s:11:\\\"18621730000\\\";}s:6:\\\"remark\\\";a:2:{s:5:\\\"value\\\";s:15:\\\"\\u5907\\u6ce8\\u4fe1\\u606f:  \\\";s:5:\\\"color\\\";s:7:\\\"#173177\\\";}}s:6:\\\"\\u0000*\\u0000url\\\";s:38:\\\"http:\\/\\/waiter.weerun.com\\/#\\/Appointment\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:6:\\\"\\u0000*\\u0000job\\\";N;}\"},\"id\":\"iGfCOmkwPuiRzLSCmaBTE3uYUEEZpCfK\",\"attempts\":4}','2017-09-19 20:17:16'),(7,'redis','default','{\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendNoticeCode\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\SendNoticeCode\\\":7:{s:6:\\\"\\u0000*\\u0000sms\\\";O:38:\\\"App\\\\Api\\\\Controllers\\\\Tool\\\\SmsController\\\":6:{s:13:\\\"\\u0000*\\u0000middleware\\\";a:0:{}s:27:\\\"\\u0000*\\u0000validatesRequestErrorBag\\\";N;s:9:\\\"\\u0000*\\u0000scopes\\\";a:0:{}s:26:\\\"\\u0000*\\u0000authenticationProviders\\\";a:0:{}s:12:\\\"\\u0000*\\u0000rateLimit\\\";a:0:{}s:12:\\\"\\u0000*\\u0000throttles\\\";a:0:{}}s:6:\\\"\\u0000*\\u0000tel\\\";s:11:\\\"18817320310\\\";s:6:\\\"\\u0000*\\u0000tem\\\";s:12:\\\"SMS_59995659\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:6:\\\"\\u0000*\\u0000job\\\";N;}\"},\"id\":\"q8jFVfkmav54ByFrdDxJyrsJoAAt2gxc\",\"attempts\":4}','2017-09-28 09:41:42');

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单链接',
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '权限名称',
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单图标',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级菜单id',
  `heightlight_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单高亮',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `menus` */

insert  into `menus`(`id`,`name`,`url`,`slug`,`icon`,`parent_id`,`heightlight_url`,`sort`,`created_at`,`updated_at`) values (1,'系统','admin/menus','system.manage','fa fa-cogs',0,'',0,'2017-07-24 19:38:08','2017-07-24 19:38:08'),(2,'后台目录管理','admin/menus','menus.list','',1,'',0,'2017-07-24 19:38:08','2017-07-24 19:38:08'),(3,'后台用户管理','admin/adminuser','adminuser.list','',1,'',0,'2017-07-24 19:38:08','2017-07-24 19:38:08'),(4,'权限管理','admin/permission','permission.list','',1,'',0,'2017-07-24 19:38:08','2017-07-24 19:38:08'),(5,'角色管理','admin/role','role.list','',1,'',0,'2017-07-24 19:38:08','2017-07-24 19:38:08'),(8,'公众号管理','admin/public','public.manage','fa  fa-hospital-o',0,'',0,'2017-07-25 15:51:51','2017-08-15 09:55:10'),(9,'公众号接入','admin/public','public.list','',8,'',0,'2017-07-25 15:52:24','2017-08-15 09:55:22'),(10,'商户管理','admin/merchant','merchant.manage','fa fa-cube',0,'',0,'2017-08-01 09:32:39','2017-08-01 09:33:05'),(11,'商户列表','admin/merchant','merchant.list','',10,'',0,'2017-08-01 09:33:47','2017-08-01 09:33:55'),(12,'商户管理员列表','admin/merchantAdmin','merchantAdmin.list','',10,'',0,'2017-08-01 10:17:58','2017-08-07 18:17:09'),(13,'商户权限管理','admin/merchantPermission','merchantPermission.list','',10,'',0,'2017-08-01 10:27:13','2017-08-07 18:18:13'),(14,'商户角色管理','admin/merchantRole','merchantRole.list','',10,'',0,'2017-08-01 10:28:06','2017-08-07 18:06:02'),(16,'商户贴纸寄送管理','admin/merchantCode','merchantCode.list','',10,'',0,'2017-09-26 17:44:39','2017-09-28 09:33:39');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`migration`,`batch`) values ('2014_10_12_000000_create_users_tables',1),('2014_10_12_100000_create_password_resets_table',1),('2017_06_02_131817_create_menus_table',1),('2017_06_29_024954_entrust_setup_tables',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `permission_role` */

DROP TABLE IF EXISTS `permission_role`;

CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `permission_role` */

insert  into `permission_role`(`permission_id`,`role_id`) values (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(43,1),(44,1),(45,1),(48,1),(49,1),(20,2),(21,2),(22,2),(23,2),(25,2),(28,2),(29,2),(30,2);

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`display_name`,`description`,`created_at`,`updated_at`) values (1,'system.manage','系统管理','系统管理','2017-07-24 19:38:08','2017-07-24 19:38:08'),(2,'menus.list','目录列表','目录列表','2017-07-24 19:38:08','2017-07-24 19:38:08'),(3,'menus.add','添加目录','添加目录','2017-07-24 19:38:08','2017-07-24 19:38:08'),(4,'menus.edit','修改目录','修改目录','2017-07-24 19:38:08','2017-07-24 19:38:08'),(5,'menus.delete','删除目录','删除目录','2017-07-24 19:38:08','2017-07-24 19:38:08'),(6,'adminuser.list','后台用户列表','后台用户列表','2017-07-24 19:38:08','2017-07-24 19:38:08'),(7,'adminuser.add','添加后台用户','添加后台用户','2017-07-24 19:38:08','2017-07-24 19:38:08'),(8,'adminuser.edit','修改后台用户','修改后台用户','2017-07-24 19:38:08','2017-07-24 19:38:08'),(9,'adminuser.delete','删除后台用户','删除后台用户','2017-07-24 19:38:08','2017-07-24 19:38:08'),(10,'permission.list','权限列表','权限列表','2017-07-24 19:38:08','2017-07-24 19:38:08'),(11,'permission.add','添加权限','添加权限','2017-07-24 19:38:08','2017-07-24 19:38:08'),(12,'permission.edit','修改权限','修改权限','2017-07-24 19:38:08','2017-07-24 19:38:08'),(13,'permission.delete','删除权限','删除权限','2017-07-24 19:38:08','2017-07-24 19:38:08'),(14,'role.list','角色列表','角色列表','2017-07-24 19:38:08','2017-07-24 19:38:08'),(15,'role.add','添加角色','添加角色','2017-07-24 19:38:08','2017-07-24 19:38:08'),(16,'role.edit','修改角色','修改角色','2017-07-24 19:38:08','2017-07-24 19:38:08'),(17,'role.delete','删除角色','删除角色','2017-07-24 19:38:08','2017-07-24 19:38:08'),(18,'public.manage','公众号管理','公众号接入、配置','2017-07-24 19:45:14','2017-08-15 09:57:17'),(19,'public.list','公众号接入','授权微信开放平台接入微信公众号','2017-07-25 15:50:14','2017-08-15 09:57:28'),(20,'merchant.manage','商户管理','对商户进行管理','2017-08-01 09:34:40','2017-08-01 09:34:40'),(21,'merchant.list','商户列表','商户列表','2017-08-01 09:35:16','2017-08-01 10:06:35'),(22,'merchant.add','商户添加','商户添加','2017-08-01 10:07:30','2017-08-01 10:07:30'),(23,'merchant.edit','商户修改','商户修改','2017-08-01 10:08:16','2017-08-01 10:08:16'),(24,'merchant.delete','商户删除','删除商户','2017-08-01 10:09:03','2017-08-01 10:09:03'),(25,'merchant.status','更改商户状态','更改商户状态','2017-08-01 10:09:44','2017-08-01 10:09:44'),(28,'merchantAdmin.list','商户管理里员列表','商户管理里员列表','2017-08-01 10:15:57','2017-08-01 17:39:04'),(29,'merchantAdmin.add','商户管理员添加','商户管理员添加','2017-08-01 10:16:25','2017-08-01 17:39:39'),(30,'merchantAdmin.edit','商户管理员编辑','商户管理员编辑','2017-08-01 10:16:45','2017-08-01 17:39:50'),(31,'merchantAdmin.delete','商户管理员删除','商户管理员删除','2017-08-01 10:17:14','2017-08-01 17:40:01'),(32,'merchantPermission.list','商户权限列表','商户权限列表','2017-08-01 10:21:24','2017-08-07 17:44:18'),(33,'merchantPermission.add','商户权限添加','商户权限添加','2017-08-01 10:21:54','2017-08-07 17:44:31'),(34,'merchantPermission.edit','商户权限编辑','商户权限编辑','2017-08-01 10:22:26','2017-08-01 10:22:26'),(35,'merchantPermission.delete','商户权限删除','商户权限删除','2017-08-01 10:22:46','2017-08-01 10:22:46'),(36,'merchantRole.list','商户角色管理','商户角色管理','2017-08-01 10:23:53','2017-08-01 10:23:53'),(37,'merchantRole.add','商户角色添加','商户角色添加','2017-08-01 10:24:27','2017-08-01 10:24:27'),(38,'merchantRole.edit','商户角色编辑','商户角色编辑','2017-08-01 10:24:49','2017-08-01 10:24:49'),(39,'merchantRole.delete','商户角色删除','商户角色删除','2017-08-01 10:25:09','2017-08-01 10:25:09'),(43,'public.add','公众号添加','添加公众号','2017-08-15 09:15:35','2017-08-15 09:57:39'),(44,'public.edit','公众号编辑','编辑公众号','2017-08-15 09:16:12','2017-08-15 09:57:49'),(45,'public.delete','公众号删除','公众号删除','2017-08-15 09:17:07','2017-08-15 09:57:58'),(48,'merchantCode.list','商户条码管理','商户二维码列表','2017-09-26 17:46:04','2017-09-26 17:46:04'),(49,'merchantCode.edit','商户二维码编辑','商户二维码编辑','2017-09-26 17:46:33','2017-09-26 17:46:33');

/*Table structure for table `role_admin` */

DROP TABLE IF EXISTS `role_admin`;

CREATE TABLE `role_admin` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_admin_role_id_foreign` (`role_id`),
  CONSTRAINT `role_admin_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_admin_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `role_admin` */

insert  into `role_admin`(`user_id`,`role_id`) values (4,1),(5,2);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`display_name`,`description`,`created_at`,`updated_at`) values (1,'SuperAdmin','超级管理员','管理后台的角色','2017-07-24 19:38:08','2017-07-24 19:38:08'),(2,' sales','销售','销售','2017-07-24 19:38:08','2017-09-11 14:38:49');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`) values (2,'贺兰丛丛','1343948033@qq.com','$2y$10$jLghOuP6QgYX7BYG9ewWyutAfmTC0xaJqOUUyifwAOYhTAHiFivTS',NULL,'2017-07-24 19:38:08','2017-07-24 19:38:08');

/*Table structure for table `wp_sucai` */

DROP TABLE IF EXISTS `wp_sucai`;

CREATE TABLE `wp_sucai` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(100) DEFAULT NULL COMMENT '素材名称',
  `status` char(10) DEFAULT 'UnSubmit' COMMENT '状态',
  `cTime` int(10) DEFAULT NULL COMMENT '提交时间',
  `url` varchar(255) DEFAULT NULL COMMENT '实际摇一摇所使用的页面URL',
  `type` varchar(255) DEFAULT NULL COMMENT '素材类型',
  `detail` text COMMENT '素材内容',
  `reason` text COMMENT '入库失败的原因',
  `create_time` int(10) DEFAULT NULL COMMENT '申请时间',
  `checked_time` int(10) DEFAULT NULL COMMENT '入库时间',
  `source` varchar(50) DEFAULT NULL COMMENT '来源',
  `source_id` int(10) DEFAULT NULL COMMENT '来源ID',
  `wechat_id` int(10) DEFAULT NULL COMMENT '微信端的素材ID',
  `uid` int(10) DEFAULT NULL COMMENT 'uid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `wp_sucai` */

/*Table structure for table `wp_sucai_template` */

DROP TABLE IF EXISTS `wp_sucai_template`;

CREATE TABLE `wp_sucai_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) DEFAULT NULL COMMENT '管理员id',
  `token` varchar(255) DEFAULT NULL COMMENT '用户token',
  `addons` varchar(255) DEFAULT NULL COMMENT '插件名称',
  `template` varchar(255) DEFAULT NULL COMMENT '模版名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `wp_sucai_template` */

/*Table structure for table `wr_admin` */

DROP TABLE IF EXISTS `wr_admin`;

CREATE TABLE `wr_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `admin_name` varchar(100) NOT NULL COMMENT '管理员账号',
  `admin_pwd` char(32) NOT NULL COMMENT '管理员密码',
  `tel` varchar(100) DEFAULT NULL COMMENT '联系方式',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态 0=>禁用 1=>正常',
  `level` tinyint(4) DEFAULT NULL COMMENT '级别 1=>超级管理员 2=>公众号管理员  3=>商户管理员  4=>门店管理员',
  `merchant_id` int(11) DEFAULT NULL COMMENT '对应的商户id',
  `shop_id` int(11) DEFAULT NULL COMMENT '对应的门店id',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '修改时间',
  `token` varchar(255) DEFAULT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='管理员表';

/*Data for the table `wr_admin` */

/*Table structure for table `wr_appoint` */

DROP TABLE IF EXISTS `wr_appoint`;

CREATE TABLE `wr_appoint` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `merchant_id` varchar(255) DEFAULT NULL COMMENT '商户id',
  `shop_id` int(10) DEFAULT NULL COMMENT '门店id',
  `waiter_id` int(11) DEFAULT NULL COMMENT '发型师id',
  `member_id` int(11) DEFAULT NULL COMMENT '客户id',
  `goods_id` int(11) DEFAULT NULL COMMENT '产品id',
  `time_date` varchar(255) DEFAULT NULL COMMENT '预约时间(天)',
  `tel` varchar(255) DEFAULT NULL COMMENT '客户手机号',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `status` int(11) DEFAULT '1' COMMENT '预约状态\n1：预约中\n2：预约完成（到店）',
  `reason` tinyint(4) DEFAULT '0' COMMENT '0：未取消 1：客户取消\n2：门店取消',
  `appoint_id` varchar(255) DEFAULT NULL COMMENT '预约单号',
  `time_hour` varchar(255) DEFAULT NULL COMMENT '预约时间（小时）',
  `time_str` varchar(255) DEFAULT NULL COMMENT '预约的时间戳',
  `is_notice_member` tinyint(4) DEFAULT '0' COMMENT '服务到期是否通知客户 \n0：未通知\n1：已通知',
  `is_notice_waiter` tinyint(4) DEFAULT '0' COMMENT '服务到期是否通知服务师 \n0：未通知\n1：已通知',
  `is_comment` tinyint(5) DEFAULT '0' COMMENT '是否评价 0：未评价，1：已评价',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `is_notice_member` (`is_notice_member`),
  KEY `is_notice_hair` (`is_notice_waiter`)
) ENGINE=InnoDB AUTO_INCREMENT=1219 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='预约表';

/*Data for the table `wr_appoint` */

insert  into `wr_appoint`(`id`,`merchant_id`,`shop_id`,`waiter_id`,`member_id`,`goods_id`,`time_date`,`tel`,`remark`,`status`,`reason`,`appoint_id`,`time_hour`,`time_str`,`is_notice_member`,`is_notice_waiter`,`is_comment`,`created_at`,`updated_at`,`deleted_at`) values (1086,'51',132,171,223,303,'2017-09-12','18817555623','摸摸摸',1,2,'y201709121629049ad0c1bbb','36','1505208600',1,1,NULL,1505204944,1505287513,NULL),(1087,'51',132,175,223,303,'2017-09-13','18817555623','o陌陌陌陌哦',1,1,'y201709130921118807c94b7','23','1505271600',1,1,NULL,1505265671,1505439445,NULL),(1088,'51',132,171,222,303,'2017-09-13','18817320310','哈哈',2,0,'y20170913112832a5e05e279','25','1505275200',1,1,NULL,1505273312,1505290201,1505290201),(1089,'51',132,171,222,303,'2017-09-13','18817320310','哈哈',2,0,'y20170913113440a7504c7c3','26','1505277000',1,1,NULL,1505273680,1505290199,1505290199),(1090,'51',132,181,222,303,'2017-09-13','18817320310','haha',1,2,'y20170913160754e75a17164','35','1505293200',1,1,NULL,1505290074,1505290401,NULL),(1091,'51',132,181,221,303,'2017-09-14','15921021906','',1,1,'y20170913161035e7fb4ea22','19','1505350800',1,1,NULL,1505290235,1505290241,NULL),(1092,'51',132,171,222,303,'2017-09-13','18817320310','xixi',2,0,'y20170913161126e82e4567e','35','1505293200',0,0,NULL,1505290286,1505290901,1505290901),(1093,'51',132,171,222,303,'2017-09-13','18817320310','哈哈',1,2,'y20170913161306e892b5670','36','1505295000',1,1,NULL,1505290386,1505290411,NULL),(1094,'51',132,181,221,303,'2017-09-13','15921021906','',2,0,'y20170913161343e8b7e82b0','39','1505300400',0,0,NULL,1505290423,1505380504,1505380504),(1095,'51',132,171,225,303,'2017-09-15','13162733315','摸摸',1,1,'y20170913161802e9ba1ebbe','38','1505471400',1,1,NULL,1505290682,1505290883,NULL),(1096,'51',132,179,225,302,'2017-09-13','13162733315','',2,0,'y20170913162415eb2fe057d','37','1505296800',0,0,NULL,1505291055,1505291237,NULL),(1097,'51',132,171,222,303,'2017-09-14','18817320310','咳咳',2,0,'y20170914145334276e2e99f','32','1505374200',0,0,NULL,1505372014,1505372042,NULL),(1098,'51',132,181,221,308,'2017-09-15','15921021906','',1,1,'y201709141524022e92212c5','28','1505453400',1,1,NULL,1505373842,1505382071,NULL),(1099,'51',132,171,222,305,'2017-09-15','18817320310','你好啊',2,0,'y201709150913422946185ad','21','1505440800',0,0,NULL,1505438022,1505438043,NULL),(1100,'51',132,175,223,302,'2017-09-15','18817555623','请准时为我服务！！',2,0,'y2017091509534732abef115','37','1505469600',0,0,1,1505440427,1505440511,NULL),(1101,'51',132,175,223,305,'2017-09-15','18817555623','啊啊啊啊啊啊啊啊',1,1,'y20170915095730338af3410','38','1505471400',1,1,NULL,1505440651,1505440666,NULL),(1102,'51',132,181,221,307,'2017-09-15','15921021906','',1,1,'y201709151141124bd8b571e','40','1505475000',1,1,NULL,1505446872,1505446877,NULL),(1103,'58',142,182,235,320,'2017-09-16','13816636800','',1,1,'y201709151141234be36fe40','27','1505538000',1,1,NULL,1505446883,1505447388,NULL),(1104,'51',132,181,221,307,'2017-09-15','15921021906','完完全全无无群前往恶趣味诶我去委屈',1,2,'y201709151143494c7523f77','40','1505475000',1,1,NULL,1505447029,1505463583,NULL),(1105,'51',132,175,223,303,'2017-09-15','18817555623','少时诵诗书所所所',1,2,'y201709151355496b653e997','38','1505471400',1,1,NULL,1505454949,1505463659,NULL),(1106,'51',132,175,223,303,'2017-09-15','18817555623','的方法三分',1,1,'y201709151356316b8f89d52','39','1505473200',1,1,NULL,1505454991,1505455903,NULL),(1107,'51',132,175,223,302,'2017-09-15','18817555623','的点点滴滴多多多多多多',1,1,'y201709151358536c1d27cdf','40','1505475000',1,1,NULL,1505455133,1505455759,NULL),(1108,'51',132,175,223,302,'2017-09-15','18817555623','反反复复付付付付付付付多',1,1,'y201709151404196d63347b1','41','1505476800',1,1,NULL,1505455459,1505455757,NULL),(1109,'51',132,175,223,304,'2017-09-15','18817555623','啊啊啊啊啊啊啊啊',1,2,'y20170915143509749dcdcf8','39','1505473200',1,1,NULL,1505457309,1505463751,NULL),(1110,'51',132,175,223,302,'2017-09-15','18817555623','少时诵诗书所所所',1,2,'y20170915144126761660f50','40','1505475000',1,1,NULL,1505457686,1505463945,NULL),(1111,'51',132,175,223,302,'2017-09-15','18817555623','啦啦啦啦绿绿绿绿绿',1,2,'y201709151458147a068cd75','41','1505476800',1,1,NULL,1505458694,1505463760,NULL),(1112,'51',132,175,223,302,'2017-09-15','18817555623','坎坎坷坷扩扩扩扩扩扩扩扩',1,2,'y201709151626588ed27bfa0','45','1505484000',1,1,NULL,1505464018,1505464380,NULL),(1113,'51',132,175,223,303,'2017-09-15','18817555623','啦啦啦啦',1,2,'y201709151631498ff53733a','38','1505471400',1,1,NULL,1505464309,1505464473,NULL),(1114,'51',132,175,223,304,'2017-09-15','18817555623','发地方斯蒂芬',1,2,'y201709151632079007cf96b','42','1505478600',1,1,NULL,1505464327,1505464540,NULL),(1115,'51',132,181,221,303,'2017-09-15','15921021906','',1,2,'y2017091516350990bd23f6e','40','1505475000',1,1,NULL,1505464509,1505464525,NULL),(1116,'51',132,181,221,307,'2017-09-15','15921021906','',1,2,'y201709151636549126278c1','40','1505475000',1,1,NULL,1505464614,1505464630,NULL),(1117,'51',132,181,221,307,'2017-09-15','15921021906','',1,2,'y201709151637439157af66e','40','1505475000',1,1,NULL,1505464663,1505464670,NULL),(1118,'51',132,181,221,307,'2017-09-15','15921021906','',2,0,'y20170915163810917282f1e','41','1505476800',0,0,NULL,1505464690,1505464731,1505464731),(1119,'51',132,175,223,303,'2017-09-15','18817555623','是否到水电费水电费是的',1,2,'y2017091516400791e760ef7','38','1505471400',1,1,NULL,1505464807,1505467330,NULL),(1120,'51',132,175,223,302,'2017-09-15','18817555623','哦哦哦哦哦哦哦哦哦哦哦',1,2,'y2017091516402291f60e701','39','1505473200',1,1,NULL,1505464822,1505467336,NULL),(1121,'51',132,175,223,302,'2017-09-15','18817555623','啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊',1,2,'y20170915164100921c2ef48','40','1505475000',1,1,NULL,1505464860,1505469378,NULL),(1122,'51',132,181,221,307,'2017-09-16','15921021906','',2,0,'y20170915164709938d2a06e','19','1505523600',0,0,NULL,1505465229,1505532029,1505532029),(1123,'51',132,181,221,307,'2017-09-16','15921021906','',1,1,'y2017091516471893966c201','24','1505532600',1,1,NULL,1505465238,1505532023,NULL),(1124,'51',132,175,223,303,'2017-09-15','18817555623','莫文蔚现在',1,2,'y20170915164935941f32be9','41','1505476800',1,1,NULL,1505465375,1505700215,NULL),(1125,'51',132,181,221,307,'2017-09-15','15921021906','qqqqqqqqqqqqqqqq',1,1,'y2017091516512094885c6ec','45','1505484000',1,1,NULL,1505465480,1505532021,NULL),(1126,'51',132,175,223,303,'2017-09-15','18817555623','V啦啦啦啦啦啦普通',1,2,'y2017091517134599c93c77c','42','1505478600',1,1,NULL,1505466825,1505700217,NULL),(1127,'51',132,175,223,303,'2017-09-15','18817555623','啦啦啦啦啦',1,2,'y201709151718269ae21629d','43','1505480400',1,1,NULL,1505467106,1505700219,NULL),(1128,'51',132,175,223,303,'2017-09-15','18817555623','',1,2,'y201709151719489b34d7384','44','1505482200',1,1,NULL,1505467188,1505467340,NULL),(1129,'51',132,175,223,307,'2017-09-15','18817555623','摸摸哦',1,2,'y20170915175542a39ecf755','45','1505484000',1,1,NULL,1505469342,1505700222,NULL),(1130,'51',132,175,223,303,'2017-09-18','18817555623','陌陌陌陌',2,0,'y20170918094933262d5390b','22','1505701800',1,0,1,1505699373,1505700228,NULL),(1131,'51',132,171,222,303,'2017-09-18','18817320310','哈哈',1,0,'y20170918095529279129588','22','1505700900',1,1,NULL,1505699729,1505699729,NULL),(1132,'51',132,171,223,303,'2017-09-18','18817555623','',1,1,'y2017091810044329bb9c609','23','1505703600',1,1,NULL,1505700283,1505712355,NULL),(1133,'51',132,175,223,303,'2017-09-18','18817555623','摸摸哦',1,2,'y2017091810054829fc23887','23','1505703600',0,0,NULL,1505700348,1505700376,NULL),(1134,'51',132,175,223,302,'2017-09-18','18817555623','vvvvvvvvvvv',2,0,'y201709181058593673188d7','24','1505705400',1,1,1,1505703539,1505712329,NULL),(1135,'60',145,185,238,327,'2017-09-18','18817320310','哈哈，支持一下',1,0,'y201709181346185daa9c69e','30','1505716200',1,1,NULL,1505713578,1505713578,NULL),(1136,'60',145,185,239,328,'2017-09-18','18817555623','支持一下',2,0,'y201709181350275ea30828f','31','1505718000',0,0,NULL,1505713827,1506080824,1506080824),(1145,'60',145,188,239,329,'2017-09-18','18817555623','看经济',1,1,'y201709181447476c132a1de','32','1505719800',1,1,NULL,1505717267,1505800229,NULL),(1146,'51',132,171,237,303,'2017-09-20','15921021906','XXXX',1,1,'y201709181502436f9383c9c','29','1505887200',0,0,NULL,1505718163,1505718681,NULL),(1147,'51',132,171,237,303,'2017-09-20','15921021906','CCCCC',1,1,'y201709181504347002b7ec2','37','1505901600',0,0,NULL,1505718274,1505720998,NULL),(1148,'51',132,175,237,306,'2017-09-21','15921021906','CCCCC',1,1,'y20170918150635707bd5e7a','41','1505995200',0,0,NULL,1505718395,1505729077,NULL),(1149,'60',145,185,238,327,'2017-09-18','18817320310','',1,0,'y2017091815375677d4d77a5','34','1505723400',1,1,NULL,1505720276,1505720276,NULL),(1150,'60',145,185,238,327,'2017-09-18','18817320310','哈哈',1,0,'y20170918162547830ba4bd4','35','1505725200',1,1,NULL,1505723147,1505723147,NULL),(1151,'51',132,175,223,307,'2017-09-18','18817555623','萨达是奥术大师多',1,1,'y20170918164322872a667a1','37','1505728800',1,1,NULL,1505724202,1505801109,NULL),(1152,'60',145,189,239,328,'2017-09-19','18817555623','看看',1,1,'y20170919134858afca83218','33','1505808000',0,0,NULL,1505800138,1505800240,NULL),(1153,'60',145,189,239,327,'2017-09-19','18817555623','',1,1,'y20170919134917afdd7f8da','30','1505802600',0,0,NULL,1505800157,1505800231,NULL),(1154,'60',145,189,239,327,'2017-09-19','18817555623','kkkmmmm',1,1,'y20170919134933afed6e8a5','32','1505806200',0,0,NULL,1505800173,1505800238,NULL),(1155,'60',145,189,239,327,'2017-09-19','18817555623','',1,1,'y20170919134942aff6a70fc','31','1505804400',0,0,NULL,1505800182,1505800236,NULL),(1156,'60',145,185,239,327,'2017-09-19','18817555623','',1,1,'y20170919135014b016888ba','30','1505802600',0,0,NULL,1505800214,1505800234,NULL),(1157,'51',132,175,223,303,'2017-09-19','18817555623','咕咕咕咕',1,1,'y20170919140501b38de8c0e','30','1505802600',1,0,NULL,1505801101,1505801110,NULL),(1158,'51',132,175,223,303,'2017-09-19','18817555623','柔柔弱弱若若若',1,1,'y20170919140524b3a45c1ca','31','1505804400',1,1,NULL,1505801124,1505807970,NULL),(1159,'51',132,175,223,304,'2017-09-19','18817555623','反反复复',1,1,'y20170919140537b3b1e668a','32','1505806200',1,1,NULL,1505801137,1505807972,NULL),(1160,'51',132,171,223,302,'2017-09-19','18817555623','',1,1,'y20170919141506b5eae0b98','33','1505808000',1,1,NULL,1505801706,1505807974,NULL),(1161,'51',132,175,223,302,'2017-09-19','18817555623','是是是',1,1,'y20170919141518b5f664d73','33','1505808000',1,1,NULL,1505801718,1505807976,NULL),(1162,'60',145,189,239,328,'2017-09-19','18817555623','',1,1,'y20170919142722b8ca256a2','31','1505804400',1,1,NULL,1505802442,1506324174,NULL),(1163,'51',132,175,223,302,'2017-09-19','18817555623','fffffffff',1,1,'y20170919155656cdc897e95','34','1505809800',0,0,NULL,1505807816,1505807978,NULL),(1164,'51',132,175,223,302,'2017-09-19','18817555623','aaaaaaaaaaa',1,1,'y20170919155709cdd5347fe','35','1505811600',0,0,NULL,1505807829,1505807980,NULL),(1165,'51',132,175,223,302,'2017-09-19','18817555623','',1,1,'y20170919155718cdde916ed','36','1505813400',0,0,NULL,1505807838,1505807982,NULL),(1166,'51',132,175,223,302,'2017-09-19','18817555623','addddddddddd',1,1,'y20170919155731cdeb58882','37','1505815200',0,0,NULL,1505807851,1505807983,NULL),(1167,'51',132,175,223,302,'2017-09-19','18817555623','dddddddeeeeeeeeeee',1,1,'y20170919155742cdf679524','38','1505817000',0,0,NULL,1505807862,1505807985,NULL),(1168,'51',132,175,223,302,'2017-09-19','18817555623','ffffffffffffff',1,1,'y20170919155754ce02e0c0a','39','1505818800',0,0,NULL,1505807874,1505807987,NULL),(1169,'51',132,175,223,302,'2017-09-19','18817555623','aaaaaaaaaaaaaa',1,2,'y20170919160223cf0f74c03','35','1505811600',1,0,NULL,1505808143,1505810799,NULL),(1170,'51',132,175,223,302,'2017-09-19','18817555623','',1,2,'y20170919160504cfb0eaf4d','36','1505813400',0,0,NULL,1505808304,1505810803,NULL),(1171,'51',132,171,222,303,'2017-09-19','18817320310','哈哈',1,0,'y20170919173932e5d4dc412','38','1505817000',1,1,NULL,1505813972,1505813972,NULL),(1172,'65',150,191,243,352,'2017-09-21','13162733315','可能会晚饭',2,0,'y20170919174452e714aab8b','25','1505966400',0,0,NULL,1505814292,1505905320,NULL),(1173,'60',145,189,238,328,'2017-09-19','18817320310','孔健健康康',1,0,'y20170919175440e960b078f','38','1505817000',1,1,NULL,1505814880,1505814880,NULL),(1174,'60',145,193,238,328,'2017-09-19','18817320310','',1,0,'y20170919175533e995cf1d2','38','1505817000',1,1,NULL,1505814933,1505814933,NULL),(1175,'74',157,204,251,398,'2017-09-22','13162733315','',2,0,'y2017091920001506cfec184','36','1506072600',0,0,NULL,1505822415,1505822488,NULL),(1176,'74',157,203,251,398,'2017-09-21','13162733315','',2,0,'y2017091920002506d90226e','27','1505970000',0,0,NULL,1505822425,1505823790,NULL),(1177,'71',156,198,257,375,'2017-09-20','18621730000','会来的',2,0,'y201709192006110833efffe','23','1505876400',0,0,NULL,1505822771,1505823855,NULL),(1178,'74',157,203,256,398,'2017-09-19','18817555623','请准时为我服务',2,0,'y201709192011040958d5911','43','1505826000',0,0,NULL,1505823064,1505823792,NULL),(1179,'73',160,200,250,400,'2017-09-20','13816636800','洗干净',2,0,'y2017091920122409a8a1988','22','1505874600',0,0,NULL,1505823144,1505823571,NULL),(1180,'73',160,200,255,400,'2017-09-20','18621791068','按时到店',2,0,'y201709192015030a471ffe5','27','1505883600',0,0,NULL,1505823303,1505823603,NULL),(1181,'71',156,206,257,387,'2017-09-19','18621730000','忙',1,1,'y201709192016470aaf4b290','47','1505833200',0,0,NULL,1505823407,1505823479,NULL),(1182,'71',156,207,257,376,'2017-09-19','18621730000','',2,0,'y201709192017110ac7d883a','48','1505835000',0,0,NULL,1505823431,1505823881,NULL),(1183,'73',160,200,255,399,'2017-09-20','18621791068','神圣不可侵犯',2,0,'y201709192018550b2f5b47b','25','1505880000',0,0,NULL,1505823535,1505823605,NULL),(1184,'72',155,202,261,373,'2017-09-20','13816630675','洗干净',2,0,'y201709192021380bd2be78c','20','1505871000',0,0,NULL,1505823698,1505823815,NULL),(1185,'72',155,202,261,373,'2017-09-20','13816630675','洗干净',2,0,'y201709192023040c2849609','19','1505869200',0,0,NULL,1505823784,1505823823,NULL),(1186,'73',160,200,262,399,'2017-09-20','18501755009','',1,0,'y201709192023490c555b23a','43','1505912400',1,1,NULL,1505823829,1505823829,NULL),(1187,'72',155,205,261,373,'2017-09-19','13816630675','',1,0,'y201709192026510d0b5a975','43','1505826000',1,1,0,1505824011,1505824011,NULL),(1188,'72',155,205,261,373,'2017-09-20','13816630675','',1,0,'y201709192030230ddf620a6','19','1505869200',1,1,0,1505824223,1505824223,NULL),(1189,'60',145,193,238,328,'2017-09-20','18817320310','',1,0,'y20170920100654cd3e50712','23','1505876400',1,1,0,1505873214,1505873214,NULL),(1190,'60',145,193,238,328,'2017-09-20','18817320310','',1,0,'y20170920100758cd7e7944c','30','1505889000',1,1,0,1505873278,1505873278,NULL),(1191,'60',145,193,238,328,'2017-09-20','18817320310','',1,0,'y20170920100858cdba0a9ca','26','1505881800',1,1,0,1505873338,1505873338,NULL),(1192,'60',145,194,239,327,'2017-09-21','18817555623','',1,1,'y20170920130829f7cded7a7','28','1505971800',1,1,0,1505884109,1506326207,NULL),(1193,'60',145,189,239,328,'2017-09-21','18817555623','',2,0,'y20170920130956f824ae1b6','29','1505973600',0,0,0,1505884196,1505884214,NULL),(1194,'70',154,196,268,363,'2017-09-21','18817555623','啊啊啊啊啊啊啊啊啊',2,0,'y20170920133055fd0f83337','15','1505948400',0,0,1,1505885455,1505885689,NULL),(1195,'70',154,196,268,363,'2017-09-20','18817555623','少时诵诗书所所所所所所所',2,0,'y20170920133107fd1b27d77','36','1505899800',0,0,0,1505885467,1505885818,1505885818),(1196,'70',154,196,268,363,'2017-09-21','18817555623','xmx',2,0,'y2017092016034020dcd32f2','23','1505962800',0,0,1,1505894620,1505979114,NULL),(1197,'69',152,208,242,347,'2017-09-21','15921021906','',2,0,'y201709201645482abc1c067','23','1505962800',0,0,1,1505897148,1505978141,1505978141),(1198,'76',163,210,270,405,'2017-09-21','17602570422','',1,0,'y2017092110243622e49c85e','31','1505977200',1,1,0,1505960676,1505960676,NULL),(1199,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,NULL,NULL,0,0,0,NULL,NULL,NULL),(1201,'51',132,171,222,302,'2017-09-21','18817320310','',1,0,'y201709211315164ae4ef29b','29','1505973600',1,1,0,1505970916,1505970916,NULL),(1202,'69',152,208,242,347,'2017-09-23','15921021906','',2,0,'y2017092114575262f0b96f1','22','1506133800',0,0,1,1505977072,1505978506,1505978506),(1203,'69',152,208,242,347,'2017-09-22','15921021906','',2,0,'y20170921151646675ecabc3','23','1506049200',0,0,1,1505978206,1505978304,NULL),(1204,'69',152,208,242,347,'2017-09-24','15921021906','',2,0,'y2017092115175867a6e66cc','22','1506220200',0,0,1,1505978278,1505978308,NULL),(1205,'70',154,196,268,363,'2017-09-21','18817555623','ssssssssssss',2,0,'y201709211530566ab07b565','33','1505980800',0,0,1,1505979056,1505979109,NULL),(1206,'70',154,196,268,363,'2017-09-21','18817555623','',2,0,'y20170921155613709d2b3d1','34','1505982600',0,0,1,1505980573,1505980602,NULL),(1207,'70',154,196,268,363,'2017-09-21','18817555623','llll',2,0,'y2017092115562470a8e2374','36','1505986200',0,0,1,1505980584,1505980604,NULL),(1208,'70',154,196,268,363,'2017-09-21','18817555623','asdsds',2,0,'y20170921193412a3b430af4','43','1505998800',0,0,1,1505993652,1505993675,NULL),(1209,'69',152,208,242,347,'2017-09-25','15921021906','',1,0,'y20170922092515667b28d14','23','1506308400',1,1,0,1506043515,1506043515,NULL),(1210,'69',167,212,242,415,'2017-09-22','15921021906','',2,0,'y20170922113647854fb0874','31','1506063600',0,0,1,1506051407,1506051438,NULL),(1211,'69',167,212,242,415,'2017-09-22','15921021906','',2,0,'y20170922113659855b1cd13','38','1506076200',0,0,1,1506051419,1506051440,NULL),(1212,'69',167,212,242,415,'2017-09-23','15921021906','',2,0,'y2017092211370685629b4e1','26','1506141000',0,0,1,1506051426,1506051441,NULL),(1213,'51',132,175,223,302,'2017-09-26','18817555623','',1,0,'y20170926135351eb6f54886','30','1506407400',1,1,0,1506405231,1506405231,NULL),(1214,'51',132,175,223,302,'2017-09-26','18817555623','',1,0,'y20170926140652ee7c398ec','35','1506416400',1,1,0,1506406012,1506406012,NULL),(1215,'60',145,193,238,328,'2017-09-29','18817320310','哈哈',1,0,'y20170929161229006dba422','35','1506675600',1,1,0,1506672749,1506672749,NULL),(1216,'60',145,193,238,327,'2017-10-10','18817320310','',1,0,'y201710100920252059f30db','21','1507600800',1,1,0,1507598426,1507598426,NULL),(1217,'60',145,193,238,328,'2017-10-11','18817320310','',1,0,'y20171011092604732c19312','21','1507687200',0,0,0,1507685164,1507685164,NULL),(1218,'65',150,191,244,353,'2017-10-12','15921021906','',1,0,'y2017101121471920e752605','20','1507771800',0,0,0,1507729639,1507729639,NULL);

/*Table structure for table `wr_comment_tag` */

DROP TABLE IF EXISTS `wr_comment_tag`;

CREATE TABLE `wr_comment_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `introduce` varchar(255) DEFAULT NULL COMMENT '标签介绍',
  `pid` int(11) DEFAULT NULL COMMENT '父级id',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `level` tinyint(5) DEFAULT NULL COMMENT '产品层级 0 一级 1二级',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `wr_comment_tag` */

insert  into `wr_comment_tag`(`id`,`introduce`,`pid`,`sort`,`level`,`created_at`,`updated_at`) values (8,'态度',0,0,0,NULL,NULL),(9,'技术',0,1,0,NULL,NULL),(10,'守时',0,2,0,NULL,NULL),(11,'态度很棒',8,0,1,NULL,NULL),(12,'一般',8,1,1,NULL,NULL),(13,'有点差',8,2,1,NULL,NULL),(14,'技术一流',9,0,1,NULL,NULL),(15,'一般',9,1,1,NULL,NULL),(16,'不满意',9,2,1,NULL,NULL),(17,'非常守时',10,0,1,NULL,NULL),(18,'一般',10,1,1,NULL,NULL),(19,'不守时',10,2,1,NULL,NULL);

/*Table structure for table `wr_custom_menu` */

DROP TABLE IF EXISTS `wr_custom_menu`;

CREATE TABLE `wr_custom_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `url` varchar(255) DEFAULT NULL COMMENT '关联URL',
  `keyword` varchar(100) DEFAULT NULL COMMENT '关联关键词',
  `title` varchar(50) NOT NULL COMMENT '菜单名',
  `pid` int(10) DEFAULT '0' COMMENT '一级菜单',
  `sort` tinyint(4) DEFAULT '0' COMMENT '排序号',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `type` varchar(30) DEFAULT 'click' COMMENT '类型',
  `from_type` char(50) DEFAULT '-1' COMMENT '配置动作',
  `target_id` int(10) DEFAULT NULL COMMENT '选择内容',
  `sucai_type` varchar(50) DEFAULT NULL COMMENT '素材类型',
  `jump_type` int(10) DEFAULT '0' COMMENT '推送类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='公众号菜单表';

/*Data for the table `wr_custom_menu` */

/*Table structure for table `wr_goods_cate` */

DROP TABLE IF EXISTS `wr_goods_cate`;

CREATE TABLE `wr_goods_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `goods_name` varchar(255) DEFAULT NULL COMMENT '产品名称',
  `pid` varchar(50) DEFAULT '0' COMMENT '父级id',
  `sort` int(10) DEFAULT '0' COMMENT '排序',
  `merchant_id` int(10) unsigned DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `level` tinyint(4) DEFAULT '0' COMMENT '产品层级 0 一级 1二级',
  `price` decimal(10,2) DEFAULT NULL COMMENT '产品价目',
  `sever_time` varchar(255) DEFAULT '1' COMMENT '服务时长',
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=465 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='产品表';

/*Data for the table `wr_goods_cate` */

insert  into `wr_goods_cate`(`id`,`goods_name`,`pid`,`sort`,`merchant_id`,`updated_at`,`level`,`price`,`sever_time`,`created_at`) values (330,'美发','0',4,51,1505705769,0,NULL,'1',1505705769),(320,'洗发','317',0,58,1505444914,1,'20.00','2',1505444914),(319,'美容','0',3,58,1505444734,0,NULL,'1',1505444734),(318,'按摩','0',2,58,1505444734,0,NULL,'1',1505444734),(317,'理发','0',1,58,1505444734,0,NULL,'1',1505444734),(316,'爹秘密哦','313',0,55,1505368869,1,'65666.00','2',1505368869),(315,'啊考虑考虑','314',0,55,1505368854,1,'6666.00','3',1505368854),(314,'qwqwqwqw','0',2,55,1505268369,0,NULL,'1',1505268369),(313,'wqqw','0',1,55,1505268369,0,NULL,'1',1505268369),(312,'高级美甲','310',0,57,1505213428,1,'90.00','2',1505213428),(311,'洗剪吹','309',0,57,1505213415,1,'30.00','1',1505213415),(310,'美甲','0',2,57,1505213252,0,NULL,'1',1505213252),(309,'美发','0',1,57,1505213252,0,NULL,'1',1505213252),(308,'悦发潮染','301',1,51,1505096937,1,'500.00','3',1505096937),(307,'施华蔻伊采染','301',0,51,1505096937,1,'700.00','3',1505096937),(306,'菲灵热烫','300',1,51,1505096807,1,'400.00','3',1505096807),(305,'悦.水润能量极致烫','300',0,51,1505096807,1,'300.00','3',1505096807),(304,'成人精剪','299',2,51,1505096690,1,'100.00','1',1505096690),(303,'儿童精剪','299',1,51,1505108417,1,'80.00','1',1505096690),(302,'洗+剪+吹','299',0,51,1505096690,1,'50.00','1',1505096690),(301,'染发','0',3,51,1505096622,0,NULL,'1',1505096622),(300,'烫发','0',2,51,1505096622,0,NULL,'1',1505096622),(299,'剪发','0',1,51,1505096622,0,NULL,'1',1505096622),(331,'剪发','0',5,51,1505705769,0,NULL,'1',1505705769),(325,'美发','0',1,60,1505705203,0,NULL,'1',1505705203),(326,'美甲','0',2,60,1505705203,0,NULL,'1',1505705203),(327,'洗发','325',0,60,1505705250,1,'15.00','1',1505705250),(328,'洗剪吹','325',1,60,1505705250,1,'30.00','2',1505705250),(329,'高级美甲套餐','326',0,60,1505717173,1,'60.00','6',1505705268),(332,'刘海烫','0',1,59,1505712603,0,NULL,'1',1505712603),(333,'齐刘海','332',0,59,1505712618,1,'2121.00','8',1505712618),(334,'美容美发1','0',1,61,1505713649,0,NULL,'1',1505713649),(335,'美容美发小类','334',0,61,1505713669,1,'199.00','4',1505713669),(336,'头发护理','331',0,51,1505716209,1,'6000.00','6',1505716209),(348,'剪发','0',1,65,1505811463,0,NULL,'1',1505811463),(349,'烫染','0',2,65,1505811463,0,NULL,'1',1505811463),(350,'接发','0',3,65,1505811463,0,NULL,'1',1505811463),(351,'护理','0',4,65,1505811463,0,NULL,'1',1505811463),(352,'单人精剪','348',0,65,1505811623,1,'68.00','1',1505811623),(425,'aaa','Array',0,69,1506062520,1,'222.00','3',1506062520),(353,'单人精剪+雕花','348',1,65,1505811623,1,'98.00','2',1505811623),(354,'单人日本施蔻烫染','349',0,65,1505811801,1,'488.00','7',1505811801),(355,'单人资生堂烫染','349',1,65,1505811801,1,'988.00','8',1505811801),(356,'无痕单色接发（40束）','350',0,65,1505812011,1,'1288.00','8',1505812011),(357,'七彩无痕接发（40束）','350',1,65,1505812011,1,'1588.00','8',1505812011),(358,'单人清新自然植物护理','351',0,65,1505812303,1,'328.00','2',1505812303),(359,'单人水润轻盈养护','351',1,65,1505812303,1,'228.00','2',1505812303),(360,'单人焕彩染','351',2,65,1505812303,1,'388.00','4',1505812303),(361,'单人型男SDE PARTING','351',3,65,1505812303,1,'68.00','2',1505812303),(362,'剪发','0',1,70,1505815542,0,NULL,'1',1505815542),(363,'洗剪吹','362',0,70,1505815594,1,'30.00','1',1505815594),(364,'儿童精剪','362',0,70,1505817428,1,'100.00','1',1505817428),(365,'理发','0',1,72,1505819533,0,NULL,'1',1505819533),(366,'美甲','0',2,72,1505819533,0,NULL,'1',1505819533),(367,'按摩','0',3,72,1505819533,0,NULL,'1',1505819533),(368,'美容','0',1,71,1505819598,0,NULL,'1',1505819598),(369,'美发','0',2,71,1505819598,0,NULL,'1',1505819598),(370,'美甲','0',3,71,1505819598,0,NULL,'1',1505819598),(371,'身体护理','0',4,71,1505819598,0,NULL,'1',1505819598),(372,'理疗类','0',5,71,1505819598,0,NULL,'1',1505819598),(373,'干洗','365',0,72,1505819722,1,'20.00','1',1505819722),(374,'洗剪吹','365',1,72,1505819722,1,'30.00','2',1505819722),(375,'深处洁肤','368',0,71,1505819736,1,'88.00','1',1505819736),(376,'深层补水','368',1,71,1505819736,1,'88.00','1',1505819736),(377,'烫发','369',0,71,1505819809,1,'168.00','3',1505819809),(378,'美容','0',1,73,1505819812,0,NULL,'1',1505819812),(379,'美发','0',2,73,1505819812,0,NULL,'1',1505819812),(380,'美甲','0',3,73,1505819812,0,NULL,'1',1505819812),(381,'医疗整形','0',4,73,1505819812,0,NULL,'1',1505819812),(382,'甲1','366',0,72,1505819837,1,'20.00','2',1505819837),(383,'甲2','366',1,72,1505819837,1,'30.00','1',1505819837),(384,'养生','0',5,73,1505819858,0,NULL,'1',1505819858),(385,'脸部按摩','367',0,72,1505819875,1,'50.00','2',1505819875),(386,'腿部按摩','367',1,72,1505819875,1,'88.00','2',1505819875),(387,'干洗，剪，吹','369',0,71,1505820957,1,'68.00','2',1505820957),(388,'洗甲护理','370',0,71,1505821298,1,'56.00','1',1505821298),(389,'足浴','0',1,75,1505821427,0,NULL,'1',1505821427),(390,'背部Spa','371',0,71,1505821439,1,'168.00','2',1505821439),(391,'洗脚','389',0,75,1505821453,1,'198.00','1',1505821453),(392,'颈肩按摩','372',0,71,1505821465,1,'98.00','2',1505821465),(393,'洗脸','389',0,75,1505821491,1,'168.00','1',1505821491),(394,'美发','0',1,74,1505821555,0,NULL,'1',1505821555),(395,'保健','0',2,74,1505821555,0,NULL,'1',1505821555),(396,'洗','394',0,74,1505821686,1,'10.00','1',1505821686),(397,'剪','394',1,74,1505821686,1,'10.00','1',1505821686),(398,'吹','394',2,74,1505821686,1,'10.00','1',1505821686),(399,'施华蔻美容','378',0,73,1505822739,1,'288.00','2',1505822739),(400,'U+美容','378',1,73,1505822739,1,'388.00','3',1505822739),(401,'美发','0',1,76,1505959600,0,NULL,'1',1505959600),(402,'染发','0',2,76,1505959629,0,NULL,'1',1505959629),(403,'美甲','0',3,76,1505959639,0,NULL,'1',1505959639),(404,'美体','0',4,76,1505959649,0,NULL,'1',1505959649),(405,'洗剪吹','401',0,76,1505959768,1,'30.00','1',1505959768),(406,'螺旋烫','401',0,76,1505959840,1,'199.00','2',1505959840),(407,'公主烫','401',0,76,1505959868,1,'259.00','3',1505959868),(408,'速染','402',0,76,1505959966,1,'39.00','1',1505959966),(409,'无痕烫染','402',0,76,1505960009,1,'299.00','3',1505960009),(410,'美甲','403',0,76,1505960029,1,'99.00','2',1505960029),(411,'微纤瘦身','404',0,76,1505960107,1,'599.00','5',1505960107),(430,'子类1','429',0,69,1506063963,1,'11.00','5',1506063963),(426,'aaa','Array',0,69,1506062601,1,'222.00','3',1506062601),(427,'女生剪发','362',0,70,1506062612,1,'200.00','2',1506062612),(429,'大类1','0',1,69,1506063891,0,NULL,'1',1506063891),(431,'就是看看书','0',1,81,1506310275,0,NULL,'1',1506310275),(432,'大家觉得肯定','431',0,81,1506310289,1,'49.00','2',1506310289),(439,'dalei 1','0',2,69,1506325328,0,NULL,'1',1506325328),(440,'212121','0',3,69,1506325328,0,NULL,'1',1506325328),(441,'ssasaas','0',4,69,1506325363,0,NULL,'1',1506325363),(442,'212','439',0,69,1506325524,1,'212.00','3',1506325524),(443,'chiahihosa','0',5,69,1506325592,0,NULL,'1',1506325592),(444,'saasas','439',0,69,1506325613,1,'21212.00','2',1506325613),(445,'hahah','0',6,69,1506325788,0,NULL,'1',1506325788),(446,'大类1','0',7,69,1506326283,0,NULL,'1',1506326283),(447,'大类2','0',8,69,1506326283,0,NULL,'1',1506326283),(448,'子类1','446',0,69,1506326294,1,'2.00','4',1506326294),(449,'撒 爱死','447',0,69,1506326303,1,'21221.00','5',1506326303),(450,'打雷1','0',9,69,1506326559,0,NULL,'1',1506326559),(451,'一类1','450',0,69,1506326571,1,'55.00','5',1506326571),(464,'烫发','462',0,82,1506335597,1,'699.00','4',1506335597),(463,'理发','462',0,82,1506335550,1,'80.00','1',1506335550),(462,'美容','0',1,82,1506335529,0,NULL,'1',1506335529);

/*Table structure for table `wr_member` */

DROP TABLE IF EXISTS `wr_member`;

CREATE TABLE `wr_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `member_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '会员名',
  `tel` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT '手机号',
  `open_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '微信open_id',
  `status` tinyint(4) DEFAULT '1' COMMENT '会员状态\n0:禁用\n1:正常',
  `birthday` int(10) DEFAULT NULL COMMENT '生日',
  `sex` int(10) DEFAULT NULL COMMENT '性别(0 保密、1男 2女)',
  `merchant_id` int(10) DEFAULT NULL COMMENT '商户id',
  `img` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '会员头像',
  `created_at` int(10) DEFAULT NULL COMMENT '注册时间',
  `updated_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=280 DEFAULT CHARSET=utf8mb4 COMMENT='会员表';

/*Data for the table `wr_member` */

insert  into `wr_member`(`id`,`member_name`,`tel`,`open_id`,`status`,`birthday`,`sex`,`merchant_id`,`img`,`created_at`,`updated_at`,`deleted_at`) values (223,'木亦1','18817555623','o9KRbwu81cSVzg9g7nKpi0hqveLI',1,NULL,1,51,'http://wx.qlogo.cn/mmopen/ib5YqYfqAabP6Ngy2nkD3FeAJ44FxZicWuosFxibicL7MECPoeydCTdicmaCeo72krjbbyibXWEF3YK1r0MGLjvTRX1BGHt52uiaJWa/0',1505182825,1505376495,NULL),(225,'六儿','13162733315','o9KRbwqDFkdJEcZgn4edsKHpvMKA',1,NULL,1,51,'http://wx.qlogo.cn/mmopen/ZXmcialJQl69hYah6QkdbAHBMSuBC999D0s9ibgdMY7wljibt20nOhytcuND2fjD0Vq1jrux7ibRQCvmdLGMsXvXsy0H0bERWU6P/0',1505289212,1505289341,NULL),(227,'郭小郭',NULL,'o9KRbwgC9mKcWxYHWC8Nnq42OgoI',1,NULL,1,51,'http://wx.qlogo.cn/mmopen/Mlib1ibM9j4BgVVs5xquTCviaBw2BS97czAbMBsCxNRrwdYiclZjIO5jiboRl0oeicUHPd8gtg7RHMhF39PVWcGVXGWTduzjbQwzJp/0',1505292427,NULL,NULL),(228,'木亦','18817555624','o9KRbwu81cSVzg9g7nKpi0hqveLI',1,NULL,1,55,'http://wx.qlogo.cn/mmopen/ib5YqYfqAabP6Ngy2nkD3FeAJ44FxZicWuosFxibicL7MECPoeydCTdicmaCeo72krjbbyibXWEF3YK1r0MGLjvTRX1BGHt52uiaJWa/0',1505292890,1505292944,NULL),(229,'六儿','13162733315','o9KRbwqDFkdJEcZgn4edsKHpvMKA',1,NULL,1,55,'http://wx.qlogo.cn/mmopen/ibxzdLaqAycQr4tcJVS6NJuclxHmPWTSagWuAVoDZb3L2YCmlT2AF3YsqhDh0f1h1703aPHlyMYTcRmoDp7wbVovDLv77wwOV/0',1505371315,1505371387,NULL),(230,'贺兰丛丛','18817320310','oZ9stwp4O1mX9AEgZHeUThmfjq0s',1,NULL,1,57,'http://wx.qlogo.cn/mmopen/tBcsVoCs6ibOl0wI8lCuvDKKSYowRAS0gLgeqVxMuiaMq5I2q88icH0eDIhTw3BfibokvNtv477fh05gicEdRBkKo3picicfibHGrZdV/0',1505373430,1505376629,NULL),(231,'木亦','18817555623','oZ9stwkrneXquTo2V1Z9MnjBh2Hk',1,NULL,1,57,'http://wx.qlogo.cn/mmopen/ialKLLGy1WwWYOtbJibwicicQAnuZaT7c24AialqfabUrYnkFtImticBSxlADrOXYlPsQInYLUlyDdqNt4TdONyTImqA2gXuG8rnSA/0',1505376876,1505377012,NULL),(232,'贺兰丛丛','18817320310','o9KRbwrHxbx-HENgY2zx-Zhki_64',1,NULL,1,55,'http://wx.qlogo.cn/mmopen/FfcQhWeOnVhL3JTf99UTfBq3BojQko9wgKItdM8rJTud9ZWHM86uEX4cibWnETribNr1yVibLAVSFkMwiaOqNFaRwKZnUXH1Vwon/0',1505377350,1505384640,NULL),(234,'Fget',NULL,'oZ9stwuLKDDZ2xliY4GLhWtCjp9s',1,NULL,1,57,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLDkJia20WviapPCbCc8ZRW6hxewCblzLr0VSCON1CibmH4hHzCYVHp0NjSdGuSN7NB3YpYmHD4PTVISA/0',1505445797,NULL,NULL),(235,'Fget','13816636800','o9KRbwoTOqvHGG0lb1YRmMzRc99A',1,NULL,1,58,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLDZ85tU644Jfb2MfcPuOrNgoxZxy1WElY0ZHiaIWoKVAT0D4ntDYRc9e1u1FaibEYziaWiat6h1st5ozQ/0',1505445849,1505445924,NULL),(236,'六儿','13162733315','o9KRbwqDFkdJEcZgn4edsKHpvMKA',1,NULL,1,58,'http://wx.qlogo.cn/mmopen/ibxzdLaqAycQr4tcJVS6NJuclxHmPWTSagWuAVoDZb3L2YCmlT2AF3YsqhDh0f1h1703aPHlyMYTcRmoDp7wbVovDLv77wwOV/0',1505446325,1505446376,NULL),(238,'贺兰丛丛','18817320310','oDrxZ0vN4OcZhly4cAxC3UWYsSIo',1,NULL,1,60,'http://wx.qlogo.cn/mmopen/ryCQ4PkLrx7kLG0V61rP69eFNmzZSCIc4YuJBLQyjbbmWkJ5YXgsPA9PpWfkEONiamxAbPM02EiboMKHsqzzgeGDPnx64x2wkv/0',1505706602,1505706662,NULL),(239,'木亦','18817555623','oDrxZ0p3lLuqAThT6rH8ptNTI5l8',1,NULL,1,60,'http://wx.qlogo.cn/mmopen/aRlMvCYr2RlVwxorc1pyFeAXmxepkM7WwoArLNUicbepHOGMzk0IohSKUxctb2Uj3zqpFFEa5I8BJfXWHOxx8EBvNaRI5FT83/0',1505713719,1505713782,NULL),(240,'六儿','13162733315','o9KRbwqDFkdJEcZgn4edsKHpvMKA',1,NULL,1,61,'http://wx.qlogo.cn/mmopen/Mlib1ibM9j4BgVVs5xquTCvpfcnIKm7Y51nMm9OE5cUp4DaDIBAro42q8aiaJYumrZD3ftgl9Ec1MckOzug9ibj6KAPgUsiaE3l7I/0',1505715225,1505715288,NULL),(241,'阿钟喵','15921021906','o9KRbwruUVLveGr2Y0lauhNWEy-A',1,NULL,1,61,'http://wx.qlogo.cn/mmopen/FfcQhWeOnVhL3JTf99UTfIQqdZlkproTUKpaicKoHgtI5dZibWJud9sc47b11zkHDtdIyjrIHHCG1icBWqAoru0eJWKRRQoXVVe/0',1505716840,1505716880,NULL),(242,'阿钟喵','15921021906','o9KRbwruUVLveGr2Y0lauhNWEy-A',1,NULL,1,69,'http://wx.qlogo.cn/mmopen/FfcQhWeOnVhL3JTf99UTfIQqdZlkproTUKpaicKoHgtI5dZibWJud9sc47b11zkHDtdIyjrIHHCG1icBWqAoru0eJWKRRQoXVVe/0',1505798171,1505798220,NULL),(243,'六儿','13162733315','oDrxZ0mA3A1Mtm-1fXGp6-91eCPc',1,NULL,1,65,'http://wx.qlogo.cn/mmopen/H2CxJ1pMnFkXGaqyXYDdzAAsfGQBz7iaibjnYtqLP2DITgRLfs5IVdC30a6uZHf9ib2OHFn5tcLZ3ZjaaEndCK2crGRb3hGofaic/0',1505798270,1505815955,NULL),(244,'阿钟喵','15921021906','oDrxZ0kTW7sr6tTE9cJXObv51M2A',1,NULL,1,65,'https://image.weerun.com/wr2/2017-09-1959a7f7ad1073a7a82b848755ea0425b9.JPG',1505804202,1505815665,NULL),(245,'Fget','13816636800','oDrxZ0nbY7Iz1tpnUSa0LbRyBiiM',1,NULL,1,65,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLB0pOaUvyL0SMnH1GrbJC70NGUjhmBdUDbk1ibwoIQfU6EM90ooTiaDUiap6KJAQPT9QAjn5U5v7cbicA/0',1505814649,1505814694,NULL),(246,'金宇Johnny','18621668709','oDrxZ0hOdCUJbPVCaB1vlN1Ppkzs',1,NULL,1,65,'http://wx.qlogo.cn/mmopen/ryCQ4PkLrx7kLG0V61rP6ibSvrPwppnWXmGFFBw73CIL68Hib08ibB1jXsfpWNHHJVXwR7RpKWjBWU211rrDQNjUHm78AVMAsqia/0',1505814919,1505814953,NULL),(247,'唐',NULL,'oDrxZ0sL4xgxU9NDLFV2PQko0-4A',1,NULL,2,65,'http://wx.qlogo.cn/mmopen/Q3auHgzwzM7gOBXFIXMC0MLDfE77rrsfMRL11nLn8BqH7qh4H1W4COgN2wC2PXoxfDmaFq5z6P6tYBRAeQP81OXh2EcKLztYMFHGKTFyXPM/0',1505814969,NULL,NULL),(248,'avel','18621730000','oDrxZ0vOldFWoU981Vj2bulBq474',1,NULL,2,65,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLAkFLhaLibSGBcElCHkvYEbYJEbvt7WBibkicticPqggslrscqlWSawzIsv4lo61eibNq5Q8wKRD2mml5Q/0',1505817315,1505822468,NULL),(249,'金宇Johnny','18621668709','oDrxZ0hOdCUJbPVCaB1vlN1Ppkzs',1,NULL,1,73,'http://wx.qlogo.cn/mmopen/ryCQ4PkLrx7kLG0V61rP6ibSvrPwppnWXmGFFBw73CIL68Hib08ibB1jXsfpWNHHJVXwR7RpKWjBWU211rrDQNjUHm78AVMAsqia/0',1505819274,1505824444,NULL),(250,'Fget','13816636800','oDrxZ0nbY7Iz1tpnUSa0LbRyBiiM',1,NULL,1,73,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLB0pOaUvyL0SMnH1GrbJC70NGUjhmBdUDbk1ibwoIQfU6EM90ooTiaDUiap6KJAQPT9QAjn5U5v7cbicA/0',1505822314,1505822406,NULL),(251,'六儿','13162733315','oDrxZ0mA3A1Mtm-1fXGp6-91eCPc',1,NULL,1,74,'http://wx.qlogo.cn/mmopen/H2CxJ1pMnFkXGaqyXYDdzAAsfGQBz7iaibjnYtqLP2DITgRLfs5IVdC30a6uZHf9ib2OHFn5tcLZ3ZjaaEndCK2crGRb3hGofaic/0',1505822332,1505822388,NULL),(252,'杨世海','13816630675','oDrxZ0k00Jr3m7rPx4KqoEz5lGCM',1,NULL,1,74,'http://wx.qlogo.cn/mmopen/Q3auHgzwzM40uQ0lyd6jrbNkibSV1SysvO2wv4dZsZhFTZfm82fKZC3Y3b1ngzjmpyEVhOsia27qEF1Fgo0ia37MA/0',1505822339,1505822410,NULL),(253,'阿钟喵','15921021906','oDrxZ0kTW7sr6tTE9cJXObv51M2A',1,NULL,1,74,'http://wx.qlogo.cn/mmopen/ryCQ4PkLrx7kLG0V61rP6ibRic5Gq8DL2FPPdc0egFsxetzS5K2MnK1K2z0yPkgPqQzghm3Aia0SVtWyYTTFaiaesRiaocqBSPjiaK/0',1505822341,1505877421,NULL),(254,'avel',NULL,'oDrxZ0vOldFWoU981Vj2bulBq474',1,NULL,2,74,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLAkFLhaLibSGBcElCHkvYEbYJEbvt7WBibkicticPqggslrscqlWSawzIsv4lo61eibNq5Q8wKRD2mml5Q/0',1505822352,NULL,NULL),(255,'皓月Owen','18621791068','oDrxZ0oyvYEE5AHBMHeUSNFwGilU',1,NULL,1,73,'http://wx.qlogo.cn/mmopen/H2CxJ1pMnFkXGaqyXYDdzCLsQg67AZcc0EjKHsRe3tQLLCH6OicvHlyVlcGVbtQhbgkduk1WaibCZn4p0CG5dvvgHumP0gx2rF/0',1505822380,1505822432,NULL),(256,'木亦','18817555623','oDrxZ0p3lLuqAThT6rH8ptNTI5l8',1,NULL,1,74,'http://wx.qlogo.cn/mmopen/aRlMvCYr2RlVwxorc1pyFeAXmxepkM7WwoArLNUicbepHOGMzk0IohSKUxctb2Uj3zqpFFEa5I8BJfXWHOxx8EBvNaRI5FT83/0',1505822426,1505822945,NULL),(257,'avel','18621730000','oDrxZ0vOldFWoU981Vj2bulBq474',1,NULL,2,71,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLAkFLhaLibSGBcElCHkvYEbYJEbvt7WBibkicticPqggslrscqlWSawzIsv4lo61eibNq5Q8wKRD2mml5Q/0',1505822595,1505822650,NULL),(258,'杨世海','13816630675','oDrxZ0k00Jr3m7rPx4KqoEz5lGCM',1,NULL,1,73,'http://wx.qlogo.cn/mmopen/Q3auHgzwzM40uQ0lyd6jrbNkibSV1SysvO2wv4dZsZhFTZfm82fKZC3Y3b1ngzjmpyEVhOsia27qEF1Fgo0ia37MA/0',1505822765,1505822816,NULL),(259,'皓月Owen','18621791068','oDrxZ0oyvYEE5AHBMHeUSNFwGilU',1,NULL,1,72,'http://wx.qlogo.cn/mmopen/H2CxJ1pMnFkXGaqyXYDdzCLsQg67AZcc0EjKHsRe3tQLLCH6OicvHlyVlcGVbtQhbgkduk1WaibCZn4p0CG5dvvgHumP0gx2rF/0',1505822834,1505825280,NULL),(260,'杨世海','13816630675','oDrxZ0k00Jr3m7rPx4KqoEz5lGCM',1,NULL,1,71,'http://wx.qlogo.cn/mmopen/Q3auHgzwzM40uQ0lyd6jrbNkibSV1SysvO2wv4dZsZhFTZfm82fKZC3Y3b1ngzjmpyEVhOsia27qEF1Fgo0ia37MA/0',1505823126,1505823223,NULL),(261,'杨世海','13816630675','oDrxZ0k00Jr3m7rPx4KqoEz5lGCM',1,NULL,1,72,'http://wx.qlogo.cn/mmopen/Q3auHgzwzM40uQ0lyd6jrbNkibSV1SysvO2wv4dZsZhFTZfm82fKZC3Y3b1ngzjmpyEVhOsia27qEF1Fgo0ia37MA/0',1505823358,1505823396,NULL),(262,'刘俊','18501755009','oDrxZ0jO4nlfyNzbX7DTVAygl6wg',1,NULL,1,73,'http://wx.qlogo.cn/mmopen/ryCQ4PkLrx7kLG0V61rP61l2oyUe4f8Zq5Bfmyb2Jgx7C2TOI4guF7TVIskeXNGmWCS5kIV2ziaRD2Vc0SA3SXzHvnMJZ0g51/0',1505823750,1505823800,NULL),(263,'avel','18621730000','oDrxZ0vOldFWoU981Vj2bulBq474',1,NULL,2,73,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLAkFLhaLibSGBcElCHkvYEbYJEbvt7WBibkicticPqggslrscqlWSawzIsv4lo61eibNq5Q8wKRD2mml5Q/0',1505824270,1505824377,NULL),(264,'木亦','18817555623','oDrxZ0p3lLuqAThT6rH8ptNTI5l8',1,NULL,1,71,'http://wx.qlogo.cn/mmopen/aRlMvCYr2RlVwxorc1pyFeAXmxepkM7WwoArLNUicbepHOGMzk0IohSKUxctb2Uj3zqpFFEa5I8BJfXWHOxx8EBvNaRI5FT83/0',1505824497,1505824532,NULL),(265,'avel',NULL,'oDrxZ0vOldFWoU981Vj2bulBq474',1,NULL,2,72,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLAkFLhaLibSGBcElCHkvYEbYJEbvt7WBibkicticPqggslrscqlWSawzIsv4lo61eibNq5Q8wKRD2mml5Q/0',1505825150,NULL,NULL),(266,'杨世海',NULL,'oDrxZ0k00Jr3m7rPx4KqoEz5lGCM',1,NULL,1,65,'http://wx.qlogo.cn/mmopen/Q3auHgzwzM40uQ0lyd6jrbNkibSV1SysvO2wv4dZsZhFTZfm82fKZC3Y3b1ngzjmpyEVhOsia27qEF1Fgo0ia37MA/0',1505825290,NULL,NULL),(267,'刘俊',NULL,'oDrxZ0jO4nlfyNzbX7DTVAygl6wg',1,NULL,1,72,'http://wx.qlogo.cn/mmopen/ryCQ4PkLrx7kLG0V61rP61l2oyUe4f8Zq5Bfmyb2Jgx7C2TOI4guF7TVIskeXNGmWCS5kIV2ziaRD2Vc0SA3SXzHvnMJZ0g51/0',1505825433,NULL,NULL),(268,'木亦','18817555623','oDrxZ0p3lLuqAThT6rH8ptNTI5l8',1,NULL,1,70,'http://wx.qlogo.cn/mmopen/aRlMvCYr2RlVwxorc1pyFeAXmxepkM7WwoArLNUicbepHOGMzk0IohSKUxctb2Uj3zqpFFEa5I8BJfXWHOxx8EBvNaRI5FT83/0',1505885197,1505885438,NULL),(269,'管福康','17602570422','oDrxZ0pQ5gapqK0nykoC4RnsBE-s',1,NULL,1,72,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLDo9RA6kTvL2CeicfmVcaj2j6TE5WOwIUMywah20OD5R6ibLKXt2MqFKqfjYeb2448C8icFjMTmWUGpg/0',1505958400,1505958524,NULL),(270,'管福康','17602570422','oDrxZ0pQ5gapqK0nykoC4RnsBE-s',1,NULL,1,76,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLDo9RA6kTvL2CeicfmVcaj2j6TE5WOwIUMywah20OD5R6ibLKXt2MqFKqfjYeb2448C8icFjMTmWUGpg/0',1505960621,1505960649,NULL),(273,'六儿',NULL,'oDrxZ0mA3A1Mtm-1fXGp6-91eCPc',1,NULL,1,77,'http://wx.qlogo.cn/mmopen/H2CxJ1pMnFkXGaqyXYDdzAAsfGQBz7iaibjnYtqLP2DITgRLfs5IVdC30a6uZHf9ib2OHFn5tcLZ3ZjaaEndCK2crGRb3hGofaic/0',1505966098,NULL,NULL),(274,'贺兰丛丛','18817320310','osOP3wuCEkfMWtFjXWO-wQRbXTAw',1,NULL,1,79,'http://wx.qlogo.cn/mmopen/JxIbOe23BHicKlJnEzNaYR6NnvwQISWLS68wFUWJpU5n7D6ewtyLL0kSe1uj5DZhWrQD4byT67pwReGoLrIPmaWTEwBohE1ibib/0',1505967092,1505968335,NULL),(275,'Fget','13816636800','osOP3wuCVZ9lPa7_4tI3sVChnPTk',1,NULL,1,79,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLANkFgc5Zyfq8qibMcdHibhOtllpH24T6leXppKXYiaMQqCCOicCqexZCt1gRLEnKsfFQ39hrB7KK8CXg/0',1505990231,1505991184,NULL),(276,'贺兰丛丛','18817320310','o9KRbwrHxbx-HENgY2zx-Zhki_64',1,NULL,1,51,'http://wx.qlogo.cn/mmopen/FfcQhWeOnVhL3JTf99UTfBq3BojQko9wgKItdM8rJTud9ZWHM86uEX4cibWnETribNr1yVibLAVSFkMwiaOqNFaRwKZnUXH1Vwon/0',1506306536,1506418571,NULL),(277,'贺兰丛丛',NULL,'o9KRbwrHxbx-HENgY2zx-Zhki_64',1,NULL,1,58,'http://wx.qlogo.cn/mmopen/FfcQhWeOnVhL3JTf99UTfBq3BojQko9wgKItdM8rJTud9ZWHM86uEX4cibWnETribNr1yVibLAVSFkMwiaOqNFaRwKZnUXH1Vwon/0',1506306595,NULL,NULL),(278,'木亦',NULL,'oDrxZ0p3lLuqAThT6rH8ptNTI5l8',1,NULL,1,65,'http://wx.qlogo.cn/mmopen/aRlMvCYr2RlVwxorc1pyFeAXmxepkM7WwoArLNUicbepHOGMzk0IohSKUxctb2Uj3zqpFFEa5I8BJfXWHOxx8EBvNaRI5FT83/0',1506329249,NULL,NULL),(279,'贺兰丛丛','18817320310','oDrxZ0vN4OcZhly4cAxC3UWYsSIo',1,NULL,1,74,'http://wx.qlogo.cn/mmopen/ryCQ4PkLrx7kLG0V61rP69eFNmzZSCIc4YuJBLQyjbbmWkJ5YXgsPA9PpWfkEONiamxAbPM02EiboMKHsqzzgeGDPnx64x2wkv/0',1506415151,1506415722,NULL);

/*Table structure for table `wr_member_album` */

DROP TABLE IF EXISTS `wr_member_album`;

CREATE TABLE `wr_member_album` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(50) DEFAULT NULL COMMENT '作品名称',
  `introduce` varchar(500) DEFAULT NULL COMMENT '作品介绍',
  `merchant_id` int(11) DEFAULT NULL COMMENT '商户id',
  `shop_id` int(11) DEFAULT NULL COMMENT '门店id',
  `member_id` int(11) DEFAULT NULL COMMENT '客户id',
  `img_front` varchar(255) DEFAULT NULL COMMENT '正面',
  `img_left` varchar(255) DEFAULT NULL COMMENT '左侧',
  `img_right` varchar(255) DEFAULT NULL COMMENT '右侧',
  `img_back` varchar(255) DEFAULT NULL COMMENT '背面',
  `created_at` int(11) DEFAULT NULL COMMENT '上传时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '作品修改时间',
  `is_open` int(11) DEFAULT NULL COMMENT '是否公开\n1：公开\n2：不公开',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户作品表';

/*Data for the table `wr_member_album` */

/*Table structure for table `wr_merchant` */

DROP TABLE IF EXISTS `wr_merchant`;

CREATE TABLE `wr_merchant` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_name` varchar(100) DEFAULT NULL COMMENT '商户名字',
  `introduce` varchar(255) DEFAULT NULL COMMENT '商户介绍',
  `role` int(11) DEFAULT NULL COMMENT '商户角色',
  `expire` int(11) DEFAULT NULL COMMENT '商户到期时间',
  `shop_nums` int(11) DEFAULT '1' COMMENT '商户可添加的门店数',
  `qr_code_waiter` varchar(255) DEFAULT NULL COMMENT '服务师二维码',
  `logo` varchar(255) DEFAULT NULL COMMENT '商户logo',
  `public_id` int(11) DEFAULT NULL,
  `qr_code_member` varchar(255) DEFAULT NULL COMMENT '会员二维码',
  `status` tinyint(4) DEFAULT '1' COMMENT '公众号状态\n0：禁用\n1：正常',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COMMENT='商户表';

/*Data for the table `wr_merchant` */

insert  into `wr_merchant`(`id`,`merchant_name`,`introduce`,`role`,`expire`,`shop_nums`,`qr_code_waiter`,`logo`,`public_id`,`qr_code_member`,`status`,`created_at`,`updated_at`) values (51,'予约造型','予约造型打造完美造型',16,1557244800,5,NULL,'https://image.weerun.com/wr2/2017-09-1181090248e2fadbe155216ea63020b9b9.png',11,NULL,1,1505094761,1505195715),(57,'永琪','顾客第一',16,1568217600,1,NULL,'https://image.weerun.com/wr2/2017-09-121eaa0a2781c38f00d8ba800b30416a40.jpg',11,NULL,1,1505211489,1506563062),(58,'HYT','美容美发',16,1568476800,1,NULL,'https://image.weerun.com/wr2/2017-09-15e406ab842f30f74876c2a9b2db73e9fa.jpg',11,NULL,1,1505443323,1505443544),(60,'爱丽真','爱丽真提供优质理发服务',16,1568736000,1,NULL,'https://image.weerun.com/wr2/2017-09-18fa335652ba519d34133a6afce9a4eb5a.jpg',13,NULL,1,1505703691,1505714108),(65,'星客多','新店开张尽情期待',16,1568822400,3,NULL,'https://image.weerun.com/wr2/2017-09-193155612678315a56e661cbcf29ef597d.jpg',13,NULL,1,1505785423,1505815519),(69,'阿钟','www122121',16,1568822400,2,NULL,'https://image.weerun.com/wr2/2017-09-19eb7652afc9f6f211b6f111b4b0929a4c.jpg',11,NULL,1,1505787159,1505787175),(70,'亦小木','少时诵诗书所所所所所所所所所',16,1568822400,2,NULL,'https://image.weerun.com/wr2/2017-08-08b23fa5be05099b5d1146a25580940486.png',13,NULL,1,1505815277,1505873592),(71,'美亚','新店开张敬请期待',16,1568822400,1,NULL,'https://image.weerun.com/wr2/2017-09-19d191846d630278e8e0c0fee89739054e.jpg',13,NULL,1,1505818954,1505818999),(72,'一棵树','新店开张敬请期待',16,1568822400,2,NULL,'https://image.weerun.com/wr2/2017-09-19170d5a68f5c7b6a2ff7d056049527496.jpg',13,NULL,1,1505819013,1505819085),(73,'金宇Johnny','新店开张敬请期待',16,1568822400,2,NULL,'https://image.weerun.com/wr2/2017-09-19c4542fa98f93691b62b911d30a8df38a.JPG',13,NULL,1,1505819025,1505819107),(74,'天外窥云','新店开张敬请期待',16,1568822400,2,NULL,'https://image.weerun.com/wr2/2017-09-1963e8aee39139914efdbd8a88f85bfdf9.jpg',13,NULL,1,1505819324,1505819376),(75,'大桶大','新店开张敬请期待',16,1568822400,1,NULL,'https://image.weerun.com/wr2/2017-09-19c8531ca777cd76f134eaba5b24468498.PNG',13,NULL,1,1505819619,1505819651),(76,'低调美发工作室','低调美发工作室',16,1568995200,1,NULL,'https://image.weerun.com/wr2/2017-09-21d6655cbb3cb099b1525aee89d3958d40.JPG',13,NULL,1,1505959385,1505959427),(77,'乔韵国际','乔韵国际打造完美造型',16,1563379200,1,NULL,'https://image.weerun.com/wr2/2017-09-21ec9b1c8b066b6173076232c584fb1d69.jpg',13,NULL,1,1505963448,1505963448),(78,'style1030','style1030打造完美造型',16,1594828800,2,NULL,'https://image.weerun.com/wr2/2017-09-218f4bae56d4def09ffdfa6d0c01bdad2b.jpg',13,NULL,1,1505963509,1505963509),(79,'蕾娜发型沙龙','蕾娜发型沙龙打造完美造型',16,1574352000,1,NULL,'https://image.weerun.com/wr2/2017-09-21738325ea325821940087295e0bafa697.png',14,NULL,1,1505963565,1505968696),(80,'艾利','艾利打造完美造型',16,1560355200,1,NULL,'https://image.weerun.com/wr2/2017-09-210ad560c25ed96d410509e136f2ba263d.jpg',13,NULL,1,1505963606,1505963681),(81,'请预约','摸摸摸摸摸摸莫没定人睡觉觉去深圳',16,1569340800,1,NULL,'https://image.weerun.com/wr2/2017-09-257f0ef27408f2117108f61acc7c0391da.jpg',11,NULL,1,1506310115,1506310198),(82,'施华蔻','美业信息化',16,1569340800,50,NULL,'https://image.weerun.com/wr2/2017-09-25cacd563b2e40299058e45ff2decdc4fc.JPG',13,NULL,1,1506335256,1506335305);

/*Table structure for table `wr_merchant_address` */

DROP TABLE IF EXISTS `wr_merchant_address`;

CREATE TABLE `wr_merchant_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` int(10) unsigned NOT NULL COMMENT '商户id',
  `name` varchar(100) DEFAULT NULL COMMENT '姓名',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `tel` varchar(255) DEFAULT NULL COMMENT '联系电话',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注信息',
  `is_send` tinyint(5) DEFAULT '1' COMMENT '是否已经寄送 1：未寄送 2：已寄送',
  `apply_num` tinyint(5) DEFAULT '0' COMMENT '申请次数，最多3次，默认0次',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `merchant_id` (`merchant_id`),
  CONSTRAINT `wr_merchant_address_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `wr_merchant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `wr_merchant_address` */

insert  into `wr_merchant_address`(`id`,`merchant_id`,`name`,`address`,`tel`,`remark`,`is_send`,`apply_num`,`created_at`,`updated_at`,`deleted_at`) values (3,81,'栾光辉','桂平路481号16号楼601','18817555623',NULL,2,3,1506476571,1506563450,NULL),(4,69,'钟超','上海市徐汇区桂平路481号16号楼610室','15921021906','备注',2,1,1506478438,1506478599,NULL),(6,51,'丛','徐汇区公园管理所','18817320310','解决',2,1,1506566817,1506566852,NULL);

/*Table structure for table `wr_merchant_admin` */

DROP TABLE IF EXISTS `wr_merchant_admin`;

CREATE TABLE `wr_merchant_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `merchant_id` int(10) unsigned NOT NULL COMMENT '商户号（对应商户表的id）',
  `admin_tel` varchar(100) DEFAULT NULL COMMENT '商户登录手机号',
  `admin_password` varchar(100) DEFAULT NULL COMMENT '商户密码',
  `nickname` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL COMMENT '头像',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `merchant_id` (`merchant_id`),
  CONSTRAINT `wr_merchant_admin_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `wr_merchant` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COMMENT='商户管理员表';

/*Data for the table `wr_merchant_admin` */

insert  into `wr_merchant_admin`(`id`,`merchant_id`,`admin_tel`,`admin_password`,`nickname`,`img`,`created_at`,`updated_at`,`deleted_at`) values (26,51,'18817320311','$2y$10$BC1Q1B/Xgxr3An0FX7VNU.codbY.kIexGy8mAQSU/w.xT9sxm/AmW','贺兰丛丛','https://image.weerun.com/wr2/2017-09-11623090b2a8328a57b3094b08424495b4.jpg',1505094807,1505209675,NULL),(27,51,'18817555624','$2y$10$ILv5OM/LAQ7qOQ0yn.LLfuji7SIKiwcTpm7LYdhQac33k08Snu2xS','木亦','https://image.weerun.com/wr2/2017-09-1111e8c59d81b45e500f40ca4a48fe64ae.png',1505095098,1505815199,NULL),(32,57,'18817320310','$2y$10$gnJg5IfpusMX2Pol8pms6eRyS7jcQiTRV0ymQNffGUWXvKCJIfk1S','贺兰丛丛','https://image.weerun.com/wr2/2017-09-126ed2f1e3dc0d0f67cd7b6d21864c0c17.jpg',1505211489,1506562843,NULL),(36,60,'18817320314','$2y$10$rGkj0qaKU.GEPznHjpw75eLYAkUico9qT2YXtyd4wNSUnVAQCJHtu','贺兰丛丛','https://image.weerun.com/wr2/2017-09-180035ffdc206e7fdaf26a702390007b92.jpg',1505703691,1505785994,NULL),(41,65,'13162733315','$2y$10$w508rck6adQzwimI9zBysOHp9VtNBFz21EVd5YTAueEIaB5NAqeaq','星客多','https://image.weerun.com/wr2/2017-09-1924b001ddd05c176d20398696d04779bf.jpg',1505785423,1505815282,NULL),(45,69,'15921021906','$2y$10$tezzBbxhEDOvxRf1XyTaze3.T3Je1VSr9l7RVg0g7Q.Njmy4ueigm','mome','https://image.weerun.com/wr2/2017-09-20f78bb03ef99e762db36b7720cb5d722d.jpg',1505787159,1506303503,NULL),(46,70,'18817555625','$2y$10$VfL7y/10NNm4G45PcEx63.dwFmXRMN5tnhAE1ie2G/u.2co/fqP/W','亦小木','https://image.weerun.com/wr2/2017-08-08b23fa5be05099b5d1146a25580940486.png',1505815277,1506303512,NULL),(47,71,'18621730000','$2y$10$OQcoQDoIoiTUCG5JOnTAse/4RJ25KQ7RCuxbANkA.O1yJJoV099oi',NULL,NULL,1505818954,1505818954,NULL),(50,74,'18501755009','$2y$10$UkdDgSjAhFSNB3Vkk6wKLuqzQ8iaf7pNwX3NgEDeikvZ8mmyzGe7S','Dragon','https://image.weerun.com/wr2/2017-09-192ccf95747e006ff9d99132f7818bdfe4.jpg',1505819324,1505819774,NULL),(52,76,'17602570422','$2y$10$0LPD9rGJzkpk8IqCcK55p.n0W.gdJWqIpQIQjsDjQPCHmIfIMghOO','小伍','https://image.weerun.com/wr2/2017-09-2131b95a989d27595ee237007c36ce8697.JPG',1505959385,1505959578,NULL),(55,81,'18817555623','$2y$10$IcEBrV.wdfUYDnKkCQbKqeq1WdiUVQUkH4BRljt8LrfXHbXX/MbyC',NULL,NULL,1506310115,1506592574,NULL),(57,79,'13918677791','$2y$10$99wizJKN4wV24a9W3XNaL.q11VmKo9SkMf4R7FbZCpPS13Fe69F3G','蕾娜发型沙龙',NULL,1506334879,1506334879,NULL),(58,82,'18621668709','$2y$10$HAEC8JwiqJaFt.maGdGTguiPUUXLifULPtGFebo/nLKnQ..Yu.M8K',NULL,NULL,1506335256,1506335256,NULL);

/*Table structure for table `wr_merchant_menu` */

DROP TABLE IF EXISTS `wr_merchant_menu`;

CREATE TABLE `wr_merchant_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(100) DEFAULT NULL COMMENT '菜单名称',
  `url` varchar(100) DEFAULT NULL COMMENT '链接地址',
  `slug` varchar(255) DEFAULT NULL COMMENT '权限名称',
  `icon` varchar(100) DEFAULT NULL COMMENT '图标',
  `pid` int(11) DEFAULT NULL COMMENT '父级id',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态\n0：禁用\n1:正常',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `created_at` int(11) DEFAULT NULL COMMENT '发布时间',
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单表';

/*Data for the table `wr_merchant_menu` */

/*Table structure for table `wr_merchant_permission` */

DROP TABLE IF EXISTS `wr_merchant_permission`;

CREATE TABLE `wr_merchant_permission` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) NOT NULL COMMENT '权限名称',
  `display_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='权限表';

/*Data for the table `wr_merchant_permission` */

insert  into `wr_merchant_permission`(`id`,`name`,`display_name`,`description`,`created_at`,`updated_at`) values (8,'appoint','预约统计','预约统计',1505094650,1505094650);

/*Table structure for table `wr_merchant_role` */

DROP TABLE IF EXISTS `wr_merchant_role`;

CREATE TABLE `wr_merchant_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='角色表';

/*Data for the table `wr_merchant_role` */

insert  into `wr_merchant_role`(`id`,`name`,`display_name`,`description`,`created_at`,`updated_at`) values (16,'(基础功能)','基础功能','基础功能',1505094694,1505699471);

/*Table structure for table `wr_merchant_role_permission` */

DROP TABLE IF EXISTS `wr_merchant_role_permission`;

CREATE TABLE `wr_merchant_role_permission` (
  `role_id` int(11) unsigned NOT NULL COMMENT '角色id',
  `permission_id` int(11) unsigned NOT NULL COMMENT '权限id',
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `wr_merchant_role_permission_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `wr_merchant_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `wr_merchant_role_permission_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `wr_merchant_permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限表';

/*Data for the table `wr_merchant_role_permission` */

insert  into `wr_merchant_role_permission`(`role_id`,`permission_id`) values (16,8);

/*Table structure for table `wr_messages` */

DROP TABLE IF EXISTS `wr_messages`;

CREATE TABLE `wr_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `content` varchar(500) DEFAULT NULL COMMENT '内容',
  `type` int(11) DEFAULT NULL COMMENT '消息来源\n1：来源于平台\n2：来源于商户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='消息';

/*Data for the table `wr_messages` */

/*Table structure for table `wr_public` */

DROP TABLE IF EXISTS `wr_public`;

CREATE TABLE `wr_public` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `public_name` varchar(50) DEFAULT NULL COMMENT '公众号名称\n',
  `token` varchar(100) DEFAULT NULL COMMENT '公众号原始id',
  `wechat` varchar(100) DEFAULT NULL COMMENT '微信号',
  `appid` varchar(50) DEFAULT NULL COMMENT 'appid',
  `secret` varchar(50) DEFAULT NULL COMMENT 'secret',
  `encodingaeskey` varchar(255) DEFAULT NULL COMMENT 'encodingaeskey',
  `is_bind` tinyint(4) DEFAULT '1' COMMENT '是否绑定开放平台（0 未绑定，1绑定）',
  `authorizer_refresh_token` varchar(100) DEFAULT NULL COMMENT '一键绑定的authorizer_refresh_token',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='公众号列表';

/*Data for the table `wr_public` */

insert  into `wr_public`(`id`,`public_name`,`token`,`wechat`,`appid`,`secret`,`encodingaeskey`,`is_bind`,`authorizer_refresh_token`,`created_at`,`updated_at`) values (11,'约美甲','gh_b34fae488daa','wr_ymj','wx456828ef5e9900e7',NULL,'DfEqNBRvzbg8MJdRQCSGyaMp6iLcGOldKFT0r8I6Tnp',1,'refreshtoken@@@gwu5CYwtV9N7RDbJYibAru001i8p2RNJQ_V--0QMgVk',1505372630,1505372630),(12,'约美发','gh_201953288802','','wxfca48d8e625bf3c2',NULL,'DfEqNBRvzbg8MJdRQCSGyaMp6iLcGOldKFT0r8I6Tnp',0,'refreshtoken@@@BZYwR5Prd-tlcXWDVurJ39TTVfCyRNxfYe37Cb2joZQ',1505372814,1505372814),(13,'爱丽真','gh_ececf74d99d1','weeruncs','wxc3c47e69c7e71c65',NULL,'DfEqNBRvzbg8MJdRQCSGyaMp6iLcGOldKFT0r8I6Tnp',1,'refreshtoken@@@upXqHYkZ8OgPQrZCVNcl7sX-5Kl61sJyjufhQVxwuwg',1505462732,1505462732),(14,'蕾娜发型沙龙','gh_d40fa1f67378','lena_salon','wxe07ccd9b6b7c7626',NULL,'DfEqNBRvzbg8MJdRQCSGyaMp6iLcGOldKFT0r8I6Tnp',1,'refreshtoken@@@e5qwEAQJMHDrWm5Rcn2VxApm0_AZogGT_x1u_gBM9WE',1505965829,1505965829);

/*Table structure for table `wr_shop` */

DROP TABLE IF EXISTS `wr_shop`;

CREATE TABLE `wr_shop` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_name` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `detail_address` varchar(255) DEFAULT NULL COMMENT '具体地址（多少号，多少室）',
  `tel` varchar(30) DEFAULT NULL,
  `open_time` varchar(50) DEFAULT NULL COMMENT '营业时间',
  `longitude` text COMMENT '经度',
  `latitude` text COMMENT '纬度',
  `introduce` text COMMENT '介绍',
  `merchant_id` int(10) unsigned DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL COMMENT '公众号的原始id',
  `img0` varchar(255) DEFAULT NULL,
  `img1` varchar(255) DEFAULT NULL,
  `img2` varchar(255) DEFAULT NULL,
  `img3` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8 COMMENT='门店表';

/*Data for the table `wr_shop` */

insert  into `wr_shop`(`id`,`shop_name`,`address`,`detail_address`,`tel`,`open_time`,`longitude`,`latitude`,`introduce`,`merchant_id`,`token`,`img0`,`img1`,`img2`,`img3`,`created_at`,`updated_at`,`deleted_at`) values (132,'予约造型设计','上海市徐汇区桂平路481号16号楼',NULL,'18817555623','09:30 - 23:00','121.409063','31.175004','欢迎来到予约造型！！',51,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-118f655def0c5d73e9cfdf69a537825a2c.png','https://image.weerun.com/wr2/2017-09-1120c86b7dc0b0e41883818c9f71e9771c.png','https://image.weerun.com/wr2/2017-09-11185ca2bc1aa51a2f419c4d339408bb68.png','https://image.weerun.com/wr2/2017-09-114ee8afe595d086dfbde40a223a625af4.jpeg',1505095392,1505810195,NULL),(136,'121121221','上海市徐汇区徐汇区',NULL,'2122121','06:10 - 23:59','121.443396','31.194557','2112121221',51,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-131055b56431803834c012cc52f63353c9.jpg','','https://image.weerun.com/wr2/2017-09-1336d3a35f986645f83a9fab8843ca9e76.jpg','',1505269573,1505273322,1505273322),(137,'约美发造型','上海市徐汇区桂平路481号20号',NULL,'15921021906','09:30 - 22:30','121.408957','31.174004','欢迎来到！！！',55,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-1368f8e4aead9aad92e0774f9ec6aff79b.jpg','https://image.weerun.com/wr2/2017-09-134b0dbde9e5400b1f53809a8fa3274d90.jpg','https://image.weerun.com/wr2/2017-09-13a56def5046a8688020ea5da65c524a6f.jpg','https://image.weerun.com/wr2/2017-09-13e01f418f304ecb7aa5f812d1c892aa67.jpg',1505269976,1505285419,NULL),(138,'我去前往前往我去','上海市徐汇区徐汇区',NULL,'我去我去我去','06:10 - 23:59','121.443396','31.194557','前往前往我去',51,'gh_b34fae488daa','','https://image.weerun.com/wr2/2017-09-1329b1c46bf422ca07f49e4005424c31c0.jpg','','',1505270201,1505270214,1505270214),(139,'乔月国际','上海市徐汇区上海汇付科技有限公司',NULL,'021-40099876','09:30 - 22:30','121.409063','31.175004','乔月国际',51,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-13cf7e91c10fcc7159346b6bc0f57ea215.jpg','https://image.weerun.com/wr2/2017-09-13354a9b96756a4e6d4dde0394b7647708.jpg','','',1505291352,1505725212,NULL),(141,'永琪一店','上海市闵行区秀枫翠谷公寓',NULL,'021-198990989','09:10 - 22:30','121.371099','31.16459','永琪一店',57,'gh_201953288802','https://image.weerun.com/wr2/2017-09-1463c190f95a80ab2cb272638d89e7ec80.jpg','https://image.weerun.com/wr2/2017-09-14a9e89251c03196ff6a6f84194c0fd85c.jpg','','',1505376526,1505376526,NULL),(142,'HYT1','上海市徐汇区桂平路481号16号楼',NULL,'021-65656565','06:00 - 21:59','121.409063','31.175004','自建店铺',58,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-159a64182d742289de807378acf37e033a.jpg','','','',1505444000,1505444000,NULL),(143,'阿钟哈哈','上海市闸北区上海火车站-地铁站',NULL,'15921021906','08:10 - 23:59','121.46396','31.255155','哈哈哈哈哈哈哈',59,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-18237c717652fd3c692d91245cd55349d2.JPG','','','',1505701836,1505701836,NULL),(144,'阿钟222','上海市徐汇区上海市徐汇区中心医院',NULL,'15921021906','06:10 - 23:59','121.464941','31.223328','哈哈哈哈哈哈哈',59,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-183165cebb60a6d83d9adb4b05db0eb6ab.JPG','https://image.weerun.com/wr2/2017-09-18c43cc4c8078b2ba429e008734c5b51d4.JPG','','',1505701883,1505701906,1505701906),(145,'爱丽真一号店','上海市徐汇区桂平路481号16号楼',NULL,'021-90988776','09:30 - 22:02','121.409063','31.175004','爱丽真一号店上线，欢饮新老客户',60,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-1802e612351d228b8fbfa79a2e0c247693.jpg','https://image.weerun.com/wr2/2017-09-18ac80d3767d3eeb58963b333058d40de7.jpg','','',1505704743,1505704743,NULL),(146,'阿钟理发店一号','上海市徐汇区上海市徐汇区中心医院',NULL,'15921021906','09:10 - 23:59','121.464941','31.223328','阿钟1661',61,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-183d2b5a0c7f4ea208a94970c617cb45a1.JPG','https://image.weerun.com/wr2/2017-09-18ecd59ce7403200443612622d86074bf6.JPG','','',1505714266,1505714266,NULL),(147,'梅赛德斯','上海市闸北区上海火车站-地铁站',NULL,'莫咯','08:20 - 23:00','121.46396','31.255155','卡路里浏览器',51,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-1803a3bd8395b56a4b58d4550caccbf141.jpg','','','',1505724678,1505724678,NULL),(148,'看看咯M8哦了','上海市徐汇区上海南站',NULL,'咯莫摸JJ普及','06:10 - 23:59','121.435865','31.159439','龙母庙',51,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-18d2875c8f499024e2d3c2eb1ce212cc3e.jpg','','','',1505724723,1505724737,NULL),(149,'咯娄','上海市闸北区上海静安铂尔曼酒店',NULL,'JOJONONO族','06:10 - 23:59','121.463137','31.252675','透漏摸摸',51,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-185b1f97da8a80718888808dd236a81311.jpg','','','',1505724839,1505724839,NULL),(150,'XINGKEDUO（绿地缤纷店）','上海市徐汇区城市轮滑(绿地缤纷城店)',NULL,'13162733315','09:00 - 23:09','121.464169','31.190762','上海站总店！',65,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-19271d0d00b8c75f52901b4e2cc0848ae6.jpg','https://image.weerun.com/wr2/2017-09-199191daace444bf7394088e7e476df3d6.jpg','https://image.weerun.com/wr2/2017-09-19b34d980015f1275e7183c86b19b3cd06.jpg','https://image.weerun.com/wr2/2017-09-19598f3bd501013fd8bbf8f1f6913b51ea.jpg',1505786657,1505819430,NULL),(151,'测试4-2','5694959986',NULL,'131627335你莫','06:10 - 23:59','121.46396','31.255155','6664988',65,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-19b7c24e433256b68260e1bbc8755db7f2.jpg','','','',1505787065,1505800253,1505800253),(152,'阿钟','上海市上海市','qwqwwq','21212121','10:13 - 11:13','121.480539','31.235929','21121212',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-196fd0283be1e556931358954cea3c4e9b.jpg','','','',1505787247,1506047279,1506047279),(153,'XINGEDUO（灵岩南路店）','浦东新区灵岩南路380弄48号',NULL,'13975183126','06:10 - 23:59','121.500878','31.158808','灵岩南路分店',65,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-19c00ba76015e7661f13db7ec8888ec78b.jpg','https://image.weerun.com/wr2/2017-09-197621be12251328a559e6f9c03c408512.jpg','https://image.weerun.com/wr2/2017-09-195d6ab12ca85e9d3ee6fcc06648b5095b.jpg','https://image.weerun.com/wr2/2017-09-191d858df2077596cb6f272abe43f14c5d.jpg',1505804991,1505805132,NULL),(154,'爱预约','上海市徐汇区漕宝路-地铁站','69号602','18817555623','06:10 - 23:59','121.440961','31.174604','欢迎来到爱预约',70,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-19905b010d076960ec9c736bded53c8ca5.jpg','','','',1505815499,1505893462,NULL),(155,'一棵树','上海市徐汇区吴中路500弄9号',NULL,'02136528596','09:00 - 21:00','121.430068','31.196673','一棵树发型屋',72,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-19012fa83ac402528657003ee1f97bdadb.jpg','','','',1505819429,1505819458,NULL),(156,'美亚','上海市闵行区上海虹桥站',NULL,'0216000000','06:10 - 23:59','121.326997','31.200547','成就你的美',71,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-19443e02266071057164292931cd417998.JPG','','','',1505819467,1505819467,NULL),(157,'天字一号','上海市黄浦区外滩18号',NULL,'02188888888','06:10 - 23:59','121.49618','31.244099','谈笑有鸿儒，往来无白丁',74,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-19b8349864533f1d6f081b911ecda395b1.jpg','https://image.weerun.com/wr2/2017-09-1972655ba568ed7d5434a9baecfffddf9b.jpg','https://image.weerun.com/wr2/2017-09-190213596a0b23759e635b86b54ac51bbc.jpg','https://image.weerun.com/wr2/2017-09-19ce194468b3db277fd249aa0077d0d207.jpg',1505819724,1505819734,NULL),(158,'侯师傅分店一号','上海市徐汇区桂中园(桂平路)',NULL,'02160548000','06:10 - 23:59','121.409064','31.174439','侯师傅',75,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-1943ce86a3b740814bae2488fa201a258d.PNG','','','',1505820175,1505820175,NULL),(159,'二棵树','上海市徐汇区桂平路481号15号楼',NULL,'02112345678','06:10 - 23:59','121.408937','31.175274','二棵树',72,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-19ddccb8a807c226dfa415b2bd5a7018bd.jpg','','','',1505821141,1505821587,1505821587),(160,'金宇美容美发（桂平路店）','上海市徐汇区桂平路481号16号楼',NULL,'02160548000','10:00 - 22:00','121.409063','31.175004','微信公众号网上预约美容美发！',73,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-1984c1a9606354b49da9a9b5c94507d3d2.JPG','','','',1505821552,1505821552,NULL),(161,'二棵树','上海市徐汇区桂平路481号16号楼',NULL,'02161350001','06:10 - 23:59','121.409063','31.175004','二棵树',72,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-19f939016d12a0b23e5be88b3d8b2d7db5.jpg','','','',1505821744,1505821744,NULL),(162,'地字二号店','上海市长宁区天山路202弄12号',NULL,'02166666666','06:10 - 23:59','121.388967','31.221915','悲哉六识 沉沦八苦 无有大圣 谁拯慧桥',74,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-192aaa90cad6dcd83c54c3fdd54cfb3a81.jpg','https://image.weerun.com/wr2/2017-09-1968b5041ba115639b62ebdfdd811d97a8.jpg','','',1505822259,1505822259,NULL),(163,'低调美发工作室','上海市徐汇区石龙路-地铁站','石龙路128号','17602570422','08:00 - 22:00','121.44963','31.164304','低调美发室欢迎您的光临！',76,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-2198ad7406cefe52ba3dbd32f3a8bad891.JPG','','','',1505960505,1505960505,NULL),(165,'阿钟','上海市黄浦区上海人民广场','徐汇区481号16号楼610','15921021906','06:10 - 23:59','121.481139','31.235301','哈哈哈',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-211f34f9695c9198d8b5119e7e569e6fb4.PNG','','','',1505981151,1505981198,1505981198),(167,'阿钟理发店','上海市徐汇区上海市徐汇区中心医院','481号','122112','06:10 - 23:59','121.464941','31.223328','阿萨斯所所所所所所所所所所所所所',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-226037d53dfa8b299b33101a8eb0d6aeb7.jpg','','','',1506051113,1506062181,1506062181),(168,'阿钟理发店2','上海市徐汇区桂平路-道路','481号16号楼610','15921021906','06:10 - 23:59','121.40738','31.183992','阿钟测试点',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-22945aef45711c5972274172ac1bdbf17a.jpg','','','',1506059161,1506062175,1506062175),(169,'阿钟店','上海市徐汇区上海市徐汇区中心医院','481','122133213','06:10 - 23:59','121.464941','31.223328','211121212',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-22e3452ba99037b831eadf9de8c6819d6a.jpg','','','',1506062373,1506063253,1506063253),(170,'阿钟店','上海市闸北区上海火车站-地铁站','481','123454664','06:10 - 23:59','121.46396','31.255155','1点半到晚上',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-224433cb28c5020dde986e51bd36c43c75.JPG','','','',1506063869,1506302471,1506302471),(171,'测试2','上海市徐汇区上海市徐汇区中心医院','徐汇区','12122121','06:10 - 23:59','121.464941','31.223328','撒阿萨飒飒',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-254d0c124681329693896eeb0f0f897e02.jpg','','','',1506301715,1506302453,1506302453),(172,'测试1','上海市徐汇区徐汇区牙病防治所(肇嘉浜路)','徐汇区','2121212','06:10 - 23:59','121.45787','31.205766','前往我去群无',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-25c07fb01f8e71c3d20e74f4b2165c098b.jpg','','','',1506302495,1506302888,1506302888),(173,'徐汇区1店','上海市徐汇区上海市徐汇区房地产交易中心','信息','12212112','06:10 - 23:59','121.448255','31.146124','飒飒',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-250eb9825d0c14f24c1e92118fc30c5ef3.jpg','','','',1506302918,1506303558,1506303558),(174,'1122112','上海市徐汇区上海市徐汇区中心医院','','1221','06:10 - 23:59','121.464941','31.223328','122121',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-25df607a78e18a2cc89dde4bf5c257ad1d.jpg','','','',1506302934,1506303562,1506303562),(175,'阿钟理发店','上海市徐汇区桂平路481号16号楼','wwww','15921021906','06:10 - 23:59','121.409063','31.175004','啊哈',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-251436a6c8f294cfbaedefaee404b3fdb1.jpg','','','',1506303608,1506326121,1506326121),(176,'u苏睡觉觉','上海市虹口区搜索','602室','18817555623','06:10 - 23:59','121.489433','31.250788','米西米西慢慢想',81,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-2524fb92fd3e7368a11e35dd5a69b59430.jpg','','','',1506310264,1506326821,NULL),(179,'阿钟112','上海市徐汇区徐汇区','徐汇区桂平481号','121221','06:10 - 23:59','121.443396','31.194557','撒飒飒',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-25c47687e66178e6dff7fa74091a50907d.jpg','','','',1506326151,1506326209,1506326209),(180,'阿钟2','上海市闸北区上海火车站-地铁站','火车站','2222','06:10 - 23:59','121.46396','31.255155','我去我去群无',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-254bc7d2cc22f1408602de10f6b1a26b03.jpg','','','',1506326174,1506326206,1506326206),(181,'徐汇区','上海市闸北区上海站','22火车站','15921021976','06:10 - 23:59','121.462056','31.255923','我QQ无',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-2503cc9e3f78280b4a083d9868a0a87ee9.jpg','','','',1506326274,1506326515,1506326515),(182,'阿钟11','上海市徐汇区徐汇区','徐汇区桂平路485551','5184884','06:10 - 23:59','121.443396','31.194557','哈哈',69,'gh_b34fae488daa','https://image.weerun.com/wr2/2017-09-25f79eba18e6096a5ecd3a9f4493459dfd.png','','','',1506326549,1506326655,NULL),(185,'施华蔻美发(桂平路店)','上海市徐汇区桂平路481号16号楼','上海市徐汇区桂平路481号16号楼610室','18621668709','10:00 - 22:00','121.409063','31.175004','美出新高度',82,'gh_ececf74d99d1','https://image.weerun.com/wr2/2017-09-25af52a957e749fb537088b92f7be53df4.JPG','','','',1506335505,1506335505,NULL),(186,'1','上海市虹口区1933老场坊','徐汇区桂平路','021909988','06:10 - 23:59','121.499089','31.260242','111',70,'gh_ececf74d99d1','','https://image.weerun.com/wr2/2017-09-264d19178a14bc2c84fa2b7a37704ea66c.png','','',1506414255,1506418679,NULL);

/*Table structure for table `wr_shop_waiter` */

DROP TABLE IF EXISTS `wr_shop_waiter`;

CREATE TABLE `wr_shop_waiter` (
  `shop_id` int(10) unsigned NOT NULL COMMENT '门店id',
  `waiter_id` int(10) unsigned NOT NULL COMMENT '服务师id',
  `merchant_id` int(11) DEFAULT NULL COMMENT '商户id',
  KEY `shop_id` (`shop_id`),
  KEY `waiter_id` (`waiter_id`),
  CONSTRAINT `wr_shop_waiter_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `wr_shop` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `wr_shop_waiter_ibfk_2` FOREIGN KEY (`waiter_id`) REFERENCES `wr_waiter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门店服务师关系表';

/*Data for the table `wr_shop_waiter` */

insert  into `wr_shop_waiter`(`shop_id`,`waiter_id`,`merchant_id`) values (132,179,51),(132,181,51),(142,182,58),(145,185,60),(146,186,61),(146,187,61),(145,188,60),(145,189,60),(150,190,65),(151,190,65),(145,194,60),(132,171,51),(139,171,51),(145,193,60),(152,192,69),(132,175,51),(153,195,65),(150,195,65),(154,196,70),(154,197,70),(156,198,71),(156,199,71),(158,201,75),(155,202,72),(150,191,65),(153,191,65),(157,203,74),(157,204,74),(155,205,72),(161,205,72),(156,206,71),(160,200,73),(156,207,71),(152,208,69),(163,210,76),(167,212,69),(170,212,69),(185,213,82),(150,209,65),(153,209,65);

/*Table structure for table `wr_template` */

DROP TABLE IF EXISTS `wr_template`;

CREATE TABLE `wr_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `type` char(50) DEFAULT NULL COMMENT '模板消息类型',
  `template_id` varchar(255) DEFAULT NULL COMMENT '模板消息id',
  `type_name` varchar(100) DEFAULT NULL COMMENT '模板消息名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='公众号模板消息';

/*Data for the table `wr_template` */

/*Table structure for table `wr_time_relation` */

DROP TABLE IF EXISTS `wr_time_relation`;

CREATE TABLE `wr_time_relation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `id_sort` int(10) DEFAULT NULL COMMENT '序号',
  `time_str` varchar(255) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='时间（小时）映射表';

/*Data for the table `wr_time_relation` */

insert  into `wr_time_relation`(`id`,`id_sort`,`time_str`) values (1,1,'00:00'),(2,2,'00:30'),(3,3,'01:00'),(4,4,'01:30'),(5,5,'02:00'),(6,6,'02:30'),(7,7,'03:00'),(8,8,'03:30'),(9,9,'04:00'),(10,10,'04:30'),(11,11,'05:00'),(12,12,'05:30'),(13,13,'06:00'),(14,14,'06:30'),(15,15,'07:00'),(16,16,'07:30'),(17,17,'08:00'),(18,18,'08:30'),(19,19,'09:00'),(20,20,'09:30'),(21,21,'10:00'),(22,22,'10:30'),(23,23,'11:00'),(24,24,'11:30'),(25,25,'12:00'),(26,26,'12:30'),(27,27,'13:00'),(28,28,'13:30'),(29,29,'14:00'),(30,30,'14:30'),(31,31,'15:00'),(32,32,'15:30'),(33,33,'16:00'),(34,34,'16:30'),(35,35,'17:00'),(36,36,'17:30'),(37,37,'18:00'),(38,38,'18:30'),(39,39,'19:00'),(40,40,'19:30'),(41,41,'20:00'),(42,42,'20:30'),(43,43,'21:00'),(44,44,'21:30'),(45,45,'22:00'),(46,46,'22:30'),(47,47,'23:00'),(48,48,'23:30');

/*Table structure for table `wr_waiter` */

DROP TABLE IF EXISTS `wr_waiter`;

CREATE TABLE `wr_waiter` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `nickname` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '昵称',
  `tel` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '手机号',
  `age` int(10) DEFAULT NULL COMMENT '年龄',
  `brief` text CHARACTER SET utf8 COMMENT '简介',
  `level` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '职位',
  `img` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '头像',
  `open_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '微信open_id',
  `sex` tinyint(2) DEFAULT '1' COMMENT '性别0:保密 1:男 2：女',
  `work_length` int(10) DEFAULT '1' COMMENT '从业年数',
  `status` int(10) DEFAULT '1' COMMENT '状态',
  `merchant_id` int(11) DEFAULT NULL COMMENT '商户id',
  `open_appoint` tinyint(2) DEFAULT '0' COMMENT '0:可以预约 1:不可预约',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=214 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='服务师表';

/*Data for the table `wr_waiter` */

insert  into `wr_waiter`(`id`,`nickname`,`tel`,`age`,`brief`,`level`,`img`,`open_id`,`sex`,`work_length`,`status`,`merchant_id`,`open_appoint`,`created_at`,`updated_at`,`deleted_at`) values (171,'贺兰丛丛1','18817320310',NULL,'人帅','44','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKPkia3rxjuBobr6G2dp9VJWonyZc5Aul90UoBXSibDZ4CHatQzdf0n4XsTrb0hwovqQpS9uVs2egeg/0','o9KRbwrHxbx-HENgY2zx-Zhki_64',1,1,1,51,0,1505097037,1505807682,NULL),(175,'木1亦','18817555623',NULL,'欢迎预约！','44','http://wx.qlogo.cn/mmopen/vi_32/gPNZLX3SMGI0ZxiakzMBujmZ7Xz04fGt3LHbT9ricETPibrnUazaWzZBCZ3ibVvdoLibKLfKmnOPlr39nYkcsVq1POg/0','o9KRbwu81cSVzg9g7nKpi0hqveLI',1,3,1,51,0,1505100278,1505813081,NULL),(179,'六儿','13162733315',NULL,'啦啦啦啦啦了','44','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJV7jhkceGC457mJgs2lic77BF9LKWeYicmSOEy4ehDicCGicgVPicKcgedUvJH6DHurnEwOPn0pGhLflg/0','o9KRbwqDFkdJEcZgn4edsKHpvMKA',1,1,1,51,1,1505180386,1505180840,NULL),(181,'阿钟喵','15921021906',NULL,'哈哈还差','44','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIyuwbWibwljAWicUJ5HcCib8icrUKOtIBl1XgJ7GPiahyDIgOKDYiapHhFJ3nGVics7Aytl2eWNsQ44PNmQ/0','o9KRbwruUVLveGr2Y0lauhNWEy-A',1,1,1,51,0,1505181244,1505697551,1505697551),(182,'Fget','13816636800',NULL,'啦啦啦啦啦啦啦','51','http://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83erNponYicKryNKdyZh4wxUtolEGsiaPnzXvQiblFdW6a35uTAouvcYI9B8QeAicAyEUd79Cw1PNXT3XnQ/0','o9KRbwoTOqvHGG0lb1YRmMzRc99A',1,3,1,58,0,1505445033,1505445033,NULL),(185,'贺兰丛丛','18817320310',NULL,'嘻嘻','54','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTI5bVeCHmDiadUW0O1wkKVZcYDSqL7D5OpKVndib5bvjP7VVE6ENRHjNia8EicZEqrxASQ8wJcY7AbVaQ/0','oDrxZ0vN4OcZhly4cAxC3UWYsSIo',1,2,1,60,0,1505713274,1505801064,1505801064),(186,'阿钟喵','15921021906',NULL,'阿钟理发师','58','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIyuwbWibwljAWicUJ5HcCib8icrUKOtIBl1XgJ7GPiahyDIgOKDYiapHhFJ3nGVics7Aytl2eWNsQ44PNmQ/0','o9KRbwruUVLveGr2Y0lauhNWEy-A',1,3,1,61,0,1505714536,1505716127,1505716127),(187,'阿钟喵','15921021906',NULL,'哈哈还','58','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIyuwbWibwljAWicUJ5HcCib8icrUKOtIBl1XgJ7GPiahyDIgOKDYiapHhFJ3nGVics7Aytl2eWNsQ44PNmQ/0','o9KRbwruUVLveGr2Y0lauhNWEy-A',1,2,1,61,0,1505716152,1505716152,NULL),(188,'木亦','18817555623',NULL,'欢迎预约！给你放心的体验！','54','http://wx.qlogo.cn/mmopen/vi_32/DVhYQdkcRfj9blDBUKnu9nj8Gcic2pFeGQITfdKxEedoyF3NWvNDOZlAVBriaIoY4PpQlRDcicwD1oEWVwY6ef77A/0','oDrxZ0p3lLuqAThT6rH8ptNTI5l8',1,4,1,60,0,1505717209,1505718690,1505718690),(189,'木亦','18817555623',NULL,'欢迎预约！','54','http://wx.qlogo.cn/mmopen/vi_32/DVhYQdkcRfj9blDBUKnu9nj8Gcic2pFeGQITfdKxEedoyF3NWvNDOZlAVBriaIoY4PpQlRDcicwD1oEWVwY6ef77A/0','oDrxZ0p3lLuqAThT6rH8ptNTI5l8',1,4,1,60,0,1505720689,1505720689,NULL),(190,'六儿','13162733315',NULL,'呢嗯嗯的呃呃呃得得得','62','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJx33zpGe1Y4yVicZWoK9dxUoiadqhveBJcRibIicIecoFGwYBMEruv9YXbmHWXhX2nuriaBORz0jRCW9A/0','oDrxZ0mA3A1Mtm-1fXGp6-91eCPc',1,4,1,65,0,1505788486,1505788744,1505788744),(191,'六儿','13162733315',NULL,'这家伙很傲娇，什么都没写(´▽｀)ノ♪','64','https://image.weerun.com/wr2/2017-09-1916a7f128e7991d6ec685310ced87c1d9.jpg','oDrxZ0mA3A1Mtm-1fXGp6-91eCPc',1,7,1,65,0,1505788791,1505821936,NULL),(192,'阿钟喵','15921021906',NULL,'哈哈哈哈哈哈哈','67','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIyuwbWibwljAWicUJ5HcCib8icrUKOtIBl1XgJ7GPiahyDIgOKDYiapHhFJ3nGVics7Aytl2eWNsQ44PNmQ/0','o9KRbwruUVLveGr2Y0lauhNWEy-A',1,5,1,69,0,1505801049,1505814590,1505814590),(193,'贺兰丛丛2','18817320310',NULL,'haha','54','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTI5bVeCHmDiadUW0O1wkKVZcYDSqL7D5OpKVndib5bvjP7VVE6ENRHjNia8EicZEqrxASQ8wJcY7AbVaQ/0','oDrxZ0vN4OcZhly4cAxC3UWYsSIo',1,3,1,60,0,1505801169,1505807730,NULL),(194,'123阿钟喵','15921021906',NULL,'哈哈哈','54','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJ5ic36YMKCJa5uiaNG7qv6plFZ89846ew9zGDaiakDQG8bKl4PEyEFy9GXVCxJZmxUtofIuMSMp2bcg/0','oDrxZ0kTW7sr6tTE9cJXObv51M2A',1,2,1,60,0,1505806595,1505806595,NULL),(195,'阿钟喵','15515465725',NULL,'懒','65','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJ5ic36YMKCJa5uiaNG7qv6plFZ89846ew9zGDaiakDQG8bKl4PEyEFy9GXVCxJZmxUtofIuMSMp2bcg/0','oDrxZ0kTW7sr6tTE9cJXObv51M2A',1,0,1,65,0,1505813427,1505815728,1505815728),(196,'木亦','18817555623',NULL,'监控你们','68','http://wx.qlogo.cn/mmopen/vi_32/DVhYQdkcRfj9blDBUKnu9nj8Gcic2pFeGQITfdKxEedoyF3NWvNDOZlAVBriaIoY4PpQlRDcicwD1oEWVwY6ef77A/0','oDrxZ0p3lLuqAThT6rH8ptNTI5l8',1,3,1,70,0,1505815640,1505815640,NULL),(197,'阿钟喵','15921821906',NULL,'哈哈哈','68','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJ5ic36YMKCJa5uiaNG7qv6plFZ89846ew9zGDaiakDQG8bKl4PEyEFy9GXVCxJZmxUtofIuMSMp2bcg/0','oDrxZ0kTW7sr6tTE9cJXObv51M2A',1,0,1,70,0,1505816253,1505816253,NULL),(198,'木亦','18817555623',NULL,'欢迎预约！提供最优质服务！','74','http://wx.qlogo.cn/mmopen/vi_32/DVhYQdkcRfj9blDBUKnu9nj8Gcic2pFeGQITfdKxEedoyF3NWvNDOZlAVBriaIoY4PpQlRDcicwD1oEWVwY6ef77A/0','oDrxZ0p3lLuqAThT6rH8ptNTI5l8',1,4,1,71,0,1505821652,1505821652,NULL),(199,'avel','18621730000',NULL,'我。。。成就你的美','78','http://wx.qlogo.cn/mmopen/vi_32/PiajxSqBRaEL7xWUHxIoPqicpAZhN2yDYAs0mGKmCtEOSUrvNuCVdmTXvkYfMUtFlRysvoOT5obY7ibE7kHsKJCUg/0','oDrxZ0vOldFWoU981Vj2bulBq474',2,1,1,71,0,1505821659,1505821659,NULL),(200,'金宇Johnny','18621668709',NULL,'完美个人形象设计','81','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLSQlpIr5x9oic8DUJwu8R33LjFEzn7gTomwClq0G52GUh5E1clQFRRuW4pjGYrWNzvk7VVtic20Uzg/0','oDrxZ0hOdCUJbPVCaB1vlN1Ppkzs',1,8,1,73,0,1505821721,1505823097,NULL),(201,'大海','13816630675',NULL,'这家伙很傲娇','83','http://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83epe5LxQLyLy0jDDC7otSc99ByZ2Z1CgicAZINJ3lWDoCbmWuSFdTQWUM7ubzLmV4WtiaMmtwWsy0Avg/0','oDrxZ0k00Jr3m7rPx4KqoEz5lGCM',1,5,1,75,0,1505821810,1505821810,NULL),(202,'Fget','13816636800',NULL,'成就我的美！','71','http://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83epquomgicYP4Gpg43UlSZpgb5TyHB2fugzzVNNYdd5ibRMdq42S0ktsvGQbHRFKhCpuiav86bqlE6Irg/0','oDrxZ0nbY7Iz1tpnUSa0LbRyBiiM',1,0,1,72,0,1505821893,1505821893,NULL),(203,'木亦','18817555623',NULL,'欢迎预约！！给你最美好的服务！！','86','http://wx.qlogo.cn/mmopen/vi_32/DVhYQdkcRfj9blDBUKnu9nj8Gcic2pFeGQITfdKxEedoyF3NWvNDOZlAVBriaIoY4PpQlRDcicwD1oEWVwY6ef77A/0','oDrxZ0p3lLuqAThT6rH8ptNTI5l8',1,4,1,74,0,1505822026,1505822026,NULL),(204,'六儿','13162733315',NULL,'我是老司机','84','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJx33zpGe1Y4yVicZWoK9dxUoiadqhveBJcRibIicIecoFGwYBMEruv9YXbmHWXhX2nuriaBORz0jRCW9A/0','oDrxZ0mA3A1Mtm-1fXGp6-91eCPc',1,4,1,74,0,1505822029,1505822029,NULL),(205,'玄天机','18501755009',NULL,'玄之又玄','70','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLrGaYHR6hFdCOsFviaQyia3zQdTq4VSGh8cibCv1ianUgia6AmiaZfKKWQsxRHhCxuVvY1ibKvGw1SNsWFg/0','oDrxZ0jO4nlfyNzbX7DTVAygl6wg',1,30,1,72,0,1505822835,1505822835,NULL),(206,'大海','13816630675',NULL,'这个人很傲娇','77','http://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83epe5LxQLyLy0jDDC7otSc99ByZ2Z1CgicAZINJ3lWDoCbmWuSFdTQWUM7ubzLmV4WtiaMmtwWsy0Avg/0','oDrxZ0k00Jr3m7rPx4KqoEz5lGCM',1,6,1,71,0,1505822923,1505822923,NULL),(207,'Dragonfly','18501755009',NULL,'明月出天山 苍茫云海间 长风几万里 吹度玉门关','73','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLrGaYHR6hFdCOsFviaQyia3zQdTq4VSGh8cibCv1ianUgia6AmiaZfKKWQsxRHhCxuVvY1ibKvGw1SNsWFg/0','oDrxZ0jO4nlfyNzbX7DTVAygl6wg',1,20,1,71,0,1505823105,1505823105,NULL),(208,'阿钟喵','15921821906',NULL,'哈哈','67','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIyuwbWibwljAWicUJ5HcCib8icrUKOtIBl1XgJ7GPiahyDIgOKDYiapHhFJ3nGVics7Aytl2eWNsQ44PNmQ/0','o9KRbwruUVLveGr2Y0lauhNWEy-A',1,0,1,69,0,1505873608,1506047286,1506047286),(209,'1122121阿钟喵','15921021906',NULL,'哈哈哈','64','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJ5ic36YMKCJa5uiaNG7qv6plFZ89846ew9zGDaiakDQG8bKl4PEyEFy9GXVCxJZmxUtofIuMSMp2bcg/0','oDrxZ0kTW7sr6tTE9cJXObv51M2A',1,5,1,65,0,1505873654,1506477371,NULL),(210,'管福康','17602570422',NULL,'五年从业经验','91','http://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83epbKxGqfgdTqTjqicp3lic0ejCZ6zW9VZoeKTicPUK7F1oNP0ZzecUX9c4rW3JOqwVfeIRGnUPYexsFQ/0','oDrxZ0pQ5gapqK0nykoC4RnsBE-s',1,2147483647,1,76,0,1505960581,1505960581,NULL),(212,'阿钟喵','15921021906',NULL,'哈哈哈','93','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIyuwbWibwljAWicUJ5HcCib8icrUKOtIBl1XgJ7GPiahyDIgOKDYiapHhFJ3nGVics7Aytl2eWNsQ44PNmQ/0','o9KRbwruUVLveGr2Y0lauhNWEy-A',1,5,1,69,0,1506051213,1506070395,NULL),(213,'金宇Johnny','18621668709',NULL,'新发型有我定义！','103','http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLSQlpIr5x9oic8DUJwu8R33LjFEzn7gTomwClq0G52GUh5E1clQFRRumxu6UV5GN3EcoaBZDVxRAA/0','oDrxZ0hOdCUJbPVCaB1vlN1Ppkzs',1,10,1,82,0,1506335942,1506335942,NULL);

/*Table structure for table `wr_waiter_album` */

DROP TABLE IF EXISTS `wr_waiter_album`;

CREATE TABLE `wr_waiter_album` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `waiter_id` int(11) unsigned NOT NULL COMMENT '服务师id',
  `name` varchar(50) DEFAULT NULL,
  `introduce` varchar(500) DEFAULT NULL COMMENT '作品介绍',
  `merchant_id` int(11) DEFAULT NULL COMMENT '商户id',
  `shop_id` varchar(20) DEFAULT NULL COMMENT '门店id',
  `img_front` varchar(255) DEFAULT NULL COMMENT '正面',
  `img_left` varchar(255) DEFAULT NULL COMMENT '左侧',
  `img_right` varchar(255) DEFAULT NULL COMMENT '右侧',
  `img_back` varchar(255) DEFAULT NULL COMMENT '背面',
  `created_at` int(11) DEFAULT NULL COMMENT '上传时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '作品修改时间',
  PRIMARY KEY (`id`),
  KEY `waiter_id` (`waiter_id`),
  CONSTRAINT `wr_waiter_album_ibfk_1` FOREIGN KEY (`waiter_id`) REFERENCES `wr_waiter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COMMENT='作品表';

/*Data for the table `wr_waiter_album` */

insert  into `wr_waiter_album`(`id`,`waiter_id`,`name`,`introduce`,`merchant_id`,`shop_id`,`img_front`,`img_left`,`img_right`,`img_back`,`created_at`,`updated_at`) values (50,175,'儿童精剪','儿童精剪',51,'132','https://image.weerun.com/wr2/2017-09-116c6aa4aa2b822791a55d3745a84bb726.jpg','https://image.weerun.com/wr2/2017-09-11ae94c55f445b3013038aaa6640cd9687.jpg','https://image.weerun.com/wr2/2017-09-112709fa7ae9c1140659b36aac2feabc18.jpg','https://image.weerun.com/wr2/2017-09-1148c2e4dcd703497a7772e83c319860b3.jpg',1505100376,1505100376),(52,179,'啊啊啊啊','啊啊啊啊',51,'132','','https://image.weerun.com/wr2/2017-09-125e3903d890463e1933232faaabb3b4bf.jpg','','',1505180929,1505180977),(53,179,'啊啊啊啊','JJ啦',51,'132','https://image.weerun.com/wr2/2017-09-12bf09ba7d7a622225d4841ede6ee2372d.jpg','https://image.weerun.com/wr2/2017-09-12de1d28cf570310b6b28335dae236275b.jpg','https://image.weerun.com/wr2/2017-09-122531b16c04ffbcd974c65991c1aff3d2.jpg','https://image.weerun.com/wr2/2017-09-1201e578c0bb11c40dbb4104bedad28272.jpg',1505181084,1505181084),(54,181,'adsdsadsda','sadsadasdsadsad',51,'132','https://image.weerun.com/wr2/2017-09-14407f8712df9a7019880c7d64f221ba15.jpg','https://image.weerun.com/wr2/2017-09-147cc7b646219b59ff1708b2b3ae33050c.jpg','https://image.weerun.com/wr2/2017-09-14ed5ac8651dcfed350a31e480e28db61d.jpg','https://image.weerun.com/wr2/2017-09-143b4b687976b1d8b4117a3dc39bfea93c.jpg',1505375741,1505375741),(55,181,'wqqwqwqw','wqqw',51,'132','https://image.weerun.com/wr2/2017-09-140dbb10aace62a3751969d03280839359.jpg','','','',1505376153,1505376153),(56,181,'21211221','121212',51,'132','https://image.weerun.com/wr2/2017-09-18c00e30d553babaffa76d37338107b853.jpg','','','',1505701605,1505701605),(57,181,'211221','212121',51,'132','https://image.weerun.com/wr2/2017-09-18f42020fbe6a97d388927d3f035314784.jpg','','','',1505701612,1505701612),(58,181,'21212121','211212',51,'132','','https://image.weerun.com/wr2/2017-09-1856e4e9cf315c89ab3170c655ff44e53a.jpg','','',1505701620,1505701620),(59,185,'大波浪','大波浪',60,'145','https://image.weerun.com/wr2/2017-09-186fc020dd73a5edc654ca4af63cd5a0a3.jpg','','','',1505713432,1505713432),(61,186,'啊实打实的','的的撒',61,'146','https://image.weerun.com/wr2/2017-09-180ee1c6e41d38cd85fe69fdbc2fc37c12.jpg','https://image.weerun.com/wr2/2017-09-18a484f4d8a3fe5e33705f109463b51d38.jpg','https://image.weerun.com/wr2/2017-09-185da60998ff9ccb509961b94e966f4372.jpg','',1505714867,1505714867),(62,187,'azhong','wqa',61,'146','https://image.weerun.com/wr2/2017-09-18df8d9aa561f80f2324d6cc519d7c74b1.jpg','','','',1505717150,1505717150),(65,191,'总监精剪-雕花','根据客户自主选择图案。进行精剪雕花。\n时长根据不同图案不等。收费68-138不等',65,'150','https://image.weerun.com/wr2/2017-09-19a23048cd9faf54259f10512456a2955c.jpg','https://image.weerun.com/wr2/2017-09-1955515a2f6a25ad94266ce2412a02fc06.jpg','https://image.weerun.com/wr2/2017-09-191588c4d42f10e07643c4c0f5c1901a1b.jpg','',1505803345,1505812381),(66,191,'波斯少女系列','波斯猫(´▽｀)ノ♪',65,'150','https://image.weerun.com/wr2/2017-09-19f17ea6600836d275d9e85dc280d8f077.jpg','https://image.weerun.com/wr2/2017-09-197932b381de6e8678f347f8c151b6d888.jpg','https://image.weerun.com/wr2/2017-09-19ed7421cb031f805dd93792cf98e11cb3.jpg','',1505803447,1505812469),(67,191,'元气少女系列','感谢。小九九颜值赞助',65,'150','https://image.weerun.com/wr2/2017-09-195e249d135848c55ed563d31993313dc1.jpg','https://image.weerun.com/wr2/2017-09-19e906831168a8c080e796747978028839.jpg','https://image.weerun.com/wr2/2017-09-198102cfd358eded8d1032f49a2a9b26a7.jpg','',1505803761,1505812491),(69,191,'英朗短发系列','(⁄ ⁄•⁄ω⁄•⁄ ⁄)有没有很帅',65,'150','https://image.weerun.com/wr2/2017-09-19499db942408946bf6cd7e9daf1007826.jpg','https://image.weerun.com/wr2/2017-09-19038d7106f681350ffc27d153ef729a6f.jpg','https://image.weerun.com/wr2/2017-09-19c061b515ee5669cd4f4a72eec515ab6f.jpg','',1505812707,1505812707),(70,198,'儿童精简','儿童精剪',71,'156','https://image.weerun.com/wr2/2017-09-198b69f061862dd079be31b3229f733d73.jpg','https://image.weerun.com/wr2/2017-09-193809e53dfc8a182861f872a8aece2352.jpg','https://image.weerun.com/wr2/2017-09-1913f2e5b5cb875331c0264818aaefb21e.jpg','https://image.weerun.com/wr2/2017-09-1979d7ddc3cc97666239a1056938e327c7.jpg',1505821887,1505821904),(72,200,'欧美时尚发型','欧美风情',73,'160','https://image.weerun.com/wr2/2017-09-1946d6705c4ed9b075d40f2b40692d13c8.JPG','https://image.weerun.com/wr2/2017-09-199b7869ad41e08875caa53f12a24be08f.JPG','https://image.weerun.com/wr2/2017-09-19ee8d78ff60db548208977de441a78d0c.JPG','',1505821965,1505822032),(73,203,'美女长发','美女长发！！',74,'157','https://image.weerun.com/wr2/2017-09-19ba214f6d0fe280dda80bc75f5ddd97f3.jpg','https://image.weerun.com/wr2/2017-09-198eb79259089783c55a03219a46066f83.jpg','https://image.weerun.com/wr2/2017-09-191f59eb0d854d003a34912b450e2bcc39.jpg','https://image.weerun.com/wr2/2017-09-19a18c31d2f64818ad2d8b24a19e4a1737.jpg',1505822258,1505822258),(74,210,'狗狗','布丁',76,'163','https://image.weerun.com/wr2/2017-09-2150b7137cb347b1add27df02bf8391856.JPG','https://image.weerun.com/wr2/2017-09-21e3b77518c55d8d0a22698931ba5cdb9a.JPG','https://image.weerun.com/wr2/2017-09-21a454d06cad0837c5f07458edb473e04d.JPG','',1505960938,1505960938);

/*Table structure for table `wr_waiter_appoint_time` */

DROP TABLE IF EXISTS `wr_waiter_appoint_time`;

CREATE TABLE `wr_waiter_appoint_time` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `waiter_id` int(11) DEFAULT NULL COMMENT '服务师id',
  `merchant_id` int(10) DEFAULT NULL COMMENT '商户id',
  `shop_id` varchar(255) DEFAULT NULL COMMENT '门店',
  `time_date` varchar(255) DEFAULT NULL COMMENT '预约日期',
  `time_hour` varchar(255) DEFAULT NULL COMMENT '预约时间(小时)',
  `status` tinyint(4) DEFAULT '1' COMMENT '预约状态\n1：该时间被占用\n2：该时间被释放',
  `appoint_id` varchar(255) DEFAULT NULL COMMENT '预约单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1561 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='服务师预约时间表';

/*Data for the table `wr_waiter_appoint_time` */

insert  into `wr_waiter_appoint_time`(`id`,`waiter_id`,`merchant_id`,`shop_id`,`time_date`,`time_hour`,`status`,`appoint_id`) values (1293,171,51,'132','2017-09-12','19',2,'y201709111330091f61f0bdf'),(1294,171,51,'132','2017-09-12','20',2,'y2017091113354420b051d00'),(1295,171,51,'132','2017-09-12','21',2,'y201709111417252a756a4e4'),(1296,175,51,'132','2017-09-11','36',2,'y201709111555004154092ea'),(1297,175,51,'132','2017-09-11','37',2,'y201709111555004154092ea'),(1298,175,51,'132','2017-09-11','38',2,'y201709111555004154092ea'),(1299,175,51,'132','2017-09-11','44',2,'y201709111658315037d3b04'),(1300,175,51,'132','2017-09-11','45',2,'y201709111658315037d3b04'),(1301,175,51,'132','2017-09-11','46',2,'y201709111658315037d3b04'),(1302,175,51,'132','2017-09-13','24',2,'y2017091116595150876ec25'),(1303,175,51,'132','2017-09-13','25',2,'y2017091116595150876ec25'),(1304,175,51,'132','2017-09-13','26',2,'y2017091116595150876ec25'),(1305,175,51,'132','2017-09-13','27',1,'y20170911171557544d6a2d7'),(1306,175,51,'132','2017-09-13','28',1,'y20170911171557544d6a2d7'),(1307,175,51,'132','2017-09-13','29',1,'y20170911171557544d6a2d7'),(1308,175,51,'132','2017-09-13','30',1,'y2017091117173154ab0d512'),(1309,175,51,'132','2017-09-13','31',1,'y2017091117173154ab0d512'),(1310,175,51,'132','2017-09-13','32',1,'y2017091117173154ab0d512'),(1311,175,51,'132','2017-09-13','19',1,'y2017091210131242b81ae49'),(1312,175,51,'132','2017-09-13','20',1,'y20170912101516433459a34'),(1313,175,51,'132','2017-09-13','21',1,'y2017091210174843cc326d4'),(1314,175,51,'132','2017-09-13','22',2,'y201709121045304a4a37002'),(1315,175,51,'132','2017-09-13','22',1,'y201709121048014ae17343f'),(1316,171,51,'132','2017-09-12','24',2,'y201709121051314bb397c60'),(1317,181,51,'132','2017-09-12','32',2,'y201709121414527b5c8b1bd'),(1318,181,51,'132','2017-09-12','33',2,'y201709121414527b5c8b1bd'),(1319,181,51,'132','2017-09-12','34',2,'y201709121414527b5c8b1bd'),(1320,171,51,'132','2017-09-12','31',1,'y201709121416197bb39b03c'),(1321,171,51,'132','2017-09-12','36',2,'y201709121629049ad0c1bbb'),(1322,175,51,'132','2017-09-13','23',2,'y201709130921118807c94b7'),(1323,171,51,'132','2017-09-13','25',1,'y20170913112832a5e05e279'),(1324,171,51,'132','2017-09-13','26',1,'y20170913113440a7504c7c3'),(1325,181,51,'132','2017-09-13','35',2,'y20170913160754e75a17164'),(1326,181,51,'132','2017-09-14','19',2,'y20170913161035e7fb4ea22'),(1327,171,51,'132','2017-09-13','35',1,'y20170913161126e82e4567e'),(1328,171,51,'132','2017-09-13','36',2,'y20170913161306e892b5670'),(1329,181,51,'132','2017-09-13','39',1,'y20170913161343e8b7e82b0'),(1330,171,51,'132','2017-09-15','38',2,'y20170913161802e9ba1ebbe'),(1331,179,51,'132','2017-09-13','37',1,'y20170913162415eb2fe057d'),(1332,171,51,'132','2017-09-14','32',1,'y20170914145334276e2e99f'),(1333,181,51,'132','2017-09-15','28',2,'y201709141524022e92212c5'),(1334,181,51,'132','2017-09-15','29',2,'y201709141524022e92212c5'),(1335,181,51,'132','2017-09-15','30',2,'y201709141524022e92212c5'),(1336,171,51,'132','2017-09-15','21',1,'y201709150913422946185ad'),(1337,171,51,'132','2017-09-15','22',1,'y201709150913422946185ad'),(1338,171,51,'132','2017-09-15','23',1,'y201709150913422946185ad'),(1339,175,51,'132','2017-09-15','37',1,'y2017091509534732abef115'),(1340,175,51,'132','2017-09-15','38',2,'y20170915095730338af3410'),(1341,175,51,'132','2017-09-15','39',2,'y20170915095730338af3410'),(1342,175,51,'132','2017-09-15','40',2,'y20170915095730338af3410'),(1343,181,51,'132','2017-09-15','40',2,'y201709151141124bd8b571e'),(1344,181,51,'132','2017-09-15','41',2,'y201709151141124bd8b571e'),(1345,181,51,'132','2017-09-15','42',2,'y201709151141124bd8b571e'),(1346,182,58,'142','2017-09-16','27',2,'y201709151141234be36fe40'),(1347,182,58,'142','2017-09-16','28',2,'y201709151141234be36fe40'),(1348,181,51,'132','2017-09-15','40',2,'y201709151143494c7523f77'),(1349,181,51,'132','2017-09-15','41',2,'y201709151143494c7523f77'),(1350,181,51,'132','2017-09-15','42',2,'y201709151143494c7523f77'),(1351,175,51,'132','2017-09-15','38',2,'y201709151355496b653e997'),(1352,175,51,'132','2017-09-15','39',2,'y201709151356316b8f89d52'),(1353,175,51,'132','2017-09-15','40',2,'y201709151358536c1d27cdf'),(1354,175,51,'132','2017-09-15','41',2,'y201709151404196d63347b1'),(1355,175,51,'132','2017-09-15','39',2,'y20170915143509749dcdcf8'),(1356,175,51,'132','2017-09-15','40',2,'y20170915144126761660f50'),(1357,175,51,'132','2017-09-15','41',2,'y201709151458147a068cd75'),(1358,175,51,'132','2017-09-15','45',2,'y201709151626588ed27bfa0'),(1359,175,51,'132','2017-09-15','38',2,'y201709151631498ff53733a'),(1360,175,51,'132','2017-09-15','42',2,'y201709151632079007cf96b'),(1361,181,51,'132','2017-09-15','40',2,'y2017091516350990bd23f6e'),(1362,181,51,'132','2017-09-15','40',2,'y201709151636549126278c1'),(1363,181,51,'132','2017-09-15','41',2,'y201709151636549126278c1'),(1364,181,51,'132','2017-09-15','42',2,'y201709151636549126278c1'),(1365,181,51,'132','2017-09-15','40',2,'y201709151637439157af66e'),(1366,181,51,'132','2017-09-15','41',2,'y201709151637439157af66e'),(1367,181,51,'132','2017-09-15','42',2,'y201709151637439157af66e'),(1368,181,51,'132','2017-09-15','41',1,'y20170915163810917282f1e'),(1369,181,51,'132','2017-09-15','42',1,'y20170915163810917282f1e'),(1370,181,51,'132','2017-09-15','43',1,'y20170915163810917282f1e'),(1371,175,51,'132','2017-09-15','38',2,'y2017091516400791e760ef7'),(1372,175,51,'132','2017-09-15','39',2,'y2017091516402291f60e701'),(1373,175,51,'132','2017-09-15','40',2,'y20170915164100921c2ef48'),(1374,181,51,'132','2017-09-16','19',1,'y20170915164709938d2a06e'),(1375,181,51,'132','2017-09-16','20',1,'y20170915164709938d2a06e'),(1376,181,51,'132','2017-09-16','21',1,'y20170915164709938d2a06e'),(1377,181,51,'132','2017-09-16','24',2,'y2017091516471893966c201'),(1378,181,51,'132','2017-09-16','25',2,'y2017091516471893966c201'),(1379,181,51,'132','2017-09-16','26',2,'y2017091516471893966c201'),(1380,175,51,'132','2017-09-15','41',2,'y20170915164935941f32be9'),(1381,181,51,'132','2017-09-15','45',2,'y2017091516512094885c6ec'),(1382,181,51,'132','2017-09-15','46',2,'y2017091516512094885c6ec'),(1383,181,51,'132','2017-09-15','47',2,'y2017091516512094885c6ec'),(1384,175,51,'132','2017-09-15','42',2,'y2017091517134599c93c77c'),(1385,175,51,'132','2017-09-15','43',2,'y201709151718269ae21629d'),(1386,175,51,'132','2017-09-15','44',2,'y201709151719489b34d7384'),(1387,175,51,'132','2017-09-15','45',2,'y20170915175542a39ecf755'),(1388,175,51,'132','2017-09-15','46',2,'y20170915175542a39ecf755'),(1389,175,51,'132','2017-09-15','47',2,'y20170915175542a39ecf755'),(1390,175,51,'132','2017-09-18','22',1,'y20170918094933262d5390b'),(1391,171,51,'132','2017-09-18','22',1,'y20170918095529279129588'),(1392,171,51,'132','2017-09-18','23',2,'y2017091810044329bb9c609'),(1393,175,51,'132','2017-09-18','23',2,'y2017091810054829fc23887'),(1394,175,51,'132','2017-09-18','24',1,'y201709181058593673188d7'),(1395,185,60,'145','2017-09-18','30',1,'y201709181346185daa9c69e'),(1396,185,60,'145','2017-09-18','31',1,'y201709181350275ea30828f'),(1397,185,60,'145','2017-09-18','32',1,'y201709181350275ea30828f'),(1398,186,61,'146','2017-09-18','38',1,'y201709181415036467a097d'),(1399,186,61,'146','2017-09-18','39',1,'y201709181415036467a097d'),(1400,186,61,'146','2017-09-18','40',1,'y201709181415036467a097d'),(1401,186,61,'146','2017-09-18','41',1,'y201709181415036467a097d'),(1402,186,61,'146','2017-09-19','41',2,'y201709181415286480bde6a'),(1403,186,61,'146','2017-09-19','42',2,'y201709181415286480bde6a'),(1404,186,61,'146','2017-09-19','43',2,'y201709181415286480bde6a'),(1405,186,61,'146','2017-09-19','44',2,'y201709181415286480bde6a'),(1406,186,61,'146','2017-09-20','29',1,'y20170918141557649d92408'),(1407,186,61,'146','2017-09-20','30',1,'y20170918141557649d92408'),(1408,186,61,'146','2017-09-20','31',1,'y20170918141557649d92408'),(1409,186,61,'146','2017-09-20','32',1,'y20170918141557649d92408'),(1410,186,61,'146','2017-09-21','22',1,'y20170918141751650f67ca4'),(1411,186,61,'146','2017-09-21','23',1,'y20170918141751650f67ca4'),(1412,186,61,'146','2017-09-21','24',1,'y20170918141751650f67ca4'),(1413,186,61,'146','2017-09-21','25',1,'y20170918141751650f67ca4'),(1414,186,61,'146','2017-09-18','32',1,'y20170918141805651d166e7'),(1415,186,61,'146','2017-09-18','33',1,'y20170918141805651d166e7'),(1416,186,61,'146','2017-09-18','34',1,'y20170918141805651d166e7'),(1417,186,61,'146','2017-09-18','35',1,'y20170918141805651d166e7'),(1418,187,61,'146','2017-09-18','34',1,'y201709181441306a9acafad'),(1419,187,61,'146','2017-09-18','35',1,'y201709181441306a9acafad'),(1420,187,61,'146','2017-09-18','36',1,'y201709181441306a9acafad'),(1421,187,61,'146','2017-09-18','37',1,'y201709181441306a9acafad'),(1422,187,61,'146','2017-09-18','40',2,'y201709181441386aa296e57'),(1423,187,61,'146','2017-09-18','41',2,'y201709181441386aa296e57'),(1424,187,61,'146','2017-09-18','42',2,'y201709181441386aa296e57'),(1425,187,61,'146','2017-09-18','43',2,'y201709181441386aa296e57'),(1426,187,61,'146','2017-09-18','45',1,'y201709181441476aab530df'),(1427,187,61,'146','2017-09-18','46',1,'y201709181441476aab530df'),(1428,187,61,'146','2017-09-18','47',1,'y201709181441476aab530df'),(1429,187,61,'146','2017-09-18','48',1,'y201709181441476aab530df'),(1430,188,60,'145','2017-09-18','32',2,'y201709181447476c132a1de'),(1431,188,60,'145','2017-09-18','33',2,'y201709181447476c132a1de'),(1432,188,60,'145','2017-09-18','34',2,'y201709181447476c132a1de'),(1433,188,60,'145','2017-09-18','35',2,'y201709181447476c132a1de'),(1434,188,60,'145','2017-09-18','36',2,'y201709181447476c132a1de'),(1435,188,60,'145','2017-09-18','37',2,'y201709181447476c132a1de'),(1436,171,51,'132','2017-09-20','29',2,'y201709181502436f9383c9c'),(1437,171,51,'132','2017-09-20','37',2,'y201709181504347002b7ec2'),(1438,175,51,'132','2017-09-21','41',2,'y20170918150635707bd5e7a'),(1439,175,51,'132','2017-09-21','42',2,'y20170918150635707bd5e7a'),(1440,175,51,'132','2017-09-21','43',2,'y20170918150635707bd5e7a'),(1441,185,60,'145','2017-09-18','34',1,'y2017091815375677d4d77a5'),(1442,185,60,'145','2017-09-18','35',1,'y20170918162547830ba4bd4'),(1443,175,51,'132','2017-09-18','37',2,'y20170918164322872a667a1'),(1444,175,51,'132','2017-09-18','38',2,'y20170918164322872a667a1'),(1445,175,51,'132','2017-09-18','39',2,'y20170918164322872a667a1'),(1446,189,60,'145','2017-09-19','33',2,'y20170919134858afca83218'),(1447,189,60,'145','2017-09-19','34',2,'y20170919134858afca83218'),(1448,189,60,'145','2017-09-19','30',2,'y20170919134917afdd7f8da'),(1449,189,60,'145','2017-09-19','32',2,'y20170919134933afed6e8a5'),(1450,189,60,'145','2017-09-19','31',2,'y20170919134942aff6a70fc'),(1451,185,60,'145','2017-09-19','30',2,'y20170919135014b016888ba'),(1452,175,51,'132','2017-09-19','30',2,'y20170919140501b38de8c0e'),(1453,175,51,'132','2017-09-19','31',2,'y20170919140524b3a45c1ca'),(1454,175,51,'132','2017-09-19','32',2,'y20170919140537b3b1e668a'),(1455,171,51,'132','2017-09-19','33',2,'y20170919141506b5eae0b98'),(1456,175,51,'132','2017-09-19','33',2,'y20170919141518b5f664d73'),(1457,189,60,'145','2017-09-19','31',2,'y20170919142722b8ca256a2'),(1458,189,60,'145','2017-09-19','32',2,'y20170919142722b8ca256a2'),(1459,175,51,'132','2017-09-19','34',2,'y20170919155656cdc897e95'),(1460,175,51,'132','2017-09-19','35',2,'y20170919155709cdd5347fe'),(1461,175,51,'132','2017-09-19','36',2,'y20170919155718cdde916ed'),(1462,175,51,'132','2017-09-19','37',2,'y20170919155731cdeb58882'),(1463,175,51,'132','2017-09-19','38',2,'y20170919155742cdf679524'),(1464,175,51,'132','2017-09-19','39',2,'y20170919155754ce02e0c0a'),(1465,175,51,'132','2017-09-19','35',2,'y20170919160223cf0f74c03'),(1466,175,51,'132','2017-09-19','36',2,'y20170919160504cfb0eaf4d'),(1467,171,51,'132','2017-09-19','38',1,'y20170919173932e5d4dc412'),(1468,191,65,'150','2017-09-21','25',1,'y20170919174452e714aab8b'),(1469,189,60,'145','2017-09-19','38',1,'y20170919175440e960b078f'),(1470,189,60,'145','2017-09-19','39',1,'y20170919175440e960b078f'),(1471,193,60,'145','2017-09-19','38',1,'y20170919175533e995cf1d2'),(1472,193,60,'145','2017-09-19','39',1,'y20170919175533e995cf1d2'),(1473,204,74,'157','2017-09-22','36',1,'y2017091920001506cfec184'),(1474,203,74,'157','2017-09-21','27',1,'y2017091920002506d90226e'),(1475,198,71,'156','2017-09-20','23',1,'y201709192006110833efffe'),(1476,203,74,'157','2017-09-19','43',1,'y201709192011040958d5911'),(1477,200,73,'160','2017-09-20','22',1,'y2017091920122409a8a1988'),(1478,200,73,'160','2017-09-20','23',1,'y2017091920122409a8a1988'),(1479,200,73,'160','2017-09-20','24',1,'y2017091920122409a8a1988'),(1480,200,73,'160','2017-09-20','27',1,'y201709192015030a471ffe5'),(1481,200,73,'160','2017-09-20','28',1,'y201709192015030a471ffe5'),(1482,200,73,'160','2017-09-20','29',1,'y201709192015030a471ffe5'),(1483,206,71,'156','2017-09-19','47',2,'y201709192016470aaf4b290'),(1484,206,71,'156','2017-09-19','48',2,'y201709192016470aaf4b290'),(1485,207,71,'156','2017-09-19','48',1,'y201709192017110ac7d883a'),(1486,200,73,'160','2017-09-20','25',1,'y201709192018550b2f5b47b'),(1487,200,73,'160','2017-09-20','26',1,'y201709192018550b2f5b47b'),(1488,202,72,'155','2017-09-20','20',1,'y201709192021380bd2be78c'),(1489,202,72,'155','2017-09-20','19',1,'y201709192023040c2849609'),(1490,200,73,'160','2017-09-20','43',1,'y201709192023490c555b23a'),(1491,200,73,'160','2017-09-20','44',1,'y201709192023490c555b23a'),(1492,205,72,'155','2017-09-19','43',1,'y201709192026510d0b5a975'),(1493,205,72,'155','2017-09-20','19',1,'y201709192030230ddf620a6'),(1494,193,60,'145','2017-09-20','23',1,'y20170920100654cd3e50712'),(1495,193,60,'145','2017-09-20','24',1,'y20170920100654cd3e50712'),(1496,193,60,'145','2017-09-20','30',1,'y20170920100758cd7e7944c'),(1497,193,60,'145','2017-09-20','31',1,'y20170920100758cd7e7944c'),(1498,193,60,'145','2017-09-20','26',1,'y20170920100858cdba0a9ca'),(1499,193,60,'145','2017-09-20','27',1,'y20170920100858cdba0a9ca'),(1500,194,60,'145','2017-09-21','28',2,'y20170920130829f7cded7a7'),(1501,189,60,'145','2017-09-21','29',1,'y20170920130956f824ae1b6'),(1502,189,60,'145','2017-09-21','30',1,'y20170920130956f824ae1b6'),(1503,196,70,'154','2017-09-21','15',1,'y20170920133055fd0f83337'),(1504,196,70,'154','2017-09-20','36',1,'y20170920133107fd1b27d77'),(1505,196,70,'154','2017-09-21','23',1,'y2017092016034020dcd32f2'),(1506,208,69,'152','2017-09-21','23',1,'y201709201645482abc1c067'),(1507,208,69,'152','2017-09-21','24',1,'y201709201645482abc1c067'),(1508,208,69,'152','2017-09-21','25',1,'y201709201645482abc1c067'),(1509,208,69,'152','2017-09-21','26',1,'y201709201645482abc1c067'),(1510,210,76,'163','2017-09-21','31',1,'y2017092110243622e49c85e'),(1511,211,79,'164','2017-09-21','28',1,'y20170921123510417e37b7e'),(1512,211,79,'164','2017-09-21','29',1,'y20170921123510417e37b7e'),(1513,171,51,'132','2017-09-21','29',1,'y201709211315164ae4ef29b'),(1514,208,69,'152','2017-09-23','22',1,'y2017092114575262f0b96f1'),(1515,208,69,'152','2017-09-23','23',1,'y2017092114575262f0b96f1'),(1516,208,69,'152','2017-09-23','24',1,'y2017092114575262f0b96f1'),(1517,208,69,'152','2017-09-23','25',1,'y2017092114575262f0b96f1'),(1518,208,69,'152','2017-09-22','23',1,'y20170921151646675ecabc3'),(1519,208,69,'152','2017-09-22','24',1,'y20170921151646675ecabc3'),(1520,208,69,'152','2017-09-22','25',1,'y20170921151646675ecabc3'),(1521,208,69,'152','2017-09-22','26',1,'y20170921151646675ecabc3'),(1522,208,69,'152','2017-09-24','22',1,'y2017092115175867a6e66cc'),(1523,208,69,'152','2017-09-24','23',1,'y2017092115175867a6e66cc'),(1524,208,69,'152','2017-09-24','24',1,'y2017092115175867a6e66cc'),(1525,208,69,'152','2017-09-24','25',1,'y2017092115175867a6e66cc'),(1526,196,70,'154','2017-09-21','33',1,'y201709211530566ab07b565'),(1527,196,70,'154','2017-09-21','34',1,'y20170921155613709d2b3d1'),(1528,196,70,'154','2017-09-21','36',1,'y2017092115562470a8e2374'),(1529,196,70,'154','2017-09-21','43',1,'y20170921193412a3b430af4'),(1530,208,69,'152','2017-09-25','23',1,'y20170922092515667b28d14'),(1531,208,69,'152','2017-09-25','24',1,'y20170922092515667b28d14'),(1532,208,69,'152','2017-09-25','25',1,'y20170922092515667b28d14'),(1533,208,69,'152','2017-09-25','26',1,'y20170922092515667b28d14'),(1534,212,69,'167','2017-09-22','31',1,'y20170922113647854fb0874'),(1535,212,69,'167','2017-09-22','32',1,'y20170922113647854fb0874'),(1536,212,69,'167','2017-09-22','33',1,'y20170922113647854fb0874'),(1537,212,69,'167','2017-09-22','34',1,'y20170922113647854fb0874'),(1538,212,69,'167','2017-09-22','35',1,'y20170922113647854fb0874'),(1539,212,69,'167','2017-09-22','36',1,'y20170922113647854fb0874'),(1540,212,69,'167','2017-09-22','38',1,'y20170922113659855b1cd13'),(1541,212,69,'167','2017-09-22','39',1,'y20170922113659855b1cd13'),(1542,212,69,'167','2017-09-22','40',1,'y20170922113659855b1cd13'),(1543,212,69,'167','2017-09-22','41',1,'y20170922113659855b1cd13'),(1544,212,69,'167','2017-09-22','42',1,'y20170922113659855b1cd13'),(1545,212,69,'167','2017-09-22','43',1,'y20170922113659855b1cd13'),(1546,212,69,'167','2017-09-23','26',1,'y2017092211370685629b4e1'),(1547,212,69,'167','2017-09-23','27',1,'y2017092211370685629b4e1'),(1548,212,69,'167','2017-09-23','28',1,'y2017092211370685629b4e1'),(1549,212,69,'167','2017-09-23','29',1,'y2017092211370685629b4e1'),(1550,212,69,'167','2017-09-23','30',1,'y2017092211370685629b4e1'),(1551,212,69,'167','2017-09-23','31',1,'y2017092211370685629b4e1'),(1552,175,51,'132','2017-09-26','30',1,'y20170926135351eb6f54886'),(1553,175,51,'132','2017-09-26','35',1,'y20170926140652ee7c398ec'),(1554,193,60,'145','2017-09-29','35',1,'y20170929161229006dba422'),(1555,193,60,'145','2017-09-29','36',1,'y20170929161229006dba422'),(1556,193,60,'145','2017-10-10','21',1,'y201710100920252059f30db'),(1557,193,60,'145','2017-10-11','21',1,'y20171011092604732c19312'),(1558,193,60,'145','2017-10-11','22',1,'y20171011092604732c19312'),(1559,191,65,'150','2017-10-12','20',1,'y2017101121471920e752605'),(1560,191,65,'150','2017-10-12','21',1,'y2017101121471920e752605');

/*Table structure for table `wr_waiter_comment` */

DROP TABLE IF EXISTS `wr_waiter_comment`;

CREATE TABLE `wr_waiter_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `waiter_id` int(10) DEFAULT NULL COMMENT '服务师id',
  `member_id` int(10) DEFAULT NULL COMMENT '客户id',
  `merchant_id` int(10) DEFAULT NULL COMMENT '商户id',
  `shop_id` int(10) DEFAULT NULL COMMENT '门店id',
  `appoint_id` int(10) DEFAULT NULL COMMENT '预约单id',
  `waiter_grade` int(10) DEFAULT NULL COMMENT '服务师评星',
  `punctual_id` int(10) DEFAULT NULL COMMENT '守时标签id',
  `stance_id` int(10) DEFAULT NULL COMMENT '态度标签id',
  `art_id` int(10) DEFAULT NULL COMMENT '技能标签id',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `wr_waiter_comment` */

insert  into `wr_waiter_comment`(`id`,`waiter_id`,`member_id`,`merchant_id`,`shop_id`,`appoint_id`,`waiter_grade`,`punctual_id`,`stance_id`,`art_id`,`created_at`,`updated_at`,`deleted_at`) values (3,196,268,70,154,1194,4,17,11,14,1505973020,1505973020,NULL),(4,208,242,69,152,1197,5,17,11,14,1505977705,1505977705,NULL),(6,208,242,69,152,1202,2,18,13,15,1505977737,1505977737,NULL),(8,208,242,69,152,1203,5,17,11,14,1505978315,1505978315,NULL),(9,208,242,69,152,1204,1,19,13,16,1505978326,1505978326,NULL),(10,196,268,70,154,1196,5,18,11,14,1505979172,1505979172,NULL),(11,196,268,70,154,1205,5,19,11,15,1505980482,1505980482,NULL),(12,196,268,70,154,1206,5,19,12,15,1505980650,1505980650,NULL),(13,196,268,70,154,1207,5,19,13,16,1505980738,1505980738,NULL),(14,196,268,70,154,1208,4,18,11,15,1505993700,1505993700,NULL),(15,212,242,69,167,1210,5,17,11,14,1506051452,1506051452,NULL),(16,212,242,69,167,1211,1,19,13,16,1506051457,1506051457,NULL),(17,212,242,69,167,1212,3,18,12,15,1506051461,1506051461,NULL),(18,175,223,51,132,1100,5,18,12,14,1506309714,1506309714,NULL),(19,175,223,51,132,1130,5,18,12,15,1506309725,1506309725,NULL),(20,175,223,51,132,1134,5,17,11,14,1506309727,1506309727,NULL);

/*Table structure for table `wr_waiter_goods` */

DROP TABLE IF EXISTS `wr_waiter_goods`;

CREATE TABLE `wr_waiter_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `waiter_id` int(11) DEFAULT NULL COMMENT '服务师id',
  `goods_id` int(11) DEFAULT NULL COMMENT '产品id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=690 DEFAULT CHARSET=utf8 COMMENT='服务师产品关系表';

/*Data for the table `wr_waiter_goods` */

insert  into `wr_waiter_goods`(`id`,`waiter_id`,`goods_id`) values (377,172,302),(378,172,303),(379,172,304),(380,172,305),(381,172,306),(382,172,307),(383,172,308),(391,176,302),(392,176,303),(393,176,304),(394,176,305),(395,176,306),(396,176,307),(397,176,308),(398,177,302),(399,177,303),(400,177,304),(401,177,305),(402,177,306),(403,178,302),(404,178,303),(405,178,304),(415,179,302),(416,179,303),(417,179,304),(418,179,305),(419,179,306),(420,180,302),(421,180,303),(422,180,304),(423,180,305),(424,180,306),(425,180,307),(426,180,308),(448,181,302),(449,181,303),(450,181,304),(451,181,305),(452,181,306),(453,181,307),(454,181,308),(455,182,320),(456,183,327),(457,183,328),(458,183,329),(459,184,327),(460,184,328),(461,184,329),(462,185,327),(463,185,328),(464,185,329),(466,186,335),(467,187,335),(476,188,329),(477,189,327),(478,189,328),(479,190,339),(513,194,327),(514,194,328),(515,194,329),(521,171,302),(522,171,303),(523,171,304),(524,171,305),(525,171,306),(526,171,307),(527,171,308),(528,193,327),(529,193,328),(531,192,347),(547,175,302),(548,175,303),(549,175,304),(550,175,305),(551,175,306),(552,195,352),(553,195,353),(554,195,354),(555,195,355),(556,195,356),(557,195,357),(558,196,363),(559,197,363),(570,198,375),(571,198,376),(572,198,377),(573,198,387),(574,199,375),(575,199,376),(576,199,377),(577,199,387),(578,199,388),(579,199,390),(580,199,392),(586,201,391),(587,201,393),(588,202,373),(589,202,374),(590,202,382),(607,191,352),(608,191,353),(609,191,354),(610,191,355),(611,191,356),(612,191,357),(613,191,358),(614,191,359),(615,191,360),(616,191,361),(617,203,396),(618,203,397),(619,203,398),(620,204,396),(621,204,397),(622,204,398),(628,205,373),(629,205,374),(630,205,382),(631,205,383),(632,205,385),(633,205,386),(634,206,375),(635,206,376),(636,206,377),(637,206,387),(638,206,388),(639,206,390),(640,206,392),(641,200,379),(642,200,380),(643,200,381),(644,200,384),(645,200,399),(646,200,400),(647,207,375),(648,207,376),(649,207,377),(650,207,387),(651,207,388),(652,207,390),(653,207,392),(654,208,347),(665,210,405),(666,210,406),(667,210,407),(668,210,408),(669,210,409),(670,210,410),(671,210,411),(672,211,413),(677,212,430),(678,213,463),(679,213,464),(680,209,352),(681,209,353),(682,209,354),(683,209,355),(684,209,356),(685,209,357),(686,209,358),(687,209,359),(688,209,360),(689,209,361);

/*Table structure for table `wr_waiter_level` */

DROP TABLE IF EXISTS `wr_waiter_level`;

CREATE TABLE `wr_waiter_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(100) DEFAULT NULL COMMENT '职位名称',
  `merchant_id` int(11) DEFAULT NULL COMMENT '商户id',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COMMENT='服务师职位';

/*Data for the table `wr_waiter_level` */

insert  into `wr_waiter_level`(`id`,`name`,`merchant_id`,`created_at`,`updated_at`) values (44,'高级理发师',51,1505095990,1505096004),(45,'店长',51,1505095990,1505095990),(46,'督导',51,1505095990,1505095990),(47,'啊六六六六六',55,1505357759,1505357759),(48,'唐酷兔兔',55,1505357775,1505357775),(49,'哦哦哦哦哦哦哦',55,1505357775,1505357775),(50,'高级服务师',57,1505376544,1505376544),(51,'设计师',58,1505444228,1505444228),(52,'店长',58,1505444228,1505444228),(53,'总监',58,1505444228,1505444228),(54,'高级服务师',60,1505704975,1505704975),(55,'总监',60,1505704975,1505704975),(56,'店长',60,1505704975,1505704975),(57,'总监',59,1505711889,1505711889),(58,'1店长',61,1505713700,1505713722),(64,'技术总监',65,1505800378,1505811339),(65,'首席服务师',65,1505800378,1505811356),(66,'资深服务师',65,1505800378,1505811371),(68,'高级技师',70,1505815523,1505815523),(69,'中级技术',70,1505815523,1505815523),(70,'总监',72,1505820834,1505820834),(71,'首席',72,1505820834,1505820834),(72,'设计师',72,1505820834,1505820834),(73,'美容师',71,1505821541,1505821541),(74,'美发师',71,1505821541,1505821541),(75,'美甲师',71,1505821541,1505821541),(76,'高级经理',71,1505821541,1505821541),(77,'高级总监',71,1505821541,1505821541),(78,'店长',71,1505821541,1505821541),(80,'高级理发师',73,1505821626,1505821626),(81,'总监',73,1505821626,1505821626),(82,'店长',73,1505821626,1505821626),(83,'店长',75,1505821654,1505821654),(84,'大师',74,1505821934,1505821934),(85,'工匠',74,1505821934,1505821934),(86,'学徒',74,1505821934,1505821934),(87,'首席',75,1505823001,1505823001),(88,'次席',75,1505823012,1505823012),(89,'高级',75,1505823021,1505823021),(90,'总监',76,1505960307,1505960307),(91,'经理',76,1505960307,1505960307),(98,'总监',69,1506063976,1506063976),(99,'快点快点看',81,1506310294,1506310294),(101,'飒飒',69,1506326307,1506326307),(103,'首席',82,1506335630,1506335630);

/*Table structure for table `wr_waiter_rest` */

DROP TABLE IF EXISTS `wr_waiter_rest`;

CREATE TABLE `wr_waiter_rest` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `waiter_id` int(11) DEFAULT NULL COMMENT '服务师id',
  `start_time` int(11) DEFAULT NULL COMMENT '调休时间',
  `end_time` int(11) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=utf8;

/*Data for the table `wr_waiter_rest` */

insert  into `wr_waiter_rest`(`id`,`waiter_id`,`start_time`,`end_time`,`remark`) values (178,175,1505290906,1505390806,'有事外出'),(195,181,1505386860,1505473260,''),(196,171,1505438100,1505618100,'休息'),(197,175,1505440800,1505469600,'有事情，外出！'),(201,182,1505528125,1505531737,''),(202,185,1505883600,1505894400,'调休'),(203,185,1506145920,1506491520,''),(205,179,1509598800,1509645540,''),(209,191,1505968200,1506006000,''),(210,207,1505910600,1505997000,''),(211,204,1505824529,1505824532,''),(212,204,1505824540,1505910940,''),(214,199,1505867436,1505911240,''),(215,201,1505824598,1505997399,''),(216,200,1505872820,1505916036,'请假'),(220,196,1505959260,1505973600,'有事情请假！！'),(221,191,1507782180,1508126400,''),(222,191,1508731200,1509336000,'');

/*Table structure for table `wr_wuser` */

DROP TABLE IF EXISTS `wr_wuser`;

CREATE TABLE `wr_wuser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(500) CHARACTER SET utf8 DEFAULT NULL COMMENT '微信昵称',
  `sex` tinyint(2) DEFAULT NULL COMMENT '性别(0保密,1男,2女)',
  `headimgurl` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '头像',
  `city` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT '城市',
  `province` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT '省份',
  `country` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT '国家',
  `language` varchar(20) CHARACTER SET utf8 DEFAULT 'zh-cn' COMMENT '语言',
  `unionid` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '微信第三方ID',
  `subscribe_time` int(10) DEFAULT NULL COMMENT '用户关注公众号时间',
  `remark` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '微信用户备注',
  `groupid` int(10) DEFAULT NULL COMMENT '微信端的分组ID',
  `open_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '微信open_id',
  `is_subscribe` tinyint(4) DEFAULT NULL COMMENT '是否关注\n0:取消关注\n1：关注',
  `token` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '公众号原始id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=270 DEFAULT CHARSET=utf8mb4 COMMENT='微信粉丝表';

/*Data for the table `wr_wuser` */

insert  into `wr_wuser`(`id`,`nickname`,`sex`,`headimgurl`,`city`,`province`,`country`,`language`,`unionid`,`subscribe_time`,`remark`,`groupid`,`open_id`,`is_subscribe`,`token`) values (244,'贺兰丛丛',1,'http://wx.qlogo.cn/mmopen/FfcQhWeOnVhL3JTf99UTfBq3BojQko9wgKItdM8rJTud9ZWHM86uEX4cibWnETribNr1yVibLAVSFkMwiaOqNFaRwKZnUXH1Vwon/0','闵行','上海','中国','en',NULL,1505101262,'',0,'o9KRbwrHxbx-HENgY2zx-Zhki_64',1,'gh_b34fae488daa'),(245,'阿钟喵',1,'http://wx.qlogo.cn/mmopen/FfcQhWeOnVhL3JTf99UTfIQqdZlkproTUKpaicKoHgtI5dZibWJud9sc47b11zkHDtdIyjrIHHCG1icBWqAoru0eJWKRRQoXVVe/0','','迪拜','阿拉伯联合酋长国','zh_CN',NULL,1504517826,'',0,'o9KRbwruUVLveGr2Y0lauhNWEy-A',1,'gh_b34fae488daa'),(246,'木亦',1,'http://wx.qlogo.cn/mmopen/ib5YqYfqAabP6Ngy2nkD3FeAJ44FxZicWuosFxibicL7MECPoeydCTdicmaCeo72krjbbyibXWEF3YK1r0MGLjvTRX1BGHt52uiaJWa/0','','','中国','zh_CN',NULL,1502962100,'',0,'o9KRbwu81cSVzg9g7nKpi0hqveLI',1,'gh_b34fae488daa'),(247,'六儿',1,'http://wx.qlogo.cn/mmopen/ZXmcialJQl69hYah6QkdbAHBMSuBC999D0s9ibgdMY7wljibt20nOhytcuND2fjD0Vq1jrux7ibRQCvmdLGMsXvXsy0H0bERWU6P/0','','','中国','zh_CN',NULL,1504662230,'',0,'o9KRbwqDFkdJEcZgn4edsKHpvMKA',1,'gh_b34fae488daa'),(248,'郭小郭',1,'http://wx.qlogo.cn/mmopen/Mlib1ibM9j4BgVVs5xquTCviaBw2BS97czAbMBsCxNRrwdYiclZjIO5jiboRl0oeicUHPd8gtg7RHMhF39PVWcGVXGWTduzjbQwzJp/0','松江','上海','中国','zh_CN',NULL,1505292427,'',0,'o9KRbwgC9mKcWxYHWC8Nnq42OgoI',1,'gh_b34fae488daa'),(249,'贺兰丛丛',1,'http://wx.qlogo.cn/mmopen/tBcsVoCs6ibOl0wI8lCuvDKKSYowRAS0gLgeqVxMuiaMq5I2q88icH0eDIhTw3BfibokvNtv477fh05gicEdRBkKo3picicfibHGrZdV/0','闵行','上海','中国','en',NULL,1505373429,'',0,'oZ9stwp4O1mX9AEgZHeUThmfjq0s',1,'gh_201953288802'),(250,'木亦',1,'http://wx.qlogo.cn/mmopen/ialKLLGy1WwWYOtbJibwicicQAnuZaT7c24AialqfabUrYnkFtImticBSxlADrOXYlPsQInYLUlyDdqNt4TdONyTImqA2gXuG8rnSA/0','','','中国','zh_CN',NULL,1505376876,'',0,'oZ9stwkrneXquTo2V1Z9MnjBh2Hk',1,'gh_201953288802'),(251,'Fget',1,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLDkJia20WviapPCbCc8ZRW6hxewCblzLr0VSCON1CibmH4hHzCYVHp0NjSdGuSN7NB3YpYmHD4PTVISA/0','徐汇','上海','中国','zh_CN',NULL,1505445796,'',0,'oZ9stwuLKDDZ2xliY4GLhWtCjp9s',1,'gh_201953288802'),(252,'Fget',1,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLDZ85tU644Jfb2MfcPuOrNgoxZxy1WElY0ZHiaIWoKVAT0D4ntDYRc9e1u1FaibEYziaWiat6h1st5ozQ/0','徐汇','上海','中国','zh_CN',NULL,1502955831,'',0,'o9KRbwoTOqvHGG0lb1YRmMzRc99A',1,'gh_b34fae488daa'),(253,'贺兰丛丛',1,'http://wx.qlogo.cn/mmopen/ryCQ4PkLrx7kLG0V61rP69eFNmzZSCIc4YuJBLQyjbbmWkJ5YXgsPA9PpWfkEONiamxAbPM02EiboMKHsqzzgeGDPnx64x2wkv/0','闵行','上海','中国','en',NULL,1505706601,'',0,'oDrxZ0vN4OcZhly4cAxC3UWYsSIo',1,'gh_ececf74d99d1'),(254,'木亦',1,'http://wx.qlogo.cn/mmopen/aRlMvCYr2RlVwxorc1pyFeAXmxepkM7WwoArLNUicbepHOGMzk0IohSKUxctb2Uj3zqpFFEa5I8BJfXWHOxx8EBvNaRI5FT83/0','','','中国','zh_CN',NULL,1500885489,'',0,'oDrxZ0p3lLuqAThT6rH8ptNTI5l8',1,'gh_ececf74d99d1'),(255,'六儿',1,'http://wx.qlogo.cn/mmopen/H2CxJ1pMnFkXGaqyXYDdzAAsfGQBz7iaibjnYtqLP2DITgRLfs5IVdC30a6uZHf9ib2OHFn5tcLZ3ZjaaEndCK2crGRb3hGofaic/0','','','中国','zh_CN',NULL,1503987591,'',0,'oDrxZ0mA3A1Mtm-1fXGp6-91eCPc',1,'gh_ececf74d99d1'),(256,'阿钟喵',1,'http://wx.qlogo.cn/mmopen/ryCQ4PkLrx7kLG0V61rP6ibRic5Gq8DL2FPPdc0egFsxetzS5K2MnK1K2z0yPkgPqQzghm3Aia0SVtWyYTTFaiaesRiaocqBSPjiaK/0','','迪拜','阿拉伯联合酋长国','zh_CN',NULL,1500885565,'',0,'oDrxZ0kTW7sr6tTE9cJXObv51M2A',1,'gh_ececf74d99d1'),(257,'Fget',1,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLB0pOaUvyL0SMnH1GrbJC70NGUjhmBdUDbk1ibwoIQfU6EM90ooTiaDUiap6KJAQPT9QAjn5U5v7cbicA/0','徐汇','上海','中国','zh_CN',NULL,1500885513,'',0,'oDrxZ0nbY7Iz1tpnUSa0LbRyBiiM',1,'gh_ececf74d99d1'),(258,'金宇Johnny',1,'http://wx.qlogo.cn/mmopen/ryCQ4PkLrx7kLG0V61rP6ibSvrPwppnWXmGFFBw73CIL68Hib08ibB1jXsfpWNHHJVXwR7RpKWjBWU211rrDQNjUHm78AVMAsqia/0','徐汇','上海','中国','zh_CN',NULL,1499244670,'',0,'oDrxZ0hOdCUJbPVCaB1vlN1Ppkzs',1,'gh_ececf74d99d1'),(259,'唐',2,'http://wx.qlogo.cn/mmopen/Q3auHgzwzM7gOBXFIXMC0MLDfE77rrsfMRL11nLn8BqH7qh4H1W4COgN2wC2PXoxfDmaFq5z6P6tYBRAeQP81OXh2EcKLztYMFHGKTFyXPM/0','','上海','中国','zh_CN',NULL,1505814968,'',0,'oDrxZ0sL4xgxU9NDLFV2PQko0-4A',1,'gh_ececf74d99d1'),(260,'avel',2,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLAkFLhaLibSGBcElCHkvYEbYJEbvt7WBibkicticPqggslrscqlWSawzIsv4lo61eibNq5Q8wKRD2mml5Q/0','长宁','上海','中国','zh_CN',NULL,1499244662,'',0,'oDrxZ0vOldFWoU981Vj2bulBq474',1,'gh_ececf74d99d1'),(261,'杨世海',1,'http://wx.qlogo.cn/mmopen/Q3auHgzwzM40uQ0lyd6jrbNkibSV1SysvO2wv4dZsZhFTZfm82fKZC3Y3b1ngzjmpyEVhOsia27qEF1Fgo0ia37MA/0','闵行','上海','中国','zh_CN',NULL,1499245579,'',0,'oDrxZ0k00Jr3m7rPx4KqoEz5lGCM',1,'gh_ececf74d99d1'),(262,'皓月Owen',1,'http://wx.qlogo.cn/mmopen/H2CxJ1pMnFkXGaqyXYDdzCLsQg67AZcc0EjKHsRe3tQLLCH6OicvHlyVlcGVbtQhbgkduk1WaibCZn4p0CG5dvvgHumP0gx2rF/0','','上海','中国','zh_CN',NULL,1505822379,'',0,'oDrxZ0oyvYEE5AHBMHeUSNFwGilU',1,'gh_ececf74d99d1'),(263,'刘俊',1,'http://wx.qlogo.cn/mmopen/ryCQ4PkLrx7kLG0V61rP61l2oyUe4f8Zq5Bfmyb2Jgx7C2TOI4guF7TVIskeXNGmWCS5kIV2ziaRD2Vc0SA3SXzHvnMJZ0g51/0','常德','湖南','中国','zh_CN',NULL,1505823750,'',0,'oDrxZ0jO4nlfyNzbX7DTVAygl6wg',1,'gh_ececf74d99d1'),(264,'管福康',1,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLDo9RA6kTvL2CeicfmVcaj2j6TE5WOwIUMywah20OD5R6ibLKXt2MqFKqfjYeb2448C8icFjMTmWUGpg/0','','上海','中国','zh_CN',NULL,1499306348,'',0,'oDrxZ0pQ5gapqK0nykoC4RnsBE-s',1,'gh_ececf74d99d1'),(265,'贺兰丛丛',1,'http://wx.qlogo.cn/mmopen/JxIbOe23BHicKlJnEzNaYR6NnvwQISWLS68wFUWJpU5n7D6ewtyLL0kSe1uj5DZhWrQD4byT67pwReGoLrIPmaWTEwBohE1ibib/0','闵行','上海','中国','en',NULL,1500366508,'',0,'osOP3wuCEkfMWtFjXWO-wQRbXTAw',1,'gh_d40fa1f67378'),(266,'Fget',1,'http://wx.qlogo.cn/mmopen/ajNVdqHZLLANkFgc5Zyfq8qibMcdHibhOtllpH24T6leXppKXYiaMQqCCOicCqexZCt1gRLEnKsfFQ39hrB7KK8CXg/0','徐汇','上海','中国','zh_CN',NULL,1505990230,'',0,'osOP3wuCVZ9lPa7_4tI3sVChnPTk',1,'gh_d40fa1f67378'),(267,'小神',1,'http://wx.qlogo.cn/mmopen/ryCQ4PkLrx7kLG0V61rP6zNH0TBRibd42cFqia9h8icyRVxL7a2IIR4oOctKGBKKzrKqZib80M7lX0H4b0okgJpHfxb19xzwIiaiaU/0','','','安道尔','zh_CN',NULL,1506084479,'',0,'oDrxZ0ok3S91V8jq8yy3gV7pBZUE',1,'gh_ececf74d99d1'),(268,'大佛爷',2,'http://wx.qlogo.cn/mmopen/IbQhd2Y9oKfOL1IGwXmS8oMzj9z3RJUZia1AOfIC36ROeLTa53IJdibib2HzPHkBcRavib7iaic88epZ8vQ0QabSlJ0GKadd0ayibrib/0','宜宾','四川','中国','zh_CN',NULL,1508116090,'',0,'osOP3wjnExu-5sgBUQw8rp_WD2oU',1,'gh_d40fa1f67378'),(269,'皇帝私人定制',1,'http://wx.qlogo.cn/mmopen/Q3auHgzwzM4cMticYT5U5Px0Uzxe3Vhdzt6FVfgAaFZFBwiadf4YL5vnLP0TLnvUjUxh6Y4fb28NvS9zCNJ5nnJicQExYicJY3MXF8DTm6qkUK8/0','肇庆','广东','中国','zh_CN',NULL,1508333126,'',0,'osOP3wp8C5v-6eYccIKSrmsdMrns',1,'gh_d40fa1f67378');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
