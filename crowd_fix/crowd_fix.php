<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://devdigital.pro
 * @since             1.0.0
 * @package           Crowd_fix
 *
 * @wordpress-plugin
 * Plugin Name:       DevCrowd
 * Plugin URI:        http://devdigital.pro
 * Description:       Плагин содержит исправления для темы Crowdfunding
 * Version:           1.0.0
 * Author:            DEVDIGITAL
 * Author URI:        http://devdigital.pro
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       crowd_fix
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-crowd_fix-activator.php
 */
function activate_crowd_fix() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-crowd_fix-activator.php';
	Crowd_fix_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-crowd_fix-deactivator.php
 */
function deactivate_crowd_fix() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-crowd_fix-deactivator.php';
	Crowd_fix_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_crowd_fix' );
register_deactivation_hook( __FILE__, 'deactivate_crowd_fix' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-crowd_fix.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function run_crowd_fix() {
	
	$plugin = new Crowd_fix();
	$plugin->run();

}
run_crowd_fix();
