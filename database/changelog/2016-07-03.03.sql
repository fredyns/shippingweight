-- MySQL Workbench Synchronization
-- Generated: 2016-07-03 07:16
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Fredy

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `shippingweight`.`container` 
ADD COLUMN `payment_id` INT(11) NULL DEFAULT NULL AFTER `status`,
ADD INDEX `index4` (`payment_id` ASC);

ALTER TABLE `shippingweight`.`container` 
ADD CONSTRAINT `fk_container_2`
  FOREIGN KEY (`payment_id`)
  REFERENCES `shippingweight`.`payment` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
