-- MySQL Workbench Synchronization
-- Generated: 2016-06-28 09:51
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Fredy

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `shippingweight`.`certificate` 
DROP COLUMN `job_order`;

ALTER TABLE `shippingweight`.`shipment` 
DROP COLUMN `payment`,
DROP COLUMN `job_order`,
ADD COLUMN `container_status` ENUM('new', 'certified') NULL DEFAULT 'new' AFTER `container_number`,
ADD COLUMN `payment_status` ENUM('billed', 'paid') NULL DEFAULT 'billed' AFTER `container_status`,
ADD COLUMN `payment_bill` INT(11) NULL DEFAULT NULL AFTER `payment_status`,
ADD COLUMN `payment_date` DATETIME NULL DEFAULT NULL AFTER `payment_bill`,
ADD COLUMN `payment_by` INT(11) NULL DEFAULT NULL AFTER `payment_date`;

ALTER TABLE `shippingweight`.`weighing` 
DROP COLUMN `measurement_method`,
CHANGE COLUMN `job_order` `job_order` VARCHAR(255) NULL DEFAULT NULL AFTER `grossmass`,
CHANGE COLUMN `measured_at` `date` DATETIME NULL DEFAULT NULL ,
ADD COLUMN `emkl_name` VARCHAR(255) NULL DEFAULT NULL AFTER `job_order`,
ADD COLUMN `emkl_email` VARCHAR(255) NULL DEFAULT NULL AFTER `emkl_name`;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
