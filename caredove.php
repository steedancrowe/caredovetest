<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://caredove.com
 * @since             0.1.0
 * @package           Caredove
 *
 * @wordpress-plugin
 * Plugin Name:       Caredove
 * Plugin URI:        https://caredove.com/plugins/caredove
 * Description:       This plugin provides integration with caredove.com for scheduling buttons, services listings and search.Here is a short description of the plugin. 
 * Version:           0.1.6
 * Author:            Caredove
 * Author URI:        https://caredove.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       caredove
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 0.1.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
//change-version
define( 'caredove', '0.1.6' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-caredove-activator.php
 */
function activate_caredove() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-caredove-activator.php';
	Caredove_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-caredove-deactivator.php
 */
function deactivate_caredove() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-caredove-deactivator.php';
	Caredove_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_caredove' );
register_deactivation_hook( __FILE__, 'deactivate_caredove' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-caredove.php';

/**
 * The plugin checker library, it allows integration with GitHub, new releases will automagically be available to users 
 * during WordPress' update check, or when they manually click on 'check for updates' from the plugins page.
 */

require plugin_dir_path( __FILE__ ) . 'plugin-update-checker/plugin-update-checker.php';
$CaredoveUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/Caredove/CD-Integrations-Wordpress/',
	__FILE__,
	'CD-Integrations-Wordpress'
);

//Optional: If you're using a private repository, specify the access token like this:
$CaredoveUpdateChecker->setAuthentication('30606f94f4d990ae3f2f640d29706b441de639dd');

//Optional: Set the branch that contains the stable release.
$CaredoveUpdateChecker->setBranch('master');
// $CaredoveUpdateChecker->getVcsApi()->enableReleaseAssets();

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_caredove() {

	$plugin = new Caredove();
	$plugin->run();

}
run_caredove();
