-- for SqlLogTarget
CREATE TABLE `sql_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app` char(32) NOT NULL DEFAULT '',
  `request_uri` varchar(500) DEFAULT NULL,
  `trace_file` varchar(2000) DEFAULT NULL,
  `trace_sql` varchar(10000) DEFAULT NULL,
  `extra` text,
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;