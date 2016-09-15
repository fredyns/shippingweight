-- MySQL Workbench Synchronization
-- Generated: 2016-08-10 11:50
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Fredy

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `shippingweight`.`container` 
ADD COLUMN `transfer_id` INT(11) NULL DEFAULT NULL AFTER `sentShipper_at`,
ADD INDEX `index5` (`transfer_id` ASC);

ALTER TABLE `shippingweight`.`container` 
ADD CONSTRAINT `fk_container_3`
  FOREIGN KEY (`transfer_id`)
  REFERENCES `shippingweight`.`transfer` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
