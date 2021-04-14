SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8mb4;

CREATE TABLE `yo_categories` (
  `id` int(5) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `yo_cities` (
  `id` int(5) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `yo_product` (
  `id` int(10) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(7) DEFAULT NULL,
  `place_date` date DEFAULT NULL,
  `city_id` int(5) DEFAULT NULL,
  `category_id` int(5) DEFAULT NULL,
  `type_id` int(5) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `yo_types` (
  `id` int(5) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `yo_users` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `reg_date` date DEFAULT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `yo_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`name`);

ALTER TABLE `yo_cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `UNIQUE` (`name`);

ALTER TABLE `yo_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `type_id` (`type_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `yo_types`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `yo_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`email`);

ALTER TABLE `yo_categories`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

ALTER TABLE `yo_cities`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

ALTER TABLE `yo_product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `yo_types`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

ALTER TABLE `yo_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `yo_product`
  ADD CONSTRAINT `yo_product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `yo_users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `yo_product_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `yo_types` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `yo_product_ibfk_3` FOREIGN KEY (`city_id`) REFERENCES `yo_cities` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `yo_product_ibfk_4` FOREIGN KEY (`category_id`) REFERENCES `yo_categories` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;

SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT;
SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS;
SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION;
