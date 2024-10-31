<?php

/**
 * @wordpress-plugin
 * Requires Plugins:  woocommerce
 * Plugin Name:       PrintKK for woocommerce
 * Description:       Connect your PrintKK account with WooCommerce.
 * Version:           1.0.3
 * Author:            PrintKK
 * Author URI:        https://www.printkk.com
 * License:           GPLv2
 * Text Domain:       printkk-for-woocommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * plugin dir
 */
if (!defined('PRINTKK_BASE_DIR')) {
    define('PRINTKK_BASE_DIR', plugin_dir_path(__FILE__));
}
/**
 * PrintKK HOST
 */
if (!defined('PRINTKK_HOST')) {
    define('PRINTKK_HOST', "https://dashboard.printkk.com/");
}
/**
 * PrintKK API HOST
 */
if (!defined('PRINTKK_API_HOST')) {
    define('PRINTKK_API_HOST', "https://dashboard.printkk.com/api");
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PRINTKK_FOR_WOOCOMMERCE_VERSION', '1.0.3' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-printkk-for-woocommerce.php';

/**
 * dashboard
 */

require_once plugin_dir_path( __FILE__ ) . 'includes/class-printkk-for-woocommerce-dashboard.php';

/**
 * Get printKK admin image url.
 *
 * @return string
 */
function printkk_admin_image_url(): string
{
    return trailingslashit(plugin_dir_url(__FILE__)) . 'admin/images/';
}
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function printkk_admin_start() {

	$plugin = new PrintKK_For_Woocommerce();
	$plugin->run();

}
printkk_admin_start();
