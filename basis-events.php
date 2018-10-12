<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://indevver.com
 * @since             1.0.0
 * @package           Basis_Events
 *
 * @wordpress-plugin
 * Plugin Name:       Basis Events
 * Plugin URI:        https://indevver.com
 * Description:       Adds customizable events to the site
 * Version:           1.0.0
 * Author:            Jeremy Ross
 * Author URI:        https://indevver.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       basis-events
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-basis-events-activator.php
 */
function activate_basis_events() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-basis-events-activator.php';
	Basis_Events_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-basis-events-deactivator.php
 */
function deactivate_basis_events() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-basis-events-deactivator.php';
	Basis_Events_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_basis_events' );
register_deactivation_hook( __FILE__, 'deactivate_basis_events' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-basis-events.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_basis_events() {

	$plugin = new Basis_Events();
	$plugin->run();

}
run_basis_events();
