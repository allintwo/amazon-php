<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 6/12/2022
 * Time: 2:50 PM
 */


function add_this_script_footer_hamazon(){
    if ( is_single() ) {

        echo <<<sdhfdsfhdfhdsofhdsofds
 
<style>
.haccordion {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  text-align: left;
  border: none;
  outline: none;
  transition: 0.4s;
  border-bottom: 1px solid gray;
  border-top: 1px solid lightgray;
}

/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
.haccordion .active, .haccordion:hover {
  background-color: lightgray;
}

/* Style the accordion panel. Note: hidden by default */
.hpanel {
  padding: 0 18px;
  background-color: white;
  display: none;
  overflow: hidden;
  transition: max-height 1s ease-in-out;

}

.haccordion::after {
  content: '+';
  color: #777;
  font-weight: bold;
  float: right;
  margin-left: 5px;
  }
  .haccordion.active::after {
  content: "-";
  }
  
  .hamazon-container .imga-buy-button{
  width: 200px;
  }
  
  
.hamazon-container .mySlides {display: none;}
.hamazon-container img {vertical-align: middle;}

/* Slideshow container */
.hamazon-container .slideshow-container {
  height: 300px;
  position: relative;
  margin: auto;
}
.hamazon-container .slideshow-container img{
  height: 300px;
}

/* Caption text */
.hamazon-container .text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
  background-color: black;
}

/* Number text (1/3 etc) */
.hamazon-container .numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.hamazon-container .dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.hamazon-container .active {
  background-color: lightgray;
}

/* Fading animation */
.hamazon-container .fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}
  .hamazon-rsocre{
  font-size: 30px;
  }
  .hamazon-rsocre-div{
  margin: 20px;
  text-align: center;
  }
  .readmore-btn{
background: #007070;
border-radius: 25px;
color: #fff !important;
clear: both;
display: block;
font-size: 14px;
font-weight: 600;
margin: 15px 10px;
padding: 3px 10px;
text-align: center;
  }
  .readmore-btn:hover{
  background: #25dddd;
color: #000 !important;
  }
  
  
</style>


<script>
var acc = document.getElementsByClassName("haccordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    /* Toggle between adding and removing the "active" class,
    to highlight the button that controls the panel */
    this.classList.toggle("active");

    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
} 

// script for slider


let slideIndex = 0;
showSlides();
function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
 // let dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  // for (i = 0; i < dots.length; i++) {
  //  dots[i].className = dots[i].className.replace(" active", "");
  // }
  slides[slideIndex-1].style.display = "block";  
 // dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 6000); // Change image every 2 seconds
}

</script>

sdhfdsfhdfhdsofhdsofds;

    }
 }


//if ( is_single() ) {
//    add_action('wp_footer', 'add_this_script_footer_hamazon');
//}

//if (is_singular('post')) {
//    add_action('wp_footer', 'add_this_script_footer_hamazon');
//}

    add_action('wp_footer', 'add_this_script_footer_hamazon');