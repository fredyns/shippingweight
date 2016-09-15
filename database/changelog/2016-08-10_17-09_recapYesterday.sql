-- MySQL Workbench Synchronization
-- Generated: 2016-08-10 17:09
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Fredy

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


USE `shippingweight`;
DROP procedure IF EXISTS `shippingweight`.`recapYesterday`;

DELIMITER $$
USE `shippingweight`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `recapYesterday`()
BEGIN

SET @now = NOW();
SET @date = DATE(@now);
SET @yesterday = DATE_SUB(@date, INTERVAL 1 DAY);
SET @stampToday = UNIX_TIMESTAMP(@date);
SET @stampYesterday = UNIX_TIMESTAMP(@yesterday);

SELECT @regCount := count(*)
FROM container
WHERE container.created_at >= @stampYesterday
AND container.created_at < @stampToday;

INSERT INTO
	reportDaily
    (day, registerCount)
VALUES
	(@date, IFNULL(@regCount, 0))
ON DUPLICATE KEY UPDATE registerCount = @regCount;


SELECT @certCount = count(*)
FROM container
WHERE container.weighing_date is NOT null
AND container.weighing_date LIKE CONCAT(@date, '%');


UPDATE reportDaily
SET reportDaily.certificateCount = IFNULL(@certCount, 0)
WHERE reportDaily.day = @date;



SELECT @paidCount := sum(transfer.containerCount)
FROM transfer
WHERE transfer.created_at >= @stampYesterday
AND transfer.created_at < @stampToday;

INSERT INTO
	reportDaily
    (day, paidCount)
VALUES
	(@date, IFNULL(@paidCount, 0))
ON DUPLICATE KEY UPDATE paidCount = @paidCount;


END$$

DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
