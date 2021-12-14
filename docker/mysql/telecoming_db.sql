/*

 Source Server         : LOCAL
 Source Server Type    : MySQL
 Source Server Version : 80027
 Source Host           : 127.0.0.1:3306
 Source Schema         : telecoming_db

 Target Server Type    : MySQL
 Target Server Version : 80027
 File Encoding         : 65001

*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for payment
-- ----------------------------
DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `subscriber_id` bigint NOT NULL,
  `transaction_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `transaction_date` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `result` enum('OK','KO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriber_id` (`subscriber_id`),
  CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`subscriber_id`) REFERENCES `subscriber` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Table structure for subscriber
-- ----------------------------
DROP TABLE IF EXISTS `subscriber`;
CREATE TABLE `subscriber` (
  `id` bigint NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` enum('ONLINE','DELETED') NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `subscribed_at` date NOT NULL,
  `unsubscribed_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

SET FOREIGN_KEY_CHECKS = 1;
