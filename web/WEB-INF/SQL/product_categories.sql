CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0',
  `cate_name` varchar(250) DEFAULT NULL,
  `invalid` tinyint(4) DEFAULT '0',
  `remark` varchar(250) DEFAULT NULL,
  `cate_code` varchar(200) DEFAULT NULL,
  `sort_no` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
