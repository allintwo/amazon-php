<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 5/30/2022
 * Time: 4:48 AM
 */


function hamazon_custom_cron_schedule( $schedules ) {
    $schedules['every_one_hours'] = array(
        'interval' => 3600, // Every 1 hours
        'display'  => __( 'Every 1 hours' ),
    );
    return $schedules;
}

add_filter( 'cron_schedules', 'hamazon_custom_cron_schedule' );

//Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'hamazon_cron_hook' ) ) {
    wp_schedule_event( time(), 'every_one_hours', 'hamazon_cron_hook' );
}

///Hook into that action that'll fire every six hours
add_action( 'hamazon_cron_hook', 'hamazon_cron_function' );

//create your function, that runs on cron
function hamazon_cron_function() {
    //your function...

    file_put_contents('cron.log',time());

}