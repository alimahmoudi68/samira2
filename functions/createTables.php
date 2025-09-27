<?php 
$my_opt = get_option('my_opt');
$create_tables = isset($my_opt['opt-create-table']) ? $my_opt['opt-create-table'] : '0';

if($create_tables){

    require_once ABSPATH. 'wp-admin/includes/upgrade.php';

    global $wpdb;
    $tablename_phone_otp = 'phone_otp';
    $main_sql_create_phone_otp = 'CREATE TABLE `wp_phone_otp` (
        `id` int NOT NULL AUTO_INCREMENT,
        `phone` varchar(11) COLLATE utf8mb4_persian_ci NOT NULL,
        `token` varchar(100) COLLATE utf8mb4_persian_ci NOT NULL,
        `otp` varchar(100) COLLATE utf8mb4_persian_ci NOT NULL,
        `time` varchar(15) COLLATE utf8mb4_persian_ci NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;'; 
    maybe_create_table($wpdb->prefix. $tablename_phone_otp, $main_sql_create_phone_otp);


    $tablename_phone_otp_allow = 'phone_otp_allow';
    $main_sql_create_phone_otp_allow = 'CREATE TABLE `wp_phone_otp_allow` (
        `id` int NOT NULL AUTO_INCREMENT,
        `ip` varchar(20) COLLATE utf8mb4_persian_ci NOT NULL,
        `count` int NOT NULL,
        `date` varchar(15) COLLATE utf8mb4_persian_ci NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;'; 
    maybe_create_table($wpdb->prefix. $tablename_phone_otp_allow, $main_sql_create_phone_otp_allow);

}

?>