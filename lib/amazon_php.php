<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 5/26/2022
 * Time: 4:17 PM
 */




class amazon_php{

    public $title = '';
    public $id = '';
    public $image ='';
    public $images = [];
    public $videos = [];
    public $rating = '';
    public $rating_txt = '';
    public $rating_count = '';
    public $answers = [];
    public $answers_count = '';
    public $reviews = [];
    public $reviews_count = '';

    public $description = '';
    public $details = '';
    public $features = '';

    public $categorys = '';
    public $tags = '';




    function get_product_info($product_id)
    {

        $this->id = $product_id;

        //   if($k>=$items) break;
        $productLink = "https://www.amazon.com/dp/{$product_id}/ref=sspa_dk_detail_3?pd_rd_i=B07W86N3JV&pd_rd_w=uMrD2&content-id=amzn1.sym.3be1c5b9-5b41-4830-a902-fa8556c19eb5&pf_rd_p=3be1c5b9-5b41-4830-a902-fa8556c19eb5&pf_rd_r=KCCT6MCYM2BPFB0S68P4&pd_rd_wg=gY7aI&pd_rd_r=8a9da21e-1594-4fb5-95df-5097fdf2aa4b&s=pc&spLa=ZW5jcnlwdGVkUXVhbGlmaWVyPUE1S0FTSlVONUs5RzMmZW5jcnlwdGVkSWQ9QTAzMTMxMjcyWVFHRlEwRUJVN01IJmVuY3J5cHRlZEFkSWQ9QTA0Mzg2OTZSVldJTkxRODZJMTcmd2lkZ2V0TmFtZT1zcF9kZXRhaWwmYWN0aW9uPWNsaWNrUmVkaXJlY3QmZG9Ob3RMb2dDbGljaz10cnVl&th=1" ;

        //$productData = file_get_contents( $amazon . $productLink );
      // $productData = $this->curlx( $productLink );

        $debug = 0;
        $dfile = 'page.txt';

        if($debug)
        {

            if(is_file($dfile))
            {
                $productData = file_get_contents($dfile);
            }else{
                $productData = $this->func_get_content( $productLink );
                file_put_contents($dfile,$productData);
            }
        }else{
            $productData = $this->func_get_content( $productLink );
        }

       // echo $productData;exit;

        $xdom = str_get_html($productData);


        // get title

        $title = $xdom->find('span#productTitle',0)->plaintext;
        $this->title = trim( $title);

        $rating = $xdom->find('span#acrPopover',0)->attr['title'];
        $this->rating = $rating;
        $this->rating_txt = $rating;
        if(preg_match('#(\d\.\d) out of #',$rating,$mtc))
        {
            $this->rating = $mtc[1];
        }

        $total_rating = $xdom->find('span#acrCustomerReviewText',0)->plaintext;
        $this->rating_count = $total_rating;
        if(preg_match('#(.*) ratings#',$total_rating,$mtc))
        {
            $this->rating_count = $mtc[1];
        }

        $answers_count = $xdom->find("a#askATFLink",0)->plaintext;
        $this->answers_count = $answers_count;
        if(preg_match('#(\d+) answered#',$answers_count,$mtc))
        {
            $this->answers_count = $mtc[1];
        }

        $image = '';
        if(preg_match('/"large":"(.*?)"/',$productData,$mtc))
        {
            $image = $mtc[1];
            $this->image = $image;
            $this->images = [$image];
        }
        // images
        if(preg_match_all('/"large":"(.*?)"/',$productData,$mtcs))
        {
            foreach ($mtcs[1] as $mtc)
            {
                $this->images[] = $mtc;
            }
        }
        shuffle($this->images);

       // print_r($this->images);return;


        // $productFeature = imga_get_match('/<div id=\"feature-bullets\" \b[^>]*>(\s+)<ul \b[^>]*>(.*)<\/ul>/isU', $productData, 2);
        $productFeature = $xdom->find('div#feature-bullets',0)->innertext;
        //$productFeature = imga_get_match('/<li\s?\b[^>]*>(.*)<\/li>/isU', $productFeature[0]);
        /*$productFeature = imga_get_match('/<li\s?[^>]*?>(.*)<\/li>/isU', $productFeature[0]);*/
        $productFeature = $this->imga_get_match('/<li(?=>)[^>]*?>(.*)<\/li>/isU', $productFeature);
        $productFeature = preg_replace('/<a \b[^>]*>(.*)<\/a>/isU', '<span class="linkRemove">$1</span>', $productFeature);


        $productDescription_ = $this->imga_get_match('/<div id=\"dpx-aplus-product-description_feature_div\">(.*)<div id=\"dpx-aplus-3p-product-description_feature_div\">/isU', $productData);
        $productDescription = !empty($productDescription_[0])? preg_replace('/(\s+)/',' ', $productDescription_[0]) : '';
        $productDescription = !empty(trim($productDescription, " \r\n\t"))? '<div id="imgaproductDescription">'.$productDescription : '';

        $productDescription1_ = $this->imga_get_match('/<div id=\"dpx-aplus-3p-product-description_feature_div\">(.*)<div id=\"dpx-window-blind-disclaimer_feature_div\">/isU', $productData);
        $productDescription1 = !empty($productDescription1_[0])? preg_replace('/(\s+)/',' ', $productDescription1_[0]) : '';
        $productDescription1 = !empty(trim($productDescription1, " \r\n\t"))? '<div id="imgaproductDescription">'.$productDescription1 : $productDescription;

        $productDescription2_ = $this->imga_get_match('/<div id=\"descriptionAndDetails\" \b[^>]*>(.*)<div id=\"featurebulletsbtf\"/isU', $productData);
        $productDescription2 = !empty($productDescription2_[0])? preg_replace('/(\s+)/',' ', $productDescription2_[0]) : '';
        $productDescription2 = !empty(trim($productDescription2, " \r\n\t"))? '<div id="imgaproductDescription">'.$productDescription2 : $productDescription1;

        $productDescription3_ = $this->imga_get_match('/<div id=\"productDescription\" \b[^>]*>(.*)<style/isU', $productData);
        $productDescription3 = !empty($productDescription3_[0])? preg_replace('/(\s+)/',' ', $productDescription3_[0]) : '';
        $productDescription3 = !empty(trim($productDescription3, " \r\n\t"))? '<div id="imgaproductDescription">'.$productDescription3 : $productDescription2;
        $productDescription3 = preg_replace('/<a \b[^>]*>(\s+)?See all Product description<\/a>/', '', $productDescription3);
        $productDescription3 = preg_replace('/<a \b[^>]*>(.*)<\/a>/isU', '<span class="linkRemove">$1</span>', $productDescription3);
        $productDescription3 = preg_replace('/<script(.*)<\/script>/is','', $productDescription3);
        $productDescription3 = preg_replace('/<style(.*)<\/style>/is','', $productDescription3);
        $productDescription3 = preg_replace('/<h(1|2|3|4|5|6)>Product description<\/h(1|2|3|4|5|6)>/is','',$productDescription3);
        $productDescription3 = strip_tags($productDescription3, '<h2><h3><h4><p><ul><li><span><strong><em><i><table><tr><td><th>');
        $productDescription3 = preg_replace('/(\s+)/',' ', $productDescription3);
        $productDescription3 = preg_replace('/(<p>\s+<\/p>)/is','', $productDescription3);
        $productDescription3 = preg_replace('/(<h(1|2|3|4|5|6)>Amazon\.com<\/h(1|2|3|4|5|6)>)/is','', $productDescription3);

        $shortdesc = $this->imga_get_match('/<p>(.*)<\/p>/isU', $productDescription3);
        $shortdesc = !empty($shortdesc[0])? trim($shortdesc[0], " \r\n\t") : '';
        $shortdesc = preg_replace('/<h(1|2|3|4|5|6)>(\w+)<\/h(1|2|3|4|5|6)>(.*)/is','$2:$4', $shortdesc);
        $shortdesc = strip_tags($shortdesc,'<p>');

        $productDetails2_ = $this->imga_get_match('/<div id=\"productDetails_feature_div\" \b[^>]*>(.*)<link rel/isU', $productData);
        $productDetails2 = !empty($productDetails2_[0])? preg_replace('/(\s+)/',' ', $productDetails2_[0]) : '';
        $productDetails2 = !empty($productDetails2)? '<div id="amzomotion-product-details">'.$productDetails2 : '';

        $productDetails_ = $this->imga_get_match('/<div id=\"product-details-grid_feature_div\">(.*)<div id=\"va-related-videos-widget_feature_div\">/isU', $productData);
        $productDetails = !empty($productDetails_[0])? '<div id="amzomotion-product-details">'.$productDetails_[0] : $productDetails2;

        $productDetails = preg_replace('/<a href="(\w+)" \b[^>]*>(\s*?)User Manual(\s*?)<\/a>/isU','<span clas="userManual" href="$1">User Manual</span>', $productDetails);
        $productDetails = preg_replace('/(\s+)/',' ', $productDetails);
        $productDetails = preg_replace('/(<p>\s+<\/p>)/','', $productDetails);
        $productDetails = preg_replace('/<a \b[^>]*>(.*)<\/a>/isU','<span clas="linkRemove">$1</span>', $productDetails);
        $productDetails = preg_replace('/<script(.*)<\/script>/','', $productDetails);
        $productDetails = preg_replace('/<style(.*)<\/style>/','', $productDetails);
        $productDetails = strip_tags($productDetails,'<div><span><p><ol><ul><li><h1><h2><h3><h4><h5><h6><em><i><strong><table><tr><td><th>');
        $productDetails = preg_replace('/<h1 class=\"a-size-medium a-spacing-small secHeader\"> Feedback <\/h1>(.*)<\/table>/', '', $productDetails);
        $productDetails = preg_replace('/(\s+)/',' ', $productDetails);

        $productSeller = $this->imga_get_match('/<div id=\"bylineInfo_feature_div\" \b[^>]*>(.*)<\/div>/isU', $productData);
        $seller = $this->imga_get_match('/<a \b[^>]*>(.*)<\/a>/isU', $productSeller[0]);
        $seller = trim($seller[0], ' ');

        $sellerLink = $this->imga_get_match('/href=\"(.*)\"/isU', $productSeller[0]);
        $sellerLink = $sellerLink[0];
        $features = '';

        if(!empty($productFeature)){
            foreach($productFeature as $f){
                $f = preg_replace('/<a \b[^>]*>(.*)<\/a>/isU', '<span class="linkRemove">$1</span>', $f);
                $f = preg_replace('/(\r|\n|\t|\s+)/', ' ', $f);
                $features .= '<li>'.trim($f, " \r\n\t").'</li>';
            }
        }else{

            $features .= '<li>Please See This Product Details On Amazon.</li>';
        }

        $features = $features ? '<ul class="amazomotion-product-feature">'.$features.'</ul>' : '';
        $features = preg_replace('/(\s+)/',' ', $features);
        $features = preg_replace('/(<p>\s+<\/p>)/','', $features);
        $features = preg_replace('/<a \b[^>]*>(.*)<\/a>/isU','<span clas="link-remove">$1</span>', $features);

        $productCategories = $this->imga_get_match('/<div id=\"wayfinding-breadcrumbs_feature_div\" \b[^>]*>(.*)<ul \b[^>]*>(.*)<\/ul>/isU', $productData, 2);
        $productCategories = !empty($productCategories[0])? $productCategories[0]: '';
        $productCategories = $this->imga_get_match('/<li>(.*)<\/li>/isU', $productCategories);

        $productCats = array();
        $productTags = array();
        $catindex = 0;
        foreach($productCategories as $i=>$cat){
            $catindex++;
            $pcat = preg_replace('/\s+/',' ', strip_tags($cat));
            $pcat = trim($pcat, ' ');
            if($i<=1) $productCats[$catindex] = $pcat;
            if($i>1){
                $productTags[$catindex] = $pcat;
            }
        }

        // $productCats = implode(',',$productCats);
        // $productTags = implode(',',$productTags);


        $k = 0;
       /// $results[$k] = $product_id;
        $results[$k]['categories'] = $productCats;
        $results[$k]['tags'] = $productTags;

        $results[$k]['seller'] = $seller;
        $results[$k]['sellerLink'] = $sellerLink;
        $results[$k]['featurs'] = $features;
        $results[$k]['shortdesc'] = $shortdesc;
        $results[$k]['description'] = $productDescription3;
        $results[$k]['details'] = $productDetails;
        $results[$k]['code'] = 200;
        $results[$k]['date'] = date("y-m-d h:i:s");

        $this->features = $features;
        $this->description = $productDescription3;
        $this->details = $productDetails;

        $this->categorys = $productCats;
        $this->tags = $productTags;
        $this->reviews = $this->get_reviews($product_id);
        $this->answers = $this->get_questions($product_id);


        // videos
        if(1)
        {
            $pattarn = '#data-video-url="([^"]+)"#';
            if(preg_match_all($pattarn,$productData,$mtcs))
            {
                foreach ($mtcs[1] as $mtc)
                {
                    $this->videos[md5($mtc)] = $mtc;
                }
            }
        }


        return $results;
    }






    public function get_questions($product_id,$question_limit = 15)
    {
        $each_page = 10;

        $ret_q = [];
        for($i=1;$i<3;$i++)
        {
           // $url = "https://www.amazon.com/ask/questions/asin/{$product_id}/ref=cm_cd_dp_lla_ql_ll";
            $url = "https://www.amazon.com/ask/questions/asin/{$product_id}/{$i}/ref=ask_ql_psf_ql_hza";
            $webpage = $this->func_get_content($url);
            $xdom = str_get_html($webpage);

            // $quss = $xdom->find('div.askTeaserQuestions div.a-fixed-left-grid.a-spacing-base');
            $quss = $xdom->find('div.a-section.askTeaserQuestions div.a-fixed-left-grid.a-spacing-base div.a-fixed-left-grid-inner div.a-fixed-left-grid-col.a-col-right');



            foreach ($quss as $que)
            {
                $a = $que->find('div.a-fixed-left-grid.a-spacing-base div.a-fixed-left-grid-inner div.a-fixed-left-grid-col.a-col-right span',0);
                if(isset($a))
                {
                    $q = $que->find('a.a-link-normal span.a-declarative',0);

                    $ans = $a->plaintext;
                    $ans = trim($ans);
                    $ans = str_replace('                    see less','',$ans);
                    $ans = str_replace('                    see more                                ','',$ans);

                    $q = trim($q->plaintext);
                    $qhsah = md5($q);

                    $ret_q[$qhsah] = [$q,$ans];

                    //echo "<b>{$q->plaintext}</b><i>{$ans}</i><hr>";
                }
            }

        }



        return  array_slice($ret_q,0,$question_limit);

    }




    public function get_reviews($product_id,$reviews_limit = 10)
    {
        $url = "https://www.amazon.com/545/product-reviews/{$product_id}/ref=cm_cr_dp_d_show_all_btm?ie=UTF8&reviewerType=all_reviews";
        $url = "https://www.amazon.com/HyperX-Alloy-Origins-Software-Controlled-Customization/product-reviews/{$product_id}/ref=cm_cr_getr_d_paging_btm_2?ie=UTF8&filterByStar=positive&pageNumber=1&reviewerType=all_reviews&pageSize=10";
        $webpage = $this->func_get_content($url);
        $xdom = str_get_html($webpage);

       // $quss = $xdom->find('div.askTeaserQuestions div.a-fixed-left-grid.a-spacing-base');
        $quss = $xdom->find('div#cm_cr-review_list div');

        $ret_q = [];

        foreach ($quss as $que)
        {
            $a = $que->find('div.a-row.a-spacing-small.review-data span.a-size-base.review-text.review-text-content',0);
            if(isset($a))
            {
                $q = $que->find('div.a-row a.a-size-base.a-link-normal.review-title.a-color-base.review-title-content.a-text-bold',0);

                $ans = $a->plaintext;
                $ans = trim($ans);
                $q = trim($q->plaintext);
              //  $ans = str_replace('                    see less','',$ans);
               // $ans = str_replace('                    see more                                ','',$ans);

                $thash = md5(trim($q));

                $ret_q[$thash] = [$q,$ans];

            // echo "<b>{$q->plaintext}</b><i>{$ans}</i><hr>";
            }


        }

       // print_r($ret_q);
        return $ret_q;

    }



    function imga_get_match($regex,$content, $m=1){
        preg_match_all($regex,$content,$matches);
        return $matches[$m];
    }


    function func_get_content($myurl, $method = 'get', $posts = [], $headers = [],$encoding=0)
    {

        sleep(rand(0,3));
        $host = parse_url(urldecode($myurl))['host'];
        //   /*
        if($headers == [])
        {
            $headers = [
                "Host: ".$host,
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0".rand(0,999999),
                "Accept-Language: en-US,en;q=0.5",
                // "Accept-Encoding: gzip, deflate, br",
                "Connection: keep-alive",
                "Upgrade-Insecure-Requests: 1",
                "TE: Trailers",];
        }
        // */

        $myurl = str_replace(" ","%20",$myurl);
        // global $range;
        $ch = curl_init();

        //  $agent = 'tab mobile';
        // curl_setopt($ch, CURLOPT_PROXY, '85.26.146.169:80');
        curl_setopt($ch, CURLOPT_URL, $myurl);
        // curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);

        //  curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
        //  curl_setopt( $ch, CURLOPT_COOKIEFILE,dirname(__FILE__) . '/cookie.txt');
        //  curl_setopt($ch, CURLOPT_HEADER, true); // header
        // curl_setopt($ch, CURLOPT_NOBODY, true); // header
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        //  curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_RANGE, $range);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch,CURLOPT_TIMEOUT , 60);
        # sending manually set cookie
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if($method != 'get')
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($posts));
        }

        //  curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"serialno\":\"$code\"}");


        //   $error = curl_error($ch);
        $result = curl_exec($ch);
        curl_close($ch);
        if($encoding)
        {
            return mb_convert_encoding($result, 'utf-8','auto');
        }

        // debug
        //  file_put_contents($this->ROOT.'/webpage.txt',$result);

        return $result;
        //  return mb_convert_encoding($result, 'UTF-8','auto');
    }

    function curlx($url){
        $options = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"User-Agent: ".$this->random_user_agent()."\r\n"
            )
        );
        $context = stream_context_create($options);

        if (false !== ($html = @file_get_contents($url, false, $context))){
            $data = $html;
            //Header response Variable $http_response_header
        }else{
            $ch = curl_init();
            $timeout = 300;
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_COOKIESESSION => true,
                CURLOPT_COOKIEJAR => '',
                CURLOPT_COOKIEFILE => '',
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => $timeout,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_POSTFIELDS => '{}',
                CURLOPT_USERAGENT => $this->random_user_agent(),
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FRESH_CONNECT => true,
                CURLOPT_CONNECTTIMEOUT => 3000,
                CURLOPT_MAX_SEND_SPEED_LARGE => 100000,
                CURLOPT_MAX_RECV_SPEED_LARGE => 100000,
                CURLOPT_VERBOSE => 0,
                CURLOPT_POST => false
            ));
            $data = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);
        }
        return $data;
    }

    function random_user_agent(){
        $agent = array(
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/74.0.3729.157 Safari/537.36',
            'Mozilla/5.0 (X11; Datanyze; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36',
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:49.0) Gecko/20100101 Firefox/49.0',
            'Mozilla/5.0 (X11; Fedora;Linux x86; rv:60.0) Gecko/20100101 Firefox/60.0',
            'Opera/9.80 (Linux armv7l) Presto/2.12.407 Version/12.51 , D50u-D1-UHD/V1.5.16-UHD (Vizio, D50u-D1, Wireless)',
            'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9a1) Gecko/20070308 Minefield/3.0a1'

        );
        $max = count($agent)-1;
        $i = rand(0, $max);
        return $agent[$i];
    }
    function imga_sortcount($a, $b) {
        return strcmp($a->count, $b->count);
    }
}

class amazon_product_data extends amazon_php {




    function get_response()
    {

        $retval = [
            'id' => $this->id,
            'title'=>$this->title,
            'image' => $this->image,
            'images' => $this->images,
            'videos' => $this->videos,
            'rating' => $this->rating,
            'rating_txt' => $this->rating_txt,
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


        return $retval;

    }




    function func_get_content($myurl, $method = 'get', $posts = [], $headers = [],$encoding=0)
    {

        sleep(rand(0,3));
        $host = parse_url(urldecode($myurl))['host'];
        //   /*
        if($headers == [])
        {
            $headers = [
                "Host: ".$host,
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0".rand(0,999999),
                "Accept-Language: en-US,en;q=0.5",
                // "Accept-Encoding: gzip, deflate, br",
                "Connection: keep-alive",
                "Upgrade-Insecure-Requests: 1",
                "TE: Trailers",];
        }
        // */

        $myurl = str_replace(" ","%20",$myurl);
        // global $range;
        $ch = curl_init();

        //  $agent = 'tab mobile';
        // curl_setopt($ch, CURLOPT_PROXY, '85.26.146.169:80');
        curl_setopt($ch, CURLOPT_URL, $myurl);
        // curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);

        //  curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
        //  curl_setopt( $ch, CURLOPT_COOKIEFILE,dirname(__FILE__) . '/cookie.txt');
        //  curl_setopt($ch, CURLOPT_HEADER, true); // header
        // curl_setopt($ch, CURLOPT_NOBODY, true); // header
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        //  curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_RANGE, $range);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch,CURLOPT_TIMEOUT , 60);
        # sending manually set cookie
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if($method != 'get')
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($posts));
        }

        //  curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"serialno\":\"$code\"}");


        //   $error = curl_error($ch);
        $result = curl_exec($ch);
        curl_close($ch);
        if($encoding)
        {
            return mb_convert_encoding($result, 'utf-8','auto');
        }

        // debug
        //  file_put_contents($this->ROOT.'/webpage.txt',$result);

        return $result;
        //  return mb_convert_encoding($result, 'UTF-8','auto');
    }
}