-- MySQL Workbench Synchronization
-- Generated: 2016-08-10 17:06
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Fredy

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


USE `shippingweight`;
DROP procedure IF EXISTS `shippingweight`.`recapToday`;

DELIMITER $$
USE `shippingweight`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `recapToday`()
BEGIN

SET @now = NOW();
SET @date = DATE(@now);
SET @timestamp = UNIX_TIMESTAMP(@date);

SELECT @regCount := count(*) 
FROM container
WHERE container.created_at >= @timestamp;

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
WHERE transfer.created_at >= @timestamp;

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
