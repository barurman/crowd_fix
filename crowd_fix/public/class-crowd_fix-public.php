<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://devdigital.pro
 * @since      1.0.0
 *
 * @package    Crowd_fix
 * @subpackage Crowd_fix/public
 */

// wpneo_crowdfunding_wc_login_form();


require_once( "partials/login/custom-ajax-auth.php" );




function insert_my_footer() {

	 ob_start();

	// start popup
	?>
	<button id="pop_login">Логин</button>
	<button href="#" id="pop_signup">Регистрация</button>
	<?
	include "partials/login/ajax-auth.php";
	?>
	<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
	<script src="//yastatic.net/share2/share.js"></script>
	<div class="ya-share2" data-services="vkontakte"></div>

	<? ob_end_flush();
	// end popup
	//die(1);
}

add_action('wp_footer', 'insert_my_footer');






/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Crowd_fix
 * @subpackage Crowd_fix/public
 * @author     DEVDIGITAL <info@devdigital.pro>
 */

class Crowd_fix_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Crowd_fix_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Crowd_fix_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name . 'formstyler', plugin_dir_url( __FILE__ ) . 'css/jquery.formstyler.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/crowd_fix-public.css', array(), $this->version, 'all' );


	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Crowd_fix_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Crowd_fix_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script('validate-script', plugin_dir_url( __FILE__ ) . 'js/jquery.validate.js', array('jquery') );
		wp_enqueue_script('validate-script');


		wp_register_script('formstyler', plugin_dir_url( __FILE__ ) . 'js/jquery.formstyler.min.js', array('validate-script') );
		wp_enqueue_script('formstyler');



		wp_register_script('ajax-auth-script', plugin_dir_url( __FILE__ ) . 'js/crowd_fix-public.js', array('formstyler') );
		wp_enqueue_script('ajax-auth-script');


		wp_localize_script( 'ajax-auth-script', 'ajax_auth_object', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'redirecturl' => home_url(),
			'loadingmessage' => __('Sending user info, please wait...')
		));

//		 wp_enqueue_script( $this->plugin_name . "libs" , plugin_dir_url( __FILE__ ) . 'js/jquery.validate.js', array( 'jquery' ), $this->version, false );

	}

}

