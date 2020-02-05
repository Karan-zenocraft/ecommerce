-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 05, 2020 at 02:25 PM
-- Server version: 5.7.28-0ubuntu0.18.04.4
-- PHP Version: 7.2.27-5+ubuntu18.04.1+deb.sury.org+2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marketplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `device_details`
--

CREATE TABLE `device_details` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `device_tocken` varchar(6000) DEFAULT NULL,
  `type` enum('1','2') NOT NULL,
  `gcm_id` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `device_details`
--

INSERT INTO `device_details` (`id`, `user_id`, `device_tocken`, `type`, `gcm_id`, `created_at`) VALUES
(47, 4, '1122', '1', '', '2020-01-06 12:10:48'),
(48, 5, '1122', '1', '', '2020-01-06 12:32:12'),
(49, 6, '1122', '1', '', '2020-01-06 12:44:31'),
(50, 7, '', '1', '', '2020-01-22 13:53:12'),
(51, 8, '', '1', '', '2020-01-16 11:42:44'),
(52, 9, '123456', '1', '', '2020-01-22 13:23:47'),
(53, 10, '123456', '1', '', '2020-01-22 13:25:24'),
(54, 11, '', '1', '', '2020-01-22 13:25:26'),
(55, 12, '1122', '1', '', '2020-01-22 13:34:36'),
(56, 13, '1122', '1', '', '2020-01-22 13:35:44'),
(57, 14, '1122', '1', '', '2020-01-22 13:35:50'),
(58, 15, '1122', '1', '', '2020-01-22 13:36:15'),
(59, 16, '6666', '1', '', '2020-01-22 13:37:12'),
(62, 19, '', '1', '', '2020-01-22 13:52:34'),
(63, 20, '123456', '2', '', '2020-01-22 14:00:30'),
(64, 21, '1122', '1', '', '2020-01-22 14:02:06'),
(65, 22, '7777', '2', '', '2020-01-22 14:04:56'),
(66, 23, '', '1', '', '2020-01-22 14:04:59'),
(67, 24, '123456', '2', '', '2020-01-22 14:06:13'),
(68, 25, '7777', '2', '', '2020-01-22 14:06:29'),
(69, 26, '123456', '2', '', '2020-01-22 14:07:42'),
(70, 27, '1122', '1', '', '2020-01-22 14:08:00'),
(71, 28, '', '1', '', '2020-01-22 14:17:55'),
(72, 18, '123456', '2', NULL, '2020-02-04 12:22:22');

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
(1, 'forgot_password', 'Forgot Password', '<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" align=\"center\" valign=\"top\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" bgcolor=\"FFFFFF\" border=\"0\" width=\"650\">\n                <tbody>\n                    <tr>\n                        <td style=\"background: #444444; \" bgcolor=\"#EAEAEA\" valign=\"top\"><p style=\"color:#fff;display: inline-flex;\">&nbsp;&nbsp;Clin Essentials</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Dear  {username},</p>\n                        <p>Your New Password is :<br></p><p><strong>E-mail:</strong> {email}<br>\n                         </p><p><strong>Password:</strong> {password}<br>\n\n                        </p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">Clin Essentials team</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>\n', 1, '2019-12-12 00:00:00', NULL),
(2, 'user_registration', 'Clin Essentials -New Account', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\n                <tbody>\n                    <tr>\n                        <td style=\"background:#444444;color: white; \" valign=\"top\" bgcolor=\"#EAEAEA\"><p>Clin Essentials</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Dear  {username},</p>\n                        <p>Your account has been created.<br></p>\n                          <p><strong>E-mail:</strong> {email} <br></p>\n<p><strong>Password:</strong> {password} <br></p>\n<p>Please click on below link for verify your Email :</p>\n<p>{email_verify_link}</p>\n                        <p></p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">Clin Essentials Team</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>\n', 1, '2019-12-12 00:00:00', NULL),
(3, 'reset_password', 'Reset Password', '<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" align=\"center\" valign=\"top\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" bgcolor=\"FFFFFF\" border=\"0\" width=\"650\">\n                <tbody>\n                   <tr>\n                        <td style=\"background: #444444; \" bgcolor=\"#EAEAEA\" valign=\"top\"><p style=\"color:#fff;display: inline-flex;\">&nbsp;&nbsp;Clin Essentials</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Dear  {username},</p>\n                        <p>Follow the link below to reset your password:</p>\n                        <p>{resetLink}</p>\n\n                        </p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">Clin Essentials</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>\n', 1, '2019-12-12 00:00:00', NULL),
(4, 'contact_us', 'Clin Essentials Contact', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\n                <tbody>\n                     <tr>\n                        <td style=\"background: #444444; \" bgcolor=\"#EAEAEA\" valign=\"top\"><p style=\"color:#fff;display: inline-flex;\">&nbsp;&nbsp;Clin Essentials</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Hello  Food App Admin,\n                        <p>{message}<br></p>\n                        <p></p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">{name}</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>\n', 1, '2019-12-12 00:00:00', NULL),
(5, 'backend_registration', 'Clin Essentials -New Account', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\n                <tbody>\n                    <tr>\n                        <td style=\"background:#444444;color: white; \" valign=\"top\" bgcolor=\"#EAEAEA\"><p>Clin Essentials</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Dear  {username},</p>\n                        <p>Your account has been created.<br></p>\n                          <p><strong>E-mail:</strong> {email} <br></p>\n                            <p><strong>Password:</strong> {password} <br></p>\n                            <p>Your role is {role}</p>\n                        <p></p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">Clin Essentials Team</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>\n', 1, '2019-12-12 00:00:00', NULL),
(6, 'note_email', 'Clin Essentials -Note ', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\r\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\r\n                <tbody>\r\n                    <tr>\r\n                        <td style=\"background:#444444;color: white; \" valign=\"top\" bgcolor=\"#EAEAEA\"><p>Clin Essentials</p><p></p><p></p></td>\r\n                    </tr>\r\n                    <!-- [ middle starts here] -->\r\n                    <tr>\r\n                        <td valign=\"top\">\r\n                        <p>Dear  Patient,</p>\r\n                        <p>Please found attached pdf file.<br></p>\r\n                        <p></p><p>&nbsp;</p>\r\n                        </td>\r\n                    </tr>\r\n                   <tr>\r\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\r\n                        <p style=\"font-size:12px; margin:0;\">Clin Essentials Team</p>\r\n                        </center></td>\r\n                    </tr>\r\n                </tbody>\r\n            </table>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n', 1, '2019-12-12 00:00:00', NULL),
(7, 'todolist_email', 'Clin Essentials - Visit to do list', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\r\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\r\n                <tbody>\r\n                    <tr>\r\n                        <td style=\"background:#444444;color: white; \" valign=\"top\" bgcolor=\"#EAEAEA\"><p>Clin Essentials</p><p></p><p></p></td>\r\n                    </tr>\r\n                    <!-- [ middle starts here] -->\r\n                    <tr>\r\n                        <td valign=\"top\">\r\n                        <p>Dear  Patient,</p>\r\n                        <p>Please found attached pdf file.<br></p>\r\n                        <p></p><p>&nbsp;</p>\r\n                        </td>\r\n                    </tr>\r\n                   <tr>\r\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\r\n                        <p style=\"font-size:12px; margin:0;\">Clin Essentials Team</p>\r\n                        </center></td>\r\n                    </tr>\r\n                </tbody>\r\n            </table>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n', 1, '2020-01-31 00:00:00', '2020-01-31 00:00:00'),
(8, 'action_items_email', 'Clin Essentials - Action Items', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\r\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\r\n                <tbody>\r\n                    <tr>\r\n                        <td style=\"background:#444444;color: white; \" valign=\"top\" bgcolor=\"#EAEAEA\"><p>Clin Essentials</p><p></p><p></p></td>\r\n                    </tr>\r\n                    <!-- [ middle starts here] -->\r\n                    <tr>\r\n                        <td valign=\"top\">\r\n                        <p>Dear  Patient,</p>\r\n                        <p>Please found attached pdf file.<br></p>\r\n                        <p></p><p>&nbsp;</p>\r\n                        </td>\r\n                    </tr>\r\n                   <tr>\r\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\r\n                        <p style=\"font-size:12px; margin:0;\">Clin Essentials Team</p>\r\n                        </center></td>\r\n                    </tr>\r\n                </tbody>\r\n            </table>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n', 1, '2020-01-31 00:00:00', '2020-01-31 00:00:00'),
(9, 'critical_study_protocol', 'Clin Essentials - Critical Study Protocol', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\r\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\r\n                <tbody>\r\n                    <tr>\r\n                        <td style=\"background:#444444;color: white; \" valign=\"top\" bgcolor=\"#EAEAEA\"><p>Clin Essentials</p><p></p><p></p></td>\r\n                    </tr>\r\n                    <!-- [ middle starts here] -->\r\n                    <tr>\r\n                        <td valign=\"top\">\r\n                        <p>Dear  Patient,</p>\r\n                        <p>Please found attached pdf file.<br></p>\r\n                        <p></p><p>&nbsp;</p>\r\n                        </td>\r\n                    </tr>\r\n                   <tr>\r\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\r\n                        <p style=\"font-size:12px; margin:0;\">Clin Essentials Team</p>\r\n                        </center></td>\r\n                    </tr>\r\n                </tbody>\r\n            </table>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n', 1, '2020-01-31 00:00:00', '2020-01-31 00:00:00');

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
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `color_code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `color_code`, `title`) VALUES
(1, '#5f5f9c', 'Adverse Event'),
(2, '#c9869d', 'Adverse Event of \\n Special Interest'),
(3, '#ffffff', 'Blank Note'),
(4, '#bcbcbc', 'Concomitant \\n Medication'),
(5, '#a46199', 'Per The eCRF'),
(6, '#acc753', 'Please Add to Drug\r\nAccountability Log'),
(7, '#97b6b1', 'Per The Source'),
(8, '#ddb948', 'Please Clarify'),
(9, '#ce8b3f', 'Please Complete'),
(10, '#76af9d', 'Please File'),
(11, '#768dc3', 'Please Reconcile'),
(12, '#b75a84', 'Please Report to IRB/EC'),
(13, '#7da1bb', 'Prior to the Next Visit'),
(14, '#d35b43', 'Protocol Deviation'),
(15, '#95564f', 'Serious Adverse Event'),
(16, '#d17341', 'Temperature Excursion');

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
(1, 'rutusha', '9RVFrCft1DVvnHvt7bdSuQOFGOV2oE0L', '$2y$13$ypJyQCuCKVvpIDKMCdJdyOZ.7/z6TDkqqf6OOLG0enIEm3EZx/iHy', NULL, 'rutusha1212joshi@gmail.com', 9, 1576498801, 1576498801, 'dW2jJIJJJCpqHsW-RdSVGE6iPStmG2Mq_1576498801');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` bigint(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `is_code_verified` enum('0','1') NOT NULL DEFAULT '0',
  `password_reset_token` text,
  `auth_token` varchar(255) DEFAULT NULL,
  `badge_count` int(11) DEFAULT NULL,
  `status` smallint(6) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `user_name`, `email`, `password`, `phone`, `photo`, `verification_code`, `is_code_verified`, `password_reset_token`, `auth_token`, `badge_count`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'super_admin', 'rutusha1212joshi@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 44444444, '45ac63f556943e88ff3413af1def39f764654.png', '', '0', '', '', 0, 1, '2019-12-17 00:00:00', '2019-12-17 00:00:00'),
(3, 3, 'rutusha', 'rutusha.joshi@zenocraft.com', '21232f297a57a5a743894a0e4a801fc3', 8080788989, '45ac63f556943e88ff3413af1def39f768922.png', 'f74d32646cc637745f4c067d1fd6dafc3da37f56246d8e307c303d96575891e7', '0', 'iGINfKjjU1jm6RAJYa-jxdjXhKvbdFAJ_1578641421', '2f257615877d87cf3b306094de798367', NULL, 1, '2020-01-06 11:22:49', '2020-02-04 08:48:55'),
(4, 3, 'rutusha', 'rutusha.joshi@zenocraft.com1', '21232f297a57a5a743894a0e4a801fc3', 8080788982, NULL, 'f26bb6d9182e29104b52a60dcde9a1c8734ade58732e93e31c95a6b8a4629e18', '0', NULL, '2f257615877d87cf3b306094de79833e', NULL, 1, '2020-01-06 12:10:48', '2020-01-06 12:10:48'),
(5, 3, 'dipak', 'dipak.vyas@zenocraft.com', '21232f297a57a5a743894a0e4a801fc3', 80807889822, NULL, 'd0d1a348edc39f3d881afc22236b156f973f810c60004363f679033f87f57e1c', '0', '0clvimBSMDr-jibIPt3Eu0GJjtloYz8f_1578641902', '8225a49d5236ff5b7c720bcfce0bc4ba', NULL, 1, '2020-01-06 12:32:12', '2020-01-10 07:38:22'),
(6, 3, 'rutusha', 'rutusha.joshi@zenocraft.com123', '21232f297a57a5a743894a0e4a801fc3', 808078898223, NULL, '4700f17382c5d0c29e104efe8818f42e6a19ac72832e8207e098119faaed34c2', '0', NULL, '73bcf4ebfac185374bba112a4ab863e5', NULL, 1, '2020-01-06 12:44:31', '2020-01-06 12:44:31'),
(7, 3, 'Dipak', 'vyasdipak991@gmail.com', '7488e331b8b64e5794da3fa4eb10ad5d', 9428589787, NULL, 'a8bfd93a2dcab261d963ec03d5c17005bf0459628f5de4610666463e3085b8ad', '0', 'uyPNVfMgjTdicYTYRHyhPd61hlbLIIDK_1579846456', '931a1c1072f0113c4f12faf4aa0f80d5', NULL, 1, '2020-01-16 07:05:12', '2020-01-24 07:01:58'),
(8, 3, 'hv ivy', 'vyasdipak1991@gmail.com', '25d55ad283aa400af464c76d713c07ad', 9853637378383, NULL, 'a491d8a020ed482c1f046f4c0b3603bde3fdd6b4e40f62589fafc0ee69dbd911', '0', NULL, '5adfa7b05317631b14184697ce644328', NULL, 1, '2020-01-16 11:42:43', '2020-01-16 11:42:43'),
(9, 3, 'rishi', 'rishi@gmail.com', '25d55ad283aa400af464c76d713c07ad', 2, NULL, 'b8fa9d6d3f9098293773e9e30285fa1aeb310010e8645b1d8e5016739fe5e052', '0', NULL, 'ce0d3bee011c932842f776ba790f69a0', NULL, 1, '2020-01-22 13:23:47', '2020-01-22 13:28:31'),
(10, 3, 'rishi', 'rishi1@gmail.com', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, '67389892a65f17a4869753922f35679002bf0963b2d6a1d815ffdf101c241e95', '0', NULL, 'eceb2dd503f8cfa0f5e8521bc4eeab1d', NULL, 1, '2020-01-22 13:25:23', '2020-01-22 13:25:23'),
(11, 3, 'fjff', 'vyasdipak2991@gmail.com', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, '7e76601331bf4ab3280547e7b5be386fcc0b8ef4bc0ae3b7e137ab0a4d75a141', '0', NULL, '266d31673b695fa3f9901fed1d449a40', NULL, 1, '2020-01-22 13:25:26', '2020-01-22 13:25:26'),
(12, 3, 'rutusha', 'rutushsa.joshi@zenocraft.com', '21232f297a57a5a743894a0e4a801fc3', 808078, '45ac63f556943e88ff3413af1def39f788511.png', '204ffc9b1d0a2d4ca45a85c1d272bf52dcca350bf8e926de6e74c6019e86d9cf', '0', NULL, '7efb70d0bb10ca0ac079c22263e7e18f', NULL, 1, '2020-01-22 13:34:36', '2020-01-22 13:34:36'),
(13, 3, 'rutusha', 'rutusha1.joshi@zenocraft.com', '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, 'cbc9b7b2633dde970267009e2aebf166b89415d18e639b2a55fa8ca8cd115f96', '0', NULL, '7afae827e97415a79846dec88c063ae1', NULL, 1, '2020-01-22 13:35:44', '2020-01-22 13:35:44'),
(14, 3, 'rutusha', 'rutushsas.joshi@zenocraft.com', '21232f297a57a5a743894a0e4a801fc3', NULL, '45ac63f556943e88ff3413af1def39f744119.png', '77ca8815a5a0c90db339b83f348d90ee04758c02f15159af6865f6bf844a459a', '0', NULL, 'cdd6b1fc41a7acf806abe89ab4027d43', NULL, 1, '2020-01-22 13:35:50', '2020-01-22 13:35:50'),
(15, 3, 'rutusha', 'rutusha21.joshi@zenocraft.com', '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, '9c46c7e18a1a11e8535de7428fc8f4214fef4e91f38ff1ca64b94ee88ff6ec69', '0', NULL, '83cc2cd2648808f390d6a57d62167b1f', NULL, 1, '2020-01-22 13:36:15', '2020-01-22 13:36:15'),
(16, 3, 'rutusha', 'r.joshi@zenocraft.com', '21232f297a57a5a743894a0e4a801fc3', NULL, '45ac63f556943e88ff3413af1def39f786011.png', '601d6c8d787d0d8a7fc2096304bc5a6bee16ea9fe3408b6901f92837c521d210', '0', NULL, '09faac2926f859ae4324d38c7e786ff5', NULL, 1, '2020-01-22 13:37:11', '2020-01-22 13:37:11'),
(17, 3, 'rutusha', 'r1.joshi@zenocraft.com', '21232f297a57a5a743894a0e4a801fc3', NULL, '45ac63f556943e88ff3413af1def39f771656.png', '470c08b19c6650270f1170659b7a8de7692b47933ac332271871abff03ee2a33', '0', NULL, '', NULL, 1, '2020-01-22 13:38:57', '2020-02-04 12:09:48'),
(18, 3, 'admin', 'admin1@gmail.com', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, 'a4d1eeb8ca1baa117383244bfaaac4c535c8392849b555ad4d1a6c6174909def', '0', NULL, '6ad7d777f0712ff49324174468e7a20e', NULL, 1, '2020-01-22 13:42:55', '2020-02-04 12:22:22'),
(19, 3, 'gxhchch', 'vyasdipak7991@gmail.com', '7488e331b8b64e5794da3fa4eb10ad5d', NULL, NULL, '0be5a2776bcb9ece51032ae0e9f424005684c7b91e9c35c92b5b1626c6d66565', '0', NULL, '99579102933544c7e7cd19311351ac0f', NULL, 1, '2020-01-22 13:52:34', '2020-01-22 13:52:34'),
(20, 3, 'rocky', 'rocky@gmail.com', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, '71652ff4ac567578a89d030b933c4e14b4dd6e6eb150f4881bf3bc3778e78363', '0', NULL, '4afbba926f8b2cfaf0fd049db0d6f352', NULL, 1, '2020-01-22 14:00:30', '2020-01-22 14:00:30'),
(21, 3, 'rutusha', 'rutusha.joshi@zenocraft.com12334', '21232f297a57a5a743894a0e4a801fc3', 808078898223, NULL, '6073b5107d1ac9030a6b7013b8a303d503d2e94c455fa1f708b5837eb2cb956c', '0', NULL, 'fecc7a68bb6495bb26b6fba1ded5d7bb', NULL, 1, '2020-01-22 14:02:06', '2020-01-22 14:02:06'),
(22, 3, 'rutusha', 'r4.joshi@zenocraft.com', '21232f297a57a5a743894a0e4a801fc3', NULL, '45ac63f556943e88ff3413af1def39f725803.png', '4a9bb9fd4844e56a8274731f2489d4ed34f2746d184499417dd85d210de72a06', '0', NULL, 'ac438ef44f60a62513dc111b5eeaaa76', NULL, 1, '2020-01-22 14:04:55', '2020-01-22 14:04:55'),
(23, 3, 'hdhfhhf', 'vyasdipak12991@gmail.com', '7488e331b8b64e5794da3fa4eb10ad5d', NULL, NULL, '70ee1cfc399880cf98dd35670de4575f5e5a2d78252070385199241097779b86', '0', NULL, '91d1a723f807bf2ed973aa439c046be8', NULL, 1, '2020-01-22 14:04:59', '2020-01-22 14:04:59'),
(24, 3, 'rishi', 'rishi12@gmail.com', '22d7fe8c185003c98f97e5d6ced420c7', NULL, NULL, 'e330044854671c9388b91adc92046dcfed98d640f56d51308cdd621c720b4ef4', '0', NULL, '32c0be5dfc5a10af533e37d23935d647', NULL, 1, '2020-01-22 14:06:13', '2020-01-22 14:06:13'),
(25, 3, 'rutusha', 'r5.joshi@zenocraft.com', '21232f297a57a5a743894a0e4a801fc3', NULL, '45ac63f556943e88ff3413af1def39f737935.png', '6a6140f028c673f9d9dbd792d063ef1afba778427d6affec72532fe421a5f035', '0', NULL, '03a1351e5ef4c529c6a260604c8ed169', NULL, 1, '2020-01-22 14:06:29', '2020-01-22 14:06:29'),
(26, 3, 'rishi', 'rishias@gmail.com', '25f9e794323b453885f5181f1b624d0b', NULL, NULL, 'cec57197bcc5dac20782cade646b1d6138bb52d89532ee9df9227c7305661f6d', '0', NULL, '4ec786cceda08ff5eb5e53e43e580231', NULL, 1, '2020-01-22 14:07:42', '2020-01-22 14:07:42'),
(27, 3, 'rutusha', 'rutusha.joshi@zenocraft.com12334r5', '21232f297a57a5a743894a0e4a801fc3', 808078898223, NULL, 'f4fa366cc18dace4b3bdc6926f22c85798b021d266fca2be7d7e00dacab27c27', '0', NULL, 'fd2d9ab9e4303d0e130b3ab376fcc148', NULL, 1, '2020-01-22 14:07:59', '2020-01-22 14:07:59'),
(28, 3, 'gshdjjdjfj', 'vyasdipak961@gmail.com', '7488e331b8b64e5794da3fa4eb10ad5d', NULL, NULL, 'cf8344fc65713852760f663918273d5c12a96531ceb02c57c036e0b8b7a3d23c', '0', NULL, 'd98ed79ea5077bb83aec803120850838', NULL, 1, '2020-01-22 14:17:55', '2020-01-22 14:17:55'),
(34, 3, 'root', 'ranagaya@gmail.com', '21232f297a57a5a743894a0e4a801fc3', NULL, 'bk7_5e293c620367b.png', '90810b35ee93a5ee0fdd234a9d71da036680b0e1ace2259696337da9bca829d8', '0', NULL, NULL, NULL, 1, '2020-01-23 06:25:38', '2020-01-23 06:25:38');

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
(5, 1, 'PagesController', 'index,create,update,delete,view,delete-all', 'allow', 'super admin'),
(6, 2, 'PagesController', 'index,create,update,delete,view,delete-all', 'allow', 'admin');

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
(5, 'admin', 0, 5, 'Manage Pages', 'icon-user', 'pages/index', 3, 1),
(11, 'admin', 0, 6, 'Manage Pages', 'icon-user', 'pages/index', 3, 1);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `device_details`
--
ALTER TABLE `device_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `email_format`
--
ALTER TABLE `email_format`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_rules`
--
ALTER TABLE `user_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_rules_menu`
--
ALTER TABLE `user_rules_menu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `device_details`
--
ALTER TABLE `device_details`
  ADD CONSTRAINT `fk_userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
