<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 5/30/2022
 * Time: 4:48 AM
 */


function hamazon_custom_cron_schedulex( $schedules ) {
    $schedules['every_hx_times'] = array(
        'interval' => 55, // Every 1 hours
        'display'  => __( 'Every hx5 ,minutes' ),
    );
    return $schedules;
}

add_filter( 'cron_schedules', 'hamazon_custom_cron_schedulex' );

//Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'hamazon_cron_hookx' ) ) {
    wp_schedule_event( time(), 'every_hx_times', 'hamazon_cron_hookx' );
}

///Hook into that action that'll fire every six hours
add_action( 'hamazon_cron_hookx', 'hamazon_cron_function' );

//create your function, that runs on cron
function hamazon_cron_function() {
    global $wpdb;
    //your function...


    $sql = "SELECT * FROM `hamazon_lists` where post_id = '0' order by id asc limit 1";
    $results = $wpdb->get_results($sql);
    foreach( $results as $result ) {


        include_once HAMAZON_PLUGIN_DIR .'/lib/simple_html_dom.php';
        include_once HAMAZON_PLUGIN_DIR .'/lib/amazon_php.php';
        $az = new amazon_product_data();
        $amazon_id = $result->product_id;
        $data = $az->get_product_info($amazon_id);
        $az->get_questions($amazon_id);
        $az->get_reviews($amazon_id);
        $product_response = $az->get_response();
        $post_test_output = build_wp_post_template($product_response);
      //  file_put_contents($_SERVER['DOCUMENT_ROOT'].'/cron.log',time().$post_test_output);
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/wp/hamazon_res.json',json_encode($product_response));

        if(isset($product_response['title']))
        {
            $cats =$product_response['categorys'];
            $ncats = [];
            foreach ($cats as $cat)
            {
                $ncats[] = [$cat , $cat];
            }
            $ntags = [];
            $tags = $product_response['tags'];
            foreach ($tags as $tag)
            {
                $ntags[] = [$tag,$tag];
            }

            $paramlink = sanitize_title($product_response['title']);


         //  $post_id =  hamazon_Postwp($product_response['title'],$product_response['image'],$post_test_output,$paramlink,$ncats,$ntags);
           $post_id =  hamazon_Postwp($product_response['title'],'',$post_test_output,$paramlink,$ncats,$ntags);
            $time = time();
            $sql = "UPDATE `hamazon_lists` SET `post_time`='{$time}',`post_id`='{$post_id}',`status`='1' WHERE id = '{$result->id}'";
            $wpdb->query($sql);
        }else{
            hamazon_logsave('title too short');
        }

    }
}

function hamazon_logsave($log,$location = 'log.txt')
{
    $location = HAMAZON_PLUGIN_DIR . 'log.txt';
    file_put_contents($location,$log);
}


function hamazon_Postwp($title,$thumb,$content,$paramlink,$cats = [],$tags = [])
{
    // $wproot = realpath('../../../../..');
    global $wproot;
    global $wpdb;
    global $response;
    global $errors;
    $wproot = ABSPATH;

    $author_id = 1;
//    include $wproot.'/wp-config.php';
    require_once($wproot . '/wp-admin/includes/media.php');
    require_once($wproot . '/wp-admin/includes/file.php');
    require_once($wproot . '/wp-admin/includes/image.php');
    require_once( $wproot . '/wp-admin/includes/taxonomy.php');

    $query = $wpdb->prepare(
        'SELECT ID FROM ' . $wpdb->posts . '
        WHERE post_title = %s',
        $title
    );
    $wpdb->query( $query );

    if ( $wpdb->num_rows ) {
        //	echo "post exits";
        $response['errors'][] ="Post exist";
        $response['status'] = 501;
        hamazon_logsave('post exist');
        return false;
    }
    $query = $wpdb->prepare(
        'SELECT ID FROM ' . $wpdb->posts . '
        WHERE post_name = %s',
        $paramlink
    );
    $wpdb->query( $query );

    if ( $wpdb->num_rows ) {
        //	echo "post exits";
        $response['errors'][] ="Post url exist";
        $response['status'] = 501;
        hamazon_logsave('paramlink exist');
        return false;
    }


// category and tags system
    $cat_ids = [];
    $tag_ids = [];


    foreach ($cats as $cat)
    {
        $cat_ID = get_cat_ID($cat[1]);
        if($cat_ID)
        {
        }else {
            $cat_data = array( 'cat_name' => $cat[1], 'category_nicename' => $cat[1] );
            wp_insert_category( $cat_data );

        }
        // try again . sometime category insert take time
        $cat_ID = get_cat_ID($cat[1]);
        if($cat_ID)
        {
        }else{
            $cat_data = array('cat_name' => $cat[1],'category_nicename'=>$cat[1]);
            wp_insert_category($cat_data);

        }

        $new_cat_ID = get_cat_ID($cat[1]);
        if($cat_ID)
        {
            $cat_ids[] = $new_cat_ID;
        }
    }



// print_r($cats);
    if(count($cat_ids)<1)
    {
        $cat_ids = [1]; // uncategorys
    }

// print_r($cat_ids);exit();

// print_r($tags);
    if(1)
    {
        foreach ($tags as $tag)
        {
            $tag_found = get_term_by('name',$tag[1],'post_tag');
            if($tag_found)
            {
                // $new_tag_id = $tag_found->term_id;
            }else{
                $tagdata = wp_insert_term($tag[1],'post_tag',['slug'=> $tag[0]]);
            }
            $tag_found = get_term_by('name',$tag[1],'post_tag');
            if($tag_found)
            {
                $tag_ids[] = $tag_found->term_id;
            }
        }
    }
    if(count($tag_ids)<1)
    {
        $tag_ids = [];
    }

//print_r($cats);
//print_r($cat_ids);
//exit();


    // check double post



// Gather post data.
    $my_post = array(
        'post_title'    => $title,
        'post_name'    => $paramlink,
        'post_content'  => $content,
        // 'post_status'   => 'pending',
      //  'post_status'   => 'Publish',
        'post_status'   => 'draft',
        'post_author'   => $author_id,
        'post_category' => $cat_ids,
        'tags_input' => $tag_ids
    );
// echo '--dd--';
// exit();
// Insert the post into the database.
    @kses_remove_filters();
    $post_id = wp_insert_post($my_post);
    @kses_init_filters();
    // example image
    $image = $thumb;
    if(strlen($image)>10)
    {
// magic sideload image returns an HTML image, not an ID
        $media = media_sideload_image($image, $post_id);

// therefore we must find it so we can set it as featured ID
        if(!empty($media) && !is_wp_error($media)){
            $args = array(
                'post_type' => 'attachment',
                'posts_per_page' => -1,
                'post_status' => 'any',
                'post_parent' => $post_id
            );

            // reference new image to set as featured
            $attachments = get_posts($args);

            if(isset($attachments) && is_array($attachments)){
                foreach($attachments as $attachment){
                    // grab source of full size images (so no 300x150 nonsense in path)
                    $image = wp_get_attachment_image_src($attachment->ID, 'full');
                    // determine if in the $media image we created, the string of the URL exists
                    if(strpos($media, $image[0]) !== false){
                        // if so, we found our image. set it as thumbnail
                        set_post_thumbnail($post_id, $attachment->ID);
                        // only want one image
                        break;
                    }
                }
            }else{
                hamazon_logsave('Main attachment image already exist !');
                $response['errors'][] = "Main attachment image already exist !";
            }
        }else{
            hamazon_logsave('media_sideload_image Error.  Something wrong with image !');
            $response['errors'][] = "media_sideload_image Error.  Something wrong with image !";
        }

    }else{
        $response['errors'][] = "Image url too short !";
       // hamazon_logsave('Image url too short !');
    }


    return $post_id;
}