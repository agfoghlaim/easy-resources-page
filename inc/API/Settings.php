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
		add_filter( 'plugin_action_links_easy-resources-page/easy-resources-page.php', array( $this, 'add_settings_link' ) );
		add_action( 'admin_init', array( $this, 'deal_with_wp_settings_api_god_help_us' ) );
	}

	/**
	 * Register erp menu page.
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
	 * Require settings page markup.
	 */
	public function get_admin_template() {
		require_once dirname( __FILE__, 3 ) . '/admin-templates/admin.php';
	}

	/**
	 * Intercept $links (deactivate, delete etc) on plugins list page and add link to erp settings.
	 *
	 * @param Array $links List of links.
	 */
	public function add_settings_link( $links ) {
		$erp_setting_page_link = '<a href="options-general.php?page=erp_plugin">Settings</a>';
		array_push( $links, $erp_setting_page_link );
		return $links;

	}

	/**
	 * 1. Register settings (fields).
	 * 2. Add sections.
	 * 3. Add fields that correspond to the registered settings, assigned to sections.
	 */
	public function deal_with_wp_settings_api_god_help_us() {

		// 1. Register Settings.

		// Button - background
		register_setting(
			'erp_plugin_settings',
			'erp-button-background',
			'sanitize_hex_color'
		);
		add_settings_section(
			'buttons_section', // section id.
			'Buttons Section', // section title.
			array( $this, 'buttons_section_cb' ),
			'erp_plugin' // page.
		);

		add_settings_field(
			'erp-button-background', // id;
			'Button Background', // title.
			array( $this, 'button_background_field_cb' ),
			'erp_plugin', // page
			'buttons_section' // section id
		);

	}

	/**
	 * Buttons section cb
	 */
	public function buttons_section_cb() {
		echo 'Before buttons section';
	}
	/**
	 * Buttons background field cb
	 */
	public function button_background_field_cb() {

		// TODO check this works first time if not defined.
		$background_color = get_option( 'erp-button-background' );
		echo '<input type="text" id="erp-button-background" name="erp-button-background" value="' . esc_attr( $background_color ) . '" />';
	}

}
