/*
Navicat MySQL Data Transfer

Source Server         : MySqlLocal
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : ors

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-07-04 20:24:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for accepted_requisition_back
-- ----------------------------
DROP TABLE IF EXISTS `accepted_requisition_back`;
CREATE TABLE `accepted_requisition_back` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `org_name` int(11) DEFAULT NULL,
  `dept_name` int(11) DEFAULT NULL,
  `officer_name` varchar(65) DEFAULT '',
  `officer_desig` int(11) DEFAULT NULL,
  `contact_no` char(10) DEFAULT '',
  `officer_email` varchar(120) DEFAULT '',
  `c_mode_recruitment` char(1) DEFAULT '',
  `post_name` int(11) DEFAULT NULL,
  `a_group` char(1) DEFAULT '',
  `b_pay_scale` varchar(25) DEFAULT NULL,
  `d_ur` int(4) DEFAULT NULL,
  `d_apst` int(4) DEFAULT NULL,
  `d_total` int(4) DEFAULT NULL,
  `d_pwd` int(4) DEFAULT NULL,
  `d_ex_sm` int(4) DEFAULT NULL,
  `e_blindness` int(4) DEFAULT NULL,
  `e_deaf` int(4) DEFAULT NULL,
  `e_locomotor` int(4) DEFAULT NULL,
  `e_autism` int(4) DEFAULT NULL,
  `e_multiple` int(4) DEFAULT NULL,
  `e_total` int(4) DEFAULT NULL,
  `f_vac_worked_out` char(1) DEFAULT '',
  `g_edu_others` varchar(225) DEFAULT NULL,
  `h_min_age` int(2) DEFAULT NULL,
  `h_max_age` int(2) DEFAULT NULL,
  `i_apst` int(2) DEFAULT NULL,
  `i_pwd` int(2) DEFAULT NULL,
  `i_ex_sm` int(2) DEFAULT NULL,
  `j_ban_restric` char(1) DEFAULT NULL,
  `file_copy_k_rr` text DEFAULT NULL,
  `l_other_requi_cond` varchar(225) DEFAULT NULL,
  `file_copy_l_ro` text DEFAULT NULL,
  `m_criteria_eligibility_post` char(6) DEFAULT NULL,
  `m_criteria_eligibility` varchar(225) DEFAULT NULL,
  `file_copy_n_list_cands` tinytext DEFAULT NULL,
  `file_copy_o_list_cands` tinytext DEFAULT NULL,
  `entry_datetime` datetime DEFAULT NULL,
  `sent_datetime` datetime DEFAULT NULL,
  `sys_ip` varchar(65) DEFAULT '',
  `entry_user` varchar(65) DEFAULT NULL,
  `mst_id` char(20) DEFAULT '',
  `updated_datetime` datetime DEFAULT NULL,
  `seen_flag` int(1) NOT NULL DEFAULT 0,
  `seen_datetime` datetime DEFAULT NULL,
  `seen_user` varchar(65) DEFAULT NULL,
  `action_taken` char(1) DEFAULT 'P',
  `action_taken_user` varchar(65) DEFAULT NULL,
  `action_datetime` datetime DEFAULT NULL,
  `seen_by_dept` int(1) NOT NULL DEFAULT 0,
  `move_to_draft` int(1) NOT NULL DEFAULT 0,
  `action_remarks` tinytext DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of accepted_requisition_back
-- ----------------------------

-- ----------------------------
-- Table structure for draft_recomm_list
-- ----------------------------
DROP TABLE IF EXISTS `draft_recomm_list`;
CREATE TABLE `draft_recomm_list` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `inbox_requi_auto_id` int(11) DEFAULT NULL,
  `full_name` varchar(65) DEFAULT NULL,
  `roll_no` int(7) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `father_name` varchar(65) DEFAULT NULL,
  `category_allot` char(4) DEFAULT NULL,
  `is_pwd` char(1) DEFAULT NULL,
  `is_ex_sm` char(1) DEFAULT NULL,
  `dossier_link` tinytext DEFAULT NULL,
  `entry_datetime` datetime DEFAULT NULL,
  `sys_ip` varchar(65) DEFAULT NULL,
  `entry_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`auto_id`),
  KEY `inbox_requi_auto_id` (`inbox_requi_auto_id`) USING BTREE,
  KEY `entry_user` (`entry_user`) USING BTREE,
  CONSTRAINT `draft_recomm_list_ibfk_1` FOREIGN KEY (`inbox_requi_auto_id`) REFERENCES `inbox_requisition` (`auto_id`) ON UPDATE CASCADE,
  CONSTRAINT `draft_recomm_list_ibfk_2` FOREIGN KEY (`entry_user`) REFERENCES `users_login` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of draft_recomm_list
-- ----------------------------

-- ----------------------------
-- Table structure for draft_requisition
-- ----------------------------
DROP TABLE IF EXISTS `draft_requisition`;
CREATE TABLE `draft_requisition` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `org_name` int(11) DEFAULT NULL,
  `dept_name` int(11) DEFAULT NULL,
  `officer_name` varchar(65) DEFAULT '',
  `officer_desig` int(11) DEFAULT NULL,
  `contact_no` char(10) DEFAULT '',
  `officer_email` varchar(120) DEFAULT '',
  `c_mode_recruitment` char(1) DEFAULT '',
  `post_name` int(11) DEFAULT NULL,
  `a_group` char(1) DEFAULT '',
  `b_pay_scale` varchar(25) DEFAULT NULL,
  `d_ur` int(4) DEFAULT NULL,
  `d_apst` int(4) DEFAULT NULL,
  `d_total` int(4) DEFAULT NULL,
  `d_pwd` int(4) DEFAULT NULL,
  `d_ex_sm` int(4) DEFAULT NULL,
  `e_blindness` int(4) DEFAULT NULL,
  `e_deaf` int(4) DEFAULT NULL,
  `e_locomotor` int(4) DEFAULT NULL,
  `e_autism` int(4) DEFAULT NULL,
  `e_multiple` int(4) DEFAULT NULL,
  `e_total` int(4) DEFAULT NULL,
  `f_vac_worked_out` char(1) DEFAULT '',
  `g_edu_others` varchar(225) DEFAULT NULL,
  `h_min_age` int(2) DEFAULT NULL,
  `h_max_age` int(2) DEFAULT NULL,
  `i_apst` int(2) DEFAULT NULL,
  `i_pwd_apst` int(2) NOT NULL,
  `i_pwd_ur` int(2) NOT NULL,
  `i_ex_sm_apst` int(2) DEFAULT NULL,
  `i_ex_sm_ur` int(2) NOT NULL,
  `j_ban_restric` char(1) DEFAULT NULL,
  `file_copy_k_rr` tinytext DEFAULT NULL,
  `l_other_requi_cond` varchar(225) DEFAULT NULL,
  `file_copy_l_ro` text DEFAULT NULL,
  `m_criteria_eligibility_post` varchar(6) DEFAULT NULL,
  `m_criteria_eligibility` int(11) DEFAULT NULL,
  `file_copy_n_list_cands` tinytext DEFAULT NULL,
  `file_copy_o_list_cands` tinytext DEFAULT NULL,
  `entry_datetime` datetime DEFAULT NULL,
  `sent_datetime` datetime DEFAULT NULL,
  `sys_ip` varchar(65) DEFAULT '',
  `entry_user` varchar(65) DEFAULT NULL,
  `mst_id` char(20) DEFAULT '',
  `updated_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of draft_requisition
-- ----------------------------

-- ----------------------------
-- Table structure for final_recomm_list
-- ----------------------------
DROP TABLE IF EXISTS `final_recomm_list`;
CREATE TABLE `final_recomm_list` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `inbox_requi_auto_id` int(11) NOT NULL,
  `full_name` varchar(65) DEFAULT NULL,
  `roll_no` int(7) NOT NULL,
  `dob` date DEFAULT NULL,
  `father_name` varchar(65) DEFAULT NULL,
  `category_allot` char(4) DEFAULT NULL,
  `is_pwd` char(1) DEFAULT NULL,
  `is_ex_sm` char(1) DEFAULT NULL,
  `dossier_link` tinytext DEFAULT NULL,
  `entry_datetime` datetime DEFAULT NULL,
  `sys_ip` varchar(65) DEFAULT NULL,
  `entry_user` int(11) DEFAULT NULL,
  `iol_flag` int(1) NOT NULL DEFAULT 0,
  `iol_datetime` datetime DEFAULT NULL,
  `iol_user` varchar(65) DEFAULT NULL,
  `uol_flag` int(1) DEFAULT 0,
  `uol_datetime` datetime DEFAULT NULL,
  `uol_user` varchar(65) DEFAULT '',
  `uol_dossier` tinytext DEFAULT NULL,
  `ial_flag` int(1) NOT NULL DEFAULT 0,
  `ial_datetime` datetime DEFAULT NULL,
  `ial_user` varchar(65) DEFAULT '',
  `ual_flag` int(1) DEFAULT 0,
  `ual_datetime` datetime DEFAULT NULL,
  `ual_user` varchar(65) DEFAULT '',
  `ual_dossier` tinytext DEFAULT NULL,
  PRIMARY KEY (`auto_id`,`inbox_requi_auto_id`,`roll_no`),
  KEY `inbox_requi_auto_id` (`inbox_requi_auto_id`) USING BTREE,
  KEY `entry_user` (`entry_user`) USING BTREE,
  CONSTRAINT `final_recomm_list_ibfk_1` FOREIGN KEY (`inbox_requi_auto_id`) REFERENCES `inbox_requisition` (`auto_id`) ON UPDATE CASCADE,
  CONSTRAINT `final_recomm_list_ibfk_2` FOREIGN KEY (`entry_user`) REFERENCES `users_login` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of final_recomm_list
-- ----------------------------

-- ----------------------------
-- Table structure for inbox_requisition
-- ----------------------------
DROP TABLE IF EXISTS `inbox_requisition`;
CREATE TABLE `inbox_requisition` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `org_name` int(11) DEFAULT NULL,
  `dept_name` int(11) DEFAULT NULL,
  `officer_name` varchar(65) DEFAULT '',
  `officer_desig` int(11) DEFAULT NULL,
  `contact_no` char(10) DEFAULT '',
  `officer_email` varchar(120) DEFAULT '',
  `c_mode_recruitment` char(1) DEFAULT '',
  `post_name` int(11) DEFAULT NULL,
  `a_group` char(1) DEFAULT '',
  `b_pay_scale` varchar(25) DEFAULT NULL,
  `d_ur` int(4) DEFAULT NULL,
  `d_apst` int(4) DEFAULT NULL,
  `d_total` int(4) DEFAULT NULL,
  `d_pwd` int(4) DEFAULT NULL,
  `d_ex_sm` int(4) DEFAULT NULL,
  `e_blindness` int(4) DEFAULT NULL,
  `e_deaf` int(4) DEFAULT NULL,
  `e_locomotor` int(4) DEFAULT NULL,
  `e_autism` int(4) DEFAULT NULL,
  `e_multiple` int(4) DEFAULT NULL,
  `e_total` int(4) DEFAULT NULL,
  `f_vac_worked_out` char(1) DEFAULT '',
  `g_edu_others` varchar(225) DEFAULT NULL,
  `h_min_age` int(2) DEFAULT NULL,
  `h_max_age` int(2) DEFAULT NULL,
  `i_apst` int(2) DEFAULT NULL,
  `i_pwd_apst` int(2) DEFAULT NULL,
  `i_pwd_ur` int(2) DEFAULT NULL,
  `i_ex_sm_apst` int(2) DEFAULT NULL,
  `i_ex_sm_ur` int(2) DEFAULT NULL,
  `j_ban_restric` char(1) DEFAULT NULL,
  `file_copy_k_rr` text DEFAULT NULL,
  `l_other_requi_cond` varchar(225) DEFAULT NULL,
  `file_copy_l_ro` text DEFAULT NULL,
  `m_criteria_eligibility_post` char(6) DEFAULT NULL,
  `m_criteria_eligibility` varchar(225) DEFAULT NULL,
  `file_copy_n_list_cands` tinytext DEFAULT NULL,
  `file_copy_o_list_cands` tinytext DEFAULT NULL,
  `entry_datetime` datetime DEFAULT NULL,
  `sent_datetime` datetime DEFAULT NULL,
  `sys_ip` varchar(65) DEFAULT '',
  `entry_user` varchar(65) DEFAULT NULL,
  `mst_id` char(20) DEFAULT '',
  `updated_datetime` datetime DEFAULT NULL,
  `seen_flag` int(1) NOT NULL DEFAULT 0,
  `seen_datetime` datetime DEFAULT NULL,
  `seen_user` varchar(65) DEFAULT NULL,
  `action_taken` char(11) DEFAULT 'PENDING',
  `action_taken_user` varchar(65) DEFAULT NULL,
  `action_datetime` datetime DEFAULT NULL,
  `seen_by_dept` int(1) NOT NULL DEFAULT 0,
  `move_to_draft` int(1) NOT NULL DEFAULT 0,
  `action_remarks` tinytext DEFAULT NULL,
  `advertised_date` date DEFAULT NULL,
  `rec_ur` int(4) DEFAULT NULL,
  `rec_apst` int(4) DEFAULT NULL,
  `rec_pwd` int(4) DEFAULT NULL,
  `rec_ex_sm` int(4) DEFAULT NULL,
  `rec_sent_to_dept_flag` char(1) DEFAULT 'D',
  `pull_back_datetime` datetime DEFAULT NULL,
  `pull_back_user` varchar(65) DEFAULT NULL,
  `accept_datetime` datetime DEFAULT NULL,
  `accept_user` varchar(65) DEFAULT NULL,
  `returned_datetime` datetime DEFAULT NULL,
  `returned_user` varchar(65) DEFAULT NULL,
  `advertised_datetime` datetime DEFAULT NULL,
  `advertised_user` varchar(65) DEFAULT NULL,
  `recommended_datetime` datetime DEFAULT NULL,
  `recommended_user` varchar(65) DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of inbox_requisition
-- ----------------------------

-- ----------------------------
-- Table structure for mst_department
-- ----------------------------
DROP TABLE IF EXISTS `mst_department`;
CREATE TABLE `mst_department` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(65) DEFAULT '',
  `dept_address` tinytext DEFAULT NULL,
  `entry_by` varchar(25) DEFAULT '',
  `entry_datetime` date DEFAULT NULL,
  `sys_ip` varchar(25) DEFAULT NULL,
  `last_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of mst_department
-- ----------------------------
INSERT INTO `mst_department` VALUES ('1', 'Department 1', null, '', null, null, null);
INSERT INTO `mst_department` VALUES ('2', 'Department 2', null, '', null, null, null);
INSERT INTO `mst_department` VALUES ('3', 'Department 3', null, '', null, null, null);
INSERT INTO `mst_department` VALUES ('4', 'Department 4', null, '', null, null, null);
INSERT INTO `mst_department` VALUES ('5', 'Department 5', null, '', null, null, null);
INSERT INTO `mst_department` VALUES ('6', 'Department 6', null, '', null, null, null);
INSERT INTO `mst_department` VALUES ('7', 'Department 7', null, '', null, null, null);
INSERT INTO `mst_department` VALUES ('8', 'Department 8', null, '', null, null, null);
INSERT INTO `mst_department` VALUES ('9', 'Department 9', null, '', null, null, null);
INSERT INTO `mst_department` VALUES ('10', 'Department 10', null, '', null, null, null);

-- ----------------------------
-- Table structure for mst_designation
-- ----------------------------
DROP TABLE IF EXISTS `mst_designation`;
CREATE TABLE `mst_designation` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `desig_name` varchar(65) DEFAULT '',
  `entry_by` varchar(65) DEFAULT NULL,
  `entry_datetime` datetime DEFAULT NULL,
  `sys_ip` varchar(65) DEFAULT NULL,
  `last_update_datetime` date DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of mst_designation
-- ----------------------------
INSERT INTO `mst_designation` VALUES ('10', 'DESIGNATION 1', '1', '2023-02-13 11:20:21', '117.248.138.119', null);
INSERT INTO `mst_designation` VALUES ('11', 'DESIGNATION 2', '1', '2023-02-13 11:20:26', '117.248.138.119', null);
INSERT INTO `mst_designation` VALUES ('12', 'DESIGNATION 3', '1', '2023-02-13 11:20:32', '117.248.138.119', null);
INSERT INTO `mst_designation` VALUES ('13', 'DESIGNATION 4', '1', '2023-02-13 11:20:42', '117.248.138.119', null);
INSERT INTO `mst_designation` VALUES ('14', 'DESIGNATION 5', '1', '2023-02-13 11:20:48', '117.248.138.119', null);
INSERT INTO `mst_designation` VALUES ('15', 'DESIGNATION 6', '1', '2023-02-13 11:20:55', '117.248.138.119', null);
INSERT INTO `mst_designation` VALUES ('16', 'DESIGNATION 7', '1', '2023-02-13 11:21:03', '117.248.138.119', null);

-- ----------------------------
-- Table structure for mst_group_back
-- ----------------------------
DROP TABLE IF EXISTS `mst_group_back`;
CREATE TABLE `mst_group_back` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(65) DEFAULT '',
  `entry_by` varchar(25) DEFAULT '',
  `entry_datetime` date DEFAULT NULL,
  `sys_ip` varchar(25) DEFAULT NULL,
  `last_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of mst_group_back
-- ----------------------------
INSERT INTO `mst_group_back` VALUES ('5', 'G-III', 'admin', '2022-12-29', '::1', '2022-12-29 20:41:32');
INSERT INTO `mst_group_back` VALUES ('6', 'G-II', 'admin', '2022-12-29', '::1', null);

-- ----------------------------
-- Table structure for mst_mode_recruit_back
-- ----------------------------
DROP TABLE IF EXISTS `mst_mode_recruit_back`;
CREATE TABLE `mst_mode_recruit_back` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `mode_name` varchar(65) DEFAULT '',
  `entry_by` varchar(25) DEFAULT '',
  `entry_datetime` date DEFAULT NULL,
  `sys_ip` varchar(25) DEFAULT NULL,
  `last_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of mst_mode_recruit_back
-- ----------------------------
INSERT INTO `mst_mode_recruit_back` VALUES ('5', 'G-III', 'admin', '2022-12-29', '::1', '2022-12-29 20:41:32');
INSERT INTO `mst_mode_recruit_back` VALUES ('7', 'NEW MODE', 'admin', '2022-12-29', '::1', null);

-- ----------------------------
-- Table structure for mst_organisation
-- ----------------------------
DROP TABLE IF EXISTS `mst_organisation`;
CREATE TABLE `mst_organisation` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `org_name` varchar(65) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `entry_by` varchar(65) DEFAULT NULL,
  `entry_datetime` datetime DEFAULT NULL,
  `sys_ip` varchar(65) DEFAULT NULL,
  `last_update_datetime` date DEFAULT NULL,
  PRIMARY KEY (`auto_id`),
  KEY `dept_id` (`dept_id`),
  CONSTRAINT `mst_organisation_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `mst_department` (`auto_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of mst_organisation
-- ----------------------------
INSERT INTO `mst_organisation` VALUES ('1', 'Organisation 1', '1', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('2', 'Organisation 2', '1', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('3', 'Organisation 3', '1', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('4', 'Organisation 4', '2', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('5', 'Organisation 5', '2', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('6', 'Organisation 6', '2', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('7', 'Organisation 7', '2', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('8', 'Organisation 8', '2', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('9', 'Organisation 9', '3', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('10', 'Organisation 10', '3', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('11', 'Organisation 11', '3', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('12', 'Organisation 12', '4', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('13', 'Organisation 13', '4', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('14', 'Organisation 14', '4', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('15', 'Organisation 15', '5', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('16', 'Organisation 16', '5', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('17', 'Organisation 17', '5', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('18', 'Organisation 18', '6', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('19', 'Organisation 19', '6', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('20', 'Organisation 20', '7', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('21', 'Organisation 21', '7', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('22', 'Organisation 22', '7', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('23', 'Organisation 23', '7', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('24', 'Organisation 24', '7', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('25', 'Organisation 25', '7', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('26', 'Organisation 26', '8', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('27', 'Organisation 27', '8', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('28', 'Organisation 28', '9', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('29', 'Organisation 29', '9', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('30', 'Organisation 30', '9', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('31', 'Organisation 31', '9', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('32', 'Organisation 32', '9', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('33', 'Organisation 33', '9', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('34', 'Organisation 34', '9', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('35', 'Organisation 35', '9', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('36', 'Organisation 36', '9', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('37', 'Organisation 37', '9', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('38', 'Organisation 38', '9', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('39', 'Organisation 39', '9', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('40', 'Organisation 40', '9', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('41', 'Organisation 41', '9', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('42', 'Organisation 42', '10', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('43', 'Organisation 43', '10', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('44', 'Organisation 44', '10', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('45', 'Organisation 45', '10', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('46', 'Organisation 46', '10', null, null, null, null);
INSERT INTO `mst_organisation` VALUES ('47', 'Organisation 47', '10', null, null, null, null);

-- ----------------------------
-- Table structure for mst_pay_scale_back
-- ----------------------------
DROP TABLE IF EXISTS `mst_pay_scale_back`;
CREATE TABLE `mst_pay_scale_back` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_scale` varchar(65) DEFAULT '',
  `entry_by` varchar(25) DEFAULT '',
  `entry_datetime` date DEFAULT NULL,
  `sys_ip` varchar(25) DEFAULT NULL,
  `last_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of mst_pay_scale_back
-- ----------------------------
INSERT INTO `mst_pay_scale_back` VALUES ('5', 'G-III', 'admin', '2022-12-29', '::1', '2022-12-29 20:41:32');
INSERT INTO `mst_pay_scale_back` VALUES ('6', 'PAY-I', 'admin', '2022-12-29', '::1', '2022-12-29 20:50:24');

-- ----------------------------
-- Table structure for mst_post
-- ----------------------------
DROP TABLE IF EXISTS `mst_post`;
CREATE TABLE `mst_post` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_name` varchar(65) DEFAULT '',
  `entry_by` varchar(25) DEFAULT '',
  `entry_datetime` date DEFAULT NULL,
  `sys_ip` varchar(25) DEFAULT NULL,
  `last_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of mst_post
-- ----------------------------
INSERT INTO `mst_post` VALUES ('1', 'Artist', '', null, null, null);
INSERT INTO `mst_post` VALUES ('2', 'Assistant Inspector', '', null, null, null);
INSERT INTO `mst_post` VALUES ('3', 'Chainman', '', null, null, null);
INSERT INTO `mst_post` VALUES ('4', 'Computer Operator', '', null, null, null);
INSERT INTO `mst_post` VALUES ('5', 'Conductor', '', null, null, null);
INSERT INTO `mst_post` VALUES ('6', 'Constable (Band/Bugler)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('7', 'Constable (Driver)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('8', 'Constable (GD)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('9', 'Data Entry Operator', '', null, null, null);
INSERT INTO `mst_post` VALUES ('10', 'Dental Mechanic', '', null, null, null);
INSERT INTO `mst_post` VALUES ('11', 'Dental Technician', '', null, null, null);
INSERT INTO `mst_post` VALUES ('12', 'Dissection Hall Attendant', '', null, null, null);
INSERT INTO `mst_post` VALUES ('13', 'Driver', '', null, null, null);
INSERT INTO `mst_post` VALUES ('14', 'Driver (Heavy)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('15', 'ECG Technician', '', null, null, null);
INSERT INTO `mst_post` VALUES ('16', 'Electrician Grade-III', '', null, null, null);
INSERT INTO `mst_post` VALUES ('17', 'Fireman Gr-C', '', null, null, null);
INSERT INTO `mst_post` VALUES ('18', 'Fishery Demonstrator', '', null, null, null);
INSERT INTO `mst_post` VALUES ('19', 'Fitter', '', null, null, null);
INSERT INTO `mst_post` VALUES ('20', 'Forest Guard', '', null, null, null);
INSERT INTO `mst_post` VALUES ('21', 'Forester', '', null, null, null);
INSERT INTO `mst_post` VALUES ('22', 'Handyman', '', null, null, null);
INSERT INTO `mst_post` VALUES ('23', 'Head Constable (Driver)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('24', 'Head Constable (Radio Technician)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('25', 'Head Constable (Telecom)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('26', 'Health Assistant (Jr)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('27', 'Helper (Publicity Assistant)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('28', 'Junior Estimator/Draughtsman-III', '', null, null, null);
INSERT INTO `mst_post` VALUES ('29', 'Junior Inspector of Co-Operative Societies', '', null, null, null);
INSERT INTO `mst_post` VALUES ('30', 'Junior Librarian', '', null, null, null);
INSERT INTO `mst_post` VALUES ('31', 'Junior Secretariat Assistant', '', null, null, null);
INSERT INTO `mst_post` VALUES ('32', 'Khalasi', '', null, null, null);
INSERT INTO `mst_post` VALUES ('33', 'Laboratory Assistant ', '', null, null, null);
INSERT INTO `mst_post` VALUES ('34', 'Laboratory Attendant', '', null, null, null);
INSERT INTO `mst_post` VALUES ('35', 'Laboratory Technician', '', null, null, null);
INSERT INTO `mst_post` VALUES ('36', 'Line Checker', '', null, null, null);
INSERT INTO `mst_post` VALUES ('37', 'Lower Division Clerk', '', null, null, null);
INSERT INTO `mst_post` VALUES ('38', 'Manual Assistant ', '', null, null, null);
INSERT INTO `mst_post` VALUES ('39', 'Mechanic Gd. -III', '', null, null, null);
INSERT INTO `mst_post` VALUES ('40', 'Mineral Guard', '', null, null, null);
INSERT INTO `mst_post` VALUES ('41', 'MTS (Ayah)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('42', 'MTS (Barber)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('43', 'MTS (Chowkidar)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('44', 'MTS (Cook)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('45', 'MTS (Dak Runner)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('46', 'MTS (Dhobi)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('47', 'MTS (Dresser)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('48', 'MTS (Duftry)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('49', 'MTS (Female Attendant)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('50', 'MTS (Gestetner Operator)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('51', 'MTS (Male attendant)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('52', 'MTS (Mali)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('53', 'MTS (Masalchi)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('54', 'MTS (Peon)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('55', 'MTS (Sanitary Assistant)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('56', 'MTS (Stretcher Bearer)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('57', 'MTS (Sweeper)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('58', 'MTS (Washer Man)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('59', 'MTS (Water Carrier)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('60', 'Nursing Assistant ', '', null, null, null);
INSERT INTO `mst_post` VALUES ('61', 'Optometrist', '', null, null, null);
INSERT INTO `mst_post` VALUES ('62', 'OT Technician', '', null, null, null);
INSERT INTO `mst_post` VALUES ('63', 'Para Medical Worker', '', null, null, null);
INSERT INTO `mst_post` VALUES ('64', 'Pharmacist', '', null, null, null);
INSERT INTO `mst_post` VALUES ('65', 'Primary Investigator', '', null, null, null);
INSERT INTO `mst_post` VALUES ('66', 'Projector Operator (Field Publicity Assistant)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('67', 'Radio Mechanic (Assistant Technician)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('68', 'Record Keeper/ Record Clerk', '', null, null, null);
INSERT INTO `mst_post` VALUES ('69', 'Staff Artiste', '', null, null, null);
INSERT INTO `mst_post` VALUES ('70', 'Stenographer Gr-III', '', null, null, null);
INSERT INTO `mst_post` VALUES ('71', 'Stockman', '', null, null, null);
INSERT INTO `mst_post` VALUES ('72', 'Storekeeper', '', null, null, null);
INSERT INTO `mst_post` VALUES ('73', 'Supervisor Kanungo', '', null, null, null);
INSERT INTO `mst_post` VALUES ('74', 'Surveyor', '', null, null, null);
INSERT INTO `mst_post` VALUES ('75', 'Upper Division Clerk', '', null, null, null);
INSERT INTO `mst_post` VALUES ('76', 'Vocational Instructor (Basic Cosmetology)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('77', 'Vocational Instructor (COPA)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('78', 'Vocational Instructor (Draughtsman)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('79', 'Vocational Instructor (DTPO)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('80', 'Vocational Instructor (Electrician)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('81', 'Vocational Instructor (Employability Skill)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('82', 'Vocational Instructor (Engineering Drawing)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('83', 'Vocational Instructor (Fashion Design Technology)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('84', 'Vocational Instructor (Fashion Design)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('85', 'Vocational Instructor (Front Ofiice Assistant', '', null, null, null);
INSERT INTO `mst_post` VALUES ('86', 'Vocational Instructor (ICT & SM)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('87', 'Vocational Instructor (Mechanic Motor Vehicle)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('88', 'Vocational Instructor (Plumber)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('89', 'Vocational Instructor (Stenography & Secretarial Assistant)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('90', 'Vocational Instructor (Surveyor)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('91', 'Vocational Instructor (Welder)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('92', 'Vocational Instructor (Wireman)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('93', 'Vocational Instructor (Workshop Calculation & Scienec)', '', null, null, null);
INSERT INTO `mst_post` VALUES ('94', 'Welder Gr-III', '', null, null, null);
INSERT INTO `mst_post` VALUES ('95', 'Workshop worker/ Rehabilitation worker/ Dark Room Assistant', '', null, null, null);

-- ----------------------------
-- Table structure for mst_settings
-- ----------------------------
DROP TABLE IF EXISTS `mst_settings`;
CREATE TABLE `mst_settings` (
  `auto_id` int(11) NOT NULL,
  `requisition_form_flag` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of mst_settings
-- ----------------------------
INSERT INTO `mst_settings` VALUES ('1', '1');

-- ----------------------------
-- Table structure for post_eligibility_mapped
-- ----------------------------
DROP TABLE IF EXISTS `post_eligibility_mapped`;
CREATE TABLE `post_eligibility_mapped` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_name` char(6) DEFAULT NULL,
  `eligibility` tinytext DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of post_eligibility_mapped
-- ----------------------------
INSERT INTO `post_eligibility_mapped` VALUES ('1', 'LDC', 'MTS of the cadre with 8 years of regular service in the grade and possessing Class XII pass certificate from a recognized Board/institution and should not be more than 45 years (50 years in case of APST candidate)');
INSERT INTO `post_eligibility_mapped` VALUES ('2', 'LDC', 'Skilled Contingency staff with minimum 12 years of continuous service as skilled contingency in the department/office and possess Education Qualification of Class XII pass certificate from a recognized Board or Institution');
INSERT INTO `post_eligibility_mapped` VALUES ('3', 'DRIVER', 'Contingency Skilled Driver who have completed 10 years of continuous service and who possess Education Qualification of Class X pass certificate from a recognized Board or Insititution');
INSERT INTO `post_eligibility_mapped` VALUES ('4', 'JSA', 'MTS of the Arunachal Pradesh Civil Secretariat who possess educational qualification of Class XII certificate from a recognized Board or Institution and rendered 8 years of regular service in the grade and should not be more than 45 years ( 50 years in ca');

-- ----------------------------
-- Table structure for returned_requisition_back
-- ----------------------------
DROP TABLE IF EXISTS `returned_requisition_back`;
CREATE TABLE `returned_requisition_back` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `org_name` int(11) DEFAULT NULL,
  `dept_name` int(11) DEFAULT NULL,
  `officer_name` varchar(65) DEFAULT '',
  `officer_desig` int(11) DEFAULT NULL,
  `contact_no` char(10) DEFAULT '',
  `officer_email` varchar(120) DEFAULT '',
  `c_mode_recruitment` char(1) DEFAULT '',
  `post_name` int(11) DEFAULT NULL,
  `a_group` char(1) DEFAULT '',
  `b_pay_scale` varchar(25) DEFAULT NULL,
  `d_ur` int(4) DEFAULT NULL,
  `d_apst` int(4) DEFAULT NULL,
  `d_total` int(4) DEFAULT NULL,
  `d_pwd` int(4) DEFAULT NULL,
  `d_ex_sm` int(4) DEFAULT NULL,
  `e_blindness` int(4) DEFAULT NULL,
  `e_deaf` int(4) DEFAULT NULL,
  `e_locomotor` int(4) DEFAULT NULL,
  `e_autism` int(4) DEFAULT NULL,
  `e_multiple` int(4) DEFAULT NULL,
  `e_total` int(4) DEFAULT NULL,
  `f_vac_worked_out` char(1) DEFAULT '',
  `g_edu_others` varchar(225) DEFAULT NULL,
  `h_min_age` int(2) DEFAULT NULL,
  `h_max_age` int(2) DEFAULT NULL,
  `i_apst` int(2) DEFAULT NULL,
  `i_pwd` int(2) DEFAULT NULL,
  `i_ex_sm` int(2) DEFAULT NULL,
  `j_ban_restric` char(1) DEFAULT NULL,
  `file_copy_k_rr` text DEFAULT NULL,
  `l_other_requi_cond` varchar(225) DEFAULT NULL,
  `file_copy_l_ro` text DEFAULT NULL,
  `m_criteria_eligibility_post` char(6) DEFAULT NULL,
  `m_criteria_eligibility` varchar(225) DEFAULT NULL,
  `file_copy_n_list_cands` tinytext DEFAULT NULL,
  `file_copy_o_list_cands` tinytext DEFAULT NULL,
  `entry_datetime` datetime DEFAULT NULL,
  `sent_datetime` datetime DEFAULT NULL,
  `sys_ip` varchar(65) DEFAULT '',
  `entry_user` varchar(65) DEFAULT NULL,
  `mst_id` char(20) DEFAULT '',
  `updated_datetime` datetime DEFAULT NULL,
  `seen_flag` int(1) NOT NULL DEFAULT 0,
  `seen_datetime` datetime DEFAULT NULL,
  `seen_user` varchar(65) DEFAULT NULL,
  `action_taken` char(1) DEFAULT 'P',
  `action_taken_user` varchar(65) DEFAULT NULL,
  `action_datetime` datetime DEFAULT NULL,
  `seen_by_dept` int(1) NOT NULL DEFAULT 0,
  `move_to_draft` int(1) NOT NULL DEFAULT 0,
  `action_remarks` tinytext DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of returned_requisition_back
-- ----------------------------

-- ----------------------------
-- Table structure for trash_requisition
-- ----------------------------
DROP TABLE IF EXISTS `trash_requisition`;
CREATE TABLE `trash_requisition` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `org_name` int(11) DEFAULT NULL,
  `dept_name` int(11) DEFAULT NULL,
  `officer_name` varchar(65) DEFAULT '',
  `officer_desig` int(11) DEFAULT NULL,
  `contact_no` char(10) DEFAULT '',
  `officer_email` varchar(120) DEFAULT '',
  `c_mode_recruitment` char(1) DEFAULT '',
  `post_name` int(11) DEFAULT NULL,
  `a_group` char(1) DEFAULT '',
  `b_pay_scale` varchar(25) DEFAULT NULL,
  `d_ur` int(4) DEFAULT NULL,
  `d_apst` int(4) DEFAULT NULL,
  `d_total` int(4) DEFAULT NULL,
  `d_pwd` int(4) DEFAULT NULL,
  `d_ex_sm` int(4) DEFAULT NULL,
  `e_blindness` int(4) DEFAULT NULL,
  `e_deaf` int(4) DEFAULT NULL,
  `e_locomotor` int(4) DEFAULT NULL,
  `e_autism` int(4) DEFAULT NULL,
  `e_multiple` int(4) DEFAULT NULL,
  `e_total` int(4) DEFAULT NULL,
  `f_vac_worked_out` char(1) DEFAULT '',
  `g_edu_others` varchar(225) DEFAULT NULL,
  `h_min_age` int(2) DEFAULT NULL,
  `h_max_age` int(2) DEFAULT NULL,
  `i_apst` int(2) DEFAULT NULL,
  `i_pwd_apst` int(2) DEFAULT NULL,
  `i_pwd_ur` int(2) DEFAULT NULL,
  `i_ex_sm_apst` int(2) DEFAULT NULL,
  `i_ex_sm_ur` int(2) DEFAULT NULL,
  `j_ban_restric` char(1) DEFAULT NULL,
  `file_copy_k_rr` tinytext DEFAULT NULL,
  `l_other_requi_cond` varchar(225) DEFAULT NULL,
  `file_copy_l_ro` text DEFAULT NULL,
  `m_criteria_eligibility_post` varchar(6) DEFAULT NULL,
  `m_criteria_eligibility` int(11) DEFAULT NULL,
  `file_copy_n_list_cands` tinytext DEFAULT NULL,
  `file_copy_o_list_cands` tinytext DEFAULT NULL,
  `entry_datetime` datetime DEFAULT NULL,
  `sent_datetime` datetime DEFAULT NULL,
  `sys_ip` varchar(65) DEFAULT '',
  `entry_user` varchar(65) DEFAULT NULL,
  `mst_id` char(20) DEFAULT '',
  `updated_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of trash_requisition
-- ----------------------------

-- ----------------------------
-- Table structure for users_login
-- ----------------------------
DROP TABLE IF EXISTS `users_login`;
CREATE TABLE `users_login` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_lvl` char(2) DEFAULT 'E',
  `email_id` varchar(65) DEFAULT NULL,
  `mobile_no` char(10) DEFAULT NULL,
  `full_name` varchar(65) DEFAULT NULL,
  `desig` int(11) DEFAULT NULL,
  `pwd` varchar(65) DEFAULT NULL,
  `last_pwd_changed` datetime DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `org_alloted` tinytext DEFAULT NULL,
  `is_mob_verified` char(1) DEFAULT 'N',
  `is_email_verified` char(1) DEFAULT 'N',
  `approved_flag` char(1) DEFAULT 'P',
  `approved_datetime` datetime DEFAULT NULL,
  `approved_by_admin` varchar(25) DEFAULT NULL,
  `login_access` varchar(1) DEFAULT 'N',
  `block_reason` tinytext DEFAULT NULL,
  `block_by_admin` varchar(25) DEFAULT NULL,
  `block_datetime` datetime DEFAULT NULL,
  `registered_datetime` datetime DEFAULT NULL,
  `registered_from_ip` tinytext DEFAULT NULL,
  `registered_from_admin` varchar(65) DEFAULT NULL,
  `seen_flag` int(1) NOT NULL DEFAULT 0,
  `seen_datetime` datetime DEFAULT NULL,
  `seen_user` varchar(65) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of users_login
-- ----------------------------
INSERT INTO `users_login` VALUES ('1', 'AD', 'sadmin@gmail.com', '9000000001', 'Super Admin', '5', 'Test@2020', null, '3', '', 'Y', 'Y', 'A', '2023-02-05 20:04:51', '17', 'Y', 'Reason', null, null, '2023-02-03 15:43:30', '::1', null, '0', null, null);

-- ----------------------------
-- Table structure for users_mapped_organisation
-- ----------------------------
DROP TABLE IF EXISTS `users_mapped_organisation`;
CREATE TABLE `users_mapped_organisation` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `org_id` int(11) DEFAULT NULL,
  `status_flag` char(2) DEFAULT 'PN',
  `entry_datetime` datetime DEFAULT NULL,
  `action_taken_user` varchar(25) DEFAULT NULL,
  `action_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `users_mapped_organisation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_login` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of users_mapped_organisation
-- ----------------------------
