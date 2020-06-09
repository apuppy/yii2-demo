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

-- category
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '栏目名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='栏目表';

-- custom gii demo test
CREATE TABLE `gii_demo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- error log table
create table error_log(
    id int(11) primary key auto_increment,
    module varchar(20) not null default '' comment 'application module',
    level varchar(10) not null default '' comment 'error or exception level',
    code int(11) unsigned not null default 0 comment 'error code',
    message varchar(300) not null default '' comment 'error message',
    file varchar(100) not null default '' comment 'related code file',
    trace text comment 'trace',
    created_date date comment 'created date',
    created_at datetime not null default current_timestamp
) engine=InnoDB default charset = utf8mb4 comment '错误日志表';