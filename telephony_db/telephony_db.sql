-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 03, 2025 at 03:02 AM
-- Server version: 10.6.18-MariaDB-log
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `telephony_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `after_office_ivr_tbl`
--

CREATE TABLE `after_office_ivr_tbl` (
  `id` int(11) NOT NULL,
  `campaign_Id` varchar(100) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `admin` varchar(100) NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `block_no`
--

CREATE TABLE `block_no` (
  `id` int(11) NOT NULL,
  `block_no` varchar(255) NOT NULL,
  `admin` varchar(255) NOT NULL,
  `ins_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `break_time`
--

CREATE TABLE `break_time` (
  `id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `mobile_no` varchar(50) NOT NULL,
  `break_name` varchar(500) NOT NULL,
  `start_time` varchar(200) NOT NULL,
  `break_duration` varchar(100) NOT NULL,
  `end_time` varchar(200) NOT NULL,
  `break_status` varchar(50) NOT NULL,
  `status` varchar(200) NOT NULL,
  `campaign_id` varchar(200) NOT NULL,
  `press_key` varchar(100) NOT NULL,
  `agent_priorty` varchar(100) NOT NULL,
  `take_call_mobile` varchar(100) NOT NULL,
  `menu_prompt` varchar(100) NOT NULL,
  `parent_option` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cdr`
--

CREATE TABLE `cdr` (
  `id` int(10) NOT NULL,
  `admin` varchar(200) NOT NULL,
  `did` varchar(50) NOT NULL,
  `uniqueid` varchar(200) NOT NULL,
  `call_from` varchar(200) NOT NULL,
  `call_to` varchar(200) NOT NULL,
  `start_time` varchar(200) NOT NULL,
  `end_time` varchar(200) NOT NULL,
  `dur` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `record_url` varchar(250) NOT NULL,
  `direction` varchar(200) NOT NULL,
  `hangup` varchar(100) NOT NULL,
  `campaign_id` varchar(200) NOT NULL,
  `agent_remark` varchar(50) NOT NULL COMMENT 'agents performance number',
  `remark_comments` varchar(250) NOT NULL COMMENT 'Remark Comments',
  `created_by` varchar(50) NOT NULL COMMENT 'The user ID who added the remark',
  `created_time` varchar(50) NOT NULL COMMENT 'The date and time when the remark was added'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compaign_list`
--

CREATE TABLE `compaign_list` (
  `id` int(11) NOT NULL,
  `compaign_id` varchar(255) NOT NULL,
  `compaignname` varchar(255) NOT NULL,
  `campaign_number` varchar(255) NOT NULL,
  `outbond_cli` varchar(100) NOT NULL,
  `campaign_dis` varchar(100) NOT NULL,
  `creat_date` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `music_on_hold` varchar(255) DEFAULT NULL,
  `welcome_ivr` varchar(255) DEFAULT NULL,
  `after_office_ivr` varchar(255) DEFAULT NULL,
  `week_off_ivr` varchar(100) NOT NULL,
  `ring_tone_music` varchar(100) NOT NULL,
  `no_agent_ivr` varchar(100) NOT NULL,
  `local_call_time` varchar(100) DEFAULT NULL,
  `week_off` varchar(100) NOT NULL,
  `script_notes` varchar(100) DEFAULT NULL,
  `get_call_lunch` varchar(255) DEFAULT NULL,
  `admin` varchar(255) DEFAULT NULL,
  `ring_time` varchar(100) DEFAULT NULL,
  `agent_number` varchar(255) DEFAULT NULL,
  `ivr` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `noagent_file_name` varchar(200) NOT NULL,
  `ringtone_file_name` varchar(200) NOT NULL,
  `auto_dial_level` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

CREATE TABLE `company_info` (
  `id` int(11) NOT NULL,
  `cdr_uniqueid` varchar(100) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `employee_size` int(11) DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `phone_2` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `dialstatus` varchar(255) DEFAULT NULL,
  `campaign_id` varchar(100) NOT NULL,
  `upload_user` varchar(100) NOT NULL,
  `ins_date` varchar(50) NOT NULL,
  `remark` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dialout`
--

CREATE TABLE `dialout` (
  `id` int(10) NOT NULL,
  `agent` varchar(200) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `number` varchar(200) NOT NULL,
  `response` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `did_list`
--

CREATE TABLE `did_list` (
  `id` int(11) NOT NULL,
  `did` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `extension` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `admin` varchar(200) NOT NULL,
  `campaign_id` varchar(200) NOT NULL,
  `campaign_name` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dispo`
--

CREATE TABLE `dispo` (
  `id` int(11) NOT NULL,
  `dispo` varchar(100) NOT NULL,
  `campaign_id` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `admin` varchar(100) NOT NULL,
  `ins_date` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL,
  `to_emails` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `email_body` varchar(1000) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `type` enum('system','custom') NOT NULL,
  `Agents` tinyint(1) DEFAULT 0,
  `Admin` tinyint(1) DEFAULT 0,
  `Create_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `Ip_Address` varchar(45) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `number` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_agent`
--

CREATE TABLE `group_agent` (
  `id` int(11) NOT NULL,
  `group_id` varchar(100) NOT NULL,
  `agent_id` varchar(100) NOT NULL,
  `agent_name` varchar(100) NOT NULL,
  `admin` varchar(100) NOT NULL,
  `campaign_id` varchar(100) NOT NULL,
  `press_key` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `ID` int(11) NOT NULL,
  `LIST_ID` varchar(200) DEFAULT NULL,
  `NAME` varchar(255) DEFAULT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `RTIME` varchar(100) NOT NULL,
  `LEADS_COUNT` int(11) DEFAULT NULL,
  `CALL_TIME` time DEFAULT NULL,
  `LAST_CALL_TIME` varchar(100) NOT NULL,
  `CAMPAIGN` varchar(255) DEFAULT NULL,
  `ACTIVE` varchar(10) NOT NULL,
  `ADMIN` varchar(100) NOT NULL,
  `LIST_UP_DATE` varchar(100) NOT NULL COMMENT 'list update date and user'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `live`
--

CREATE TABLE `live` (
  `id` int(11) NOT NULL,
  `uniqueid` varchar(200) NOT NULL,
  `did` varchar(200) NOT NULL,
  `call_to` varchar(200) NOT NULL,
  `call_from` varchar(200) NOT NULL,
  `Agent` varchar(200) NOT NULL,
  `admin` varchar(100) NOT NULL,
  `time` varchar(200) NOT NULL,
  `direction` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `Agent_name` varchar(100) NOT NULL,
  `campaign_Id` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_log`
--

CREATE TABLE `login_log` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `log_in_time` varchar(100) NOT NULL,
  `log_out_time` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `campaign_name` varchar(100) NOT NULL,
  `admin` varchar(100) NOT NULL,
  `user_type` varchar(100) NOT NULL,
  `emg_log_out` varchar(200) NOT NULL COMMENT 'admin all user logout to your side if Emg_log_out = 0 than login user and Emg_log_out = 1 than all user logout	',
  `emg_log_out_time` varchar(20) NOT NULL COMMENT 'logout_log'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_ivr_tbl1`
--

CREATE TABLE `menu_ivr_tbl1` (
  `id` int(11) NOT NULL,
  `menu_id` varchar(100) NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `campaign_id` varchar(100) NOT NULL,
  `press_key` varchar(100) NOT NULL,
  `ivr_file` varchar(100) NOT NULL,
  `menu_ivr_id` varchar(100) NOT NULL,
  `ivr` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_ivr_tbl2`
--

CREATE TABLE `menu_ivr_tbl2` (
  `id` int(11) NOT NULL,
  `menu_id` varchar(100) NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `campaign_id` varchar(100) NOT NULL,
  `press_key` varchar(100) NOT NULL,
  `ivr_file` varchar(100) NOT NULL,
  `menu_ivr_id` varchar(100) NOT NULL,
  `ivr` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `music_on_hold_tbl`
--

CREATE TABLE `music_on_hold_tbl` (
  `id` int(11) NOT NULL,
  `campaign_Id` varchar(100) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `admin` varchar(100) NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `popup_tbl`
--

CREATE TABLE `popup_tbl` (
  `id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `callerNumber` varchar(100) NOT NULL,
  `receiverNumber` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `StickyFeature`
--

CREATE TABLE `StickyFeature` (
  `id` int(10) NOT NULL,
  `caller_number` varchar(200) NOT NULL,
  `agent` varchar(200) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `number` varchar(200) NOT NULL,
  `response` varchar(200) NOT NULL,
  `msg` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `texttospeech`
--

CREATE TABLE `texttospeech` (
  `id` int(10) NOT NULL,
  `file_name` varchar(500) NOT NULL,
  `type` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `campaign_name` varchar(200) NOT NULL,
  `admin` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `upload_data`
--

CREATE TABLE `upload_data` (
  `id` int(11) NOT NULL,
  `uniqueid` varchar(200) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `employee_size` varchar(100) NOT NULL,
  `industry` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `phone_2` varchar(20) DEFAULT NULL,
  `phone_3` varchar(20) DEFAULT NULL,
  `phone_code` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `admin` varchar(100) NOT NULL,
  `ins_date` varchar(100) NOT NULL,
  `dial_status` varchar(50) NOT NULL,
  `list_id` varchar(100) NOT NULL,
  `campaign_Id` varchar(100) NOT NULL,
  `dial_count` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `SuperAdmin` varchar(100) NOT NULL,
  `admin` varchar(200) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(100) NOT NULL COMMENT 'user_type = (1 Agents)(2 Team Leader)(6 Quality Analytics) (7 Maneger)(8 Admin)(9 Super Admin)',
  `agent_priorty` varchar(20) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `campaigns_id` varchar(100) NOT NULL,
  `campaign_name` varchar(200) NOT NULL,
  `ins_date` datetime NOT NULL DEFAULT current_timestamp(),
  `use_did` varchar(100) NOT NULL,
  `last_heartbeat` timestamp NOT NULL DEFAULT current_timestamp(),
  `ext_number` varchar(100) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_mobile` varchar(100) NOT NULL,
  `admin_profile` varchar(100) NOT NULL,
  `user_timezone` varchar(200) NOT NULL,
  `api_key` varchar(200) NOT NULL,
  `admin_logo` varchar(500) NOT NULL,
  `caller_email` varchar(10) NOT NULL COMMENT 'Hide Email from Agent Side',
  `caller_contact` varchar(10) NOT NULL COMMENT 'Hide Contact Number from Agent Side',
  `allocated_clients` varchar(150) NOT NULL COMMENT 'allocated_clients name for created this Admin id'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vicidial_group`
--

CREATE TABLE `vicidial_group` (
  `id` int(11) NOT NULL,
  `group_id` varchar(100) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `campaign_id` varchar(100) NOT NULL,
  `press_key` varchar(100) NOT NULL,
  `menu_id` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vicidial_menu_group`
--

CREATE TABLE `vicidial_menu_group` (
  `id` int(11) NOT NULL,
  `group_id` varchar(100) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `campaign_id` varchar(100) NOT NULL,
  `press_key` varchar(100) NOT NULL,
  `menu_id` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `week_off_ivr_tbl`
--

CREATE TABLE `week_off_ivr_tbl` (
  `id` int(11) NOT NULL,
  `campaign_Id` varchar(100) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `admin` varchar(100) NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `welcome_ivr`
--

CREATE TABLE `welcome_ivr` (
  `id` int(11) NOT NULL,
  `campaign_Id` varchar(100) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `admin` varchar(100) NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `after_office_ivr_tbl`
--
ALTER TABLE `after_office_ivr_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `block_no`
--
ALTER TABLE `block_no`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `break_time`
--
ALTER TABLE `break_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cdr`
--
ALTER TABLE `cdr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compaign_list`
--
ALTER TABLE `compaign_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_info`
--
ALTER TABLE `company_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_phone_number_id` (`phone_number`,`id`);

--
-- Indexes for table `dialout`
--
ALTER TABLE `dialout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `did_list`
--
ALTER TABLE `did_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dispo`
--
ALTER TABLE `dispo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_agent`
--
ALTER TABLE `group_agent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `live`
--
ALTER TABLE `live`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_log`
--
ALTER TABLE `login_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_ivr_tbl1`
--
ALTER TABLE `menu_ivr_tbl1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_ivr_tbl2`
--
ALTER TABLE `menu_ivr_tbl2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `music_on_hold_tbl`
--
ALTER TABLE `music_on_hold_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `popup_tbl`
--
ALTER TABLE `popup_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `StickyFeature`
--
ALTER TABLE `StickyFeature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `texttospeech`
--
ALTER TABLE `texttospeech`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload_data`
--
ALTER TABLE `upload_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vicidial_group`
--
ALTER TABLE `vicidial_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vicidial_menu_group`
--
ALTER TABLE `vicidial_menu_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week_off_ivr_tbl`
--
ALTER TABLE `week_off_ivr_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `welcome_ivr`
--
ALTER TABLE `welcome_ivr`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `after_office_ivr_tbl`
--
ALTER TABLE `after_office_ivr_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `block_no`
--
ALTER TABLE `block_no`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `break_time`
--
ALTER TABLE `break_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cdr`
--
ALTER TABLE `cdr`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compaign_list`
--
ALTER TABLE `compaign_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_info`
--
ALTER TABLE `company_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dialout`
--
ALTER TABLE `dialout`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `did_list`
--
ALTER TABLE `did_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dispo`
--
ALTER TABLE `dispo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_agent`
--
ALTER TABLE `group_agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lists`
--
ALTER TABLE `lists`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `live`
--
ALTER TABLE `live`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_log`
--
ALTER TABLE `login_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_ivr_tbl1`
--
ALTER TABLE `menu_ivr_tbl1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_ivr_tbl2`
--
ALTER TABLE `menu_ivr_tbl2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `music_on_hold_tbl`
--
ALTER TABLE `music_on_hold_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `popup_tbl`
--
ALTER TABLE `popup_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `StickyFeature`
--
ALTER TABLE `StickyFeature`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `texttospeech`
--
ALTER TABLE `texttospeech`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upload_data`
--
ALTER TABLE `upload_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vicidial_group`
--
ALTER TABLE `vicidial_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vicidial_menu_group`
--
ALTER TABLE `vicidial_menu_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `week_off_ivr_tbl`
--
ALTER TABLE `week_off_ivr_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `welcome_ivr`
--
ALTER TABLE `welcome_ivr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
