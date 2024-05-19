<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://khomusi.com
 * @since             1.0.0
 * @package           Focas
 *
 * @wordpress-plugin
 * Plugin Name:       FOCAS
 * Plugin URI:        https://Msqrsols.com
 * Description:       This is a Inventory Management and Pos .
 * Version:           1.0.0
 * Author:            Miqdad k.
 * Author URI:        https://khomusi.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       focas
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
define( 'FOCAS_VERSION', '1.0.0' );
define( 'FOCAS_Path', plugin_dir_path( __FILE__ ));
define( 'FOCAS_Url', 'http://localhost/wordpress');


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-focas-activator.php
 */
function activate_focas() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-focas-activator.php';
	Focas_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-focas-deactivator.php
 */
function deactivate_focas() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-focas-deactivator.php';
	Focas_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_focas' );
register_deactivation_hook( __FILE__, 'deactivate_focas' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-focas.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_focas() {

	$plugin = new Focas();
	$plugin->run();

}
run_focas();
