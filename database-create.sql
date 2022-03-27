-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema ttkv-app
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `role` ;

CREATE TABLE IF NOT EXISTS `role` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `verein`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `verein` ;

CREATE TABLE IF NOT EXISTS `verein` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` TEXT NULL,
  `ort` TEXT NULL,
  `vereinsnummer` TEXT NULL,
  `deleted` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user` ;

CREATE TABLE IF NOT EXISTS `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NULL,
  `email` TEXT NULL,
  `password` TEXT NULL,
  `created` DATETIME NULL,
  `role_id` INT NOT NULL,
  `vereins_id` INT NULL,
  `is_validated` INT NULL,
  `validationtoken` VARCHAR(255) NULL,
  `lastlogindate` DATETIME NULL,
  `token` VARCHAR(255) NULL,
  `locked` INT NULL,
  `lockeddate` DATETIME NULL,
  `passwordforgottentoken` VARCHAR(255) NULL,
  `passwordforgottendate` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user1_role_idx` (`role_id` ASC),
  INDEX `fk_user_verein1_idx` (`vereins_id` ASC),
  CONSTRAINT `fk_user1_role`
    FOREIGN KEY (`role_id`)
    REFERENCES `role` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_verein1`
    FOREIGN KEY (`vereins_id`)
    REFERENCES `verein` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rightgroup`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rightgroup` ;

CREATE TABLE IF NOT EXISTS `rightgroup` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `sort` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `right`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `right` ;

CREATE TABLE IF NOT EXISTS `right` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NULL,
  `rightgroup_id` INT NOT NULL,
  `sort` INT NULL,
  `route` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_right_rightgroup1_idx` (`rightgroup_id` ASC),
  CONSTRAINT `fk_right_rightgroup1`
    FOREIGN KEY (`rightgroup_id`)
    REFERENCES `rightgroup` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `role_has_right`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `role_has_right` ;

CREATE TABLE IF NOT EXISTS `role_has_right` (
  `role_id` INT NOT NULL,
  `right_id` INT NOT NULL,
  `created` DATETIME NULL,
  PRIMARY KEY (`role_id`, `right_id`),
  INDEX `fk_role_has_right_right1_idx` (`right_id` ASC),
  INDEX `fk_role_has_right_role1_idx` (`role_id` ASC),
  CONSTRAINT `fk_role_has_right_role1`
    FOREIGN KEY (`role_id`)
    REFERENCES `role` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_has_right_right1`
    FOREIGN KEY (`right_id`)
    REFERENCES `right` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `season`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `season` ;

CREATE TABLE IF NOT EXISTS `season` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `created_at` DATETIME NULL,
  `active` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vereinsmeldung`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vereinsmeldung` ;

CREATE TABLE IF NOT EXISTS `vereinsmeldung` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `season_id` INT NOT NULL,
  `vereins_id` INT NOT NULL,
  `status` VARCHAR(45) NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_vereinsmeldung_season1_idx` (`season_id` ASC),
  INDEX `fk_vereinsmeldung_verein1_idx` (`vereins_id` ASC),
  CONSTRAINT `fk_vereinsmeldung_season1`
    FOREIGN KEY (`season_id`)
    REFERENCES `season` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vereinsmeldung_verein1`
    FOREIGN KEY (`vereins_id`)
    REFERENCES `verein` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vereinsmeldemodul`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vereinsmeldemodul` ;

CREATE TABLE IF NOT EXISTS `vereinsmeldemodul` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `url` VARCHAR(255) NULL,
  `class_module` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `season_has_vereinsmeldemodul`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `season_has_vereinsmeldemodul` ;

CREATE TABLE IF NOT EXISTS `season_has_vereinsmeldemodul` (
  `season_id` INT NOT NULL,
  `vereinsmeldemodul_id` INT NOT NULL,
  `sort` INT NULL,
  PRIMARY KEY (`season_id`, `vereinsmeldemodul_id`),
  INDEX `fk_season2vereinsmeldemodul_vereinsmeldemodul1_idx` (`vereinsmeldemodul_id` ASC),
  CONSTRAINT `fk_season2vereinsmeldemodul_season1`
    FOREIGN KEY (`season_id`)
    REFERENCES `season` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_season2vereinsmeldemodul_vereinsmeldemodul1`
    FOREIGN KEY (`vereinsmeldemodul_id`)
    REFERENCES `vereinsmeldemodul` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vereinsmeldung_kontakte`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vereinsmeldung_kontakte` ;

CREATE TABLE IF NOT EXISTS `vereinsmeldung_kontakte` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME NULL,
  `vereinsmeldung_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_vereinsmeldung_kontakte_vereinsmeldung1_idx` (`vereinsmeldung_id` ASC),
  CONSTRAINT `fk_vereinsmeldung_kontakte_vereinsmeldung1`
    FOREIGN KEY (`vereinsmeldung_id`)
    REFERENCES `vereinsmeldung` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `person`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `person` ;

CREATE TABLE IF NOT EXISTS `person` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `vereinsmeldung_kontakte_id` INT NOT NULL,
  `firstname` VARCHAR(45) NULL,
  `lastname` VARCHAR(255) NULL,
  `email` VARCHAR(120) NULL,
  `phone` VARCHAR(45) NULL,
  `street` VARCHAR(255) NULL,
  `zip` VARCHAR(10) NULL,
  `city` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_person_vereinsmeldung_kontakte1_idx` (`vereinsmeldung_kontakte_id` ASC),
  CONSTRAINT `fk_person_vereinsmeldung_kontakte1`
    FOREIGN KEY (`vereinsmeldung_kontakte_id`)
    REFERENCES `vereinsmeldung_kontakte` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `funktionsgruppe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `funktionsgruppe` ;

CREATE TABLE IF NOT EXISTS `funktionsgruppe` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vereinsrolle`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vereinsrolle` ;

CREATE TABLE IF NOT EXISTS `vereinsrolle` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `funktionsgruppe_id` INT NOT NULL,
  `name` VARCHAR(255) NULL,
  `shortname` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_vereinsrolle_funktionsgruppe1_idx` (`funktionsgruppe_id` ASC),
  CONSTRAINT `fk_vereinsrolle_funktionsgruppe1`
    FOREIGN KEY (`funktionsgruppe_id`)
    REFERENCES `funktionsgruppe` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vereinskontakt`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vereinskontakt` ;

CREATE TABLE IF NOT EXISTS `vereinskontakt` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `vereinsmeldung_kontakte_id` INT NOT NULL,
  `vereinsrolle_id` INT NOT NULL,
  `person_id` INT NOT NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_vereinskontakte_vereinsrolle1_idx` (`vereinsrolle_id` ASC),
  INDEX `fk_vereinskontakte_person1_idx` (`person_id` ASC),
  INDEX `fk_vereinskontakte_vereinsmeldung_kontakte1_idx` (`vereinsmeldung_kontakte_id` ASC),
  CONSTRAINT `fk_vereinskontakte_vereinsrolle1`
    FOREIGN KEY (`vereinsrolle_id`)
    REFERENCES `vereinsrolle` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vereinskontakte_person1`
    FOREIGN KEY (`person_id`)
    REFERENCES `person` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vereinskontakte_vereinsmeldung_kontakte1`
    FOREIGN KEY (`vereinsmeldung_kontakte_id`)
    REFERENCES `vereinsmeldung_kontakte` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vereinsmeldung_teams`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vereinsmeldung_teams` ;

CREATE TABLE IF NOT EXISTS `vereinsmeldung_teams` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME NULL,
  `vereinsmeldung_id` INT NOT NULL,
  `noteamsflag` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_vereinsmeldung_teams_vereinsmeldung1_idx` (`vereinsmeldung_id` ASC),
  CONSTRAINT `fk_vereinsmeldung_teams_vereinsmeldung1`
    FOREIGN KEY (`vereinsmeldung_id`)
    REFERENCES `vereinsmeldung` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liga`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liga` ;

CREATE TABLE IF NOT EXISTS `liga` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `inactive` DATETIME NULL,
  `sort` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `altersbereich`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `altersbereich` ;

CREATE TABLE IF NOT EXISTS `altersbereich` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `askweeks` INT NULL,
  `askpokal` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `altersklasse`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `altersklasse` ;

CREATE TABLE IF NOT EXISTS `altersklasse` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `sort` INT NULL,
  `altersbereich_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_altersklasse_altersbereich1_idx` (`altersbereich_id` ASC),
  CONSTRAINT `fk_altersklasse_altersbereich1`
    FOREIGN KEY (`altersbereich_id`)
    REFERENCES `altersbereich` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `team`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `team` ;

CREATE TABLE IF NOT EXISTS `team` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `vereinsmeldung_teams_id` INT NOT NULL,
  `altersklasse_id` INT NOT NULL,
  `liga_id` INT NOT NULL,
  `regional` VARCHAR(45) NULL,
  `heimspieltage` VARCHAR(255) NULL,
  `pokalteilnahme` INT NULL,
  `created_at` DATETIME NULL,
  `weeks` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_team_vereinsmeldung_teams1_idx` (`vereinsmeldung_teams_id` ASC),
  INDEX `fk_team_liga1_idx` (`liga_id` ASC),
  INDEX `fk_team_altersklasse1_idx` (`altersklasse_id` ASC),
  CONSTRAINT `fk_team_vereinsmeldung_teams1`
    FOREIGN KEY (`vereinsmeldung_teams_id`)
    REFERENCES `vereinsmeldung_teams` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_team_liga1`
    FOREIGN KEY (`liga_id`)
    REFERENCES `liga` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_team_altersklasse1`
    FOREIGN KEY (`altersklasse_id`)
    REFERENCES `altersklasse` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ligazusammenstellung`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ligazusammenstellung` ;

CREATE TABLE IF NOT EXISTS `ligazusammenstellung` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `altersbereich_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ligazusammenstellung_altersbereich1_idx` (`altersbereich_id` ASC),
  CONSTRAINT `fk_ligazusammenstellung_altersbereich1`
    FOREIGN KEY (`altersbereich_id`)
    REFERENCES `altersbereich` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ligazusammenstellung_has_liga`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ligazusammenstellung_has_liga` ;

CREATE TABLE IF NOT EXISTS `ligazusammenstellung_has_liga` (
  `ligazusammenstellung_id` INT NOT NULL,
  `liga_id` INT NOT NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`ligazusammenstellung_id`, `liga_id`),
  INDEX `fk_ligazusammenstellung_has_liga_liga1_idx` (`liga_id` ASC),
  INDEX `fk_ligazusammenstellung_has_liga_ligazusammenstellung1_idx` (`ligazusammenstellung_id` ASC),
  CONSTRAINT `fk_ligazusammenstellung_has_liga_ligazusammenstellung1`
    FOREIGN KEY (`ligazusammenstellung_id`)
    REFERENCES `ligazusammenstellung` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ligazusammenstellung_has_liga_liga1`
    FOREIGN KEY (`liga_id`)
    REFERENCES `liga` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Data for table `role`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `role` (`id`, `name`) VALUES (1, 'Standard');
INSERT INTO `role` (`id`, `name`) VALUES (2, 'Admin');

COMMIT;


-- -----------------------------------------------------
-- Data for table `verein`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (1, 'TV Asendorf - Dierkshausen', 'Asendorf', '3270250', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (2, 'MTV Ashausen', 'Ashausen', '3270300', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (3, 'TSV Auetal', 'Auetal (Garstedt)', '3277250', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (4, 'SV Bendestorf', 'Bendestorf', '3270450', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (5, 'MTV Brackel', 'Brackel', '3270700', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (6, 'BW Buchholz', 'Buchholz', '3270950', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (7, 'SV Dohren', 'Dohren', '3271600', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (8, 'MTV Egestorf', 'Egestorf', '3271800', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (9, 'SV Emmelndorf', 'Emmelndorf', '3272000', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (10, 'MTV Eyendorf', 'Eyendorf', '3272300', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (11, 'TuS Fleestedt', 'Fleestedt', '3272500', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (12, 'MTV Germania Fliegenberg', 'Fliegenberg', '3272550', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (13, 'MTV Hanstedt', 'Hanstedt', '3272850', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (14, 'TSV Eintracht Hittfeld', 'Hittfeld', '3273200', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (15, 'TuS Jahn Hollenstedt-Wenzendorf', 'Hollenstedt', '3273350', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (16, 'SV Holm-Seppensen', 'Holm-Seppensen', '3273400', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (17, 'MTV Hoopte', 'Hoopte', '3273500', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (18, 'Hundener TTV', 'Hunden', '3273550', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (19, 'VfL Jesteburg', 'Jesteburg', '3273650', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (20, 'SC Klecken', 'Klecken', '3273800', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (21, 'SV Königsmoor', 'Königsmoor', '3273900', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (22, 'MTV Laßrönne', 'Laßrönne', '3274000', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (23, 'MTV Marxen', 'Marxen', '3274400', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (24, 'TV Meckelfeld', 'Meckelfeld', '3274650', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (25, 'MTV Moisburg', 'Moisburg', '3274700', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (26, 'TuS Nenndorf', 'Nenndorf', '3274950', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (27, 'TVV Neu Wulmstorf', 'Neu Wulmstorf', '3278450', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (28, 'MTV Obermarschacht', 'Obermarschacht', '3275000', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (29, 'TSV Over-Bullenhausen', 'Over-Bullenhausen', '3275150', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (30, 'MTV Pattensen', 'Pattensen', '3276500', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (31, 'MTV Salzhausen', 'Salzhausen', '3275750', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (32, 'MTV Scharmbeck', 'Scharmbeck', '3276350', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (33, 'SG TSV Winsen-Schwinde', 'Winsen', '3278200', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (34, 'TSC Steinbeck-Meilsen', 'Steinbeck', '3276540', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (35, 'TSV Stelle', 'Stelle', '3276650', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (36, 'HSV Stöckte', 'Stöckte', '3276700', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (37, 'Todtglüsinger SV', 'Todtglüsingen', '3277050', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (38, 'MTV Tostedt', 'Tostedt', '3277300', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (39, 'TV Vahrendorf', 'Vahrendorf', '3277650', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (40, 'SC Vierhöfen', 'Vierhöfen', '3277700', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (41, 'TV Welle', 'Welle', '3277750', NULL);
INSERT INTO `verein` (`id`, `name`, `ort`, `vereinsnummer`, `deleted`) VALUES (42, 'TSV Heidenau', 'Heidenau', '3273000', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `user`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `password`, `created`, `role_id`, `vereins_id`, `is_validated`, `validationtoken`, `lastlogindate`, `token`, `locked`, `lockeddate`, `passwordforgottentoken`, `passwordforgottendate`) VALUES (1, 'Mark', 'Worthmann', 'mworthmann@googlemail.com', '$2y$10$HDJt2gN0PBa6LADaxbqJZOMRuxGTIA5sVuUA8.aAV9LZPH2zqruqK', '2021-11-28 22:30:00', 2, 27, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `password`, `created`, `role_id`, `vereins_id`, `is_validated`, `validationtoken`, `lastlogindate`, `token`, `locked`, `lockeddate`, `passwordforgottentoken`, `passwordforgottendate`) VALUES (2, 'Mark', 'Worthmann', 'mworthmann@gmail.com', '$2y$10$FsTab.0ditGEZrY5QK.nL.M4wwROhNbUKEVFC8nNrmww2KPCjR7BC', '2021-11-28 22:30:00', 1, 27, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `rightgroup`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `rightgroup` (`id`, `name`, `sort`) VALUES (1, 'Schaltzentrale deines Vereins im TTKV', 1);
INSERT INTO `rightgroup` (`id`, `name`, `sort`) VALUES (2, 'Schaltzentrale Kreis', 2);
INSERT INTO `rightgroup` (`id`, `name`, `sort`) VALUES (3, 'Administration', 3);

COMMIT;


-- -----------------------------------------------------
-- Data for table `right`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `right` (`id`, `name`, `rightgroup_id`, `sort`, `route`) VALUES (1, 'Usermanager', 3, 1, 'usermanager/index');
INSERT INTO `right` (`id`, `name`, `rightgroup_id`, `sort`, `route`) VALUES (2, 'Rolemanager', 3, 2, 'rolemanager/index');
INSERT INTO `right` (`id`, `name`, `rightgroup_id`, `sort`, `route`) VALUES (3, 'Vereinsmeldung abgeben', 1, 1, 'vereinsmeldung/index');
INSERT INTO `right` (`id`, `name`, `rightgroup_id`, `sort`, `route`) VALUES (4, 'Vereinskontakte pflegen', 1, 2, 'vereinskontakte/index');
INSERT INTO `right` (`id`, `name`, `rightgroup_id`, `sort`, `route`) VALUES (5, 'Vereinsmeldung konfigurieren', 2, 1, 'vereinsmeldungadmin/index');

COMMIT;


-- -----------------------------------------------------
-- Data for table `role_has_right`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `role_has_right` (`role_id`, `right_id`, `created`) VALUES (2, 1, '2022-01-01 18:30:00');
INSERT INTO `role_has_right` (`role_id`, `right_id`, `created`) VALUES (2, 2, '2022-01-01 18:30:00');
INSERT INTO `role_has_right` (`role_id`, `right_id`, `created`) VALUES (2, 3, '2022-01-01 18:30:00');
INSERT INTO `role_has_right` (`role_id`, `right_id`, `created`) VALUES (2, 4, '2022-01-01 18:30:00');
INSERT INTO `role_has_right` (`role_id`, `right_id`, `created`) VALUES (2, 5, '2022-01-01 18:30:00');
INSERT INTO `role_has_right` (`role_id`, `right_id`, `created`) VALUES (1, 3, '2022-01-01 18:30:00');
INSERT INTO `role_has_right` (`role_id`, `right_id`, `created`) VALUES (1, 4, '2022-01-01 18:30:00');

COMMIT;


-- -----------------------------------------------------
-- Data for table `vereinsmeldemodul`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `vereinsmeldemodul` (`id`, `name`, `url`, `class_module`) VALUES (1, 'Vereinskontakte eingeben', 'vereinsmeldung/vereinskontakte', 'app\\models\\vereinsmeldung\\vereinskontakte\\VereinsmeldungKontakte');
INSERT INTO `vereinsmeldemodul` (`id`, `name`, `url`, `class_module`) VALUES (2, 'Mannschaften eingeben', 'vereinsmeldung/teams', 'app\\models\\vereinsmeldung\\teams\\VereinsmeldungTeams');
INSERT INTO `vereinsmeldemodul` (`id`, `name`, `url`, `class_module`) VALUES (3, 'Vereinsmeldung auch in Click-tt gepflegt?', 'vereinsmeldung/confirmclicktt', NULL);
INSERT INTO `vereinsmeldemodul` (`id`, `name`, `url`, `class_module`) VALUES (4, 'Pokalmeldung auch in Click-tt gepflegt?', 'vereinsmeldung/confirmpokal', NULL);
INSERT INTO `vereinsmeldemodul` (`id`, `name`, `url`, `class_module`) VALUES (5, 'Abstimmungen für den Verbandstag', 'vereinsmeldung/voting', NULL);
INSERT INTO `vereinsmeldemodul` (`id`, `name`, `url`, `class_module`) VALUES (6, 'Umfragen für den Verbandstag', 'vereinsmeldung/survey', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `season_has_vereinsmeldemodul`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `season_has_vereinsmeldemodul` (`season_id`, `vereinsmeldemodul_id`, `sort`) VALUES (1, 1, 1);
INSERT INTO `season_has_vereinsmeldemodul` (`season_id`, `vereinsmeldemodul_id`, `sort`) VALUES (1, 2, 2);
INSERT INTO `season_has_vereinsmeldemodul` (`season_id`, `vereinsmeldemodul_id`, `sort`) VALUES (1, 3, 3);
INSERT INTO `season_has_vereinsmeldemodul` (`season_id`, `vereinsmeldemodul_id`, `sort`) VALUES (1, 4, 4);
INSERT INTO `season_has_vereinsmeldemodul` (`season_id`, `vereinsmeldemodul_id`, `sort`) VALUES (1, 5, 5);
INSERT INTO `season_has_vereinsmeldemodul` (`season_id`, `vereinsmeldemodul_id`, `sort`) VALUES (1, 6, 6);

COMMIT;


-- -----------------------------------------------------
-- Data for table `funktionsgruppe`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `funktionsgruppe` (`id`, `name`) VALUES (1, 'Vereinsvorstand');
INSERT INTO `funktionsgruppe` (`id`, `name`) VALUES (2, 'Kreisvorstand');
INSERT INTO `funktionsgruppe` (`id`, `name`) VALUES (3, 'Kreisassenprüfer');
INSERT INTO `funktionsgruppe` (`id`, `name`) VALUES (4, 'Kreisjugendausschuss');

COMMIT;


-- -----------------------------------------------------
-- Data for table `vereinsrolle`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (1, 1, 'Abteilungsleiter', 'AL');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (2, 1, 'Stv. Abteilungsleiter', 'Stv.AL');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (3, 1, 'Sportwart', 'SW');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (4, 1, 'Jugendwart', 'JW');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (5, 1, 'Stv.Jugendwart', 'Stv.JW');
INSERT INTO `vereinsrolle` (`id`, `funktionsgruppe_id`, `name`, `shortname`) VALUES (6, 1, 'Vereinsadmin', 'VA');

COMMIT;


-- -----------------------------------------------------
-- Data for table `liga`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (1, 'Bundesliga', NULL, 1);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (2, '2.Bundesliga', NULL, 2);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (3, '3.Bundesliga', NULL, 3);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (4, 'Regionalliga', NULL, 4);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (5, 'Oberliga', NULL, 5);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (6, 'Verbandsliga', NULL, 6);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (7, 'Landesliga', NULL, 7);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (8, 'Niedersachsenliga', NULL, 7);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (9, 'Bezirksoberliga', NULL, 8);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (10, 'Bezirksliga', NULL, 9);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (11, 'Bezirksklasse', NULL, 10);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (12, 'Kreisliga', NULL, 11);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (13, '1.Kreisklasse', NULL, 12);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (14, '2.Kreisklasse', NULL, 13);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (15, '3.Kreisklasse', NULL, 14);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (16, '4.Kreisklasse', NULL, 15);
INSERT INTO `liga` (`id`, `name`, `inactive`, `sort`) VALUES (17, '5.Kreisklasse', NULL, 16);

COMMIT;


-- -----------------------------------------------------
-- Data for table `altersbereich`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `altersbereich` (`id`, `name`, `askweeks`, `askpokal`) VALUES (1, 'Damen', 0, 1);
INSERT INTO `altersbereich` (`id`, `name`, `askweeks`, `askpokal`) VALUES (2, 'Herren', 0, 1);
INSERT INTO `altersbereich` (`id`, `name`, `askweeks`, `askpokal`) VALUES (3, 'Jungen', 1, 0);
INSERT INTO `altersbereich` (`id`, `name`, `askweeks`, `askpokal`) VALUES (4, 'Mädchen', 1, 0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `altersklasse`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (1, 'Damen', 1, 1);
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (2, 'Herren', 2, 2);
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (3, 'Jungen 19', 3, 3);
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (4, 'Jungen 18', 4, 3);
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (5, 'Jungen 17', 5, 3);
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (6, 'Jungen 16', 6, 3);
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (7, 'Jungen 15', 7, 3);
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (8, 'Jungen 14', 8, 3);
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (9, 'Jungen 13', 9, 3);
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (10, 'Jungen 12', 10, 3);
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (11, 'Jungen 11', 11, 3);
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (12, 'Jungen 10', 12, 3);
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (13, 'Jungen 9', 13, 3);
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (14, 'Jungen 8', 14, 3);
INSERT INTO `altersklasse` (`id`, `name`, `sort`, `altersbereich_id`) VALUES (15, 'Mädchen 19', 15, 4);

COMMIT;


-- -----------------------------------------------------
-- Data for table `ligazusammenstellung`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `ligazusammenstellung` (`id`, `name`, `altersbereich_id`) VALUES (1, 'Damen', 1);
INSERT INTO `ligazusammenstellung` (`id`, `name`, `altersbereich_id`) VALUES (2, 'Herren', 2);
INSERT INTO `ligazusammenstellung` (`id`, `name`, `altersbereich_id`) VALUES (3, 'Jungen', 3);
INSERT INTO `ligazusammenstellung` (`id`, `name`, `altersbereich_id`) VALUES (4, 'Mädchen', 4);

COMMIT;


-- -----------------------------------------------------
-- Data for table `ligazusammenstellung_has_liga`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (1, 1, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (1, 2, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (1, 3, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (1, 4, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (1, 5, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (1, 6, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (1, 7, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (1, 9, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (1, 10, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (1, 12, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 1, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 2, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 3, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 4, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 5, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 6, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 7, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 9, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 10, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 11, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 12, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 13, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 14, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 15, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 16, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (3, 8, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (3, 9, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (3, 10, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (3, 11, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (4, 8, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (4, 9, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (4, 11, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (2, 17, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (3, 12, NULL);
INSERT INTO `ligazusammenstellung_has_liga` (`ligazusammenstellung_id`, `liga_id`, `created_at`) VALUES (4, 12, NULL);

COMMIT;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
