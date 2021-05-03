<?php
/**
 * Enqueue styles & scripts.
 *
 * @package marie-plugin-starter
 * @version 1.0.0
 */

namespace MariePluginStarter\Base;

/**
 * Enqueue files.
 */
class Enqueue {

	/**
	 * Called in Init. Add actions to enqueue js & css.
	 */
	public function register() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	/**
	 * Enqueue clientside style & script (on all clientside pages!).
	 */
	public function enqueue() {


			wp_enqueue_style( 'marie-wp-plugin-starter-client-style', plugin_dir_url( dirname( __FILE__, 2 ) ) . 'dist/css/marie-wp-plugin-starter.css', array(), '1.0.0', 'all' );

			wp_enqueue_script( 'marie-wp-plugin-starter-client-script', plugin_dir_url( dirname( __FILE__, 2 ) ) . 'dist/js/marie-wp-plugin-starter.js', null, '1.0.0', true );

	}

}
