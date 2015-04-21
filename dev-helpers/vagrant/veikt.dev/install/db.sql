CREATE SCHEMA IF NOT EXISTS `veikt`
CREATE TABLE `users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(225) NOT NULL COLLATE 'utf8_unicode_ci',
	`password` VARCHAR(80) NOT NULL COLLATE 'utf8_unicode_ci',
	`name` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`phone` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`photo` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`role` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`cdate` DATETIME NULL DEFAULT NULL,
	`mdate` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `email` (`email`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
;