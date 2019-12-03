<?php
/**
 *
 * @link              https://github.com/wpplugins-tech/multisite-faqs
 * @since             1.0.0
 * @package           Multisite_FAQS
 *
 * @wordpress-plugin
 * Plugin Name:       Multisite FAQS
 * Plugin URI:        https://github.com/wpplugins-tech/multisite-faqs
 * Description:       Manage and Consolidate FAQs across a Wordpress Multisite Installation.
 * Version:           1.0
 * Author:            WPplugins.Tech
 * Author URI:        https://wpplugins.tech/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       multisite-faqs
 * Domain Path:       /languages
 * Network:           true
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'MS_FAQS_PLUGIN_BASENAME', plugin_basename(__FILE__) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-multisite-faqs-activator.php
 */
function activate_multisite_faqs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-multisite-faqs-activator.php';
	Multisite_FAQS_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-multisite-faqs-deactivator.php
 */
function deactivate_multisite_faqs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-multisite-faqs-deactivator.php';
	Multisite_FAQS_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_multisite_faqs' );
register_deactivation_hook( __FILE__, 'deactivate_multisite_faqs' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-multisite-faqs.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_multisite_faqs() {

	$plugin = new Multisite_FAQS();
	$plugin->run();

}
run_multisite_faqs();