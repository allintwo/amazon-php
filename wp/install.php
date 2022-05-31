<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 5/28/2022
 * Time: 2:15 PM
 */

global $jal_db_version;
$jal_db_version = '1.0';

function fapello_create_extra_table() {
    global $wpdb;
    global $jal_db_version;

    $table_prefix = $wpdb->prefix;

    $charset_collate = $wpdb->get_charset_collate();


    $sqls = [
        "CREATE TABLE IF NOT EXISTS `hamazon_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(32) NOT NULL,
  `time` int(12) NOT NULL,
  `post_time` int(12) NOT NULL,
  `post_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) $charset_collate;"
    ];

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    foreach ($sqls as  $sql)
    {
        dbDelta( $sql );
    }

    add_option( 'jal_db_version', $jal_db_version );
}