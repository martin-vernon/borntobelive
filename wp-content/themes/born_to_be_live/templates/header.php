<header class="banner" role="banner">
  <div class="container">
    <?php if(function_exists('uberMenu_easyIntegrate')){
        uberMenu_easyIntegrate();
    }else{ ?>
        <a class="brand" href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a>
        <nav class="nav-main" role="navigation">
          <?php
            if (has_nav_menu('primary_navigation')) :
              wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav nav-pills'));
            endif;
          ?>
        </nav>
    <?php } ?>
  </div>
</header>