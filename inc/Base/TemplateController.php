<?php
/**
 * Template ctrl.
 *
 * @package easy-resources-page
 * @version 1.0.0
 */

namespace EasyResourcesPage\Base;

/**
 * About class.
 */
class TemplateController {

	/**
	 * Array with list of this plugin's page
	 *
	 * @var array $custom_plugin_templates templates.
	 */
	public $custom_plugin_templates;

		/**
		 * Init $custom_plugin_templates and add filters to intercept the loading of page templates.
		 */
	public function register() {

		// TODO. 'page-templates/resources-page.php' should be a const somewhere? (see  Enqueue).
		$this->custom_plugin_templates = array(
			'page-templates/resources-page.php' => 'Resources Template (Plugin)',
		);

		add_filter( 'theme_page_templates', array( $this, 'add_plugin_template_to_theme' ) );
		add_filter( 'template_include', array( $this, 'load_plugin_template' ) );
	}

	/**
	 * Add page-resources.php to the list of available templates in wp-admin edit page dropdown.
	 *
	 * @param array $theme_templates List of available templates.
	 */
	public function add_plugin_template_to_theme( $theme_templates ) {

		$theme_templates = array_merge( $theme_templates, $this->custom_plugin_templates );

		return $theme_templates;
	}

	/**
	 * Intercept the loading of templates. If 'resources-page.php' is selected, return * it. Otherwise return the default template ($template).
	 *
	 * @param string $template The chosen template.
	 */
	public function load_plugin_template( $template ) {

			global $post;

		if ( ! $post ) {
			return $template;
		}

		// Get name of selected template. Will be 'page-templates/resources-page.php' if ours is selected in wp-admin.
		$template_name = get_post_meta( $post->ID, '_wp_page_template', true );

		// If $template does not match our 'page-templates/resources-page.php' just return $template as is.
		if ( ! isset( $this->custom_plugin_templates[ $template_name ] ) ) {
			return $template;
		}

		// Get full path to page-resources.php.
		$file = plugin_dir_path( dirname( __FILE__, 2 ) ) . $template_name;

		// Return our page-resources.php template if it exists.
		if ( file_exists( $file ) ) {
			return $file;
		}

		// Default: return original template.
		return $template;
	}

	/**
	 * Template helper. Echos eg. 'background:#ffffff' ($key:get_option($option))
	 *
	 * @param String $option Option from settings api.
	 * @param String $key The css attribute to set.
	 */
	public static function get_css( $option, $key ) {
		$attr = '';
		$attr = get_option( $option );
		if ( isset( $attr ) && '' !== $attr ) {
			$attr = $key . ':' . esc_attr( $attr ) . ';';
		}
		if ( $attr ) {
			echo esc_attr( $attr );
		}
		echo '';
	}


}
