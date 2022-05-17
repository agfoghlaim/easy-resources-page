<?php
/**
 * Plugin Name:       Easy Resources Page
 * Description:       Starter code for a wp plugin. Enqueues cs & js on client.
 * Version:           1.0.0
 * Author:            marieoh
 * Author URI:              https://marie.ie
 * License:           GPL v2 or later
 * Text Domain:             easy-resources-page
 *
 * @package easy-resources-page
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; // Exit if accessed directly.
}

if ( true === wp_is_block_theme() ) {
	return;
}

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	include_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

// Include functions to handle page-template svgs.
if ( file_exists( dirname( __FILE__ ) . '/template-functions/easy-resources-page-svg.php' ) ) {
	require_once dirname( __FILE__ ) . '/template-functions/easy-resources-page-svg.php';

}


/**
 * On plugin Activate
 */
function marie_wp_plugin_starter_activate() {
	EasyResourcesPage\Base\Activate::activate();

}
register_activation_hook( __FILE__, 'marie_wp_plugin_starter_activate' );

/**
 * On plugin Deactivate
 */
function marie_wp_plugin_starter_deactivate() {
	EasyResourcesPage\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'marie_wp_plugin_starter_deactivate' );


if ( class_exists( 'EasyResourcesPage\\Init' ) ) {
	EasyResourcesPage\Init::register_services();
}
