<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 5/26/2022
 * Time: 4:38 PM
 */

include_once 'lib/simple_html_dom.php';
include_once 'lib/amazon_php.php';

$az = new amazon_product_data();



if(isset($_REQUEST['amazon_id']))
{
    $amazon_id = $_REQUEST['amazon_id'];


    $data = $az->get_product_info($amazon_id);
    $az->get_questions($amazon_id);
    $az->get_reviews($amazon_id);

    header("Content-Type: application/json");
    echo json_encode($az->get_response());
}
