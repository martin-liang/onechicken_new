ALTER TABLE `onechicken`.`user_addition` CHANGE COLUMN `recommand_eggs` `recommand_eggs` decimal(11,1) DEFAULT 0 COMMENT '昨天从推荐用户处获取的蛋的数量', CHANGE COLUMN `recommand_total_eggs` `recommand_total_eggs` decimal(11,1) DEFAULT NULL COMMENT '用户从推荐用户处获取蛋的总数量', CHANGE COLUMN `total_eggs` `total_eggs` decimal(11,1) DEFAULT NULL COMMENT '用户总的蛋数量', ADD COLUMN `yestarday_eggs` int AFTER `total_eggs`;
ALTER TABLE `onechicken`.`user_addition` DROP COLUMN `today_eggs`, DROP COLUMN `yestarday_eggs`;
CREATE TABLE `eggs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `eggs` int(11) DEFAULT NULL,
  `chicken_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `onechicken`.`user_addition` CHANGE COLUMN `eggs` `eggs` int(11) DEFAULT 0 COMMENT '蛋的数量', CHANGE COLUMN `chickens` `chickens` int(11) DEFAULT 0 COMMENT '鸡的数量', CHANGE COLUMN `soils` `soils` int(11) DEFAULT 0 COMMENT '土地的数量', CHANGE COLUMN `recommand_total_eggs` `recommand_total_eggs` decimal(11,1) DEFAULT 0 COMMENT '用户从推荐用户处获取蛋的总数量', CHANGE COLUMN `total_eggs` `total_eggs` decimal(11,1) DEFAULT 0 COMMENT '用户总的蛋数量';

ALTER TABLE `onechicken`.`soil` CHANGE COLUMN `enabled` `enabled` tinyint(4) DEFAULT 0 COMMENT '是否启用';