<?php

    function draw_child_slides( $atts ){
        extract( shortcode_atts( array(
	      'id'       => get_the_ID(),
              'title'     => 'Tiles Title',
              'titleTag'  => 'h4',
              'seperator' => false 
        ), $atts ) );
        
        $pagesArray = array('child_of'    => $id,
                            'parent'      => $id,
                            'post_type'   => 'page',
                            'post_status' => 'publish');
        $children = get_pages( $pagesArray );
        $x = 1;
        
        if( $children ){

            $output = '<'.$titleTag.'>'.$title.'</'.$titleTag.'>';
            $output .= ($seperator) ? '<div class="tile"><div class="wpb_separator wpb_content_element"></div></div>' : '';
            $output .= '<ul class="da-thumbs clearfix">';

            foreach ( $children as $child ){
                if( $child->post_excerpt ){
                    $childmeta = get_post_meta($child->ID);
                    $image     = wp_get_attachment_image_src( get_post_thumbnail_id( $child->ID ), 'full' );
                    $link      = get_permalink($child->ID);
                    $price     = ( getPrices($childmeta['PropBaseDevelopment'][0]) != '0' ) ? 'from <br/><strong>'.getPrices($childmeta['PropBaseDevelopment'][0]).'</strong>' : '<a href="'.$link.'" title="For more information on '.$child->post_title.' Click Here">more info<br/><strong>CLICK HERE</strong></a>';
                    $featured  = ( $childmeta['featured'][0] ) ? ' featured' : null;

                    $output .= '<!--	###############		-	SLIDE '.$x.'	-	###############	 -->
                                    <li>
                                        <a href="'.$link.'" title="For more information on '.$child->post_title.' Click Here">
                                            <img src="'.$image[0].'" />
                                            <div>
                                                <h3>'.$child->post_title.'</h3>
                                                <p>'.$child->post_excerpt.'</p>
                                                <p class="link">Click for more info</p>    
                                            </div>
                                        </a>
                                    </li>';
                    $x++;
                }
            }

            $output .= '</ul>';
        }else{
            $output .= '<p>Page ID: '.$id.' has No Page Children</p>';
        }
        
        return $output;
    }
    
    function draw_tiles_array( $atts ){
        extract( shortcode_atts( array(
	      'ids'       => get_the_ID(),
              'title'     => 'Tiles Title',
              'titleTag'  => 'h4',
              'seperator' => false 
        ), $atts ) );
        
        $pagesArray = array('include'     => $ids,
                            'sort_column' => 'ID',
                            'post_type'   => 'page',
                            'post_status' => 'publish');
        $children = get_pages( $pagesArray );
        $x = 1;

        if( $children ){

            $output = '<'.$titleTag.'>'.$title.'</'.$titleTag.'>';
            $output .= ($seperator) ? '<div class="tile"><div class="wpb_separator wpb_content_element"></div></div>' : '';
            $output .= '<ul class="da-thumbs clearfix">';

            foreach ( $children as $child ){
                if( $child->post_title ){
                    $image     = wp_get_attachment_image_src( get_post_thumbnail_id( $child->ID ), 'full' );
                    $link      = get_permalink($child->ID);
                    
                    $output .= '<!--	###############		-	SLIDE '.$x.'	-	###############	 -->
                                    <li>
                                        <a href="'.$link.'" title="For more information on '.$child->post_title.' Click Here">
                                            <img src="'.$image[0].'" />
                                            <div>
                                                <h3>'.$child->post_title.'</h3>
                                                <p>'.$child->post_excerpt.'</p>
                                                <p class="link">Click for more info</p>    
                                            </div>
                                        </a>
                                    </li>';
                    $x++;
                }
            }

            $output .= '</ul>';
        }else{
            $output .= '<p>Page ID: '.$id.' has No Page Children</p>';
        }
        
        return $output;
    }
    
    function draw_child_tables( $atts ){
        extract( shortcode_atts( array(
              'id'           => get_the_ID(),
	      'theme'        => 'theme1',
              'width'        => 920,
              'height'       => 440,
              'slideAmount'  => 4,
              'slideSpacing' => 0,
              'touchenabled' => 'on',
              'mouseWheel'   => 'on',
              'hoverAlpha'   => 'off',
              'slideshow'    => 0,
              'hovereffect'  => 'off',
              'tilestitle'   => 'Property Developments'
        ), $atts ) );
        
        $pagesArray = array('child_of'    => $id,
                            'parent'      => $id,
                            'post_type'   => 'page',
                            'post_status' => 'publish',
                            'meta_key'    => 'development',
                            'meta_value'  => 'true');
        $children = get_pages( $pagesArray );
        $x = 1;
        
        if( $children ){
            wp_enqueue_style( 
                'sp_child_slides', 
                get_template_directory_uri() .'/assets/css/child_slides.css' 
            );
            
            $output = '<div class="tables_wrapper">
                        <div class="tables_'.$theme.'">
                            <ul>';
        
            foreach ( $children as $child ){
                $childmeta = get_post_meta($child->ID);
                $link      = get_permalink($child->ID);
                $price     = ( getPrices($childmeta['PropBaseDevelopment'][0]) != '0' ) ? 'from <br/><strong>'.getPrices($childmeta['PropBaseDevelopment'][0]).'</strong>' : '<a href="'.$link.'" title="For more information on '.$child->post_title.' prices Click Here">Price Options<br/><strong>CLICK HERE</strong></a>';
                $featured  = ( $childmeta['featuredDev'][0] ) ? ' featured' : null;
                $points    = explode( ';', $childmeta['table_points'][0] );
                if($childmeta['development'][0]){
                    $output .= '<!--	###############		-	SLIDE '.$x.'	-	###############	 -->
                                <li>        
                                        <div class="table'.$featured.'">
                                            <div class="table-corner"></div>
                                            <div class="table-title">'.$childmeta['page_title'][0].'</div>
                                            <div class="table-info">
                                                <span class="top">'.$points[0].'</span>
                                                <span>'.$points[1].'</span>
                                                <span>'.$points[2].'</span>
                                                <span class="bottom">'.$points[3].'</span>
                                            </div>
                                            <div class="table-price">'.$price.'</div>
                                            <div class="table-link"><a class="more" href="'.$link.'" title="For more information on '.$child->post_title.' Click Here">View more</a></div>
                                        </div>';
    /*
                                        <!--
                                        ***********************************************************************************************************
                                                -	HERE YOU CAN DEFINE THE EXTRA PAGE WHICH SHOULD BE SHOWN IN CASE THE "BUTTON" HAS BEED PRESSED -
                                        ***********************************************************************************************************
                                        -->
                                        <div class="page-more">
                                                <img class="big-image" width="498" height="280" src="images/services/large1.jpg">
                                                <div class="details">
                                                        <h2>Our Strategy</h2>
                                                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labora et dolore magna.</p>
                                                        <p>At vero eou et accusam et justo duo dolores et ea rebum.<br>Stet clita kasd gubergen.</p>
                                                        <a class="buttonlight" href="#">Visit Website</a>
                                                </div>
                                                <div class="details">
                                                        <h2>Step Towards Success</h2>
                                                        <ul class="check">
                                                                <li>List Item Number One</li>
                                                                <li>List Item Number Two</li>
                                                                <li>List Item Number Three</li>
                                                                <li>List Item Number Four</li>
                                                        </ul>
                                                        <img src="images/certified.png">
                                                </div>
                                                <div  class="closer"></div>
                                        </div>  */
                        $output .= '</li>';
                    $x++;
                }
            }
 
            $output .= '</ul></div></div><script>
            jQuery(document).ready(function($){
                $(".tables_'.$theme.'").services({
                    width:'.$width.',
                    height:'.$height.',
                    slideAmount:'.$slideAmount.',
                    slideSpacing:'.$slideSpacing.',
                    touchenabled:"'.$touchenabled.'",
                    mouseWheel:"'.$mouseWheel.'",
                    hoverAlpha:"'.$hoverAlpha.'",
                    slideshow:'.$slideshow.',
                    hovereffect:"'.$hovereffect.'",
                    callBack:function() { }
                });
            });
            </script>';
        }
        
        return $output;
    }
    
    add_shortcode( 'child_slides' , 'draw_child_slides' );
    add_shortcode( 'child_tables' , 'draw_child_tables' );
    add_shortcode( 'tiles_array' , 'draw_tiles_array' );
    
    function getPrices($title = null){
        global $wpdb;
        if($title){
            $pricesSQL = 'select currencyISO, min(price) as minprice, max(price) as maxprice from properties where development like "%'.$title.'%"';
        
            $prices = $wpdb->get_row( $pricesSQL );
        
            return formatPrice($prices->minprice, $prices->currencyISO);
        }else{
            return false;
        }
    }
    
    function formatPrice($price, $currency=null){
        switch( $currency ){
            case 'Euro':
                $price = '&euro;'.number_format(round($price,0));
                break;
            case 'UAE Dirham':
                $price = 'AED '.number_format(round($price,0));
                break;
            case 'British Pound':
                $price = '&pound;'.number_format(round($price,0));
                break;
            default:
                $price = number_format(round($price,0));
                break;
        }
        return $price;
    }
   
?>
