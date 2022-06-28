SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Table `kreisperson`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kreisperson` ;

CREATE TABLE IF NOT EXISTS `kreisperson` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NULL,
  `lastname` VARCHAR(255) NULL,
  `email` VARCHAR(120) NULL,
  `phone` VARCHAR(45) NULL,
  `street` VARCHAR(255) NULL,
  `zip` VARCHAR(10) NULL,
  `city` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kreiskontakt`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kreiskontakt` ;

CREATE TABLE IF NOT EXISTS `kreiskontakt` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `person_id` INT NOT NULL,
  `vereinsrolle_id` INT NOT NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_kreiskontakt_vereinsrolle1_idx` (`vereinsrolle_id` ASC),
  INDEX `fk_kreiskontakt_kreisperson1_idx` (`person_id` ASC),
  CONSTRAINT `fk_kreiskontakt_vereinsrolle1`
    FOREIGN KEY (`vereinsrolle_id`)
    REFERENCES `vereinsrolle` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_kreiskontakt_kreisperson1`
    FOREIGN KEY (`person_id`)
    REFERENCES `kreisperson` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `kreisrolle_has_funktionsgruppe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kreisrolle_has_funktionsgruppe` ;

CREATE TABLE IF NOT EXISTS `kreisrolle_has_funktionsgruppe` (
  `vereinsrolle_id` INT NOT NULL,
  `funktionsgruppe_id` INT NOT NULL,
  `sort` INT NULL,
  PRIMARY KEY (`vereinsrolle_id`, `funktionsgruppe_id`),
  INDEX `fk_kreiskontakt_has_funktionsgruppe_funktionsgruppe1_idx` (`funktionsgruppe_id` ASC),
  INDEX `fk_kreiskontakt_has_funktionsgruppe_vereinsrolle1_idx` (`vereinsrolle_id` ASC),
  CONSTRAINT `fk_kreiskontakt_has_funktionsgruppe_funktionsgruppe1`
    FOREIGN KEY (`funktionsgruppe_id`)
    REFERENCES `funktionsgruppe` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_kreiskontakt_has_funktionsgruppe_vereinsrolle1`
    FOREIGN KEY (`vereinsrolle_id`)
    REFERENCES `vereinsrolle` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (7, 2, 'Vorsitzender', 'Vors');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (8, 2, 'Stv.Vorsitzender', 'Stv.Vors');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (9, 2, 'Schatzmeister', 'Schatzm.');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (10, 2, 'Sportwart', 'SW');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (11, 2, 'Jugendwart', 'JW');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (12, 2, 'Pressewart', 'PW');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (13, 2, 'Pokalbeauftragter', 'Pokb');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (14, 2, 'Ehrenvorsitzender', 'EV');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (15, 3, 'Kassenprüfer', 'KP');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (16, 4, 'Jugendwart', 'JW');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (17, 4, 'Stv. Jugendwart', 'Stv.JW');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (18, 4, 'Jugendpokalbeauftragter', 'JugPok');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (19, 4, 'Jugendpunktspielbeauftragter', 'JugPunktb');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (20, 4, 'Minibeauftragter', 'Minib');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (21, 4, 'Beisitzer', 'Beisitzer');


INSERT INTO `right` (`id`, `name`, `rightgroup_id`, `sort`, `route`) VALUES ('8', 'Kreiskontakte pflegen', '2', '4', 'kreiskontakte/index');
INSERT INTO `right` (`id`, `name`, `rightgroup_id`, `sort`, `route`) VALUES ('9', 'Kreisausschüsse - Rollen zuordnen', '2', '5', 'kreiskontakte/ausschusszuordnung');


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


