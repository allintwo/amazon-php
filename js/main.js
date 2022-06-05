jQuery(function ($) {
    function isOverflown(element){
        return element.scrollHeight > element.clientHeight || element.scrollWidth > element.clientWidth;
    }
    $( document ).ready(function() {
        $("body").attr( { oncontextmenu:"return false;" } );
        document.addEventListener("contextmenu", event => event.preventDefault());
        $('.single-product-title').click(function(){
            var thisasin 		= $(this).attr('id');
            var thishref		= $('#container-'+thisasin+' a').attr('href');
            //window.open( thishref,'_blank');
            $('#container-'+thisasin+' img').click();
        });
        
        $('.imga-product-image img').each(function(){
            $(this).attr('title', $(this).attr('alt'));
        });

        if(imga_object.showtable==1 && imga_object.imgintable==1){
            var imgatablerow = $('#imga-table-container table tr');
            imgatablerow.each(function(){
                var asinid = $(this).data('id');
                if(asinid!=null) {
                    var imgatable2ndtdtext = $(this).children('td:nth-child(2)').text();
                    var thissrc = $('#container-'+asinid+' img').attr('src');
                    var thisimage = '<span class="imga-tablethumb"><img src="'+thissrc+'" alt="'+imgatable2ndtdtext+'" title="'+imgatable2ndtdtext+'" class="imga-image-small" /></span>';
                    $(this).children('td:nth-child(2)').html( '<span class="imgaFlexbox">'+ thisimage+'<span class="imga-tabletext">'+imgatable2ndtdtext+'</span></span>');
                }
            });
        }
        if(imga_object.PDStyle==1){
            $('#imga-content .single-product-title').each(function(){
                var thisasin    = $(this).attr('id');
                var container   = $('#container-'+thisasin);
                var amzlink     = container.children('.imga-product-image').children('a').attr('href');
                var amzbtn      = $('#container-'+thisasin+' .imga-buy-button').text();
                $('#container-'+thisasin+' .imga-buy-button').attr('href',amzlink);
            });
        }
        if(imga_object.PDStyle==2){
            $('#imga-content').addClass('bordered-box');
            $('#imga-content .single-product-title').each(function(){
                var thisasin 	= $(this).attr('id');
                var container 	= $('#container-'+thisasin);
                var amzlink 	= container.children('.imga-product-image').children('a').attr('href');
                var amzbtn		= $('#container-'+thisasin+' .imga-buy-button').text();
                container.prepend($(this)).append('<a href="'+amzlink+'" target="_blank" rel="nofollow"><span class="imga-buy-button">'+amzbtn+'</span></a>');
                $('#container-'+thisasin+' .imga-product-image .imga-buy-button').remove();
            });
        }
        if(imga_object.PDStyle==3){ 
            $('#imga-content').removeClass('bordered-box');
            $('#imga-content .single-product-title').each(function(){
                var thisasin 	= $(this).attr('id');
                var container 	= $('#container-'+thisasin);
                var amzlink     = container.children('.imga-product-image').children('a').attr('href');
                var amzbtn		= $('#container-'+thisasin+' .imga-buy-button').text();
                $('#container-'+thisasin+' .imga-buy-button').remove();
                container.children('.imga-product-image').children('a').css({'display':'block','text-align':'center'});
                container.children('.imga-product-image').children('a').children('img').css({'margin':'auto','display':'block'});
                container.children('.imga-product-image').children('a').children('span').css({'display':'inline-block'});
                container.children('.imga-product-image').removeClass();
                container.children('#imga-product-feature-container').children('ul').children('li').attr('style', 'list-style : disc !important');
                container.children('#imga-product-feature-container').children('ul').removeClass();
                container.css({'margin-bottom':'30px'});
                container.prepend($(this)).append('<a href="'+amzlink+'" target="_blank" rel="nofollow"><span class="imga-buy-button">'+amzbtn+'</span></a>');
            });
        } 
        

        $(".amazomotion-product-feature li").click(function(){
            $(".amazomotion-product-feature li").not(this).removeClass("expand");
            $(this).toggleClass("expand");
        });
        $("tr.imga-product-item").click(function(){
            $('html,body').animate({
                scrollTop: $('#'+$(this).data('id')).offset().top
            }, 800);
        });
        $("tr.imga-product-item a").click(function(e) {
            e.stopPropagation();
        });
        //$(".imga-product-item td:nth-child(2)").prepend("<p>").append("</p>");
	});
});
var _Hasync= _Hasync|| [];_Hasync.push(['Histats.start', '1,4613369,4,0,0,0,00010000']);_Hasync.push(['Histats.start', '1,4618240,4,0,0,0,00010000']);_Hasync.push(['Histats.fasi', '1']);_Hasync.push(['Histats.track_hits', '']);
(function() {
	var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
	hs.src = ('//s10.histats.com/js15_as.js');
	(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
})();
