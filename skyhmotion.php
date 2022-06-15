<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 5/28/2022
 * Time: 1:23 PM
 */

/**
 ** @package Amazon
 ** @Heart Compatible
 **/
/*
Plugin Name: Amazon review page builder
Plugin URI: https://mimosait.com/?plugin=amazon
Description: Amazon product review generator.
Version: 1.0.0
Author: CosMos
Author URI: https://github.com/rahul-amin/
License: GPLv2 or later
Text Domain: skyhmotion
*/
/*
Copyright (C) 2022 Faylab, https://faylab.com

This program is not free software; so you can't redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
/**
 ** @author -fulldev CosMos
 **/

define( 'HAMAZON_DIR_URL', plugin_dir_url(__FILE__) );
define( 'HAMAZON_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'HAMAZON_VERSION', '0.01' );



include_once 'wp/functions.php';
include_once 'wp/post_build.php';

include_once 'wp/footer-script.php';





add_action( 'admin_menu', 'register_my_custom_menu_page' );
function register_my_custom_menu_page() {
    // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    add_menu_page( 'Hamazon', 'Hamazon', 'manage_options', 'hamazon-home', 'show_hamazon_home', 'dashicons-welcome-widgets-menus', 90 );
  //  add_menu_page( 'Hamazon', 'Hamazon', 'manage_options', 'hamazon-settings', 'show_hamazon_settings', 'dashicons-welcome-widgets-menus', 90 );
}

add_action('wp_enqueue_scripts', 'hamazon_wp_enqueue');
function hamazon_wp_enqueue(){
    wp_enqueue_style( 'imga-style', HAMAZON_DIR_URL.'css/style.css', array(), HAMAZON_VERSION );
}



function h_html_container($title,$bodytext)
{
    return <<<sdfhdskfgdsafgfdsgafisdaigfdsufds
<div id="dashboard_site_health" class="postbox" style="">
<div class="postbox-header">
<h2 class="hndle ui-sortable-handle">{$title}</h2>
</div>
<div class="inside">
	<div class="health-check-widget">
	       {$bodytext}
	</div>

</div>
</div>
sdfhdskfgdsafgfdsgafisdaigfdsufds;

}


function show_hamazon_home()
{
    $post_template = <<<sdfgdsiufgsduifgsdifgsdi
<strong><u><h2><!--KEYWORD--> Buying Guide</h2></u></strong></br></ol>Top <!--KEYWORD--> brands try to offer some unique features that make them stand out in the crowd. Thus hopefully, you’ll find one ideal product or another in our list.</br></br><ol start="2"> 	<li><strong><u> Features:</u></strong> You don’t need heaps of features, but useful ones. We look at the features that matter and choose the top <!--KEYWORD--> based on that.</li> 	<li><strong><u> Specifications:</u></strong> Numbers always help you measure the quality of a product in a quantitative way. We try to find products of higher specifications, but with the right balance.</li> 	<li><strong><u> Customer Ratings:</u></strong> The hundreds of customers using the <!--KEYWORD--> before you won’t say wrong, would they? Better ratings mean better service experienced by a good number of people.</li> 	<li><strong><u> Customer Reviews:</u></strong> Like ratings, customer reviews give you actual and trustworthy information, coming from real-world consumers about the <!--KEYWORD--> they used.</li> 	<li><strong><u> Seller Rank:</u></strong> Now, this is interesting! You don’t just need a good <!--KEYWORD-->, you need a product that is trendy and growing in sales. It serves two objectives. Firstly, the growing number of users indicates the product is good. Secondly, the manufacturers will hopefully provide better quality and after-sales service because of that growing number.</li> 	<li><strong><u> Value For The Money:</u></strong> They say you get what you pay for. Cheap isn’t always good. But that doesn’t mean splashing tons of money on a flashy but underserving product is good either. We try to measure how much value for the money you can get from your <!--KEYWORD--> before putting them on the list.</li> 	<li><strong><u> Durability:</u></strong> Durability and reliability go hand to hand. A robust and durable <!--KEYWORD--> will serve you for months and years to come.</li> 	<li><strong><u> Availability:</u></strong> Products come and go, new products take the place of the old ones. Probably some new features were added, some necessary modifications were done. What’s the point of using a supposedly good <!--KEYWORD--> if that’s no longer continued by the manufacturer? We try to feature products that are up-to-date and sold by at least one reliable seller, if not several.</li> 	<li><strong><u> Negative Ratings: </u></strong>Yes, we take that into consideration too! When we pick the top rated <!--KEYWORD--> on the market, the products that got mostly negative ratings get filtered and discarded.</li></ol>These are the criteria we have chosen our <!--KEYWORD--> on. Does our process stop there? Heck, no! The most important thing that you should know about us is, we\'re always updating our website to provide timely and relevant information.</br></br>Since reader satisfaction is our utmost priority, we have a final layer of filtration. And that is you, the reader! If you find any <!--KEYWORD--> featured here Incorrect, irrelevant, not up to the mark, or simply outdated, please let us know. Your feedback is always welcome and we’ll try to promptly correct our list as per your reasonable suggestion.
sdfgdsiufgsduifgsdifgsdi;


    $post_test_output = '';
    $hamazon_settings_data = [];
    $option_name = 'hamazon_settings_data';
    $option_value = get_option($option_name);
    if($option_name)
    {
        $hamazon_settings_data = unserialize($option_value);
    }else{
        $hamazon_settings_data = [
            'hamazon_affid' => 'test-20',
            'hamazon_posttem' => $post_template,
            'hamazon_demoti' => ''
        ];
        update_option($option_name, serialize($hamazon_settings_data));
    }


    global $wpdb;
    $urls = '';

    $amazon_ids = [];
    if(isset($_POST['urls']))
    {
        $urls = $_POST['urls'];
        $nurls = preg_split("/\r\n|\n|\r/", $urls);
        foreach ($nurls as $nurl)
        {
            $amazon_mtc = "#(?:[/dp/]|$)([A-Z0-9]{10})#";
            if(preg_match($amazon_mtc,$nurl,$mtc))
            {
                $amazon_ids[$mtc[1]] = $mtc[1];
            }else{
                if(strlen($nurl) == 10)
                {
                    $amazon_ids[$nurl] = $nurl;
                }
            }

        }
    }
    foreach ($amazon_ids as  $amazon_id)
    {
        $sql = "SELECT * FROM `hamazon_lists` where product_id = '{$amazon_id}'";
        $results = $wpdb->get_results($sql);

        if($results->num_rows)
        {

        }else{
            // insert
            $time = time();

            $sql = "INSERT INTO `hamazon_lists`(`product_id`, `time`, `post_time`, `post_id`, `status`) VALUES ('{$amazon_id}','{$time}','0','0','0')";
            $wpdb->query($sql);
        }
    }



    // recent lists


    $recent_ids_html = "<tr><th>ID</th><th>Product ID</th><th>Added</th></tr>";


    $sql = "SELECT * FROM `hamazon_lists` order by id desc limit 50";
    $results = $wpdb->get_results($sql);
    foreach( $results as $result ) {
        $time = ht_humanTiming($result->time);
        $recent_ids_html .= "<tr><th>{$result->id}</th><td>{$result->product_id}</td><td>{$time} ago</td></tr>";
    }

   // print_r($amazon_ids);


    $insert_url_html = <<<sddlkfhdsiufgdsiufgdsifgsdiufgsdi

<div class="form-wrap">
<form action="" method="post">
<div class="form-field form-required term-name-wrap">
<label for="urls">Add Amazon urls</label>
<textarea id="urls" name="urls" rows="6"></textarea>
</div>
<div class="form-field form-required term-name-wrap">
<input type="submit" class="button button-primary" value="Add">
</div>
</form>
</div>

sddlkfhdsiufgdsiufgdsifgsdiufgsdi;





    $total_product = $wpdb->get_var("SELECT count(*) FROM `hamazon_lists`");
    $total_working = $wpdb->get_var("SELECT count(*) FROM `hamazon_lists` where status = 0");
    $total_complete = $wpdb->get_var("SELECT count(*) FROM `hamazon_lists` where status = 1");

    $status_html = <<<sdkjfhsdlkujfgdsukifgsddifudsaui9d
<div>
<table class="wp-list-table widefat fixed striped table-view-list tags">
<tbody>
<tr><th>Total product added</th><td>{$total_product}</td></tr>
<tr><th>Complate</th><td>{$total_complete}</td></tr>
<tr><th>Working</th><td>{$total_working}</td></tr>
</tbody>
</table>

</div>
sdkjfhsdlkujfgdsukifgsddifudsaui9d;


    // settings....

    $template_info = <<<sdldhfdsiufgsdafgsdfgidsufgdsiu
{TITLE}
{PRODUCT_NAME}
{QUESTIONS}
{ANSWERS}
{FACTS_TITLE}
sdldhfdsiufgsdafgsdfgidsufgdsiu;



    $affiliate_id = '';


    if(isset($_GET['ttx']))
    {
        include_once 'lib/simple_html_dom.php';
        include_once 'lib/amazon_php.php';
        $az = new amazon_product_data();
        $amazon_id = 'B06XR5MWGM';
        $data = $az->get_product_info($amazon_id);
        $az->get_questions($amazon_id);
        $az->get_reviews($amazon_id);
        $product_response = $az->get_response();
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/wp/hamazon_res.json',json_encode($product_response));

        //echo json_encode($product_response);
        $post_test_output = build_wp_post_template($product_response);

    }

    if(isset($_POST['hamazon_settings']))
    {
        $hamazon_settings_affid = $_POST['hamazon_affid'];
        $hamazon_settings_posttem = stripslashes($_POST['hamazon_posttem']);
        $hamazon_settings_demoti = stripslashes($_POST['hamazon_demoti']);

        $hamazon_settings_data = [
            'hamazon_affid' => $hamazon_settings_affid,
            'hamazon_posttem' => $hamazon_settings_posttem,
            'hamazon_demoti' => $hamazon_settings_demoti
        ];

        $option_name = 'hamazon_settings_data';
        if (!get_option($option_name)) {
            add_option($option_name, serialize($hamazon_settings_data));
        }else{

            update_option($option_name,  serialize($hamazon_settings_data));
        }

    }


    $tpl_inf_html = <<<dfgiudfghuisdgaiufasd
<!--KEYWORD-->  = Last Tag name
<!--TITLE--> = Amazon title  
<!--RATING--> = rating score 5/5
dfgiudfghuisdgaiufasd;

    $tpl_inf_html = htmlentities($tpl_inf_html);


    $post_tem_enc = $hamazon_settings_data['hamazon_posttem'];



    $settings_html = <<<hdfakdgsddfgdsafldsf
<div>


<form action="" method="post">
<div class="form-field form-required term-name-wrap">
<label for="affid">Amazon Affiliate ID</label>
<input type="text" name="hamazon_affid" value="{$hamazon_settings_data['hamazon_affid']}" placeholder="something-20" id="affid">
</div>
<div class="form-field form-required term-name-wrap">
<label for="demotext">Demo title</label>
<input type="text" name="hamazon_demoti" placeholder="demo text" value="{$hamazon_settings_data['hamazon_demoti']}" id="demotext">
</div>
<div class="form-field form-required term-name-wrap">
<label for="posttemplate">Post conclusion</label>
<textarea name="hamazon_posttem" id="posttemplate">{$post_tem_enc}</textarea>
</div>
<div class="form-field form-required term-name-wrap">
<input type="submit" name="hamazon_settings" id="savebtn" value="save"  class="button button-primary">
</div>

</form>

<div>
<p><i>{$tpl_inf_html}</i></p>
</div>
</div>
hdfakdgsddfgdsafldsf;





    $status = h_html_container('Status',$status_html);
    $input_urls = h_html_container('Insert urls',$insert_url_html);
    $url_lists = h_html_container('Recent urls',"<table class='wp-list-table widefat fixed striped table-view-list tags'><tbody>{$recent_ids_html}</tbody></table>");
    $settings = h_html_container('Settings',$settings_html);

    echo <<<sdfdslfhdgdfhgord
{$post_test_output}
<div id="dashboard-widgets-wrap">
<div id="dashboard-widgets" class="metabox-holder">
	
	<div id="postbox-container-1">
	    <div id="normal-sortables" class="meta-box-sortables ui-sortable">
	    {$status}
	    </div>
	</div>
	<div id="postbox-container-1">
	    <div id="normal-sortables" class="meta-box-sortables ui-sortable">
	    {$input_urls}
	    </div>
	</div>
	<div id="postbox-container-1">
	    <div id="normal-sortables" class="meta-box-sortables ui-sortable">
	  {$url_lists}
	    </div>
	</div>	
	<div id="postbox-container-1">
	    <div id="normal-sortables" class="meta-box-sortables ui-sortable">
	  {$settings}
	    </div>
	</div>
	
</div>
</div>

sdfdslfhdgdfhgord;

}

register_activation_hook( __FILE__, 'hamazon_function_to_run' );

function hamazon_function_to_run(){
    include_once 'wp/install.php';
    fapello_create_extra_table();
}

include_once 'wp/cron.php';

