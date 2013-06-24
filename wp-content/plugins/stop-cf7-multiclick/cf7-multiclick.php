<?php
/*
Plugin Name: Stop CF7 Multiclick
Plugin URI: http://drzaus.com/plugin-2/wordpress-plugin-stop-cf7-multiclick
Description: Prevent Contact Form 7 from repeated submissions due to itchy trigger fingers.
Author: zaus
Author URI: http://drzaus.com/
Text Domain: cf7multiclick
Domain Path: /languages/
Version: 0.4.1
*/

class Cf7multiclick {

	/**
	 * Namespace
	 */
	const N = 'cf7multiclick';
	/**
	 * Plugin version
	 */
	const V = '0.4.1';

	public function __construct(){
		add_shortcode( self::N, array(&$this, 'shortcode_handler') );
		
		add_action('init', array(&$this, 'register_script'));
		
		// add hook to attach our custom onSubmit override (shouldn't this be part of the plugin?)
		add_filter( 'wpcf7_ajax_json_echo', array(&$this, 'ajax_results_append') );
	}
	
	
	public function register_script() {
		// our plugin "library"
		wp_register_script(self::N, plugins_url('cf7-multiclick.js', __FILE__), array('jquery'), self::V);
	}
	
	/**
	 * Trigger script inclusion
	 */
	public static $added_script;

	#region ------------- shortcodes -----------------

	/**
	 * Default shortcode attributes and other settings
	 */
	private function get_settings(){
		return array(
			'selector' => '.wpcf7-submit'	// the jquery targeting selector of the form submit button
			, 'load_script' => 'true'			// print scripts with the shortcode, set false to work around external plugin conflicts
			, 'use_script' => 'true'			// print the js function call; set false to work around external conflicts
		);
	}
	
	/**
	 * Registered shortcodes
	 */
	public function shortcode_handler( $attributes, $content=null, $code="" ) {
		
		// $attributes	::= array of attributes
		// $content ::= text within enclosing form of shortcode element
		// $code	::= the shortcode found, when == callback name
		// examples: [my-shortcode]
		//			[my-shortcode/]
		//			[my-shortcode foo='bar']
		//			[my-shortcode foo='bar'/]
		//			[my-shortcode]content[/my-shortcode]
		//			[my-shortcode foo='bar']content[/my-shortcode]
	
		//parse out options, merge with default attributes
		//$wp_flexiSelector_defaults = wp_flexiSelector_get_default_options();
		$attributes = shortcode_atts( $this->get_settings(), $attributes );
		
		// -------- trap output --------
					ob_start();
		// -------- trap output --------
		
		// use output method
		$this->render_shortcode( $attributes );
		
		// -------- trap output --------
				return ob_get_clean();
		// -------- trap output --------
	}//--	fn	shortcode_handler
	
	/**
	 * Internal shortcode processing: actually prints the html
	 * @param array $attributes a list of attributes (as parsed from the shortcode); NOTE: you'll need to explicitly provide defaults
	 * 
	 * @return nothing, prints the shortcode
	 */
	public function render_shortcode( $attributes ) {
		##self::$add_script = true;	// trigger script once
		
		//extract( $attributes );	// unnecessary here
		
		// trigger once in place, but only if not disallowed by shortcode attribute
		// see http://twentyfiveautumn.com/2012/03/14/loading-javascript-on-the-frontend-with-your-wordpress-plugin/
		if( 'true' == $attributes['load_script'] && ! self::$added_script ){
			wp_print_scripts(self::N);
			// dequeue required scripts since they're here
			self::$added_script = true;
		}
		
	
		// ... do something with the $atts
		
		// hook - adjust attributes used to render the countdown
		###$attributes = apply_filters( self::N . '_pre_render', $attributes );
		
		// only call here if requested (so we can use both parts in different places)
		if( 'true' == $attributes['use_script'] ) :
		?>
		<script>
			window.cf7multiclick.pauseable('<?php echo $attributes['selector'] ?>');
		</script>
		<?php
		endif;
		
		// hook - add "before", "after"; alter rendered output
		###$rendered = apply_filters( self::N . '_post_render', $rendered, $attributes );
		
	}//--	fn	render_shortcode
	
	#endregion ------------- shortcodes -----------------

	/**
	 * add_filter: Attach (reattach) missing onSubmit callback
	 * @param array $items the callback response items
	 * @param array $results the wpcf7 submission result
	 *
	 * @return array the $items
	 */
	public function ajax_results_append($items, $results = false){
		global $wpcf7_contact_form;
		
		$items['onSubmit'] = $wpcf7_contact_form->additional_setting( 'on_submit', false );
		
		// send it back because it's a filter
		return $items;
	}
	
}///---	class	Cf7multiclick

// engage
$cf7multiclick = new Cf7multiclick();