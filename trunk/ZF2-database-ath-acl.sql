CREATE TABLE `role` (
  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(45) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8



CREATE TABLE `resource` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `resource_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(45) NOT NULL,
  `resource_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1

CREATE TABLE `role_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


/* Add Roles */

INSERT INTO `restmagazin`.`role` (`role_name`, `status`) VALUES ('Role1', 'Active');
INSERT INTO `restmagazin`.`role` (`role_name`, `status`) VALUES ('Role2', 'Active');
INSERT INTO `restmagazin`.`role` (`role_name`, `status`) VALUES ('Role3', 'Active');

/* Add Rresorces */

INSERT INTO `restmagazin`.`resource` (`resource_name`) VALUES ('Application\\Controller\\Index');
INSERT INTO `restmagazin`.`resource` (`resource_name`) VALUES ('ZF2AuthAcl\\Controller\\Index');

/* Add Users */
INSERT INTO `restmagazin`.`user` (`email`, `password`, `status`) VALUES ('example.1@example.com', '$2a$14$Fs0PKeQnrv4J.yJ6QRmhZ.vv6mEs20STuYcmjyUQVXG0dY0CJOv.a', 'Y');
INSERT INTO `restmagazin`.`user` (`email`, `password`, `status`) VALUES ('example.2@example.com', '$2a$14$Fs0PKeQnrv4J.yJ6QRmhZ.vv6mEs20STuYcmjyUQVXG0dY0CJOv.a', 'Y');
INSERT INTO `restmagazin`.`user` (`email`, `password`, `status`) VALUES ('example.3@example.com', '$2a$14$Fs0PKeQnrv4J.yJ6QRmhZ.vv6mEs20STuYcmjyUQVXG0dY0CJOv.a', 'Y');

/* Add User Roles */
INSERT INTO `restmagazin`.`user_role` (`user_id`, `role_id`) VALUES (1, 1);
INSERT INTO `restmagazin`.`user_role` (`user_id`, `role_id`) VALUES (2, 2);
INSERT INTO `restmagazin`.`user_role` (`user_id`, `role_id`) VALUES (3, 3);

/* Add Permissions */
INSERT INTO `restmagazin`.`permission` (`permission_name`, `resource_id`) VALUES ('index', 1);
INSERT INTO `restmagazin`.`permission` (`permission_name`, `resource_id`) VALUES ('index', 2);
INSERT INTO `restmagazin`.`permission` (`permission_name`, `resource_id`) VALUES ('show', 1);
INSERT INTO `restmagazin`.`permission` (`permission_name`, `resource_id`) VALUES ('test', 1);

/* Add User Role Permissions */
INSERT INTO `restmagazin`.`role_permission` (`role_id`, `permission_id`) VALUES (1, 1);
INSERT INTO `restmagazin`.`role_permission` (`role_id`, `permission_id`) VALUES (1, 2);
INSERT INTO `restmagazin`.`role_permission` (`role_id`, `permission_id`) VALUES (1, 3);
INSERT INTO `restmagazin`.`role_permission` (`role_id`, `permission_id`) VALUES (1, 4);
INSERT INTO `restmagazin`.`role_permission` (`role_id`, `permission_id`) VALUES (2, 1);
INSERT INTO `restmagazin`.`role_permission` (`role_id`, `permission_id`) VALUES (2, 2);
INSERT INTO `restmagazin`.`role_permission` (`role_id`, `permission_id`) VALUES (3, 1);
INSERT INTO `restmagazin`.`role_permission` (`role_id`, `permission_id`) VALUES (3, 3);