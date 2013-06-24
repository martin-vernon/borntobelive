<footer class="expanded"><!-- add class 'expanded' for different type -->
    <div class="footer_img"></div>
    <div class="container">
        <div class="row" id="footer">
            <div class="span5">
                <div class="rightPad10 leftPad10">
                    <h3>Latest from the Blog</h3>
                    <ul class="blogRoll">
                        <?php $args = array( 'numberposts' => '3', 'category' => '-6' );
                        foreach( wp_get_recent_posts( $args ) as $post){
                            echo '<li><a href="' . get_permalink($post["ID"]) . '" title="Look '.esc_attr($post["post_title"]).'" >'.$post["post_title"].' - <strong><em>'.date("F d, Y",strtotime($post['post_date'])).'</em></strong></a></li>';
                        }?>
                    </ul>
                </div>
                <div class="rightPad10 leftPad10 followUs">
                    <h3>Follow Us</h3>
                    <a href="http://www.reverbnation.com/borntobelive" title="See us on ReverbNation"><img src="<?php get_template_directory();?>/assets/img/social_media/reverb.png" alt="Twitter icon" /></a>
                    <a href="http://www.youtube.com/user/borntobeliveltd" title="Visit Our YouTube Channel"><img src="<?php get_template_directory();?>/assets/img/social_media/youtube.png" alt="Twitter icon" /></a>
                    <a href="https://twitter.com/borntobe_live" title="Follow Us on Twitter"><img src="<?php get_template_directory();?>/assets/img/social_media/twitter.png" alt="Twitter icon" /></a>
                    <a href="https://www.facebook.com/pages/Born-To-Be-Live/308974599157063?fref=ts" title="See our Facebook Page"><img src="<?php get_template_directory();?>/assets/img/social_media/facebook.png" alt="Facebook icon" /></a>                 
                </div>
            </div>
            <div class="span3">
                <div class="rightPad10 leftPad10">
                    <h3>Want to Join Us?</h3>
                    <p>Do you want to join our team? BTBL are always looking for new talent in every area of performance. To find out more click <a href="<?= site_url('/about-us/');?>" title="Join Us">here.</a>
                </div>
            </div>
            <div class="span4">
                <div class="rightPad10 leftPad10">
                    <h3>Client Testimonials</h3>
                    <?= draw_category_slider(6,4,'testimonials'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_bottom">
        <div class="container">
            <div class="row">
                <div class="span4 footer_text">
                    &copy; <?= date('Y');?> Born to Be Live Ltd 
                </div>
                <div class="span8 hidden-phone">
                    <?php
                        if (has_nav_menu('secondary_navigation')) :
                            wp_nav_menu(array('theme_location' => 'secondary_navigation', 'menu_class' => 'footer_links pull-right'));
                        endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
