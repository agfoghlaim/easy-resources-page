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
	 * Deal with wp settings api. This does 3 things.
	 *
	 * 1. Registers settings (for the fields).
	 * 2. Adds sections ( Buttons, Dropdowns, Panels & Links).
	 * 3. Adds fields that correspond to the registered settings, assigns them to sections.
	 */
	public function deal_with_wp_settings_api_god_help_us() {

		// 1. Register.

		// Buttons.
		register_setting(
			'erp_plugin_settings',
			'erp-button-background',
			'sanitize_hex_color'
		);
		register_setting(
			'erp_plugin_settings',
			'erp-button-color',
			'sanitize_hex_color'
		);

		// Dropdowns.
		register_setting(
			'erp_plugin_settings',
			'erp-dropdown-background',
			'sanitize_hex_color'
		);

		// Panels.
		register_setting(
			'erp_plugin_settings',
			'erp-panel-background',
			'sanitize_hex_color'
		);
		register_setting(
			'erp_plugin_settings',
			'erp-panel-color',
			'sanitize_hex_color'
		);

		// Links.
		register_setting(
			'erp_plugin_settings',
			'erp-link-css-class',
			'sanitize_text_field'
		);

		// 2. Sections.

		// Buttons.
		add_settings_section(
			'buttons_section', // ***section id.
			'Buttons Section', // section title.
			array( $this, 'buttons_section_cb' ),
			'erp_plugin' // page.
		);

		// Dropdowns.
		add_settings_section(
			'dropdowns_section', // ***section id.
			'Dropdowns Section', // section title.
			array( $this, 'dropdowns_section_cb' ),
			'erp_plugin' // page.
		);

		// Panels.
		add_settings_section(
			'panels_section', // ***section id.
			'Panels Section', // section title.
			array( $this, 'panels_section_cb' ),
			'erp_plugin' // page.
		);

		// Links.
		add_settings_section(
			'links_section', // ***section id.
			'Links Section', // section title.
			array( $this, 'links_section_cb' ),
			'erp_plugin' // page.
		);

		// 3. Fields.

		// Buttons.
		add_settings_field(
			'erp-button-background', // id.
			'Button Background', // title.
			array( $this, 'button_background_field_cb' ),
			'erp_plugin', // page.
			'buttons_section' // ***section id.
		);
		add_settings_field(
			'erp-button-color', // id.
			'Button Color', // title.
			array( $this, 'button_color_field_cb' ),
			'erp_plugin', // page.
			'buttons_section' // ***section id.
		);

		// Dropdowns.
		add_settings_field(
			'erp-dropdown-background', // id.
			'Dropdown Background', // title.
			array( $this, 'dropdown_background_field_cb' ),
			'erp_plugin', // page.
			'dropdowns_section' // ***section id.
		);

			// Panels.
			add_settings_field(
				'erp-panel-background', // id.
				'Panel Background', // title.
				array( $this, 'panel_background_field_cb' ),
				'erp_plugin', // page.
				'panels_section' // ***section id.
			);
			add_settings_field(
				'erp-panel-color', // id.
				'Panel Color', // title.
				array( $this, 'panel_color_field_cb' ),
				'erp_plugin', // page.
				'panels_section' // ***section id.
			);

			// Links.
			add_settings_field(
				'erp-link-css-class', // id.
				'Link Class', // title.
				array( $this, 'link_css_class_field_cb' ),
				'erp_plugin', // page.
				'links_section' // ***section id.
			);
	}

	/**
	 * Buttons section cb
	 */
	public function buttons_section_cb() {
		echo 'Before buttons section';
	}
	/**
	 * Dropdowns section cb
	 */
	public function dropdowns_section_cb() {
		echo 'Before dropdownss section';
	}
	/**
	 * Panels section cb
	 */
	public function panels_section_cb() {
		echo 'Before panels section';
	}
	/**
	 * Links section cb
	 */
	public function links_section_cb() {
		echo 'If you prefer to style the \'Preview\' and \'Download\' links as buttons, insert your theme\'s button classes here.';
	}

	/**
	 * Buttons background field cb
	 */
	public function button_background_field_cb() {
		// TODO check this works first time if not defined.
		$background_color = get_option( 'erp-button-background' );
		echo '<input class="erp-color-field" type="text" id="erp-button-background" name="erp-button-background" value="' . esc_attr( $background_color ) . '" />';
	}

	/**
	 * Buttons color field cb
	 */
	public function button_color_field_cb() {
		// TODO check this works first time if not defined.
		$color = get_option( 'erp-button-color' );
		echo '<input class="erp-color-field" type="text" id="erp-button-color" name="erp-button-color" value="' . esc_attr( $color ) . '" />';
	}

	/**
	 * Dropdowns background field cb
	 */
	public function dropdown_background_field_cb() {
		// TODO check this works first time if not defined.
		$background_color = get_option( 'erp-dropdown-background' );
		echo '<input class="erp-color-field" type="text" id="erp-dropdown-background" name="erp-dropdown-background" value="' . esc_attr( $background_color ) . '" />';
	}

	/**
	 * Panels background field cb
	 */
	public function panel_background_field_cb() {
		// TODO check this works first time if not defined.
		$background_color = get_option( 'erp-panel-background' );
		echo '<input class="erp-color-field" type="text" id="erp-panel-background" name="erp-panel-background" value="' . esc_attr( $background_color ) . '" />';
	}

	/**
	 * Panels color field cb
	 */
	public function panel_color_field_cb() {
		// TODO check this works first time if not defined.
		$color = get_option( 'erp-panel-color' );
		echo '<input class="erp-color-field" type="text" id="erp-panel-color" name="erp-panel-color" value="' . esc_attr( $color ) . '" />';
	}
	/**
	 * Linkss class field cb
	 */
	public function link_css_class_field_cb() {
		// TODO check this works first time if not defined.
		$classes = get_option( 'erp-link-css-class' );
		echo '<input type="text" id="erp-link-css-class" name="erp-link-css-class" value="' . esc_attr( $classes ) . '" placeholder="eg. btn primary-btn" />';
	}

}
