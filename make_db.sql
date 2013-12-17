SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `the_wall` DEFAULT CHARACTER SET utf8 ;
USE `the_wall` ;

-- -----------------------------------------------------
-- Table `the_wall`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `the_wall`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(255) NULL DEFAULT NULL ,
  `last_name` VARCHAR(255) NULL DEFAULT NULL ,
  `email` VARCHAR(255) NULL DEFAULT NULL ,
  `password` VARCHAR(255) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `the_wall`.`messages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `the_wall`.`messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `users_id` INT(11) NOT NULL ,
  `message` TEXT NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_messages_users_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_messages_users`
    FOREIGN KEY (`users_id` )
    REFERENCES `the_wall`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `the_wall`.`comments`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `the_wall`.`comments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `messages_id` INT(11) NOT NULL ,
  `users_id` INT(11) NOT NULL ,
  `comment` TEXT NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL COMMENT '	' ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_comments_messages1_idx` (`messages_id` ASC) ,
  INDEX `fk_comments_users1_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_comments_messages1`
    FOREIGN KEY (`messages_id` )
    REFERENCES `the_wall`.`messages` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `the_wall`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8;

USE `the_wall` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
