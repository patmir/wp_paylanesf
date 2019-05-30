<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              patmir.com
 * @since             1.0.0
 * @package           Paylane_Sf
 *
 * @wordpress-plugin
 * Plugin Name:       Paylane SecureForm
 * Plugin URI:        paylane-sf
 * Description:       Tworzy przyciski kwotowe do transakcji paylane
 * Version:           1.0.0
 * Author:            Patryk Mirosław
 * Author URI:        patmir.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       paylane-sf
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('PAYLANE_SF_VERSION', '1.0.0');
define('PAYLANE_SF_PATH', plugin_dir_path(__FILE__));
define('PAYLANE_SF_CLASSES_PATH', PAYLANE_SF_PATH . 'classes/');
define('PAYLANE_SF_LANGUAGES_PATH', basename(PAYLANE_SF_PATH) . '/languages/');
define('PAYLANE_SF_VIEWS_PATH', PAYLANE_SF_PATH . 'views/');
define('PAYLANE_SF_JS_PATH', PAYLANE_SF_PATH . 'views/js/');
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-paylane-sf-activator.php
 */
function activate_paylane_sf()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-paylane-sf-activator.php';
	Paylane_Sf_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-paylane-sf-deactivator.php
 */
function deactivate_paylane_sf()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-paylane-sf-deactivator.php';
	Paylane_Sf_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_paylane_sf');
register_deactivation_hook(__FILE__, 'deactivate_paylane_sf');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-paylane-sf.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_paylane_sf()
{
	$plugin = new Paylane_Sf();
	$plugin->run();
}
run_paylane_sf();
