<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       patmir.com
 * @since      1.0.0
 *
 * @package    Paylane_Sf
 * @subpackage Paylane_Sf/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Paylane_Sf
 * @subpackage Paylane_Sf/admin
 * @author     Patryk Mirosław <miroslaw.patryk@gmail.com>
 */
class Paylane_Sf_Admin {
	private $plugin_slug;
	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_slug = "paylane-sf";
		// ustawienia

		add_action('admin_menu', array($this, 'add_plugin_menu'));

	}

 	function add_plugin_menu() {
        	add_options_page(
                    __('Paylane SF', $this->plugin_slug), __('Paylane SF', $this->plugin_slug), 'manage_options', $this->plugin_slug, array($this, 'display_plugin_settings')
            );
		}
		
	public function display_plugin_settings() {
		global $wp_roles;

		// save settings
		$this->save_plugin_settings();

		// show settings
		include_once(PAYLANE_SF_VIEWS_PATH . 'settings.php');
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/paylane-sf-admin.css', array(), $this->version, 'all' ); 
		wp_enqueue_style($this->plugin_name . '-bs', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',array(), $this->version, 'all');
	   

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {


		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/paylane-sf-admin.js', array( 'jquery' ), $this->version, false );
	//	wp_enqueue_script( $this->plugin_name, 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array( 'jquery' ), $this->version, false );

	}
	public function save_plugin_settings() {
		if (!empty($_POST) && !empty($_POST['options'])) {
			if (!wp_verify_nonce($_POST['_wpnonce'], 'paylane-sf-options')) {
				die(__('Security check.', $this->plugin_slug));
			}

			// DO SOME SANITIZATIONS
					$_POST['options']['kwoty']= sanitize_text_field($_POST['options']['kwoty']);
					$_POST['options']['mid']= sanitize_text_field($_POST['options']['mid']);
					$_POST['options']['salt']= sanitize_text_field($_POST['options']['salt']);
					$_POST['options']['submit']= sanitize_text_field($_POST['options']['submit']);
					$_POST['options']['url']= esc_url($_POST['options']['url']);
					
			

			$this->plugin_settings = $_POST['options'];
			update_option('paylane_sf_settings', $this->plugin_settings);
		}
	}
}
