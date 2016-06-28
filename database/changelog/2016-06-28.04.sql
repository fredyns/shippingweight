-- MySQL Workbench Synchronization
-- Generated: 2016-06-28 20:17
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Fredy

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE TABLE IF NOT EXISTS `shippingweight`.`container` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `shipper_id` INT(11) NOT NULL,
  `number` VARCHAR(64) NOT NULL,
  `status` ENUM('registered', 'ready', 'verified', 'alert') NULL DEFAULT 'registered',
  `bill` INT(11) NULL DEFAULT NULL,
  `grossmass` FLOAT(11) NULL DEFAULT NULL,
  `weighing_date` DATE NULL DEFAULT NULL,
  `certificate_file` TEXT NULL DEFAULT NULL,
  `payment_by` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `billed_by` INT(11) NULL DEFAULT NULL,
  `verified_by` INT(11) NULL DEFAULT NULL,
  `checked_by` INT(11) NULL DEFAULT NULL,
  `sentOwner_by` INT(11) NULL DEFAULT NULL,
  `sentShipper_by` INT(11) NULL DEFAULT NULL,
  `created_at` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  `billed_at` INT(11) NULL DEFAULT NULL,
  `checked_at` INT(11) NULL DEFAULT NULL,
  `verified_at` INT(11) NULL DEFAULT NULL,
  `sentOwner_at` INT(11) NULL DEFAULT NULL,
  `sentShipper_at` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `index2` (`shipper_id` ASC),
  INDEX `index3` (`number` ASC),
  CONSTRAINT `fk_container_1`
    FOREIGN KEY (`shipper_id`)
    REFERENCES `shippingweight`.`shipper` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `shippingweight`.`emkl` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL DEFAULT NULL,
  `address` TEXT NULL DEFAULT NULL,
  `phone` VARCHAR(255) NULL DEFAULT NULL,
  `npwp` VARCHAR(255) NULL DEFAULT NULL,
  `email` VARCHAR(255) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
