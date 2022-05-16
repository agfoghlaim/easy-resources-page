<?php
/**
 * Enqueue styles & scripts.
 *
 * @package easy-resources-page
 * @version 1.0.0
 */

namespace EasyResourcesPage\Base;

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
		 * Enqueue js & css if the plugin template is currently loaded.
		 */
	public function enqueue() {
		
		global $post;

		if ( ! $post ) {
			return;
		}

		// Get name of currently loaded template.
		$template_name = get_post_meta( $post->ID, '_wp_page_template', true );

		// Enqueue style & script only if plugin page template currently loaded.
		if ( 'page-templates/resources-page.php' === $template_name ) {

			wp_enqueue_style( 'easy-resources-page-style', plugin_dir_url( dirname( __FILE__, 2 ) ) . 'dist/css/easy-resources-page.css', array(), '1.0.0', 'all' );
	
			wp_enqueue_script( 'easy-resources-page-main', plugin_dir_url( dirname( __FILE__, 2 ) ) . 'dist/js/easy-resources-page.js', null, '1.0.0', true );
		}
	}

}
