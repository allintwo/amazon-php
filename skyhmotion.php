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


include_once 'wp/functions.php';
include_once 'wp/cron.php';

register_activation_hook( __FILE__, 'hamazon_function_to_run' );

function hamazon_function_to_run(){
    include_once 'wp/install.php';
}



add_action( 'admin_menu', 'register_my_custom_menu_page' );
function register_my_custom_menu_page() {
    // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    add_menu_page( 'Hamazon', 'Hamazon', 'manage_options', 'hamazon-home', 'show_hamazon_home', 'dashicons-welcome-widgets-menus', 90 );
  //  add_menu_page( 'Hamazon', 'Hamazon', 'manage_options', 'hamazon-settings', 'show_hamazon_settings', 'dashicons-welcome-widgets-menus', 90 );
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

    $affiliate_id = '';
    $post_template = <<<sdfgdsiufgsduifgsdifgsdi
<!--  -->
<!--  -->
<!--  -->
<!--  -->
sdfgdsiufgsduifgsdifgsdi;



    $settings_html = <<<hdfakdgsddfgdsafldsf
<div>
<form action="" method="post">
<div class="form-field form-required term-name-wrap">
<label for="affid">Amazon Affiliate ID</label>
<input type="text" name="affid" value="" placeholder="something-20" id="affid">
</div>
<div class="form-field form-required term-name-wrap">
<label for="demotext">Demo title</label>
<input type="text" name="demotext" placeholder="demo text" value="" id="demotext">
</div>
<div class="form-field form-required term-name-wrap">
<<label for="posttemplate">Post template</label>
<textarea name="posttemplate" id="posttemplate">{$post_template}</textarea>
</div>
<div class="form-field form-required term-name-wrap">
<input type="submit" name="savebtn" id="savebtn" value="save"  class="button button-primary">
</div>


</form>


</div>
hdfakdgsddfgdsafldsf;





    $status = h_html_container('Status',$status_html);
    $input_urls = h_html_container('Insert urls',$insert_url_html);
    $url_lists = h_html_container('Recent urls',"<table class='wp-list-table widefat fixed striped table-view-list tags'><tbody>{$recent_ids_html}</tbody></table>");
    $settings = h_html_container('Settings',$settings_html);

    echo <<<sdfdslfhdgdfhgord

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

