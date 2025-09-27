<?php
defined( 'ABSPATH' ) || exit;

// ------------- create table -------------
/* global $wpdb;
$table_tickets = $wpdb->prefix . 'tickets';
$table_collation = 'utf8_general_ci';
//$table_collation = $wpdb->collate;

$sql = "
CREATE TABLE `$table_tickets` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `courseId` bigint(20) unsigned NOT NULL,
    `userId` bigint(20) unsigned NOT NULL,
    `parent` varchar(3) NOT NULL,
    `title` varchar(100) NOT NULL,
    `body` varchar(500) NOT NULL,
    `lastUpdate` varchar(200) NOT NULL,
    `file` varchar(5) NOT NULL,
    `status` varchar(5) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `r1` (`courseId`),
    KEY `r2` (`userId`),
    CONSTRAINT `r1` FOREIGN KEY (`courseId`) REFERENCES `wpclassnow_posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `r2` FOREIGN KEY (`userId`) REFERENCES `wpclassnow_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=$table_collation
";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql ); */





if(is_admin()){
    include dirname( __FILE__ ) . '/admin/tickets-admin.php';
}


?>