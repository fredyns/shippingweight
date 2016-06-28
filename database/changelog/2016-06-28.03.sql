-- MySQL Workbench Synchronization
-- Generated: 2016-06-28 20:16
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Fredy

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `shippingweight`.`weighing` 
DROP COLUMN `gateout_trackNumber`,
DROP COLUMN `gatein_trackNumber`,
DROP COLUMN `emkl_email`,
DROP COLUMN `emkl_name`,
DROP COLUMN `date`,
CHANGE COLUMN `container_number` `container_number` VARCHAR(64) NOT NULL ,
ADD COLUMN `container_id` INT(11) NULL DEFAULT NULL AFTER `container_number`,
ADD COLUMN `stack_datetime` DATETIME NULL DEFAULT NULL AFTER `job_order`,
ADD COLUMN `emkl_id` INT(11) NULL DEFAULT NULL AFTER `stack_datetime`,
ADD COLUMN `gatein_tracknumber` VARCHAR(255) NULL DEFAULT NULL AFTER `gatein_grossmass`,
ADD COLUMN `gateout_tracknumber` VARCHAR(255) NULL DEFAULT NULL AFTER `gateout_grossmass`,
ADD INDEX `index2` (`container_number` ASC),
ADD INDEX `index3` (`container_id` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
