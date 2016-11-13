DROP TABLE IF EXISTS `timeline`;
DROP TABLE IF EXISTS `user`;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
    `user_id` char(32) NOT NULL PRIMARY KEY,
    `head` varchar(100) NOT NULL COMMENT '用户头像路径',
    `gender` char(1) NOT NULL COMMENT '0 -> male, 1 -> female, 2 -> unknown',
    `password` varchar(60) NOT NULL,
    `username` varchar(30) NOT NULL COMMENT '用户昵称',
    `time` int(11) NOT NULL COMMENT '用户注册时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `timeline`;
CREATE TABLE `timeline` (
    `timeline_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` char(32) NOT NULL COMMENT '发布人',
    `image` char(50) NOT NULL COMMENT '发布的图片',
    `describe` char(200) NOT NULL COMMENT '说的话',
    `num_likes` int(11) NOT NULL COMMENT '喜欢的人数',
    `time` int(11) NOT NULL COMMENT '发布时间',
    FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
