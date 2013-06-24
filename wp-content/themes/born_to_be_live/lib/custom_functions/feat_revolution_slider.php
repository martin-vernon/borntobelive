<?php

// function to add the facility to pick a Revolution Slider as a Feature

//if( is_plugin_active( 'revslider/revslider.php' ) ){
    add_action( 'add_meta_boxes', 'page_revo_slider' );
    add_action( 'save_post', 'page_revo_slider_save' );
//}

function page_revo_slider(){
    add_meta_box(
        'page_revo_slider_sectionid',
        __( 'Featured Revolution Slider', 'myplugin_textdomain' ),
        'page_revo_slider_box',
        'page',
        'side'
    );
}

function page_revo_slider_box( $post ){
  global $wpdb;
    
  $revo_slider_sql = $wpdb->get_results( "SELECT * FROM wp_revslider_sliders;" );
  
  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'revo_slider_noncename' );

  // The actual fields for data entry
  // Use get_post_meta to retrieve an existing value from the database and use the value for the form
  $value = get_post_meta( $post->ID, '_revo_slider', true );
  
  $html = '<label for="slider">Set featured Revolution Slider</label>
           <select name="revo_slider">
            <option value="none">No Slider Selected</option>';
  foreach ( $revo_slider_sql as $slider ) {
      $selected = ($value == $slider->alias) ? 'selected="selected"' : '';
      $html .= '<option value="'.$slider->alias.'" '.$selected.'>'.$slider->title.'</option>';
  }
  $html .= '</select>
      <br /><br /><a href="'.admin_url( 'admin.php?page=revslider' ).'" title="View / Edit Revolution Sliders">View / Edit Revolution Sliders</a>';
  echo $html;
}

/* When the post is saved, saves our custom data */
function page_revo_slider_save( $post_id ) {

  // First we need to check if the current user is authorised to do this action. 
  if ( ! current_user_can( 'edit_page', $post_id ) )
      return;

  // Secondly we need to check if the user intended to change this value.
  if ( ! isset( $_POST['revo_slider_noncename'] ) || ! wp_verify_nonce( $_POST['revo_slider_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  // Thirdly we can save the value to the database

  //if saving in a custom table, get post_ID
  $post_ID = $_POST['post_ID'];
  //sanitize user input
  $mydata = sanitize_text_field( $_POST['revo_slider'] );

  // Do something with $mydata 
  // either using 
  add_post_meta($post_ID, '_revo_slider', $mydata, true) or
    update_post_meta($post_ID, '_revo_slider', $mydata);
  // or a custom table (see Further Reading section below)
}
?>
