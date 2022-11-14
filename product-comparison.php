<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://github.com/shaon-hossain45
 * @since             1.0.0
 * @package           Product_Comparison
 *
 * @wordpress-plugin
 * Plugin Name:       Product Comparison
 * Plugin URI:        https://https://github.com/shaon-hossain45
 * Description:       Product comparison for charging station with wooCommerce development.
 * Version:           1.0.0
 * Author:            Shaon Hossain
 * Author URI:        https://https://github.com/shaon-hossain45
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       product-comparison
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
define( 'PRODUCT_COMPARISON_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-product-comparison-activator.php
 */
function activate_product_comparison() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-comparison-activator.php';
	Product_Comparison_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-product-comparison-deactivator.php
 */
function deactivate_product_comparison() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-comparison-deactivator.php';
	Product_Comparison_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_product_comparison' );
register_deactivation_hook( __FILE__, 'deactivate_product_comparison' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-product-comparison.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_product_comparison() {

	$plugin = new Product_Comparison();
	$plugin->run();

}
run_product_comparison();
