DROP TABLE IF EXISTS `tbl_account_setup`;
CREATE TABLE `tbl_account_setup` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Account ID mapped to all tables',
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(75) NOT NULL,
  `agency_name` varchar(75) NOT NULL,
  `logo` text,
  `timezone` varchar(145) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `smtp_server` varchar(255) DEFAULT NULL,
  `smtp_username` varchar(45) DEFAULT NULL,
  `smtp_password` varchar(255) DEFAULT NULL,
  `apointment_locations` text,
  `staff` text,
  `colour_scheme_id` int(11) NOT NULL DEFAULT '1',
  `is_auto_checked` tinyint(4) DEFAULT '1' COMMENT 'Check: tbl_policy_type',
  `is_home_checked` tinyint(4) DEFAULT '1' COMMENT 'Check: tbl_policy_type',
  `is_activated` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_account_setup` (`id`, `first_name`, `last_name`, `email`, `agency_name`, `logo`, `timezone`, `password`, `created_at`, `updated_at`, `smtp_server`, `smtp_username`, `smtp_password`, `apointment_locations`, `staff`, `colour_scheme_id`, `is_auto_checked`, `is_home_checked`, `is_activated`) VALUES
(1,	'Jim',	'Campbell',	'jim.campbell@engagex.com',	'Engagex',	'39bb28d08c12c4c98300297262c663d0.png',	'Africa/Casablanca',	'd41d8cd98f00b204e9800998ecf8427e',	'2017-08-03 16:46:10',	NULL,	'smtp.agencythriveprogram.com',	'jim.campbell@engagex.com',	'Letmein12@',	'Makati,Ortigas,BGC,Alabang',	'Joven,Meriam,Kenjie,Kaylie,Jimmy',	1,	1,	1,	1),
(2,	'',	'',	'joven.barola@engagex.com',	'Engagex',	NULL,	'',	'914bafe46a39ad5f7b7f96045c645450',	'2017-07-30 16:36:19',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	1,	1,	1);

DROP TABLE IF EXISTS `tbl_account_setup_policy`;
CREATE TABLE `tbl_account_setup_policy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_parent_label` enum('Auto','Home') DEFAULT NULL COMMENT 'Values are: "Home" and "Auto"',
  `policy_child_label` varchar(45) DEFAULT NULL,
  `policy_child_questions` text,
  `policy_child_values` mediumtext,
  `is_child_checked` tinyint(4) DEFAULT '0',
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_policy_parent` (`policy_parent_label`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_action_item`;
CREATE TABLE `tbl_action_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT 'FK: tbl_customer',
  `action_type_code` varchar(45) NOT NULL COMMENT 'FK: tbl_action_type',
  `owner` varchar(45) DEFAULT NULL COMMENT 'This is based on the selected staff (Account Setup)',
  `description` text,
  `ci_review_guid` varchar(255) DEFAULT NULL COMMENT 'FK: tbl_ci_review',
  `is_opportunity` tinyint(4) DEFAULT NULL,
  `is_completed` tinyint(4) DEFAULT '0' COMMENT ' Insurance Agent will mark this Action Item if completed',
  `created_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_action_item` (`id`, `customer_id`, `action_type_code`, `owner`, `description`, `ci_review_guid`, `is_opportunity`, `is_completed`, `created_date`, `due_date`, `account_id`) VALUES
(1,	2,	'',	'Kenjie',	'Engagex',	NULL,	1,	0,	'2017-07-27',	'2017-07-28',	1),
(6,	53,	'',	'Kenjie',	'test',	NULL,	1,	1,	'2017-08-03',	'2017-08-03',	1),
(8,	61,	'',	'Jimmy',	'Wow',	NULL,	0,	0,	'2017-08-03',	'2017-08-03',	1);

DROP TABLE IF EXISTS `tbl_action_type`;
CREATE TABLE `tbl_action_type` (
  `action_type_code` varchar(45) NOT NULL COMMENT 'Values: Customer Contact, Dependents, Auto, Home, Concerns and Questions',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`action_type_code`),
  UNIQUE KEY `action_type_code_UNIQUE` (`action_type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_activity_meta`;
CREATE TABLE `tbl_activity_meta` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL COMMENT 'This store comma delimited data, to use for referencing on a Transaction',
  `meta_value` text COMMENT 'This store json data, or plain data',
  `account_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_appointment`;
CREATE TABLE `tbl_appointment` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` varchar(45) NOT NULL,
  `location` varchar(45) NOT NULL COMMENT 'Check: tbl_account_setup',
  `is_completed` tinyint(4) DEFAULT NULL COMMENT 'Flag if steps are now completed',
  `assessment_guid` varchar(255) DEFAULT NULL COMMENT 'Relate: Need Assessment',
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_ci_review`;
CREATE TABLE `tbl_ci_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assessment_guid` varchar(255) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `ci_review_submitted_to` varchar(255) DEFAULT NULL COMMENT 'Email address of NA receipient',
  `ci_review_guid` varchar(255) DEFAULT NULL,
  `is_completed` tinyint(4) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_colour_scheme`;
CREATE TABLE `tbl_colour_scheme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scheme_name` varchar(45) NOT NULL,
  `color_1` varchar(45) NOT NULL,
  `color_2` varchar(45) NOT NULL,
  `color_3` varchar(45) NOT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `scheme_name_UNIQUE` (`scheme_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_colour_scheme` (`id`, `scheme_name`, `color_1`, `color_2`, `color_3`, `account_id`) VALUES
(1,	'(Default)',	'null',	'null',	'null',	1),
(2,	'Theme 1',	'#f2ab14',	'#070600',	'#070800',	1),
(4,	'Theme 2',	'#C2847A',	'#280003',	'#848586',	1);

DROP TABLE IF EXISTS `tbl_current_coverage`;
CREATE TABLE `tbl_current_coverage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `policy_parent_code` varchar(45) DEFAULT NULL COMMENT 'Values are: "Auto" or "Home"',
  `policy_child_label` varchar(45) DEFAULT NULL,
  `policy_child_selected` varchar(75) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_customer`;
CREATE TABLE `tbl_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `primary_firstname` varchar(45) NOT NULL,
  `primary_lastname` varchar(45) NOT NULL,
  `primary_telno` varchar(75) DEFAULT NULL,
  `primary_cellphone` varchar(75) DEFAULT NULL,
  `primary_alt_telno` varchar(75) DEFAULT NULL,
  `primary_address` varchar(255) DEFAULT NULL,
  `primary_email` varchar(75) DEFAULT NULL,
  `primary_emergency_contact` varchar(45) DEFAULT NULL,
  `secondary_firstname` varchar(45) DEFAULT NULL,
  `secondary_lastname` varchar(45) DEFAULT NULL,
  `secondary_telno` varchar(75) DEFAULT NULL,
  `secondary_cellphone` varchar(75) DEFAULT NULL,
  `secondary_alt_telno` varchar(75) DEFAULT NULL,
  `secondary_address` varchar(255) DEFAULT NULL,
  `secondary_email` varchar(75) DEFAULT NULL,
  `secondary_emergency_contact` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_customer` (`id`, `primary_firstname`, `primary_lastname`, `primary_telno`, `primary_cellphone`, `primary_alt_telno`, `primary_address`, `primary_email`, `primary_emergency_contact`, `secondary_firstname`, `secondary_lastname`, `secondary_telno`, `secondary_cellphone`, `secondary_alt_telno`, `secondary_address`, `secondary_email`, `secondary_emergency_contact`, `created_at`, `updated_at`, `account_id`) VALUES
(2,	'Jim',	'Campbell',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'Jim',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2017-07-27 11:55:30',	NULL,	1),
(53,	'Kaylie',	'Barola',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2017-07-27 13:31:34',	NULL,	1),
(58,	'Tom',	'Jones',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2017-07-28 13:35:11',	NULL,	1),
(61,	'Bart',	'Simpson',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2017-07-28 15:34:12',	NULL,	1),
(62,	'Kenjie',	'Kumukura',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2017-07-29 12:38:10',	NULL,	1);

DROP TABLE IF EXISTS `tbl_dependent`;
CREATE TABLE `tbl_dependent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `dependent_name` varchar(45) DEFAULT NULL,
  `dependent_age` varchar(45) DEFAULT NULL COMMENT 'Ages is in the range of 0-100  (this includes Baby, Kids, Adults)',
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_education`;
CREATE TABLE `tbl_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `policy_parent_label` varchar(45) DEFAULT NULL,
  `policy_child_label` varchar(45) DEFAULT NULL,
  `policy_child_selected` varchar(45) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_feedback`;
CREATE TABLE `tbl_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_url` text NOT NULL COMMENT 'URL they have concern about',
  `reporter_name` varchar(45) NOT NULL COMMENT 'Required',
  `reporter_email` varchar(255) NOT NULL COMMENT 'Optional',
  `message` text NOT NULL COMMENT 'Feedback message by the users',
  `status` varchar(45) NOT NULL DEFAULT 'Open' COMMENT 'Status of the reported feedback',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_feedback` (`id`, `page_url`, `reporter_name`, `reporter_email`, `message`, `status`, `created_at`, `updated_at`, `account_id`) VALUES
(1,	'https://tools.agencythriveprogram.com/site/index',	'jim.campbell@engagex.com',	'jim.campbell@engagex.com',	'This is looking good ',	'Open',	'2017-07-28 12:41:30',	NULL,	1),
(2,	'https://tools.agencythriveprogram.com/site/index',	'jim.campbell@engagex.com',	'jim.campbell@engagex.com',	'This is looking good ',	'Open',	'2017-07-28 12:41:30',	NULL,	1),
(3,	'https://tools.agencythriveprogram.com/account/setup',	'jim.campbell@engagex.com',	'jim.campbell@engagex.com',	'Test',	'Open',	'2017-07-31 14:41:30',	NULL,	1);

DROP TABLE IF EXISTS `tbl_goals_concern`;
CREATE TABLE `tbl_goals_concern` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `ci_review_guid` varchar(255) DEFAULT NULL,
  `action_type` varchar(45) DEFAULT NULL COMMENT 'This only save "Goal" and "Concern"',
  `action_description` varchar(255) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_life_changes`;
CREATE TABLE `tbl_life_changes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `assessment_guid` varchar(255) DEFAULT NULL,
  `life_question` varchar(45) DEFAULT NULL,
  `life_answer` varchar(45) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_long_term_goals`;
CREATE TABLE `tbl_long_term_goals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `assessment_guid` varchar(255) DEFAULT NULL,
  `goal_question` varchar(45) DEFAULT NULL,
  `goal_answer` text,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_needs_assessment`;
CREATE TABLE `tbl_needs_assessment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assessment_guid` varchar(255) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `assessment_submitted_to` varchar(255) DEFAULT NULL COMMENT 'Email address of NA receipient',
  `is_steps_completed` tinyint(4) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_note`;
CREATE TABLE `tbl_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `msg_note` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_policies_in_place`;
CREATE TABLE `tbl_policies_in_place` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `assessment_guid` varchar(255) DEFAULT NULL,
  `policy_parent_label` varchar(45) DEFAULT NULL,
  `policy_child_label` varchar(45) DEFAULT NULL,
  `insurance_company` varchar(255) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_policy_line_question`;
CREATE TABLE `tbl_policy_line_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `assessment_guid` varchar(255) DEFAULT NULL,
  `policy_parent_label` varchar(45) DEFAULT NULL,
  `policy_child_label` varchar(45) DEFAULT NULL,
  `policy_child_selected` varchar(45) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_reporting`;
CREATE TABLE `tbl_reporting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_name` varchar(45) DEFAULT NULL,
  `data1` text,
  `data2` text,
  `data3` text,
  `data4` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_reporting` (`id`, `report_name`, `data1`, `data2`, `data3`, `data4`) VALUES
(41,	'action_item',	'<tr style=\"background-color: #045aa5;color:white;\"><td>Column1</td><td>Column2</td><td>Column3</td><td>Column4</td><td>Column5</td><td>Column6</td><td>Column7</td><td>Column8</td><td>Column9</td><td>Column10</td><td>Column11</td><td>Column12</td></tr>',	'<tr><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td><td>Row0</td></tr><tr><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td><td>Row1</td></tr><tr><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td><td>Row2</td></tr><tr><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td><td>Row3</td></tr><tr><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td><td>Row4</td></tr><tr><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td><td>Row5</td></tr><tr><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td><td>Row6</td></tr><tr><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td><td>Row7</td></tr><tr><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td><td>Row8</td></tr><tr><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td><td>Row9</td></tr><tr><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td><td>Row10</td></tr>',	'',	NULL);

DROP TABLE IF EXISTS `tbl_top_concerns`;
CREATE TABLE `tbl_top_concerns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `assessment_guid` varchar(255) DEFAULT NULL,
  `concern_question` varchar(45) DEFAULT NULL,
  `concern_answer` varchar(45) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `roles` varchar(45) NOT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_user` (`id`, `username`, `password`, `email`, `roles`, `account_id`) VALUES
(2,	'jim.campbell@engagex.com',	'c92144f2bfc3a21cccf369fbc744a473',	'jim.campbell@engagex.com',	'admin',	1),
(3,	'joven.barola@engagex.com',	'914bafe46a39ad5f7b7f96045c645450',	'joven.barola@engagex.com',	'admin',	0);

-- 2017-08-04 16:33:54
