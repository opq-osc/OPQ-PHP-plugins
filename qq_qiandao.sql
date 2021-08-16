SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for qq_qiandao
-- ----------------------------
DROP TABLE IF EXISTS `qq_qiandao`;
CREATE TABLE `qq_qiandao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `qq` bigint(20) DEFAULT NULL,
  `success` int(11) DEFAULT NULL,
  `msuccess` int(11) DEFAULT NULL,
  `continus` int(11) DEFAULT NULL,
  `gmp` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `zantime` datetime DEFAULT NULL,
  `img` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `qq` (`qq`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8 COMMENT='世外天堂QQ群签到表';
