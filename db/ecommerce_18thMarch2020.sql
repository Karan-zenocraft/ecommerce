-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 18, 2020 at 12:49 PM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `parent_category_id` bigint(20) NOT NULL,
  `sub_category_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `title`, `description`, `parent_category_id`, `sub_category_id`, `created_at`, `updated_at`) VALUES
(1, 'mercedes', 'mercedes', 1, 4, '2020-02-13 11:30:31', '2020-02-13 11:30:31'),
(2, 'Honda', 'Honda', 1, 4, '2020-02-13 11:32:58', '2020-02-13 11:32:58'),
(3, 'Nexa', 'Nexa', 1, 4, '2020-02-13 11:33:13', '2020-02-13 11:33:13'),
(4, 'Hyundai', 'Hyundai', 1, 4, '2020-02-13 11:33:22', '2020-02-13 11:33:22'),
(5, 'Maruti Suzuki', 'Maruti Suzuki', 1, 4, '2020-02-13 11:33:33', '2020-02-13 11:33:33'),
(6, 'LG', 'LG', 2, 6, '2020-02-13 11:33:51', '2020-02-13 11:33:51'),
(7, 'ONIDA', 'ONIDA', 2, 6, '2020-02-13 11:34:09', '2020-02-13 11:34:09'),
(8, 'SONY', 'SONY', 2, 6, '2020-02-13 11:34:27', '2020-02-13 11:34:27'),
(9, 'BUSH', 'BUSH', 2, 6, '2020-02-13 11:34:42', '2020-02-13 11:35:13'),
(10, 'TOYOTA', 'TOYOTA', 1, 4, '2020-02-13 12:37:43', '2020-02-13 12:37:43');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 67, 59, 1, '2020-03-05 10:04:59', '2020-03-05 10:04:59'),
(2, 67, 61, 2, '2020-03-05 10:27:29', '2020-03-05 10:27:29'),
(3, 66, 53, 1, '2020-03-06 13:18:44', '2020-03-06 13:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'category_1', 'category_1', '2020-02-07 12:17:39', '2020-02-07 12:31:28'),
(2, 'category_2', 'category_2', '2020-02-07 12:31:42', '2020-02-07 12:31:48'),
(3, 'category_3', 'category_3', '2020-02-07 12:31:59', '2020-02-07 12:32:05'),
(4, 'category_4', 'category_4', '2020-02-07 12:33:10', '2020-02-07 12:33:10'),
(5, 'category_5', 'category_5', '2020-02-07 12:33:18', '2020-02-07 12:33:18');

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `parent_id` bigint(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`id`, `title`, `description`, `parent_id`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', 'Electronics', NULL, 'http://64.225.14.21/ecommerce/uploads/category/Electronics_5e4a2b31ec1e4.png', '2020-02-13 09:25:01', '2020-02-17 05:57:52'),
(2, 'Fashion', 'Fashion', NULL, 'http://64.225.14.21/ecommerce/uploads/category/Fashion_5e4a2b3a1fa66.png', '2020-02-13 09:26:51', '2020-02-17 05:58:04'),
(3, 'Furniture', 'Furniture', NULL, 'http://10.160.7.150/ecommerce/uploads/category/Furniture_5e4a2b42404ee.png', '2020-02-13 09:28:52', '2020-02-17 05:58:19'),
(4, 'sub cat 11', 'sub cat 11', 1, NULL, '2020-02-13 10:14:11', '2020-02-13 10:16:39'),
(5, 'Sub Cat12', 'Sub Cat12', 1, NULL, '2020-02-13 10:14:50', '2020-02-13 10:16:51'),
(6, 'Sub Cat21', 'Sub Cat21', 2, NULL, '2020-02-13 10:15:10', '2020-02-13 10:17:08'),
(7, 'Sub Cat22', 'Sub Cat22', 2, NULL, '2020-02-13 10:15:32', '2020-02-13 10:21:50'),
(8, 'Sub Cat31', 'Sub Cat31', 3, NULL, '2020-02-13 10:17:43', '2020-02-13 10:21:58'),
(9, 'Sub Cat32', 'Sub Cat32', 3, NULL, '2020-02-13 10:22:13', '2020-02-13 10:22:13'),
(10, 'child11', 'child11', 4, NULL, '2020-02-13 10:39:57', '2020-02-13 10:39:57'),
(11, 'sub child1', 'sub child1', 10, NULL, '2020-02-13 10:47:23', '2020-02-13 10:47:23'),
(12, 'Hobbies', 'Hobbies', NULL, 'http://64.225.14.21/ecommerce/uploads/category/Hobbies_5e4a2b8f2a849.png', '2020-02-17 05:58:39', '2020-02-17 05:58:39'),
(14, 'Sports', 'Sports', NULL, 'http://64.225.14.21/ecommerce/uploads/category/Sports_5e4a2bb62f344.png', '2020-02-17 05:59:18', '2020-02-17 05:59:18'),
(15, 'Tools', 'Tools', NULL, 'http://64.225.14.21/ecommerce/uploads/category/Tools_5e4a2bc2c9a00.png', '2020-02-17 05:59:30', '2020-02-17 05:59:30'),
(16, 'Vehicles', 'Vehicles', NULL, 'http://64.225.14.21/ecommerce/uploads/category/Vehicles_5e4a2bd06bc32.png', '2020-02-17 05:59:44', '2020-02-17 05:59:44'),
(17, 'Other', 'Other', NULL, 'http://64.225.14.21/ecommerce/uploads/category/Other_5e4a3f6518ce6.png', '2020-02-17 07:23:17', '2020-02-17 07:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `chat_list`
--

CREATE TABLE `chat_list` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `chat_user_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `device_details`
--

CREATE TABLE `device_details` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `device_token` varchar(6000) DEFAULT NULL,
  `type` enum('1','2') NOT NULL,
  `gcm_id` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `device_details`
--

INSERT INTO `device_details` (`id`, `user_id`, `device_token`, `type`, `gcm_id`, `created_at`) VALUES
(35, 62, '1111111', '2', NULL, '2020-02-24 14:27:30'),
(42, 65, '123456', '2', NULL, '2020-03-03 05:58:31'),
(53, 69, '1111111', '2', NULL, '2020-03-03 10:42:05'),
(64, 66, '123456', '2', NULL, '2020-03-06 11:17:56'),
(72, 67, '123456', '2', NULL, '2020-03-18 10:34:40'),
(78, 63, '123456', '1', NULL, '2020-03-18 10:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `email_format`
--

CREATE TABLE `email_format` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=In-Active',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_format`
--

INSERT INTO `email_format` (`id`, `title`, `subject`, `body`, `status`, `created_at`, `updated_at`) VALUES
(1, 'forgot_password', 'Forgot Password', '<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" align=\"center\" valign=\"top\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" bgcolor=\"FFFFFF\" border=\"0\" width=\"650\">\n                <tbody>\n                    <tr>\n                        <td style=\"background: #444444; \" bgcolor=\"#EAEAEA\" valign=\"top\"><p style=\"color:#fff;display: inline-flex;\">&nbsp;&nbsp;Marketplace</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Dear  {username},</p>\n                        <p>Your New Password is :<br></p><p><strong>E-mail:</strong> {email}<br>\n                         </p><p><strong>Password:</strong> {password}<br>\n\n                        </p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">Marketplace team</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>', 1, '2019-12-12 00:00:00', NULL),
(2, 'user_registration', 'Marketplace -New Account', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\n                <tbody>\n                    <tr>\n                        <td style=\"background:#444444;color: white; \" valign=\"top\" bgcolor=\"#EAEAEA\"><p>Marketplace</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Dear  {username},</p>\n                        <p>Your account has been created.<br></p>\n                          <p><strong>E-mail:</strong> {email} <br></p>\n<p><strong>Password:</strong> {password} <br></p>\n<p>Please click on below link for verify your Email :</p>\n<p>{email_verify_link}</p>\n                        <p></p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">Marketplace Team</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>\n', 1, '2019-12-12 00:00:00', NULL),
(3, 'reset_password', 'Reset Password', '<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" align=\"center\" valign=\"top\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" bgcolor=\"FFFFFF\" border=\"0\" width=\"650\">\n                <tbody>\n                   <tr>\n                        <td style=\"background: #444444; \" bgcolor=\"#EAEAEA\" valign=\"top\"><p style=\"color:#fff;display: inline-flex;\">&nbsp;&nbsp;Marketplace</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Dear  {username},</p>\n                        <p>Follow the link below to reset your password:</p>\n                        <p>{resetLink}</p>\n\n                        </p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">Marketplace</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>', 1, '2019-12-12 00:00:00', NULL),
(4, 'contact_us', 'Marketplace Contact', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\n                <tbody>\n                     <tr>\n                        <td style=\"background: #444444; \" bgcolor=\"#EAEAEA\" valign=\"top\"><p style=\"color:#fff;display: inline-flex;\">&nbsp;&nbsp;Marketplace</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Hello  Food App Admin,\n                        <p>{message}<br></p>\n                        <p></p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">{name}</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>', 1, '2019-12-12 00:00:00', NULL),
(5, 'backend_registration', 'Marketplace -New Account', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\n                <tbody>\n                    <tr>\n                        <td style=\"background:#444444;color: white; \" valign=\"top\" bgcolor=\"#EAEAEA\"><p>Marketplace</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Dear  {username},</p>\n                        <p>Your account has been created.<br></p>\n                          <p><strong>E-mail:</strong> {email} <br></p>\n                            <p><strong>Password:</strong> {password} <br></p>\n                            <p>Your role is {role}</p>\n                        <p></p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">Marketplace Team</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>', 1, '2019-12-12 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1576498339),
('m130524_201442_init', 1576498345),
('m190124_110200_add_verification_token_column_to_user_table', 1576498347),
('m191216_132958_users', 1576566801),
('m191217_071531_user_roles', 1576567743),
('m191217_075341_users_update', 1576569569);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `buyer_id` bigint(20) NOT NULL,
  `payment_type` enum('1','2') NOT NULL,
  `discount` int(11) NOT NULL DEFAULT '0',
  `tax` float DEFAULT NULL,
  `total_amount_paid` float DEFAULT NULL,
  `user_address_id` bigint(20) NOT NULL,
  `status` tinyint(6) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `buyer_id`, `payment_type`, `discount`, `tax`, `total_amount_paid`, `user_address_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 63, '1', 0, NULL, NULL, 5, 1, '2020-03-11 06:37:39', '2020-03-11 06:37:39'),
(2, 63, '2', 0, NULL, NULL, 5, 1, '2020-03-11 06:40:48', '2020-03-11 06:40:48'),
(3, 63, '1', 0, NULL, NULL, 5, 1, '2020-03-11 06:56:49', '2020-03-11 06:56:49'),
(4, 63, '1', 0, NULL, NULL, 5, 1, '2020-03-11 07:00:00', '2020-03-11 07:00:00'),
(6, 63, '1', 0, NULL, NULL, 5, 1, '2020-03-11 07:00:45', '2020-03-11 07:00:45'),
(7, 63, '1', 0, NULL, NULL, 5, 1, '2020-03-11 07:03:06', '2020-03-11 07:03:06'),
(8, 63, '1', 0, NULL, 19, 5, 1, '2020-03-11 07:05:09', '2020-03-11 07:05:10'),
(9, 63, '1', 0, NULL, 19, 5, 1, '2020-03-11 07:05:29', '2020-03-11 07:05:29'),
(10, 63, '2', 0, NULL, 19, 6, 1, '2020-03-12 06:18:09', '2020-03-12 06:18:09'),
(11, 63, '1', 0, NULL, 19, 6, 1, '2020-03-12 06:19:44', '2020-03-12 06:19:44'),
(12, 63, '1', 0, NULL, 19, 6, 1, '2020-03-12 06:25:11', '2020-03-12 06:25:11'),
(13, 63, '1', 0, NULL, 19, 5, 1, '2020-03-12 06:32:15', '2020-03-12 06:32:15'),
(14, 63, '1', 0, NULL, 19, 6, 1, '2020-03-12 06:33:36', '2020-03-12 06:33:36'),
(15, 63, '1', 0, NULL, 19, 5, 1, '2020-03-13 11:06:21', '2020-03-13 11:06:21'),
(16, 63, '1', 0, NULL, 19, 5, 1, '2020-03-13 11:07:50', '2020-03-13 11:07:50'),
(17, 63, '1', 0, NULL, 19, 5, 1, '2020-03-13 11:10:19', '2020-03-13 11:10:19'),
(18, 63, '2', 0, NULL, 2999110, 6, 1, '2020-03-18 10:42:13', '2020-03-18 10:42:13'),
(19, 63, '2', 0, NULL, 10, 6, 1, '2020-03-18 10:49:28', '2020-03-18 10:49:28'),
(20, 63, '2', 0, NULL, 22, 6, 1, '2020-03-18 10:54:11', '2020-03-18 10:54:11');

-- --------------------------------------------------------

--
-- Table structure for table `order_payment`
--

CREATE TABLE `order_payment` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `buyer_stripe_id` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_payment`
--

INSERT INTO `order_payment` (`id`, `order_id`, `transaction_id`, `buyer_stripe_id`, `created_at`, `updated_at`) VALUES
(1, 1, '', '', '2020-03-11 06:37:40', '2020-03-11 06:37:40'),
(2, 2, 'cus_GtAafTNMKiylx1', 'cus_GtAafTNMKiylx1', '2020-03-11 06:40:48', '2020-03-11 06:40:48'),
(3, 3, 'PAY-0GF01594P5137101FLZUIXGQ', 'PAY-0GF01594P5137101FLZUIXGQ', '2020-03-11 06:56:49', '2020-03-11 06:56:49'),
(4, 4, 'PAY-08C58467CL134724FLZUIYOQ', 'PAY-08C58467CL134724FLZUIYOQ', '2020-03-11 07:00:00', '2020-03-11 07:00:00'),
(5, 6, 'PAY-0GF01594P5137101FLZUIXGQ', 'PAY-0GF01594P5137101FLZUIXGQ', '2020-03-11 07:00:45', '2020-03-11 07:00:45'),
(6, 7, 'PAY-0GF01594P5137101FLZUIXGQ', 'PAY-0GF01594P5137101FLZUIXGQ', '2020-03-11 07:03:06', '2020-03-11 07:03:06'),
(7, 8, 'PAY-0GF01594P5137101FLZUIXGQ', 'PAY-0GF01594P5137101FLZUIXGQ', '2020-03-11 07:05:10', '2020-03-11 07:05:10'),
(8, 9, 'PAY-4B320477F8283471RLZUI3LY', 'PAY-4B320477F8283471RLZUI3LY', '2020-03-11 07:05:29', '2020-03-11 07:05:29'),
(9, 10, 'cus_GtXRvnm0PveqBH', 'cus_GtXRvnm0PveqBH', '2020-03-12 06:18:09', '2020-03-12 06:18:09'),
(10, 11, 'PAY-8KJ91990NL2264055LZU5I5Q', 'PAY-8KJ91990NL2264055LZU5I5Q', '2020-03-12 06:19:44', '2020-03-12 06:19:44'),
(11, 12, 'PAY-75C68287JN167154XLZU5LPY', 'PAY-75C68287JN167154XLZU5LPY', '2020-03-12 06:25:11', '2020-03-12 06:25:11'),
(12, 13, 'PAY-0GF01594P5137101FLZUIXGQ', 'PAY-0GF01594P5137101FLZUIXGQ', '2020-03-12 06:32:15', '2020-03-12 06:32:15'),
(13, 14, 'PAY-30207015R2653464WLZU5ORA', 'PAY-30207015R2653464WLZU5ORA', '2020-03-12 06:33:36', '2020-03-12 06:33:36'),
(14, 15, 'PAY-0GF01594P5137101FLZUIXGQ', 'PAY-0GF01594P5137101FLZUIXGQ', '2020-03-13 11:06:21', '2020-03-13 11:06:21'),
(15, 16, 'PAY-0GF01594P5137101FLZUIXGQ', 'PAY-0GF01594P5137101FLZUIXGQ', '2020-03-13 11:07:50', '2020-03-13 11:07:50'),
(16, 17, 'PAY-0GF01594P5137101FLZUIXGQ', 'PAY-0GF01594P5137101FLZUIXGQ', '2020-03-13 11:10:19', '2020-03-13 11:10:19'),
(17, 18, 'cus_Gvr3YrlCGQbbIC', 'cus_Gvr3YrlCGQbbIC', '2020-03-18 10:42:13', '2020-03-18 10:42:13'),
(18, 19, 'cus_GvrBOfxjqo82Si', 'cus_GvrBOfxjqo82Si', '2020-03-18 10:49:28', '2020-03-18 10:49:28'),
(19, 20, 'cus_GvrFluqnGb2R5M', 'cus_GvrFluqnGb2R5M', '2020-03-18 10:54:11', '2020-03-18 10:54:11');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `discount` float NOT NULL DEFAULT '0',
  `tax` float DEFAULT '0',
  `sell_price` float DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `custom_url` varchar(255) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_content` text NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `custom_url`, `page_title`, `page_content`, `meta_title`, `meta_keyword`, `meta_description`, `status`, `created_at`, `updated_at`) VALUES
(4, 'community-guidelines', 'Community Guidelines', '<p><em><strong>Community Guidelines1</strong></em></p>\r\n', 'Community Guidelines', 'Community Guidelines', '', 1, NULL, NULL),
(5, 'annoucements', 'Annoucements', '<p><em><strong>Annoucements</strong></em></p>\r\n', 'Annoucements', 'Annoucements', 'Annoucements', 1, NULL, NULL),
(6, 'terms-of-use', 'Terms of Use', '<p><em><strong>Terms of Use</strong></em></p>\r\n', 'Terms of Use', 'Terms of Use', 'Terms of Use', 1, NULL, NULL),
(7, 'about-bridge', 'About Bridge', '<p><strong>About Bridge</strong></p>\r\n\r\n<p>B4P.et &ndash; BRIDGE for participation &ndash; is a dedicated web-based application to bring individual parliamentarians and their constituents together as part of an inclusive, interactive online political community.</p>\r\n\r\n<p>The App will be accessible on tablets and smartphones, and its functionality will include creating and making visible parliamentarian profiles, and allowing parliamentarians and those they represent to post questions, comments and replies to one another.</p>\r\n\r\n<p>You can contact us through the below channels.</p>\r\n\r\n<p>Email: info@b4p.et<br />\r\nPhone: +251930294007</p>\r\n', 'About Bridge', 'About Bridge', 'About Bridge', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `subcategory_id` bigint(20) NOT NULL,
  `seller_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `brand_id` bigint(20) DEFAULT NULL,
  `year_of_purchase` year(4) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `longg` float DEFAULT NULL,
  `location_address` text NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) DEFAULT '0',
  `tax` float DEFAULT '0',
  `is_rent` enum('1','0') NOT NULL,
  `rent_price` int(11) DEFAULT NULL,
  `rent_price_duration` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `status` tinyint(6) NOT NULL DEFAULT '1',
  `is_approve` enum('0','1','2') DEFAULT '0',
  `owner_discount` float NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `subcategory_id`, `seller_id`, `title`, `description`, `brand_id`, `year_of_purchase`, `lat`, `longg`, `location_address`, `city`, `price`, `discount`, `tax`, `is_rent`, `rent_price`, `rent_price_duration`, `quantity`, `status`, `is_approve`, `owner_discount`, `created_at`, `updated_at`) VALUES
(53, 1, 4, 65, 'Bike', 'Royal Enfield', NULL, 2011, 23.0009, 72.3457, 'Thaltej ,Ahmedabad', '', 2999099, 0, 0, '0', NULL, NULL, 1, 1, '1', 0, '2020-02-20 07:21:55', '2020-02-20 09:16:33'),
(54, 1, 4, 65, 'Bike', 'Description', 1, 2011, 23.0009, 72.3457, 'prahlad nagar, Bodakdev ahmedabad', 'ahmedabad', 2999099, 0, 0, '0', NULL, NULL, 2, 1, '1', 0, '2020-02-20 07:23:53', '2020-02-20 08:34:17'),
(55, 1, 4, 65, 'tree', 'Description', 1, 2015, 23.0169, 72.5057, 'prahlad nagar, Bodakdev ahmedabad', 'ahmedabad', 12, 0, 0, '0', NULL, NULL, 1, 1, '1', 0, '2020-02-20 08:12:12', '2020-02-20 08:34:20'),
(56, 1, 4, 65, 'location', 'Description', 1, 2014, 23.0169, 72.5057, 'prahlad nagar, Bodakdev ahmedabad', 'ahmedabad', 123, 0, 0, '0', NULL, NULL, 1, 1, '1', 0, '2020-02-20 08:16:43', '2020-02-20 08:34:23'),
(57, 1, 4, 62, 'pots', 'Description', 1, 2018, 23.0169, 72.5057, 'prahlad nagar, Bodakdev ahmedabad', 'ahmedabad', 89, 0, 0, '0', NULL, NULL, 1, 1, '1', 0, '2020-02-20 08:26:43', '2020-02-20 08:34:25'),
(58, 1, 4, 63, 'hets', 'Description', 1, 2017, 23.0169, 72.5057, 'prahlad nagar, Bodakdev ahmedabad', 'ahmedabad', 12, 0, 0, '0', NULL, NULL, 1, 1, '1', 0, '2020-02-20 08:28:51', '2020-02-20 08:34:29'),
(59, 1, 4, 63, 'kk', 'Description', 1, 2017, 23.0169, 72.5057, 'prahlad nagar, Bodakdev ahmedabad', 'ahmedabad', 1, 0, 0, '0', NULL, NULL, 1, 1, '1', 0, '2020-02-20 08:30:10', '2020-02-20 08:34:30'),
(60, 1, 4, 64, 'jot', 'Description', 1, 2018, 23.0169, 72.5057, 'prahlad nagar, Bodakdev ahmedabad', 'ahmedabad', 9, 0, 0, '0', NULL, NULL, 1, 1, '1', 0, '2020-02-20 08:31:55', '2020-02-20 08:34:32'),
(61, 1, 4, 67, 'Photo Frame', 'Description', 10, 2020, NULL, NULL, 'prahlad nagar, Bodakdev ahmedabad', 'ahmedabad', 10, 0, 0, '0', NULL, NULL, 10, 1, '0', 0, '2020-03-05 10:26:25', '2020-03-05 10:26:25');

-- --------------------------------------------------------

--
-- Table structure for table `product_photos`
--

CREATE TABLE `product_photos` (
  `id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_path` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_photos`
--

INSERT INTO `product_photos` (`id`, `product_id`, `image_name`, `image_path`, `created_at`, `updated_at`) VALUES
(87, 56, '26ef267a0f9ed522cb6c92e7f677065579999.jpg', 'http://64.225.14.21/ecommerce/uploads/products/26ef267a0f9ed522cb6c92e7f677065579999.jpg', '2020-02-20 08:16:43', '2020-02-20 08:16:43'),
(88, 57, '21c7dce635474a24de69feb50745f81344241.jpg', 'http://64.225.14.21/ecommerce/uploads/products/21c7dce635474a24de69feb50745f81344241.jpg', '2020-02-20 08:26:43', '2020-02-20 08:26:43'),
(89, 58, '0ccb8bdaa98a4e89beb5191122c17b6040257.jpg', 'http://64.225.14.21/ecommerce/uploads/products/0ccb8bdaa98a4e89beb5191122c17b6040257.jpg', '2020-02-20 08:28:51', '2020-02-20 08:28:51'),
(90, 59, '9338094610ef143f3412c0c394ea6b2b67741.jpg', 'http://64.225.14.21/ecommerce/uploads/products/9338094610ef143f3412c0c394ea6b2b67741.jpg', '2020-02-20 08:30:10', '2020-02-20 08:30:10'),
(91, 60, '3641395aeebf6d18390375d61ae38f9136477.jpg', 'http://64.225.14.21/ecommerce/uploads/products/3641395aeebf6d18390375d61ae38f9136477.jpg', '2020-02-20 08:31:55', '2020-02-20 08:31:55'),
(92, 61, '7a4045a9ad96aa8823652072593061de62027.jpg', 'http://64.225.14.21/ecommerce/uploads/products/7a4045a9ad96aa8823652072593061de62027.jpg', '2020-03-05 10:26:25', '2020-03-05 10:26:25'),
(93, 61, 'c0872aebb3db52f5b3307423459c975752008.jpg', 'http://64.225.14.21/ecommerce/uploads/products/c0872aebb3db52f5b3307423459c975752008.jpg', '2020-03-05 10:26:25', '2020-03-05 10:26:25'),
(94, 61, '9df40d5798e3987c012801de9f9d297686224.jpg', 'http://64.225.14.21/ecommerce/uploads/products/9df40d5798e3987c012801de9f9d297686224.jpg', '2020-03-05 10:26:25', '2020-03-05 10:26:25');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sub_category 1-1', 'Sub_category 1-1', '2020-02-12 07:27:55', '2020-02-12 09:17:11'),
(2, 2, 'Sub_category 21', 'Sub_category 21', '2020-02-12 07:42:32', '2020-02-12 09:16:34'),
(3, 3, 'Sub_category 31', 'Sub_category 31', '2020-02-12 09:01:06', '2020-02-12 09:16:46'),
(4, 3, 'Sub_category 32', 'Sub_category 32', '2020-02-12 09:01:30', '2020-02-12 09:16:54'),
(5, 1, 'Sub_category 1-2', 'Sub_category 1-2', '2020-02-12 09:01:45', '2020-02-12 09:17:17'),
(6, 1, 'Sub_category 1-3', 'Sub_category 1-3', '2020-02-12 09:01:57', '2020-02-12 09:17:24'),
(7, 4, 'Sub_category 4-1', 'Sub_category 4-1', '2020-02-12 09:02:36', '2020-02-12 09:02:36'),
(8, 4, 'Sub_category 4-2', 'Sub_category 4-2', '2020-02-12 09:02:43', '2020-02-12 09:02:43'),
(9, 5, 'Sub_category 5-1', 'Sub_category 5-1', '2020-02-12 09:03:25', '2020-02-12 09:03:25'),
(12, 5, 'sub category5-2', 'sub category5-2', '2020-02-12 09:06:44', '2020-02-12 09:06:44');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'rutusha', '9RVFrCft1DVvnHvt7bdSuQOFGOV2oE0L', '$2y$13$ypJyQCuCKVvpIDKMCdJdyOZ.7/z6TDkqqf6OOLG0enIEm3EZx/iHy', NULL, 'rutusha1212joshi@gmail.com', 9, 1576498801, 1576498801, 'dW2jJIJJJCpqHsW-RdSVGE6iPStmG2Mq_1576498801'),
(2, 'test', 'BefzqKjhwSUIZor8B7O8CaziZd_j5yOL', '$2y$13$Ivf6LIkF/XblX0cyBs1vuuYtR6vWTWhZetaK.Crn4euylKCJp/oUC', NULL, 'test@test.cpm', 9, 1580893359, 1580893359, 'xkPCn9jb68vu1tWQRnVrmpbmhPzf_6yu_1580893359');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `login_type` enum('1','2','3') NOT NULL DEFAULT '1',
  `phone` bigint(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `is_code_verified` enum('0','1') NOT NULL DEFAULT '0',
  `password_reset_token` text,
  `auth_token` varchar(255) DEFAULT NULL,
  `auth_id` varchar(255) DEFAULT NULL,
  `badge_count` int(11) DEFAULT NULL,
  `status` smallint(6) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `first_name`, `last_name`, `user_name`, `email`, `password`, `login_type`, `phone`, `photo`, `city`, `pincode`, `verification_code`, `is_code_verified`, `password_reset_token`, `auth_token`, `auth_id`, `badge_count`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super', 'Admin', 'super_admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', '1', 44444444, 'http://64.225.14.21/marketplace/uploads/dp/72ab84f0e2fad5b2e22c93c0d713ad1282375.png', 'ahmedabad', NULL, '', '1', '', '', NULL, 0, 1, '2019-12-17 00:00:00', '2020-02-05 09:13:03'),
(62, 3, 'test', 'zenosys', 'test', 'test1@zenosys.com', 'e00cf25ad42683b3df678c61f42c6bda', '1', NULL, 'http://64.225.14.21/ecommerce/uploads/dp/16ada05214aa9a815c6159c4ab55799458369.jpeg', '', NULL, 'f7d0fe8f0261d8fbddcaca5af39c7047991d3f4811b983faf656c493c663d7a6', '1', NULL, 'e774fc2cbc3000315350521147c85340', '', NULL, 1, '2020-02-20 06:42:48', '2020-02-24 14:28:04'),
(63, 3, 'testt', 'zenosys', 'testt', 'test2@zenosys.com', 'e00cf25ad42683b3df678c61f42c6bda', '1', 9033999975, 'http://64.225.14.21/ecommerce/uploads/dp/16ada05214aa9a815c6159c4ab55799475670.jpeg', 'Ahmedabad', 0, '7a592ca4891769a20e512ea30871c09c59d7740ea92efab376ccad013f4065b5', '1', NULL, 'f4f65e0eeb44990ea1bf9f743bf7d11f', '', NULL, 1, '2020-02-20 06:43:46', '2020-03-18 10:52:15'),
(64, 3, 'testtt', 'zenosys', 'testtt', 'test3@gmail.com', 'e00cf25ad42683b3df678c61f42c6bda', '1', NULL, 'http://64.225.14.21/ecommerce/uploads/dp/16ada05214aa9a815c6159c4ab55799469896.jpeg', '', NULL, 'a95d7247d8ba83ae20b28397db1011351fcd2dc2aee66dd46f42510960cdba65', '1', NULL, '', '', NULL, 1, '2020-02-20 06:45:00', '2020-02-20 13:33:24'),
(65, 3, 'rutusha', 'joshI', 'rutusha', 'rutusha.joshi@zenocraft.com', 'e00cf25ad42683b3df678c61f42c6bda', '1', NULL, 'http://64.225.14.21/ecommerce/uploads/dp/16ada05214aa9a815c6159c4ab55799430545.jpeg', '', NULL, 'e44b2d8c6ed8bf342418e39d3e007b16be7bbd79f407aebd085346ddb22348a5', '1', NULL, 'c53a6b7dc0c51114b0ee7a32acdb09dc', '', NULL, 1, '2020-02-20 06:46:26', '2020-03-03 05:58:31'),
(66, 3, 'Rishi', 'Vekaria', 'Rishi Vekaria', '', NULL, '2', NULL, 'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=10212641913041540&height=200&width=200&ext=1585821497&hash=AeROOjBWjkKpoT8N', '', NULL, NULL, '1', NULL, '7cb630b8cf771e590487f0e09ebf3cfd', '', NULL, 1, '2020-03-03 09:58:32', '2020-03-06 11:17:56'),
(67, 3, 'Rishi', 'Vekaria', 'Rishi Vekaria', 'rishi.vekaria@gmail.com', NULL, '3', NULL, 'https://lh4.googleusercontent.com/-S1hnJEsGkZs/AAAAAAAAAAI/AAAAAAAAAAA/AKF05nBAelM2VKP6l7hba3Wp0OPGVNAvyQ/s200/photo.jpg', '', NULL, NULL, '1', NULL, '932ac36f70a172873f9ba7a1b84a90f4', '', NULL, 1, '2020-03-03 10:11:26', '2020-03-18 10:34:40'),
(69, 3, 'rishi', 'vekria', 'rishi vekaria', 'rishi.vekria@gmail.com', NULL, '2', NULL, '', '', NULL, NULL, '1', NULL, 'bd7bb268e7b11b3cad08a44551adf59f', '', NULL, 1, '2020-03-03 10:42:05', '2020-03-03 10:42:05'),
(70, 3, 'Alex', 'ted', 'Alex', 'alex.ted@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1', 1212121212, 'http://64.225.14.21/ecommerce/uploads/dp/16ada05214aa9a815c6159c4ab55799490299.jpeg', 'hhhh', 12121212, '18aeb7033d08f6a221e0b97a034a5b98ee3ae3623c3f4b9d94e735448b114e75', '0', NULL, '', '', NULL, 1, '2020-03-06 10:11:04', '2020-03-06 10:14:48');

-- --------------------------------------------------------

--
-- Table structure for table `user_adresses`
--

CREATE TABLE `user_adresses` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `address` text NOT NULL,
  `pincode` int(11) NOT NULL,
  `lat` float DEFAULT NULL,
  `longg` float DEFAULT NULL,
  `is_default` enum('1','0') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_adresses`
--

INSERT INTO `user_adresses` (`id`, `user_id`, `address`, `pincode`, `lat`, `longg`, `is_default`, `created_at`, `updated_at`) VALUES
(5, 63, 'Gurudwara, Bodakdev , ahmedabad', 380060, NULL, NULL, '0', '2020-03-11 06:07:30', '2020-03-11 10:07:37'),
(6, 63, 'Zenosys, Bodakdev , ahmedabad', 380060, NULL, NULL, '1', '2020-03-11 10:03:08', '2020-03-11 10:07:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `role_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `role_name`, `role_description`) VALUES
(1, 'super_admin', 'Super Admin'),
(2, 'admin', 'admin'),
(3, 'user', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_rules`
--

CREATE TABLE `user_rules` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `privileges_controller` varchar(255) NOT NULL,
  `privileges_actions` text NOT NULL,
  `permission` enum('allow','deny') NOT NULL DEFAULT 'allow',
  `permission_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_rules`
--

INSERT INTO `user_rules` (`id`, `role_id`, `privileges_controller`, `privileges_actions`, `permission`, `permission_type`) VALUES
(1, 1, 'SiteController', 'index,logout,change-password,forgot-password', 'allow', 'super admin'),
(2, 2, 'SiteController', 'index,logout,change-password,forgot-password', 'allow', 'admin'),
(3, 1, 'UsersController', 'index,create,view,update,delete', 'allow', 'super admin'),
(4, 2, 'UsersController', 'index,create,view,update,delete', 'allow', 'admin'),
(5, 1, 'CategoriesController', 'index,create,update,delete,view', 'allow', 'super admin'),
(6, 2, 'CategoriesController', 'index,create,update,delete,view', 'allow', 'admin'),
(7, 1, 'ProductsController', 'index,create,update,delete,view,approve-product', 'allow', 'super admin'),
(8, 2, 'ProductsController', 'index,create,update,delete,view,approve-product', 'allow', 'admin'),
(9, 1, 'user-addressesController', 'index,create,update,delete,view', 'allow', 'super admin'),
(10, 2, 'user-addressesController', 'index,create,update,delete,view', 'allow', 'admin'),
(11, 1, 'sub-categoriesController', 'index,create,update,delete,view', 'allow', 'super admin'),
(12, 2, 'sub-categoriesController', 'index,create,update,delete,view', 'allow', 'admin'),
(13, 1, 'CategoryController', 'index,create,update,delete,view', 'allow', 'super admin'),
(14, 2, 'CategoryController', 'index,create,update,delete,view', 'allow', 'admin'),
(15, 2, 'BrandsController', 'index,create,update,delete,view', 'allow', 'admin'),
(16, 1, 'BrandsController', 'index,create,update,delete,view', 'allow', 'super admin'),
(17, 1, 'OrdersController', 'index,create,update,delete,view', 'allow', 'super admin'),
(18, 2, 'OrdersController', 'index,create,update,delete,view', 'allow', 'admin'),
(19, 2, 'OrdersController', 'index,create,update,delete,view', 'allow', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_rules_menu`
--

CREATE TABLE `user_rules_menu` (
  `id` int(10) NOT NULL,
  `category` enum('admin','front-top','front-bottom','front-middle') NOT NULL DEFAULT 'admin',
  `parent_id` int(10) NOT NULL DEFAULT '0',
  `user_rules_id` int(10) NOT NULL,
  `label` varchar(255) NOT NULL,
  `class` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `position` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 - inactive, 1 - active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_rules_menu`
--

INSERT INTO `user_rules_menu` (`id`, `category`, `parent_id`, `user_rules_id`, `label`, `class`, `url`, `position`, `status`) VALUES
(1, 'admin', 0, 1, 'Dashboard', 'icon-home', 'site/index', 1, 1),
(2, 'admin', 0, 2, 'Dashboard', 'icon-home', 'site/index', 1, 1),
(3, 'admin', 0, 3, 'Manage Users', 'icon-user', 'users/index', 2, 1),
(4, 'admin', 0, 4, 'Manage Users', 'icon-user', 'users/index', 2, 1),
(5, 'admin', 0, 5, 'Manage Categories', 'icon-user', 'categories/index', 3, 0),
(6, 'admin', 0, 6, 'Manage Categories', 'icon-user', 'categories/index', 3, 0),
(12, 'admin', 0, 7, 'Manage Products', 'icon-user', 'products/index', 6, 1),
(13, 'admin', 0, 8, 'Manage Products', 'icon-user', 'products/index', 6, 1),
(14, 'admin', 0, 13, 'Manage Categories', 'icon-user', 'category/index', 4, 1),
(15, 'admin', 0, 14, 'Manage Categories', 'icon-user', 'category/index', 4, 1),
(16, 'admin', 0, 15, 'Manage Brands', 'icon-user', 'brands/index', 5, 1),
(17, 'admin', 0, 16, 'Manage Brands', 'icon-user', 'brands/index', 5, 1),
(18, 'admin', 0, 17, 'Manage Orders', 'icon-user', 'orders/index', 6, 1),
(19, 'admin', 0, 18, 'Manage Orders', 'icon-user', 'orders/index', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wish_list`
--

CREATE TABLE `wish_list` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wish_list`
--

INSERT INTO `wish_list` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(4, 63, 53, '2020-02-25 13:12:33', '2020-02-25 13:12:33'),
(5, 70, 61, '2020-03-06 10:11:25', '2020-03-06 10:11:25'),
(6, 70, 55, '2020-03-06 10:13:46', '2020-03-06 10:13:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`parent_category_id`),
  ADD KEY `sub_category_id` (`sub_category_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `chat_list`
--
ALTER TABLE `chat_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `chat_user_id` (`chat_user_id`);

--
-- Indexes for table `device_details`
--
ALTER TABLE `device_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `email_format`
--
ALTER TABLE `email_format`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `user_address_id_fk` (`user_address_id`);

--
-- Indexes for table `order_payment`
--
ALTER TABLE `order_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_category` (`category_id`),
  ADD KEY `product_seller` (`seller_id`),
  ADD KEY `subcategory` (`subcategory_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `product_photos`
--
ALTER TABLE `product_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `which_product` (`product_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_category` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-users-role_id` (`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_adresses`
--
ALTER TABLE `user_adresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_rules`
--
ALTER TABLE `user_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_rules_menu`
--
ALTER TABLE `user_rules_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_rules_id` (`user_rules_id`);

--
-- Indexes for table `wish_list`
--
ALTER TABLE `wish_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_id_2` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `chat_list`
--
ALTER TABLE `chat_list`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `device_details`
--
ALTER TABLE `device_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `email_format`
--
ALTER TABLE `email_format`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `order_payment`
--
ALTER TABLE `order_payment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `product_photos`
--
ALTER TABLE `product_photos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT for table `user_adresses`
--
ALTER TABLE `user_adresses`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_rules`
--
ALTER TABLE `user_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `user_rules_menu`
--
ALTER TABLE `user_rules_menu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `wish_list`
--
ALTER TABLE `wish_list`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `aubcategory_fk` FOREIGN KEY (`sub_category_id`) REFERENCES `Category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `brand_category_fk` FOREIGN KEY (`parent_category_id`) REFERENCES `Category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_product_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Category`
--
ALTER TABLE `Category`
  ADD CONSTRAINT `parent category` FOREIGN KEY (`parent_id`) REFERENCES `Category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chat_list`
--
ALTER TABLE `chat_list`
  ADD CONSTRAINT `chat_user_id` FOREIGN KEY (`chat_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `device_details`
--
ALTER TABLE `device_details`
  ADD CONSTRAINT `fk_userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `buyer_fk` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_address_id_fk` FOREIGN KEY (`user_address_id`) REFERENCES `user_adresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `brand_fk` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `parent_category_fk` FOREIGN KEY (`category_id`) REFERENCES `Category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_seller` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sub_category_fk` FOREIGN KEY (`subcategory_id`) REFERENCES `Category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_photos`
--
ALTER TABLE `product_photos`
  ADD CONSTRAINT `which_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `parent_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `user_adresses`
--
ALTER TABLE `user_adresses`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wish_list`
--
ALTER TABLE `wish_list`
  ADD CONSTRAINT `product_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_wishlist_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
