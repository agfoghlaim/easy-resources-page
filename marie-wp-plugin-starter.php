<?php
/**
 * Plugin Name:       Marie Plugin Starter
 * Description:       Starter code for a wp plugin. Enqueues cs & js on client.
 * Version:           1.0.0
 * Author:            MOH
 * License:           GPL v2 or later
 *
 * @package marie-wp-plugin-starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; // Exit if accessed directly.
}

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	include_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * On plugin Activate
 */
function marie_wp_plugin_starter_activate() {
	MariePluginStarter\Base\Activate::activate();

}
register_activation_hook( __FILE__, 'marie_wp_plugin_starter_activate' );

/**
 * On plugin Deactivate
 */
function marie_wp_plugin_starter_deactivate() {
	MariePluginStarter\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'marie_wp_plugin_starter_deactivate' );


if ( class_exists( 'MariePluginStarter\\Init' ) ) {
	MariePluginStarter\Init::register_services();
}
