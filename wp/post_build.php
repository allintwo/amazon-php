<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 6/1/2022
 * Time: 3:25 AM
 */




function build_wp_post_template($json_data)
{

    $conclusion_html = <<<lhdsfdsfhdsiufgdsuiafgdsaiufugds
<strong><u><h2><!--KEYWORD--> Buying Guide</h2></u></strong></br></ol>Top <!--KEYWORD--> brands try to offer some unique features that make them stand out in the crowd. Thus hopefully, you’ll find one ideal product or another in our list.</br></br><ol start="2"> 	<li><strong><u> Features:</u></strong> You don’t need heaps of features, but useful ones. We look at the features that matter and choose the top <!--KEYWORD--> based on that.</li> 	<li><strong><u> Specifications:</u></strong> Numbers always help you measure the quality of a product in a quantitative way. We try to find products of higher specifications, but with the right balance.</li> 	<li><strong><u> Customer Ratings:</u></strong> The hundreds of customers using the <!--KEYWORD--> before you won’t say wrong, would they? Better ratings mean better service experienced by a good number of people.</li> 	<li><strong><u> Customer Reviews:</u></strong> Like ratings, customer reviews give you actual and trustworthy information, coming from real-world consumers about the <!--KEYWORD--> they used.</li> 	<li><strong><u> Seller Rank:</u></strong> Now, this is interesting! You don’t just need a good <!--KEYWORD-->, you need a product that is trendy and growing in sales. It serves two objectives. Firstly, the growing number of users indicates the product is good. Secondly, the manufacturers will hopefully provide better quality and after-sales service because of that growing number.</li> 	<li><strong><u> Value For The Money:</u></strong> They say you get what you pay for. Cheap isn’t always good. But that doesn’t mean splashing tons of money on a flashy but underserving product is good either. We try to measure how much value for the money you can get from your <!--KEYWORD--> before putting them on the list.</li> 	<li><strong><u> Durability:</u></strong> Durability and reliability go hand to hand. A robust and durable <!--KEYWORD--> will serve you for months and years to come.</li> 	<li><strong><u> Availability:</u></strong> Products come and go, new products take the place of the old ones. Probably some new features were added, some necessary modifications were done. What’s the point of using a supposedly good <!--KEYWORD--> if that’s no longer continued by the manufacturer? We try to feature products that are up-to-date and sold by at least one reliable seller, if not several.</li> 	<li><strong><u> Negative Ratings: </u></strong>Yes, we take that into consideration too! When we pick the top rated <!--KEYWORD--> on the market, the products that got mostly negative ratings get filtered and discarded.</li></ol>These are the criteria we have chosen our <!--KEYWORD--> on. Does our process stop there? Heck, no! The most important thing that you should know about us is, we\'re always updating our website to provide timely and relevant information.</br></br>Since reader satisfaction is our utmost priority, we have a final layer of filtration. And that is you, the reader! If you find any <!--KEYWORD--> featured here Incorrect, irrelevant, not up to the mark, or simply outdated, please let us know. Your feedback is always welcome and we’ll try to promptly correct our list as per your reasonable suggestion.
lhdsfdsfhdsiufgdsuiafgdsaiufugds;


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
            'hamazon_posttem' => $conclusion_html,
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
    $custom_conclu = $hamazon_settings_data['hamazon_posttem'];

    $rating = $json_data['rating'];

    $title = $json_data['title'];
    $product_name = $json_data['title'];
    $product_image = $json_data['image'];
    $rating_txt = $json_data['rating_txt'];

    $answers_html = '';
    foreach ($json_data['answers'] as $anskey => $ansval)
    {
        $answers_html .= <<<feriuofgeruifgeiufgsdkjfdsgfjk
<div class="wp-block-custom-block-faq faq">
<div class="haccordion">
                <b class="faq__question">{$ansval[0]}</b>
</div>
<div class="hpanel">
<p class="faq__answer">{$ansval[1]}</p>
 </div>              
</div>
feriuofgeruifgeiufgsdkjfdsgfjk;

    }

    $reviws_html = "";
    foreach ($json_data['reviews'] as $revkey => $revtxt)
    {
        $reviws_html .= <<<ldslhfdshdsijfgdsifg
<div class="wp-block-custom-block-faq faq">
<div class="haccordion">
<b>{$revtxt[0]}</b>
</div>
<div class="hpanel">
<p>{$revtxt[1]}</p>
</div>
</div>

ldslhfdshdsijfgdsifg;

    }



    $wp_title = "title {$demo_text}";


    $vid_rev_html = '';
    if(count($json_data['videos'])>0)
    {

        $vids_xhtml = '';

        foreach ($json_data['videos'] as $xkey => $vidurl)
        {
            if(strpos($vidurl,'.mp4')>0)
            {

            }else{
                continue;
            }

            $vids_xhtml .= <<<sdfhdsfjksaghfji
<div>
    <video style="width: 100%" controls="controls" preload="none" class="hamazon-video">
        <source src="{$vidurl}#t=0.5" type="video/mp4">
    </video>
</div>
sdfhdsfjksaghfji;

        }

        $vid_rev_html = <<<sdjfdhdskfgdsfldsg
<div id="container-4">
    <div id="hamazon-videos">
        <h2>Video Review</h2>
        {$vids_xhtml}
    </div>
</div>
sdjfdhdskfgdsfldsg;

    }

    $slider_images_html = '';
    if(1)
    {
        $i = 0;
        $total_img = count($json_data['images']);
        foreach ($json_data['images'] as $image_url)
        {
            $i++;
            $slider_images_html .= <<<askfdhiugsdfgdsfuidsfugids
<div class="mySlides fade">
  <div class="numbertext">{$i} / {$total_img}</div>
  <img src="{$image_url}" style="width:100%">
  <div class="text">{$json_data['title']} Image {$i}</div>
</div>
askfdhiugsdfgdsfuidsfugids;

        }
    }


$last_tag = end($json_data['tags']);






$conclusion_html = str_replace('<!--KEYWORD-->',$last_tag,$custom_conclu);
$conclusion_html = str_replace('<!--TITLE-->',$title,$conclusion_html);
$conclusion_html = str_replace('<!--RATING-->',$rating_txt,$conclusion_html);




return <<<sdgkjdskfgdsdfiuksdgfds
<div>
<div id="imga-content" class="bordered-box hamazon-container">


<div id="container-1">
<div class="slideshow-container">
{$slider_images_html}
</div>
<div class="hamazon-rsocre-div"><strong class="hamazon-rsocre">{$rating_txt}</strong></div>    
    <p>{$json_data['description']}</p>
<div>

    <div class="wp-container-1 wp-block-buttons">
        <div class="wp-block-button aligncenter has-custom-width wp-block-button__width-25 has-custom-font-size is-style-fill has-medium-font-size">
            <a style="position: unset;width: 300px" href="https://www.amazon.com/dp/{$json_data['id']}/?tag={$aff_tag}" rel="nofollow noopener" target="_blank" class="imga-buy-button">Buy Now</a>
        </div>
    </div>
</div>
</div>

<div id="container-2">
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
            <div class="hamazon-rsocre-div"><a class="readmore-btn" href="https://www.amazon.com/ask/questions/asin/{$json_data['id']}/2/ref=ask_ql_psf_ql_hza&tag={$aff_tag}" rel="nofollow noopener" target="_blank">Read more facts</a> </div>
        </div>
    </div>
</div>

<div id="container-3">
    <div id="reviews">
        <h2>Info About {$product_name} (Reviews From Amazon)</h2>
        <div>
       <!-- <p>{REVIEW_TEXT}</p> -->
       {$reviws_html}
        </div>
      <div class="hamazon-rsocre-div"><a class="readmore-btn" href="https://www.amazon.com/HyperX-Alloy-Origins-Software-Controlled-Customization/product-reviews/{$json_data['id']}/ref=cm_cr_getr_d_paging_btm_2?ie=UTF8&filterByStar=positive&pageNumber=2&reviewerType=all_reviews&pageSize=10&tag={$aff_tag}" rel="nofollow noopener" target="_blank">Read more reviews</a></div>
    </div>
</div>
{$vid_rev_html}

<div id="container-4" class="hconclusion">
{$conclusion_html}
</div>

<div id="imga-table-container">
<table class="imga-product-table" cellpadding="3">
<tbody>
<tr class="imga-product-item" data-id="{$json_data['id']}">
<td></td>
<td>
<span class="imgaFlexbox"><span class="imga-tablethumb"><img src="{$product_image}" alt="{$title}" title="{$title}" class="imga-image-small"></span><span class="imga-tabletext">{$title}</span></span>
</td>
<td>{$rating}</td>
<td><a href="https://www.amazon.com/dp/{$json_data['id']}/?tag={$aff_tag}" target="_blank" rel="nofollow noopener" class="imga-buy-button">View On Amazon</a></td>
</tr>
</tbody>
</table>
</div>


</div>
</div>

sdgkjdskfgdsdfiuksdgfds;


}
