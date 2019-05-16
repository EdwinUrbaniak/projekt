CREATE DATABASE baza;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `users` (
  `id`    INT         NOT NULL AUTO_INCREMENT,
  `ean8`  INT(8)      NOT NULL,
  `name`  VARCHAR(20) NOT NULL,
  `login` VARCHAR(30) NOT NULL,
  `pass`  VARCHAR(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`ean8`)
);

INSERT INTO `users` (`ean8`, `name`, `login`, `pass`) VALUES (96385074, 'Adam', 'adamo', 'dupa123');

CREATE TABLE IF NOT EXISTS `books` (
  `id`          INT          NOT NULL AUTO_INCREMENT,
  `ean8`        INT(8)       NOT NULL,
  `title`       VARCHAR(40)  NOT NULL,
  `author`      VARCHAR(40)  NOT NULL,
  `description` VARCHAR(100) NOT NULL,
  `status`      VARCHAR(30)  NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`ean8`)
);

INSERT INTO `books` (`ean8`, `title`, `author`, `description`, `status`)
VALUES (188855684, 'Harry Pota', 'J.K. Rowling', 'Jakis tam super opis.', 'WYPOZYCZONA');
INSERT INTO `books` (`ean8`, `title`, `author`, `description`, `status`)
VALUES (84352975, 'Jakas ksiazka', 'jakis autor', 'Jakis tam super opis 2.', 'DOSTEPNA');

CREATE TABLE IF NOT EXISTS `borrows` (
  `id`          INT      NOT NULL AUTO_INCREMENT,
  `user_id`     INT(20)  NOT NULL,
  `book_id`     INT(20)  NOT NULL,
  `date_borrow` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  FOREIGN KEY (`book_id`) REFERENCES `books` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
  ENGINE = InnoDB;

INSERT INTO `borrows` (`user_id`, `book_id`, `date_borrow`) VALUES (1, 1, CURRENT_TIME());

CREATE TABLE IF NOT EXISTS `history` (
  `id`          INT      NOT NULL AUTO_INCREMENT,
  `user_id`     INT(20)  NOT NULL,
  `book_id`     INT(20)  NOT NULL,
  `date_borrow` DATETIME NOT NULL,
  `date_return` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  FOREIGN KEY (`book_id`) REFERENCES `books` (`id`)
);