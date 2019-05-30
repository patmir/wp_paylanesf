<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       patmir.com
 * @since      1.0.0
 *
 * @package    Paylane_Sf
 * @subpackage Paylane_Sf/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Paylane_Sf
 * @subpackage Paylane_Sf/includes
 * @author     Patryk Mirosław <miroslaw.patryk@gmail.com>
 */
class Paylane_Sf {

	protected $loader;
	protected $plugin_name;
	protected $version;
	public function __construct() {
		if ( defined( 'PAYLANE_SF_VERSION' ) ) {
			$this->version = PAYLANE_SF_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'paylane-sf';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->setup_widget();
		register_setting('paylane_sf_settings', 'kwoty');
		register_setting('paylane_sf_settings', 'mid');
		register_setting('paylane_sf_settings', 'salt');
		register_setting('paylane_sf_settings', 'url');
		register_setting('paylane_sf_settings', 'submit');
	}
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-paylane-sf-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-paylane-sf-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-paylane-sf-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-paylane-sf-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-paylane-sf-widget.php';
		$this->loader = new Paylane_Sf_Loader();

	}
	private function setup_widget(){
		$widget = new Paylane_Sf_Widget();
		$this->loader->add_action('widgets_init', $widget, 'register_paylane_sf_widget');
		$this->loader->add_action('wp_enqueue_scripts', $widget, 'register_paylance_sfwidgets_scripts');
		$this->loader->add_action('wp_ajax_paylane_sf_get_hash', $widget, 'paylane_sf_get_hash');
		$this->loader->add_action('wp_ajax_nopriv_paylane_sf_get_hash', $widget, 'paylane_sf_get_hash');

	}
	private function set_locale() {

		$plugin_i18n = new Paylane_Sf_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Paylane_Sf_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Paylane_Sf_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Paylane_Sf_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
