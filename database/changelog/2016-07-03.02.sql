-- MySQL Workbench Synchronization
-- Generated: 2016-07-03 07:16
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Fredy

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE TABLE IF NOT EXISTS `shippingweight`.`payment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `customer_id` INT(11) NULL DEFAULT NULL,
  `customer_name` VARCHAR(255) NULL DEFAULT NULL,
  `customer_phone` VARCHAR(255) NULL DEFAULT NULL,
  `container_list` VARCHAR(255) NULL DEFAULT NULL,
  `note` VARCHAR(255) NULL DEFAULT NULL,
  `subtotal` INT(11) NULL DEFAULT NULL,
  `discount` INT(11) NULL DEFAULT NULL,
  `total` INT(11) NULL DEFAULT NULL,
  `status` ENUM('billed', 'paid', 'canceled') NULL DEFAULT 'billed',
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `paid_by` INT(11) NULL DEFAULT NULL,
  `cancel_by` INT(11) NULL DEFAULT NULL,
  `created_at` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  `paid_at` INT(11) NULL DEFAULT NULL,
  `cancel_at` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `index2` (`customer_id` ASC),
  CONSTRAINT `fk_payment_1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `shippingweight`.`customer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
