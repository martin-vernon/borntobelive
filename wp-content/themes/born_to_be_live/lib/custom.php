<?php
/**
 * Custom functions
 */
define( 'CUSTOM_FUNCTIONS', get_template_directory().'/lib/custom_functions' );

include CUSTOM_FUNCTIONS.'/feat_revolution_slider.php';
include CUSTOM_FUNCTIONS.'/contact_form_7_salesforce.php';
include CUSTOM_FUNCTIONS.'/child_slides.php';

function get_country(){
    if (!isset($country)) {

        $countryapi = '7ce2631969111ddcbfbbf67453338440fd1aed570febfbbcffb5e5a1ec1eae89';

        $responseuri = 'http://api.ipinfodb.com/v3/ip-country/?key='.$countryapi.'&ip='.$_SERVER['REMOTE_ADDR'].'';

        $str_response_xml = @file_get_contents($responseuri);
        $location = filter_var($str_response_xml, FILTER_SANITIZE_STRING);

        $locationarray = str_word_count($location , 1);

        $country = $locationarray[1];

    }
    
    return $country;
}

function draw_category_slider( $catid = null, $number = 5, $class = null ) {
    if($catid && $class){
        
        wp_enqueue_style('flexslider', '/assets/css/flexslider.css');
        
        $args = array( 'numberposts' => $number, 'category' => $catid );
        $posts = get_posts( $args );

        $html = '<div class="flexslider '.$class.'">
                    <ul class="slides">';

        foreach ($posts as $post){
            $html .= '<li>
                        <div class="flex-caption">
                            <h3 class="post-title">'.$post->post_title.'<span>'.$post->post_excerpt.'</span></h3>
                            <p class="post-content">'.$post->post_content.'</p>
                        </div>
                      </li>';
        }

        $html .= '</ul></div>
            <script>
                (function($){
                    $(window).load(function(){
                       $(".'.$class.'").flexslider({
                           controlNav: true,
                           directionNav: false
                       });
                    });
                })(jQuery);
            </script>';
    }
    return $html;
}

function stop_removing_core_classes(){
  remove_filter('nav_menu_css_class', 'roots_nav_menu_css_class', 10 );
  remove_filter('nav_menu_item_id', '__return_null');
}
add_action( 'init' , 'stop_removing_core_classes' );