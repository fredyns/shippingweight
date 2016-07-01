-- MySQL Workbench Synchronization
-- Generated: 2016-07-01 09:33
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Fredy

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `shippingweight`.`container` 
DROP COLUMN `payment_by`,
ADD COLUMN `booking_number` VARCHAR(64) NULL DEFAULT NULL AFTER `number`,
ADD COLUMN `certificate_sequence` INT(11) NULL DEFAULT NULL AFTER `weighing_date`,
ADD COLUMN `certificate_number` VARCHAR(64) NULL DEFAULT NULL AFTER `certificate_sequence`;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
