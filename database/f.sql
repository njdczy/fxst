-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.5.53 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- 导出 fxst 的数据库结构
CREATE DATABASE IF NOT EXISTS `fxst` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `fxst`;

-- 导出  表 fxst.admin_menu 结构
CREATE TABLE IF NOT EXISTS `admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.admin_menu 的数据：~20 rows (大约)
DELETE FROM `admin_menu`;
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;
INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `created_at`, `updated_at`) VALUES
	(1, 0, 1, 'Index', 'fa-bar-chart', '/', NULL, NULL),
	(2, 0, 2, 'Admin', 'fa-tasks', '', NULL, NULL),
	(3, 2, 3, 'Users', 'fa-users', 'auth/users', NULL, NULL),
	(4, 2, 4, 'Roles', 'fa-user', 'auth/roles', NULL, NULL),
	(5, 2, 5, 'Permission', 'fa-user', 'auth/permissions', NULL, NULL),
	(6, 2, 6, 'Menu', 'fa-bars', 'auth/menu', NULL, NULL),
	(7, 2, 7, 'Operation log', 'fa-history', 'auth/logs', NULL, NULL),
	(8, 0, 8, 'Helpers', 'fa-gears', '', NULL, NULL),
	(9, 8, 9, 'Scaffold', 'fa-keyboard-o', 'helpers/scaffold', NULL, NULL),
	(10, 8, 10, 'Database terminal', 'fa-database', 'helpers/terminal/database', NULL, NULL),
	(11, 8, 11, 'Laravel artisan', 'fa-terminal', 'helpers/terminal/artisan', NULL, NULL),
	(12, 0, 0, '部门管理', 'fa-users', '/department', '2017-06-30 02:52:59', '2017-06-30 02:52:59'),
	(13, 12, 0, '部门列表', 'fa-bars', '/department/list', '2017-06-30 02:53:42', '2017-06-30 06:03:39'),
	(14, 12, 0, '添加部门', 'fa-plus', '/department/create', '2017-06-30 02:54:14', '2017-06-30 06:03:58'),
	(15, 0, 0, '人员管理', 'fa-user', '/menber', '2017-06-30 05:42:20', '2017-06-30 05:43:50'),
	(16, 15, 0, '人员列表', 'fa-bars', '/menber/list', '2017-06-30 05:42:53', '2017-06-30 06:04:26'),
	(17, 15, 0, '添加人员', 'fa-user-plus', '/menber/create', '2017-06-30 05:43:22', '2017-06-30 06:04:41'),
	(18, 0, 0, '客户管理', 'fa-user-secret', 'customer', '2017-06-30 05:49:38', '2017-06-30 05:52:03'),
	(19, 18, 0, '客户列表', 'fa-bars', '/customer/list', '2017-06-30 05:50:15', '2017-06-30 06:05:29'),
	(20, 0, 0, '权限管理', 'fa-hand-paper-o', '/permission', '2017-07-05 08:18:54', '2017-07-05 08:18:54');
/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;

-- 导出  表 fxst.admin_operation_log 结构
CREATE TABLE IF NOT EXISTS `admin_operation_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_operation_log_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=254 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.admin_operation_log 的数据：~215 rows (大约)
DELETE FROM `admin_operation_log`;
/*!40000 ALTER TABLE `admin_operation_log` DISABLE KEYS */;
INSERT INTO `admin_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`) VALUES
	(1, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-29 08:44:11', '2017-06-29 08:44:11'),
	(2, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-29 08:44:14', '2017-06-29 08:44:14'),
	(3, 1, 'admin', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-29 08:44:33', '2017-06-29 08:44:33'),
	(4, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-29 08:45:16', '2017-06-29 08:45:16'),
	(5, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-29 08:46:24', '2017-06-29 08:46:24'),
	(6, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-29 08:46:25', '2017-06-29 08:46:25'),
	(7, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-29 08:46:26', '2017-06-29 08:46:26'),
	(8, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-29 08:49:00', '2017-06-29 08:49:00'),
	(9, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-29 08:49:18', '2017-06-29 08:49:18'),
	(10, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-29 08:49:29', '2017-06-29 08:49:29'),
	(11, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-29 08:49:42', '2017-06-29 08:49:42'),
	(12, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-29 08:49:54', '2017-06-29 08:49:54'),
	(13, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-29 08:50:07', '2017-06-29 08:50:07'),
	(14, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-29 09:27:14', '2017-06-29 09:27:14'),
	(15, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-29 09:46:56', '2017-06-29 09:46:56'),
	(16, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 01:45:18', '2017-06-30 01:45:18'),
	(17, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 01:47:17', '2017-06-30 01:47:17'),
	(18, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:18:19', '2017-06-30 02:18:19'),
	(19, 1, 'admin/auth/roles/create', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:20:06', '2017-06-30 02:20:06'),
	(20, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:20:11', '2017-06-30 02:20:11'),
	(21, 1, 'admin/auth/users/create', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:20:14', '2017-06-30 02:20:14'),
	(22, 1, 'admin/auth/users/create', 'GET', '127.0.0.1', '[]', '2017-06-30 02:22:52', '2017-06-30 02:22:52'),
	(23, 1, 'admin/auth/users/create', 'GET', '127.0.0.1', '[]', '2017-06-30 02:22:54', '2017-06-30 02:22:54'),
	(24, 1, 'admin/auth/users/create', 'GET', '127.0.0.1', '[]', '2017-06-30 02:22:56', '2017-06-30 02:22:56'),
	(25, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:24:12', '2017-06-30 02:24:12'),
	(26, 1, 'admin/auth/roles/create', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:24:15', '2017-06-30 02:24:15'),
	(27, 1, 'admin/auth/roles', 'POST', '127.0.0.1', '{"slug":"main_account","name":"\\u4e3b\\u8d26\\u53f7","permissions":[null],"_token":"iFU0AkPSLBCP0s0XyLf8uDLFhkQLHUGlkreTtMzV","_previous_":"http:\\/\\/mytest.app\\/admin\\/auth\\/roles"}', '2017-06-30 02:26:00', '2017-06-30 02:26:00'),
	(28, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '[]', '2017-06-30 02:26:00', '2017-06-30 02:26:00'),
	(29, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:26:09', '2017-06-30 02:26:09'),
	(30, 1, 'admin/auth/permissions/create', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:26:11', '2017-06-30 02:26:11'),
	(31, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:26:16', '2017-06-30 02:26:16'),
	(32, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:26:25', '2017-06-30 02:26:25'),
	(33, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:26:33', '2017-06-30 02:26:33'),
	(34, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:26:36', '2017-06-30 02:26:36'),
	(35, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:26:38', '2017-06-30 02:26:38'),
	(36, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:26:43', '2017-06-30 02:26:43'),
	(37, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:26:45', '2017-06-30 02:26:45'),
	(38, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:27:09', '2017-06-30 02:27:09'),
	(39, 1, 'admin/auth/users/create', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:27:11', '2017-06-30 02:27:11'),
	(40, 1, 'admin/auth/users', 'POST', '127.0.0.1', '{"username":"jsjjb","name":"\\u6c5f\\u82cf\\u7ecf\\u6d4e\\u62a5","password":"123456","password_confirmation":"123456","roles":["2",null],"permissions":[null],"_token":"iFU0AkPSLBCP0s0XyLf8uDLFhkQLHUGlkreTtMzV","_previous_":"http:\\/\\/mytest.app\\/admin\\/auth\\/users"}', '2017-06-30 02:27:50', '2017-06-30 02:27:50'),
	(41, 1, 'admin/auth/users', 'GET', '127.0.0.1', '[]', '2017-06-30 02:27:50', '2017-06-30 02:27:50'),
	(42, 1, 'admin/auth/logout', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:28:06', '2017-06-30 02:28:06'),
	(43, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 02:28:18', '2017-06-30 02:28:18'),
	(44, 2, 'admin', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:28:22', '2017-06-30 02:28:22'),
	(45, 2, 'admin/auth/logout', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:41:40', '2017-06-30 02:41:40'),
	(46, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 02:42:04', '2017-06-30 02:42:04'),
	(47, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:09', '2017-06-30 02:42:09'),
	(48, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:18', '2017-06-30 02:42:18'),
	(49, 1, 'admin', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:20', '2017-06-30 02:42:20'),
	(50, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:22', '2017-06-30 02:42:22'),
	(51, 1, 'admin/auth/menu/1/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:24', '2017-06-30 02:42:24'),
	(52, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:30', '2017-06-30 02:42:30'),
	(53, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:32', '2017-06-30 02:42:32'),
	(54, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:34', '2017-06-30 02:42:34'),
	(55, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:36', '2017-06-30 02:42:36'),
	(56, 1, 'admin/auth/roles/1/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:38', '2017-06-30 02:42:38'),
	(57, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:40', '2017-06-30 02:42:40'),
	(58, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:42', '2017-06-30 02:42:42'),
	(59, 1, 'admin/auth/menu/8/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:49', '2017-06-30 02:42:49'),
	(60, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:51', '2017-06-30 02:42:51'),
	(61, 1, 'admin/auth/menu/2/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:42:55', '2017-06-30 02:42:55'),
	(62, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:43:31', '2017-06-30 02:43:31'),
	(63, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:43:34', '2017-06-30 02:43:34'),
	(64, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:43:34', '2017-06-30 02:43:34'),
	(65, 1, 'admin/auth/menu/2/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:43:38', '2017-06-30 02:43:38'),
	(66, 1, 'admin', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:43:44', '2017-06-30 02:43:44'),
	(67, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:45:10', '2017-06-30 02:45:10'),
	(68, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:45:33', '2017-06-30 02:45:33'),
	(69, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:45:51', '2017-06-30 02:45:51'),
	(70, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:46:06', '2017-06-30 02:46:06'),
	(71, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:46:10', '2017-06-30 02:46:10'),
	(72, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"0","title":"\\u90e8\\u95e8\\u7ba1\\u7406","icon":"fa-users","uri":"\\/department","roles":["2",null],"_token":"iFU0AkPSLBCP0s0XyLf8uDLFhkQLHUGlkreTtMzV"}', '2017-06-30 02:52:59', '2017-06-30 02:52:59'),
	(73, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 02:53:00', '2017-06-30 02:53:00'),
	(74, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"12","title":null,"icon":"fa-bars","uri":"\\/list","roles":[null],"_token":"iFU0AkPSLBCP0s0XyLf8uDLFhkQLHUGlkreTtMzV"}', '2017-06-30 02:53:30', '2017-06-30 02:53:30'),
	(75, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 02:53:30', '2017-06-30 02:53:30'),
	(76, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"12","title":"\\u90e8\\u95e8\\u5217\\u8868","icon":"fa-bars","uri":"\\/list","roles":[null],"_token":"iFU0AkPSLBCP0s0XyLf8uDLFhkQLHUGlkreTtMzV"}', '2017-06-30 02:53:42', '2017-06-30 02:53:42'),
	(77, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 02:53:42', '2017-06-30 02:53:42'),
	(78, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"12","title":"\\u6dfb\\u52a0\\u90e8\\u95e8","icon":"fa-bars","uri":"\\/create","roles":[null],"_token":"iFU0AkPSLBCP0s0XyLf8uDLFhkQLHUGlkreTtMzV"}', '2017-06-30 02:54:14', '2017-06-30 02:54:14'),
	(79, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 02:54:14', '2017-06-30 02:54:14'),
	(80, 1, 'admin/auth/menu/14/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:54:21', '2017-06-30 02:54:21'),
	(81, 1, 'admin/auth/menu/14', 'PUT', '127.0.0.1', '{"parent_id":"12","title":"\\u6dfb\\u52a0\\u90e8\\u95e8","icon":"fa-plus","uri":"\\/create","roles":[null],"_token":"iFU0AkPSLBCP0s0XyLf8uDLFhkQLHUGlkreTtMzV","_method":"PUT","_previous_":"http:\\/\\/mytest.app\\/admin\\/auth\\/menu"}', '2017-06-30 02:54:50', '2017-06-30 02:54:50'),
	(82, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 02:54:50', '2017-06-30 02:54:50'),
	(83, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 02:54:54', '2017-06-30 02:54:54'),
	(84, 1, 'admin/auth/menu/12/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:55:05', '2017-06-30 02:55:05'),
	(85, 1, 'admin/auth/menu/12/edit', 'GET', '127.0.0.1', '[]', '2017-06-30 02:55:15', '2017-06-30 02:55:15'),
	(86, 1, 'admin/auth/menu/12/edit', 'GET', '127.0.0.1', '[]', '2017-06-30 02:55:17', '2017-06-30 02:55:17'),
	(87, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:55:26', '2017-06-30 02:55:26'),
	(88, 1, 'admin/auth/users/create', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:55:33', '2017-06-30 02:55:33'),
	(89, 1, 'admin/auth/users', 'POST', '127.0.0.1', '{"username":"admin2","name":"admin2","password":"123456","password_confirmation":"123456","roles":["1",null],"permissions":[null],"_token":"iFU0AkPSLBCP0s0XyLf8uDLFhkQLHUGlkreTtMzV","_previous_":"http:\\/\\/mytest.app\\/admin\\/auth\\/users"}', '2017-06-30 02:55:48', '2017-06-30 02:55:48'),
	(90, 1, 'admin/auth/users', 'GET', '127.0.0.1', '[]', '2017-06-30 02:55:48', '2017-06-30 02:55:48'),
	(91, 1, 'admin/auth/logout', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:56:00', '2017-06-30 02:56:00'),
	(92, 3, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 02:56:11', '2017-06-30 02:56:11'),
	(93, 3, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 02:56:20', '2017-06-30 02:56:20'),
	(94, 3, 'admin/auth/users/3', 'DELETE', '127.0.0.1', '{"_method":"delete","_token":"iFU0AkPSLBCP0s0XyLf8uDLFhkQLHUGlkreTtMzV"}', '2017-06-30 02:56:27', '2017-06-30 02:56:27'),
	(95, 1, 'admin/auth/users', 'GET', '127.0.0.1', '[]', '2017-06-30 02:56:39', '2017-06-30 02:56:39'),
	(96, 1, 'admin/auth/users', 'GET', '127.0.0.1', '[]', '2017-06-30 02:58:04', '2017-06-30 02:58:04'),
	(97, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 02:58:06', '2017-06-30 02:58:06'),
	(98, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 03:08:41', '2017-06-30 03:08:41'),
	(99, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 03:08:43', '2017-06-30 03:08:43'),
	(100, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 03:09:06', '2017-06-30 03:09:06'),
	(101, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 03:09:18', '2017-06-30 03:09:18'),
	(102, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 03:09:46', '2017-06-30 03:09:46'),
	(103, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 03:14:15', '2017-06-30 03:14:15'),
	(104, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 03:16:29', '2017-06-30 03:16:29'),
	(105, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 03:17:08', '2017-06-30 03:17:08'),
	(106, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 03:18:57', '2017-06-30 03:18:57'),
	(107, 1, 'admin', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 03:19:10', '2017-06-30 03:19:10'),
	(108, 1, 'admin/auth/logout', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 03:20:09', '2017-06-30 03:20:09'),
	(109, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 03:20:17', '2017-06-30 03:20:17'),
	(110, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 03:20:34', '2017-06-30 03:20:34'),
	(111, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 05:39:53', '2017-06-30 05:39:53'),
	(112, 2, 'admin/auth/logout', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 05:40:41', '2017-06-30 05:40:41'),
	(113, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 05:40:46', '2017-06-30 05:40:46'),
	(114, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 05:40:58', '2017-06-30 05:40:58'),
	(115, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"0","title":"\\u4eba\\u5458\\u7ba1\\u7406","icon":"fa-bars","uri":"\\/menber","roles":["2",null],"_token":"o2l1KRQf29OrmexDCtRcMijiZ4opkSNiQxmsTJPk"}', '2017-06-30 05:42:20', '2017-06-30 05:42:20'),
	(116, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 05:42:21', '2017-06-30 05:42:21'),
	(117, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"15","title":"\\u4eba\\u5458\\u5217\\u8868","icon":"fa-bars","uri":"list","roles":["2",null],"_token":"o2l1KRQf29OrmexDCtRcMijiZ4opkSNiQxmsTJPk"}', '2017-06-30 05:42:53', '2017-06-30 05:42:53'),
	(118, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 05:42:53', '2017-06-30 05:42:53'),
	(119, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"15","title":"\\u6dfb\\u52a0\\u4eba\\u5458","icon":"fa-bars","uri":"create","roles":[null],"_token":"o2l1KRQf29OrmexDCtRcMijiZ4opkSNiQxmsTJPk"}', '2017-06-30 05:43:22', '2017-06-30 05:43:22'),
	(120, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 05:43:22', '2017-06-30 05:43:22'),
	(121, 1, 'admin/auth/menu/15/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 05:43:27', '2017-06-30 05:43:27'),
	(122, 1, 'admin/auth/menu/15', 'PUT', '127.0.0.1', '{"parent_id":"0","title":"\\u4eba\\u5458\\u7ba1\\u7406","icon":"fa-user","uri":"\\/menber","roles":["2",null],"_token":"o2l1KRQf29OrmexDCtRcMijiZ4opkSNiQxmsTJPk","_method":"PUT","_previous_":"http:\\/\\/mytest.app\\/admin\\/auth\\/menu"}', '2017-06-30 05:43:50', '2017-06-30 05:43:50'),
	(123, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 05:43:50', '2017-06-30 05:43:50'),
	(124, 1, 'admin/auth/menu/17/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 05:43:54', '2017-06-30 05:43:54'),
	(125, 1, 'admin/auth/menu/17', 'PUT', '127.0.0.1', '{"parent_id":"15","title":"\\u6dfb\\u52a0\\u4eba\\u5458","icon":"fa-user-plus","uri":"create","roles":[null],"_token":"o2l1KRQf29OrmexDCtRcMijiZ4opkSNiQxmsTJPk","_method":"PUT","_previous_":"http:\\/\\/mytest.app\\/admin\\/auth\\/menu"}', '2017-06-30 05:44:01', '2017-06-30 05:44:01'),
	(126, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 05:44:01', '2017-06-30 05:44:01'),
	(127, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 05:44:05', '2017-06-30 05:44:05'),
	(128, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"0","title":"\\u5ba2\\u6237\\u7ba1\\u7406","icon":"fa-bars","uri":"customer","roles":["2",null],"_token":"o2l1KRQf29OrmexDCtRcMijiZ4opkSNiQxmsTJPk"}', '2017-06-30 05:49:38', '2017-06-30 05:49:38'),
	(129, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 05:49:39', '2017-06-30 05:49:39'),
	(130, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"18","title":"\\u5ba2\\u6237\\u5217\\u8868","icon":"fa-bars","uri":"list","roles":[null],"_token":"o2l1KRQf29OrmexDCtRcMijiZ4opkSNiQxmsTJPk"}', '2017-06-30 05:50:14', '2017-06-30 05:50:14'),
	(131, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 05:50:15', '2017-06-30 05:50:15'),
	(132, 1, 'admin/auth/menu/18/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 05:50:19', '2017-06-30 05:50:19'),
	(133, 1, 'admin/auth/menu/18', 'PUT', '127.0.0.1', '{"parent_id":"0","title":"\\u5ba2\\u6237\\u7ba1\\u7406","icon":"fa-user-secret","uri":"customer","roles":["2",null],"_token":"o2l1KRQf29OrmexDCtRcMijiZ4opkSNiQxmsTJPk","_method":"PUT","_previous_":"http:\\/\\/mytest.app\\/admin\\/auth\\/menu"}', '2017-06-30 05:52:03', '2017-06-30 05:52:03'),
	(134, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 05:52:03', '2017-06-30 05:52:03'),
	(135, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 05:52:09', '2017-06-30 05:52:09'),
	(136, 1, 'admin/auth/menu/12/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:03:15', '2017-06-30 06:03:15'),
	(137, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:03:22', '2017-06-30 06:03:22'),
	(138, 1, 'admin/auth/menu/13/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:03:26', '2017-06-30 06:03:26'),
	(139, 1, 'admin/auth/menu/13', 'PUT', '127.0.0.1', '{"parent_id":"12","title":"\\u90e8\\u95e8\\u5217\\u8868","icon":"fa-bars","uri":"\\/department\\/list","roles":[null],"_token":"o2l1KRQf29OrmexDCtRcMijiZ4opkSNiQxmsTJPk","_method":"PUT","_previous_":"http:\\/\\/mytest.app\\/admin\\/auth\\/menu"}', '2017-06-30 06:03:39', '2017-06-30 06:03:39'),
	(140, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 06:03:39', '2017-06-30 06:03:39'),
	(141, 1, 'admin/auth/menu/14/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:03:49', '2017-06-30 06:03:49'),
	(142, 1, 'admin/auth/menu/14', 'PUT', '127.0.0.1', '{"parent_id":"12","title":"\\u6dfb\\u52a0\\u90e8\\u95e8","icon":"fa-plus","uri":"\\/department\\/create","roles":[null],"_token":"o2l1KRQf29OrmexDCtRcMijiZ4opkSNiQxmsTJPk","_method":"PUT","_previous_":"http:\\/\\/mytest.app\\/admin\\/auth\\/menu"}', '2017-06-30 06:03:57', '2017-06-30 06:03:57'),
	(143, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 06:03:58', '2017-06-30 06:03:58'),
	(144, 1, 'admin/auth/menu/15/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:04:02', '2017-06-30 06:04:02'),
	(145, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:04:05', '2017-06-30 06:04:05'),
	(146, 1, 'admin/auth/menu/16/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:04:08', '2017-06-30 06:04:08'),
	(147, 1, 'admin/auth/menu/16', 'PUT', '127.0.0.1', '{"parent_id":"15","title":"\\u4eba\\u5458\\u5217\\u8868","icon":"fa-bars","uri":"\\/menber\\/list","roles":["2",null],"_token":"o2l1KRQf29OrmexDCtRcMijiZ4opkSNiQxmsTJPk","_method":"PUT","_previous_":"http:\\/\\/mytest.app\\/admin\\/auth\\/menu"}', '2017-06-30 06:04:25', '2017-06-30 06:04:25'),
	(148, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 06:04:26', '2017-06-30 06:04:26'),
	(149, 1, 'admin/auth/menu/17/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:04:31', '2017-06-30 06:04:31'),
	(150, 1, 'admin/auth/menu/17', 'PUT', '127.0.0.1', '{"parent_id":"15","title":"\\u6dfb\\u52a0\\u4eba\\u5458","icon":"fa-user-plus","uri":"\\/menber\\/create","roles":[null],"_token":"o2l1KRQf29OrmexDCtRcMijiZ4opkSNiQxmsTJPk","_method":"PUT","_previous_":"http:\\/\\/mytest.app\\/admin\\/auth\\/menu"}', '2017-06-30 06:04:41', '2017-06-30 06:04:41'),
	(151, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 06:04:41', '2017-06-30 06:04:41'),
	(152, 1, 'admin/auth/menu/19/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:05:05', '2017-06-30 06:05:05'),
	(153, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:05:11', '2017-06-30 06:05:11'),
	(154, 1, 'admin/auth/menu/18/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:05:14', '2017-06-30 06:05:14'),
	(155, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:05:18', '2017-06-30 06:05:18'),
	(156, 1, 'admin/auth/menu/19/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:05:20', '2017-06-30 06:05:20'),
	(157, 1, 'admin/auth/menu/19', 'PUT', '127.0.0.1', '{"parent_id":"18","title":"\\u5ba2\\u6237\\u5217\\u8868","icon":"fa-bars","uri":"\\/customer\\/list","roles":[null],"_token":"o2l1KRQf29OrmexDCtRcMijiZ4opkSNiQxmsTJPk","_method":"PUT","_previous_":"http:\\/\\/mytest.app\\/admin\\/auth\\/menu"}', '2017-06-30 06:05:29', '2017-06-30 06:05:29'),
	(158, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 06:05:29', '2017-06-30 06:05:29'),
	(159, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-06-30 06:05:35', '2017-06-30 06:05:35'),
	(160, 1, 'admin/auth/logout', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:05:40', '2017-06-30 06:05:40'),
	(161, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 06:05:48', '2017-06-30 06:05:48'),
	(162, 2, 'admin', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-06-30 06:24:04', '2017-06-30 06:24:04'),
	(163, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-06-30 06:24:06', '2017-06-30 06:24:06'),
	(164, 2, 'admin/auth/users', 'GET', '127.0.0.1', '[]', '2017-06-30 06:28:06', '2017-06-30 06:28:06'),
	(165, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-04 08:56:37', '2017-07-04 08:56:37'),
	(166, 2, 'admin/auth/login', 'GET', '127.0.0.1', '[]', '2017-07-04 08:58:58', '2017-07-04 08:58:58'),
	(167, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-05 08:02:04', '2017-07-05 08:02:04'),
	(168, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-05 08:02:09', '2017-07-05 08:02:09'),
	(169, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"0","title":"\\u6743\\u9650\\u7ba1\\u7406","icon":"fa-hand-paper-o","uri":"\\/permission","roles":["2",null],"_token":"SWrE7binztyhjuf59roFO0dtbmEDTDYe4eLvWrT7"}', '2017-07-05 08:18:53', '2017-07-05 08:18:53'),
	(170, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-05 08:18:54', '2017-07-05 08:18:54'),
	(171, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-05 08:18:57', '2017-07-05 08:18:57'),
	(172, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-05 08:20:49', '2017-07-05 08:20:49'),
	(173, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-05 08:20:50', '2017-07-05 08:20:50'),
	(174, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-06 06:48:53', '2017-07-06 06:48:53'),
	(175, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-06 06:48:58', '2017-07-06 06:48:58'),
	(176, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-06 07:17:20', '2017-07-06 07:17:20'),
	(177, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-10 09:32:19', '2017-07-10 09:32:19'),
	(178, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-10 09:32:23', '2017-07-10 09:32:23'),
	(179, 1, 'admin/auth/menu/10/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-10 09:32:32', '2017-07-10 09:32:32'),
	(180, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-10 09:32:35', '2017-07-10 09:32:35'),
	(181, 1, 'admin/auth/menu/8/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-10 09:32:38', '2017-07-10 09:32:38'),
	(182, 1, 'admin/auth/logout', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-10 09:32:50', '2017-07-10 09:32:50'),
	(183, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-10 09:32:58', '2017-07-10 09:32:58'),
	(184, 2, 'admin/auth/users', 'GET', '127.0.0.1', '[]', '2017-07-10 09:33:03', '2017-07-10 09:33:03'),
	(185, 2, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-10 09:34:15', '2017-07-10 09:34:15'),
	(186, 2, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-10 09:34:37', '2017-07-10 09:34:37'),
	(187, 2, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-10 09:34:38', '2017-07-10 09:34:38'),
	(188, 2, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-10 09:34:56', '2017-07-10 09:34:56'),
	(189, 2, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-10 09:35:05', '2017-07-10 09:35:05'),
	(190, 2, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-10 09:35:14', '2017-07-10 09:35:14'),
	(191, 2, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-10 09:35:15', '2017-07-10 09:35:15'),
	(192, 2, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-10 09:35:27', '2017-07-10 09:35:27'),
	(193, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-12 08:53:01', '2017-07-12 08:53:01'),
	(194, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-12 08:53:07', '2017-07-12 08:53:07'),
	(195, 1, 'admin/auth/menu/3/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-12 08:53:13', '2017-07-12 08:53:13'),
	(196, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-12 08:53:15', '2017-07-12 08:53:15'),
	(197, 1, 'admin/auth/menu/12/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-12 08:53:20', '2017-07-12 08:53:20'),
	(198, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-12 09:06:05', '2017-07-12 09:06:05'),
	(199, 1, 'admin/auth/menu/12/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-12 09:06:12', '2017-07-12 09:06:12'),
	(200, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-13 01:19:47', '2017-07-13 01:19:47'),
	(201, 2, 'admin', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-13 01:19:58', '2017-07-13 01:19:58'),
	(202, 2, 'admin/auth/permissions', 'GET', '127.0.0.1', '[]', '2017-07-13 01:20:18', '2017-07-13 01:20:18'),
	(203, 2, 'admin/auth/logout', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-13 01:20:42', '2017-07-13 01:20:42'),
	(204, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-13 01:20:52', '2017-07-13 01:20:52'),
	(205, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-13 01:20:56', '2017-07-13 01:20:56'),
	(206, 1, 'admin/auth/permissions/create', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-13 01:21:00', '2017-07-13 01:21:00'),
	(207, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-13 01:21:02', '2017-07-13 01:21:02'),
	(208, 1, 'admin/auth/users/2/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-13 01:21:06', '2017-07-13 01:21:06'),
	(209, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-13 02:07:31', '2017-07-13 02:07:31'),
	(210, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-13 02:07:34', '2017-07-13 02:07:34'),
	(211, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-13 02:07:37', '2017-07-13 02:07:37'),
	(212, 1, 'admin/auth/menu/19/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-13 02:07:42', '2017-07-13 02:07:42'),
	(213, 1, 'admin/auth/menu/19/edit', 'GET', '127.0.0.1', '[]', '2017-07-13 02:08:01', '2017-07-13 02:08:01'),
	(214, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-13 02:08:23', '2017-07-13 02:08:23'),
	(215, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-13 02:08:59', '2017-07-13 02:08:59'),
	(216, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-17 14:11:50', '2017-07-17 14:11:50'),
	(217, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-17 14:11:55', '2017-07-17 14:11:55'),
	(218, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-28 13:50:54', '2017-07-28 13:50:54'),
	(219, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:51:01', '2017-07-28 13:51:01'),
	(220, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:51:09', '2017-07-28 13:51:09'),
	(221, 1, 'admin/auth/menu/15/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:51:15', '2017-07-28 13:51:15'),
	(222, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:51:25', '2017-07-28 13:51:25'),
	(223, 1, 'admin/auth/logout', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:51:37', '2017-07-28 13:51:37'),
	(224, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-28 13:51:45', '2017-07-28 13:51:45'),
	(225, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-28 13:53:10', '2017-07-28 13:53:10'),
	(226, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-28 13:53:13', '2017-07-28 13:53:13'),
	(227, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-28 13:53:16', '2017-07-28 13:53:16'),
	(228, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-28 13:53:43', '2017-07-28 13:53:43'),
	(229, 2, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:53:51', '2017-07-28 13:53:51'),
	(230, 2, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-28 13:53:54', '2017-07-28 13:53:54'),
	(231, 2, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-28 13:53:55', '2017-07-28 13:53:55'),
	(232, 2, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-28 13:53:57', '2017-07-28 13:53:57'),
	(233, 2, 'admin/auth/logout', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:54:05', '2017-07-28 13:54:05'),
	(234, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-28 13:54:09', '2017-07-28 13:54:09'),
	(235, 2, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:54:21', '2017-07-28 13:54:21'),
	(236, 2, 'admin/helpers/terminal/database', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:54:26', '2017-07-28 13:54:26'),
	(237, 2, 'admin/helpers/scaffold', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:54:29', '2017-07-28 13:54:29'),
	(238, 2, 'admin/auth/users', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:54:31', '2017-07-28 13:54:31'),
	(239, 2, 'admin/auth/logout', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:54:46', '2017-07-28 13:54:46'),
	(240, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-28 13:54:54', '2017-07-28 13:54:54'),
	(241, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:54:57', '2017-07-28 13:54:57'),
	(242, 1, 'admin/auth/menu/15/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:55:04', '2017-07-28 13:55:04'),
	(243, 1, 'admin/auth/menu/15', 'PUT', '127.0.0.1', '{"parent_id":"0","title":"\\u4eba\\u5458\\u7ba1\\u7406","icon":"fa-user","uri":"\\/menber","roles":["2",null],"_token":"tZqZgpoRTXDzYlUcl9RMEf77YgyI0vf7xJJi5Gwu","_method":"PUT","_previous_":"http:\\/\\/fxst.app\\/admin\\/auth\\/menu"}', '2017-07-28 13:55:08', '2017-07-28 13:55:08'),
	(244, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-28 13:55:08', '2017-07-28 13:55:08'),
	(245, 1, 'admin/auth/menu/12/edit', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:55:16', '2017-07-28 13:55:16'),
	(246, 1, 'admin/auth/menu/12', 'PUT', '127.0.0.1', '{"parent_id":"0","title":"\\u90e8\\u95e8\\u7ba1\\u7406","icon":"fa-users","uri":"\\/department","roles":["1",null],"_token":"tZqZgpoRTXDzYlUcl9RMEf77YgyI0vf7xJJi5Gwu","_method":"PUT","_previous_":"http:\\/\\/fxst.app\\/admin\\/auth\\/menu"}', '2017-07-28 13:55:48', '2017-07-28 13:55:48'),
	(247, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2017-07-28 13:55:48', '2017-07-28 13:55:48'),
	(248, 1, 'admin/auth/logout', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-07-28 13:55:53', '2017-07-28 13:55:53'),
	(249, 2, 'admin', 'GET', '127.0.0.1', '[]', '2017-07-28 13:56:01', '2017-07-28 13:56:01'),
	(250, 1, 'admin', 'GET', '127.0.0.1', '[]', '2017-08-01 10:37:23', '2017-08-01 10:37:23'),
	(251, 1, 'admin/helpers/terminal/database', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-08-01 10:37:32', '2017-08-01 10:37:32'),
	(252, 1, 'admin/helpers/terminal/artisan', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-08-01 10:37:36', '2017-08-01 10:37:36'),
	(253, 1, 'admin/helpers/terminal/artisan', 'POST', '127.0.0.1', '{"c":"route:list","_token":"bCjid7Nj62iHotFP8wz2S6KiwfWsTnSkI2bkjyCD"}', '2017-08-01 10:37:57', '2017-08-01 10:37:57');
/*!40000 ALTER TABLE `admin_operation_log` ENABLE KEYS */;

-- 导出  表 fxst.admin_permissions 结构
CREATE TABLE IF NOT EXISTS `admin_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.admin_permissions 的数据：~0 rows (大约)
DELETE FROM `admin_permissions`;
/*!40000 ALTER TABLE `admin_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_permissions` ENABLE KEYS */;

-- 导出  表 fxst.admin_roles 结构
CREATE TABLE IF NOT EXISTS `admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.admin_roles 的数据：~2 rows (大约)
DELETE FROM `admin_roles`;
/*!40000 ALTER TABLE `admin_roles` DISABLE KEYS */;
INSERT INTO `admin_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator', 'administrator', '2017-06-29 08:40:10', '2017-06-29 08:40:10'),
	(2, '主账号', 'main_account', '2017-06-30 02:26:00', '2017-06-30 02:26:00');
/*!40000 ALTER TABLE `admin_roles` ENABLE KEYS */;

-- 导出  表 fxst.admin_role_menu 结构
CREATE TABLE IF NOT EXISTS `admin_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.admin_role_menu 的数据：~2 rows (大约)
DELETE FROM `admin_role_menu`;
/*!40000 ALTER TABLE `admin_role_menu` DISABLE KEYS */;
INSERT INTO `admin_role_menu` (`role_id`, `menu_id`, `created_at`, `updated_at`) VALUES
	(2, 15, NULL, NULL),
	(1, 12, NULL, NULL);
/*!40000 ALTER TABLE `admin_role_menu` ENABLE KEYS */;

-- 导出  表 fxst.admin_role_permissions 结构
CREATE TABLE IF NOT EXISTS `admin_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.admin_role_permissions 的数据：~0 rows (大约)
DELETE FROM `admin_role_permissions`;
/*!40000 ALTER TABLE `admin_role_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_role_permissions` ENABLE KEYS */;

-- 导出  表 fxst.admin_role_users 结构
CREATE TABLE IF NOT EXISTS `admin_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.admin_role_users 的数据：~3 rows (大约)
DELETE FROM `admin_role_users`;
/*!40000 ALTER TABLE `admin_role_users` DISABLE KEYS */;
INSERT INTO `admin_role_users` (`role_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, NULL),
	(2, 2, NULL, NULL),
	(1, 3, NULL, NULL);
/*!40000 ALTER TABLE `admin_role_users` ENABLE KEYS */;

-- 导出  表 fxst.admin_users 结构
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.admin_users 的数据：~2 rows (大约)
DELETE FROM `admin_users`;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin', '$2y$10$co9aCs4daGHX41oyGdTmbu7IfGZN1y7gHdDfsUh9BQJ45RvV0kUxC', 'Administrator', NULL, 'HkRsiNLt0Qfl3cbQM7PHUnECTapW5ykp6LWd05pxcqTiN21QfBLIkLXjcGzA', '2017-06-29 08:40:10', '2017-06-29 08:40:10'),
	(2, 'jsjjb', '$2y$10$xtz9YfNcgMSsaJMfXMMKiuGkPhw3FVqyY1zKiY0qVCkcqvxG0EE7G', '江苏经济报', 'image/5d78d563gy1fdm4c6qsi9j20aw09adgk.jpg', 'rHhJSwunoN5wf3qbeQWq24Vv5CuPImd2p6TehPMu3kJh5IxM30WftdUkmty2', '2017-06-30 02:27:50', '2017-06-30 02:27:50');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;

-- 导出  表 fxst.admin_user_permissions 结构
CREATE TABLE IF NOT EXISTS `admin_user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.admin_user_permissions 的数据：~0 rows (大约)
DELETE FROM `admin_user_permissions`;
/*!40000 ALTER TABLE `admin_user_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_user_permissions` ENABLE KEYS */;

-- 导出  表 fxst.baoshes 结构
CREATE TABLE IF NOT EXISTS `baoshes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '主账号ID',
  `name` varchar(50) NOT NULL COMMENT '报社名称',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='报社';

-- 正在导出表  fxst.baoshes 的数据：2 rows
DELETE FROM `baoshes`;
/*!40000 ALTER TABLE `baoshes` DISABLE KEYS */;
INSERT INTO `baoshes` (`id`, `user_id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 2, '江苏经济报社', '2017-08-14 15:12:04', '2017-08-14 15:12:04'),
	(2, 2, '都市报社', '2017-08-14 15:12:04', '2017-08-14 15:12:04');
/*!40000 ALTER TABLE `baoshes` ENABLE KEYS */;

-- 导出  表 fxst.check_details 结构
CREATE TABLE IF NOT EXISTS `check_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '主账号ID',
  `u_id` int(10) unsigned NOT NULL COMMENT '账号ID',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '变动金额',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '变动类型',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分成列表';

-- 正在导出表  fxst.check_details 的数据：0 rows
DELETE FROM `check_details`;
/*!40000 ALTER TABLE `check_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `check_details` ENABLE KEYS */;

-- 导出  表 fxst.customers 结构
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '客户名称',
  `address` varchar(255) DEFAULT NULL COMMENT '客户（寄送）地址',
  `type` tinyint(1) DEFAULT '0' COMMENT '性质（个人0单位1）',
  `contacts` varchar(255) DEFAULT NULL COMMENT '联系人',
  `mobile` varchar(255) DEFAULT NULL COMMENT '电话/手机',
  `source` varchar(50) DEFAULT NULL COMMENT '来源',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- 正在导出表  fxst.customers 的数据：2 rows
DELETE FROM `customers`;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` (`id`, `name`, `address`, `type`, `contacts`, `mobile`, `source`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, '客户1', '客户地址1', 0, '客户1', '123456789', NULL, 2, '2017-08-14 15:12:04', '2017-08-14 15:12:04'),
	(2, '客户2', '客户地址2', 1, '客户2', '123456798', NULL, 2, '2017-08-14 15:12:04', '2017-08-14 15:12:04');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

-- 导出  表 fxst.customer_piaos 结构
CREATE TABLE IF NOT EXISTS `customer_piaos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `c_id` int(10) unsigned NOT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `hao` varchar(50) DEFAULT NULL COMMENT '纳税识别号',
  `addr` varchar(50) DEFAULT NULL COMMENT '地址',
  `phone` varchar(50) DEFAULT NULL COMMENT '电话',
  `bank` varchar(50) DEFAULT NULL COMMENT '银行',
  `bank_account` varchar(50) DEFAULT NULL COMMENT '账号',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- 正在导出表  fxst.customer_piaos 的数据：2 rows
DELETE FROM `customer_piaos`;
/*!40000 ALTER TABLE `customer_piaos` DISABLE KEYS */;
INSERT INTO `customer_piaos` (`id`, `user_id`, `c_id`, `name`, `hao`, `addr`, `phone`, `bank`, `bank_account`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, '开票名称1', '999999999', '开票地址1', '123456789', '工行', '66666123456789', '2017-08-14 15:12:04', '2017-08-14 15:12:04'),
	(2, 2, 2, '开票名称2', '999999999', '开票地址2', '123456789', '建行', '66666123456798', '2017-08-14 15:12:04', '2017-08-14 15:12:04');
/*!40000 ALTER TABLE `customer_piaos` ENABLE KEYS */;

-- 导出  表 fxst.departments 结构
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0' COMMENT '上级部门ID',
  `user_id` int(11) DEFAULT NULL COMMENT '主账号ID',
  `menber_count` int(11) DEFAULT '0' COMMENT '部门人数',
  `name` varchar(50) DEFAULT NULL COMMENT '部门名称',
  `order` int(11) DEFAULT NULL COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='部门表';

-- 正在导出表  fxst.departments 的数据：4 rows
DELETE FROM `departments`;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` (`id`, `parent_id`, `user_id`, `menber_count`, `name`, `order`, `created_at`, `updated_at`) VALUES
	(1, 0, 2, 1, '江苏经济报社', NULL, '2017-08-14 15:12:04', '2017-08-14 15:12:04'),
	(2, 0, 2, 0, '都市报社', NULL, '2017-08-14 15:12:04', '2017-08-14 15:12:04'),
	(3, 1, 2, 1, '记者部', NULL, '2017-08-14 15:12:04', '2017-08-14 15:12:04'),
	(4, 0, 2, 1, '记者部', NULL, '2017-08-14 15:12:04', '2017-08-14 15:12:04');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;

-- 导出  表 fxst.d_performance 结构
CREATE TABLE IF NOT EXISTS `d_performance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '主账号ID',
  `d` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='部门业绩表';

-- 正在导出表  fxst.d_performance 的数据：0 rows
DELETE FROM `d_performance`;
/*!40000 ALTER TABLE `d_performance` DISABLE KEYS */;
/*!40000 ALTER TABLE `d_performance` ENABLE KEYS */;

-- 导出  表 fxst.d_pers 结构
CREATE TABLE IF NOT EXISTS `d_pers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `p_id` int(10) unsigned NOT NULL COMMENT '刊物ID',
  `d_id` int(10) unsigned NOT NULL COMMENT '部门ID',
  `per` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '百分比',
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='部门分成比例表';

-- 正在导出表  fxst.d_pers 的数据：2 rows
DELETE FROM `d_pers`;
/*!40000 ALTER TABLE `d_pers` DISABLE KEYS */;
INSERT INTO `d_pers` (`id`, `p_id`, `d_id`, `per`, `user_id`) VALUES
	(1, 9, 3, 11.00, 2),
	(2, 5, 3, 7.00, 2);
/*!40000 ALTER TABLE `d_pers` ENABLE KEYS */;

-- 导出  表 fxst.d_targets 结构
CREATE TABLE IF NOT EXISTS `d_targets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `d_id` int(10) unsigned NOT NULL COMMENT '部门',
  `p_id` int(10) unsigned NOT NULL COMMENT '刊物',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户ID',
  `num` int(11) NOT NULL COMMENT '目标份数',
  `numed` int(11) DEFAULT '0' COMMENT '已完成份数',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='部门目标';

-- 正在导出表  fxst.d_targets 的数据：2 rows
DELETE FROM `d_targets`;
/*!40000 ALTER TABLE `d_targets` DISABLE KEYS */;
INSERT INTO `d_targets` (`id`, `d_id`, `p_id`, `user_id`, `num`, `numed`, `updated_at`, `created_at`) VALUES
	(1, 3, 5, 2, 500, 100, NULL, NULL),
	(2, 3, 9, 2, 502, 10, '2017-07-18 05:20:13', '2017-07-16 03:30:26');
/*!40000 ALTER TABLE `d_targets` ENABLE KEYS */;

-- 导出  表 fxst.front_menu 结构
CREATE TABLE IF NOT EXISTS `front_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.front_menu 的数据：~31 rows (大约)
DELETE FROM `front_menu`;
/*!40000 ALTER TABLE `front_menu` DISABLE KEYS */;
INSERT INTO `front_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `created_at`, `updated_at`) VALUES
	(1, 0, 1, '首页', 'fa-bar-chart', '/', NULL, '2017-07-28 16:15:19'),
	(12, 0, 11, '部门管理', 'fa-users', 'department', '2017-06-30 02:52:59', '2017-08-09 11:29:57'),
	(13, 12, 12, '部门列表', 'fa-bars', '/department', '2017-06-30 02:53:42', '2017-08-09 11:29:58'),
	(14, 12, 13, '添加部门', 'fa-plus', '/department/create', '2017-06-30 02:54:14', '2017-08-09 11:29:59'),
	(15, 0, 14, '人员管理', 'fa-user', 'menber', '2017-06-30 05:42:20', '2017-08-09 11:30:00'),
	(16, 15, 15, '人员列表', 'fa-bars', '/menber', '2017-06-30 05:42:53', '2017-08-09 11:30:01'),
	(17, 15, 16, '添加人员', 'fa-user-plus', '/menber/create', '2017-06-30 05:43:22', '2017-08-09 11:30:02'),
	(18, 0, 20, '客户管理', 'fa-user-secret', 'customer', '2017-06-30 05:49:38', '2017-08-09 11:30:05'),
	(19, 18, 21, '客户列表', 'fa-bars', '/customer', '2017-06-30 05:50:15', '2017-08-09 11:30:06'),
	(21, 18, 22, '添加客户', 'fa-user-plus', '/customer/create', '2017-07-13 05:53:32', '2017-08-09 11:30:07'),
	(22, 0, 8, '刊物管理', 'fa-book', '/periodical', '2017-07-13 06:45:17', '2017-08-09 11:29:54'),
	(23, 22, 9, '刊物列表', 'fa-bars', '/periodical', '2017-07-13 06:45:51', '2017-08-09 11:29:55'),
	(24, 22, 10, '添加刊物', 'fa-plus', '/periodical/create', '2017-07-13 06:47:42', '2017-08-09 11:29:56'),
	(25, 0, 17, '目标管理', 'fa-percent', '/target', '2017-07-13 09:54:16', '2017-08-09 11:30:02'),
	(26, 25, 18, '目标列表', 'fa-bars', '/target', '2017-07-13 09:55:01', '2017-08-09 11:30:03'),
	(28, 0, 23, '财务管理', 'fa-money', '/finance', '2017-07-14 11:10:27', '2017-08-09 11:30:07'),
	(29, 28, 24, '订单列表', 'fa-bars', '/finance/input', '2017-07-16 15:34:08', '2017-08-09 11:30:09'),
	(30, 28, 25, '订单录入', 'fa-plus', '/finance/input/create', '2017-07-16 15:35:33', '2017-08-09 11:30:10'),
	(31, 0, 26, '业绩管理', 'fa-bars', '/performance', '2017-07-18 09:40:23', '2017-08-09 11:30:10'),
	(32, 31, 27, '业绩结算', 'fa-dollar', '/performance/checkout', '2017-07-18 09:41:18', '2017-08-09 11:30:11'),
	(35, 0, 2, '基本设置', 'fa-database', '/system', '2017-07-26 09:30:22', '2017-07-27 13:53:43'),
	(36, 35, 3, '信息设置', 'fa-bars', '/system/jconfig', '2017-07-26 09:30:47', '2017-07-27 13:53:43'),
	(37, 0, 5, '报社管理', 'fa-book', '/system/baoshe', '2017-07-27 13:50:53', '2017-08-09 11:29:51'),
	(38, 37, 7, '添加报社', 'fa-plus', '/system/baoshe/create', '2017-07-27 13:51:59', '2017-08-09 11:29:53'),
	(39, 37, 6, '报社列表', 'fa-bars', '/system/baoshe', '2017-07-27 13:52:28', '2017-08-09 11:29:52'),
	(40, 0, 28, '管理员设置', 'fa-user-md', '/auth/users', '2017-07-27 17:49:16', '2017-08-09 11:30:12'),
	(41, 40, 29, '管理员列表', 'fa-bars', '/auth/users', '2017-07-27 17:49:42', '2017-08-09 11:30:13'),
	(42, 40, 30, '添加管理员', 'fa-plus', '/auth/users/create', '2017-07-27 17:50:30', '2017-08-09 11:30:14'),
	(43, 35, 4, '支付方式设置', 'fa-bars', '/system/zhifu', '2017-08-01 09:07:43', '2017-08-01 13:07:58'),
	(45, 25, 19, '添加主目标', 'fa-plus', '/target/create', '2017-08-01 17:31:27', '2017-08-09 11:30:04'),
	(46, 35, 0, '客户性质设置', 'fa-bars', '/system/customer_type', '2017-08-11 13:22:34', '2017-08-11 13:22:34');
/*!40000 ALTER TABLE `front_menu` ENABLE KEYS */;

-- 导出  表 fxst.front_operation_log 结构
CREATE TABLE IF NOT EXISTS `front_operation_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `front_operation_log_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.front_operation_log 的数据：~89 rows (大约)
DELETE FROM `front_operation_log`;
/*!40000 ALTER TABLE `front_operation_log` DISABLE KEYS */;
INSERT INTO `front_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`) VALUES
	(1, 2, 'front/periodical', 'GET', '127.0.0.1', '[]', '2017-08-14 15:12:32', '2017-08-14 15:12:32'),
	(2, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 15:13:57', '2017-08-14 15:13:57'),
	(3, 2, 'front/menber', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-08-14 15:13:59', '2017-08-14 15:13:59'),
	(4, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 15:41:50', '2017-08-14 15:41:50'),
	(5, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 15:52:09', '2017-08-14 15:52:09'),
	(6, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 15:54:40', '2017-08-14 15:54:40'),
	(7, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 15:59:44', '2017-08-14 15:59:44'),
	(8, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 16:10:04', '2017-08-14 16:10:04'),
	(9, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 16:25:23', '2017-08-14 16:25:23'),
	(10, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 16:29:52', '2017-08-14 16:29:52'),
	(11, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 16:32:45', '2017-08-14 16:32:45'),
	(12, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 16:52:18', '2017-08-14 16:52:18'),
	(13, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 16:52:56', '2017-08-14 16:52:56'),
	(14, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 16:53:49', '2017-08-14 16:53:49'),
	(15, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 16:54:36', '2017-08-14 16:54:36'),
	(16, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 16:55:59', '2017-08-14 16:55:59'),
	(17, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 16:57:54', '2017-08-14 16:57:54'),
	(18, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 16:58:27', '2017-08-14 16:58:27'),
	(19, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 17:02:05', '2017-08-14 17:02:05'),
	(20, 2, 'front/finance/input', 'GET', '127.0.0.1', '[]', '2017-08-14 17:06:39', '2017-08-14 17:06:39'),
	(21, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 17:22:49', '2017-08-14 17:22:49'),
	(22, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 17:25:10', '2017-08-14 17:25:10'),
	(23, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 17:29:25', '2017-08-14 17:29:25'),
	(24, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 17:30:26', '2017-08-14 17:30:26'),
	(25, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 17:38:18', '2017-08-14 17:38:18'),
	(26, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 17:41:42', '2017-08-14 17:41:42'),
	(27, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 17:48:31', '2017-08-14 17:48:31'),
	(28, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 17:49:24', '2017-08-14 17:49:24'),
	(29, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-14 17:51:59', '2017-08-14 17:51:59'),
	(30, 2, 'front', 'GET', '127.0.0.1', '[]', '2017-08-15 10:59:55', '2017-08-15 10:59:55'),
	(31, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 11:09:18', '2017-08-15 11:09:18'),
	(32, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 11:23:18', '2017-08-15 11:23:18'),
	(33, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 11:24:57', '2017-08-15 11:24:57'),
	(34, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 11:27:07', '2017-08-15 11:27:07'),
	(35, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 11:33:47', '2017-08-15 11:33:47'),
	(36, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 11:35:41', '2017-08-15 11:35:41'),
	(37, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 13:42:29', '2017-08-15 13:42:29'),
	(38, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 13:44:26', '2017-08-15 13:44:26'),
	(39, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 13:46:56', '2017-08-15 13:46:56'),
	(40, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 13:50:07', '2017-08-15 13:50:07'),
	(41, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 13:52:37', '2017-08-15 13:52:37'),
	(42, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 13:54:06', '2017-08-15 13:54:06'),
	(43, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 13:55:25', '2017-08-15 13:55:25'),
	(44, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 13:55:47', '2017-08-15 13:55:47'),
	(45, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:00:25', '2017-08-15 14:00:25'),
	(46, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:02:34', '2017-08-15 14:02:34'),
	(47, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:04:26', '2017-08-15 14:04:26'),
	(48, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:05:44', '2017-08-15 14:05:44'),
	(49, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:26:02', '2017-08-15 14:26:02'),
	(50, 2, 'front/editper', 'POST', '127.0.0.1', '{"per":"4","menber_id":"1","p_id":"1","type":"m","_token":"6Y0j0diELgfI9NHrv5Eo7d9JUhpjQU4tNSKlMLji"}', '2017-08-15 14:27:43', '2017-08-15 14:27:43'),
	(51, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:27:43', '2017-08-15 14:27:43'),
	(52, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:29:12', '2017-08-15 14:29:12'),
	(53, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:30:41', '2017-08-15 14:30:41'),
	(54, 2, 'front/editper', 'POST', '127.0.0.1', '{"per":"4","menber_id":"1","p_id":"1","type":"m","_token":"6Y0j0diELgfI9NHrv5Eo7d9JUhpjQU4tNSKlMLji"}', '2017-08-15 14:31:31', '2017-08-15 14:31:31'),
	(55, 2, 'front', 'GET', '127.0.0.1', '[]', '2017-08-15 14:33:12', '2017-08-15 14:33:12'),
	(56, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:33:47', '2017-08-15 14:33:47'),
	(57, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:35:11', '2017-08-15 14:35:11'),
	(58, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:36:18', '2017-08-15 14:36:18'),
	(59, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:36:53', '2017-08-15 14:36:53'),
	(60, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:37:46', '2017-08-15 14:37:46'),
	(61, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:38:30', '2017-08-15 14:38:30'),
	(62, 2, 'front/editper', 'POST', '127.0.0.1', '{"per":"8","menber_id":"1","p_id":"1","type":"m","_token":"6Y0j0diELgfI9NHrv5Eo7d9JUhpjQU4tNSKlMLji"}', '2017-08-15 14:39:28', '2017-08-15 14:39:28'),
	(63, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:39:29', '2017-08-15 14:39:29'),
	(64, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:46:42', '2017-08-15 14:46:42'),
	(65, 2, 'front/editper', 'POST', '127.0.0.1', '{"per":"4","menber_id":"1","p_id":"2","type":"j","_token":"6Y0j0diELgfI9NHrv5Eo7d9JUhpjQU4tNSKlMLji"}', '2017-08-15 14:47:55', '2017-08-15 14:47:55'),
	(66, 2, 'front/menber', 'GET', '127.0.0.1', '[]', '2017-08-15 14:47:55', '2017-08-15 14:47:55'),
	(67, 2, 'front/target', 'GET', '127.0.0.1', '[]', '2017-08-15 14:50:05', '2017-08-15 14:50:05'),
	(68, 2, 'front/department', 'GET', '127.0.0.1', '[]', '2017-08-15 14:50:46', '2017-08-15 14:50:46'),
	(69, 2, 'front/target', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-08-15 14:50:54', '2017-08-15 14:50:54'),
	(70, 2, 'front/target/create', 'GET', '127.0.0.1', '[]', '2017-08-15 15:47:46', '2017-08-15 15:47:46'),
	(71, 2, 'front/target/create', 'GET', '127.0.0.1', '[]', '2017-08-15 15:52:03', '2017-08-15 15:52:03'),
	(72, 2, 'front/target/create', 'GET', '127.0.0.1', '[]', '2017-08-15 15:52:40', '2017-08-15 15:52:40'),
	(73, 2, 'front/target/create', 'GET', '127.0.0.1', '[]', '2017-08-15 15:53:39', '2017-08-15 15:53:39'),
	(74, 2, 'front/target', 'POST', '127.0.0.1', '{"p_id":"1","s_time":"2017-09-01","e_time":"2017-09-30","num":"100","money":"10000","user_id":"2","_token":"6Y0j0diELgfI9NHrv5Eo7d9JUhpjQU4tNSKlMLji","_previous_":"http:\\/\\/fxst.app\\/front\\/target"}', '2017-08-15 16:03:16', '2017-08-15 16:03:16'),
	(75, 2, 'front/target', 'GET', '127.0.0.1', '[]', '2017-08-15 16:03:17', '2017-08-15 16:03:17'),
	(76, 2, 'front/target', 'GET', '127.0.0.1', '[]', '2017-08-15 16:11:18', '2017-08-15 16:11:18'),
	(77, 2, 'front/target', 'GET', '127.0.0.1', '[]', '2017-08-15 16:13:59', '2017-08-15 16:13:59'),
	(78, 2, 'front/target', 'GET', '127.0.0.1', '[]', '2017-08-15 16:16:51', '2017-08-15 16:16:51'),
	(79, 2, 'front/target', 'GET', '127.0.0.1', '[]', '2017-08-15 16:18:16', '2017-08-15 16:18:16'),
	(80, 2, 'front/target', 'GET', '127.0.0.1', '[]', '2017-08-15 16:21:59', '2017-08-15 16:21:59'),
	(81, 2, 'front/target', 'GET', '127.0.0.1', '[]', '2017-08-15 16:24:03', '2017-08-15 16:24:03'),
	(82, 2, 'front/target/1', 'DELETE', '127.0.0.1', '{"_method":"delete","_token":"6Y0j0diELgfI9NHrv5Eo7d9JUhpjQU4tNSKlMLji"}', '2017-08-15 17:22:26', '2017-08-15 17:22:26'),
	(83, 2, 'front/target', 'GET', '127.0.0.1', '{"_pjax":"#pjax-container"}', '2017-08-15 17:22:26', '2017-08-15 17:22:26'),
	(84, 2, 'front/target/2/targetd/create', 'GET', '127.0.0.1', '[]', '2017-08-15 17:23:17', '2017-08-15 17:23:17'),
	(85, 2, 'front/target/2/targetd', 'POST', '127.0.0.1', '{"user_id":"2","p_id":"2","target_id":"2","parent_d_id":null,"d_name":null,"d_id":"1","num":"50","money":"2000","_token":"6Y0j0diELgfI9NHrv5Eo7d9JUhpjQU4tNSKlMLji"}', '2017-08-15 17:24:15', '2017-08-15 17:24:15'),
	(86, 2, 'front/target', 'GET', '127.0.0.1', '[]', '2017-08-15 17:24:15', '2017-08-15 17:24:15'),
	(87, 2, 'front/target', 'GET', '127.0.0.1', '[]', '2017-08-15 17:26:32', '2017-08-15 17:26:32'),
	(88, 2, 'front/customer', 'GET', '127.0.0.1', '[]', '2017-08-15 17:27:46', '2017-08-15 17:27:46'),
	(89, 2, 'front/customer', 'GET', '127.0.0.1', '[]', '2017-08-15 17:59:15', '2017-08-15 17:59:15');
/*!40000 ALTER TABLE `front_operation_log` ENABLE KEYS */;

-- 导出  表 fxst.front_permissions 结构
CREATE TABLE IF NOT EXISTS `front_permissions` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` int(10) DEFAULT '0' COMMENT '父级ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `front_permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.front_permissions 的数据：~31 rows (大约)
DELETE FROM `front_permissions`;
/*!40000 ALTER TABLE `front_permissions` DISABLE KEYS */;
INSERT INTO `front_permissions` (`id`, `name`, `slug`, `created_at`, `updated_at`, `parent_id`) VALUES
	(1, '首页', '/', '2017-08-11 13:22:34', '2017-08-11 13:22:34', 0),
	(12, '部门管理', 'department', '2017-08-11 13:22:34', '2017-08-11 13:22:34', 0),
	(13, '部门列表', '/department', '2017-08-11 13:22:34', '2017-08-11 13:22:34', 12),
	(14, '添加部门', '/department/create', '2017-08-11 13:22:34', '2017-08-11 13:22:34', 12),
	(15, '人员管理', 'menber', '2017-08-11 13:22:34', '2017-08-11 13:22:34', 0),
	(16, '人员列表', '/menber', '2017-08-11 13:22:34', '2017-08-11 13:22:34', 15),
	(17, '添加人员', '/menber/create', '2017-08-11 13:22:34', '2017-08-11 13:22:34', 15),
	(18, '客户管理', 'customer', '2017-08-11 13:22:34', '2017-08-11 13:22:34', 0),
	(19, '客户列表', '/customer', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 18),
	(21, '添加客户', '/customer/create', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 18),
	(22, '刊物管理', '/periodical', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 0),
	(23, '刊物列表', '/periodical', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 22),
	(24, '添加刊物', '/periodical/create', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 22),
	(25, '目标管理', '/target', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 0),
	(26, '目标列表', '/target', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 25),
	(28, '财务管理', '/finance', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 0),
	(29, '订单列表', '/finance/input', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 28),
	(30, '订单录入', '/finance/input/create', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 28),
	(31, '业绩管理', '/performance', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 0),
	(32, '业绩结算', '/performance/checkout', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 31),
	(35, '基本设置', '/system', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 0),
	(36, '信息设置', '/system/jconfig', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 35),
	(37, '报社管理', '/system/baoshe', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 0),
	(38, '添加报社', '/system/baoshe/create', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 37),
	(39, '报社列表', '/system/baoshe', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 37),
	(40, '管理员设置', '/auth/users', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 0),
	(41, '管理员列表', '/auth/users', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 40),
	(42, '添加管理员', '/auth/users/create', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 40),
	(43, '支付方式设置', '/system/zhifu', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 35),
	(45, '添加主目标', '/target/create', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 25),
	(46, '客户性质设置', '/system/customer_type', '2017-08-11 13:22:35', '2017-08-11 13:22:35', 35);
/*!40000 ALTER TABLE `front_permissions` ENABLE KEYS */;

-- 导出  表 fxst.front_roles 结构
CREATE TABLE IF NOT EXISTS `front_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '部门名称',
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) DEFAULT '0' COMMENT '主账号ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `front_roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色表';

-- 正在导出表  fxst.front_roles 的数据：~2 rows (大约)
DELETE FROM `front_roles`;
/*!40000 ALTER TABLE `front_roles` DISABLE KEYS */;
INSERT INTO `front_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`, `user_id`) VALUES
	(2, '超级管理员', 'main_account', '2017-06-30 02:26:00', '2017-07-06 02:18:21', 2),
	(3, '管理员', 'guanliyuan', '2017-07-06 03:06:24', '2017-07-10 09:30:38', 2);
/*!40000 ALTER TABLE `front_roles` ENABLE KEYS */;

-- 导出  表 fxst.front_role_menu 结构
CREATE TABLE IF NOT EXISTS `front_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `front_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.front_role_menu 的数据：~1 rows (大约)
DELETE FROM `front_role_menu`;
/*!40000 ALTER TABLE `front_role_menu` DISABLE KEYS */;
INSERT INTO `front_role_menu` (`role_id`, `menu_id`, `created_at`, `updated_at`) VALUES
	(3, 22, NULL, NULL);
/*!40000 ALTER TABLE `front_role_menu` ENABLE KEYS */;

-- 导出  表 fxst.front_role_permissions 结构
CREATE TABLE IF NOT EXISTS `front_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `front_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.front_role_permissions 的数据：~0 rows (大约)
DELETE FROM `front_role_permissions`;
/*!40000 ALTER TABLE `front_role_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `front_role_permissions` ENABLE KEYS */;

-- 导出  表 fxst.front_role_users 结构
CREATE TABLE IF NOT EXISTS `front_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `front_role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.front_role_users 的数据：~5 rows (大约)
DELETE FROM `front_role_users`;
/*!40000 ALTER TABLE `front_role_users` DISABLE KEYS */;
INSERT INTO `front_role_users` (`role_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, NULL),
	(2, 2, NULL, NULL),
	(8, 9, NULL, NULL),
	(3, 10, NULL, NULL),
	(3, 11, NULL, NULL);
/*!40000 ALTER TABLE `front_role_users` ENABLE KEYS */;

-- 导出  表 fxst.front_users 结构
CREATE TABLE IF NOT EXISTS `front_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_account` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理员账号',
  `admin_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理员名称',
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) DEFAULT '0' COMMENT '主账号ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `front_users_username_unique` (`admin_account`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.front_users 的数据：~1 rows (大约)
DELETE FROM `front_users`;
/*!40000 ALTER TABLE `front_users` DISABLE KEYS */;
INSERT INTO `front_users` (`id`, `admin_account`, `admin_name`, `password`, `avatar`, `remember_token`, `created_at`, `updated_at`, `user_id`) VALUES
	(2, 'admin', '超级管理员', '$2y$10$co9aCs4daGHX41oyGdTmbu7IfGZN1y7gHdDfsUh9BQJ45RvV0kUxC', 'image/5d78d563gy1fdm4c6qsi9j20aw09adgk.jpg', 'vRVytmN86TfVPWCJUJnp7wFj7eDp3sxkLfVNE3UE2jX3MfGjhILBudbdgb7X', '2017-06-30 02:27:50', '2017-06-30 02:27:50', 2);
/*!40000 ALTER TABLE `front_users` ENABLE KEYS */;

-- 导出  表 fxst.front_user_menu 结构
CREATE TABLE IF NOT EXISTS `front_user_menu` (
  `user_id` int(10) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `user_id` (`user_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='user_menu关联表';

-- 正在导出表  fxst.front_user_menu 的数据：3 rows
DELETE FROM `front_user_menu`;
/*!40000 ALTER TABLE `front_user_menu` DISABLE KEYS */;
INSERT INTO `front_user_menu` (`user_id`, `menu_id`, `created_at`, `updated_at`) VALUES
	(6, 37, NULL, NULL),
	(6, 38, NULL, NULL),
	(6, 39, NULL, NULL);
/*!40000 ALTER TABLE `front_user_menu` ENABLE KEYS */;

-- 导出  表 fxst.front_user_permissions 结构
CREATE TABLE IF NOT EXISTS `front_user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `front_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.front_user_permissions 的数据：~18 rows (大约)
DELETE FROM `front_user_permissions`;
/*!40000 ALTER TABLE `front_user_permissions` DISABLE KEYS */;
INSERT INTO `front_user_permissions` (`user_id`, `permission_id`, `created_at`, `updated_at`) VALUES
	(6, 27, NULL, NULL),
	(6, 28, NULL, NULL),
	(6, 29, NULL, NULL),
	(7, 8, NULL, NULL),
	(7, 9, NULL, NULL),
	(7, 10, NULL, NULL),
	(8, 8, NULL, NULL),
	(8, 9, NULL, NULL),
	(8, 10, NULL, NULL),
	(9, 8, NULL, NULL),
	(9, 9, NULL, NULL),
	(9, 10, NULL, NULL),
	(10, 8, NULL, NULL),
	(10, 9, NULL, NULL),
	(10, 10, NULL, NULL),
	(11, 8, NULL, NULL),
	(11, 9, NULL, NULL),
	(11, 10, NULL, NULL);
/*!40000 ALTER TABLE `front_user_permissions` ENABLE KEYS */;

-- 导出  表 fxst.inputs 结构
CREATE TABLE IF NOT EXISTS `inputs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_id` int(10) unsigned NOT NULL COMMENT '客户ID',
  `customer_name` varchar(50) NOT NULL COMMENT '客户名称',
  `user_id` int(10) unsigned NOT NULL COMMENT '主账号ID',
  `u_id` int(10) unsigned DEFAULT NULL COMMENT '账号ID',
  `menber_name` varchar(50) DEFAULT NULL COMMENT '销售名称',
  `d_id` int(10) unsigned DEFAULT NULL COMMENT '部门ID',
  `p_id` int(10) unsigned DEFAULT NULL COMMENT '刊物ID',
  `p_name` varchar(50) DEFAULT '无' COMMENT '刊物名称',
  `source` tinyint(1) DEFAULT '0' COMMENT '订单来源',
  `num` int(11) unsigned DEFAULT '0' COMMENT '订单数量',
  `input_type` varchar(5) DEFAULT 'm' COMMENT 'mjby月季半年年',
  `input_sn` varchar(50) DEFAULT NULL COMMENT '订单sn',
  `input_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单状态',
  `piao_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开票状态',
  `dis_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分成状态',
  `dis_per` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分成比例',
  `pay_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态',
  `pay_name` tinyint(4) DEFAULT NULL COMMENT '支付方式',
  `p_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
  `p_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '应付总金额',
  `money_paid` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '已付款金额',
  `money_kou` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '扣',
  `piao_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '开票金额',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pay_time` timestamp NULL DEFAULT NULL COMMENT '支付时间',
  `pay_note` varchar(50) DEFAULT NULL COMMENT '付款备注',
  `fapiao` varchar(50) DEFAULT NULL COMMENT '发票',
  `liushui` varchar(50) DEFAULT NULL COMMENT '流水',
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='财务录入表';

-- 正在导出表  fxst.inputs 的数据：1 rows
DELETE FROM `inputs`;
/*!40000 ALTER TABLE `inputs` DISABLE KEYS */;
INSERT INTO `inputs` (`id`, `c_id`, `customer_name`, `user_id`, `u_id`, `menber_name`, `d_id`, `p_id`, `p_name`, `source`, `num`, `input_type`, `input_sn`, `input_status`, `piao_status`, `dis_status`, `dis_per`, `pay_status`, `pay_name`, `p_money`, `p_amount`, `money_paid`, `money_kou`, `piao_money`, `created_at`, `updated_at`, `pay_time`, `pay_note`, `fapiao`, `liushui`, `time`) VALUES
	(1, 1, '客户1', 2, 1, '发行人1', 3, 1, '江苏经济报', 0, 10, 'm', NULL, 1, 0, 0, 3.00, 1, 1, 1.00, 10.00, 10.00, 0.00, 0.00, '2017-08-14 15:12:04', '2017-08-14 15:12:04', NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `inputs` ENABLE KEYS */;

-- 导出  表 fxst.input_ps 结构
CREATE TABLE IF NOT EXISTS `input_ps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `input_id` int(10) unsigned NOT NULL COMMENT '订单表ID',
  `p_id` int(10) unsigned NOT NULL COMMENT '刊物ID',
  `num` int(11) NOT NULL COMMENT '份数',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `per` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '比例',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单刊物表';

-- 正在导出表  fxst.input_ps 的数据：0 rows
DELETE FROM `input_ps`;
/*!40000 ALTER TABLE `input_ps` DISABLE KEYS */;
/*!40000 ALTER TABLE `input_ps` ENABLE KEYS */;

-- 导出  表 fxst.jituan_configs 结构
CREATE TABLE IF NOT EXISTS `jituan_configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '主账号ID',
  `jituan_name` text NOT NULL COMMENT '单位名称',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='集团配置文件';

-- 正在导出表  fxst.jituan_configs 的数据：1 rows
DELETE FROM `jituan_configs`;
/*!40000 ALTER TABLE `jituan_configs` DISABLE KEYS */;
INSERT INTO `jituan_configs` (`id`, `user_id`, `jituan_name`, `updated_at`, `created_at`) VALUES
	(1, 2, '新华报业集团', NULL, NULL);
/*!40000 ALTER TABLE `jituan_configs` ENABLE KEYS */;

-- 导出  表 fxst.menbers 结构
CREATE TABLE IF NOT EXISTS `menbers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '主账号ID',
  `d_id` int(10) unsigned NOT NULL COMMENT '所属部门ID',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='人员表';

-- 正在导出表  fxst.menbers 的数据：2 rows
DELETE FROM `menbers`;
/*!40000 ALTER TABLE `menbers` DISABLE KEYS */;
INSERT INTO `menbers` (`id`, `user_id`, `d_id`, `name`, `money`, `created_at`, `updated_at`) VALUES
	(1, 2, 3, '发行人1', 0.00, '2017-08-14 15:12:04', '2017-08-14 15:12:04'),
	(2, 2, 4, '发行人2', 0.00, '2017-08-14 15:12:04', '2017-08-14 15:12:04');
/*!40000 ALTER TABLE `menbers` ENABLE KEYS */;

-- 导出  表 fxst.menber_pers 结构
CREATE TABLE IF NOT EXISTS `menber_pers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '主账号ID',
  `menber_id` int(11) DEFAULT NULL COMMENT '发行人ID',
  `p_id` int(11) DEFAULT NULL COMMENT '刊物ID',
  `per` int(11) DEFAULT NULL COMMENT '分成比例',
  `type` varchar(5) DEFAULT 'm' COMMENT '半，季。。类型',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='发行人分成比例表';

-- 正在导出表  fxst.menber_pers 的数据：~2 rows (大约)
DELETE FROM `menber_pers`;
/*!40000 ALTER TABLE `menber_pers` DISABLE KEYS */;
INSERT INTO `menber_pers` (`id`, `user_id`, `menber_id`, `p_id`, `per`, `type`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, 1, 8, 'm', '2017-08-15 14:31:31', '2017-08-15 14:39:29'),
	(2, 2, 1, 2, 4, 'j', '2017-08-15 14:47:55', '2017-08-15 14:47:55');
/*!40000 ALTER TABLE `menber_pers` ENABLE KEYS */;

-- 导出  表 fxst.migrations 结构
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  fxst.migrations 的数据：~1 rows (大约)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2016_01_04_173148_create_admin_tables', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- 导出  表 fxst.periodicals 结构
CREATE TABLE IF NOT EXISTS `periodicals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '刊物名称',
  `m_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '月价格',
  `j_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '季度价格',
  `b_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '半年价格',
  `y_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一年价格',
  `user_id` int(10) NOT NULL,
  `baoshe_id` int(10) NOT NULL COMMENT '属于哪个报社',
  `per` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '基准分成比例',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='刊物列表';

-- 正在导出表  fxst.periodicals 的数据：2 rows
DELETE FROM `periodicals`;
/*!40000 ALTER TABLE `periodicals` DISABLE KEYS */;
INSERT INTO `periodicals` (`id`, `name`, `m_price`, `j_price`, `b_price`, `y_price`, `user_id`, `baoshe_id`, `per`, `created_at`, `updated_at`) VALUES
	(1, '江苏经济报', 100.00, 300.00, 600.00, 1200.00, 2, 1, 3.00, '2017-08-14 15:12:04', '2017-08-14 15:12:04'),
	(2, '都市报', 100.00, 300.00, 600.00, 1200.00, 2, 2, 3.00, '2017-08-14 15:12:04', '2017-08-14 15:12:04');
/*!40000 ALTER TABLE `periodicals` ENABLE KEYS */;

-- 导出  表 fxst.p_performance 结构
CREATE TABLE IF NOT EXISTS `p_performance` (
  `id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='个人业绩表';

-- 正在导出表  fxst.p_performance 的数据：0 rows
DELETE FROM `p_performance`;
/*!40000 ALTER TABLE `p_performance` DISABLE KEYS */;
/*!40000 ALTER TABLE `p_performance` ENABLE KEYS */;

-- 导出  表 fxst.regions 结构
CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) DEFAULT NULL COMMENT '地区代码',
  `name` varchar(20) DEFAULT NULL COMMENT '地区名称',
  `parent_code` int(11) DEFAULT NULL COMMENT '父级地区',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='地区表';

-- 正在导出表  fxst.regions 的数据：~0 rows (大约)
DELETE FROM `regions`;
/*!40000 ALTER TABLE `regions` DISABLE KEYS */;
/*!40000 ALTER TABLE `regions` ENABLE KEYS */;

-- 导出  表 fxst.system_users 结构
CREATE TABLE IF NOT EXISTS `system_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(50) NOT NULL COMMENT '管理员名称',
  `password` varchar(50) NOT NULL,
  `remember_token` varchar(50) DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT '主账号ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员列表';

-- 正在导出表  fxst.system_users 的数据：0 rows
DELETE FROM `system_users`;
/*!40000 ALTER TABLE `system_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_users` ENABLE KEYS */;

-- 导出  表 fxst.targets 结构
CREATE TABLE IF NOT EXISTS `targets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `p_id` int(10) unsigned DEFAULT NULL COMMENT '刊物ID',
  `num` int(10) unsigned DEFAULT '0' COMMENT '总目标',
  `numed` int(10) unsigned DEFAULT '0' COMMENT '总完成数',
  `money` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '总目标金额',
  `moneyed` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '总已完成目标金额',
  `s_time` timestamp NULL DEFAULT NULL COMMENT '开始时间',
  `e_time` timestamp NULL DEFAULT NULL COMMENT '结束时间',
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='目标';

-- 正在导出表  fxst.targets 的数据：2 rows
DELETE FROM `targets`;
/*!40000 ALTER TABLE `targets` DISABLE KEYS */;
INSERT INTO `targets` (`id`, `p_id`, `num`, `numed`, `money`, `moneyed`, `s_time`, `e_time`, `user_id`, `created_at`, `updated_at`) VALUES
	(2, 2, 20000, 0, 100.00, 0.00, '2017-01-01 00:00:00', '2017-12-31 23:59:59', 2, '2017-08-14 15:12:04', '2017-08-14 15:12:04'),
	(3, 1, 100, 0, 10000.00, 0.00, '2017-09-01 00:00:00', '2017-09-30 00:00:00', 2, '2017-08-15 16:03:16', '2017-08-15 16:03:16');
/*!40000 ALTER TABLE `targets` ENABLE KEYS */;

-- 导出  表 fxst.target_ds 结构
CREATE TABLE IF NOT EXISTS `target_ds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `p_id` int(10) unsigned NOT NULL,
  `target_id` int(10) unsigned NOT NULL COMMENT '主目标ID',
  `num` int(11) NOT NULL DEFAULT '0',
  `numed` int(11) DEFAULT '0',
  `money` decimal(10,2) DEFAULT '0.00',
  `moneyed` decimal(10,2) DEFAULT '0.00',
  `d_id` int(10) unsigned DEFAULT NULL COMMENT '部门ID',
  `d_name` varchar(50) DEFAULT NULL,
  `parent_d_id` int(10) unsigned DEFAULT NULL,
  `order` int(10) DEFAULT NULL COMMENT '排序（根据部门）',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- 正在导出表  fxst.target_ds 的数据：3 rows
DELETE FROM `target_ds`;
/*!40000 ALTER TABLE `target_ds` DISABLE KEYS */;
INSERT INTO `target_ds` (`id`, `user_id`, `p_id`, `target_id`, `num`, `numed`, `money`, `moneyed`, `d_id`, `d_name`, `parent_d_id`, `order`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, 1, 5000, 10, 0.00, 0.00, 1, '江苏经济报社', 0, NULL, '2017-08-14 15:12:04', '2017-08-14 15:12:04'),
	(2, 2, 1, 1, 2000, 10, 0.00, 0.00, 3, '记者部', 1, NULL, '2017-08-14 15:12:04', '2017-08-14 15:12:04'),
	(3, 2, 2, 2, 50, 0, 2000.00, 0.00, 1, '江苏经济报社', 0, NULL, '2017-08-15 17:24:15', '2017-08-15 17:24:15');
/*!40000 ALTER TABLE `target_ds` ENABLE KEYS */;

-- 导出  表 fxst.target_ms 结构
CREATE TABLE IF NOT EXISTS `target_ms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '主账户ID',
  `user_name` varchar(50) DEFAULT NULL COMMENT '销售名',
  `u_id` int(10) unsigned NOT NULL COMMENT '销售ID',
  `num` int(11) DEFAULT '0' COMMENT '目标数量',
  `numed` int(11) DEFAULT '0' COMMENT '完成数量',
  `t_id` int(10) unsigned NOT NULL COMMENT '主任务ID',
  `t_d_id` int(10) unsigned NOT NULL COMMENT '部门任务ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='人员目标完成表';

-- 正在导出表  fxst.target_ms 的数据：1 rows
DELETE FROM `target_ms`;
/*!40000 ALTER TABLE `target_ms` DISABLE KEYS */;
INSERT INTO `target_ms` (`id`, `user_id`, `user_name`, `u_id`, `num`, `numed`, `t_id`, `t_d_id`, `created_at`, `updated_at`) VALUES
	(1, 2, '发行人1', 1, 500, 10, 1, 2, '2017-08-14 15:12:04', '2017-08-14 15:12:04');
/*!40000 ALTER TABLE `target_ms` ENABLE KEYS */;

-- 导出  表 fxst.types 结构
CREATE TABLE IF NOT EXISTS `types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='支付方式表';

-- 正在导出表  fxst.types 的数据：6 rows
DELETE FROM `types`;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` (`id`, `user_id`, `type`, `name`, `code`, `created_at`, `updated_at`) VALUES
	(1, 0, 'pay_type', '微信支付', 'wxpay', NULL, NULL),
	(2, 0, 'pay_type', '银行转账', 'bankpay', NULL, NULL),
	(5, 0, 'customer_type', '个人', 'geren', NULL, NULL),
	(6, 0, 'customer_type', '事业单位', 'sydw', NULL, NULL),
	(7, 0, 'customer_type', '政府', 'zhengfu', NULL, NULL),
	(8, 0, 'customer_type', '企业', 'qiye', NULL, NULL);
/*!40000 ALTER TABLE `types` ENABLE KEYS */;

-- 导出  表 fxst.u_checkouts 结构
CREATE TABLE IF NOT EXISTS `u_checkouts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '主账号ID',
  `d_id` int(10) unsigned NOT NULL COMMENT '部门ID',
  `p_id` int(10) unsigned NOT NULL COMMENT '刊物ID',
  `u_id` int(10) unsigned NOT NULL COMMENT '销售员ID',
  `all_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总佣金',
  `j_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已结算',
  `no_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '未结算',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户佣金表';

-- 正在导出表  fxst.u_checkouts 的数据：0 rows
DELETE FROM `u_checkouts`;
/*!40000 ALTER TABLE `u_checkouts` DISABLE KEYS */;
/*!40000 ALTER TABLE `u_checkouts` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
