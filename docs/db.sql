create database yii2demo;

CREATE TABLE user (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(16) NOT NULL DEFAULT '' COMMENT '姓名',
  sex TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '性别 0:未知 1：男 2：女',
  age TINYINT(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '年龄',
  birthday DATE  COMMENT '生日',
  tel CHAR(15) NOT NULL DEFAULT '' COMMENT '电话号码',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COMMENT '用户表';

-- backend user
CREATE TABLE `user_backend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;