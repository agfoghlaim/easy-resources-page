<?php
/**
 * Template ctrl.
 *
 * @package easy-resources-page
 * @version 1.0.0
 */

namespace EasyResourcesPage\API;

/**
 * About class.
 */
class Settings {

		/**
		 * Add actions
		 */
	public function register() {

		add_action( 'admin_menu', array( $this, 'handle_add_menu_page' ) );
	}



	/**
	 * Register a custom menu page.
	 */
	public function handle_add_menu_page() {
		add_menu_page(
			__( 'Easy Resources Page', 'easy-resources-page' ),
			__( 'Easy R\' Page', 'easy-resources-page' ),
			'manage_options',
			'erp_plugin',
			array( $this, 'get_admin_template' ),
			'',
			110
		);
	}

	/**
	 * TODO
	 */
	public function get_admin_template() {
		require_once dirname( __FILE__, 3 ) . '/admin-templates/admin.php';
	}
}
