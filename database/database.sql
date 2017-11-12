CREATE TABLE `ledger_account` (
  `account_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_number` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `account_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `account_name_slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hide_ui` tinyint(1) NOT NULL DEFAULT '0',
  `is_left` tinyint(1) NOT NULL,
  `is_right` tinyint(1) NOT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `UNIQ_B3339695B1A4D127` (`account_number`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ledger_account_group` (
  `child_account_id` int(10) unsigned NOT NULL,
  `parent_account_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`child_account_id`,`parent_account_id`),
  KEY `IDX_D193EA1FDC28DBEA` (`parent_account_id`),
  KEY `IDX_D193EA1F7FB4A1D1` (`child_account_id`),
  CONSTRAINT `FK_D193EA1F7FB4A1D1` FOREIGN KEY (`child_account_id`) REFERENCES `ledger_account` (`account_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_D193EA1FDC28DBEA` FOREIGN KEY (`parent_account_id`) REFERENCES `ledger_account` (`account_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `ledger_journal_type` (
  `journal_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `journal_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `journal_name_slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hide_ui` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`journal_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ledger_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `external_guid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rego_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ledger_org_unit` (
  `org_unit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_unit_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `org_unit_name_slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hide_ui` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`org_unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `ledger_transaction` (
  `transaction_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `journal_type_id` int(10) unsigned NOT NULL,
  `adjustment_id` int(10) unsigned DEFAULT NULL,
  `org_unit_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `process_dt` date NOT NULL,
  `occured_dt` date NOT NULL,
  `vouchernum` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `IDX_AAA417A715F7C276` (`journal_type_id`),
  KEY `IDX_AAA417A75D6DA33D` (`adjustment_id`),
  KEY `IDX_AAA417A78BC224C3` (`org_unit_id`),
  KEY `IDX_AAA417A7A76ED395` (`user_id`),
  CONSTRAINT `FK_AAA417A7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `ledger_user` (`user_id`),
  CONSTRAINT `FK_AAA417A715F7C276` FOREIGN KEY (`journal_type_id`) REFERENCES `ledger_journal_type` (`journal_type_id`),
  CONSTRAINT `FK_AAA417A75D6DA33D` FOREIGN KEY (`adjustment_id`) REFERENCES `ledger_transaction` (`transaction_id`),
  CONSTRAINT `FK_AAA417A78BC224C3` FOREIGN KEY (`org_unit_id`) REFERENCES `ledger_org_unit` (`org_unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100508 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ledger_entry` (
  `entry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(10) unsigned NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `movement` double NOT NULL,
  PRIMARY KEY (`entry_id`),
  KEY `IDX_64272A692FC0CB0F` (`transaction_id`),
  KEY `IDX_64272A699B6B5FBA` (`account_id`),
  CONSTRAINT `FK_64272A699B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `ledger_account` (`account_id`),
  CONSTRAINT `FK_64272A692FC0CB0F` FOREIGN KEY (`transaction_id`) REFERENCES `ledger_transaction` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=402410 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `ledger_daily` (
  `process_dt` date NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `balance` double NOT NULL,
  PRIMARY KEY (`process_dt`,`account_id`),
  KEY `IDX_C19B1C739B6B5FBA` (`account_id`),
  CONSTRAINT `FK_C19B1C739B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `ledger_account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ledger_daily_org` (
  `process_dt` date NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `org_unit_id` int(10) unsigned NOT NULL,
  `balance` double NOT NULL,
  PRIMARY KEY (`process_dt`,`account_id`,`org_unit_id`),
  KEY `IDX_2D1E57EB9B6B5FBA` (`account_id`),
  KEY `IDX_2D1E57EB8BC224C3` (`org_unit_id`),
  CONSTRAINT `FK_2D1E57EB8BC224C3` FOREIGN KEY (`org_unit_id`) REFERENCES `ledger_org_unit` (`org_unit_id`),
  CONSTRAINT `FK_2D1E57EB9B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `ledger_account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ledger_daily_user` (
  `process_dt` date NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `balance` double NOT NULL,
  PRIMARY KEY (`process_dt`,`account_id`,`user_id`),
  KEY `IDX_57AC65749B6B5FBA` (`account_id`),
  KEY `IDX_57AC6574A76ED395` (`user_id`),
  CONSTRAINT `FK_57AC6574A76ED395` FOREIGN KEY (`user_id`) REFERENCES `ledger_user` (`user_id`),
  CONSTRAINT `FK_57AC65749B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `ledger_account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
