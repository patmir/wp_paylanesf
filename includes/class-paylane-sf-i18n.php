<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       patmir.com
 * @since      1.0.0
 *
 * @package    Paylane_Sf
 * @subpackage Paylane_Sf/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Paylane_Sf
 * @subpackage Paylane_Sf/includes
 * @author     Patryk Mirosław <miroslaw.patryk@gmail.com>
 */
class Paylane_Sf_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'paylane-sf',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
