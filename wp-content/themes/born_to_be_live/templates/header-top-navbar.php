<header class="banner navbar navbar-static-top" role="banner">
    <div class="navbar-inner">
      <div class="container">

        <!-- Be sure to leave the brand out there if you want it shown -->
        <a class="brand hidden-phone" href="<?php echo home_url(); ?>/">
            <img src="<?php get_template_directory();?>/assets/img/btbl-logo-main.png" alt="Born To Be Live" />
        </a>

        <!-- Everything you want hidden at 940px or less, place within here -->
        <nav class="navigation" role="navigation">
            <?php
              if (has_nav_menu('primary_navigation')) :
                wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav pull-right'));
              endif;
            ?>
        </nav>

      </div>
    </div>
</header>
<?php if (function_exists('putRevSlider') && get_post_meta( get_the_ID(), '_revo_slider', true ) && get_post_meta( get_the_ID(), '_revo_slider', true ) != 'none' ) { ?> 
    <section class="hero-unit rev_slider hidden-phone">    
        <?php putRevSlider( get_post_meta( get_the_ID(), '_revo_slider', true ) ); ?>
    </section>
<?php } ?>