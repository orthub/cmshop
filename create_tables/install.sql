USE cms_shop;
-- DROP OLD TABLES IF EXISTS
DROP TABLE IF EXISTS `order_products`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `delivery_address`;
DROP TABLE IF EXISTS `cart`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `product_category`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `user_role`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `contact`;
DROP TABLE IF EXISTS `contact_status`;
DROP TABLE IF EXISTS `users_archive`;
-- CREATE CMS TABLES
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` VARCHAR(12) NOT NULL,
  PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `users` (
  `id` VARCHAR(28) NOT NULL,
  `first_name` VARCHAR(24) NOT NULL,
  `last_name` VARCHAR(36) NOT NULL,
  `email` VARCHAR(64) NOT NULL,
  `password` VARCHAR(128) NOT NULL,
  `role_id` INT UNSIGNED NOT NULL DEFAULT 3,
  `home` VARCHAR(64),
  UNIQUE KEY `email` (`email`),
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_users_user_role` FOREIGN KEY (`role_id`) REFERENCES `user_role`(`id`)
);
CREATE TABLE IF NOT EXISTS `posts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(128) NOT NULL,
  `body` TEXT NOT NULL,
  `author` VARCHAR(28) NOT NULL,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `published` ENUM('LIVE', 'DRAFT') NOT NULL DEFAULT 'DRAFT',
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_posts_users` FOREIGN KEY (`author`) REFERENCES `users`(`id`)
);
-- CREATE TEST ACCOUNTS
-- ROLES
INSERT INTO
  `user_role`(`role`)
VALUES('ADMIN');
INSERT INTO
  `user_role`(`role`)
VALUES('EMPLOYEE');
INSERT INTO
  `user_role`(`role`)
VALUES('CUSTOMER');
-- ADMIN
INSERT INTO
  `users` (
    `id`,
    `first_name`,
    `last_name`,
    `email`,
    `password`,
    `role_id`,
    `home`
  )
VALUES(
    "110011001100",
    "John",
    "Doe",
    "admin@cmshop.nomail",
    "$2y$10$pWz2yv91s5IeWGaH5kdFZ.l1.HK8E/TaMlxu..QY2rQcPOgixGFfS",
    1,
    "/storage/110011001100/"
  );
-- EMPLOYEE
INSERT INTO
  `users` (
    `id`,
    `first_name`,
    `last_name`,
    `email`,
    `password`,
    `role_id`,
    `home`
  )
VALUES(
    "220011001100",
    "Jane",
    "Doe",
    "employee@cmshop.nomail",
    "$2y$10$45d9IhaGeQO5rkDW3fkz6eYGFrrUrfOvPnxRIz80s41gd5ED0Ehxm",
    2,
    "/storage/220011001100/"
  );
-- CUSTOMER
INSERT INTO
  `users` (
    `id`,
    `first_name`,
    `last_name`,
    `email`,
    `password`,
    `role_id`,
    `home`
  )
VALUES(
    "770011001100",
    "Jim",
    "Doe",
    "customer@cmshop.nomail",
    "$2y$10$YwUikUgEslSkb4yV3OyDIeDbA2U8XlJESJr0qwKWf7UwcqGHavJWi",
    3,
    "/storage/770011001100/"
  );
-- CREATE SHOP TABLES
  CREATE TABLE IF NOT EXISTS `product_category` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `category` VARCHAR(36) NOT NULL,
    PRIMARY KEY (`id`)
  );
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(128) NOT NULL,
    `slug` VARCHAR(128) NOT NULL,
    `description` text NOT NULL,
    `price` INT NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,
    `img_url` VARCHAR(128) DEFAULT "/img/products/default.jpg",
    `quantity` INT UNSIGNED DEFAULT "0",
    `status` ENUM("LIVE", "DRAFT") DEFAULT "DRAFT",
    PRIMARY KEY (`id`),
    CONSTRAINT `FK_products_product_category` FOREIGN KEY (`category_id`) REFERENCES `product_category`(`id`)
  );
CREATE TABLE IF NOT EXISTS `cart` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` VARCHAR(28) NOT NULL,
    `product_id` INT UNSIGNED NOT NULL DEFAULT 0,
    `quantity` INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `product_id_user_id` (`product_id`, `user_id`),
    CONSTRAINT `FK_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE
  );
CREATE TABLE IF NOT EXISTS `delivery_address` (
    `id` INT(16) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` VARCHAR(28) NOT NULL,
    `city` TEXT NOT NULL,
    `street` TEXT NOT NULL,
    `street_number` VARCHAR(64) NOT NULL,
    `zip_code` VARCHAR(64) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_user_delivery_address` (`user_id`),
    CONSTRAINT `FK_user_delivery_address` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
  );
CREATE TABLE IF NOT EXISTS `orders` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `status` enum("new", "payed") NOT NULL DEFAULT "new",
    `user_id` VARCHAR(28) NOT NULL,
    `orders_id` VARCHAR(128) NOT NULL,
    `order_price` INT,
    `delivery_address_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY (`orders_id`),
    CONSTRAINT `FK_order_to_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `FK_order_delivery_address` FOREIGN KEY (`delivery_address_id`) REFERENCES `delivery_address` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
  );
CREATE TABLE IF NOT EXISTS `order_products` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id` VARCHAR(128) NOT NULL,
    `product_id` INT UNSIGNED NOT NULL,
    `quantity` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `FK_order_products_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
    CONSTRAINT `FK_order_products_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`orders_id`) ON DELETE CASCADE ON UPDATE CASCADE
  );
-- ARCHIVE FOR DELETED USERS
  CREATE TABLE IF NOT EXISTS `users_archive` (
    `id` VARCHAR(28) NOT NULL,
    `first_name` VARCHAR(24) NOT NULL,
    `last_name` VARCHAR(36) NOT NULL,
    `email` VARCHAR(64) NOT NULL,
    `role_id` INT UNSIGNED NOT NULL,
    `invoice_path` VARCHAR(255),
    UNIQUE KEY `email` (`email`),
    PRIMARY KEY (`id`),
    CONSTRAINT `FK_users_archive_user_role` FOREIGN KEY (`role_id`) REFERENCES `user_role`(`id`)
  );
CREATE TABLE IF NOT EXISTS `contact_status` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `status` VARCHAR(24) NOT NULL,
    PRIMARY KEY (`id`)
  );
-- CONTACT TABLE
  CREATE TABLE IF NOT EXISTS `contact` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(128) NOT NULL,
    `title` VARCHAR(64) NOT NULL,
    `message` TEXT NOT NULL,
    `status_id` INT UNSIGNED NOT NULL,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `FK_contact_status_contact` FOREIGN KEY (`status_id`) REFERENCES `contact_status` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
  );
-- ADD CATEGORIES
INSERT INTO
  `product_category` (`category`)
VALUES("Kategorie 1");
INSERT INTO
  `product_category` (`category`)
VALUES("Kategorie 2");
INSERT INTO
  `product_category` (`category`)
VALUES("Kategorie 3");
INSERT INTO
  `product_category` (`category`)
VALUES("Kategorie 4");
-- ADD SOME PRODUCTS
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 1",
    "testproduct one",
    1499,
    "product-1",
    1,
    10,
    "/img/products/default.jpg",
    "LIVE"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 2",
    "testproduct two",
    1499,
    "product-2",
    2,
    10,
    "/img/products/default.jpg",
    "LIVE"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 3",
    "testproduct three",
    1499,
    "product-3",
    3,
    10,
    "/img/products/default.jpg",
    "LIVE"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 4",
    "testproduct four",
    1999,
    "product-4",
    4,
    10,
    "/img/products/default.jpg",
    "LIVE"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 5",
    "testproduct five",
    1199,
    "product-5",
    1,
    10,
    "/img/products/default.jpg",
    "DRAFT"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 6",
    "testproduct six",
    1999,
    "product-6",
    2,
    10,
    "/img/products/default.jpg",
    "DRAFT"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 7",
    "testproduct seven",
    2199,
    "product-7",
    3,
    10,
    "/img/products/default.jpg",
    "LIVE"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 8",
    "testproduct eight",
    2199,
    "product-8",
    4,
    10,
    "/img/products/default.jpg",
    "LIVE"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 9",
    "testproduct nine",
    1499,
    "product-9",
    1,
    10,
    "/img/products/default.jpg",
    "LIVE"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 10",
    "testproduct ten",
    1199,
    "product-10",
    2,
    10,
    "/img/products/default.jpg",
    "LIVE"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 11",
    "testproduct eleven",
    1799,
    "product-11",
    3,
    10,
    "/img/products/default.jpg",
    "DRAFT"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 12",
    "testproduct twelve",
    2199,
    "product-12",
    4,
    10,
    "/img/products/default.jpg",
    "LIVE"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 13",
    "testproduct thirteen",
    1499,
    "product-13",
    1,
    10,
    "/img/products/default.jpg",
    "LIVE"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 14",
    "testproduct fourteen",
    1199,
    "product-14",
    2,
    10,
    "/img/products/default.jpg",
    "LIVE"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 15",
    "testproduct fivteen",
    1999,
    "product-15",
    3,
    10,
    "/img/products/default.jpg",
    "DRAFT"
  );
INSERT INTO
  `products` (
    `title`,
    `description`,
    `price`,
    `slug`,
    `category_id`,
    `quantity`,
    `img_url`,
    `status`
  )
VALUES(
    "Product 16",
    "testproduct sixteen",
    2199,
    "product-16",
    4,
    10,
    "/img/products/default.jpg",
    "LIVE"
  );
-- ADD CONTACT STATUS
INSERT INTO
  `contact_status` (`status`)
VALUES('NEU');
INSERT INTO
  `contact_status` (`status`)
VALUES('GELESEN');
INSERT INTO
  `contact_status` (`status`)
VALUES('BEANTWORTET');
-- ADD ARCHIVED USERS
INSERT INTO
  `users_archive` (
    `id`,
    `first_name`,
    `last_name`,
    `email`,
    `role_id`,
    `invoice_path`
  )
VALUES
  (
    "110022003300",
    "Max",
    "Muster",
    "max@mustermann.nomail",
    3,
    "/storage/770011002200/"
  );
INSERT INTO
  `users_archive` (
    `id`,
    `first_name`,
    `last_name`,
    `email`,
    `role_id`,
    `invoice_path`
  )
VALUES
  (
    "110033004400",
    "Stefan",
    "Klein",
    "stefan@klein.nomail",
    2,
    ""
  );
INSERT INTO
  `users_archive` (
    `id`,
    `first_name`,
    `last_name`,
    `email`,
    `role_id`,
    `invoice_path`
  )
VALUES
  (
    "220011003300",
    "Sabine",
    "Lauf",
    "sabine@lauf.nomail",
    1,
    ""
  );
-- CREATE SAMPLE POSTS
INSERT INTO
  `posts` (
    `title`,
    `body`,
    `author`,
    `created`,
    `published`
  )
VALUES(
    'Post 1',
    'Damit Ihr indes erkennt, woher dieser ganze Irrthum gekommen ist, und weshalb man die Lust anklagt und den Schmerz lobet, 
    so will ich Euch Alles eröffnen und auseinander setzen, was jener Begründer der Wahrheit und gleichsam Baumeister 
    des glücklichen Lebens selbst darüber gesagt hat. Niemand, sagt er, verschmähe, oder hasse, oder fliehe die Lust als solche, 
    sondern weil grosse Schmerzen ihr folgen, wenn man nicht mit Vernunft ihr nachzugehen verstehe. 
    Ebenso werde der Schmerz als solcher von Niemand geliebt, gesucht und verlangt, sondern weil mitunter solche Zeiten eintreten, 
    dass man mittelst Arbeiten und Schmerzen eine grosse Lust sich zu verschaften suchen müsse. 
    Um hier gleich bei dem Einfachsten stehen zu bleiben, so würde Niemand von uns anstrengende körperliche Übungen vornehmen, 
    wenn er nicht einen Vortheil davon erwartete. Wer dürfte aber wohl Den tadeln, der nach einer Lust verlangt, 
    welcher keine Unannehmlichkeit folgt, oder der einem Schmerze ausweicht, aus dem keine Lust hervorgeht?<br /><br />
    Dagegen tadelt und hasst man mit Recht Den, welcher sich durch die Lockungen einer gegenwärtigen Lust erweichen und verführen lässt, 
    ohne in seiner blinden Begierde zu sehen, welche Schmerzen und Unannehmlichkeiten seiner deshalb warten. 
    Gleiche Schuld treffe Die, welche aus geistiger Schwäche, d.h. um der Arbeit und dem Schmerze zu entgehen, 
    ihre Pflichten verabsäumen. Man kann hier leicht und schnell den richtigen Unterschied treffen; zu einer ruhigen Zeit, 
    wo die Wahl der Entscheidung völlig frei ist und nichts hindert, das zu thun, was den Meisten gefällt, hat man jede Lust zu erfassen 
    und jeden Schmerz abzuhalten; aber zu Zeiten trifft es sich in Folge von schuldigen Pflichten oder von sachlicher Noth, 
    dass man die Lust zurückweisen und Beschwerden nicht von sich weisen darf. Deshalb trifft der Weise dann eine Auswahl, 
    damit er durch Zurückweisung einer Lust dafür eine grössere erlange oder durch Übernahme gewisser Schmerzen sich grössere erspare.',
    '110011001100',
    '2021-01-23 02:05:19',
    'LIVE'
  );
-- WAITFOR DELAY '00:00:02';
INSERT INTO
  `posts` (
    `title`,
    `body`,
    `author`,
    `created`,
    `published`
  )
VALUES(
    'Post 2',
    'Damit Ihr indes erkennt, woher dieser ganze Irrthum gekommen ist, und weshalb man die Lust anklagt und den Schmerz lobet, 
    so will ich Euch Alles eröffnen und auseinander setzen, was jener Begründer der Wahrheit und gleichsam Baumeister 
    des glücklichen Lebens selbst darüber gesagt hat. Niemand, sagt er, verschmähe, oder hasse, oder fliehe die Lust als solche, 
    sondern weil grosse Schmerzen ihr folgen, wenn man nicht mit Vernunft ihr nachzugehen verstehe. 
    Ebenso werde der Schmerz als solcher von Niemand geliebt, gesucht und verlangt, sondern weil mitunter solche Zeiten eintreten, 
    dass man mittelst Arbeiten und Schmerzen eine grosse Lust sich zu verschaften suchen müsse. 
    Um hier gleich bei dem Einfachsten stehen zu bleiben, so würde Niemand von uns anstrengende körperliche Übungen vornehmen, 
    wenn er nicht einen Vortheil davon erwartete. Wer dürfte aber wohl Den tadeln, der nach einer Lust verlangt, 
    welcher keine Unannehmlichkeit folgt, oder der einem Schmerze ausweicht, aus dem keine Lust hervorgeht?<br /><br />
    Dagegen tadelt und hasst man mit Recht Den, welcher sich durch die Lockungen einer gegenwärtigen Lust erweichen und verführen lässt, 
    ohne in seiner blinden Begierde zu sehen, welche Schmerzen und Unannehmlichkeiten seiner deshalb warten. 
    Gleiche Schuld treffe Die, welche aus geistiger Schwäche, d.h. um der Arbeit und dem Schmerze zu entgehen, 
    ihre Pflichten verabsäumen. Man kann hier leicht und schnell den richtigen Unterschied treffen; zu einer ruhigen Zeit, 
    wo die Wahl der Entscheidung völlig frei ist und nichts hindert, das zu thun, was den Meisten gefällt, hat man jede Lust zu erfassen 
    und jeden Schmerz abzuhalten; aber zu Zeiten trifft es sich in Folge von schuldigen Pflichten oder von sachlicher Noth, 
    dass man die Lust zurückweisen und Beschwerden nicht von sich weisen darf. Deshalb trifft der Weise dann eine Auswahl, 
    damit er durch Zurückweisung einer Lust dafür eine grössere erlange oder durch Übernahme gewisser Schmerzen sich grössere erspare.',
    '220011001100',
    '2021-05-11 02:16:37',
    'LIVE'
  );
-- WAITFOR DELAY '00:00:02'
INSERT INTO
  `posts` (
    `title`,
    `body`,
    `author`,
    `created`,
    `published`
  )
VALUES(
    'Post 3',
    'Damit Ihr indes erkennt, woher dieser ganze Irrthum gekommen ist, und weshalb man die Lust anklagt und den Schmerz lobet, 
    so will ich Euch Alles eröffnen und auseinander setzen, was jener Begründer der Wahrheit und gleichsam Baumeister 
    des glücklichen Lebens selbst darüber gesagt hat. Niemand, sagt er, verschmähe, oder hasse, oder fliehe die Lust als solche, 
    sondern weil grosse Schmerzen ihr folgen, wenn man nicht mit Vernunft ihr nachzugehen verstehe. 
    Ebenso werde der Schmerz als solcher von Niemand geliebt, gesucht und verlangt, sondern weil mitunter solche Zeiten eintreten, 
    dass man mittelst Arbeiten und Schmerzen eine grosse Lust sich zu verschaften suchen müsse. 
    Um hier gleich bei dem Einfachsten stehen zu bleiben, so würde Niemand von uns anstrengende körperliche Übungen vornehmen, 
    wenn er nicht einen Vortheil davon erwartete. Wer dürfte aber wohl Den tadeln, der nach einer Lust verlangt, 
    welcher keine Unannehmlichkeit folgt, oder der einem Schmerze ausweicht, aus dem keine Lust hervorgeht?<br /><br />
    Dagegen tadelt und hasst man mit Recht Den, welcher sich durch die Lockungen einer gegenwärtigen Lust erweichen und verführen lässt, 
    ohne in seiner blinden Begierde zu sehen, welche Schmerzen und Unannehmlichkeiten seiner deshalb warten. 
    Gleiche Schuld treffe Die, welche aus geistiger Schwäche, d.h. um der Arbeit und dem Schmerze zu entgehen, 
    ihre Pflichten verabsäumen. Man kann hier leicht und schnell den richtigen Unterschied treffen; zu einer ruhigen Zeit, 
    wo die Wahl der Entscheidung völlig frei ist und nichts hindert, das zu thun, was den Meisten gefällt, hat man jede Lust zu erfassen 
    und jeden Schmerz abzuhalten; aber zu Zeiten trifft es sich in Folge von schuldigen Pflichten oder von sachlicher Noth, 
    dass man die Lust zurückweisen und Beschwerden nicht von sich weisen darf. Deshalb trifft der Weise dann eine Auswahl, 
    damit er durch Zurückweisung einer Lust dafür eine grössere erlange oder durch Übernahme gewisser Schmerzen sich grössere erspare.',
    '220011001100',
    '2021-011-10 15:32:01',
    'LIVE'
  );
-- WAITFOR DELAY '00:00:02';
INSERT INTO
  `posts` (
    `title`,
    `body`,
    `author`,
    `created`,
    `published`
  )
VALUES(
    'Post 4',
    'Damit Ihr indes erkennt, woher dieser ganze Irrthum gekommen ist, und weshalb man die Lust anklagt und den Schmerz lobet, 
    so will ich Euch Alles eröffnen und auseinander setzen, was jener Begründer der Wahrheit und gleichsam Baumeister 
    des glücklichen Lebens selbst darüber gesagt hat. Niemand, sagt er, verschmähe, oder hasse, oder fliehe die Lust als solche, 
    sondern weil grosse Schmerzen ihr folgen, wenn man nicht mit Vernunft ihr nachzugehen verstehe. 
    Ebenso werde der Schmerz als solcher von Niemand geliebt, gesucht und verlangt, sondern weil mitunter solche Zeiten eintreten, 
    dass man mittelst Arbeiten und Schmerzen eine grosse Lust sich zu verschaften suchen müsse. 
    Um hier gleich bei dem Einfachsten stehen zu bleiben, so würde Niemand von uns anstrengende körperliche Übungen vornehmen, 
    wenn er nicht einen Vortheil davon erwartete. Wer dürfte aber wohl Den tadeln, der nach einer Lust verlangt, 
    welcher keine Unannehmlichkeit folgt, oder der einem Schmerze ausweicht, aus dem keine Lust hervorgeht?<br /><br />
    Dagegen tadelt und hasst man mit Recht Den, welcher sich durch die Lockungen einer gegenwärtigen Lust erweichen und verführen lässt, 
    ohne in seiner blinden Begierde zu sehen, welche Schmerzen und Unannehmlichkeiten seiner deshalb warten. 
    Gleiche Schuld treffe Die, welche aus geistiger Schwäche, d.h. um der Arbeit und dem Schmerze zu entgehen, 
    ihre Pflichten verabsäumen. Man kann hier leicht und schnell den richtigen Unterschied treffen; zu einer ruhigen Zeit, 
    wo die Wahl der Entscheidung völlig frei ist und nichts hindert, das zu thun, was den Meisten gefällt, hat man jede Lust zu erfassen 
    und jeden Schmerz abzuhalten; aber zu Zeiten trifft es sich in Folge von schuldigen Pflichten oder von sachlicher Noth, 
    dass man die Lust zurückweisen und Beschwerden nicht von sich weisen darf. Deshalb trifft der Weise dann eine Auswahl, 
    damit er durch Zurückweisung einer Lust dafür eine grössere erlange oder durch Übernahme gewisser Schmerzen sich grössere erspare.',
    '110011001100',
    '2022-01-16 09:12:53',
    'LIVE'
  );
-- WAITFOR DELAY '00:00:02';
INSERT INTO
  `posts` (
    `title`,
    `body`,
    `author`,
    `created`,
    `published`
  )
VALUES(
    'Post 5',
    'Damit Ihr indes erkennt, woher dieser ganze Irrthum gekommen ist, und weshalb man die Lust anklagt und den Schmerz lobet, 
    so will ich Euch Alles eröffnen und auseinander setzen, was jener Begründer der Wahrheit und gleichsam Baumeister 
    des glücklichen Lebens selbst darüber gesagt hat. Niemand, sagt er, verschmähe, oder hasse, oder fliehe die Lust als solche, 
    sondern weil grosse Schmerzen ihr folgen, wenn man nicht mit Vernunft ihr nachzugehen verstehe. 
    Ebenso werde der Schmerz als solcher von Niemand geliebt, gesucht und verlangt, sondern weil mitunter solche Zeiten eintreten, 
    dass man mittelst Arbeiten und Schmerzen eine grosse Lust sich zu verschaften suchen müsse. 
    Um hier gleich bei dem Einfachsten stehen zu bleiben, so würde Niemand von uns anstrengende körperliche Übungen vornehmen, 
    wenn er nicht einen Vortheil davon erwartete. Wer dürfte aber wohl Den tadeln, der nach einer Lust verlangt, 
    welcher keine Unannehmlichkeit folgt, oder der einem Schmerze ausweicht, aus dem keine Lust hervorgeht?<br /><br />
    Dagegen tadelt und hasst man mit Recht Den, welcher sich durch die Lockungen einer gegenwärtigen Lust erweichen und verführen lässt, 
    ohne in seiner blinden Begierde zu sehen, welche Schmerzen und Unannehmlichkeiten seiner deshalb warten. 
    Gleiche Schuld treffe Die, welche aus geistiger Schwäche, d.h. um der Arbeit und dem Schmerze zu entgehen, 
    ihre Pflichten verabsäumen. Man kann hier leicht und schnell den richtigen Unterschied treffen; zu einer ruhigen Zeit, 
    wo die Wahl der Entscheidung völlig frei ist und nichts hindert, das zu thun, was den Meisten gefällt, hat man jede Lust zu erfassen 
    und jeden Schmerz abzuhalten; aber zu Zeiten trifft es sich in Folge von schuldigen Pflichten oder von sachlicher Noth, 
    dass man die Lust zurückweisen und Beschwerden nicht von sich weisen darf. Deshalb trifft der Weise dann eine Auswahl, 
    damit er durch Zurückweisung einer Lust dafür eine grössere erlange oder durch Übernahme gewisser Schmerzen sich grössere erspare.',
    '220011002200',
    '2022-02-21 09:35:42',
    'DRAFT'
  );
INSERT INTO
  `posts` (
    `title`,
    `body`,
    `author`,
    `created`,
    `published`
  )
VALUES(
    'Post 6',
    'Damit Ihr indes erkennt, woher dieser ganze Irrthum gekommen ist, und weshalb man die Lust anklagt und den Schmerz lobet, 
    so will ich Euch Alles eröffnen und auseinander setzen, was jener Begründer der Wahrheit und gleichsam Baumeister 
    des glücklichen Lebens selbst darüber gesagt hat. Niemand, sagt er, verschmähe, oder hasse, oder fliehe die Lust als solche, 
    sondern weil grosse Schmerzen ihr folgen, wenn man nicht mit Vernunft ihr nachzugehen verstehe. 
    Ebenso werde der Schmerz als solcher von Niemand geliebt, gesucht und verlangt, sondern weil mitunter solche Zeiten eintreten, 
    dass man mittelst Arbeiten und Schmerzen eine grosse Lust sich zu verschaften suchen müsse. 
    Um hier gleich bei dem Einfachsten stehen zu bleiben, so würde Niemand von uns anstrengende körperliche Übungen vornehmen, 
    wenn er nicht einen Vortheil davon erwartete. Wer dürfte aber wohl Den tadeln, der nach einer Lust verlangt, 
    welcher keine Unannehmlichkeit folgt, oder der einem Schmerze ausweicht, aus dem keine Lust hervorgeht?<br /><br />
    Dagegen tadelt und hasst man mit Recht Den, welcher sich durch die Lockungen einer gegenwärtigen Lust erweichen und verführen lässt, 
    ohne in seiner blinden Begierde zu sehen, welche Schmerzen und Unannehmlichkeiten seiner deshalb warten. 
    Gleiche Schuld treffe Die, welche aus geistiger Schwäche, d.h. um der Arbeit und dem Schmerze zu entgehen, 
    ihre Pflichten verabsäumen. Man kann hier leicht und schnell den richtigen Unterschied treffen; zu einer ruhigen Zeit, 
    wo die Wahl der Entscheidung völlig frei ist und nichts hindert, das zu thun, was den Meisten gefällt, hat man jede Lust zu erfassen 
    und jeden Schmerz abzuhalten; aber zu Zeiten trifft es sich in Folge von schuldigen Pflichten oder von sachlicher Noth, 
    dass man die Lust zurückweisen und Beschwerden nicht von sich weisen darf. Deshalb trifft der Weise dann eine Auswahl, 
    damit er durch Zurückweisung einer Lust dafür eine grössere erlange oder durch Übernahme gewisser Schmerzen sich grössere erspare.',
    '110011002200',
    '2022-02-24 09:30:42',
    'DRAFT'
  );
INSERT INTO
  `posts` (
    `title`,
    `body`,
    `author`,
    `created`,
    `published`
  )
VALUES(
    'Post 7',
    'Damit Ihr indes erkennt, woher dieser ganze Irrthum gekommen ist, und weshalb man die Lust anklagt und den Schmerz lobet, 
    so will ich Euch Alles eröffnen und auseinander setzen, was jener Begründer der Wahrheit und gleichsam Baumeister 
    des glücklichen Lebens selbst darüber gesagt hat. Niemand, sagt er, verschmähe, oder hasse, oder fliehe die Lust als solche, 
    sondern weil grosse Schmerzen ihr folgen, wenn man nicht mit Vernunft ihr nachzugehen verstehe. 
    Ebenso werde der Schmerz als solcher von Niemand geliebt, gesucht und verlangt, sondern weil mitunter solche Zeiten eintreten, 
    dass man mittelst Arbeiten und Schmerzen eine grosse Lust sich zu verschaften suchen müsse. 
    Um hier gleich bei dem Einfachsten stehen zu bleiben, so würde Niemand von uns anstrengende körperliche Übungen vornehmen, 
    wenn er nicht einen Vortheil davon erwartete. Wer dürfte aber wohl Den tadeln, der nach einer Lust verlangt, 
    welcher keine Unannehmlichkeit folgt, oder der einem Schmerze ausweicht, aus dem keine Lust hervorgeht?<br /><br />
    Dagegen tadelt und hasst man mit Recht Den, welcher sich durch die Lockungen einer gegenwärtigen Lust erweichen und verführen lässt, 
    ohne in seiner blinden Begierde zu sehen, welche Schmerzen und Unannehmlichkeiten seiner deshalb warten. 
    Gleiche Schuld treffe Die, welche aus geistiger Schwäche, d.h. um der Arbeit und dem Schmerze zu entgehen, 
    ihre Pflichten verabsäumen. Man kann hier leicht und schnell den richtigen Unterschied treffen; zu einer ruhigen Zeit, 
    wo die Wahl der Entscheidung völlig frei ist und nichts hindert, das zu thun, was den Meisten gefällt, hat man jede Lust zu erfassen 
    und jeden Schmerz abzuhalten; aber zu Zeiten trifft es sich in Folge von schuldigen Pflichten oder von sachlicher Noth, 
    dass man die Lust zurückweisen und Beschwerden nicht von sich weisen darf. Deshalb trifft der Weise dann eine Auswahl, 
    damit er durch Zurückweisung einer Lust dafür eine grössere erlange oder durch Übernahme gewisser Schmerzen sich grössere erspare.',
    '220011002200',
    '2022-02-27 11:23:02',
    'DRAFT'
  );
INSERT INTO
  `contact` (
    `email`,
    `title`,
    `message`,
    `status_id`,
    `created`
  )
VALUES(
    "j.kuli@keinemail.com",
    "Spezialstifte",
    "Guten Tag,<br><br>fertigen sie auch stifte nach Kundenwunsch an?<br>Wenn ja, wieviel würde das kosten?",
    1,
    "2022-02-28 09:06:16"
  );
INSERT INTO
  `contact` (
    `email`,
    `title`,
    `message`,
    `status_id`,
    `created`
  )
VALUES(
    "s.kugelstift@keinemail.com",
    "Grünes Monster",
    "bekommen sie wieder den Kugelschreiber Grünes Monster, ich hätte den so gerne.",
    2,
    "2022-03-08 10:15:03"
  );
INSERT INTO
  `contact` (
    `email`,
    `title`,
    `message`,
    `status_id`,
    `created`
  )
VALUES(
    "a.verfilzt@keinemail.com",
    "Nich nur Stifte",
    "ich würde mich freuen wenn sie zu den Stiften auch Notizbücher anbieten würden",
    2,
    "2022-03-15 08:31:48"
  );
INSERT INTO
  `contact` (
    `email`,
    `title`,
    `message`,
    `status_id`,
    `created`
  )
VALUES(
    "k.gutemiene@keinemail.com",
    "Mehr Farben",
    "guten Tag,<br><br>wäre es möglich ihr sortiment an Stiften bezüglich der Schreibfarben zu erweitern?",
    3,
    "2022-03-19 15:47:42"
  );
INSERT INTO
  `contact` (
    `email`,
    `title`,
    `message`,
    `status_id`,
    `created`
  )
VALUES(
    "f.stanglwirt@keinemail.com",
    "Personalisierung",
    "können sie auch Gravuren oder Aufdrucke an den Stiften vornehmen?",
    1,
    "2022-03-25 08:57:21"
  );
INSERT INTO
  `contact` (
    `email`,
    `title`,
    `message`,
    `status_id`,
    `created`
  )
VALUES(
    "o.senfmaier@keinemail.com",
    "Kugelschreiber",
    "hallo,<br><br>ich würde gerne erfahren ob sie in zukunft auch Kugelschreiber mit roter und grüner Farbe verkaufen",
    2,
    "2022-04-06 09:22:45"
  );
INSERT INTO
  `contact` (
    `email`,
    `title`,
    `message`,
    `status_id`,
    `created`
  )
VALUES(
    "b.hasuleitner@hauslmail.at",
    "Notizbücher",
    "bitte nehmen sie notizbücher in ihr sortiment auf",
    3,
    "2022-04-12 15:37:44"
  );