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

$data = $az->get_product_info('B06XR5MWGM');

//print_r($data);

$res = $az->get_response();

///$az->get_questions();
$az->get_reviews();