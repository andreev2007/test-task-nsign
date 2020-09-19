CREATE TABLE `food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


INSERT INTO `food` VALUES (1,'Pizza',10,1,1,1600434763,1600522397),(2,'Soup',10,1,1,1600434987,1600522388),(3,'Burger',10,1,1,1600437190,1600522414),(4,'Tea',10,1,1,1600516121,1600522429);

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



INSERT INTO `ingredients` VALUES (1,'Broccoli',10,1,1,1600432289,1600522446),(2,'Meat',10,1,1,1600432308,1600522457),(3,'Tomato',10,1,1,1600432315,1600522525),(4,'Onion',10,1,1,1600432322,1600522478),(5,'Carrot',10,1,1,1600432333,1600522489),(6,'Potato',10,1,1,1600432344,1600522500),(7,'Cucumber',10,1,1,1600432360,1600522516),(8,'Сахар',10,1,1,1600515869,1600522535),(11,'Жасмин',10,1,1,1600516067,1600522555);


CREATE TABLE `ingredients_to_food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `food_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-ingredients_to_food-food_id` (`food_id`),
  KEY `idx-ingredients_to_food-ingredient_id` (`ingredient_id`),
  CONSTRAINT `fk-ingredients_to_food-food_id` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-ingredients_to_food-ingredient_id` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



INSERT INTO `ingredients_to_food` VALUES (2,3,2,10,1,1,1600437190,1600437190),(3,3,4,10,1,1,1600437190,1600437190),(5,3,7,10,1,1,1600437190,1600437190),(6,3,3,10,1,1,1600437190,1600437190),(8,1,2,10,1,1,1600515613,1600515613),(9,1,4,10,1,1,1600515613,1600515613),(10,1,3,10,1,1,1600515613,1600515613),(11,2,1,10,1,1,1600515691,1600515691),(12,2,5,10,1,1,1600515691,1600515691),(13,2,6,10,1,1,1600515691,1600515691),(14,4,8,10,1,1,1600516121,1600516121),(15,4,11,10,1,1,1600516121,1600516121);


CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `migration` VALUES ('m000000_000000_base',1600430491),('m130524_201442_init',1600430493),('m130524_201443_ingredients',1600430493),('m130524_201444_food',1600430493),('m130524_201445_ingredients_to_food',1600430493),('m190124_110200_add_verification_token_column_to_user_table',1600430493);


CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_general_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `verification_token` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

