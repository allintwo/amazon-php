<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 6/1/2022
 * Time: 3:25 AM
 */




function build_wp_post_template($json_data)
{

    $post_template = <<<sdfgdsiufgsduifgsdifgsdi
<!--  -->
<!--  -->
<!--  -->
<!--  -->
sdfgdsiufgsduifgsdifgsdi;

    $hamazon_settings_data = [
        'hamazon_affid' => 'test-20',
        'hamazon_posttem' => '',
        'hamazon_demoti' => ''
    ];

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




/*
    $json_datax = [
        'id' => $this->id,
        'title'=>$this->title,
        'image' => $this->image,
        'images' => $this->images,
        'rating' => $this->rating,
        'rating_count' => $this->rating_count,
        'answers' => $this->answers,
        'answers_count' => $this->answers_count,
        'reviews' => $this->reviews,
        'reviews_count'=>$this->reviews_count,
        'details' => $this->details,
        'description'=>$this->description,
        'features' => $this->features,
        'categorys' => $this->categorys,
        'tags' => $this->tags
    ];
*/

    $aff_tag = $hamazon_settings_data['hamazon_affid'];
    $demo_text = $hamazon_settings_data['hamazon_demoti'];


    $title = $json_data['title'];
    $product_name = $json_data['title'];
    $product_image = $json_data['image'];
    $rating = $json_data['rating'];

    $answers_html = '';
    foreach ($json_data['answers'] as $anskey => $ansval)
    {
        $answers_html .= <<<feriuofgeruifgeiufgsdkjfdsgfjk
<div class="wp-block-custom-block-faq faq">
                <b class="faq__question">{$ansval[0]}</b>
                <p class="faq__answer">{$ansval[1]}</p>
</div>
feriuofgeruifgeiufgsdkjfdsgfjk;

    }

    $reviws_html = "";
    foreach ($json_data['reviews'] as $revkey => $revtxt)
    {
        $reviws_html .= <<<ldslhfdshdsijfgdsifg
<b>{$revtxt[0]}</b>
<p>{$revtxt[1]}</p>
ldslhfdshdsijfgdsifg;

    }



    $wp_title = "title {$demo_text}";


return <<<sdgkjdskfgdsdfiuksdgfds
<div>
    <div class="wp-block-image">
    <figure class="alignleft size-large">
        <img src="{$product_image}" alt="{$title}" style="max-height: 200px">
        <figcaption><strong>{$rating}/5</strong></figcaption>
    </figure>
    </div>
    <h2 class="product-name">{$product_name}</h2>
    <div class="wp-container-1 wp-block-buttons">
        <div class="wp-block-button aligncenter has-custom-width wp-block-button__width-25 has-custom-font-size is-style-fill has-medium-font-size">
            <a href="https://www.amazon.com/dp/B08RZBHXNQ/?tag={$aff_tag}" rel="nofollow noopener" target="_blank" class="wp-block-button__link">Buy Now</a>
        </div>
    </div>
    <p>Intro</p>
    
    <div id="facts">
        <h2>Facts About {$title}</h2>
        <div>
        <!--
            <div class="wp-block-custom-block-faq faq">
                <p class="faq__question">{Q}</p>
                <p class="faq__answer">{A}</p>
            </div>
            -->
            {$answers_html}
        </div>
    </div>
    
    <div id="reviews">
        <h2>Info About {$product_name} (Reviews From Amazon)</h2>
        <div>
       <!-- <p>{REVIEW_TEXT}</p> -->
       {$reviws_html}
        </div>
        <h2 id="review_video">Video Reviews</h2>
    </div>
</div>
sdgkjdskfgdsdfiuksdgfds;


}
